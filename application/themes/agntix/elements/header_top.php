<?php defined('C5_EXECUTE') or die("Access Denied.");

/** @var HtmlHelper $htmlHelper */
$htmlHelper = Loader::helper('html');

global $u;

$page = $c;

$pageType = (string) $page->getAttribute('page_type');
if (!$pageType) {
    $pageType = 'default';
}
$bodyClass = $bodyClass ?? '';
$bodyClass .= ' ' . $pageType . '-page';
if (User::isLoggedIn()) {
    $bodyClass .= ' logged-in';
}
if ($page->isEditMode()) {
    $bodyClass .= ' edit-mode';
}
$site = Config::get('concrete.site');
$version = Config::get('concrete.FILE_VERSION');
$is_arabic = 0;
$activeLanguage = Localization::activeLanguage();
$dir = "";
if (Localization::activeLanguage() === 'ar') {
    $activeLanguage = "ar";
    $dir = "rtl";
    $is_arabic = 1;
}

?>
<!DOCTYPE html>
<!--[if lte IE 8]> <html lang="<?php echo $activeLanguage ?>" dir="<?php echo $dir; ?>" class="ie10 ie9 ie8"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo $activeLanguage ?>" dir="<?php echo $dir; ?>" class="ie10 ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="<?php echo $activeLanguage ?>" dir="<?php echo $dir; ?>"> <!--<![endif]-->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Author -->
    <meta name="author" content="TenTwenty | Webdesign, Webshops & E-marketing | Dubai">

    <!-- Below tag will be used for android mobile browser colors, change it to main logo color of the project -->
    <meta name="theme-color" content="#393939">

    <?php
    $ih = new \Application\Concrete\Helpers\ImageHelper();
    $meta_description = ($c->getAttribute('meta_description')) ? $c->getAttribute('meta_description') : $page->getCollectionDescription();

    $meta_title = ($c->getAttribute('meta_title')) ? $c->getAttribute('meta_title') : $site . " | " . $page->getCollectionName();
    $seo_image = $c->getAttribute('seo_image');
    $banner_image = $c->getAttribute('banner_image');
    $thumbnail_image = $c->getAttribute('thumbnail_image');
    $listing_image = $c->getAttribute('listing_image');
    if ($seo_image) {
        $meta_image = $ih->getThumbnail($seo_image, 1000, 1000);
    } elseif (!$seo_image && $banner_image) {
        $meta_image = $ih->getThumbnail($banner_image, 1000, 1000);
    } else if (!$banner_image && $thumbnail_image) {
        $meta_image = $ih->getThumbnail($thumbnail_image, 1000, 1000);
    } else if (!$banner_image && !$thumbnail_image && $listing_image) {
        $meta_image = $ih->getThumbnail($listing_image, 1000, 1000);
    } else {
        $meta_image = BASE_URL . $this->getThemePath() . "/dist/images/logo.png";
    }
    ?>

    <!-- Meta Tags for Social Media -->
    <meta property="og:site_name" content="<?php echo $site; ?>">
    <meta property="og:image" content="<?php echo $meta_image; ?>">
    <meta property="og:title" content="<?= $meta_title; ?>">
    <meta property="og:description" content="<?php echo  $meta_description; ?>">
    <meta name="twitter:title" content="<?= $meta_title; ?>">
    <meta name="twitter:image" content="<?php echo $meta_image; ?>">
    <meta name="twitter:description" content="<?php echo  $meta_description; ?>">
    <meta name="twitter:card" content="summary_large_image" />

    <?php
    //print core cms files
    $metaTitle = $c->getAttribute('meta_title');
    $template = $c->getPageTemplateObject();
    $title = $metaTitle ? $metaTitle : ($pageType == 'home' || is_object($template) && $template->getPageTemplateHandle() === 'homepage' ?  $site :  $page->getCollectionName() . ' | ' . $site);
    View::element('header_required', [
        'pageTitle' => isset($title) ? $title : '',
        'pageDescription' => isset($pageDescription) ? $pageDescription : $page->getCollectionDescription(),
        'pageMetaKeywords' => isset($pageMetaKeywords) ? $pageMetaKeywords : ''
    ]);

    //custom css files
    $direction = "";
    if ($is_arabic == 1) {
        $direction = ".rtl";
        $bodyClass .= ' page-arabic';
    }

    //custom css files
    // $this->addHeaderItem($htmlHelper->css('css/all.css'));
    // $this->addHeaderItem($htmlHelper->css('css/style.css'));
    // $this->addHeaderItem($htmlHelper->css('css/print.css'));
    ?>
    <!-- <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/dist/css/vendors.min.css'; ?>">     -->
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/dist/css/app.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/bootstrap.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/slick.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/swiper-bundle.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/magnific-popup.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/font-awesome-pro.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/spacing.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/atropos.min.css' ?>">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/assets/css/main.css' ?>">

    <?php
    if ($is_arabic == 1) {
    ?>
        <link rel="stylesheet" href="<?php echo $this->getThemePath() . '/dist/css/arabic.min.css?v=' . $version; ?>">
    <?php
    }

    ?>
    <script>
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style');
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            );
            document.querySelector('head').appendChild(msViewportStyle);
        }

        //set cookie for site
        function setCookie(cname, cvalue) {
            var d = new Date();
            d.setTime(d.getTime() + 2160000000);
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
        }
    </script>

</head>

<body class="tp-magic-cursor black-bg-4 <?php echo $bodyClass; ?>">
    <!-- Site Loader -->
    <div class="site-loader">
        <div class="logo-middle">
            <img src="<?php echo $this->getThemePath(); ?>/assets/images/logo.png" alt="<?php echo $site; ?>" />
        </div>
    </div>

    
    <script>
        if (document.cookie.indexOf("visited=") == -1) {
            setCookie("visited", "1");
            $('.site-loader').show();
        }
    </script>
    <!-- Site Loader End -->
    
            <div class="wrapper <?php echo $c->getPageWrapperClass() ?>"><!-- opening of wrapper div ends in footer_bottom.php -->