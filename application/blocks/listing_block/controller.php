<?php namespace Application\Block\ListingBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use Application\Concrete\Helpers\SelectOptionsHelper;
use Application\Concrete\Models\Common\CommonList;
use Application\Concrete\View\View;
use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Entity\Attribute\Key\PageKey;
use Concrete\Core\Http\Response;
use Concrete\Core\Page\Type\Type;
use Concrete\Core\Validation\CSRF\Token;
use Core;
use Database;
use Page;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends BlockController
{
    public $btFieldsRequired = ['filters' => ['filterTitle', 'filterAttribute']];
    protected $btExportTables = ['btListingBlock', 'btListingBlockFiltersEntries', 'btListingBlockPageTypes_MultipleSelectEntries', 'btListingBlockSortOptions_MultipleSelectEntries'];
    protected $btTable = 'btListingBlock';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $pkg = false;
    protected $th;

    CONST ITEMS_PER_PAGE = 10;
    CONST PARENT_ELEMENT = "blocks/listing_block/";
    CONST ITEM_ELEMENT = self::PARENT_ELEMENT . "page_item";
    CONST ACTION_HANDLE = "listing_block";

    public function __construct($obj = null)
    {
        parent::__construct($obj);
    }

    public function getBlockTypeName()
    {
        return t("Listing Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $content[] = $this->searchPlaceHolderText;
        $content[] = $this->loadMoreText;
        $db = Database::connection();
        $filters_items = $db->fetchAll('SELECT * FROM btListingBlockFiltersEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($filters_items as $filters_item_k => $filters_item_v) {
            if (isset($filters_item_v["filterTitle"]) && trim($filters_item_v["filterTitle"]) != "") {
                $content[] = $filters_item_v["filterTitle"];
            }
        }
        $content[] = $this->itemCount;
        $pageTypes_options = [
            'all' => "All",
            'type_one' => "Type One",
            'type_two' => "Type Two"
        ];
        foreach($this->getMultipleSelectSelections('btListingBlockPageTypes_MultipleSelectEntries', $this->bID, $pageTypes_options) as $pageTypes_key => $pageTypes_value){
            $content[] = $pageTypes_value;
        }
        $sortOptions_options = [
            'display_asc' => "Sitemap order",
            'display_desc' => "Reverse sitemap order",
            'chrono_desc' => "Most recent first",
            'chrono_asc' => "Earliest first",
            'alpha_asc' => "Alphabetical order",
            'alpha_desc' => "Reverse alphabetical order",
            'modified_desc' => "Most recently modified first",
            'random' => "Random"
        ];
        foreach($this->getMultipleSelectSelections('btListingBlockSortOptions_MultipleSelectEntries', $this->bID, $sortOptions_options) as $sortOptions_key => $sortOptions_value){
            $content[] = $sortOptions_value;
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $button_URL = null;
		$button_Object = null;
		$button_Title = trim($this->button_Title);
		if (trim($this->button) != '') {
			switch ($this->button) {
				case 'page':
					if ($this->button_Page > 0 && ($button_Page_c = Page::getByID($this->button_Page)) && !$button_Page_c->error && !$button_Page_c->isInTrash()) {
						$button_Object = $button_Page_c;
						$button_URL = $button_Page_c->getCollectionLink();
						if ($button_Title == '') {
							$button_Title = $button_Page_c->getCollectionName();
						}
					}
					break;
				case 'url':
					$button_URL = $this->button_URL;
					if ($button_Title == '') {
						$button_Title = $button_URL;
					}
					break;
			}
		}
		$this->set("button_URL", $button_URL);
		$this->set("button_Object", $button_Object);
		$this->set("button_Title", $button_Title);
        $this->set('filters', $this->getCustomFilters());
        $paginationStyle_options = [
            '' => "-- " . t("None") . " --",
            'on_click' => "On Click",
            'on_scroll' => "On Scroll",
            'test' => "Hello"
        ];
        $this->set("paginationStyle_options", $paginationStyle_options);
        $pageTypes_options = [
            'all' => "All",
            'type_one' => "Type One",
            'type_two' => "Type Two"
        ];
        $this->set("pageTypes_options", $pageTypes_options);
        $this->set("pageTypes", $this->getMultipleSelectSelections('btListingBlockPageTypes_MultipleSelectEntries', $this->bID, $pageTypes_options));

        $selectedOptions = $this->getMultipleSelectSelections('btListingBlockSortOptions_MultipleSelectEntries', $this->bID, $this->getSortOptions());
        $sortOptions = array_filter($this->getSortOptions(), function ($option) use($selectedOptions) {
            return isset($selectedOptions[$option]);
        }, ARRAY_FILTER_USE_KEY);
        $this->set("sortOptions", $sortOptions);

        $pageResponse = $this->getPages();

        $this->set("pages", $pageResponse->getPages());
        $this->set("loadMore", $pageResponse->getLoadMore());
        $this->set("token", Core::make('helper/validation/token')->output(self::ACTION_HANDLE, true));
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btListingBlockFiltersEntries', ['bID' => $this->bID]);
        $db->delete('btListingBlockPageTypes_MultipleSelectEntries', ['bvID' => $this->bID]);
        $db->delete('btListingBlockSortOptions_MultipleSelectEntries', ['bvID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $filters_items = $db->fetchAll('SELECT * FROM btListingBlockFiltersEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($filters_items as $filters_item) {
            unset($filters_item['id']);
            $filters_item['bID'] = $newBID;
            $db->insert('btListingBlockFiltersEntries', $filters_item);
        }
        $pageTypes_entries = $db->fetchAll('SELECT * FROM btListingBlockPageTypes_MultipleSelectEntries WHERE bvID = ? ORDER BY sortOrder ASC', [$this->bID]);
        foreach ($pageTypes_entries as $pageTypes_entry) {
            unset($pageTypes_entry['msID']);
            $db->insert('btListingBlockPageTypes_MultipleSelectEntries', $pageTypes_entry);
        }
        $sortOptions_entries = $db->fetchAll('SELECT * FROM btListingBlockSortOptions_MultipleSelectEntries WHERE bvID = ? ORDER BY sortOrder ASC', [$this->bID]);
        foreach ($sortOptions_entries as $sortOptions_entry) {
            unset($sortOptions_entry['msID']);
            $db->insert('btListingBlockSortOptions_MultipleSelectEntries', $sortOptions_entry);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $filters = $this->get('filters');
        $this->set('filters_items', []);
        
        
        $this->set('filters', $filters);
        $pageTypes = [];
		$pageTypes_defaults = array_unique([]);
		$pageTypes_options = $this->get("pageTypes_options");
		if (!empty($pageTypes_defaults)) {
			foreach ($pageTypes_defaults as $pageTypes_default) {
				if (isset($pageTypes_options[$pageTypes_default])) {
					$pageTypes[$pageTypes_default] = $pageTypes_options[$pageTypes_default];
				}
			}
		}
		$this->set("pageTypes", $pageTypes);
        $sortOptions = [];
		$sortOptions_defaults = array_unique([]);
		$sortOptions_options = $this->get("sortOptions_options");
		if (!empty($sortOptions_defaults)) {
			foreach ($sortOptions_defaults as $sortOptions_default) {
				if (isset($sortOptions_options[$sortOptions_default])) {
					$sortOptions[$sortOptions_default] = $sortOptions_options[$sortOptions_default];
				}
			}
		}
		$this->set("sortOptions", $sortOptions);
		$this->set("isAdd", true);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $filters = $this->get('filters');
        $filters_items = $db->fetchAll('SELECT * FROM btListingBlockFiltersEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('filters', $filters);
        $this->set('filters_items', $filters_items);
        $this->set("pageTypes", $this->getMultipleSelectSelections('btListingBlockPageTypes_MultipleSelectEntries', $this->bID, $this->get("pageTypes_options")));
        $this->set("sortOptions", $this->getMultipleSelectSelections('btListingBlockSortOptions_MultipleSelectEntries', $this->bID, $this->get("sortOptions_options")));
    }

    protected function addEdit()
    {
        $this->set("button_Options", $this->getSmartLinkTypeOptions([
  'page',
  'url',
], true));
        $filters = [];
        $filters['filterAttribute_options'] = $this->getAttributeOptions();
        $this->set('filters', $filters);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $this->set("paginationStyle_options", [
                'on_click' => t("On Click"),
                'on_scroll' => t("On Scroll"),
            ]
        );
        $this->set("pageTypes_options", $this->getPageTypeOptions());
        $this->set("sortOptions_options", $this->getSortOptions());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/listing_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/listing_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/listing_block/js_form/handlebars-helpers.js', [], $this->pkg);
        $al->register('css', 'auto-css-' . $this->btHandle, 'blocks/' . $this->btHandle . '/auto.css', [], $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->requireAsset('css', 'select2');
        $this->requireAsset('javascript', 'select2');
        $this->requireAsset('css', 'auto-css-' . $this->btHandle);
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        if (isset($args["button"]) && trim($args["button"]) != '') {
			switch ($args["button"]) {
				case 'page':
					$args["button_File"] = '0';
					$args["button_URL"] = '';
					$args["button_Relative_URL"] = '';
					$args["button_Image"] = '0';
					break;
				case 'url':
					$args["button_Page"] = '0';
					$args["button_Relative_URL"] = '';
					$args["button_File"] = '0';
					$args["button_Image"] = '0';
					break;
				default:
					$args["button_Title"] = '';
					$args["button_Page"] = '0';
					$args["button_File"] = '0';
					$args["button_URL"] = '';
					$args["button_Relative_URL"] = '';
					$args["button_Image"] = '0';
					break;	
			}
		}
		else {
			$args["button_Title"] = '';
			$args["button_Page"] = '0';
			$args["button_File"] = '0';
			$args["button_URL"] = '';
			$args["button_Relative_URL"] = '';
			$args["button_Image"] = '0';
		}
        $rows = $db->fetchAll('SELECT * FROM btListingBlockFiltersEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $filters_items = isset($args['filters']) && is_array($args['filters']) ? $args['filters'] : [];
        $queries = [];
        if (!empty($filters_items)) {
            $i = 0;
            foreach ($filters_items as $filters_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($filters_item['filterTitle']) && trim($filters_item['filterTitle']) != '') {
                    $data['filterTitle'] = trim($filters_item['filterTitle']);
                } else {
                    $data['filterTitle'] = null;
                }
                if (isset($filters_item['filterAttribute']) && trim($filters_item['filterAttribute']) != '') {
                    $data['filterAttribute'] = trim($filters_item['filterAttribute']);
                } else {
                    $data['filterAttribute'] = null;
                }
                if (isset($filters_item['allowMultiple']) && trim($filters_item['allowMultiple']) != '' && in_array($filters_item['allowMultiple'], [0, 1])) {
                    $data['allowMultiple'] = $filters_item['allowMultiple'];
                } else {
                    $data['allowMultiple'] = null;
                }
                if (isset($rows[$i])) {
                    $queries['update'][$rows[$i]['id']] = $data;
                    unset($rows[$i]);
                } else {
                    $data['bID'] = $this->bID;
                    $queries['insert'][] = $data;
                }
                $i++;
            }
        }
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $queries['delete'][] = $row['id'];
            }
        }
        if (!empty($queries)) {
            foreach ($queries as $type => $values) {
                if (!empty($values)) {
                    switch ($type) {
                        case 'update':
                            foreach ($values as $id => $data) {
                                $db->update('btListingBlockFiltersEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btListingBlockFiltersEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btListingBlockFiltersEntries', ['id' => $value]);
                            }
                            break;
                    }
                }
            }
        }
        if (!isset($args["enableSearch"]) || trim($args["enableSearch"]) == "" || !in_array($args["enableSearch"], [0, 1])) {
            $args["enableSearch"] = '';
        }
        if (!isset($args["enableSort"]) || trim($args["enableSort"]) == "" || !in_array($args["enableSort"], [0, 1])) {
            $args["enableSort"] = '';
        }
        if (!isset($args["enablePagination"]) || trim($args["enablePagination"]) == "" || !in_array($args["enablePagination"], [0, 1])) {
            $args["enablePagination"] = '';
        }
        $pageTypes_table = 'btListingBlockPageTypes_MultipleSelectEntries';
		$pageTypes_entries = $this->getMultipleSelectSelections($pageTypes_table, $this->bID, [], true);
		if (isset($args['pageTypes']) && is_array($args['pageTypes'])) {
			$pageTypes_sortOrder = 1;
			foreach ($args['pageTypes'] as $pageTypes_value) {
				$pageTypes_data = [
					'value'     => $pageTypes_value,
					'sortOrder' => $pageTypes_sortOrder,
					'bvID'      => $this->bID,
				];
				if (!empty($pageTypes_entries)) {
					$pageTypes_entryID = key($pageTypes_entries);
					$db->update($pageTypes_table, $pageTypes_data, ['msID' => $pageTypes_entryID]);
					unset($pageTypes_entries[$pageTypes_entryID]);
				} else {
					$db->insert($pageTypes_table, $pageTypes_data);
				}
				$pageTypes_sortOrder++;
			}
		}
		if (!empty($pageTypes_entries)) {
			foreach (array_keys($pageTypes_entries) as $pageTypes_entry) {
				$db->delete($pageTypes_table, ['msID' => $pageTypes_entry]);
			}
		}
        $sortOptions_table = 'btListingBlockSortOptions_MultipleSelectEntries';
		$sortOptions_entries = $this->getMultipleSelectSelections($sortOptions_table, $this->bID, [], true);
		if (isset($args['sortOptions']) && is_array($args['sortOptions'])) {
			$sortOptions_sortOrder = 1;
			foreach ($args['sortOptions'] as $sortOptions_value) {
				$sortOptions_data = [
					'value'     => $sortOptions_value,
					'sortOrder' => $sortOptions_sortOrder,
					'bvID'      => $this->bID,
				];
				if (!empty($sortOptions_entries)) {
					$sortOptions_entryID = key($sortOptions_entries);
					$db->update($sortOptions_table, $sortOptions_data, ['msID' => $sortOptions_entryID]);
					unset($sortOptions_entries[$sortOptions_entryID]);
				} else {
					$db->insert($sortOptions_table, $sortOptions_data);
				}
				$sortOptions_sortOrder++;
			}
		}
		if (!empty($sortOptions_entries)) {
			foreach (array_keys($sortOptions_entries) as $sortOptions_entry) {
				$db->delete($sortOptions_table, ['msID' => $sortOptions_entry]);
			}
		}

		if($args["isAdd"]) {
		    $args["blockIdentifier"] = Core::make('helper/validation/identifier')->getString(6);
        }

        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("searchPlaceHolderText", $this->btFieldsRequired) && (trim($args["searchPlaceHolderText"]) == "")) {
            $e->add(t("The %s field is required.", t("Search Place Holder Text")));
        }
        if (in_array("loadMoreText", $this->btFieldsRequired) && (trim($args["loadMoreText"]) == "")) {
            $e->add(t("The %s field is required.", t("Load More Text")));
        }
        if ((in_array("button", $this->btFieldsRequired) && (!isset($args["button"]) || trim($args["button"]) == "")) || (isset($args["button"]) && trim($args["button"]) != "" && !array_key_exists($args["button"], $this->getSmartLinkTypeOptions(['page', 'url'])))) {
			$e->add(t("The %s field has an invalid value.", t("Button")));
		} elseif (array_key_exists($args["button"], $this->getSmartLinkTypeOptions(['page', 'url']))) {
			switch ($args["button"]) {
				case 'page':
					if (!isset($args["button_Page"]) || trim($args["button_Page"]) == "" || $args["button_Page"] == "0" || (($page = Page::getByID($args["button_Page"])) && $page->error !== false)) {
						$e->add(t("The %s field for '%s' is required.", t("Page"), t("Button")));
					}
					break;
				case 'url':
					if (!isset($args["button_URL"]) || trim($args["button_URL"]) == "" || !filter_var($args["button_URL"], FILTER_VALIDATE_URL)) {
						$e->add(t("The %s field for '%s' does not have a valid URL.", t("URL"), t("Button")));
					}
					break;	
			}
		}
        $filtersEntriesMin = 0;
        $filtersEntriesMax = 0;
        $filtersEntriesErrors = 0;
        $filters = [];
        if (isset($args['filters']) && is_array($args['filters']) && !empty($args['filters'])) {
            if ($filtersEntriesMin >= 1 && count($args['filters']) < $filtersEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Filters"), $filtersEntriesMin, count($args['filters'])));
                $filtersEntriesErrors++;
            }
            if ($filtersEntriesMax >= 1 && count($args['filters']) > $filtersEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Filters"), $filtersEntriesMax, count($args['filters'])));
                $filtersEntriesErrors++;
            }
            if ($filtersEntriesErrors == 0) {
                foreach ($args['filters'] as $filters_k => $filters_v) {
                    if (is_array($filters_v)) {
                        if (in_array("filterTitle", $this->btFieldsRequired['filters']) && (!isset($filters_v['filterTitle']) || trim($filters_v['filterTitle']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Filter Title"), t("Filters"), $filters_k));
                        }
                        if ((in_array("filterAttribute", $this->btFieldsRequired['filters']) && (!isset($filters_v['filterAttribute']) || trim($filters_v['filterAttribute']) == ""))) {
                            $e->add(t("The %s field has an invalid value (%s, row #%s).", t("Filter Attribute"), t("Filters"), $filters_k));
                        }
                        if (in_array("allowMultiple", $this->btFieldsRequired['filters']) && (!isset($filters_v['allowMultiple']) || trim($filters_v['allowMultiple']) == "" || !in_array($filters_v['allowMultiple'], [0, 1]))) {
                            $e->add(t("The %s field is required.", t("Allow Multiple"), t("Filters"), $filters_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Filters'), $filters_k));
                    }
                }
            }
        } else {
            if ($filtersEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Filters"), $filtersEntriesMin));
            }
        }
        if (in_array("enableSearch", $this->btFieldsRequired) && (trim($args["enableSearch"]) == "" || !in_array($args["enableSearch"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Enable Search")));
        }
        if (in_array("enableSort", $this->btFieldsRequired) && (trim($args["enableSort"]) == "" || !in_array($args["enableSort"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Enable Sort")));
        }
        if (in_array("enablePagination", $this->btFieldsRequired) && (trim($args["enablePagination"]) == "" || !in_array($args["enablePagination"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Enable Pagination")));
        }
        if ((in_array("paginationStyle", $this->btFieldsRequired) && (!isset($args["paginationStyle"]) || trim($args["paginationStyle"]) == ""))) {
            $e->add(t("The %s field has an invalid value.", t("Pagination Style")));
        }
        if (in_array("itemCount", $this->btFieldsRequired) && (trim($args["itemCount"]) == "")) {
            $e->add(t("The %s field is required.", t("Item Count")));
        }
        return $e;
    }

    public function composer()
    {
        $al = AssetList::getInstance();
        $al->register('javascript', 'auto-js-' . $this->btHandle, 'blocks/' . $this->btHandle . '/auto.js', [], $this->pkg);
        $this->requireAsset('javascript', 'auto-js-' . $this->btHandle);
        $this->edit();
    }

    protected function getSmartLinkTypeOptions($include = [], $checkNone = false)
	{
		$options = [
			''             => sprintf("-- %s--", t("None")),
			'page'         => t("Page"),
			'url'          => t("External URL"),
			'relative_url' => t("Relative URL"),
			'file'         => t("File"),
			'image'        => t("Image")
		];
		if ($checkNone) {
            $include = array_merge([''], $include);
        }
		$return = [];
		foreach($include as $v){
		    if(isset($options[$v])){
		        $return[$v] = $options[$v];
		    }
		}
		return $return;
	}

    protected function getMultipleSelectSelections($table, $bvID, $options = [], $save = false)
	{
		$return = [];

		if (trim($bvID) != '' && $bvID > 0 && ($items = Database::connection()->fetchAll('SELECT * FROM ' . $table . ' WHERE bvID = ? ORDER BY sortOrder', [$bvID]))) {
			foreach ($items as $item) {
				if ($save) {
					$return[$item['msID']] = $item['value'];
				} elseif (isset($options[$item['value']])) {
					$return[$item['value']] = $options[$item['value']];
				}
			}
		}

		return $return;
	}

    private function getPageTypeOptions(){
        $options = [];

        $pageTypes = Type::getList();

        if(is_array($pageTypes)){
            /** @var Type  $pt */
            foreach ($pageTypes as $pt) {
                $options[$pt->getPageTypeID()] = $pt->getPageTypeDisplayName();
            }
        }

        return $options;
    }

    private function getAttributeOptions(){
        $options = [];

        $entity = \Concrete\Core\Attribute\Key\Category::getByHandle('collection');
        $category = $entity->getAttributeKeyCategory();
        $attributes = $category->getList();

        /** @var PageKey $attribute */
        foreach ($attributes as $attribute){
            if($attribute->getAttributeTypeHandle() == "select"){
                $options[$attribute->getAttributeKeyHandle()] = $attribute->getAttributeKeyDisplayName();
            }
        }

        return $options;
    }

    private function getSortOptions() {
        return  [
            'display_asc' => t("Sitemap order"),
            'display_desc' => t("Reverse sitemap order"),
            'chrono_desc' => t("Most recent first"),
            'chrono_asc' => t("Earliest first"),
            'alpha_asc' => t("Alphabetical order"),
            'alpha_desc' => t("Reverse alphabetical order"),
            'modified_desc' => t("Most recently modified first"),
            'random' => t("Random")
        ];
    }

    private function getCustomFilters($options = true){
        $filters = [];
        $db = Database::connection();
        $rows = $db->fetchAll('SELECT * FROM btListingBlockFiltersEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rows as $row) {
            $filters[] = [
                "key" => $row["filterAttribute"],
                "label" => $row["filterTitle"],
                "allowMultiple" => $row["allowMultiple"],
                "options" => $options ? SelectOptionsHelper::getOptions($row["filterAttribute"], ["" => "All"]) : '',
            ];
        }
        return $filters;
    }

    public function action_listing_block($parameters = null) {
        if(!Core::make('helper/validation/token')->validate(self::ACTION_HANDLE)) return new JsonResponse([
            "title" => t("Error"),
            "message" => t("Please refresh the page and try again!"),
        ], Response::HTTP_BAD_REQUEST);

        $pageResponse = $this->getPages();

        $data = [
            "data" => View::elementRender(self::ITEM_ELEMENT, ["pages" => $pageResponse->getPages()]),
            "loadMore" => $pageResponse->getLoadMore()
        ];

        return new JsonResponse($data);
    }

    public function getPages() {
        $th = Core::make("helper/text");
        $pl = new CommonList();

        $keywords = $th->sanitize(urldecode($this->get("keywords")));
        $sortOrder = $th->sanitize(urldecode($this->get("sortOrder")));
        $page = ($page = (int)$th->sanitize($this->get("page"))) ? $page : 1;

        $params = [];

        if($pageType = $this->getMultipleSelectSelections('btListingBlockPageTypes_MultipleSelectEntries', $this->bID, $this->getPageTypeOptions())) $pl->filterByPageTypeID(array_keys($pageType));

        if($keywords) {
            $params["keywords"] = $keywords;

            $pl->filterByKeywords($keywords);
        }

        if($sortOrder) {
            $params["sortOrder"] = $sortOrder;

            switch ($sortOrder) {
                case 'display_asc':
                    $pl->sortByDisplayOrder();
                    break;
                case 'chrono_asc':
                    $pl->sortByPublicDate();
                    break;
                case 'modified_desc':
                    $pl->sortByDateModifiedDescending();
                    break;
                case 'random':
                    $pl->sortBy('RAND()');
                    break;
                case 'alpha_asc':
                    $pl->sortByName();
                    break;
                case 'alpha_desc':
                    $pl->sortByNameDescending();
                    break;
                case 'display_desc':
                default:
                    $pl->sortByPublicDateDescending();
                    break;
            }
        }

        //custom filters
        $customFilters = $this->getCustomFilters(false);
        foreach ($customFilters as $customFilter) {
            $handle = $customFilter['key'];
            if(!$handle) continue;

            $value = $this->get($handle);
            if(!$value || !is_array($value)) continue;

            $value = array_map(function ($v) use ($th) {
                return $th->sanitize(urldecode($v));
            }, $value);

            $criteria = [];
            foreach ($value as $v) {
                if($v) $criteria[] = "ak_{$handle} LIKE '%\n{$v}\n%'";
            }

            if($criteria) $pl->getQueryObject()->andWhere('(' . implode(' AND ', $criteria) . ')');

            $params[$handle] = $value;
        }

        $pl->setItemsPerPage($this->itemCount ? $this->itemCount : self::ITEMS_PER_PAGE);

        $pageResponse = $pl->getPage($page);

        return $pageResponse;
    }
}