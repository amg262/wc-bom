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

namespace WooBom;

class WC_Bom_material {

	public function __construct() {

		add_action( 'init', [ $this, 'register_material' ] );
		add_action( 'init', [ $this, 'register_material_cat' ] );
		add_action( 'init', [ $this, 'register_procurement_type' ] );
		add_action( 'init', [ $this, 'register_location' ] );

		add_action( 'init', [ $this, 'register_vendor' ] );
		add_action( 'init', [ $this, 'register_material_tags' ] );
	}


	public function register_material() {

		$labels = [
			'name'          => __( 'Materials', 'wc-bom' ),
			'singular_name' => __( 'Material', 'wc-bom' ),
			'menu_name'     => __( 'Material', 'wc-bom' ),
			'all_items'     => __( 'All Materials', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Materials', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'Material',
			'has_archive'         => 'Materials',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'material', 'with_front' => true ],
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

		register_post_type( 'material', $args );
	}


	public function register_material_cat() {

		$labels = [
			'name'          => __( 'Material Categories', 'wc-bom' ),
			'singular_name' => __( 'Material Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Material Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'material-category', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'material-category',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'material_category', [ 'material' ], $args );

		if (! has_term( 'geoposts', 'geopost-category' )) {
			wp_insert_term( 'GeoPosts','geopost-category', array('GeoPosts', 'geoposts') );
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
		register_taxonomy( 'procurement_type', [ 'material' ], $args );
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
		register_taxonomy( 'vendors', [ 'material' ], $args );
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
		register_taxonomy( 'locations', [ 'material' ], $args );
	}


	public function register_material_tags() {

		$labels = [
			'name'          => __( 'Material Tags', 'wc-bom' ),
			'singular_name' => __( 'Material Tag', 'wc-bom' ),
			'menu_name'     => __( 'Material Tags', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Material Tags', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => false,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'material-tags', 'with_front' => true, 'hierarchical' => false, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'Material-tags',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'material_tags', [ 'material', 'assembly' ], $args );
	}

}


$obj = new WC_Bom_material();