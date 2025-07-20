<?php namespace Application\Block\BrandsSlider;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use Database;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = ['rowOne' => [], 'rowTwo' => []];
    protected $btExportFileColumns = ['imageOne', 'imageTwo'];
    protected $btExportTables = ['btBrandsSlider', 'btBrandsSliderRowOneEntries', 'btBrandsSliderRowTwoEntries'];
    protected $btTable = 'btBrandsSlider';
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
        return t("Brands Slider");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $rowOne = [];
        $rowOne_items = $db->fetchAll('SELECT * FROM btBrandsSliderRowOneEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rowOne_items as $rowOne_item_k => &$rowOne_item_v) {
            if (isset($rowOne_item_v['imageOne']) && trim($rowOne_item_v['imageOne']) != "" && ($f = File::getByID($rowOne_item_v['imageOne'])) && is_object($f)) {
                $rowOne_item_v['imageOne'] = $f;
            } else {
                $rowOne_item_v['imageOne'] = false;
            }
        }
        $this->set('rowOne_items', $rowOne_items);
        $this->set('rowOne', $rowOne);
        $rowTwo = [];
        $rowTwo_items = $db->fetchAll('SELECT * FROM btBrandsSliderRowTwoEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rowTwo_items as $rowTwo_item_k => &$rowTwo_item_v) {
            if (isset($rowTwo_item_v['imageTwo']) && trim($rowTwo_item_v['imageTwo']) != "" && ($f = File::getByID($rowTwo_item_v['imageTwo'])) && is_object($f)) {
                $rowTwo_item_v['imageTwo'] = $f;
            } else {
                $rowTwo_item_v['imageTwo'] = false;
            }
        }
        $this->set('rowTwo_items', $rowTwo_items);
        $this->set('rowTwo', $rowTwo);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btBrandsSliderRowOneEntries', ['bID' => $this->bID]);
        $db->delete('btBrandsSliderRowTwoEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $rowOne_items = $db->fetchAll('SELECT * FROM btBrandsSliderRowOneEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rowOne_items as $rowOne_item) {
            unset($rowOne_item['id']);
            $rowOne_item['bID'] = $newBID;
            $db->insert('btBrandsSliderRowOneEntries', $rowOne_item);
        }
        $rowTwo_items = $db->fetchAll('SELECT * FROM btBrandsSliderRowTwoEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rowTwo_items as $rowTwo_item) {
            unset($rowTwo_item['id']);
            $rowTwo_item['bID'] = $newBID;
            $db->insert('btBrandsSliderRowTwoEntries', $rowTwo_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $rowOne = $this->get('rowOne');
        $this->set('rowOne_items', []);
        $this->set('rowOne', $rowOne);
        $rowTwo = $this->get('rowTwo');
        $this->set('rowTwo_items', []);
        $this->set('rowTwo', $rowTwo);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $rowOne = $this->get('rowOne');
        $rowOne_items = $db->fetchAll('SELECT * FROM btBrandsSliderRowOneEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rowOne_items as &$rowOne_item) {
            if (!File::getByID($rowOne_item['imageOne'])) {
                unset($rowOne_item['imageOne']);
            }
        }
        $this->set('rowOne', $rowOne);
        $this->set('rowOne_items', $rowOne_items);
        $rowTwo = $this->get('rowTwo');
        $rowTwo_items = $db->fetchAll('SELECT * FROM btBrandsSliderRowTwoEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rowTwo_items as &$rowTwo_item) {
            if (!File::getByID($rowTwo_item['imageTwo'])) {
                unset($rowTwo_item['imageTwo']);
            }
        }
        $this->set('rowTwo', $rowTwo);
        $this->set('rowTwo_items', $rowTwo_items);
    }

    protected function addEdit()
    {
        $rowOne = [];
        $this->set('rowOne', $rowOne);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $rowTwo = [];
        $this->set('rowTwo', $rowTwo);
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/brands_slider/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/brands_slider/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/brands_slider/js_form/handlebars-helpers.js', [], $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        if (!isset($args["hideBlock"]) || trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1])) {
            $args["hideBlock"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btBrandsSliderRowOneEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $rowOne_items = isset($args['rowOne']) && is_array($args['rowOne']) ? $args['rowOne'] : [];
        $queries = [];
        if (!empty($rowOne_items)) {
            $i = 0;
            foreach ($rowOne_items as $rowOne_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($rowOne_item['imageOne']) && trim($rowOne_item['imageOne']) != '') {
                    $data['imageOne'] = trim($rowOne_item['imageOne']);
                } else {
                    $data['imageOne'] = null;
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
                                $db->update('btBrandsSliderRowOneEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btBrandsSliderRowOneEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btBrandsSliderRowOneEntries', ['id' => $value]);
                            }
                            break;
                    }
                }
            }
        }
        $rows = $db->fetchAll('SELECT * FROM btBrandsSliderRowTwoEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $rowTwo_items = isset($args['rowTwo']) && is_array($args['rowTwo']) ? $args['rowTwo'] : [];
        $queries = [];
        if (!empty($rowTwo_items)) {
            $i = 0;
            foreach ($rowTwo_items as $rowTwo_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($rowTwo_item['imageTwo']) && trim($rowTwo_item['imageTwo']) != '') {
                    $data['imageTwo'] = trim($rowTwo_item['imageTwo']);
                } else {
                    $data['imageTwo'] = null;
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
                                $db->update('btBrandsSliderRowTwoEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btBrandsSliderRowTwoEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btBrandsSliderRowTwoEntries', ['id' => $value]);
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
        $rowOneEntriesMin = 0;
        $rowOneEntriesMax = 0;
        $rowOneEntriesErrors = 0;
        $rowOne = [];
        if (isset($args['rowOne']) && is_array($args['rowOne']) && !empty($args['rowOne'])) {
            if ($rowOneEntriesMin >= 1 && count($args['rowOne']) < $rowOneEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Row 1"), $rowOneEntriesMin, count($args['rowOne'])));
                $rowOneEntriesErrors++;
            }
            if ($rowOneEntriesMax >= 1 && count($args['rowOne']) > $rowOneEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Row 1"), $rowOneEntriesMax, count($args['rowOne'])));
                $rowOneEntriesErrors++;
            }
            if ($rowOneEntriesErrors == 0) {
                foreach ($args['rowOne'] as $rowOne_k => $rowOne_v) {
                    if (is_array($rowOne_v)) {
                        if (in_array("imageOne", $this->btFieldsRequired['rowOne']) && (!isset($rowOne_v['imageOne']) || trim($rowOne_v['imageOne']) == "" || !is_object(File::getByID($rowOne_v['imageOne'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image 1"), t("Row 1"), $rowOne_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Row 1'), $rowOne_k));
                    }
                }
            }
        } else {
            if ($rowOneEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Row 1"), $rowOneEntriesMin));
            }
        }
        $rowTwoEntriesMin = 0;
        $rowTwoEntriesMax = 0;
        $rowTwoEntriesErrors = 0;
        $rowTwo = [];
        if (isset($args['rowTwo']) && is_array($args['rowTwo']) && !empty($args['rowTwo'])) {
            if ($rowTwoEntriesMin >= 1 && count($args['rowTwo']) < $rowTwoEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Row 2"), $rowTwoEntriesMin, count($args['rowTwo'])));
                $rowTwoEntriesErrors++;
            }
            if ($rowTwoEntriesMax >= 1 && count($args['rowTwo']) > $rowTwoEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Row 2"), $rowTwoEntriesMax, count($args['rowTwo'])));
                $rowTwoEntriesErrors++;
            }
            if ($rowTwoEntriesErrors == 0) {
                foreach ($args['rowTwo'] as $rowTwo_k => $rowTwo_v) {
                    if (is_array($rowTwo_v)) {
                        if (in_array("imageTwo", $this->btFieldsRequired['rowTwo']) && (!isset($rowTwo_v['imageTwo']) || trim($rowTwo_v['imageTwo']) == "" || !is_object(File::getByID($rowTwo_v['imageTwo'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image 2"), t("Row 2"), $rowTwo_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Row 2'), $rowTwo_k));
                    }
                }
            }
        } else {
            if ($rowTwoEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Row 2"), $rowTwoEntriesMin));
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