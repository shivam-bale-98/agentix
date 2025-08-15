<?php namespace Application\Block\ContactUsBanner;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btExportFileColumns = ['titleImage'];
    protected $btTable = 'btContactUsBanner';
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
        return t("Contact Us Banner");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->subtitle;
        $content[] = $this->titleOne;
        $content[] = $this->titleTwo;
        $content[] = $this->description_1;
        return implode(" ", $content);
    }

    public function view()
    {
        $this->set('description_1', LinkAbstractor::translateFrom($this->description_1));
        
        if ($this->titleImage && ($f = File::getByID($this->titleImage)) && is_object($f)) {
            $this->set("titleImage", $f);
        } else {
            $this->set("titleImage", false);
        }
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('description_1', LinkAbstractor::translateFromEditMode($this->description_1));
    }

    protected function addEdit()
    {
        $this->requireAsset('redactor');
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $args['description_1'] = LinkAbstractor::translateTo($args['description_1']);
        $args['titleImage'] = isset($args['titleImage']) && is_numeric($args['titleImage']) ? $args['titleImage'] : 0;
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("subtitle", $this->btFieldsRequired) && (trim($args["subtitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Subtitle")));
        }
        if (in_array("titleOne", $this->btFieldsRequired) && (trim($args["titleOne"]) == "")) {
            $e->add(t("The %s field is required.", t("Title 1")));
        }
        if (in_array("titleTwo", $this->btFieldsRequired) && (trim($args["titleTwo"]) == "")) {
            $e->add(t("The %s field is required.", t("Title 2")));
        }
        if (in_array("description_1", $this->btFieldsRequired) && (trim($args["description_1"]) == "")) {
            $e->add(t("The %s field is required.", t("Description")));
        }
        if (in_array("titleImage", $this->btFieldsRequired) && (trim($args["titleImage"]) == "" || !is_object(File::getByID($args["titleImage"])))) {
            $e->add(t("The %s field is required.", t("Title Image")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}