<?php
namespace Application\Concrete\Helpers;

use Concrete\Core\Entity\File\File;
use Concrete\Theme\Concrete\PageTheme;
use Core;

class ImageHelper
{

    public static function getAbsPathFromDoctrineFileObj($img)
    {
        $file_storage       = $img->getFileStorageLocationObject();
        $path1              =$file_storage->getConfigurationObject()->getRootPath();
        $path_2             =$img->getFileResource()->getPath();
        $orig_file_abs_path = $path1 .'/'.$path_2;
        return $orig_file_abs_path;
    }

    public static function getAbsPathFromImageUrl($url_path)
    {
        //get thumb path form thumb url path
        $obj_parms = parse_url($url_path);
        $thumb_path = $obj_parms['path'];
        $cache_thumb_abs_path = $_SERVER['DOCUMENT_ROOT'].$thumb_path;
        return $cache_thumb_abs_path;
    }

    public static function getThumbnail($image, $width = 1800, $height = 1800, $crop = false)
    {
        /** @var File $image */
        /** @var \Concrete\Core\File\Image\BasicThumbnailer $ih */
        $ih = Core::make('helper/image');

        $thumbnail = null;

        if ($image instanceof File) {
            $extension = $image->getExtension();
            if($extension == 'svg') return $image->getURL();

            $image = $ih->getThumbnail($image, $width, $height, $crop);
            $thumbnail = $image?->src;
        }

        if (!$thumbnail) {
            $thumbnail = BASE_URL . PageTheme::getSiteTheme()->getThemeURL() . '/assets/images/placeholder.jpg';
        }

        return $thumbnail;
    }

    public static function getPlatformImage($image, $width = 1800, $height = 1800, $crop = false)
    {
        /** @var File $image */
        /** @var \Concrete\Core\File\Image\BasicThumbnailer $ih */
        $ih = Core::make('helper/image');
        $md = new \Mobile_Detect();

        $thumbnail = null;

        if ($image instanceof File) {
            if ($md->isMobile()) {
                $im = $image->getAttribute('mobile_version');

                if ($im instanceof File) {
                    $im = $ih->getThumbnail($im, $width, $height, $crop);
                }

                if ($im) {
                    $thumbnail = $im->src;
                }

                if (!$thumbnail) {
                    $image = $ih->getThumbnail($image, $width, $height, $crop);
                    $thumbnail = $image->src;
                }
            }
        }

        if (!$thumbnail) {
            $thumbnail = BASE_URL . PageTheme::getSiteTheme()->getThemeURL() . '/assets/images/placeholder.jpg';
        }

        return $thumbnail;
    }
}