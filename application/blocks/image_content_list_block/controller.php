<?php namespace Application\Block\ImageContentListBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = ['features' => []];
    protected $btExportFileColumns = ['image'];
    protected $btExportTables = ['btImageContentListBlock', 'btImageContentListBlockFeaturesEntries'];
    protected $btTable = 'btImageContentListBlock';
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
        return t("Image Content List Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->videoLink;
        $content[] = $this->subTitle;
        $content[] = $this->title;
        $content[] = $this->content;
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btImageContentListBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item_k => $features_item_v) {
            if (isset($features_item_v["value"]) && trim($features_item_v["value"]) != "") {
                $content[] = $features_item_v["value"];
            }
            if (isset($features_item_v["surfix"]) && trim($features_item_v["surfix"]) != "") {
                $content[] = $features_item_v["surfix"];
            }
            if (isset($features_item_v["info"]) && trim($features_item_v["info"]) != "") {
                $content[] = $features_item_v["info"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        
        if ($this->image && ($f = File::getByID($this->image)) && is_object($f)) {
            $this->set("image", $f);
        } else {
            $this->set("image", false);
        }
        $this->set('content', LinkAbstractor::translateFrom($this->content));
        $features = [];
        $features_items = $db->fetchAll('SELECT * FROM btImageContentListBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item_k => &$features_item_v) {
            $features_item_v["info"] = isset($features_item_v["info"]) ? LinkAbstractor::translateFrom($features_item_v["info"]) : null;
        }
        $this->set('features_items', $features_items);
        $this->set('features', $features);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btImageContentListBlockFeaturesEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btImageContentListBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item) {
            unset($features_item['id']);
            $features_item['bID'] = $newBID;
            $db->insert('btImageContentListBlockFeaturesEntries', $features_item);
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
        
        $this->set('content', LinkAbstractor::translateFromEditMode($this->content));
        $features = $this->get('features');
        $features_items = $db->fetchAll('SELECT * FROM btImageContentListBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        
        foreach ($features_items as &$features_item) {
            $features_item['info'] = isset($features_item['info']) ? LinkAbstractor::translateFromEditMode($features_item['info']) : null;
        }
        $this->set('features', $features);
        $this->set('features_items', $features_items);
    }

    protected function addEdit()
    {
        $features = [];
        $this->set('features', $features);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/image_content_list_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/image_content_list_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/image_content_list_block/js_form/handlebars-helpers.js', [], $this->pkg);
        $this->requireAsset('core/file-manager');
        $this->requireAsset('redactor');
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
        $args['image'] = isset($args['image']) && is_numeric($args['image']) ? $args['image'] : 0;
        $args['content'] = LinkAbstractor::translateTo($args['content']);
        $rows = $db->fetchAll('SELECT * FROM btImageContentListBlockFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
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
                if (isset($features_item['surfix']) && trim($features_item['surfix']) != '') {
                    $data['surfix'] = trim($features_item['surfix']);
                } else {
                    $data['surfix'] = null;
                }
                $data['info'] = isset($features_item['info']) ? LinkAbstractor::translateTo($features_item['info']) : null;
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
                                $db->update('btImageContentListBlockFeaturesEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btImageContentListBlockFeaturesEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btImageContentListBlockFeaturesEntries', ['id' => $value]);
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
        if (in_array("image", $this->btFieldsRequired) && (trim($args["image"]) == "" || !is_object(File::getByID($args["image"])))) {
            $e->add(t("The %s field is required.", t("Image")));
        }
        if (in_array("videoLink", $this->btFieldsRequired) && (trim($args["videoLink"]) == "")) {
            $e->add(t("The %s field is required.", t("Video Link")));
        }
        if (in_array("subTitle", $this->btFieldsRequired) && (trim($args["subTitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Sub Title")));
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("content", $this->btFieldsRequired) && (trim($args["content"]) == "")) {
            $e->add(t("The %s field is required.", t("Content")));
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
                        if (in_array("surfix", $this->btFieldsRequired['features']) && (!isset($features_v['surfix']) || trim($features_v['surfix']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("surfix"), t("Features"), $features_k));
                        }
                        if (in_array("info", $this->btFieldsRequired['features']) && (!isset($features_v['info']) || trim($features_v['info']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Info"), t("Features"), $features_k));
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