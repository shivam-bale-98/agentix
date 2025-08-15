<?php defined("C5_EXECUTE") or die("Access Denied."); ?>










<div class="app-faq-area service-faq-style p-relative pb-140 xl:pt-24 pt-12 <?php if (isset($paddingTop) && trim($paddingTop) == 1) { ?> !pt-0 <?php } ?> <?php if (isset($paddingBottom) && trim($paddingBottom) == 1) { ?> !pt-0 <?php } ?>">
    <div class="container container-1230">
        <div class="row justify-content-center">
            <?php if (isset($title) && trim($title) != "") { ?>

                <div class="col-lg-8">
                    <div class="app-faq-heading p-relative mb-80 text-center">
                        <h3 class="tp-section-title-mango fs-100">
                            <!-- Frequently asked questions -->
                            <?php echo h($title); ?>
                        </h3>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($faqs_items)) { ?>
                <div class="col-lg-12">
                    <div class="app-faq-wrap">
                        <div class="ai-faq-accordion-wrap">
                            <div class="accordion" id="accordionExample1">
                                <?php foreach ($faqs_items as $faqs_item_key => $faqs_item) { ?>
                                    <?php 
                                        $accordion_id = "collapse" . ($faqs_item_key + 1);
                                        $is_first = ($faqs_item_key === 0);
                                        $expanded_class = $is_first ? "" : "collapsed";
                                        $aria_expanded = $is_first ? "true" : "false";
                                        $collapse_class = $is_first ? "accordion-collapse collapse show" : "accordion-collapse collapse";
                                    ?>
                                    <div class="accordion-items">
                                        <?php if (isset($faqs_item["faqTitle"]) && trim($faqs_item["faqTitle"]) != "") { ?>
                                            <h2 class="accordion-header">
                                                <button class="accordion-buttons <?php echo $expanded_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $accordion_id; ?>" aria-expanded="<?php echo $aria_expanded; ?>" aria-controls="<?php echo $accordion_id; ?>">
                                                    <?php echo h($faqs_item["faqTitle"]); ?>

                                                    <span class="accordion-icon"></span>
                                                </button>
                                            </h2>
                                        <?php } ?>

                                        <div id="<?php echo $accordion_id; ?>" class="<?php echo $collapse_class; ?>" data-bs-parent="#accordionExample1">
                                            <?php if (isset($faqs_item["faqDescription"]) && trim($faqs_item["faqDescription"]) != "") { ?>

                                                <div class="accordion-body">
                                                    <?php echo $faqs_item["faqDescription"]; ?>

                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>