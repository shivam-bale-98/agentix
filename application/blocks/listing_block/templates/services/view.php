<?php defined("C5_EXECUTE") or die("Access Denied."); ?>
<section class="listing--block des-text-moving-2-area pt-200 pb-60 z-index-1">



  




    <div class="bind--data des-text-moving-wrap">
        <div class="des-text-title-box text-center">
             <?php if (isset($title) && trim($title) != "") { ?>
            <div class="des-text-title-wrap">
                <!-- <h4 class="des-text-title">We can help you with</h4> -->
                 <h4 class="des-text-title"><?php echo h($title); ?></h4>
            </div>
             <?php } ?>
            <p>Check out some of my projects by area of expertise</p>
        </div>
        <?php View::element("services/view", ["pages" => $pages]); ?>
    </div>

    <!-- <div class="loader" style="display : none;">
                <h4><? //= t("loading...") 
                    ?></h4>
            </div> -->

    <? //php if(isset($enablePagination) && $enablePagination && isset($paginationStyle)) { 
    ?>
    <!-- <div class="load--more" <? //php if(!isset($loadMore) || $paginationStyle == "on_scroll") { 
                                    ?>style="display: none" <? //php } 
                                                            ?> data-pagination-style="<? //php echo $paginationStyle; 
                                                                                                                                                            ?>" data-load-more="<? //php echo $loadMore; 
                                                                                                                                                                                        ?>" ><span><? //php echo isset($loadMoreText) ? $loadMoreText : t("Load More"); 
                                                                                                                                                                                                                                    ?></span></div> -->
    <? //php } 
    ?>


    <?php echo $token; ?>
</section>