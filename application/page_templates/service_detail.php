 <?php


    $c = Page::getCurrentPage();

    use  \Application\Concrete\Helpers\ImageHelper;

    $ih = new ImageHelper();

    $title = $c->getCollectionName();
    $pageURL = $c->getCollectionLink();
    $description = $c->getCollectionDescription();
    ?>

 <div class="agntix-dark">
     <!-- hero area start -->
     <div class="ar-hero-area pp-service-2 p-relative pb-45" data-background="<?php echo $this->getThemePath() . '/assets/img/blog/blog-masonry/blog-bradcum-bg.png'; ?>">
         <div class="tp-career-shape-1">
             <span>
                 <svg xmlns="http://www.w3.org/2000/svg" width="84" height="84" viewBox="0 0 84 84" fill="none">
                     <path d="M36.3761 0.5993C40.3065 8.98556 47.3237 34.898 32.8824 44.3691C25.3614 49.0997 9.4871 52.826 1.7513 31.3747C-1.16691 23.2826 5.38982 15.9009 20.5227 20.0332C29.2536 22.4173 50.3517 27.8744 60.9 44.2751C66.4672 52.9311 71.833 71.0287 69.4175 82.9721M69.4175 82.9721C70.1596 77.2054 74.079 66.0171 83.8204 67.3978M69.4175 82.9721C69.8033 79.1875 67.076 70.1737 53.0797 64.3958M49.1371 20.8349C52.611 22.1801 63.742 28.4916 67.9921 39.9344" stroke="#ffffff" stroke-width="1.5" />
                 </svg>
             </span>
         </div>
         <div class="ar-about-us-4-shape">
             <img src="<?php echo $this->getThemePath() . '/assets/img/portfolio/portfolio-shape.png'; ?>" alt="">
         </div>
         <div class="container container-1830">
             <div class="row justify-content-center">
                 <div class="col-xl-12">
                     <div class="pp-service-2-title-box">
                         <h3 class="ar-about-us-4-title tp-char-animation xl:max-w-[70%]"><?php echo $title ?></h3>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- hero area end -->


     <?php $a = new Area('Service Detail Blocks');
        $a->display($c); ?>

     
 </div>