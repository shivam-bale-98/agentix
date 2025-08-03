<?php namespace Application\Block\ProjectApproachBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['features' => []];
    protected $btExportTables = ['btProjectApproachBlock', 'btProjectApproachBlockFeaturesEntries'];
    protected $btTable = 'btProjectApproachBlock';
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
        return t("Project Approach Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $content[] = $this->subtitle;
        $content[] = $this->description_1;
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btProjectApproachBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item_k => $features_item_v) {
            if (isset($features_item_v["value"]) && trim($features_item_v["value"]) != "") {
                $content[] = $features_item_v["value"];
            }
            if (isset($features_item_v["prefix"]) && trim($features_item_v["prefix"]) != "") {
                $content[] = $features_item_v["prefix"];
            }
            if (isset($features_item_v["title"]) && trim($features_item_v["title"]) != "") {
                $content[] = $features_item_v["title"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $this->set('title', LinkAbstractor::translateFrom($this->title));
        $this->set('subtitle', LinkAbstractor::translateFrom($this->subtitle));
        $this->set('description_1', LinkAbstractor::translateFrom($this->description_1));
        $features = [];
        $features_items = $db->fetchAll('SELECT * FROM btProjectApproachBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('features_items', $features_items);
        $this->set('features', $features);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btProjectApproachBlockFeaturesEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btProjectApproachBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item) {
            unset($features_item['id']);
            $features_item['bID'] = $newBID;
            $db->insert('btProjectApproachBlockFeaturesEntries', $features_item);
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
        
        $this->set('title', LinkAbstractor::translateFromEditMode($this->title));
        
        $this->set('subtitle', LinkAbstractor::translateFromEditMode($this->subtitle));
        
        $this->set('description_1', LinkAbstractor::translateFromEditMode($this->description_1));
        $features = $this->get('features');
        $features_items = $db->fetchAll('SELECT * FROM btProjectApproachBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('features', $features);
        $this->set('features_items', $features_items);
    }

    protected function addEdit()
    {
        $features = [];
        $this->set('features', $features);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/project_approach_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/project_approach_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/project_approach_block/js_form/handlebars-helpers.js', [], $this->pkg);
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
        $args['title'] = LinkAbstractor::translateTo($args['title']);
        $args['subtitle'] = LinkAbstractor::translateTo($args['subtitle']);
        $args['description_1'] = LinkAbstractor::translateTo($args['description_1']);
        $rows = $db->fetchAll('SELECT * FROM btProjectApproachBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $features_items = isset($args['features']) && is_array($args['features']) ? $args['features'] : [];
        $queries = [];
        if (!empty($features_items)) {
            $i = 0;
            foreach ($features_items as $features_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($features_item['value']) && trim($features_item['value']) != '') {
                    $data['value'] = trim($features_item['value']);
                } else {
                    $data['value'] = null;
                }
                if (isset($features_item['prefix']) && trim($features_item['prefix']) != '') {
                    $data['prefix'] = trim($features_item['prefix']);
                } else {
                    $data['prefix'] = null;
                }
                if (isset($features_item['title']) && trim($features_item['title']) != '') {
                    $data['title'] = trim($features_item['title']);
                } else {
                    $data['title'] = null;
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
                                $db->update('btProjectApproachBlockFeaturesEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btProjectApproachBlockFeaturesEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btProjectApproachBlockFeaturesEntries', ['id' => $value]);
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
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("subtitle", $this->btFieldsRequired) && (trim($args["subtitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Subtitle")));
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
                        if (in_array("value", $this->btFieldsRequired['features']) && (!isset($features_v['value']) || trim($features_v['value']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Value"), t("Features"), $features_k));
                        }
                        if (in_array("prefix", $this->btFieldsRequired['features']) && (!isset($features_v['prefix']) || trim($features_v['prefix']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("prefix"), t("Features"), $features_k));
                        }
                        if (in_array("title", $this->btFieldsRequired['features']) && (!isset($features_v['title']) || trim($features_v['title']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Title"), t("Features"), $features_k));
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
}