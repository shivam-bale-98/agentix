<?php


$c = Page::getCurrentPage();

use  \Application\Concrete\Helpers\ImageHelper;

$ih = new ImageHelper();

$title = $c->getCollectionName();
$banner_attribute = $c->getAttribute('banner_image');
$banner_image = $ih->getThumbnail($banner_attribute, 2000, 2000, false);
$banner_mobile_attribute = $c->getAttribute('mobile_banner');
$banner_mobile_image = $ih->getThumbnail($banner_mobile_attribute, 1000, 1000, false);

$logo_attribute = $c->getAttribute('logo');
$logo = $ih->getThumbnail($logo_attribute, 200, 200, false);
$description = $c->getCollectionDescription();
?>


<section class="tp-portfolio-details-1-area pt-[8.75rem]  xl:pb-[6.25rem] pb-[3.125rem] z-[2] relative">
    <div class="container container-1830 z-[1] relative">
        <div class="row">
            <div class="col-lg-12">
                <div class="tp-portfolio-details-1-banner ">
                    <img class="max-sm:hidden z-[1] relative h-[120%]" data-speed=".8" src="<?php echo $banner_image ?>" alt="<?php echo h($title) ?>">

                    <img class="sm:hidden z-[1] scale-125" data-speed=".8" src="<?php echo $banner_mobile_image ?>" alt="<?php echo h($title) ?>">
                </div>
            </div>
        </div>

        <div class="absolute xl:size-36 size-24 bg-white rounded-full xl:top-[calc(50%-4.5rem)] top-[calc(50%-3rem)] xl:left-[calc(50%-4.5rem)] left-[calc(50%-3rem)]  z-[2] xl:p-4 p-2">
            <img class="w-full h-full object-contain" src="<?php echo $logo ?>" alt="<?php echo h($title) ?>">
        </div>
    </div>


</section>


<?php $a = new Area('Inner Page Content');
$a->display($c); ?>