<?php namespace Application\Block\ServiceBannerText;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btTable = 'btServiceBannerText';
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
        return t("Service Banner Text");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->textOne;
        $content[] = $this->textTwo;
        $content[] = $this->scrollToId;
        return implode(" ", $content);
    }

    public function view()
    {
        $this->set('textTwo', LinkAbstractor::translateFrom($this->textTwo));
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('textTwo', LinkAbstractor::translateFromEditMode($this->textTwo));
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
        $args['textTwo'] = LinkAbstractor::translateTo($args['textTwo']);
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("textOne", $this->btFieldsRequired) && (trim($args["textOne"]) == "")) {
            $e->add(t("The %s field is required.", t("Text 1")));
        }
        if (in_array("textTwo", $this->btFieldsRequired) && (trim($args["textTwo"]) == "")) {
            $e->add(t("The %s field is required.", t("text 2")));
        }
        if (in_array("scrollToId", $this->btFieldsRequired) && (trim($args["scrollToId"]) == "")) {
            $e->add(t("The %s field is required.", t("ScrollToId")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}