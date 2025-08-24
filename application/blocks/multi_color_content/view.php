<?php defined("C5_EXECUTE") or die("Access Denied."); ?>


    




<!-- about moving area start -->
<section class="des-about-area sm:pb-[6.25rem] pb-[3.75rem] <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
    <div class="container container-1230">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="des-text-about-us-wrap p-relative text-center">
                    <div class="des-text-shape d-flex justify-content-center align-items-center">
                        <span class="shape-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="101" height="9" viewBox="0 0 101 9" fill="none">
                                <rect y="4.01807" width="100" height="1" fill="white" fill-opacity="0.2" />
                                <path d="M97 7.98173L100.5 4.4999L97 1.01807" stroke="white" stroke-opacity="0.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <?php if (isset($title) && trim($title) != "") { ?>
                            <h4 class="des-text-title"><?php echo h($title); ?></h4>
                        <?php } ?>

                        <span class="shape-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="101" height="9" viewBox="0 0 101 9" fill="none">
                                <rect width="100" height="1" transform="matrix(-1 0 0 1 101 4.01807)" fill="white" fill-opacity="0.2" />
                                <path d="M4 7.98173L0.5 4.4999L4 1.01807" stroke="white" stroke-opacity="0.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>
                <?php if (isset($content) && trim($content) != "") { ?>

                <div class="des-about-text text-center">
       
                    <?php echo $content; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- about moving area end -->