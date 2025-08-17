<?php defined('C5_EXECUTE') or die("Access Denied.");

$site = Config::get('concrete.site');
$themePath = $this->getThemePath();

?>

<?php $this->inc('elements/header_top.php'); ?>


   <!-- Begin magic cursor -->
    <div id="magic-cursor" class="cursor-white-bg">
        <div id="ball"></div>
    </div>
    <!-- End magic cursor -->

    <!-- preloader -->

    <!-- preloader -->
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- preloader end  -->
    <!-- preloader end  -->

    <!-- back to top start -->
    <!-- back to top start -->
    <div class="back-to-top-wrapper">
        <button id="back_to_top" type="button" class="back-to-top-btn">
            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    <!-- back to top end -->
    <!-- back to top end -->

    <!-- offcanvas start -->

    <div class="tp-offcanvas-2-area p-relative offcanvas-2-black-bg">
        <div class="tp-offcanvas-2-bg is-left left-box"></div>
        <div class="tp-offcanvas-2-bg is-right right-box d-none d-md-block"></div>
        <div class="tp-offcanvas-2-wrapper">
            <div class="tp-offcanvas-2-left left-box">
                <div class="tp-offcanvas-2-left-wrap d-flex justify-content-between align-items-center">
                    <div class="tp-offcanvas-2-logo">
                        <a href="index.html">
                            <img class="logo-1" data-width="140" src="<?php echo $this->getThemePath() . '/assets/img/logo/logo-white.png'; ?>" alt="Agentix">
                            <img class="logo-2" data-width="140" src="<?php echo $this->getThemePath() . '/assets/img/logo/logo-black.png'; ?>" alt="Agentix">
                        </a>
                    </div>
                    <div class="tp-offcanvas-2-close d-md-none text-end">
                        <button class="tp-offcanvas-2-close-btn">
                            <span class="text">
                                <span>close</span>
                            </span>
                            <span class="d-inline-block">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32.621" height="1.00918" transform="matrix(0.704882 0.709325 -0.704882 0.709325 1.0061 0)" fill="currentcolor"></rect>
                                        <rect width="32.621" height="1.00918" transform="matrix(0.704882 -0.709325 0.704882 0.709325 0 23.2842)" fill="currentcolor"></rect>
                                    </svg>
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="tp-offcanvas-menu counter-row">
                    <nav>
                    </nav>
                </div>
            </div>
            <div class="tp-offcanvas-2-right right-box d-none d-md-block p-relative">
                <div class="tp-offcanvas-2-close text-end">
                    <button class="tp-offcanvas-2-close-btn">
                        <span class="text"><span>close</span></span>
                        <span class="d-inline-block">
                            <span>
                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.80859 9.80762L28.1934 28.1924" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9.80859 28.1924L28.1934 9.80761" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
                <?php $s = Stack::getByName("Menu Address");
                      $s->display(); ?>
            </div>
        </div>
    </div>
    <!-- offcanvas end -->

<header class="header fixed w-full top-0">

    <div class="tp-header-2-area z-index-3 xl:!mt-7">
        <div class="container container-1750">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="tp-header-logo">
                        <a href="<?php echo View::url('/'); ?>">
                            <img class=""  src="<?php echo $this->getThemePath() . '/assets/images/MMv1.svg'; ?>" alt="Agentix">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="tp-header-2-right d-flex justify-content-end">
                        <button class="tp-header-2-bar tp-offcanvas-open-btn d-flex align-items-center">
                            <span>Menu</span>
                            <span>
                                <i></i>
                                <i></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="tp-mobile-menu-active d-none">
        <?php $s = Stack::getByName("Mega Menu");
        $s->display(); ?>
    </nav>


</header>

<div id="smooth-wrapper">
    <div id="smooth-content">