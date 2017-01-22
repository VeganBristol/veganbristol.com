<? get_header();

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}



function display_links() {

	$website = get_field('website', get_the_ID());
	$facebook = get_field('facebook', get_the_ID());
	$instagram = get_field('instagram', get_the_ID());
	$twitter = get_field('twitter', get_the_ID());

	if($website != '') 
	{
		echo("\n");
		echo("<a href='" . $website . "' target='_blank'><div class='weblink'> </div></a>");
	}
	if($facebook != '')
	{
		echo("\n");
		echo("<a href='https://www.facebook.com/" . $facebook . "' target='_blank'><div class='facebooklink'> </div></a>");
	}
	if($instagram != '')
	{
		echo("\n");
		echo("<a href='https://www.instagram.com/" . $instagram . "' target='_blank'><div class='instagramlink'> </div></a>");
	}
	if($twitter != '')
	{
		echo("\n");
		echo("<a href='https://www.twitter.com/" . $twitter . "' target='_blank'><div class='twitterlink'> </div></a>");
	}

	$values = get_field('location');

	if($values)
	{
		$lng = $values['lng'];
		$lat = $values['lat'];

		$add = str_replace(' ', '+', $values['address']);

		$link = "http://www.google.com/maps/place/" . $add . "/@" . $lat . "," . $lng;

		$out = "\n<a href='" . $link . "' target='_blank'><div class='locationlink'> </div></a>";
		echo $out;
	}
}


function post_type_tags( $post_type = '' ) {
    global $wpdb;

    if ( empty( $post_type ) ) {
        $post_type = get_post_type();
    }

    return $wpdb->get_results( $wpdb->prepare( "
        SELECT COUNT( DISTINCT tr.object_id ) 
            AS count, tt.taxonomy, tt.description, tt.term_taxonomy_id, t.name, t.slug, t.term_id 
        FROM {$wpdb->posts} p 
        INNER JOIN {$wpdb->term_relationships} tr 
            ON p.ID=tr.object_id 
        INNER JOIN {$wpdb->term_taxonomy} tt 
            ON tt.term_taxonomy_id=tr.term_taxonomy_id 
        INNER JOIN {$wpdb->terms} t 
            ON t.term_id=tt.term_taxonomy_id 
        WHERE p.post_type=%s 
            AND tt.taxonomy='post_tag' 
        GROUP BY tt.term_taxonomy_id 
        ORDER BY count DESC
    ", $post_type ) );
}

function display_terms_together($taxonomy) {
	$vals = array();

	foreach((array)$taxonomy as $tax) {
		$values = get_the_terms(get_the_ID(), $tax);

		foreach( (array) $values as $val ) {
			$vals[] = "\n<a class='" . $tax . "-itemss tagitem' href='#'>" . $val->name . "</a> ";
		}
	}
	echo (implode(" ", $vals));
}


$field = get_field_object('field_588354174cac8');
// echo(implode(', ', $field['choices']));



?>



<div class="container">

<div id='taglists'>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-2">
<p>
<form id="search">
<input type="text" id="filter">
</form>
<button id="resetbutton">Show me everything</button>
</p>
</div>
<div class="col-sm-8 rightalign">
<!-- Get list of tags -->

<?


$term1 = get_terms(array('taxonomy' => 'business-type','hide_empty' => true));
$term2 = get_terms(array('taxonomy' => 'neighbourhood','hide_empty' => true));
$term3 = get_terms(array('taxonomy' => 'cuisine','hide_empty' => true));
$term4 = post_type_tags('business');


echo("<div class='row'>\n");
foreach((array) $term1 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem business-type-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div>\n");

echo("<div class='row'>\n");
foreach((array) $term2 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem neighbourhood-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div>\n");

echo("<div class='row'>\n");
foreach($term3 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem cuisine-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div>\n");

echo("<div class='row'>\n");
foreach($term4 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem post_tag-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div>\n");

?>

</div></div></div>

<div class="parent">

<?
$myposts = get_posts(array(
				'post_type'=> 'business',
				'posts_per_page'=>'1000', 
				'post_status'=>'publish', 
				'order'=>'ASC'));


foreach($myposts as $post) :


	$vals = array();
	$vals2 = array();
	$values = get_the_terms(get_the_ID(), 'business-type');
	// var_dump($values);
	foreach((array) $values as $val) :
		if (isset($val->term_id)) $vals[] = $val->term_id;
		if (isset($val->slug)) $vals2[] = $val->slug;
	endforeach;
	$values = get_the_terms(get_the_ID(), 'cuisine');
	foreach((array) $values as $val) :
		if (isset($val->term_id)) $vals[] = $val->term_id;
		if (isset($val->slug)) $vals2[] = $val->slug;
	endforeach;
	$values = get_the_terms(get_the_ID(), 'neighbourhood');
	foreach((array) $values as $val) :
		if (isset($val->term_id)) $vals[] = $val->term_id;
		if (isset($val->slug)) $vals2[] = $val->slug;
	endforeach;
	$values = get_the_terms(get_the_ID(), 'post_tag');
	foreach((array) $values as $val) :
		if (isset($val->term_id)) $vals[] = $val->term_id;
		if (isset($val->slug)) $vals2[] = $val->slug;
	endforeach;
	
	echo("<div class='listing' data-term=':r");
	echo(implode("::r", $vals));
	echo(":' data-title='". $post->post_name . " " . implode(' ', $vals2) . "'>\n");


	global $post;
	setup_postdata($post);
	$post_slug=$post->post_name;

	echo("<a style='display:block;' href='#'><div class='internal'>");

	echo("<div class='hvdiv'><h4>"); 
	the_title();
	echo("</h4></div>");

	echo("<div class='pdiv'>");
	// $field = get_field_object('veglevel');
	$value = get_field('veglevel');


	$location = get_field('location');
	if($location)
	{
		echo("<p>" . $location['address'] . "</p>");		
	}
	echo("<p>" . the_field('veglevel') . "</p>");
	// echo("<p>" . get_class($field) . "</p>");
	echo("</div>");


echo("\n<div class='displaylinks'>");
display_links();
echo("\n&nbsp;</div>\n");

	
	// display_terms_together(array('business-type', 'neighbourhood', 'cuisine', 'post_tag'));

	echo("</div></a></div>\n");


endforeach;

?>

</div> <!-- parent -->

</div> <!-- container -->

</body>


<script>

var IDs = [];
$("#taglists").find("input").each(function(){ IDs.push(this.id); });
var $allboxes = $('input[name=tag]');
var nboxes = $allboxes.length;
var $boxes = $allboxes;

$('#filter').on('keyup', function() {
    var keyword = $(this).val().toLowerCase();
    $('.listing').each( function() {
        $(this).toggle( keyword.length < 1 || $(this).attr('data-title').indexOf(keyword) > -1 );
    });
});

$("#resetbutton").click(function()
{
	$(".listing").hide()
	$.each(IDs, function(index, value) {
		$('#'+value).prop('checked', true);
		$('div[data-term*="'+value+'"]').show();
	})
	nboxes = $allboxes.length;
})


$(".button-bt").click(function() {
	$(".listing").hide()
 	$boxes = $('input[name=tag]:checked');
	if($boxes.length == 0) {
  		$.each(IDs, function(index, value) {
			$('#'+value).prop('checked', true);
     		$('div[data-term*="'+value+'"]').show();
    })
  	} else if($allboxes.length == ($boxes.length+1) && $allboxes.length == nboxes) {
  		$.each(IDs, function(index, value) {
			$('#'+value).prop('checked', false);
    })
		$('#'+this.id).prop('checked', true);
    $('div[data-term*="'+this.id+'"]').show();
	} else {
  	$.each(IDs, function(index, value) {
      if($('#'+value).prop('checked'))
      {
          $('div[data-term*="'+value+'"]').show();
      }
    })
  }
  if($boxes.length == 0)
  	nboxes = $allboxes.length;
  else
	  nboxes = $boxes.length;
});

</script>


</html>
