<?php defined("C5_EXECUTE") or die("Access Denied."); ?>









<section class="tp-work-area pt-120 pb-145 tp-panel-pin-area <?php if (isset($paddingTop) && trim($paddingTop) == 1) { ?> !pt-0 <?php } ?> <?php if (isset($paddingBottom) && trim($paddingBottom) == 1) { ?> !pb-0 <?php } ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="tp-work-title-box tp-panel-pin">
                    <?php if (isset($subtitle) && trim($subtitle) != "") { ?>
                        <span class="tp-section-subtitle pre mb-20"><?php echo h($subtitle); ?></span>
                    <?php } ?>
                    <?php if (isset($title) && trim($title) != "") { ?>
                        <?php echo $title; ?>
                        <!-- <h2 class="tp-section-title fs-140">Our <br> design thinking process</h2> -->
                    <?php } ?>
                </div>
            </div>
            <?php if (!empty($features_items)) { ?>
                <div class="col-lg-6">
                    <div class="tp-work-wrapper">
                        <?php foreach ($features_items as $features_item_key => $features_item) { ?>

                            <div class="tp-work-item tp-panel-pin mb-15">
                                <div class="tp-work-number p-relative">
                                    <span></span>
                                    <i><?php echo str_pad($features_item_key + 1, 2, '0', STR_PAD_LEFT); ?></i>
                                </div>
                                <div class="tp-work-content">
                                    <?php if (isset($features_item["featureTitle"]) && trim($features_item["featureTitle"]) != "") { ?>
                                        <h4 class="tp-work-title"> <?php echo h($features_item["featureTitle"]); ?>
                                        </h4>
                                    <?php } ?>
                                    <?php if (isset($features_item["featureDescription"]) && trim($features_item["featureDescription"]) != "") { ?>

                                        <?php echo $features_item["featureDescription"]; ?>

                                    <?php } ?>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>