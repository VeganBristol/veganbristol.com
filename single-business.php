<? get_header() ?>

<?php if ( have_posts() ) : while( have_posts() ) : the_post();


function display_terms($taxonomy) {
	$values = get_the_terms(get_the_ID(), $taxonomy);
	$vals = array();
	foreach($values as $val) {
		$vals[] = "<a class='tag-item' href='#'>" . $val->name . "</a> ";
	}

	echo ("<p>" . implode(", ", $vals) . "</p>");
}


function display_links() {

	$website = get_field('website', get_the_ID());
	$facebook = get_field('facebook', get_the_ID());
	$instagram = get_field('instagram', get_the_ID());
	$twitter = get_field('twitter', get_the_ID());

	echo("<div class='link-section'>");
	if($website != '') 
	{
		echo("<p class='weblink summary-link'>Website: <a class='weblink summary-link' href='" . $website . "' target='_blank'>" . $website . "</a></p>");
	}
	if($facebook != '')
	{
		echo("<p class='facebooklink summary-link'>Facebook: <a class='facebooklink summary-link' href='https://www.facebook.com/" . $facebook . "' target='_blank'>" . $facebook . "</a></p>");
	}
	if($instagram != '')
	{
		echo("<p class='instagramlink summary-link'>Instagram: <a class='instagramlink summary-link' href='https://www.instagram.com/" . $instagram . "' target='_blank'>" . $instagram . "</a></p>");
	}
	if($twitter != '')
	{
		echo("<p class='twitterlink summary-link'>Twitter: <a class='twitterlink summary-link' href='https://www.twitter.com/" . $twitter . "' target='_blank'>" . $twitter . "</a></p>");
	}
	echo("</div>");
}


function display_content($keep_images='true')
{
	// if($keep_images = 'true')
	// {
	// 	the_content();
	// } else {
		$content = get_the_content();
		$content = preg_replace("/<img[^>]+\>/i", " ", $content);          
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]>', $content);
		echo $content;		
	// }
}


function display_address() {
	$values = get_field('location');

	$lng = $values['lng'];
	$lat = $values['lat'];

	$add = str_replace(' ', '+', $values['address']);

	$link = "http://www.google.com/maps/place/" . $add . "/@" . $lat . "," . $lng;

	$out = "<div class='summary-location'><p class='address'>" . $values['address'] . "<a href='" . $link . "' target='_blank'> [ google maps ]</a></p>";
	echo $out;
}


echo ("<div class='container'>");
echo ("<div class='summary-area'>");

echo ("<h1>");
the_title();
echo ("</h1>");


// Taxonomies

echo ("<div class='tag-list taxonomy-list'>");
display_terms("post_tag");
echo("</div>");

echo ("<div class='neighbourhood-list taxonomy-list'>");
display_terms("neighbourhood");
echo("</div>");

echo ("<div class='business-type-list taxonomy-list'>");
display_terms("business-type");
echo("</div>");

echo ("<div class='cuisine-list taxonomy-list'>");
display_terms("cuisine");
echo("</div>");


// Links

display_links();


// Location

display_address();


echo("</div> <!-- summary-area -->");


// Content

display_content('false');

echo("</div>  <!-- container -->");


// Comments

if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;


endwhile; endif; ?>




<? get_footer(); ?>
