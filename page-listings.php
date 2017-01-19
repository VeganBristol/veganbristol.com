<? get_header();

function display_terms_together($taxonomy) {
	$vals = array();

	foreach($taxonomy as $tax) {

		$values = get_the_terms(get_the_ID(), $tax);

		foreach($values as $val) {
			$vals[] = "\n<a class='" . $tax . "-item tagitem' href='#'>" . $val->name . "</a> ";
		}

	}
	echo (implode(" ", $vals));
}



 ?>


<div class="container">


<!-- Get list of tags -->

<?


	$term1 = get_terms(array(
    	'taxonomy' => 'business-type',
    	'hide_empty' => false
	));
	$term2 = get_terms(array(
    	'taxonomy' => 'neighbourhood',
    	'hide_empty' => false
	));
	$term3 = get_terms(array(
    	'taxonomy' => 'cuisine',
    	'hide_empty' => false
	));
	$term4 = get_terms(array(
    	'taxonomy' => 'post_tag',
    	'hide_empty' => true
	));


echo('<div class="btn-group" role="group">');
foreach($term1 as $term) :
	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
	echo($term->name);
	echo("</button>");
endforeach;
echo("</div>");
echo('<div class="btn-group" role="group">');
foreach($term2 as $term) :
	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
	echo($term->name);
	echo("</button>");
endforeach;
echo("</div>");
echo('<div class="btn-group" role="group">');
foreach($term3 as $term) :
	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
	echo($term->name);
	echo("</button>");
endforeach;
echo("</div>");
// echo('<div class="btn-group" role="group">');
// foreach($term4 as $term) :
// 	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
// 	echo($term->name);
// 	echo("</button>");
// endforeach;
// echo("</div>");


?>


<input type="button" id="test" value="Toggle 830" />



<input type="text" id="filter">
<ul class="cars">
    <li data-models="mustang, f150, 500, fusion">Ford</li>
    <li data-models="corvette, silverado, impala, cavalier">Chevrolet</li>
    ...
</ul>

<script>
$('#filter').on('keyup', function() {
    var keyword = $(this).val().toLowerCase();
    $('.cars > li').each( function() {
        $(this).toggle( keyword.length < 1 || $(this).attr('data-models').indexOf(keyword) > -1 );
    });
});
</script>

<script>
$("#test").click(function(){
    $('div[data-term="830"]').toggle();
});
</script>
<?


$myposts = get_posts(array(
				'post_type'=> 'business',
				'posts_per_page'=>'100', 
				'post_status'=>'publish', 
				'order'=>'ASC'));


foreach($myposts as $post) :


	$values = get_the_terms(get_the_ID(), 'business-type');
	echo("<div class='listing' ");
	foreach($values as $val) :
		echo("data-term='" . $val->term_id . "' ");
	endforeach;
	echo(">\n");


	global $post;
	setup_postdata($post);
	$values = get_field('location');
	$lat = $values['lat'];
	$lng = $values['lng'];
	$post_slug=$post->post_name;


	echo("<h3>"); 
	the_title();
	echo("</h3>");

	display_terms_together(array('business-type', 'neighbourhood', 'cuisine', 'post_tag'));

	echo("</div>\n");


endforeach;

?>

</div>

</body>
</html>
