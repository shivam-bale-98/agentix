<?php namespace Application\Block\VideoGallery;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use Database;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = ['gallery' => []];
    protected $btExportFileColumns = ['image'];
    protected $btExportTables = ['btVideoGallery', 'btVideoGalleryGalleryEntries'];
    protected $btTable = 'btVideoGallery';
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
        return t("Video Gallery ");
    }

    public function getSearchableContent()
    {
        $content = [];
        $db = Database::connection();
        $gallery_items = $db->fetchAll('SELECT * FROM btVideoGalleryGalleryEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($gallery_items as $gallery_item_k => $gallery_item_v) {
            if (isset($gallery_item_v["videoLink"]) && trim($gallery_item_v["videoLink"]) != "") {
                $content[] = $gallery_item_v["videoLink"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $gallery = [];
        $gallery_items = $db->fetchAll('SELECT * FROM btVideoGalleryGalleryEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($gallery_items as $gallery_item_k => &$gallery_item_v) {
            if (isset($gallery_item_v['image']) && trim($gallery_item_v['image']) != "" && ($f = File::getByID($gallery_item_v['image'])) && is_object($f)) {
                $gallery_item_v['image'] = $f;
            } else {
                $gallery_item_v['image'] = false;
            }
        }
        $this->set('gallery_items', $gallery_items);
        $this->set('gallery', $gallery);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btVideoGalleryGalleryEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $gallery_items = $db->fetchAll('SELECT * FROM btVideoGalleryGalleryEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($gallery_items as $gallery_item) {
            unset($gallery_item['id']);
            $gallery_item['bID'] = $newBID;
            $db->insert('btVideoGalleryGalleryEntries', $gallery_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $gallery = $this->get('gallery');
        $this->set('gallery_items', []);
        $this->set('gallery', $gallery);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $gallery = $this->get('gallery');
        $gallery_items = $db->fetchAll('SELECT * FROM btVideoGalleryGalleryEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($gallery_items as &$gallery_item) {
            if (!File::getByID($gallery_item['image'])) {
                unset($gallery_item['image']);
            }
        }
        $this->set('gallery', $gallery);
        $this->set('gallery_items', $gallery_items);
    }

    protected function addEdit()
    {
        $gallery = [];
        $this->set('gallery', $gallery);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/video_gallery/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/video_gallery/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/video_gallery/js_form/handlebars-helpers.js', [], $this->pkg);
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
        if (!isset($args["paddingTop"]) || trim($args["paddingTop"]) == "" || !in_array($args["paddingTop"], [0, 1])) {
            $args["paddingTop"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btVideoGalleryGalleryEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $gallery_items = isset($args['gallery']) && is_array($args['gallery']) ? $args['gallery'] : [];
        $queries = [];
        if (!empty($gallery_items)) {
            $i = 0;
            foreach ($gallery_items as $gallery_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($gallery_item['image']) && trim($gallery_item['image']) != '') {
                    $data['image'] = trim($gallery_item['image']);
                } else {
                    $data['image'] = null;
                }
                if (isset($gallery_item['videoLink']) && trim($gallery_item['videoLink']) != '') {
                    $data['videoLink'] = trim($gallery_item['videoLink']);
                } else {
                    $data['videoLink'] = null;
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
                                $db->update('btVideoGalleryGalleryEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btVideoGalleryGalleryEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btVideoGalleryGalleryEntries', ['id' => $value]);
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
        $galleryEntriesMin = 6;
        $galleryEntriesMax = 0;
        $galleryEntriesErrors = 0;
        $gallery = [];
        if (isset($args['gallery']) && is_array($args['gallery']) && !empty($args['gallery'])) {
            if ($galleryEntriesMin >= 1 && count($args['gallery']) < $galleryEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Gallery"), $galleryEntriesMin, count($args['gallery'])));
                $galleryEntriesErrors++;
            }
            if ($galleryEntriesMax >= 1 && count($args['gallery']) > $galleryEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Gallery"), $galleryEntriesMax, count($args['gallery'])));
                $galleryEntriesErrors++;
            }
            if ($galleryEntriesErrors == 0) {
                foreach ($args['gallery'] as $gallery_k => $gallery_v) {
                    if (is_array($gallery_v)) {
                        if (in_array("image", $this->btFieldsRequired['gallery']) && (!isset($gallery_v['image']) || trim($gallery_v['image']) == "" || !is_object(File::getByID($gallery_v['image'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image"), t("Gallery"), $gallery_k));
                        }
                        if (in_array("videoLink", $this->btFieldsRequired['gallery']) && (!isset($gallery_v['videoLink']) || trim($gallery_v['videoLink']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Video Link"), t("Gallery"), $gallery_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Gallery'), $gallery_k));
                    }
                }
            }
        } else {
            if ($galleryEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Gallery"), $galleryEntriesMin));
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