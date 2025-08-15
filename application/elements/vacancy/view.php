<?php

use  \Application\Concrete\Helpers\ImageHelper;
use Application\Concrete\Helpers\GeneralHelper;
$ih = new ImageHelper();
$detect   = new Mobile_Detect();
$isMobile = $detect->isMobile() && !$detect->isTablet();
?>

<?php if (is_array($pages) && count($pages)) {
      $th = Core::make("helper/text");
    foreach ($pages as $page) {
        $title = $page->getCollectionName();
        $url = $page->getCollectionLink();
        $open_post = $page->getAttribute('open_posts');
        $job_type = $page->getAttribute('job_type');
        $linkedin_url = $page->getAttribute('linkedin_url');
?>

        <div class="tp-career-opening-item ptb">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="tp-career-opening-title">
                            <h4 class="tp-career-opening-title-name"><?php echo $title ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-career-opening-role">
                            <span><?php echo $open_post ?></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-career-opening-Type d-flex justify-content-between align-items-center">
                            <span><?php echo $job_type ?></span>
                            <div class="tp-career-opening-btn">
                                <a target="_blank" href="<?php echo $linkedin_url ?>" class="tp-btn-black btn-red-bg">
                                    <span class="tp-btn-black-filter-blur">
                                        <svg width="0" height="0">
                                            <defs>
                                                <filter id="buttonFilter">
                                                    <feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur"></feGaussianBlur>
                                                    <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"></feColorMatrix>
                                                    <feComposite in="SourceGraphic" in2="buttonFilter" operator="atop"></feComposite>
                                                    <feBlend in="SourceGraphic" in2="buttonFilter"></feBlend>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </span>
                                    <span class="tp-btn-black-filter d-inline-flex align-items-center" style="filter: url(#buttonFilter)">
                                        <span class="tp-btn-black-text">Apply Now</span>
                                        <span class="tp-btn-black-circle">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 9L9 1M9 1H1M9 1V9" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
} else {  ?>
    <h4><?= t("No Items Found") ?></h4>
<?php } ?>