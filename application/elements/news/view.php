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
        $thumb = $page->getThumbnailImage(2000, 1600);
        $author = $page->getAttribute('author');
        // $date = $page->getPublicDate('d/m/Y');
        $date = date("d/m/Y", strtotime($page->getCollectionDatePublic()));
        $blog_category = $page->getAttribute('blogs_category');
?>

        <div class="col-lg-4 col-md-6">
            <div class="tp-blog-masonry-item mb-30">
                <div class="tp-blog-masonry-item-top d-flex justify-content-between align-items-center mb-30">
                    <div class="tp-blog-masonry-item-user d-flex align-items-center">
                        <div class="tp-blog-masonry-item-user-thumb"><img src="assets/img/blog/blog-masonry/blog-masonry-user-1.jpg" alt=""></div>
                        <div class="tp-blog-masonry-item-user-content">
                            <span><?php echo $author ?></span>
                            <!-- <p>Administrator</p> -->
                        </div>
                    </div>
                    <div class="tp-blog-masonry-item-time">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M9 4.19997V8.99997L12.2 10.6M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z" stroke="white" stroke-opacity="0.6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <!-- April 15, 2025 -->
                             <?php echo $date ?>
                        </span>
                    </div>
                </div>
                <div class="tp-blog-masonry-thumb mb-30">
                    <a href="<?php echo $url ?>">
                        <img src="<?php echo $thumb ?>" alt="<?php echo h($title) ?>">
                    </a>
                </div>
                <div class="tp-blog-masonry-content">
                    <div class="tp-blog-masonry-tag mb-15">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                                <path d="M4.39012 4.13048H4.39847M13.6056 8.14369L8.74375 12.6328C8.6178 12.7492 8.46823 12.8415 8.30359 12.9046C8.13896 12.9676 7.96248 13 7.78426 13C7.60604 13 7.42956 12.9676 7.26493 12.9046C7.10029 12.8415 6.95072 12.7492 6.82477 12.6328L1 7.2609V1H7.78087L13.6056 6.37811C13.8582 6.61273 14 6.93009 14 7.2609C14 7.59171 13.8582 7.90908 13.6056 8.14369Z" stroke="white" stroke-opacity="0.6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> 
                            <!-- Inspiration -->
                             <?php echo $blog_category ?> 
                        </span>
                    </div>
                    <h4 class="tp-blog-masonry-title">
                        <a class="tp-line-white" href="blog-details.html">
                            <?php echo $title ?>
                        </a>
                    </h4>
                    <div class="tp-blog-masonry-btn">
                        <a href="<?php echo $url ?>">Read More <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#D0FF71" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#D0FF71" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span></a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
} else {  ?>
    <h4><?= t("No Items Found") ?></h4>
<?php } ?>