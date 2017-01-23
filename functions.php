<?php

add_action( 'acf/fields/google_map_extended/api', function( $key ) {
	$key = 'AIzaSyDvfhHopNdtPTjvZx8LfrJLjCiQwrHzfH0';
	return $key;
} );


add_filter( 'manage_edit-business_columns', 'my_edit_business_columns' ) ;

function my_edit_business_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'tags' => __( 'Tags' ),
		'business-type' => __( 'Business Type' ),
		'vlevel' => __( 'Veg Level' ),
		'cuisine' => __( 'Cuisine' ),
		'comments' => __( '<span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span>' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_business_posts_custom_column', 'my_manage_business_columns', 10, 2 );


// $fieldName = 'wpcf-vlevel';
// $customField = substr($fieldName, 5);  
// $fieldConfig = wpcf_admin_fields_get_field($customField);
// echo $fieldConfig;

function my_manage_business_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'business-type' column. */
		case 'business-type' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'business-type' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'genre' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'business-type', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( '—' );
			}

			break;


		/* If displaying the 'business-type' column. */
		case 'vlevel' :

			/* Get the genres for the post. */
			$term = get_field_object( 'vlevel', $post_id );
			/* If terms were found. */
			if ( !empty( $term['value'] ) ) {
				$value = $term['value'];
			  	echo $term['choices'][$value];  	
			}

			/* If no terms were found, output a default message. */
			else {
				_e( '—' );
			}

			break;

		case 'cuisine' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'cuisine' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'genre' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cuisine', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( '—' );
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}



add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
  		  'menu_slug' => 'Menu 1',
  		)
  	);
}

