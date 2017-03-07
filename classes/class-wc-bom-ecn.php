<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 3/6/17
 * Time: 8:03 PM
 */


class WC_Bom_Ecn {

	public function __construct() {

		add_action( 'init', [ $this, 'register_ecn' ] );
		//add_action( 'init', [ $this, 'register_inventory_cat' ] );
	}


	public function register_ecn() {
		/**
		 * Post Type: Change Notices.
		 */

		$labels = [
			'name'          => __( 'Change Notice', 'wc-bom' ),
			'singular_name' => __( 'Change Notice', 'wc-bom' ),
			'menu_name'     => __( 'ECN', 'wc-bom' ),
			'all_items'     => __( 'All Notices', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Change Notices', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'change-notice', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-flag',
			'supports'            => [ 'title',
			                           //  'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'ecn', $args );

	}

}


$obj = new WC_Bom_Ecn();