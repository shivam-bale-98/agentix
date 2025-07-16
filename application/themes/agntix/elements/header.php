<?php defined('C5_EXECUTE') or die("Access Denied.");

$site = Config::get('concrete.site');
$themePath = $this->getThemePath();

?>

<?php $this->inc('elements/header_top.php'); ?>
<!-- <div class="mobile-nav">
</div>
<header>
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="logo">
                <a href="<?php echo View::url('/'); ?>">
                    <img src="<?php echo $themePath; ?>/dist/images/logo.png" alt="<?php echo $site; ?>"/>
                </a>
            </div>
            <nav>
                <div class="mobile-menu">
                    <span class="nav-icon"></span>
                </div>
            </nav>
        </div>
    </div>
</header> -->