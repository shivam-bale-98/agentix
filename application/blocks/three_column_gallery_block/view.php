<?php defined("C5_EXECUTE") or die("Access Denied.");
$ih = new \Application\Concrete\Helpers\ImageHelper();

$thumbnailOne = "";
$thumbnailTwo = "";
$thumbnailThree = "";
$thumbnailFour = "";
$thumbnailRight = "";

if ($cardOneImage) {
    $thumbnailOne = $ih->getThumbnail($cardOneImage, 800, 800);
}

if ($cardTwoImage) {
    $thumbnailTwo = $ih->getThumbnail($cardTwoImage, 800, 800);
}

if ($cardThreeImage) {
    $thumbnailThree = $ih->getThumbnail($cardThreeImage, 800, 800);
}

if ($cardFourImage) {
    $thumbnailFour = $ih->getThumbnail($cardFourImage, 800, 800);
}

if ($imageRight) {
    $thumbnailRight = $ih->getThumbnail($imageRight, 1800, 1400);
}
?>















<section class="crp-success-area mb-70 p-relative z-[3] <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
    <div class="container-fluid p-0">
        <div class="row gx-10">
            <div class="col-xl-6">
                <div class="row gx-10">
                    <div class="col-xl-6 col-lg-6 col-md-6 mb-10">



                        <?php if ($cardOneImage) { ?>
                            <div class="crp-success-item about-us p-relative bg-cover !bg-center bg-no-repeat" data-bg-color="#1B1B1D" data-background="<?php echo $thumbnailOne ?>">
                                <div class="crp-about-us-item-wrap relative z-[2]">
                                    <?php if ($logo) { ?>
                                        <div class="crp-about-us-item-iconc z-[3]">
                                            <span>
                                                <img src="<?php echo $logo->getURL(); ?>" alt="<?php echo $logo->getTitle(); ?>" />
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($cardTitle) && trim($cardTitle) != "") { ?>
                                        <h4 class="max-w-48 text-center crp-about-us-item-title mx-auto z-[3]"><?php echo h($cardTitle); ?></h4>
                                    <?php } ?>

                                    <div class="crp-about-us-item-btn-box z-[3]">
                                        <?php if (isset($cardSubtitle) && trim($cardSubtitle) != "") { ?>
                                            <span><?php echo h($cardSubtitle); ?></span>
                                        <?php } ?>
                                        <?php
                                        if (trim($link_URL) != "") { ?>
                                            <?php
                                            $link_Attributes = [];
                                            $link_Attributes['href'] = $link_URL;
                                            if (in_array($link, ['relative_url'])) {
                                                $link_Attributes['target'] = '_blank';
                                            }
                                            $link_AttributesHtml = join(' ', array_map(function ($key) use ($link_Attributes) {
                                                return $key . '="' . $link_Attributes[$key] . '"';
                                            }, array_keys($link_Attributes)));
                                            echo sprintf('<a %s>
                                                    <span>%s
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                        <path d="M1 8.99994L9 0.999939" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M1 0.999939H9V8.99994" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </a>', $link_AttributesHtml, $link_Title); ?>
                                        <?php } ?>

                                    </div>
                                </div>

                                <div class="bg-black/40 absolute inset-0 z-[1]"></div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($cardTwoImage) { ?>

                        <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
                            <div class="crp-success-item">
                                <div class="crp-success-img anim-zoomin-wrap">
                                    <img class="w-100 anim-zoomin" src="<?php echo $thumbnailTwo; ?>" alt="<?php echo $cardTwoImage->getTitle(); ?>" />
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($cardThreeVideo) && trim($cardThreeVideo) != "") { ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
                            <div class="crp-success-item about-us">
                                <div class="crp-success-video anim-zoomin-wrap">
                                    <video loop="" muted="" autoplay="" playsinline="" src="<?php echo h($cardThreeVideo); ?>"></video>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php if ($cardThreeImage) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
                                <div class="crp-success-item about-us">
                                    <div class="crp-success-video anim-zoomin-wrap">
                                        <img src="<?php echo $thumbnailThree; ?>" alt="<?php echo $cardThreeImage->getTitle(); ?>" />
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } ?>

                    <?php if ($cardFourImage) { ?>

                        <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
                            <div class="crp-success-item about-us-img p-relative" data-bg-color="#1B1B1D">
                                <div class="crp-about-us-item-img">
                                    <img src="<?php echo $thumbnailFour; ?>" alt="<?php echo $cardFourImage->getTitle(); ?>" />
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <div class="crp-success-about-us-big-img anim-zoomin-wrap">
        <?php if ($imageRight) { ?>
            <img class="w-100 anim-zoomin" src="<?php echo $thumbnailRight; ?>" alt="<?php echo $imageRight->getTitle(); ?>" />
        <?php } ?>

    </div>
</section>