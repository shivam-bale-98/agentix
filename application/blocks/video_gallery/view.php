<?php defined("C5_EXECUTE") or die("Access Denied."); 

$ih = new \Application\Concrete\Helpers\ImageHelper();
$thumbnail = "";
?>














<!-- video area start -->
<?php if (!empty($gallery_items)) { ?>
    <div class="tp-video-area black-bg mt-120 fix <?php if (isset($paddingTop) && trim($paddingTop) == 1) { ?> !mt-0 <?php } ?>">
        <div class="container-fluid p-0">
            <div class="tp-video-thumb-wrap">
                <?php foreach ($gallery_items as $gallery_item_key => $gallery_item) { ?>
                    <?php if (isset($gallery_item["videoLink"]) && trim($gallery_item["videoLink"]) != "") { ?>
                        <div class="tp-video-thumb mb-25">
                            <!-- <img src="assets/img/home-01/video/video-1.jpg" alt=""> -->
                            <video loop="" muted="" autoplay="" playsinline="">
                                <!-- <source src="https://html.aqlova.com/videos/liko/liko.mp4" type="video/mp4"> -->
                                <source src="<?php echo $gallery_item["videoLink"]; ?>" type="video/mp4">
                            </video>
                        </div>
                    <?php } else { ?>
                        <?php if ($gallery_item["image"]) { 
                              $thumbnail = $ih->getThumbnail($gallery_item["image"], 1000, 1000);    
                        ?>
                            <div class="tp-video-thumb d-none d-xl-block mb-25">
                                <img src="<?php echo $thumbnail ?>" alt="<?php echo $gallery_item["image"]->getTitle(); ?>">
                            </div>
                        <?php } ?>
                    <?php } ?>


                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- video area end -->