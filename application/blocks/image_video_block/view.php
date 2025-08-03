<?php defined("C5_EXECUTE") or die("Access Denied.");

$ih = new \Application\Concrete\Helpers\ImageHelper();

$thumbnail = "";

if ($image) {
    $thumbnail = $ih->getThumbnail($image, 2000, 2000);
}
?>







<?php if (isset($popupVideoLink) && trim($popupVideoLink) != "") { ?>
    <?php echo h($popupVideoLink); ?>
<?php } ?>



<!-- portfolio details area start -->
<div class="tp-portfolio-details-1-area pb-140 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
    <div class="container container-1830">
        <div class="row">
            <div class="col-lg-12">
                <div class="tp-portfolio-details-1-banner hight relative">
                    <?php if (isset($smallVideoLink) && trim($smallVideoLink) != "") { ?>
                        <video class="absolute inset-0" data-speed=".8" loop="" muted="" autoplay="" playsinline="" src="<?php echo h($video); ?>"></video>

                    <?php } elseif ($image) { ?>
                        <img data-speed=".8" src="<?php echo $thumbnail ?>" alt="<?php echo $image->getTitle(); ?>">

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- portfolio details area end -->