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


class WC_Bom_Assembly {

	public function __construct() {

		add_action( 'init', [ $this, 'register_assembly' ] );
		add_action( 'init', [ $this, 'register_assembly_cat' ] );
	}

	public function init() {

	}


	public function register() {

	}

	public function register_assembly() {

		$labels = [
			'name'          => __( 'Assemblies', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assembly', 'wc-bom' ),
			'all_items'     => __( 'All Assemblies', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Assemblies', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Post type for assemblies build by combining materials with parts.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'assembly',
			'has_archive'         => 'assemblies',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'assembly', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-hammer',
			'supports'            => [
				'title',
				//'editor',
				'thumbnail',
				'revisions',
				'author',
				'page-attributes',
			],
		];

		register_post_type( 'assembly', $args );
	}


	public function register_assembly_cat() {

		$labels = [
			'name'          => __( 'Assembly Categories', 'wc-bom' ),
			'singular_name' => __( 'Assembly Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Assembly Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'assembly-category', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'sssembly-category',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'assembly_category', [ 'assembly' ], $args );
	}




}


$obj = new WC_Bom_Assembly();