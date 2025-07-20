<?php defined('C5_EXECUTE') or die("Access Denied.");

$site = Config::get('concrete.site');
$themePath = $this->getThemePath();

?>

<?php $this->inc('elements/header_top.php'); ?>



<header>

    <div class="tp-header-2-area z-index-3 mt-40 ">
        <div class="container container-1750">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="tp-header-logo">
                        <a href="index.html"><img data-width="140px" src="<?php echo $this->getThemePath() . '/assets/img/logo/logo-white.png'; ?>" alt="Agentix"></a>
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
        <ul>
            <li class="has-dropdown p-static is-active">
                <a href="#">Home</a>
                <ul class="tp-submenu submenu">
                    <li><a href="index-dark.html">Modern Agency</a></li>
                    <li><a href="index-digital-marketing-dark.html">Digital Marketing</a></li>
                    <li><a href="index-design-agency-dark.html">Design Agency</a></li>
                    <li><a href="index-unique-ai-image-dark.html">Unique AI Images</a></li>
                    <li><a href="index-corporate-agency-dark.html">Corporate Agency</a></li>
                    <li><a href="index-mobile-application-dark.html">Mobile Application</a></li>
                    <li><a href="index-it-solution-dark.html">IT Solutions</a></li>
                    <li><a href="index-cryptocurrency-dark.html">Cryptocurrency</a></li>
                </ul>
            </li>
            <li class="has-dropdown p-static is-active">
                <a href="#">Pages</a>
                <ul class="tp-submenu submenu">
                    <li><a href="about-me-dark.html">About Me</a></li>
                    <li><a href="about-us-dark.html">About Us</a></li>
                    <li><a href="service-1-dark.html">Services</a></li>
                    <li><a href="service-details-2-dark.html">Service Details</a></li>
                    <li><a href="career-dark.html">Carrer</a></li>
                    <li><a href="career-details-dark.html">Carrer Details</a></li>
                    <li><a href="team-dark.html">Team</a></li>
                    <li><a href="team-details-dark.html">Team Details</a></li>
                    <li><a href="pricing-dark.html">Pricing</a></li>
                    <li><a href="faq-dark.html">Faq's</a></li>
                </ul>
            </li>
            <li class="has-dropdown p-static is-active">
                <a href="#">Projects</a>
                <ul class="tp-submenu submenu">
                    <li><a href="portfolio-webgl-showcase.html">Webgl Showcase</a></li>
                    <li><a href="portfolio-coverflow-slider.html">Coverflow Slider</a></li>
                    <li><a href="portfolio-creative-thumb-slider.html">Creative Thumb Slider</a></li>
                    <li><a href="portfolio-creative-skew-slider.html">Creative Skew Slider</a></li>
                    <li><a href="portfolio-creative-text-slider.html">Creative Text Slider</a></li>
                    <li><a href="portfolio-parallax-slider.html">Parallax Slider</a></li>
                    <li><a href="portfolio-perspective-slider.html">Paspective Showcase</a></li>
                </ul>
            </li>
            <li class="has-dropdown is-active">
                <a href="#">Blog</a>
                <ul class="tp-submenu submenu">
                    <li><a href="blog-grid.html">Blog Grid</a></li>
                    <li><a href="blog-standard.html">Blog Classic</a></li>
                    <li><a href="blog-list.html">Blog Listing</a></li>
                    <li><a href="blog-masonry.html">Masonry</a></li>
                    <li><a href="blog-details.html">Blog Single Post</a></li>
                </ul>
            </li>
            <li class="has-dropdown is-active">
                <a href="#">Shop</a>
                <ul class="tp-submenu submenu">
                    <li><a href="index-shop-modern-dark.html">Shop Modern</a></li>
                    <li><a href="shop-details-dark.html">Shop Details</a></li>
                    <li><a href="my-account.html">My Account</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="wishlist.html">Wishlist</a></li>
                    <li><a href="login.html">LogIn</a></li>
                </ul>
            </li>
            <li class="has-dropdown is-active">
                <a href="#">Contact</a>
                <ul class="tp-submenu submenu">
                    <li><a href="contact-me-dark.html">Contact Me</a></li>
                    <li><a href="contact-us-dark.html">Contact Us</a></li>
                    <li><a href="contact-dark.html">Get In Touch</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    

</header>

<div id="smooth-wrapper">
        <div id="smooth-content">
