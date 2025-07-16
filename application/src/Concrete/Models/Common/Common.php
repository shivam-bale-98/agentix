<?php

namespace Application\Concrete\Models\Common;

use Concrete\Core\Entity\File\File;
use Concrete\Core\File\Image\BasicThumbnailer;
use Concrete\Core\Html\Image;
use Concrete\Core\Localization\Service\Date;
use Application\Concrete\Page\Page;
use Concrete\Theme\Concrete\PageTheme;
use Core;
use Application\Concrete\Helpers\ImageHelper;

abstract class Common
{
    protected $id;
    protected $name;
    protected $url;
    protected $collection_description;
    protected $thumbnail;
    protected $banner;
    protected $public_date;
    protected $collectionObject;

    /**
     * Author constructor.
     *
     * @param Page| \Application\Concrete\Page\Page $page
     */
    public function __construct($page)
    {
        $this->collectionObject = $page;
    }

    /**
     * @return Page | \Application\Concrete\Page\Page
     */
    public function getCollectionObject()
    {
        return $this->collectionObject;
    }

    public function getID()
    {
        if (!$this->id) {
            $this->id = $this->collectionObject->getCollectionID();
        }
        return $this->id;
    }

    public function getTitle($characters = 250)
    {
        /** @var \Concrete\Core\Utility\Service\Text $th */
        $th = Core::make('helper/text');

        if (!$this->name) {
            $this->name = $th->wordSafeShortText($this->collectionObject->getCollectionName(), $characters);
        }
        return $this->name;
    }

    public function getUrl()
    {
        if (!$this->url) {
            $this->url = $this->getCollectionObject()->getCollectionLink();
        }

        return $this->url;
    }

    public function getCollectionDescription()
    {
        if (!$this->collection_description) {
            $this->collection_description = $this->collectionObject->getCollectionDescription();
        }
        return $this->collection_description;
    }

    public function getPublicDate($format ="d / m / Y" )
    {
        $dh = new Date();
        if (!$this->public_date) {
            $this->public_date = $this->collectionObject->getCollectionDatePublicObject();
        }
        return $dh->formatCustom($format, $this->public_date);
    }

    public function __call($method, $arguments)
    {
        $controller = $this->getCollectionObject();

        return call_user_func_array(array($controller, $method), $arguments);
    }

    public static function getByID($cID)
    {
        $class = get_called_class();
        $c = Page::getByID($cID);
        return $c ? new $class($c) : null;
    }

    public function getThumbnailImage($width = 400, $height = 400, $crop = false, $regenerate = false)
    {
        if (!$this->thumbnail || $regenerate) $this->thumbnail = $this->getImageAttribute('thumbnail', $width, $height, $crop);

        return $this->thumbnail;
    }

    public function getBannerImage($width = 1000, $height = 1000, $crop = false, $regenerate = false)
    {
        if (!$this->banner || $regenerate) $this->banner = $this->getImageAttribute('banner_image', $width, $height, $crop);

        return $this->banner;
    }

    public function getImageAttribute($handle, $width = 1000, $height = 1000, $crop = false) {
        $image = $this->getAttribute($handle);
        return ImageHelper::getThumbnail($image, $width, $height, $crop);
    }
}