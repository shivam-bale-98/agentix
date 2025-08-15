<?php defined("C5_EXECUTE") or die("Access Denied."); ?>
    


    






<div class="pp-service-2-banner-area p-relative">
    <div class="pp-service-2-banner-top">
        <div class="container container-1830">
            <div class="row">
                <div class="col-lg-4">
                    <?php if (isset($textOne) && trim($textOne) != "") { ?>
                    <div class="pp-service-2-banner-text">
                         <p><?php echo h($textOne); ?></p>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <?php if (isset($textTwo) && trim($textTwo) != "") { ?>
                    <div class="pp-service-2-banner-text text-lg-center">
                         <?php echo $textTwo; ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <div class="pp-service-2-banner-text smooth text-lg-end">
                        <a href="#<?php echo h($scrollToId); ?>">Scroll Down
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M7 1V13" stroke="#111013" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M13 7L7 13L1 7" stroke="#111013" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>