<?php namespace Application\Block\NewsDetails;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btExportFileColumns = ['imageOne', 'imageTwo'];
    protected $btTable = 'btNewsDetails';
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
        return t("News Details");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->body;
        $content[] = $this->bodyTwo;
        $content[] = $this->quote;
        $content[] = $this->author;
        $content[] = $this->bodyThree;
        return implode(" ", $content);
    }

    public function view()
    {
        $this->set('body', LinkAbstractor::translateFrom($this->body));
        
        if ($this->imageOne && ($f = File::getByID($this->imageOne)) && is_object($f)) {
            $this->set("imageOne", $f);
        } else {
            $this->set("imageOne", false);
        }
        
        if ($this->imageTwo && ($f = File::getByID($this->imageTwo)) && is_object($f)) {
            $this->set("imageTwo", $f);
        } else {
            $this->set("imageTwo", false);
        }
        $this->set('bodyTwo', LinkAbstractor::translateFrom($this->bodyTwo));
        $this->set('bodyThree', LinkAbstractor::translateFrom($this->bodyThree));
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('body', LinkAbstractor::translateFromEditMode($this->body));
        
        $this->set('bodyTwo', LinkAbstractor::translateFromEditMode($this->bodyTwo));
        
        $this->set('bodyThree', LinkAbstractor::translateFromEditMode($this->bodyThree));
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
        $args['body'] = LinkAbstractor::translateTo($args['body']);
        $args['imageOne'] = isset($args['imageOne']) && is_numeric($args['imageOne']) ? $args['imageOne'] : 0;
        $args['imageTwo'] = isset($args['imageTwo']) && is_numeric($args['imageTwo']) ? $args['imageTwo'] : 0;
        $args['bodyTwo'] = LinkAbstractor::translateTo($args['bodyTwo']);
        $args['bodyThree'] = LinkAbstractor::translateTo($args['bodyThree']);
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("body", $this->btFieldsRequired) && (trim($args["body"]) == "")) {
            $e->add(t("The %s field is required.", t("Body")));
        }
        if (in_array("imageOne", $this->btFieldsRequired) && (trim($args["imageOne"]) == "" || !is_object(File::getByID($args["imageOne"])))) {
            $e->add(t("The %s field is required.", t("Image1")));
        }
        if (in_array("imageTwo", $this->btFieldsRequired) && (trim($args["imageTwo"]) == "" || !is_object(File::getByID($args["imageTwo"])))) {
            $e->add(t("The %s field is required.", t("Image2")));
        }
        if (in_array("bodyTwo", $this->btFieldsRequired) && (trim($args["bodyTwo"]) == "")) {
            $e->add(t("The %s field is required.", t("Body 2")));
        }
        if (in_array("quote", $this->btFieldsRequired) && trim($args["quote"]) == "") {
            $e->add(t("The %s field is required.", t("Quote")));
        }
        if (in_array("author", $this->btFieldsRequired) && (trim($args["author"]) == "")) {
            $e->add(t("The %s field is required.", t("Author")));
        }
        if (in_array("bodyThree", $this->btFieldsRequired) && (trim($args["bodyThree"]) == "")) {
            $e->add(t("The %s field is required.", t("Body 3")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}