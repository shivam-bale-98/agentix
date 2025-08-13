<?php
defined('C5_EXECUTE') or die("Access Denied.");

?>



<!-- portfolio details next prv start -->
<div class="tp-pd-1-np-ptb pt-40">
    <div class="container container-1230">
        <div class="row justify-content-md-center">
            <div class="col-lg-8">
                <?php if ($nextCollection && $nextLinkURL && $nextLabel) {
                        $title = $nextCollection->getCollectionName();
                        $thumbnail = $nextCollection->getAttribute('thumbnail');
                        $categories = iterator_to_array($nextCollection->getAttribute('portfolio_category'));
                        $categoriesString = is_array($categories) ? implode(', ', $categories) : $categories;
                        $thumbnailURL = $thumbnail ? \Application\Concrete\Helpers\ImageHelper::getThumbnail($thumbnail) : $this->getThemePath() . '/assets/img/portfolio/portfolio-details-1/portfolio-details-np.jpg';
                    ?>
                    <div class="tp-pd-1-np-box hover-reveal-item p-relative">

                        <a href="<?php echo $nextLinkURL ?>" class="tp-pd-1-np-content z-index-1 text-center">
                            <span>next</span>
                            <h4 class="tp-pd-1-np-title"><?php echo $title ?></h4>
                            <!-- <p>Research,UX, UI Design</p> -->
                             <p><?php echo $categoriesString ?></p>
                        </a>
                        <div class="tp-award-reveal-img bg-cover bg-center" data-background="<?php echo $thumbnailURL; ?>"></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- portfolio details next prv end -->