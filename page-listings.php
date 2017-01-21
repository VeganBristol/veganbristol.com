<? get_header();

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

	foreach($taxonomy as $tax) {
		$values = get_the_terms(get_the_ID(), $tax);

		foreach( $values as $val ) {
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

$term4 = post_type_tags('business');

// $term4 = get_terms(array(
// 	'taxonomy' => 'post_tag',
// 	'hide_empty' => true
// ));


foreach($term1 as $term) :

	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever business-type-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;

foreach($term2 as $term) :

	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever neighbourhood-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;

foreach($term3 as $term) :

	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever cuisine-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;

foreach($term4 as $term) :

	echo("<input checked type='checkbox' name='tag' id='r" . $term->term_id . "' class='button-bt' data-termid=':" . $term->term_id . ":'>\n");
	echo("<label class='whatever post_tag-item' for='r" . $term->term_id . "'>" . $term->name . "</label>\n");

endforeach;

?>

</div></div></div>

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
  nboxes = $boxes.length;
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
	
	echo("<div class='listing' data-term=':r");
	echo(implode("::r", $vals));
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
