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


class WC_Bom_material {

	public function __construct() {

		add_action( 'init', [ $this, 'register_material' ] );
		add_action( 'init', [ $this, 'register_material_cat' ] );
		//add_action( 'init', [ $this, 'register_procurement_type' ] );
		//add_action( 'init', [ $this, 'register_location' ] );
		//add_action( 'init', [ $this, 'register_phase' ] );

		add_action( 'init', [ $this, 'register_vendor' ] );
		add_action( 'init', [ $this, 'register_material_tags' ] );
	}


	public function register_material() {

		$labels = [
			'name'          => __( 'Parts', 'wc-bom' ),
			'singular_name' => __( 'Part', 'wc-bom' ),
			'menu_name'     => __( 'Parts', 'wc-bom' ),
			'all_items'     => __( 'All Parts', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Parts', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
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
			'rewrite'             => [ 'slug' => 'part', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-admin-tools',
			'supports'            => [
				'title',
				//'editor',
				'thumbnail',
				//'excerpt',
				//'comments',
				'revisions',
				'author',
				'page-attributes',
			],
		];

		register_post_type( 'part', $args );
	}


	public function register_material_cat() {

		$labels = [
			'name'          => __( 'Part Categories', 'wc-bom' ),
			'singular_name' => __( 'Part Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Part Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'part-category', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'part-category', [ 'part' ], $args );



		if ( ! has_term( 'part', 'part-category' ) ) {
			wp_insert_term( 'Part', 'part-category', [ 'Part', 'part' ] );
		}

		if ( ! has_term( 'component', 'part-category' ) ) {
			wp_insert_term( 'Component', 'part-category', [ 'Component', 'component' ] );
		}

		if ( ! has_term( 'raw-material', 'part-category' ) ) {
			wp_insert_term( 'Raw Material', 'part-category', [ 'Raw Material', 'raw-material' ] );
		}

	}


	public function register_procurement_type() {

		$labels = [
			'name'          => __( 'Procurement Types', 'wc-bom' ),
			'singular_name' => __( 'Procurement Type', 'wc-bom' ),
			'menu_name'     => __( 'Procurements', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Procurement Types', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'procurement-type', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'procurement-type',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'procurement_type', [ 'part' ], $args );
	}


	public function register_vendor() {

		$labels = [
			'name'          => __( 'Vendors', 'wc-bom' ),
			'singular_name' => __( 'Vendor', 'wc-bom' ),
			'menu_name'     => __( 'Vendors', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Vendors', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'vendors', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'vendors',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'vendors', [ 'part' ], $args );
	}


	public function register_location() {

		$labels = [
			'name'          => __( 'Locations', 'wc-bom' ),
			'singular_name' => __( 'Location', 'wc-bom' ),
			'menu_name'     => __( 'Locations', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Locations', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'locations', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'locations',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'locations', [ 'part' ], $args );
	}

	public function register_phase() {

		$labels = [
			'name'          => __( 'Phases', 'wc-bom' ),
			'singular_name' => __( 'Phase', 'wc-bom' ),
			'menu_name'     => __( 'Phases', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Phases', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'phases', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'phases',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'phases', [ 'part' ], $args );
	}


	public function register_material_tags() {

		$labels = [
			'name'          => __( 'Part Tags', 'wc-bom' ),
			'singular_name' => __( 'Part Tag', 'wc-bom' ),
			'menu_name'     => __( 'Tags', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Part Tags', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => false,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'part-tags', 'with_front' => true, 'hierarchical' => false, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'part_tags', [ 'part', 'assembly', 'inventory','ecn' ], $args );
	}

}


$obj = new WC_Bom_material();