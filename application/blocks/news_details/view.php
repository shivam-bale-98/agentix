


<?php defined("C5_EXECUTE") or die("Access Denied.");

$ih = new \Application\Concrete\Helpers\ImageHelper();

$thumbnail1 = "";
$thumbnail2 = "";

if ($imageOne) {
    $thumbnail1 = $ih->getThumbnail($imageOne, 1000, 1000);
}

if ($imageTwo) {
    $thumbnail2 = $ih->getThumbnail($imageTwo, 1000, 1000);
}

?>













<div class="col-xxl-8 col-xl-8 col-lg-8">
    <div class="postbox-wrapper mb-115">
        <?php if (isset($body) && trim($body) != "") { ?>
            <div class="postbox-details-text mb-45 ">

                <?php echo $body; ?>
            
            </div>
        <?php } ?>
        <div class="postbox-details-thumb d-flex align-items-center mb-50">
            <?php if ($imageOne) { ?>
                <div class="md:w-1/2 w-full aspect-square relative">
                    <img class="size-full absolute inset-0" src="<?php echo $thumbnail1 ?>" alt="<?php echo $imageOne->getTitle(); ?>">
                </div>
            <?php } ?>
            <?php if ($imageTwo) { ?>
                <div class="md:w-1/2 w-full aspect-square relative">
                    <img class="size-full absolute inset-0" src="<?php echo $thumbnail2 ?>" alt="<?php echo $imageTwo->getTitle(); ?>">
                </div>
            <?php } ?>
        </div>
        <?php if (isset($bodyTwo) && trim($bodyTwo) != "") { ?>

            <div class="postbox-details-text mb-50">
                <?php echo $bodyTwo; ?>
            </div>
        <?php } ?>
        <?php if (isset($quote) && trim($quote) != "") { ?>

            <div class="postbox-details-quote-box mb-45">
                <blockquote>
                    <div class="postbox-details-quote-box d-flex align-items-start">
                        <i>
                            <svg width="63" height="50" viewBox="0 0 63 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M36.7657 50V39.1608C42.0105 38.4615 45.507 36.7133 47.2552 33.9161C49.0035 31.0023 49.8776 26.9231 49.8776 21.6783L58.4441 23.4266H37.1154V0H62.6399V17.4825C62.6399 25.8741 60.542 33.042 56.3461 38.986C52.2669 44.9301 45.7401 48.6014 36.7657 50ZM0 50V39.1608C5.24476 38.4615 8.74126 36.7133 10.4895 33.9161C12.2378 31.0023 13.1119 26.9231 13.1119 21.6783L21.6783 23.4266H0.34965V0H25.8741V17.4825C25.8741 25.8741 23.7762 33.042 19.5804 38.986C15.5012 44.9301 8.97436 48.6014 0 50Z" fill="white" fill-opacity="0.1" />
                            </svg>
                        </i>
                        <div class="postbox-details-quote">
                            <p>
                                <?php echo h($quote); ?>
                            </p>
                            <?php if (isset($author) && trim($author) != "") { ?>

                                <span><?php echo h($author); ?></span>
                            <?php } ?>

                        </div>
                    </div>
                </blockquote>
            </div>
        <?php } ?>
        <?php if (isset($bodyThree) && trim($bodyThree) != "") { ?>

            <div class="postbox-details-text mb-45">
             
                <?php echo $bodyThree; ?>
            </div>
        <?php } ?>





    </div>
</div>