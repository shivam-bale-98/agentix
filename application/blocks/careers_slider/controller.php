<?php namespace Application\Block\CareersSlider;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use Database;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = ['slider' => []];
    protected $btExportFileColumns = ['image'];
    protected $btExportTables = ['btCareersSlider', 'btCareersSliderSliderEntries'];
    protected $btTable = 'btCareersSlider';
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
        return t("Careers Image Slider");
    }

    public function view()
    {
        $db = Database::connection();
        $slider = [];
        $slider_items = $db->fetchAll('SELECT * FROM btCareersSliderSliderEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($slider_items as $slider_item_k => &$slider_item_v) {
            if (isset($slider_item_v['image']) && trim($slider_item_v['image']) != "" && ($f = File::getByID($slider_item_v['image'])) && is_object($f)) {
                $slider_item_v['image'] = $f;
            } else {
                $slider_item_v['image'] = false;
            }
        }
        $this->set('slider_items', $slider_items);
        $this->set('slider', $slider);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btCareersSliderSliderEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $slider_items = $db->fetchAll('SELECT * FROM btCareersSliderSliderEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($slider_items as $slider_item) {
            unset($slider_item['id']);
            $slider_item['bID'] = $newBID;
            $db->insert('btCareersSliderSliderEntries', $slider_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $slider = $this->get('slider');
        $this->set('slider_items', []);
        $this->set('slider', $slider);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $slider = $this->get('slider');
        $slider_items = $db->fetchAll('SELECT * FROM btCareersSliderSliderEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($slider_items as &$slider_item) {
            if (!File::getByID($slider_item['image'])) {
                unset($slider_item['image']);
            }
        }
        $this->set('slider', $slider);
        $this->set('slider_items', $slider_items);
    }

    protected function addEdit()
    {
        $slider = [];
        $this->set('slider', $slider);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/careers_slider/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/careers_slider/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/careers_slider/js_form/handlebars-helpers.js', [], $this->pkg);
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
        if (!isset($args["paddingBottom"]) || trim($args["paddingBottom"]) == "" || !in_array($args["paddingBottom"], [0, 1])) {
            $args["paddingBottom"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btCareersSliderSliderEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $slider_items = isset($args['slider']) && is_array($args['slider']) ? $args['slider'] : [];
        $queries = [];
        if (!empty($slider_items)) {
            $i = 0;
            foreach ($slider_items as $slider_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($slider_item['image']) && trim($slider_item['image']) != '') {
                    $data['image'] = trim($slider_item['image']);
                } else {
                    $data['image'] = null;
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
                                $db->update('btCareersSliderSliderEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btCareersSliderSliderEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btCareersSliderSliderEntries', ['id' => $value]);
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
        if (in_array("paddingBottom", $this->btFieldsRequired) && (trim($args["paddingBottom"]) == "" || !in_array($args["paddingBottom"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Padding Bottom")));
        }
        $sliderEntriesMin = 0;
        $sliderEntriesMax = 0;
        $sliderEntriesErrors = 0;
        $slider = [];
        if (isset($args['slider']) && is_array($args['slider']) && !empty($args['slider'])) {
            if ($sliderEntriesMin >= 1 && count($args['slider']) < $sliderEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Slider"), $sliderEntriesMin, count($args['slider'])));
                $sliderEntriesErrors++;
            }
            if ($sliderEntriesMax >= 1 && count($args['slider']) > $sliderEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Slider"), $sliderEntriesMax, count($args['slider'])));
                $sliderEntriesErrors++;
            }
            if ($sliderEntriesErrors == 0) {
                foreach ($args['slider'] as $slider_k => $slider_v) {
                    if (is_array($slider_v)) {
                        if (in_array("image", $this->btFieldsRequired['slider']) && (!isset($slider_v['image']) || trim($slider_v['image']) == "" || !is_object(File::getByID($slider_v['image'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image"), t("Slider"), $slider_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Slider'), $slider_k));
                    }
                }
            }
        } else {
            if ($sliderEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Slider"), $sliderEntriesMin));
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