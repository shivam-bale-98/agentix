<?php defined("C5_EXECUTE") or die("Access Denied.");

$ih = new \Application\Concrete\Helpers\ImageHelper();

$thumbnail = "";
$thumbnail2 = "";
$thumbnail3 = "";


if ($imageFull) {
    $thumbnail = $ih->getThumbnail($imageFull, 2000, 2000);
}

if ($ImageTwo) {
    $thumbnail2 = $ih->getThumbnail($ImageTwo, 1000, 1000);
}

if ($imageThree) {
    $thumbnail3 = $ih->getThumbnail($imageThree, 1000, 1000);
}
?>










<!-- portfolio details thumb area start -->
<div class="tp-portfolio-details-1-thumb-ptb pb-140 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
    <div class="container container-1830">
        <div class="row gx-20">
            <?php if (isset($video) && trim($video) != "" || $imageFull) { ?>
                <div class="col-lg-12">
                    <div class="tp-portfolio-details-1-thumb-1 mb-20">
                        <?php if (isset($video) && trim($video) != "") { ?>
                            <video loop="" muted="" autoplay="" playsinline="" src=" <?php echo h($video); ?>"></video>
                        <?php } elseif ($imageFull) { ?>
                            <img data-speed=".8" src="<?php echo $thumbnail ?>" alt="<?php echo $imageFull->getTitle(); ?>">
                        <?php  } ?>

                    </div>
                </div>
            <?php  } ?>
            <?php if ($ImageTwo) { ?>
                <div class="col-lg-6">
                    <div class="tp-portfolio-details-1-thumb-2 mb-20">
                        <img data-speed=".8" src="<?php echo $thumbnail2 ?>" alt="<?php echo $ImageTwo->getTitle(); ?>">
                    </div>
                </div>
            <?php } ?>
            <?php if ($imageThree) { ?>
                <div class="col-lg-6">
                    <div class="tp-portfolio-details-1-thumb-3 mb-20">
                        <img data-speed=".8" src="<?php echo $thumbnail3 ?>" alt="<?php echo $imageThree->getTitle(); ?>">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- portfolio details thumb area start -->