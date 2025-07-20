<?php defined("C5_EXECUTE") or die("Access Denied.");
$ih = new \Application\Concrete\Helpers\ImageHelper();
$thumbnailOne = "";
$thumbnailTwo = "";
?>


























<section class="des-brand-area pb-140 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
    <?php if (isset($title) && trim($title) != "") { ?>

        <div class="container container-1510">
            <div class="row">
                <div class="col-xl-6">
                    <div class="des-brand-title-box mb-40">
                        <h3 class="tp-section-title-mango mb-0"><?php echo h($title); ?></h3>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
    <div class="des-brand-moving-wrap">
        <?php if (!empty($rowOne_items)) { ?>
            <div class="des-brand-moving-top moving-text pb-10">
                <div class="des-brand-item wrapper-text black-style d-flex align-items-center">
                    <?php foreach ($rowOne_items as $rowOne_item_key => $rowOne_item) { ?>
                        <?php if ($rowOne_item["imageOne"]) {
                            $thumbnailOne = $ih->getThumbnail($rowOne_item["imageOne"], 500, 500);
                        ?>
                            <div class="des-brand-item-inner">
                                <img src="<?php echo $thumbnailOne ?>" alt="<?php echo $rowOne_item["imageOne"]->getTitle(); ?>">
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="des-brand-moving-bottom moving-text">
            <?php if (!empty($rowTwo_items)) { ?>

                <div class="des-brand-item wrapper-text black-style d-flex align-items-center">
                    <?php foreach ($rowTwo_items as $rowTwo_item_key => $rowTwo_item) { ?>
                        <?php if ($rowTwo_item["imageTwo"]) { 
                            $thumbnailTwo = $ih->getThumbnail($rowTwo_item["imageTwo"], 500, 500);
                        ?>
                            <div class="des-brand-item-inner">
                                <img src="<?php echo $thumbnailTwo ?>" alt="<?php echo $rowTwo_item["imageTwo"]->getTitle(); ?>">
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>