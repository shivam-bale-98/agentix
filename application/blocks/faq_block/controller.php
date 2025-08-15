<?php namespace Application\Block\FaqBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['faqs' => []];
    protected $btExportTables = ['btFaqBlock', 'btFaqBlockFaqsEntries'];
    protected $btTable = 'btFaqBlock';
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
        return t("Faq Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $db = Database::connection();
        $faqs_items = $db->fetchAll('SELECT * FROM btFaqBlockFaqsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($faqs_items as $faqs_item_k => $faqs_item_v) {
            if (isset($faqs_item_v["faqTitle"]) && trim($faqs_item_v["faqTitle"]) != "") {
                $content[] = $faqs_item_v["faqTitle"];
            }
            if (isset($faqs_item_v["faqDescription"]) && trim($faqs_item_v["faqDescription"]) != "") {
                $content[] = $faqs_item_v["faqDescription"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $faqs = [];
        $faqs_items = $db->fetchAll('SELECT * FROM btFaqBlockFaqsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($faqs_items as $faqs_item_k => &$faqs_item_v) {
            $faqs_item_v["faqDescription"] = isset($faqs_item_v["faqDescription"]) ? LinkAbstractor::translateFrom($faqs_item_v["faqDescription"]) : null;
        }
        $this->set('faqs_items', $faqs_items);
        $this->set('faqs', $faqs);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btFaqBlockFaqsEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $faqs_items = $db->fetchAll('SELECT * FROM btFaqBlockFaqsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($faqs_items as $faqs_item) {
            unset($faqs_item['id']);
            $faqs_item['bID'] = $newBID;
            $db->insert('btFaqBlockFaqsEntries', $faqs_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $faqs = $this->get('faqs');
        $this->set('faqs_items', []);
        $this->set('faqs', $faqs);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $faqs = $this->get('faqs');
        $faqs_items = $db->fetchAll('SELECT * FROM btFaqBlockFaqsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        
        foreach ($faqs_items as &$faqs_item) {
            $faqs_item['faqDescription'] = isset($faqs_item['faqDescription']) ? LinkAbstractor::translateFromEditMode($faqs_item['faqDescription']) : null;
        }
        $this->set('faqs', $faqs);
        $this->set('faqs_items', $faqs_items);
    }

    protected function addEdit()
    {
        $faqs = [];
        $this->set('faqs', $faqs);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/faq_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/faq_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/faq_block/js_form/handlebars-helpers.js', [], $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->requireAsset('redactor');
        $this->requireAsset('core/file-manager');
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
        $rows = $db->fetchAll('SELECT * FROM btFaqBlockFaqsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $faqs_items = isset($args['faqs']) && is_array($args['faqs']) ? $args['faqs'] : [];
        $queries = [];
        if (!empty($faqs_items)) {
            $i = 0;
            foreach ($faqs_items as $faqs_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($faqs_item['faqTitle']) && trim($faqs_item['faqTitle']) != '') {
                    $data['faqTitle'] = trim($faqs_item['faqTitle']);
                } else {
                    $data['faqTitle'] = null;
                }
                $data['faqDescription'] = isset($faqs_item['faqDescription']) ? LinkAbstractor::translateTo($faqs_item['faqDescription']) : null;
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
                                $db->update('btFaqBlockFaqsEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btFaqBlockFaqsEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btFaqBlockFaqsEntries', ['id' => $value]);
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
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("paddingTop", $this->btFieldsRequired) && (trim($args["paddingTop"]) == "" || !in_array($args["paddingTop"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("PaddingTop")));
        }
        if (in_array("paddingBottom", $this->btFieldsRequired) && (trim($args["paddingBottom"]) == "" || !in_array($args["paddingBottom"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Padding Bottom")));
        }
        $faqsEntriesMin = 0;
        $faqsEntriesMax = 0;
        $faqsEntriesErrors = 0;
        $faqs = [];
        if (isset($args['faqs']) && is_array($args['faqs']) && !empty($args['faqs'])) {
            if ($faqsEntriesMin >= 1 && count($args['faqs']) < $faqsEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Faqs"), $faqsEntriesMin, count($args['faqs'])));
                $faqsEntriesErrors++;
            }
            if ($faqsEntriesMax >= 1 && count($args['faqs']) > $faqsEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Faqs"), $faqsEntriesMax, count($args['faqs'])));
                $faqsEntriesErrors++;
            }
            if ($faqsEntriesErrors == 0) {
                foreach ($args['faqs'] as $faqs_k => $faqs_v) {
                    if (is_array($faqs_v)) {
                        if (in_array("faqTitle", $this->btFieldsRequired['faqs']) && (!isset($faqs_v['faqTitle']) || trim($faqs_v['faqTitle']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Faq Title"), t("Faqs"), $faqs_k));
                        }
                        if (in_array("faqDescription", $this->btFieldsRequired['faqs']) && (!isset($faqs_v['faqDescription']) || trim($faqs_v['faqDescription']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Faq Description"), t("Faqs"), $faqs_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Faqs'), $faqs_k));
                    }
                }
            }
        } else {
            if ($faqsEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Faqs"), $faqsEntriesMin));
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