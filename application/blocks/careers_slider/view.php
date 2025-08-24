<?php defined("C5_EXECUTE") or die("Access Denied.");

$ih = new \Application\Concrete\Helpers\ImageHelper();
$thumbnailOne = "";
?>











<!-- career slider area start -->
<?php if (!empty($slider_items)) { ?>

    <div class="tp-career-slider-ptb xl:pb-[6.25rem] sm:pb-[3.75rem] <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?> <?php if (isset($PaddingBottom) && trim($PaddingBottom) == 1) { ?> !pb-0 <?php } ?>">
        <div class="tp-career-slider-wrapper">
            <div class="tp-career-slider-active swiper-container">
                <div class="swiper-wrapper align-items-center slide-transtion">
                    <?php foreach ($slider_items as $slider_item_key => $slider_item) { ?>
                        <?php if ($slider_item["image"]) {
                            $thumbnailOne = $ih->getThumbnail($slider_item["image"], 1000, 1000);
                        ?>
                            <div class="swiper-slide">
                                <div class="tp-career-slider-thumb">
                                    <img src="<?php echo $thumbnailOne ?>" alt="<?php echo $slider_item["image"]->getTitle(); ?>">
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- career slider area end -->