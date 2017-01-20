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

<div id='taglists'>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-2">
<p>
<input type="text" id="filter">
</p>
</div>
<div class="col-sm-8 rightalign">
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

	echo("<input checked type='checkbox' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever business-type-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;

foreach($term2 as $term) :

	echo("<input checked type='checkbox' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever neighbourhood-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;

foreach($term3 as $term) :

	echo("<input checked type='checkbox' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever cuisine-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;


?>

</div></div></div>

<script>
$('#filter').on('keyup', function() {
    var keyword = $(this).val().toLowerCase();
    $('.listing').each( function() {
        $(this).toggle( keyword.length < 1 || $(this).attr('data-title').indexOf(keyword) > -1 );
    });
});

$(".button-bt").click(function() {
		var value=this.getAttribute('data-termid');
    if($(this).is(":checked")) {
		$('div[data-term*="'+value+'"]').show('fade');
    } else {
    	$('div[data-term*="'+value+'"]').hide('fade');
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


	$vals = array();
	$vals2 = array();
	$values = get_the_terms(get_the_ID(), 'business-type');
	foreach($values as $val) :
		$vals[] = $val->term_id;
		$vals2[] = $val->slug;
	endforeach;
	$values = get_the_terms(get_the_ID(), 'cuisine');
	foreach($values as $val) :
		$vals[] = $val->term_id;
		$vals2[] = $val->slug;
	endforeach;
	$values = get_the_terms(get_the_ID(), 'neighbourhood');
	foreach($values as $val) :
		$vals[] = $val->term_id;
		$vals2[] = $val->slug;
	endforeach;
	
	echo("<div class='listing' data-term=':");
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
