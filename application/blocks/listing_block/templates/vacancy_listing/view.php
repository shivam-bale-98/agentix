<?php defined("C5_EXECUTE") or die("Access Denied."); ?>



<section class="tp-career-opening-ptb sm:pb-[6.25rem] pb-[3.75rem]">
    <div class="container container-1230">




        <!-- link -->
        <? //php if (isset($button_URL) && isset($button_Title)) { 
        ?>
        <!-- <a href="<? //php echo $button_URL; 
                        ?>"><? //php echo $button_Title; 
                            ?></a> -->
        <? //php } 
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="tp-benefit-heading xmd:!mb-[6.25rem] !mb-0">
                    <div class="ar-about-us-4-title-box shape-color tp_fade_anim d-flex align-items-center mb-15">
                        <span class="tp-section-subtitle pre">
                            <!--  -->
                            <?php echo $button_Title; ?>
                        </span>
                        <div class="ar-about-us-4-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                <rect y="4" width="80" height="1" fill="#ffffffba" />
                                <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#ffffffba" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <?php if (isset($title) && trim($title) != "") { ?>
                        <h3 class="tp-section-title lts tp_fade_anim">
                            <?php echo h($title); ?>
                            <!--  -->
                        </h3>
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="tp-career-opening-item career-heading">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="tp-career-opening-heading">
                            <span>Position</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-career-opening-heading">
                            <span>Roles</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-career-opening-heading">
                            <span>Type</span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="bind--data ">
            <?php View::element("vacancy/view", ["pages" => $pages]); ?>
        </div>

        <!-- <div class="loader" style="display : none;">
                    <h4><? //= t("loading...") 
                        ?></h4>
                </div> -->

        <? //php if (isset($enablePagination) && $enablePagination && isset($paginationStyle)) { 
        ?>
        <!-- <div class="load--more" <? //php if (!isset($loadMore) || $paginationStyle == "on_scroll") { 
                                        ?>style="display: none" <? //php } 
                                                                                                                                    ?> data-pagination-style="<? //php echo $paginationStyle; 
                                                                                                                                                                        ?>" data-load-more="<? //php echo $loadMore; 
                                                                                                                                                                                                                            ?>"><span><? //php echo isset($loadMoreText) ? $loadMoreText : t("Load More"); 
                                                                                                                                                                                                                                                                ?></span></div> -->
        <? //php } 
        ?>

    </div>
    <?php echo $token; ?>
</section>