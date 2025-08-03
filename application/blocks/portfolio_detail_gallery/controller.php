<?php namespace Application\Block\PortfolioDetailGallery;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Core;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btExportFileColumns = ['imageFull', 'ImageTwo', 'imageThree'];
    protected $btTable = 'btPortfolioDetailGallery';
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
        return t("Portfolio Detail Gallery");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->video;
        return implode(" ", $content);
    }

    public function view()
    {
        
        if ($this->imageFull && ($f = File::getByID($this->imageFull)) && is_object($f)) {
            $this->set("imageFull", $f);
        } else {
            $this->set("imageFull", false);
        }
        
        if ($this->ImageTwo && ($f = File::getByID($this->ImageTwo)) && is_object($f)) {
            $this->set("ImageTwo", $f);
        } else {
            $this->set("ImageTwo", false);
        }
        
        if ($this->imageThree && ($f = File::getByID($this->imageThree)) && is_object($f)) {
            $this->set("imageThree", $f);
        } else {
            $this->set("imageThree", false);
        }
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
    }

    protected function addEdit()
    {
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        if (!isset($args["hideBlock"]) || trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1])) {
            $args["hideBlock"] = '';
        }
        $args['imageFull'] = isset($args['imageFull']) && is_numeric($args['imageFull']) ? $args['imageFull'] : 0;
        $args['ImageTwo'] = isset($args['ImageTwo']) && is_numeric($args['ImageTwo']) ? $args['ImageTwo'] : 0;
        $args['imageThree'] = isset($args['imageThree']) && is_numeric($args['imageThree']) ? $args['imageThree'] : 0;
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("hideBlock", $this->btFieldsRequired) && (trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Hide Block")));
        }
        if (in_array("imageFull", $this->btFieldsRequired) && (trim($args["imageFull"]) == "" || !is_object(File::getByID($args["imageFull"])))) {
            $e->add(t("The %s field is required.", t("Image Full")));
        }
        if (in_array("video", $this->btFieldsRequired) && (trim($args["video"]) == "")) {
            $e->add(t("The %s field is required.", t("Video")));
        }
        if (in_array("ImageTwo", $this->btFieldsRequired) && (trim($args["ImageTwo"]) == "" || !is_object(File::getByID($args["ImageTwo"])))) {
            $e->add(t("The %s field is required.", t("Image2")));
        }
        if (in_array("imageThree", $this->btFieldsRequired) && (trim($args["imageThree"]) == "" || !is_object(File::getByID($args["imageThree"])))) {
            $e->add(t("The %s field is required.", t("Image3")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}