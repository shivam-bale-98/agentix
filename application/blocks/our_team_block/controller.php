<?php namespace Application\Block\OurTeamBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use Database;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = ['list' => []];
    protected $btExportFileColumns = ['image'];
    protected $btExportTables = ['btOurTeamBlock', 'btOurTeamBlockListEntries'];
    protected $btTable = 'btOurTeamBlock';
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
        return t("Our Team Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $db = Database::connection();
        $list_items = $db->fetchAll('SELECT * FROM btOurTeamBlockListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($list_items as $list_item_k => $list_item_v) {
            if (isset($list_item_v["date"]) && trim($list_item_v["date"]) != "") {
                $content[] = $list_item_v["date"];
            }
            if (isset($list_item_v["name"]) && trim($list_item_v["name"]) != "") {
                $content[] = $list_item_v["name"];
            }
            if (isset($list_item_v["designation"]) && trim($list_item_v["designation"]) != "") {
                $content[] = $list_item_v["designation"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $list = [];
        $list_items = $db->fetchAll('SELECT * FROM btOurTeamBlockListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($list_items as $list_item_k => &$list_item_v) {
            if (isset($list_item_v['image']) && trim($list_item_v['image']) != "" && ($f = File::getByID($list_item_v['image'])) && is_object($f)) {
                $list_item_v['image'] = $f;
            } else {
                $list_item_v['image'] = false;
            }
        }
        $this->set('list_items', $list_items);
        $this->set('list', $list);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btOurTeamBlockListEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $list_items = $db->fetchAll('SELECT * FROM btOurTeamBlockListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($list_items as $list_item) {
            unset($list_item['id']);
            $list_item['bID'] = $newBID;
            $db->insert('btOurTeamBlockListEntries', $list_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $list = $this->get('list');
        $this->set('list_items', []);
        $this->set('list', $list);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $list = $this->get('list');
        $list_items = $db->fetchAll('SELECT * FROM btOurTeamBlockListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($list_items as &$list_item) {
            if (!File::getByID($list_item['image'])) {
                unset($list_item['image']);
            }
        }
        $this->set('list', $list);
        $this->set('list_items', $list_items);
    }

    protected function addEdit()
    {
        $list = [];
        $this->set('list', $list);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/our_team_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/our_team_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/our_team_block/js_form/handlebars-helpers.js', [], $this->pkg);
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
        $rows = $db->fetchAll('SELECT * FROM btOurTeamBlockListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $list_items = isset($args['list']) && is_array($args['list']) ? $args['list'] : [];
        $queries = [];
        if (!empty($list_items)) {
            $i = 0;
            foreach ($list_items as $list_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($list_item['date']) && trim($list_item['date']) != '') {
                    $data['date'] = trim($list_item['date']);
                } else {
                    $data['date'] = null;
                }
                if (isset($list_item['name']) && trim($list_item['name']) != '') {
                    $data['name'] = trim($list_item['name']);
                } else {
                    $data['name'] = null;
                }
                if (isset($list_item['designation']) && trim($list_item['designation']) != '') {
                    $data['designation'] = trim($list_item['designation']);
                } else {
                    $data['designation'] = null;
                }
                if (isset($list_item['image']) && trim($list_item['image']) != '') {
                    $data['image'] = trim($list_item['image']);
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
                                $db->update('btOurTeamBlockListEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btOurTeamBlockListEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btOurTeamBlockListEntries', ['id' => $value]);
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
        $listEntriesMin = 0;
        $listEntriesMax = 0;
        $listEntriesErrors = 0;
        $list = [];
        if (isset($args['list']) && is_array($args['list']) && !empty($args['list'])) {
            if ($listEntriesMin >= 1 && count($args['list']) < $listEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("List"), $listEntriesMin, count($args['list'])));
                $listEntriesErrors++;
            }
            if ($listEntriesMax >= 1 && count($args['list']) > $listEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("List"), $listEntriesMax, count($args['list'])));
                $listEntriesErrors++;
            }
            if ($listEntriesErrors == 0) {
                foreach ($args['list'] as $list_k => $list_v) {
                    if (is_array($list_v)) {
                        if (in_array("date", $this->btFieldsRequired['list']) && (!isset($list_v['date']) || trim($list_v['date']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Joining Date"), t("List"), $list_k));
                        }
                        if (in_array("name", $this->btFieldsRequired['list']) && (!isset($list_v['name']) || trim($list_v['name']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Name"), t("List"), $list_k));
                        }
                        if (in_array("designation", $this->btFieldsRequired['list']) && (!isset($list_v['designation']) || trim($list_v['designation']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Designation"), t("List"), $list_k));
                        }
                        if (in_array("image", $this->btFieldsRequired['list']) && (!isset($list_v['image']) || trim($list_v['image']) == "" || !is_object(File::getByID($list_v['image'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image"), t("List"), $list_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('List'), $list_k));
                    }
                }
            }
        } else {
            if ($listEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("List"), $listEntriesMin));
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