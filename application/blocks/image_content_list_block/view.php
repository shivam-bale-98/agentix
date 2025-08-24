<?php defined("C5_EXECUTE") or die("Access Denied.");

$ih = new \Application\Concrete\Helpers\ImageHelper();

$thumbnail = "";

if ($image) {
    $thumbnail = $ih->getThumbnail($image, 2000, 2000);
}

?>



<? //php if (isset($videoLink) && trim($videoLink) != "") { 
?>
<? //php echo h($videoLink); 
?>
<? //php } 
?>



















<section class="<?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?> des-project-area sm:pb-[6.25rem] pb-[3.75rem]">
    <?php if ($image) { ?>
    <div class="des-project-banner">
        <img class="w-100" data-speed=".7" src="<?php echo $thumbnail ?>" alt="<?php echo h($title); ?>">
    </div>
    <?php } ?>
    <?php if (isset($title) && trim($title) != "") { ?>
        <div class="container container-1510">
            <div class="des-project-title-wrap xl:!pb-20 !pb-10  xl:!pt-24 !pt-10">
                <div class="row align-items-center">
                    <div class="col-xxl-6 col-xl-5">
                        <div class="des-project-title-box">
                            <?php if (isset($subTitle) && trim($subTitle) != "") { ?>

                                <span class="tp-section-subtitle text-capitalize text-white mb-15"><?php echo h($subTitle); ?></span>

                            <?php } ?>

                            <?php if (isset($title) && trim($title) != "") { ?>

                                <h3 class="tp-section-title-mango mb-0"><?php echo h($title); ?></h3>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-7">
                        <?php if (isset($content) && trim($content) != "") { ?>

                            <div class="des-project-top-text">

                                <?php echo $content; ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="des-project-wrap">
                <div class="row">
                    <?php if (!empty($features_items)) { ?>
                        <?php foreach ($features_items as $features_item_key => $features_item) { ?>
                            <div class="col-xxl-6 offset-xxl-6 col-xl-7 offset-xl-5">
                                <div class="des-project-item d-flex align-items-center">
                                    <?php if (isset($features_item["value"]) && trim($features_item["value"]) != "") { ?>

                                        <div class="des-project-total">
                                            <span><i data-purecounter-duration="1" data-purecounter-end="<?php echo h($features_item["value"]); ?>" class="purecounter">0</i><?php echo h($features_item["surfix"]); ?></span>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($features_item["info"]) && trim($features_item["info"]) != "") { ?>

                                        <div class="des-project-info">
                                            <!-- <span>[ Nice! ]</span>
                                        <h4>Projects Completed</h4> -->
                                            <?php echo $features_item["info"]; ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    <?php } ?>
</section>