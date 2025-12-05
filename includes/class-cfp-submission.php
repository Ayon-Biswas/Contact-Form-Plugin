<?php
function cptui_register_my_cpts_support() {

	/**
	 * Post Type: Supports.
	 */

	$labels = [
		"name" => esc_html__( "Supports", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Supports", "twentytwentyfive" ),
	];

	$args = [
		"label" => esc_html__( "Supports", "twentytwentyfive" ),
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
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "support", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor" ],
		"show_in_graphql" => false,
	];

	register_post_type( "support", $args );
}

add_action( 'init', 'cptui_register_my_cpts_support' );

