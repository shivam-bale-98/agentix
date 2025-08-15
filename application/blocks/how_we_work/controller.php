<?php namespace Application\Block\HowWeWork;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['features' => []];
    protected $btExportTables = ['btHowWeWork', 'btHowWeWorkFeaturesEntries'];
    protected $btTable = 'btHowWeWork';
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
        return t("How We Work");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->subtitle;
        $content[] = $this->title;
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btHowWeWorkFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
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
        $this->set('title', LinkAbstractor::translateFrom($this->title));
        $features = [];
        $features_items = $db->fetchAll('SELECT * FROM btHowWeWorkFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item_k => &$features_item_v) {
            $features_item_v["featureDescription"] = isset($features_item_v["featureDescription"]) ? LinkAbstractor::translateFrom($features_item_v["featureDescription"]) : null;
        }
        $this->set('features_items', $features_items);
        $this->set('features', $features);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btHowWeWorkFeaturesEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $features_items = $db->fetchAll('SELECT * FROM btHowWeWorkFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($features_items as $features_item) {
            unset($features_item['id']);
            $features_item['bID'] = $newBID;
            $db->insert('btHowWeWorkFeaturesEntries', $features_item);
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
        $features = $this->get('features');
        $features_items = $db->fetchAll('SELECT * FROM btHowWeWorkFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        
        foreach ($features_items as &$features_item) {
            $features_item['featureDescription'] = isset($features_item['featureDescription']) ? LinkAbstractor::translateFromEditMode($features_item['featureDescription']) : null;
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
        $al->register('css', 'repeatable-ft.form', 'blocks/how_we_work/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/how_we_work/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/how_we_work/js_form/handlebars-helpers.js', [], $this->pkg);
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
        if (!isset($args["paddingTop"]) || trim($args["paddingTop"]) == "" || !in_array($args["paddingTop"], [0, 1])) {
            $args["paddingTop"] = '';
        }
        if (!isset($args["paddingBottom"]) || trim($args["paddingBottom"]) == "" || !in_array($args["paddingBottom"], [0, 1])) {
            $args["paddingBottom"] = '';
        }
        $args['title'] = LinkAbstractor::translateTo($args['title']);
        $rows = $db->fetchAll('SELECT * FROM btHowWeWorkFeaturesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
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
                $data['featureDescription'] = isset($features_item['featureDescription']) ? LinkAbstractor::translateTo($features_item['featureDescription']) : null;
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
                                $db->update('btHowWeWorkFeaturesEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btHowWeWorkFeaturesEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btHowWeWorkFeaturesEntries', ['id' => $value]);
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
        if (in_array("paddingTop", $this->btFieldsRequired) && (trim($args["paddingTop"]) == "" || !in_array($args["paddingTop"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Padding Top")));
        }
        if (in_array("paddingBottom", $this->btFieldsRequired) && (trim($args["paddingBottom"]) == "" || !in_array($args["paddingBottom"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Padding Bottom")));
        }
        if (in_array("subtitle", $this->btFieldsRequired) && (trim($args["subtitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Subtitle")));
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
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
}