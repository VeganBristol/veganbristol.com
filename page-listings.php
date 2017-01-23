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


$veglevels = get_field_object('field_588515b86025f');
// echo(implode(', ', $veglevels['choices']));
// var_dump($veglevels);


?>



<div class="container">

<div id='taglists'>
<div class="row">
<div class='col-sm-1'>
	<a id="showmoretags" href="#">
		<span class="glyphicon glyphicon-circle-arrow-down"></span>
	</a>
	<a id="resetbutton" href="#">
		<span class="glyphicon glyphicon-refresh"></span>
	</a>
</div>
<div class="col-sm-11">
	<div id="extratags" class="row" style='border-bottom: 1px solid grey; padding-bottom: 20px; margin-bottom: 20px;'>
		<div class="col-sm-12 rightalign">
		<!-- Get list of tags -->

<?


$term1 = get_terms(array('taxonomy' => 'business-type','hide_empty' => true));
$term2 = get_terms(array('taxonomy' => 'neighbourhood','hide_empty' => true));
$term3 = get_terms(array('taxonomy' => 'cuisine','hide_empty' => true));
$term4 = post_type_tags('business');


echo("<div class='row'><div class='col-sm-11'>\n");
foreach((array) $term1 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem business-type-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div><div class='col-sm-1 left-align'><p>Business type</p></div></div>\n");

echo("<div class='row'><div class='col-sm-11'>\n");
foreach((array) $term2 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem neighbourhood-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div><div class='col-sm-1 left-align'><p>Neighbourhood</p></div></div>\n");

echo("<div class='row'><div class='col-sm-11'>\n");
foreach($term3 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem cuisine-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div><div class='col-sm-1 left-align'><p>Cuisine</p></div></div>\n");

echo("<div class='row'><div class='col-sm-11'>\n");
foreach($term4 as $term) :
	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever tagitem post_tag-items' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");
endforeach;
echo("</div><div class='col-sm-1 left-align'><p>Tags</p></div></div>\n");

?>

		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 rightalign">
			<div class="row">

				<?
				$vc = (array) $veglevels['choices'];
				while ($term = current($vc)) {
					echo("<input checked type='checkbox' name='tag' id='r" . key($vc) . "' class='button-bt' data-termid=':" . key($vc) . ":'>\n");
					echo("<label class='whatever tagitem vlevel' for='r" . key($vc) . "'>" . $term . "</label>\n");
					next($vc);
				}
				?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<form id="search">
				<p>
					<input type="text" id="filter"> <span class="displaycount"></span>
				</p>
				</form>
			</div>
			<div class="row">
			</div>
		</div>
	</div>



</div>

<div class="row">

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
	
	echo("<div class='col-xs-6 col-sm-4 col-md-3 listing' data-term=':r" . get_field('vlevel') . "::r");
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


	$veglevel = get_field('vlevel');
	if($veglevel)
	{
		echo("<p class='whatever tagitem vlevel'>" . $veglevels['choices'][ $veglevel ] . "</p>");

	}

	$location = get_field('location');
	if($location)
	{
		echo("<p>" . $location['address'] . "</p>");		
	}
	echo("</div>");


echo("\n<div class='displaylinks'>");
display_links();
echo("\n&nbsp;</div>\n");

	
	// display_terms_together(array('business-type', 'neighbourhood', 'cuisine', 'post_tag'));

	echo("</div></a></div>\n\n");


endforeach;

?>
</div></div>
</div> <!-- row -->

</div> <!-- parent -->

</div> <!-- container -->

</body>


<script>

var IDs = [];
$("#taglists").find("input").each(function(){ IDs.push(this.id); });
var $allboxes = $('input[name=tag]');
var nboxes = $allboxes.length;
var $boxes = $allboxes;
$("#extratags").hide();

function printDisplayCount() {
	var showing = $(".listing:visible").length;
	var total = $(".listing").length;
	// if(showing == total)
	// {
	// 	$('#resetbutton').hide();
	// } else {
	// 	$('#resetbutton').show();
	// }
	$('.displaycount').html("Showing "+showing+" of "+total+" listings");
}

printDisplayCount();


$('#filter').on('keyup', function() {
    var keyword = $(this).val().toLowerCase();
    $('.listing').each( function() {
        $(this).toggle( keyword.length < 1 || $(this).attr('data-title').indexOf(keyword) > -1 );
        printDisplayCount();
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
	printDisplayCount();
})

$("#showmoretags").click(function()
{
if ( $( "#extratags" ).is( ":hidden" ) ) {
    $( "#extratags" ).slideDown();
  } else {
    $( "#extratags" ).slideUp();
  }
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
  printDisplayCount();
});

</script>


</html>
