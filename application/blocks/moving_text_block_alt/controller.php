<?php namespace Application\Block\MovingTextBlockAlt;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['movingText' => []];
    protected $btExportTables = ['btMovingTextBlockAlt', 'btMovingTextBlockAltMovingTextEntries'];
    protected $btTable = 'btMovingTextBlockAlt';
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
        return t("Moving Text Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $db = Database::connection();
        $movingText_items = $db->fetchAll('SELECT * FROM btMovingTextBlockAltMovingTextEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($movingText_items as $movingText_item_k => $movingText_item_v) {
            if (isset($movingText_item_v["text"]) && trim($movingText_item_v["text"]) != "") {
                $content[] = $movingText_item_v["text"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $movingText = [];
        $movingText_items = $db->fetchAll('SELECT * FROM btMovingTextBlockAltMovingTextEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($movingText_items as $movingText_item_k => &$movingText_item_v) {
            $movingText_item_v["text"] = isset($movingText_item_v["text"]) ? LinkAbstractor::translateFrom($movingText_item_v["text"]) : null;
        }
        $this->set('movingText_items', $movingText_items);
        $this->set('movingText', $movingText);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btMovingTextBlockAltMovingTextEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $movingText_items = $db->fetchAll('SELECT * FROM btMovingTextBlockAltMovingTextEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($movingText_items as $movingText_item) {
            unset($movingText_item['id']);
            $movingText_item['bID'] = $newBID;
            $db->insert('btMovingTextBlockAltMovingTextEntries', $movingText_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $movingText = $this->get('movingText');
        $this->set('movingText_items', []);
        $this->set('movingText', $movingText);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $movingText = $this->get('movingText');
        $movingText_items = $db->fetchAll('SELECT * FROM btMovingTextBlockAltMovingTextEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        
        foreach ($movingText_items as &$movingText_item) {
            $movingText_item['text'] = isset($movingText_item['text']) ? LinkAbstractor::translateFromEditMode($movingText_item['text']) : null;
        }
        $this->set('movingText', $movingText);
        $this->set('movingText_items', $movingText_items);
    }

    protected function addEdit()
    {
        $movingText = [];
        $this->set('movingText', $movingText);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/moving_text_block_alt/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/moving_text_block_alt/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/moving_text_block_alt/js_form/handlebars-helpers.js', [], $this->pkg);
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
        if (!isset($args["hideBlock"]) || trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1])) {
            $args["hideBlock"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btMovingTextBlockAltMovingTextEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $movingText_items = isset($args['movingText']) && is_array($args['movingText']) ? $args['movingText'] : [];
        $queries = [];
        if (!empty($movingText_items)) {
            $i = 0;
            foreach ($movingText_items as $movingText_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                $data['text'] = isset($movingText_item['text']) ? LinkAbstractor::translateTo($movingText_item['text']) : null;
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
                                $db->update('btMovingTextBlockAltMovingTextEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btMovingTextBlockAltMovingTextEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btMovingTextBlockAltMovingTextEntries', ['id' => $value]);
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
        $movingTextEntriesMin = 0;
        $movingTextEntriesMax = 0;
        $movingTextEntriesErrors = 0;
        $movingText = [];
        if (isset($args['movingText']) && is_array($args['movingText']) && !empty($args['movingText'])) {
            if ($movingTextEntriesMin >= 1 && count($args['movingText']) < $movingTextEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Moving Text"), $movingTextEntriesMin, count($args['movingText'])));
                $movingTextEntriesErrors++;
            }
            if ($movingTextEntriesMax >= 1 && count($args['movingText']) > $movingTextEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Moving Text"), $movingTextEntriesMax, count($args['movingText'])));
                $movingTextEntriesErrors++;
            }
            if ($movingTextEntriesErrors == 0) {
                foreach ($args['movingText'] as $movingText_k => $movingText_v) {
                    if (is_array($movingText_v)) {
                        if (in_array("text", $this->btFieldsRequired['movingText']) && (!isset($movingText_v['text']) || trim($movingText_v['text']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Text"), t("Moving Text"), $movingText_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Moving Text'), $movingText_k));
                    }
                }
            }
        } else {
            if ($movingTextEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Moving Text"), $movingTextEntriesMin));
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