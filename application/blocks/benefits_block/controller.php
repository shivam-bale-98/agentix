<?php namespace Application\Block\BenefitsBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['benefits' => []];
    protected $btExportTables = ['btBenefitsBlock', 'btBenefitsBlockBenefitsEntries'];
    protected $btTable = 'btBenefitsBlock';
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
        return t("Benefits Blocks");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->subTitle;
        $content[] = $this->title;
        $db = Database::connection();
        $benefits_items = $db->fetchAll('SELECT * FROM btBenefitsBlockBenefitsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($benefits_items as $benefits_item_k => $benefits_item_v) {
            if (isset($benefits_item_v["title"]) && trim($benefits_item_v["title"]) != "") {
                $content[] = $benefits_item_v["title"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $benefits = [];
        $benefits["logos_options"] = [
            '' => "-- " . t("None") . " --",
            'culture' => "culture",
            'sports' => "sports",
            'festivals' => "festivals",
            'outings' => "outings",
            'pantry' => "pantry",
            'prayer' => "prayer",
            'encashment' => "encashment",
            'bonus' => "bonus"
        ];
        $benefits_items = $db->fetchAll('SELECT * FROM btBenefitsBlockBenefitsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('benefits_items', $benefits_items);
        $this->set('benefits', $benefits);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btBenefitsBlockBenefitsEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $benefits_items = $db->fetchAll('SELECT * FROM btBenefitsBlockBenefitsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($benefits_items as $benefits_item) {
            unset($benefits_item['id']);
            $benefits_item['bID'] = $newBID;
            $db->insert('btBenefitsBlockBenefitsEntries', $benefits_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $benefits = $this->get('benefits');
        $this->set('benefits_items', []);
        
        $this->set('benefits', $benefits);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $benefits = $this->get('benefits');
        $benefits_items = $db->fetchAll('SELECT * FROM btBenefitsBlockBenefitsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('benefits', $benefits);
        $this->set('benefits_items', $benefits_items);
    }

    protected function addEdit()
    {
        $benefits = [];
        $benefits['logos_options'] = [
            '' => "-- " . t("None") . " --",
            'culture' => "culture",
            'sports' => "sports",
            'festivals' => "festivals",
            'outings' => "outings",
            'pantry' => "pantry",
            'prayer' => "prayer",
            'encashment' => "encashment",
            'bonus' => "bonus"
        ];
        $this->set('benefits', $benefits);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/benefits_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/benefits_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/benefits_block/js_form/handlebars-helpers.js', [], $this->pkg);
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
        if (!isset($args["PaddingTop"]) || trim($args["PaddingTop"]) == "" || !in_array($args["PaddingTop"], [0, 1])) {
            $args["PaddingTop"] = '';
        }
        if (!isset($args["PaddingBottom"]) || trim($args["PaddingBottom"]) == "" || !in_array($args["PaddingBottom"], [0, 1])) {
            $args["PaddingBottom"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btBenefitsBlockBenefitsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $benefits_items = isset($args['benefits']) && is_array($args['benefits']) ? $args['benefits'] : [];
        $queries = [];
        if (!empty($benefits_items)) {
            $i = 0;
            foreach ($benefits_items as $benefits_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($benefits_item['logos']) && trim($benefits_item['logos']) != '') {
                    $data['logos'] = trim($benefits_item['logos']);
                } else {
                    $data['logos'] = null;
                }
                if (isset($benefits_item['title']) && trim($benefits_item['title']) != '') {
                    $data['title'] = trim($benefits_item['title']);
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
                                $db->update('btBenefitsBlockBenefitsEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btBenefitsBlockBenefitsEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btBenefitsBlockBenefitsEntries', ['id' => $value]);
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
        if (in_array("PaddingTop", $this->btFieldsRequired) && (trim($args["PaddingTop"]) == "" || !in_array($args["PaddingTop"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Padding Top")));
        }
        if (in_array("PaddingBottom", $this->btFieldsRequired) && (trim($args["PaddingBottom"]) == "" || !in_array($args["PaddingBottom"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Padding Bottom")));
        }
        if (in_array("subTitle", $this->btFieldsRequired) && (trim($args["subTitle"]) == "")) {
            $e->add(t("The %s field is required.", t("SubTitle")));
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        $benefitsEntriesMin = 0;
        $benefitsEntriesMax = 0;
        $benefitsEntriesErrors = 0;
        $benefits = [];
        if (isset($args['benefits']) && is_array($args['benefits']) && !empty($args['benefits'])) {
            if ($benefitsEntriesMin >= 1 && count($args['benefits']) < $benefitsEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Benefits"), $benefitsEntriesMin, count($args['benefits'])));
                $benefitsEntriesErrors++;
            }
            if ($benefitsEntriesMax >= 1 && count($args['benefits']) > $benefitsEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Benefits"), $benefitsEntriesMax, count($args['benefits'])));
                $benefitsEntriesErrors++;
            }
            if ($benefitsEntriesErrors == 0) {
                foreach ($args['benefits'] as $benefits_k => $benefits_v) {
                    if (is_array($benefits_v)) {
                        if ((in_array("logos", $this->btFieldsRequired['benefits']) && (!isset($benefits_v['logos']) || trim($benefits_v['logos']) == "")) || (isset($benefits_v['logos']) && trim($benefits_v['logos']) != "" && !in_array($benefits_v['logos'], ["culture", "sports", "festivals", "outings", "pantry", "prayer", "encashment", "bonus"]))) {
                            $e->add(t("The %s field has an invalid value (%s, row #%s).", t("Logos"), t("Benefits"), $benefits_k));
                        }
                        if (in_array("title", $this->btFieldsRequired['benefits']) && (!isset($benefits_v['title']) || trim($benefits_v['title']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Title"), t("Benefits"), $benefits_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Benefits'), $benefits_k));
                    }
                }
            }
        } else {
            if ($benefitsEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Benefits"), $benefitsEntriesMin));
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