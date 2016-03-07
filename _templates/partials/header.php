<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

    <title><?php echo get('page.title'); ?></title>
    <?php if ( get('page.description') ): ?><meta name="description" content="<?php echo get('page.description'); ?>"><?php endif; ?>
    <meta name="keywords" content="<?php if ( get('page.keywords') ): echo get('page.keywords'); else: echo get('site.keywords'); endif; ?>">
    <?php if ( get('page.canonical') ): ?><link rel="canonical" href="<?php echo get('page.canonical'); ?>"><?php endif; ?>

    <!-- Site wide stylesheets -->
    <?php if ( get('site.stylesheets') ): ?>
        <?php foreach ( get('site.stylesheets') as $stylesheet ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $stylesheet; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Page specific stylesheets -->
    <?php if ( get('page.stylesheets') ): ?>
        <?php foreach ( get('page.stylesheets') as $stylesheet ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $stylesheet; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Touch icons & Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php assets_dir(); ?>/images/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php assets_dir(); ?>/images/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php assets_dir(); ?>/images/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php assets_dir(); ?>/images/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php assets_dir(); ?>/images/icons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/x-icon" href="<?php assets_dir(); ?>/images/icons/favicon.ico">

</head>
<body class="page-<?php echo get('page.slug'); ?>" itemscope itemtype="http://schema.org/WebPage">

    <?php get_partial('browser-update'); ?>

    <header id="site-header" class="site-header">
        <div class="container">

            <div class="contact-info">
                <span><i class="fa fa-envelope"></i> <?php echo get('site.email'); ?></span>
                <span><i class="fa fa-phone"></i> <?php echo get('site.phone'); ?></span>
            </div>

            <a class="logo">
                <img src="http://placehold.it/200x60">
            </a>

            <a class="nav-toggle" href="#">
                <i class="fa fa-navicon"></i>
            </a>

            <nav id="site-nav" class="header-nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>

        </div>
    </header>
