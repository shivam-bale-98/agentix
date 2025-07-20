<?php defined("C5_EXECUTE") or die("Access Denied.");
$ih = new \Application\Concrete\Helpers\ImageHelper();

$thumbnailOne = "";
$thumbnailTwo = "";
$thumbnailThree = "";
$thumbnailFour = "";
$thumbnailFive = "";
$thumbnailSix = "";
$thumbnailSeven = "";
$thumbnailEight = "";

if ($imageOne) {
    $thumbnailOne = $ih->getThumbnail($imageOne, 600, 600);
}

if ($imageTwo) {
    $thumbnailTwo = $ih->getThumbnail($imageTwo, 600, 600);
}

if ($imageThree) {
    $thumbnailThree = $ih->getThumbnail($imageThree, 600, 600);
}

if ($imageFour) {
    $thumbnailFour = $ih->getThumbnail($imageFour, 800, 800);
}

if ($imageFive) {
    $thumbnailFive = $ih->getThumbnail($imageFive, 600, 600);
}

if ($imageSix) {
    $thumbnailSix = $ih->getThumbnail($imageSix, 600, 600);
}

if ($imageSeven) {
    $thumbnailSeven = $ih->getThumbnail($imageSeven, 600, 600);
}

if ($imageEight) {
    $thumbnailEight = $ih->getThumbnail($imageEight, 600, 600);
}
?>













<? //php if ($imageThree) { 
?>
<!-- <img src="<? //php echo $imageThree->getURL(); 
                ?>" alt="<? //php echo $imageThree->getTitle(); ?>" /> -->
<? //php } 
?>











<!-- hero area start -->
<section class="<?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?> tp-hero-2-wrapper ">
    <div class="tp-hero-2-area include-bg pt-180 pb-160 " data-background="<?php echo $this->getThemePath() . '/assets/img/home-02/hero/hero-bg.jpg'; ?>">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-hero-2-content text-center mb-25">
                        <?php if (isset($title) && trim($title) != "") { ?>
                            <?php echo $title; ?>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
            <div class="row w-full">
                <div class="col-md-6">
                    <div class="tp-hero-2-avater-box d-flex align-items-center justify-content-center justify-content-md-start tp_fade_anim" data-delay=".7" data-on-scroll="3">
                        <div class="tp-hero-2-avater">
                            <img src="assets/img/home-02/hero/avater.png" alt="">
                        </div>
                        <div class="tp-hero-2-avater-content">
                            <?php if (isset($featureTitle) && trim($featureTitle) != "") { ?>
                                <h4><?php echo h($featureTitle); ?></h4>
                      
                            <?php } ?>
                            <?php if (isset($featureValue) && trim($featureValue) != "") { ?>
                                <span><?php echo h($featureValue); ?></span>
                                 
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">


                    <?php
                    if (trim($linkTag_URL) != "") { ?>
                        <div class="tp-hero-2-btn-box text-center text-md-end tp_fade_anim" data-delay=".7" data-on-scroll="3">
                            <?php
                            $linkTag_Attributes = [];
                            $linkTag_Attributes['href'] = $linkTag_URL;
                            if (in_array($linkTag, ['file', 'image', 'relative_url'])) {
                                $linkTag_Attributes['target'] = '_blank';
                            }
                            $linkTag_AttributesHtml = join(' ', array_map(function ($key) use ($linkTag_Attributes) {
                                return $key . '="' . $linkTag_Attributes[$key] . '"';
                            }, array_keys($linkTag_Attributes)));
                            echo sprintf('
                               <a class="tp-btn-border z-[2] relative" %s>
                                    %s
                                    <span>
                                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 9.99999H15.2222M8.11121 1.11108L17.0001 9.99997L8.11121 18.8889" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                               </a>', $linkTag_AttributesHtml, $linkTag_Title); ?>
                            <!-- <a  href="portfolio-details-creative-slider.html">
                                    Explore Our Projects
                                    <span>
                                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 9.99999H15.2222M8.11121 1.11108L17.0001 9.99997L8.11121 18.8889" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a> -->
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <div class="tp-hero-2-img-wrap d-none d-md-block">
        <div class="container container-1230">
            <div class="tp-hero-2-img-box mb-150">
                <div class="row">

                    <?php if ($imageOne) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-1 ">
                                <img class="lg:w-[16%] min-w-52 aspect-[0.8]" src="<?php echo $thumbnailOne ?>" alt="<?php echo $imageOne->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>



                    <?php if ($imageTwo) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-2 text-end ">
                                <img class="lg:w-[16%] min-w-52 aspect-[0.8]" src="<?php echo $thumbnailTwo ?>" alt="<?php echo $imageTwo->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ($imageThree) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-3 text-end ">
                                <img class="lg:w-[25%] min-w-52 aspect-square" src="<?php echo $thumbnailThree ?>" alt="<?php echo $imageThree->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="tp-hero-2-img-box mb-150">
                <div class="row">

                    <?php if ($imageFour) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-1">
                                <img class="lg:w-[16%] min-w-52 aspect-[0.8]" src="<?php echo $thumbnailFour ?>" alt="<?php echo $imageFour->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ($imageFive) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-2 text-end">
                                <img class="lg:w-[16%] min-w-52 aspect-[0.8]" src="<?php echo $thumbnailFive ?>" alt="<?php echo $imageFive->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ($imageSix) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-3 text-end">
                                <img class="lg:w-[25%] min-w-52 aspect-square" src="<?php echo $thumbnailSix ?>" alt="<?php echo $imageSix->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="tp-hero-2-img-box last-item">
                <div class="row">

                    <?php if ($imageSeven) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-1">
                                <img class="lg:w-[16%] min-w-52 aspect-[0.8]" src="<?php echo $thumbnailSeven ?>" alt="<?php echo $imageSeven->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ($imageEight) { ?>
                        <div class="col-12">
                            <div class="tp-heo-2-img tp-hero-2-img-2 text-end">
                                <img class="lg:w-[16%] min-w-52 aspect-[0.8]" src="<?php echo $thumbnailEight ?>" alt="<?php echo $imageEight->getTitle(); ?>" />
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- hero area end -->