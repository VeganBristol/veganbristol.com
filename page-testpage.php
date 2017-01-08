<?php get_header(); ?>
<?php get_sidebar(); ?>



<?php if ( have_posts() ) : while( have_posts() ) : the_post();
the_content();
endwhile; endif; ?>

testpage






<?


$myposts = get_posts(array(
				'post_type'=> 'business',
				'posts_per_page'=>'100', 
				'post_status'=>'publish', 
				'order'=>'ASC'));

foreach($myposts as $post) :
	global $post;
	setup_postdata($post);
	the_title();
	echo '<br/>';
	get_field('map');
	echo '<br/>';
	echo '<br/>';
endforeach;
wp_reset_postdata(); 

?>
</div>
<?

get_footer(); ?>

