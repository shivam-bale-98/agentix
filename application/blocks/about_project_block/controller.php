<?php namespace Application\Block\AboutProjectBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['listItems' => []];
    protected $btExportTables = ['btAboutProjectBlock', 'btAboutProjectBlockListItemsEntries'];
    protected $btTable = 'btAboutProjectBlock';
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
        return t("About Project Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->subtitle;
        $content[] = $this->description_1;
        $db = Database::connection();
        $listItems_items = $db->fetchAll('SELECT * FROM btAboutProjectBlockListItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($listItems_items as $listItems_item_k => $listItems_item_v) {
            if (isset($listItems_item_v["item"]) && trim($listItems_item_v["item"]) != "") {
                $content[] = $listItems_item_v["item"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $this->set('subtitle', LinkAbstractor::translateFrom($this->subtitle));
        $listItems = [];
        $listItems_items = $db->fetchAll('SELECT * FROM btAboutProjectBlockListItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('listItems_items', $listItems_items);
        $this->set('listItems', $listItems);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btAboutProjectBlockListItemsEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $listItems_items = $db->fetchAll('SELECT * FROM btAboutProjectBlockListItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($listItems_items as $listItems_item) {
            unset($listItems_item['id']);
            $listItems_item['bID'] = $newBID;
            $db->insert('btAboutProjectBlockListItemsEntries', $listItems_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $listItems = $this->get('listItems');
        $this->set('listItems_items', []);
        $this->set('listItems', $listItems);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        
        $this->set('subtitle', LinkAbstractor::translateFromEditMode($this->subtitle));
        $listItems = $this->get('listItems');
        $listItems_items = $db->fetchAll('SELECT * FROM btAboutProjectBlockListItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('listItems', $listItems);
        $this->set('listItems_items', $listItems_items);
    }

    protected function addEdit()
    {
        $listItems = [];
        $this->set('listItems', $listItems);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/about_project_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/about_project_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/about_project_block/js_form/handlebars-helpers.js', [], $this->pkg);
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
        $args['subtitle'] = LinkAbstractor::translateTo($args['subtitle']);
        $rows = $db->fetchAll('SELECT * FROM btAboutProjectBlockListItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $listItems_items = isset($args['listItems']) && is_array($args['listItems']) ? $args['listItems'] : [];
        $queries = [];
        if (!empty($listItems_items)) {
            $i = 0;
            foreach ($listItems_items as $listItems_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($listItems_item['item']) && trim($listItems_item['item']) != '') {
                    $data['item'] = trim($listItems_item['item']);
                } else {
                    $data['item'] = null;
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
                                $db->update('btAboutProjectBlockListItemsEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btAboutProjectBlockListItemsEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btAboutProjectBlockListItemsEntries', ['id' => $value]);
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
        if (in_array("description_1", $this->btFieldsRequired) && (trim($args["description_1"]) == "")) {
            $e->add(t("The %s field is required.", t("Description")));
        }
        $listItemsEntriesMin = 0;
        $listItemsEntriesMax = 0;
        $listItemsEntriesErrors = 0;
        $listItems = [];
        if (isset($args['listItems']) && is_array($args['listItems']) && !empty($args['listItems'])) {
            if ($listItemsEntriesMin >= 1 && count($args['listItems']) < $listItemsEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("List Item"), $listItemsEntriesMin, count($args['listItems'])));
                $listItemsEntriesErrors++;
            }
            if ($listItemsEntriesMax >= 1 && count($args['listItems']) > $listItemsEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("List Item"), $listItemsEntriesMax, count($args['listItems'])));
                $listItemsEntriesErrors++;
            }
            if ($listItemsEntriesErrors == 0) {
                foreach ($args['listItems'] as $listItems_k => $listItems_v) {
                    if (is_array($listItems_v)) {
                        if (in_array("item", $this->btFieldsRequired['listItems']) && (!isset($listItems_v['item']) || trim($listItems_v['item']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Item"), t("List Item"), $listItems_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('List Item'), $listItems_k));
                    }
                }
            }
        } else {
            if ($listItemsEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("List Item"), $listItemsEntriesMin));
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
}