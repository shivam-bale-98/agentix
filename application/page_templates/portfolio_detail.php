<?php


$c = Page::getCurrentPage();

use  \Application\Concrete\Helpers\ImageHelper;

$ih = new ImageHelper();

$title = $c->getCollectionName();
$banner_attribute = $c->getAttribute('banner_image');
$banner_image = $ih->getThumbnail($banner_attribute, 2000, 2000, false);
$banner_mobile_attribute = $c->getAttribute('mobile_banner');
$banner_mobile_image = $ih->getThumbnail($banner_mobile_attribute, 1000, 1000, false);
$description = $c->getCollectionDescription();
?>


<section class="tp-portfolio-details-1-area pt-110 pb-140">
    <div class="container container-1830">
        <div class="row">
            <div class="col-lg-12">
                <div class="tp-portfolio-details-1-banner">
                    <img class="max-sm:hidden" data-speed=".8" src="<?php echo $banner_image ?>" alt="<?php echo h($title) ?>">

                    <img class="sm:hidden" data-speed=".8" src="<?php echo $banner_mobile_image ?>" alt="<?php echo h($title) ?>">
                </div>
            </div>
        </div>
    </div>
</section>


<?php $a = new Area('Inner Page Content');
$a->display($c); ?>

















