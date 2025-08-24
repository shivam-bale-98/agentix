<?php

use  \Application\Concrete\Helpers\ImageHelper;

$ih = new ImageHelper();
?>

<?php if (is_array($pages) && count($pages)) {
    foreach ($pages as $page) {
        $url = $page->getCollectionLink();
        $title = $page->getCollectionName();
        $thumb = $page->getThumbnailImage(2000, 1600);
        $year = $page->getAttribute('portfolio_year');
        $video = $page->getAttribute('video_url');
        $categories = iterator_to_array($page->getAttribute('portfolio_category'));
        $bussiness_category = $page->getAttribute('bussiness_category');
        $logo_attribute = $page->getAttribute('logo');
        $logo = $ih->getThumbnail($logo_attribute, 200, 200, false);
?>
        <div class="des-portfolio-item des-portfolio-panel p-relative not-hide-cursor mb-30" data-cursor="View<br>Demo">
            <a class="cursor-hide" href="<?php echo $url; ?>">
                <div class="des-portfolio-thumb p-relative">
                    <img class="lazy object-cover" loading="lazy" src="<?php echo $thumb ?>" alt="<?php echo $title ?>">
                </div>
                <div class="des-portfolio-category">
                    <?php foreach ($categories as $category) { ?>
                        <span><?php echo trim($category); ?></span>
                    <?php } ?>
                </div>
                <div class="des-portfolio-category portfolio-meta hidden">
                    <span><?php echo $year ?></span>
                </div>
            </a>
            <div class="des-portfolio-content">
                <div class="xl:size-36 size-24 bg-white rounded-full p-[0.5rem] xl:p-[1rem]  mb-[1rem] xl:mb-[2rem] ">
                    <img class="w-full h-full object-contain" src="<?php echo $logo ?>" alt="<?php echo h($title) ?>">
                </div>
                <div>
                    <p class="tp-perspective-category tp_reveal_anim !mb-[1rem] xl:!mb-[2rem]  text-center"><?php echo $bussiness_category ?></p>
                </div>
                <h2 class="des-portfolio-title"><a href="<?php echo $url; ?>"><?php echo $title ?></a></h2>
            </div>
        </div>
    <?php }
} else { ?>
    <h4><?= t("No Items Found") ?></h4>
<?php } ?>