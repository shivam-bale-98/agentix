<?php defined("C5_EXECUTE") or die("Access Denied."); ?>



<div class="tp-perspective-area listing--block">
    <div class="container container-1685">
        <div class="row">
            <div class="col-xl-12 js-filter--section">
                <div class="">
                    <div class="filters w-full flex justify-center lg:gap-5 gap-3 flex-wrap">
                        <!-- Dynamic Filters -->
                        <?php if (isset($filters) && $filters) {
                            foreach ($filters as $filter) {
                                if ($filter["allowMultiple"]) {
                                    $fieldType = "selectMultiple";
                                } else {
                                    $fieldType = "select";
                                }

                                echo '<div class="select-box tabs relative multi-select">';
                                echo $form->{$fieldType}($filter["key"], $filter["options"], null, ["class" => "block--filter select2"]);
                                echo '<span class="arrow"></span>
                         <div class="dropdown-result" data-lenis-prevent></div>
                        </div>';
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="tp-perspective-slider bind--data">
                    <?php View::element("portfolio/view", ["pages" => $pages]); ?>
                </div>

                <div class="loader" style="display : none;">
                    <h4><?= t("loading...") ?></h4>
                </div>

                <?php if(isset($enablePagination) && $enablePagination && isset($paginationStyle)) { ?>
                    <div class="load--more" <?php if(!isset($loadMore) || $paginationStyle == "on_scroll") { ?>style="display: none" <?php } ?> data-pagination-style="<?php echo $paginationStyle; ?>" data-load-more="<?php echo $loadMore; ?>" ><span><?php echo isset($loadMoreText) ? $loadMoreText : t("Load More"); ?></span></div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php echo $token; ?>
</div>