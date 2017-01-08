<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <?php wp_head(); ?>

        <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">

	    <style>
	      /* Always set the map height explicitly to define the size of the div
	       * element that contains the map. */
	      #map {
	        height: 100%;
	        position: relative;
	      }
	      /* Optional: Makes the sample page fill the window. */
	      html, body {
	        height: 100%;
	        margin: 0;
	        padding: 0;
	      }

	      #overmap {
	      	position: absolute; top: 10px; right: 10px; z-index: 99;
	      	padding: 30px;
	      	/*width: 25%;*/
	      }

	      .overmap_item {
	      	background-color: rgba(255, 255, 255, 0.9);
	      	margin-bottom: 10px;
	      	display:inline-block;
	      	padding: 5px;
	      	color: #333;
	      	font-size: 20px;
	      	text-align: right;
	      }

	    </style>
    </head>

<body>

