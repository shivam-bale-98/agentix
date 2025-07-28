<?php
/** @var View $this */
defined('C5_EXECUTE') or die(_("Access Denied."));
/** @var HtmlHelper $htmlHelper */
$htmlHelper = Loader::helper('html');
$version = \Config::get('concrete.FILE_VERSION');
$json_file_path = 'application/config/version.json';
$data = file_get_contents($json_file_path);
$data = json_decode($data, true);
$fileversion = $data['version'];
?>
<script src="<?php echo $this->getThemePath() . '/dist/js/app-'.$fileversion.'.min.js?v='.$version; ?>"></script>

<?php if (!$c->isEditMode()): ?>
  <script src="<?php echo $this->getThemePath() . '/assets/js/vendor/jquery.js'; ?>"></script>
<?php endif; ?>
<script src="<?php  //echo $this->getThemePath() . '/assets/js/vendor/jquery.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/bootstrap-bundle.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/swiper-bundle.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/plugin.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/three.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/slick.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/scroll-magic.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/hover-effect.umd.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/magnific-popup.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/parallax-slider.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/nice-select.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/purecounter.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/isotope-pkgd.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/imagesloaded-pkgd.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/ajax-form.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/Observer.min.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/splitting.min.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/webgl.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/parallax-scroll.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/atropos.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/slider-active.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/main.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/tp-cursor.js'; ?>"></script>
<script src="<?php echo $this->getThemePath() . '/assets/js/portfolio-slider-1.js'; ?>"></script>
<script type="module" src="<?php echo $this->getThemePath() . '/assets/js/distortion-img.js'; ?>"></script>
<script type="module" src="<?php echo $this->getThemePath() . '/assets/js/skew-slider/index.js'; ?>"></script>
<script type="module" src="<?php echo $this->getThemePath() . '/assets/js/img-revel/index.js'; ?>"></script>



















<!--comment below if you don't need maps-->
<?php
// $this->addFooterItem($htmlHelper->javascript('//maps.googleapis.com/maps/api/js?key='));
?>
<!-- Google Tag Manager (noscript) -->
<!--<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WK2TMCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>-->
<!-- End Google Tag Manager (noscript) -->


	</body>
</html>
