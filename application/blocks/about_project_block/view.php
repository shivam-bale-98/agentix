<?php defined("C5_EXECUTE") or die("Access Denied."); ?>















<!-- portfolio details about start -->
<div class="tp-portfolio-details-1-about-ptb pb-150 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
    <div class="container container-1230">
        <div class="row">
            <div class="col-xl-6 col-lg-5">
                <?php if (isset($subtitle) && trim($subtitle) != "") { ?>
                    <div class="tp-pd-1-about-heading tp_fade_anim" data-delay=".3">
                        <span class="tp-pd-1-about-title">
                            
                            <?php echo str_replace(['<p>', '</p>'], '', $subtitle); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="102" height="9" viewBox="0 0 102 9" fill="none">
                                <path d="M98 7.91996L101.5 4.43813L98 0.956299M1 3.99989H101V4.99989H1V3.99989Z" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                <?php } ?>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="tp-portfolio-details-1-about-content">
                    <?php if (isset($description_1) && trim($description_1) != "") { ?>
                        <h3 class="tp-pd-1-about-text">
                            <?php echo h($description_1); ?>
                        </h3>
                    <?php } ?>
                    <?php if (!empty($listItems_items)) { ?>
                        <div class="tp-pd-1-about-list">
                            <ul>
                                <?php foreach ($listItems_items as $listItems_item_key => $listItems_item) { ?>

                                    <?php if (isset($listItems_item["item"]) && trim($listItems_item["item"]) != "") { ?>
                                        <li><?php echo h($listItems_item["item"]); ?></li>
                                    <?php } ?>

                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- portfolio details about end -->