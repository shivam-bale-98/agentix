<?php if (is_array($pages) && count($pages)) {
    $bulletClasses = ['gradient-bulet', 'paste-bulet', 'yellow-bulet', 'pink-bulet'];
    foreach ($pages as $index => $page) {
        $url = $page->getCollectionLink();
        $title = $page->getCollectionName();
        $thumb = $page->getThumbnailImage(2000, 1600);
        $currentBulletClass = $bulletClasses[$index % 4];
?>
        <div class="des-text-moving-top active moving-text">
            <div class="des-text-item hover-reveal-item  <?php echo $currentBulletClass; ?> sm wrapper-text">
                
                <a href="<?php echo $url ?>" class="d-flex align-items-center">
                    <span><?php echo $title ?></span>
                    <span><?php echo $title ?></span>
                    <span><?php echo $title ?></span>
                    <span><?php echo $title ?></span>
                </a>
                <div class="des-text-reveal-img">
                    <img src="<?php echo $thumb ?>" alt="<?php echo $title ?>">
                </div>
            </div>
        </div>
        <div class="des-text-title-box text-center">
            <div class="des-text-title-wrap">
                <h4 class="des-text-title sm"><a href="<?php echo $url ?>">Click to view Services</a></h4>
            </div>
        </div>
    <?php }
} else { ?>
    <h4><?= t("No Items Found") ?></h4>
<?php } ?>