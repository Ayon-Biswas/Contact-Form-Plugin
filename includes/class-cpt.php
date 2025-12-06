<?php

class CFP_Custom_Post_Types{
    function __construct(){
        add_action( 'init', [$this,'cptui_register_my_cpts_cfp_submission'] );
    }
    function cptui_register_my_cpts_cfp_submission() {

	/**
	 * Post Type: Submissions CPT.
	 */

	$labels = [
		"name" => esc_html__( "Submissions CPT", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Submission CPT", "twentytwentyfive" ),
	];

	$args = [
		"label" => esc_html__( "Submissions CPT", "twentytwentyfive" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => false,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "cfp_submission", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor" ],
		"show_in_graphql" => false,
	];

	register_post_type( "cfp_submission", $args );

    $args1 = array(
    'post_type' => 'post', // Or your desired post type
    'meta_query' => array(
        array(
            'key'     => 'your_meta_key', // The meta key to search within
            'value'   => '%search_term%', // The value to search for, with wildcards
            'compare' => 'LIKE',           // Specify the LIKE operator
        ),
      ),
    );
   $query = new WP_Query( $args1 );
}
}
