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


foreach($term1 as $term) :
	echo("<input checked type='checkbox' class='button-bt' data-toggle='toggle' data-businesstype=':" . $term->term_id . ":' data-on='" . $term->name . "'  data-off='" . $term->name . "'>\n");


endforeach;
//echo('<div class="btn-group" role="group">');
//foreach($term2 as $term) :
//	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
//	echo($term->name);
//	echo("</button>");
//endforeach;
//echo("</div>");
//echo('<div class="btn-group" role="group">');
//foreach($term3 as $term) :
//	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
//	echo($term->name);
//	echo("</button>");
//endforeach;
//echo("</div>");
// echo('<div class="btn-group" role="group">');
// foreach($term4 as $term) :
// 	echo('<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">');
// 	echo($term->name);
// 	echo("</button>");
// endforeach;
// echo("</div>");


?>

<p>
<input type="text" id="filter">
</p>
<p>
<input type="button" class="testbutton" data-id=':830:' value="Toggle 830" />
<input type="button" class="testbutton" data-id=':898:' value="Toggle 898" />
</p>

<script>
$('#filter').on('keyup', function() {
    var keyword = $(this).val().toLowerCase();
    $('.listing').each( function() {
        $(this).toggle( keyword.length < 1 || $(this).attr('data-title').indexOf(keyword) > -1 );
    });
});
</script>

<script>
// $(".button-bt").click(function(){
//    var value=$(this).data("businesstype");
//    $('div[data-term*="'+value+'"]').toggle("fade");
// });
</script>

<script>
$(".button-bt").click(function() {
		var value=$(this).getAttribute('data-businesstype');
    if($(this).is(":checked")) {
			$('div[data-term*="'+value+'"]').show();
      
    } else {
			$('div[data-term*="'+value+'"]').hide();

    }
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
	$vals = array();
	$vals2 = array();
	echo("<div class='listing' data-term=':");
	foreach($values as $val) :
		$vals[] = $val->term_id;
		$vals2[] = $val->slug;
	endforeach;
	
	echo(implode("::", $vals));
	echo(":' data-title='". $post->post_name . " " . implode(' ', $vals2) . "'>\n");


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
