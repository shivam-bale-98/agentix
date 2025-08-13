<?php
defined('C5_EXECUTE') or die("Access Denied.");

?>




<?php if ($nextCollection && $nextLinkURL && $nextLabel) {
    $title = $nextCollection->getCollectionName();
    $thumbnail = $nextCollection->getAttribute('thumbnail');
    $thumbnailURL = $thumbnail ? \Application\Concrete\Helpers\ImageHelper::getThumbnail($thumbnail) : $this->getThemePath() . '/assets/img/portfolio/portfolio-details-1/portfolio-details-np.jpg';
?>
    <div class="container container-1750">
        <div class="row justify-content-center">
            <div class="col-xl-12">

                <a href="<?php echo $nextLinkURL ?>">
                    <div class="postbox-details-nevigation-wrap p-relative">
                        <div class="postbox-details-nevigation-thumb-bg">
                            <div class="postbox-details-nevigation-thumb size-full ">
                                <img class="object-cover !mt-0 w-full h-[110%]" data-speed=".8" src="<?php echo $thumbnailURL ?>" alt="<?php echo h($title) ?>">
                            </div>
                        </div>
                        <div class="postbox-details-nevigation-content ">
                            <span>Next Post</span>
                            <h4 class="postbox-details-nevigation-title max-w-[80%] mx-auto">
                               <?php echo h($title) ?> 
                            </h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

<?php } ?>