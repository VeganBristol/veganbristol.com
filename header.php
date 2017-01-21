<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>

        <?php wp_head(); ?>

        <!-- <link href="http://explodecomputer.com/veganbristol2017/wp-content/themes/veganbristol.com/css/bootstrap.min.css" rel="stylesheet"> -->

        <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
        <link href="http://explodecomputer.com/veganbristol2017/wp-content/themes/veganbristol.com/css/listings.css" rel="stylesheet">
        <link href="http://explodecomputer.com/veganbristol2017/wp-content/themes/veganbristol.com/css/map.css" rel="stylesheet">
    </head>
<body>

