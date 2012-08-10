<?php
$frontpage_title = 'Christian Fellowship @ UC Berkeley';
require('disqus.php');
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
         Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <title>
    <?php 
        if (is_front_page()) {
    		echo $frontpage_title;
            $id = 'home';
    	} elseif (is_search()) {
    	    bloginfo('name');?> &raquo; Search Results for: <?php echo wp_specialchars($s, 1);
    	} else {
    	    wp_title('',true); ?> &#8212; <?php bloginfo('name');
            if (is_page() || is_category()) $id = 'page';
            elseif (is_single()) $id = 'post';
    	} 
    ?>
    </title>

    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico">

     <!-- CSS: implied media=all -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/text.css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/grid.css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    
    <!-- JS files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/galleria/galleria-1.2.5.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/galleria/plugins/flickr/galleria.flickr.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/galleria/themes/folio/galleria.folio.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.validate.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/magazine.js"></script>
    
    <?php do_action('wp_head'); ?>
    
</head>

<body class="<?php echo $id; ?>-wrapper">

    <div id="wrapper">
		<header class="container_16 clearfix">
	        <div id="header-nav" class="grid_16">
	            <div class="pull-left">
					<h1 id="logo" class="textshadow"><a href="<?php echo get_option('home'); ?>/">Koinonia</a></h1>
					<div class="nav textshadow">
						<div class="small-heading">christian fellowship</div> 
						<div class="small-heading">UC Berkeley</div>
					</div>
				</div>
				<div class="pull-right">
		            <div class="nav textshadow">
		                <a href="<?php echo get_option('home');?>/about">about</a>
		                <a href="<?php echo get_option('home');?>/getconnected">get connected</a>
		                <a href="<?php echo get_option('home');?>/signups">signups</a>
		                <a href="<?php echo get_option('home');?>/contact">contact</a>
		                <a href="<?php echo get_option('home');?>/archives">archives</a>
					</div>
				</div>
	        </div>
	    </header>
