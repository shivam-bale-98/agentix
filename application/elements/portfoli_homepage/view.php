<?php if (is_array($pages) && count($pages)) {
    foreach ($pages as $page) {
        $url = $page->getCollectionLink();
        $title = $page->getCollectionName();
        $thumb = $page->getThumbnailImage(2000, 1600);
        $year = $page->getAttribute('portfolio_year');
        $video = $page->getAttribute('video_url');
        $categories = iterator_to_array($page->getAttribute('portfolio_category'));
     
?>
        <div class="des-portfolio-item des-portfolio-panel p-relative not-hide-cursor mb-30" data-cursor="View<br>Demo">
            <a class="cursor-hide" href="<?php echo $url; ?>">
                <div class="des-portfolio-thumb p-relative">
                    <img class="lazy" loading="lazy" src="<?php echo $thumb ?>" alt="<?php echo $title ?>">
                </div>
                <div class="des-portfolio-category">
                    <?php foreach ($categories as $category) { ?>
                        <span><?php echo trim($category); ?></span>
                    <?php } ?>
                </div>
                <div class="des-portfolio-category portfolio-meta">
                    <span><?php echo $year ?></span>
                </div>
            </a>
            <div class="des-portfolio-content">
                <h2 class="des-portfolio-title"><a href="<?php echo $url; ?>"><?php echo $title ?></a></h2>
            </div>
        </div>
    <?php } } else { ?>
    <h4><?= t("No Items Found") ?></h4>
<?php } ?>