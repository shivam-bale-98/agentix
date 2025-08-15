<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

















<div class="tp-contact-me-interest-ptb p-relative pb-28">
    <div class="container container-1230">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="tp-contact-me-interest-wrapper pb-100">
                    <?php if (isset($subtitle) && trim($subtitle) != "") { ?>
                        <!-- <h3 class="tp-contact-me-interest-title">I'm Interested in...</h3> -->
                        <h3 class="tp-contact-me-interest-title"><?php echo h($subtitle); ?></h3>
                    <?php } ?>
                    <?php if (!empty($categories_items)) { ?>

                        <div class="tp-contact-me-interest-category">
                            <?php foreach ($categories_items as $categories_item_key => $categories_item) { ?>
                                <?php if (isset($categories_item["interest"]) && trim($categories_item["interest"]) != "") { ?>

                                    <!-- <span class="tp-contact-category-btn">Branding</span> -->
                                    <span class="tp-contact-category-btn"><?php echo h($categories_item["interest"]); ?></span>
                                <?php } ?>
                            <?php } ?>
                            
                        </div>
                    <?php } ?>
                </div>
                <div class="tp-contact-me-interest-form">
                    <?php if (isset($title) && trim($title) != "") { ?>
                        <!-- <h3 class="tp-contact-me-interest-title">Request a Quote</h3> -->
                        <h3 class="tp-contact-me-interest-title"><?php echo h($title); ?></h3>
                    <?php } ?>
                    <div class="tp-contact-me-interest-form-wrap">

                        <?php $s = Stack::getByName("Contact Form");
                          $s->display(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>