<?php
use  \Application\Concrete\Helpers\ImageHelper;

$ih = new ImageHelper();
$detect   = new Mobile_Detect();
$isMobile = $detect->isMobile() && !$detect->isTablet();
?>

<?php if (is_array($pages) && count($pages)) {
    foreach ($pages as $page) {
        $title = $page->getCollectionName();
        $url = $page->getCollectionLink();
        $thumb = $page->getThumbnailImage(2000, 1600);
        $mobile_thumbnail = $page->getThumbnailMobileImage(600, 1000);
        $display_thumb = $isMobile ? $mobile_thumbnail : $thumb;
        //$description = $page->getCollectionDescription();
        $bussiness_category = $page->getAttribute('bussiness_category');
        $categories = iterator_to_array($page->getAttribute('portfolio_category'));
        $logo_attribute = $page->getAttribute('logo');
        $logo = $ih->getThumbnail($logo_attribute, 200, 200, false);
?>

        <div class="tp-perspective-main">
            <div class="tp-perspective-inner">
                <div class="tp-perspective-image bg-center" data-background="<?php echo $display_thumb ?>">

                    <div class="tp-perspective-content flex flex-col items-center">
                        <div class="xl:size-36 size-24 bg-white rounded-full xl:p-4 p-2 xl:mb-4 mb-2">
                            <img class="w-full h-full object-contain" src="<?php echo $logo ?>" alt="<?php echo h($title) ?>">
                        </div>
                        <span class="tp-perspective-category tp_reveal_anim"><?php echo $bussiness_category ?></span>
                        <h1 class="tp-perspective-title tp_reveal_anim not-hide-cursor" data-cursor="View<br>Demo">
                            <a class="cursor-hide" href="<?php echo $url ?>"><?php echo $title ?></a>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    <?php }
} else {  ?>
    <h4><?= t("No Items Found") ?></h4>
<?php } ?>