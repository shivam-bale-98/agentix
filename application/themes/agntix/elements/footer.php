<?php defined('C5_EXECUTE') or die("Access Denied.");
?>



<footer>
    <div class="des-footer-wrap pb-15">
        <div class="container-fluid">
            <div class="des-footer-area des-footer-bg text-center include-bg" data-background="<?php echo $this->getThemePath() . '/assets/img/home-02/footer/footer-bg.jpg'; ?>">
                <div class="des-footer-top d-flex align-items-center justify-content-between">
                    <!-- <span>Creative Design Agency</span> -->
                     <?php $s = Stack::getByName("Footer Subtitle");
                      $s->display(); ?>
                    <div class="des-footer-logo">
                        <a href="<?php echo View::url('/'); ?>"><img data-width="140px" src="<?php echo $this->getThemePath() . '/assets/img/logo/logo-white.png'; ?>" alt=""></a>
                    </div>
                    
                    <?php $s = Stack::getByName("Footer Location");
                      $s->display(); ?>
                </div>
                <div class="des-footer-middle">
                    <?php $s = Stack::getByName("Footer Title Area");
                      $s->display(); ?>
                </div>
                <div class="des-footer-bottom d-flex align-items-center justify-content-between">
                    <?php $s = Stack::getByName("Footer Bottom");
                      $s->display(); ?>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
</div> <!-- closing of wrapper div from header_top.php -->
<!-- Go to top button -->
<!-- <div id="gotoTop">
    <span class="fa fa-chevron-up" aria-hidden="true"></span>
</div> -->

<!-- For Landscape Alert -->
<!-- <div class="landscape-alert">
    <p>For better web experience, please use the website in portrait mode</p>
</div> -->

<?php $this->inc('elements/footer_bottom.php'); ?>