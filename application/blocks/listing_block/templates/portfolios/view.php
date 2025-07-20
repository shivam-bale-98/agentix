<?php defined("C5_EXECUTE") or die("Access Denied."); ?>



<section class="des-portfolio-area pb-160">
    <div class="container container-1750">
        <? //php if (isset($title) && trim($title) != "") { 
        ?>
        <? //php echo h($title); 
        ?>
        <? //php } 
        ?>

        <!-- link -->
        <? //php if (isset($button_URL) && isset($button_Title)) { 
        ?>
        <!-- <a href="<? //php echo $button_URL; 
                        ?>"><? //php echo $button_Title; 
                            ?></a> -->
        <? //php } 
        ?>



        <div class="row">
            <div class="col-xl-12">
                <div class="bind--data des-portfolio-wrap">
                    <?php View::element("portfoli_homepage/view", ["pages" => $pages]); ?>
                </div>

                <!-- <div class="loader" style="display : none;">
                    <h4><? //= t("loading...") ?></h4>
                </div> -->

                <? //php if (isset($enablePagination) && $enablePagination && isset($paginationStyle)) { ?>
                    <!-- <div class="load--more" <? //php if (!isset($loadMore) || $paginationStyle == "on_scroll") { ?>style="display: none" <? //php } ?> data-pagination-style="<? //php echo $paginationStyle; ?>" data-load-more="<? //php echo $loadMore; ?>"><span><? //php echo isset($loadMoreText) ? $loadMoreText : t("Load More"); ?></span></div> -->
                <? //php } ?>
            </div>
        </div>
    </div>
    <?php echo $token; ?>
</section>