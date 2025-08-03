<?php namespace Application\Block\TwoColumnFeaturesBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = ['features' => []];
    protected $btExportTables = ['btTwoColumnFeaturesBlock', 'btTwoColumnFeaturesBlockFeaturesEntries'];
    protected $btTable = 'btTwoColumnFeaturesBlock';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $pkg = false;
    
    public function getBlockTypeName()
    {
        return t("Two Column Features Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->subtitle;
        $content[] = $this->title;
        $content[] = $this->description_1;
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btTwoColumnFeaturesBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item_k => $features_item_v) {
            if (isset($features_item_v["featureTitle"]) && trim($features_item_v["featureTitle"]) != "") {
                $content[] = $features_item_v["featureTitle"];
            }
            if (isset($features_item_v["featureDescription"]) && trim($features_item_v["featureDescription"]) != "") {
                $content[] = $features_item_v["featureDescription"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $link_URL = null;
		$link_Object = null;
		$link_Title = trim($this->link_Title);
		if (trim($this->link) != '') {
			switch ($this->link) {
				case 'page':
					if ($this->link_Page > 0 && ($link_Page_c = Page::getByID($this->link_Page)) && !$link_Page_c->error && !$link_Page_c->isInTrash()) {
						$link_Object = $link_Page_c;
						$link_URL = $link_Page_c->getCollectionLink();
						if ($link_Title == '') {
							$link_Title = $link_Page_c->getCollectionName();
						}
					}
					break;
				case 'url':
					$link_URL = $this->link_URL;
					if ($link_Title == '') {
						$link_Title = $link_URL;
					}
					break;
				case 'relative_url':
					$link_URL = $this->link_Relative_URL;
					if ($link_Title == '') {
						$link_Title = $this->link_Relative_URL;
					}
					break;
			}
		}
		$this->set("link_URL", $link_URL);
		$this->set("link_Object", $link_Object);
		$this->set("link_Title", $link_Title);
        $this->set('description_1', LinkAbstractor::translateFrom($this->description_1));
        $features = [];
        $features_items = $db->fetchAll('SELECT * FROM btTwoColumnFeaturesBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('features_items', $features_items);
        $this->set('features', $features);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btTwoColumnFeaturesBlockFeaturesEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btTwoColumnFeaturesBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item) {
            unset($features_item['id']);
            $features_item['bID'] = $newBID;
            $db->insert('btTwoColumnFeaturesBlockFeaturesEntries', $features_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $features = $this->get('features');
        $this->set('features_items', []);
        $this->set('features', $features);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        
        $this->set('description_1', LinkAbstractor::translateFromEditMode($this->description_1));
        $features = $this->get('features');
        $features_items = $db->fetchAll('SELECT * FROM btTwoColumnFeaturesBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('features', $features);
        $this->set('features_items', $features_items);
    }

    protected function addEdit()
    {
        $this->set("link_Options", $this->getSmartLinkTypeOptions([
  'page',
  'url',
  'relative_url',
], true));
        $features = [];
        $this->set('features', $features);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/two_column_features_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/two_column_features_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/two_column_features_block/js_form/handlebars-helpers.js', [], $this->pkg);
        $this->requireAsset('redactor');
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        if (!isset($args["hideBlock"]) || trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1])) {
            $args["hideBlock"] = '';
        }
        if (isset($args["link"]) && trim($args["link"]) != '') {
			switch ($args["link"]) {
				case 'page':
					$args["link_File"] = '0';
					$args["link_URL"] = '';
					$args["link_Relative_URL"] = '';
					$args["link_Image"] = '0';
					break;
				case 'url':
					$args["link_Page"] = '0';
					$args["link_Relative_URL"] = '';
					$args["link_File"] = '0';
					$args["link_Image"] = '0';
					break;
				case 'relative_url':
					$args["link_Page"] = '0';
					$args["link_URL"] = '';
					$args["link_File"] = '0';
					$args["link_Image"] = '0';
					break;
				default:
					$args["link_Title"] = '';
					$args["link_Page"] = '0';
					$args["link_File"] = '0';
					$args["link_URL"] = '';
					$args["link_Relative_URL"] = '';
					$args["link_Image"] = '0';
					break;	
			}
		}
		else {
			$args["link_Title"] = '';
			$args["link_Page"] = '0';
			$args["link_File"] = '0';
			$args["link_URL"] = '';
			$args["link_Relative_URL"] = '';
			$args["link_Image"] = '0';
		}
        $args['description_1'] = LinkAbstractor::translateTo($args['description_1']);
        $rows = $db->fetchAll('SELECT * FROM btTwoColumnFeaturesBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $features_items = isset($args['features']) && is_array($args['features']) ? $args['features'] : [];
        $queries = [];
        if (!empty($features_items)) {
            $i = 0;
            foreach ($features_items as $features_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($features_item['featureTitle']) && trim($features_item['featureTitle']) != '') {
                    $data['featureTitle'] = trim($features_item['featureTitle']);
                } else {
                    $data['featureTitle'] = null;
                }
                if (isset($features_item['featureDescription']) && trim($features_item['featureDescription']) != '') {
                    $data['featureDescription'] = trim($features_item['featureDescription']);
                } else {
                    $data['featureDescription'] = null;
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
                                $db->update('btTwoColumnFeaturesBlockFeaturesEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btTwoColumnFeaturesBlockFeaturesEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btTwoColumnFeaturesBlockFeaturesEntries', ['id' => $value]);
                            }
                            break;
                    }
                }
            }
        }
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("hideBlock", $this->btFieldsRequired) && (trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Hide Block")));
        }
        if (in_array("subtitle", $this->btFieldsRequired) && (trim($args["subtitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Subtitle")));
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if ((in_array("link", $this->btFieldsRequired) && (!isset($args["link"]) || trim($args["link"]) == "")) || (isset($args["link"]) && trim($args["link"]) != "" && !array_key_exists($args["link"], $this->getSmartLinkTypeOptions(['page', 'url', 'relative_url'])))) {
			$e->add(t("The %s field has an invalid value.", t("Link")));
		} elseif (array_key_exists($args["link"], $this->getSmartLinkTypeOptions(['page', 'url', 'relative_url']))) {
			switch ($args["link"]) {
				case 'page':
					if (!isset($args["link_Page"]) || trim($args["link_Page"]) == "" || $args["link_Page"] == "0" || (($page = Page::getByID($args["link_Page"])) && $page->error !== false)) {
						$e->add(t("The %s field for '%s' is required.", t("Page"), t("Link")));
					}
					break;
				case 'url':
					if (!isset($args["link_URL"]) || trim($args["link_URL"]) == "" || !filter_var($args["link_URL"], FILTER_VALIDATE_URL)) {
						$e->add(t("The %s field for '%s' does not have a valid URL.", t("URL"), t("Link")));
					}
					break;
				case 'relative_url':
					if (!isset($args["link_Relative_URL"]) || trim($args["link_Relative_URL"]) == "") {
						$e->add(t("The %s field for '%s' is required.", t("Relative URL"), t("Link")));
					}
					break;	
			}
		}
        if (in_array("description_1", $this->btFieldsRequired) && (trim($args["description_1"]) == "")) {
            $e->add(t("The %s field is required.", t("Description")));
        }
        $featuresEntriesMin = 0;
        $featuresEntriesMax = 0;
        $featuresEntriesErrors = 0;
        $features = [];
        if (isset($args['features']) && is_array($args['features']) && !empty($args['features'])) {
            if ($featuresEntriesMin >= 1 && count($args['features']) < $featuresEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Features"), $featuresEntriesMin, count($args['features'])));
                $featuresEntriesErrors++;
            }
            if ($featuresEntriesMax >= 1 && count($args['features']) > $featuresEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Features"), $featuresEntriesMax, count($args['features'])));
                $featuresEntriesErrors++;
            }
            if ($featuresEntriesErrors == 0) {
                foreach ($args['features'] as $features_k => $features_v) {
                    if (is_array($features_v)) {
                        if (in_array("featureTitle", $this->btFieldsRequired['features']) && (!isset($features_v['featureTitle']) || trim($features_v['featureTitle']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Feature Title"), t("Features"), $features_k));
                        }
                        if (in_array("featureDescription", $this->btFieldsRequired['features']) && (!isset($features_v['featureDescription']) || trim($features_v['featureDescription']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Feature Description"), t("Features"), $features_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Features'), $features_k));
                    }
                }
            }
        } else {
            if ($featuresEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Features"), $featuresEntriesMin));
            }
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
}