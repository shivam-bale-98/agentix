<?php defined("C5_EXECUTE") or die("Access Denied."); ?>





















<!-- portfolio details work start -->
<div class="tp-pd-1-work-ptb pb-130">
    <div class="container container-1230">
        <div class="tp-pd-1-work-top pb-70">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (isset($title) && trim($title) != "") { ?>
                        <div class="tp-pd-1-work-heading pb-60 tp_fade_anim " data-delay=".3">
                            <?php echo $title; ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <div class="tp-pd-1-work-heading tp_fade_anim" data-delay=".5">
                        <?php if (isset($subtitle) && trim($subtitle) != "") { ?>
                            <span class="tp-pd-1-about-title">

                                <?php echo str_replace(['<p>', '</p>'], '', $subtitle); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="102" height="9" viewBox="0 0 102 9" fill="none">
                                    <path d="M98 7.91996L101.5 4.43813L98 0.956299M1 3.99989H101V4.99989H1V3.99989Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php if (isset($description_1) && trim($description_1) != "") { ?>
                        <div class="tp-pd-1-work-content pl-20 tp_fade_anim" data-delay=".5">
                            <?php echo $description_1; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if (!empty($features_items)) { ?>
            <div class="row">
                <?php foreach ($features_items as $features_item_key => $features_item) { ?>

                    <div class="col-lg-6">
                        <div class="tp-pd-1-work-item mb-30">
                            <?php if (isset($features_item["value"]) && trim($features_item["value"]) != "") { ?>

                                <h3 class="tp-pd-1-work-item-title">
                                    <span><i data-purecounter-duration="2" data-purecounter-end="<?php echo h($features_item["value"]); ?>" class="purecounter">0</i><?php echo h($features_item["prefix"]); ?></span>
                                </h3>
                            <?php } ?>
                            <?php if (isset($features_item["title"]) && trim($features_item["title"]) != "") { ?>

                                <div class="tp-pd-1-work-item-text">
                                    <span><?php echo h($features_item["title"]); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<!-- portfolio details work end -->