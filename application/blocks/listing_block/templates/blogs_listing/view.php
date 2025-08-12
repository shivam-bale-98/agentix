<?php defined("C5_EXECUTE") or die("Access Denied."); ?>
<section class="listing--block">
    <?php if (isset($title) && trim($title) != "") { ?>
        <?php echo h($title); ?>
    <?php } ?>

    <!-- link -->
    <?php if (isset($button_URL) && isset($button_Title)) { ?>
        <a href="<?php echo $button_URL; ?>"><?php echo $button_Title; ?></a>
    <?php } ?>

    <!-- Filters -->
    <div>
        <!-- Search -->
        <?php if (isset($enableSearch) && $enableSearch) {
            echo $form->text("keywords", null, ["placeholder" => isset($searchPlaceHolderText) ? $searchPlaceHolderText : t("Search")]);
        } ?>

        <!-- sortBy -->
        <?php if (isset($enableSort) && $enableSort && isset($sortOptions) && $sortOptions) {
            echo $form->label("sortOrder", t("Sort By"));
            echo $form->select("sortOrder", $sortOptions, null, ["class" => "sort--filter"]);
        } ?>

        <!-- Dynamic Filters -->
        <?php if (isset($filters) && $filters) {
            foreach ($filters as $filter) {
                if ($filter["allowMultiple"]) {
                    $fieldType = "selectMultiple";
                } else {
                    $fieldType = "select";
                }

                echo $form->label($filter["key"], $filter["label"]);
                echo $form->{$fieldType}($filter["key"], $filter["options"], null, ["class" => "block--filter"]);
            }
        } ?>
    </div>

    <div>
        <div id="down" class="bind--data tp-blog-gird-sidebar-ptb pb-80">
            <div class="container container-1330">
                <div class="row">
                    <?php View::element("news/view", ["pages" => $pages]); ?>
                </div>
            </div>
        </div>

        <div class="loader" style="display : none;">
            <h4><?= t("loading...") ?></h4>
        </div>

        <?php if (isset($enablePagination) && $enablePagination && isset($paginationStyle)) { ?>
            <div class="load--more" <?php if (!isset($loadMore) || $paginationStyle == "on_scroll") { ?>style="display: none" <?php } ?> data-pagination-style="<?php echo $paginationStyle; ?>" data-load-more="<?php echo $loadMore; ?>"><span><?php echo isset($loadMoreText) ? $loadMoreText : t("Load More"); ?></span></div>
        <?php } ?>
    </div>

    <?php echo $token; ?>
</section>