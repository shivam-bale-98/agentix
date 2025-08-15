<?php namespace Application\Block\ContactFormBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use CollectionVersion;
use Concrete\Core\Block\BlockController;
use Core;
use Database;
use Stack;
use StackList;

class Controller extends BlockController
{
    public $btFieldsRequired = ['categories' => []];
    protected $btExportTables = ['btContactFormBlock', 'btContactFormBlockCategoriesEntries'];
    protected $btTable = 'btContactFormBlock';
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
        return t("Contact Us Form");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->subtitle;
        $db = Database::connection();
        $categories_items = $db->fetchAll('SELECT * FROM btContactFormBlockCategoriesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($categories_items as $categories_item_k => $categories_item_v) {
            if (isset($categories_item_v["interest"]) && trim($categories_item_v["interest"]) != "") {
                $content[] = $categories_item_v["interest"];
            }
        }
        $content[] = $this->title;
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $categories = [];
        $categories_items = $db->fetchAll('SELECT * FROM btContactFormBlockCategoriesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('categories_items', $categories_items);
        $this->set('categories', $categories);
        $form = [];
        if ($form_entries = $db->fetchAll('SELECT * FROM btContactFormBlockFormEntries WHERE bID = ? ORDER BY sortOrder ASC', [$this->bID])) {
            foreach ($form_entries as $form_entry) {
                $form[$form_entry['stID']] = Stack::getByID($form_entry['stID']);
            }
        }
        $this->set('form', $form);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btContactFormBlockCategoriesEntries', ['bID' => $this->bID]);
        $db->delete('btContactFormBlockFormEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $categories_items = $db->fetchAll('SELECT * FROM btContactFormBlockCategoriesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($categories_items as $categories_item) {
            unset($categories_item['id']);
            $categories_item['bID'] = $newBID;
            $db->insert('btContactFormBlockCategoriesEntries', $categories_item);
        }
        $form_entries = $db->fetchAll('SELECT * FROM btContactFormBlockFormEntries WHERE bID = ? ORDER BY sortOrder ASC', [$this->bID]);
        foreach ($form_entries as $form_entry) {
            unset($form_entry['id']);
            $db->insert('btContactFormBlockFormEntries', $form_entry);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $categories = $this->get('categories');
        $this->set('categories_items', []);
        $this->set('categories', $categories);
        $form_selected = [];
        $form_options = $this->getStacks();
        $this->set('form_options', $form_options);
        $this->set('form_selected', $form_selected);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $categories = $this->get('categories');
        $categories_items = $db->fetchAll('SELECT * FROM btContactFormBlockCategoriesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('categories', $categories);
        $this->set('categories_items', $categories_items);
        $form_selected = [];
        $form_ordered = [];
        $form_options = $this->getStacks();
        if ($form_entries = $db->fetchAll('SELECT * FROM btContactFormBlockFormEntries WHERE bID = ? ORDER BY sortOrder ASC', [$this->bID])) {
            foreach ($form_entries as $form_entry) {
                $form_selected[] = $form_entry['stID'];
            }
            foreach ($form_selected as $key) {
                if (array_key_exists($key, $form_options)) {
                    $form_ordered[$key] = $form_options[$key];
                    unset($form_options[$key]);
                }
            }
            $form_options = $form_ordered + $form_options;
        }
        $this->set('form_options', $form_options);
        $this->set('form_selected', $form_selected);
    }

    protected function addEdit()
    {
        $categories = [];
        $this->set('categories', $categories);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/contact_form_block/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/contact_form_block/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/contact_form_block/js_form/handlebars-helpers.js', [], $this->pkg);
        $al->register('javascript', 'select2sortable', 'blocks/contact_form_block/js_form/select2.sortable.js', [], $this->pkg);
        $al->register('css', 'auto-css-' . $this->btHandle, 'blocks/' . $this->btHandle . '/auto.css', [], $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->requireAsset('css', 'select2');
        $this->requireAsset('javascript', 'select2');
        $this->requireAsset('javascript', 'select2sortable');
        $this->requireAsset('css', 'auto-css-' . $this->btHandle);
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        $rows = $db->fetchAll('SELECT * FROM btContactFormBlockCategoriesEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $categories_items = isset($args['categories']) && is_array($args['categories']) ? $args['categories'] : [];
        $queries = [];
        if (!empty($categories_items)) {
            $i = 0;
            foreach ($categories_items as $categories_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($categories_item['interest']) && trim($categories_item['interest']) != '') {
                    $data['interest'] = trim($categories_item['interest']);
                } else {
                    $data['interest'] = null;
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
                                $db->update('btContactFormBlockCategoriesEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btContactFormBlockCategoriesEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btContactFormBlockCategoriesEntries', ['id' => $value]);
                            }
                            break;
                    }
                }
            }
        }
        $form_entries_db = [];
        $form_queries = [];
        if ($form_entries = $db->fetchAll('SELECT * FROM btContactFormBlockFormEntries WHERE bID = ? ORDER BY sortOrder ASC', [$this->bID])) {
            foreach ($form_entries as $form_entry) {
                $form_entries_db[] = $form_entry['id'];
            }
        }
        if (isset($args['form']) && is_array($args['form'])) {
            $form_options = $this->getStacks();
            $i = 0;
            foreach ($args['form'] as $stackID) {
                if ($stackID > 0 && array_key_exists($stackID, $form_options)) {
                    $form_data = [
                        'stID'      => $stackID,
                        'sortOrder' => $i,
                    ];
                    if (!empty($form_entries_db)) {
                        $form_entry_db_key = key($form_entries_db);
                        $form_entry_db_value = $form_entries_db[$form_entry_db_key];
                        $form_queries['update'][$form_entry_db_value] = $form_data;
                        unset($form_entries_db[$form_entry_db_key]);
                    } else {
                        $form_data['bID'] = $this->bID;
                        $form_queries['insert'][] = $form_data;
                    }
                    $i++;
                }
            }
        }
        if (!empty($form_entries_db)) {
            foreach ($form_entries_db as $form_entry_db) {
                $form_queries['delete'][] = $form_entry_db;
            }
        }
        if (!empty($form_queries)) {
            foreach ($form_queries as $type => $values) {
                if (!empty($values)) {
                    switch ($type) {
                        case 'update':
                            foreach ($values as $id => $data) {
                                $db->update('btContactFormBlockFormEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btContactFormBlockFormEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btContactFormBlockFormEntries', ['id' => $value]);
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
        if (in_array("subtitle", $this->btFieldsRequired) && (trim($args["subtitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Subtitle")));
        }
        $categoriesEntriesMin = 0;
        $categoriesEntriesMax = 0;
        $categoriesEntriesErrors = 0;
        $categories = [];
        if (isset($args['categories']) && is_array($args['categories']) && !empty($args['categories'])) {
            if ($categoriesEntriesMin >= 1 && count($args['categories']) < $categoriesEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Categories"), $categoriesEntriesMin, count($args['categories'])));
                $categoriesEntriesErrors++;
            }
            if ($categoriesEntriesMax >= 1 && count($args['categories']) > $categoriesEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Categories"), $categoriesEntriesMax, count($args['categories'])));
                $categoriesEntriesErrors++;
            }
            if ($categoriesEntriesErrors == 0) {
                foreach ($args['categories'] as $categories_k => $categories_v) {
                    if (is_array($categories_v)) {
                        if (in_array("interest", $this->btFieldsRequired['categories']) && (!isset($categories_v['interest']) || trim($categories_v['interest']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Interest"), t("Categories"), $categories_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Categories'), $categories_k));
                    }
                }
            }
        } else {
            if ($categoriesEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Categories"), $categoriesEntriesMin));
            }
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("form", $this->btFieldsRequired) && (!isset($args['form']) || (!is_array($args['form']) || empty($args['form'])))) {
            $e->add(t("The %s field is required.", t("Form")));
        } else {
            $stacksPosted = 0;
            $stacksMin = null;
            $stacksMax = null;
            if (isset($args['form']) && is_array($args['form'])) {
                $args['form'] = array_unique($args['form']);
                foreach ($args['form'] as $stID) {
                    if ($st = Stack::getByID($stID)) {
                        $stacksPosted++;
                    }
                }
            }
            if ($stacksMin != null && $stacksMin >= 1 && $stacksPosted < $stacksMin) {
                $e->add(t("The %s field needs a minimum of %s stacks.", t("Form"), $stacksMin));
            } elseif ($stacksMax != null && $stacksMax >= 1 && $stacksMax > $stacksMin && $stacksPosted > $stacksMax) {
                $e->add(t("The %s field has a maximum of %s stacks.", t("Form"), $stacksMax));
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

    private function getStacks()
    {
        $stacksOptions = [];
        $stm = new StackList();
        $stm->filterByUserAdded();
        $stacks = $stm->get();
        foreach ($stacks as $st) {
            $sv = CollectionVersion::get($st, 'ACTIVE');
            $stacksOptions[$st->getCollectionID()] = $sv->getVersionName();
        }
        return $stacksOptions;
    }
}