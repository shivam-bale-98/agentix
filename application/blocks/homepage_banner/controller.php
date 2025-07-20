<?php namespace Application\Block\HomepageBanner;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use File;
use Page;
use Permissions;
use URL;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btExportFileColumns = ['imageOne', 'imageTwo', 'imageThree', 'imageFour', 'imageFive', 'imageSix', 'imageSeven', 'imageEight'];
    protected $btTable = 'btHomepageBanner';
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
        return t("Homepage Banner");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $content[] = $this->featureTitle;
        $content[] = $this->featureValue;
        return implode(" ", $content);
    }

    public function view()
    {
        $this->set('title', LinkAbstractor::translateFrom($this->title));
        $linkTag_URL = null;
		$linkTag_Object = null;
		$linkTag_Title = trim($this->linkTag_Title);
		if (trim($this->linkTag) != '') {
			switch ($this->linkTag) {
				case 'page':
					if ($this->linkTag_Page > 0 && ($linkTag_Page_c = Page::getByID($this->linkTag_Page)) && !$linkTag_Page_c->error && !$linkTag_Page_c->isInTrash()) {
						$linkTag_Object = $linkTag_Page_c;
						$linkTag_URL = $linkTag_Page_c->getCollectionLink();
						if ($linkTag_Title == '') {
							$linkTag_Title = $linkTag_Page_c->getCollectionName();
						}
					}
					break;
				case 'file':
					$linkTag_File_id = (int)$this->linkTag_File;
					if ($linkTag_File_id > 0 && ($linkTag_File_object = File::getByID($linkTag_File_id)) && is_object($linkTag_File_object)) {
						$fp = new Permissions($linkTag_File_object);
						if ($fp->canViewFile()) {
							$linkTag_Object = $linkTag_File_object;
							$linkTag_URL = $linkTag_File_object->getRelativePath();
							if (($c = Page::getCurrentPage()) && $c instanceof Page) {
		                        $linkTag_URL = URL::to('/download_file', $linkTag_File_id, $c->getCollectionID());
		                    }
							if ($linkTag_Title == '') {
								$linkTag_Title = $linkTag_File_object->getTitle();
							}
						}
					}
					break;
				case 'url':
					$linkTag_URL = $this->linkTag_URL;
					if ($linkTag_Title == '') {
						$linkTag_Title = $linkTag_URL;
					}
					break;
				case 'relative_url':
					$linkTag_URL = $this->linkTag_Relative_URL;
					if ($linkTag_Title == '') {
						$linkTag_Title = $this->linkTag_Relative_URL;
					}
					break;
				case 'image':
					if ($this->linkTag_Image && ($linkTag_Image_object = File::getByID($this->linkTag_Image)) && is_object($linkTag_Image_object)) {
						$linkTag_URL = $linkTag_Image_object->getURL();
						$linkTag_Object = $linkTag_Image_object;
						if ($linkTag_Title == '') {
							$linkTag_Title = $linkTag_Image_object->getTitle();
						}
					}
					break;
			}
		}
		$this->set("linkTag_URL", $linkTag_URL);
		$this->set("linkTag_Object", $linkTag_Object);
		$this->set("linkTag_Title", $linkTag_Title);
        
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
        
        if ($this->imageThree && ($f = File::getByID($this->imageThree)) && is_object($f)) {
            $this->set("imageThree", $f);
        } else {
            $this->set("imageThree", false);
        }
        
        if ($this->imageFour && ($f = File::getByID($this->imageFour)) && is_object($f)) {
            $this->set("imageFour", $f);
        } else {
            $this->set("imageFour", false);
        }
        
        if ($this->imageFive && ($f = File::getByID($this->imageFive)) && is_object($f)) {
            $this->set("imageFive", $f);
        } else {
            $this->set("imageFive", false);
        }
        
        if ($this->imageSix && ($f = File::getByID($this->imageSix)) && is_object($f)) {
            $this->set("imageSix", $f);
        } else {
            $this->set("imageSix", false);
        }
        
        if ($this->imageSeven && ($f = File::getByID($this->imageSeven)) && is_object($f)) {
            $this->set("imageSeven", $f);
        } else {
            $this->set("imageSeven", false);
        }
        
        if ($this->imageEight && ($f = File::getByID($this->imageEight)) && is_object($f)) {
            $this->set("imageEight", $f);
        } else {
            $this->set("imageEight", false);
        }
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('title', LinkAbstractor::translateFromEditMode($this->title));
    }

    protected function addEdit()
    {
        $this->set("linkTag_Options", $this->getSmartLinkTypeOptions([
  'page',
  'file',
  'image',
  'url',
  'relative_url',
], true));
        $this->requireAsset('redactor');
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        if (!isset($args["hideBlock"]) || trim($args["hideBlock"]) == "" || !in_array($args["hideBlock"], [0, 1])) {
            $args["hideBlock"] = '';
        }
        $args['title'] = LinkAbstractor::translateTo($args['title']);
        if (isset($args["linkTag"]) && trim($args["linkTag"]) != '') {
			switch ($args["linkTag"]) {
				case 'page':
					$args["linkTag_File"] = '0';
					$args["linkTag_URL"] = '';
					$args["linkTag_Relative_URL"] = '';
					$args["linkTag_Image"] = '0';
					break;
				case 'file':
					$args["linkTag_Page"] = '0';
					$args["linkTag_URL"] = '';
					$args["linkTag_Relative_URL"] = '';
					$args["linkTag_Image"] = '0';
					break;
				case 'url':
					$args["linkTag_Page"] = '0';
					$args["linkTag_Relative_URL"] = '';
					$args["linkTag_File"] = '0';
					$args["linkTag_Image"] = '0';
					break;
				case 'relative_url':
					$args["linkTag_Page"] = '0';
					$args["linkTag_URL"] = '';
					$args["linkTag_File"] = '0';
					$args["linkTag_Image"] = '0';
					break;
				case 'image':
					$args["linkTag_Page"] = '0';
					$args["linkTag_File"] = '0';
					$args["linkTag_URL"] = '';
					$args["linkTag_Relative_URL"] = '';
					break;
				default:
					$args["linkTag_Title"] = '';
					$args["linkTag_Page"] = '0';
					$args["linkTag_File"] = '0';
					$args["linkTag_URL"] = '';
					$args["linkTag_Relative_URL"] = '';
					$args["linkTag_Image"] = '0';
					break;	
			}
		}
		else {
			$args["linkTag_Title"] = '';
			$args["linkTag_Page"] = '0';
			$args["linkTag_File"] = '0';
			$args["linkTag_URL"] = '';
			$args["linkTag_Relative_URL"] = '';
			$args["linkTag_Image"] = '0';
		}
        $args['imageOne'] = isset($args['imageOne']) && is_numeric($args['imageOne']) ? $args['imageOne'] : 0;
        $args['imageTwo'] = isset($args['imageTwo']) && is_numeric($args['imageTwo']) ? $args['imageTwo'] : 0;
        $args['imageThree'] = isset($args['imageThree']) && is_numeric($args['imageThree']) ? $args['imageThree'] : 0;
        $args['imageFour'] = isset($args['imageFour']) && is_numeric($args['imageFour']) ? $args['imageFour'] : 0;
        $args['imageFive'] = isset($args['imageFive']) && is_numeric($args['imageFive']) ? $args['imageFive'] : 0;
        $args['imageSix'] = isset($args['imageSix']) && is_numeric($args['imageSix']) ? $args['imageSix'] : 0;
        $args['imageSeven'] = isset($args['imageSeven']) && is_numeric($args['imageSeven']) ? $args['imageSeven'] : 0;
        $args['imageEight'] = isset($args['imageEight']) && is_numeric($args['imageEight']) ? $args['imageEight'] : 0;
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
        if (in_array("featureTitle", $this->btFieldsRequired) && (trim($args["featureTitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Feature Title")));
        }
        if (in_array("featureValue", $this->btFieldsRequired) && (trim($args["featureValue"]) == "")) {
            $e->add(t("The %s field is required.", t("Feature Value")));
        }
        if ((in_array("linkTag", $this->btFieldsRequired) && (!isset($args["linkTag"]) || trim($args["linkTag"]) == "")) || (isset($args["linkTag"]) && trim($args["linkTag"]) != "" && !array_key_exists($args["linkTag"], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url'])))) {
			$e->add(t("The %s field has an invalid value.", t("Link Tag")));
		} elseif (array_key_exists($args["linkTag"], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url']))) {
			switch ($args["linkTag"]) {
				case 'page':
					if (!isset($args["linkTag_Page"]) || trim($args["linkTag_Page"]) == "" || $args["linkTag_Page"] == "0" || (($page = Page::getByID($args["linkTag_Page"])) && $page->error !== false)) {
						$e->add(t("The %s field for '%s' is required.", t("Page"), t("Link Tag")));
					}
					break;
				case 'file':
					if (!isset($args["linkTag_File"]) || trim($args["linkTag_File"]) == "" || !is_object(File::getByID($args["linkTag_File"]))) {
						$e->add(t("The %s field for '%s' is required.", t("File"), t("Link Tag")));
					}
					break;
				case 'url':
					if (!isset($args["linkTag_URL"]) || trim($args["linkTag_URL"]) == "" || !filter_var($args["linkTag_URL"], FILTER_VALIDATE_URL)) {
						$e->add(t("The %s field for '%s' does not have a valid URL.", t("URL"), t("Link Tag")));
					}
					break;
				case 'relative_url':
					if (!isset($args["linkTag_Relative_URL"]) || trim($args["linkTag_Relative_URL"]) == "") {
						$e->add(t("The %s field for '%s' is required.", t("Relative URL"), t("Link Tag")));
					}
					break;
				case 'image':
					if (!isset($args["linkTag_Image"]) || trim($args["linkTag_Image"]) == "" || !is_object(File::getByID($args["linkTag_Image"]))) {
						$e->add(t("The %s field for '%s' is required.", t("Image"), t("Link Tag")));
					}
					break;	
			}
		}
        if (in_array("imageOne", $this->btFieldsRequired) && (trim($args["imageOne"]) == "" || !is_object(File::getByID($args["imageOne"])))) {
            $e->add(t("The %s field is required.", t("Image 1")));
        }
        if (in_array("imageTwo", $this->btFieldsRequired) && (trim($args["imageTwo"]) == "" || !is_object(File::getByID($args["imageTwo"])))) {
            $e->add(t("The %s field is required.", t("Image 2")));
        }
        if (in_array("imageThree", $this->btFieldsRequired) && (trim($args["imageThree"]) == "" || !is_object(File::getByID($args["imageThree"])))) {
            $e->add(t("The %s field is required.", t("Image 3")));
        }
        if (in_array("imageFour", $this->btFieldsRequired) && (trim($args["imageFour"]) == "" || !is_object(File::getByID($args["imageFour"])))) {
            $e->add(t("The %s field is required.", t("Image 4 ")));
        }
        if (in_array("imageFive", $this->btFieldsRequired) && (trim($args["imageFive"]) == "" || !is_object(File::getByID($args["imageFive"])))) {
            $e->add(t("The %s field is required.", t("Image 5")));
        }
        if (in_array("imageSix", $this->btFieldsRequired) && (trim($args["imageSix"]) == "" || !is_object(File::getByID($args["imageSix"])))) {
            $e->add(t("The %s field is required.", t("Image 6")));
        }
        if (in_array("imageSeven", $this->btFieldsRequired) && (trim($args["imageSeven"]) == "" || !is_object(File::getByID($args["imageSeven"])))) {
            $e->add(t("The %s field is required.", t("Image 7")));
        }
        if (in_array("imageEight", $this->btFieldsRequired) && (trim($args["imageEight"]) == "" || !is_object(File::getByID($args["imageEight"])))) {
            $e->add(t("The %s field is required.", t("Image 8")));
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