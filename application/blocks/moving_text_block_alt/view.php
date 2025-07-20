<?php defined("C5_EXECUTE") or die("Access Denied."); ?>















<!-- text moving area start -->
<?php if (!empty($movingText_items)) { ?>
    <section class="des-text-moving-area pt-100 pb-160 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
        <?php foreach ($movingText_items as $movingText_item_key => $movingText_item) { ?>
            <?php $cssClass = ($movingText_item_key % 2 == 0) ? 'des-text-moving-top' : 'des-text-moving-bottom'; ?>
            <div class="<?php echo $cssClass; ?> moving-text sm:!-translate-y-11 first-of-type:!translate-y-0 relative">

                <div class="des-text-item wrapper-text d-flex align-items-center [&>p]:flex">
                    
                    <?php if (isset($movingText_item["text"]) && trim($movingText_item["text"]) != "") { ?>
                        <?php echo $movingText_item["text"]; ?>
                        <!-- <span>Digital Experience</span>
                    <span>Online Interaction</span> -->
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </section>
<?php } ?>
<!-- text moving area end -->