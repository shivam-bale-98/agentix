<?php namespace Application\Block\ThreeColumnGalleryBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use File;
use Page;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btExportFileColumns = ['cardOneImage', 'logo', 'cardTwoImage', 'cardThreeImage', 'cardFourImage', 'imageRight'];
    protected $btTable = 'btThreeColumnGalleryBlock';
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
        return t("Three Column Gallery Block");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->cardTitle;
        $content[] = $this->cardSubtitle;
        $content[] = $this->cardThreeVideo;
        return implode(" ", $content);
    }

    public function view()
    {
        
        if ($this->cardOneImage && ($f = File::getByID($this->cardOneImage)) && is_object($f)) {
            $this->set("cardOneImage", $f);
        } else {
            $this->set("cardOneImage", false);
        }
        
        if ($this->logo && ($f = File::getByID($this->logo)) && is_object($f)) {
            $this->set("logo", $f);
        } else {
            $this->set("logo", false);
        }
        $link_URL = null;
		$link_Object = null;
		$link_Title = trim($this->link_Title);
		if (trim($this->link) != '') {
			switch ($this->link) {
				case 'page':
					if ($this->link_Page > 0 && ($link_Page_c = Page::getByID($this->link_Page)) && !$link_Page_c->error && !$link_Page_c->isInTrash()) {
						$link_Object = $link_Page_c;
						$link_URL = $link_Page_c->getCollectionLink();
						if ($link_Title == '') {
							$link_Title = $link_Page_c->getCollectionName();
						}
					}
					break;
				case 'url':
					$link_URL = $this->link_URL;
					if ($link_Title == '') {
						$link_Title = $link_URL;
					}
					break;
				case 'relative_url':
					$link_URL = $this->link_Relative_URL;
					if ($link_Title == '') {
						$link_Title = $this->link_Relative_URL;
					}
					break;
			}
		}
		$this->set("link_URL", $link_URL);
		$this->set("link_Object", $link_Object);
		$this->set("link_Title", $link_Title);
        
        if ($this->cardTwoImage && ($f = File::getByID($this->cardTwoImage)) && is_object($f)) {
            $this->set("cardTwoImage", $f);
        } else {
            $this->set("cardTwoImage", false);
        }
        
        if ($this->cardThreeImage && ($f = File::getByID($this->cardThreeImage)) && is_object($f)) {
            $this->set("cardThreeImage", $f);
        } else {
            $this->set("cardThreeImage", false);
        }
        
        if ($this->cardFourImage && ($f = File::getByID($this->cardFourImage)) && is_object($f)) {
            $this->set("cardFourImage", $f);
        } else {
            $this->set("cardFourImage", false);
        }
        
        if ($this->imageRight && ($f = File::getByID($this->imageRight)) && is_object($f)) {
            $this->set("imageRight", $f);
        } else {
            $this->set("imageRight", false);
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
        $this->set("link_Options", $this->getSmartLinkTypeOptions([
  'page',
  'url',
  'relative_url',
], true));
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        if (!isset($args["hideBlock"]) || trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1])) {
            $args["hideBlock"] = '';
        }
        $args['cardOneImage'] = isset($args['cardOneImage']) && is_numeric($args['cardOneImage']) ? $args['cardOneImage'] : 0;
        $args['logo'] = isset($args['logo']) && is_numeric($args['logo']) ? $args['logo'] : 0;
        if (isset($args["link"]) && trim($args["link"]) != '') {
			switch ($args["link"]) {
				case 'page':
					$args["link_File"] = '0';
					$args["link_URL"] = '';
					$args["link_Relative_URL"] = '';
					$args["link_Image"] = '0';
					break;
				case 'url':
					$args["link_Page"] = '0';
					$args["link_Relative_URL"] = '';
					$args["link_File"] = '0';
					$args["link_Image"] = '0';
					break;
				case 'relative_url':
					$args["link_Page"] = '0';
					$args["link_URL"] = '';
					$args["link_File"] = '0';
					$args["link_Image"] = '0';
					break;
				default:
					$args["link_Title"] = '';
					$args["link_Page"] = '0';
					$args["link_File"] = '0';
					$args["link_URL"] = '';
					$args["link_Relative_URL"] = '';
					$args["link_Image"] = '0';
					break;	
			}
		}
		else {
			$args["link_Title"] = '';
			$args["link_Page"] = '0';
			$args["link_File"] = '0';
			$args["link_URL"] = '';
			$args["link_Relative_URL"] = '';
			$args["link_Image"] = '0';
		}
        $args['cardTwoImage'] = isset($args['cardTwoImage']) && is_numeric($args['cardTwoImage']) ? $args['cardTwoImage'] : 0;
        $args['cardThreeImage'] = isset($args['cardThreeImage']) && is_numeric($args['cardThreeImage']) ? $args['cardThreeImage'] : 0;
        $args['cardFourImage'] = isset($args['cardFourImage']) && is_numeric($args['cardFourImage']) ? $args['cardFourImage'] : 0;
        $args['imageRight'] = isset($args['imageRight']) && is_numeric($args['imageRight']) ? $args['imageRight'] : 0;
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("hideBlock", $this->btFieldsRequired) && (trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1]))) {
            $e->add(t("The %s field is required.", t("Hide Block")));
        }
        if (in_array("cardOneImage", $this->btFieldsRequired) && (trim($args["cardOneImage"]) == "" || !is_object(File::getByID($args["cardOneImage"])))) {
            $e->add(t("The %s field is required.", t("Card One Image (350X430)")));
        }
        if (in_array("logo", $this->btFieldsRequired) && (trim($args["logo"]) == "" || !is_object(File::getByID($args["logo"])))) {
            $e->add(t("The %s field is required.", t("Logo (20x20)")));
        }
        if (in_array("cardTitle", $this->btFieldsRequired) && (trim($args["cardTitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Card Title")));
        }
        if (in_array("cardSubtitle", $this->btFieldsRequired) && (trim($args["cardSubtitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Card Subtitle")));
        }
        if ((in_array("link", $this->btFieldsRequired) && (!isset($args["link"]) || trim($args["link"]) == "")) || (isset($args["link"]) && trim($args["link"]) != "" && !array_key_exists($args["link"], $this->getSmartLinkTypeOptions(['page', 'url', 'relative_url'])))) {
			$e->add(t("The %s field has an invalid value.", t("Link")));
		} elseif (array_key_exists($args["link"], $this->getSmartLinkTypeOptions(['page', 'url', 'relative_url']))) {
			switch ($args["link"]) {
				case 'page':
					if (!isset($args["link_Page"]) || trim($args["link_Page"]) == "" || $args["link_Page"] == "0" || (($page = Page::getByID($args["link_Page"])) && $page->error !== false)) {
						$e->add(t("The %s field for '%s' is required.", t("Page"), t("Link")));
					}
					break;
				case 'url':
					if (!isset($args["link_URL"]) || trim($args["link_URL"]) == "" || !filter_var($args["link_URL"], FILTER_VALIDATE_URL)) {
						$e->add(t("The %s field for '%s' does not have a valid URL.", t("URL"), t("Link")));
					}
					break;
				case 'relative_url':
					if (!isset($args["link_Relative_URL"]) || trim($args["link_Relative_URL"]) == "") {
						$e->add(t("The %s field for '%s' is required.", t("Relative URL"), t("Link")));
					}
					break;	
			}
		}
        if (in_array("cardTwoImage", $this->btFieldsRequired) && (trim($args["cardTwoImage"]) == "" || !is_object(File::getByID($args["cardTwoImage"])))) {
            $e->add(t("The %s field is required.", t("Card Two Image (350X430)")));
        }
        if (in_array("cardThreeVideo", $this->btFieldsRequired) && trim($args["cardThreeVideo"]) == "") {
            $e->add(t("The %s field is required.", t("Card Three Video (350X430)")));
        }
        if (in_array("cardThreeImage", $this->btFieldsRequired) && (trim($args["cardThreeImage"]) == "" || !is_object(File::getByID($args["cardThreeImage"])))) {
            $e->add(t("The %s field is required.", t("Card Three Image (optional)(350X430)")));
        }
        if (in_array("cardFourImage", $this->btFieldsRequired) && (trim($args["cardFourImage"]) == "" || !is_object(File::getByID($args["cardFourImage"])))) {
            $e->add(t("The %s field is required.", t("Card Four Image (350X430)")));
        }
        if (in_array("imageRight", $this->btFieldsRequired) && (trim($args["imageRight"]) == "" || !is_object(File::getByID($args["imageRight"])))) {
            $e->add(t("The %s field is required.", t("ImageRight (700X900)")));
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

    protected function getSmartLinkTypeOptions($include = [], $checkNone = false)
	{
		$options = [
			''             => sprintf("-- %s--", t("None")),
			'page'         => t("Page"),
			'url'          => t("External URL"),
			'relative_url' => t("Relative URL"),
			'file'         => t("File"),
			'image'        => t("Image")
		];
		if ($checkNone) {
            $include = array_merge([''], $include);
        }
		$return = [];
		foreach($include as $v){
		    if(isset($options[$v])){
		        $return[$v] = $options[$v];
		    }
		}
		return $return;
	}
}