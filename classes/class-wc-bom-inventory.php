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


class WC_Bom_Inventory {

	public function __construct() {

		add_action( 'init', [ $this, 'register_inventory' ] );
		//add_action( 'init', [ $this, 'register_inventory_cat' ] );
	}


	public function register_inventory() {

		$labels = [
			'name'          => __( 'Inventory', 'wc-bom' ),
			'singular_name' => __( 'Inventory', 'wc-bom' ),
			'menu_name'     => __( 'Inventory', 'wc-bom' ),
			'all_items'     => __( 'All Records', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Inventory Records', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Inventorys post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'inventory-records',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'inventory-record', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-schedule',
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

		register_post_type( 'inventory', $args );
	}


	public function register_inventory_cat() {

		$labels = [
			'name'          => __( 'Inventory Categories', 'wc-bom' ),
			'singular_name' => __( 'Inventory Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Inventory Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'inventory-category', 'with_front' => true, 'hierarchical' => true, ],
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'inventory-category',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'inventory-category', [ 'inventory' ], $args );

		if ( ! has_term( 'requisition', 'inventory-category' ) ) {
			wp_insert_term( 'Requisition', 'inventory-category', [ 'Requisition', 'requisition ' ] );
		}
		if ( ! has_term( 'purchase-order', 'inventory-category' ) ) {
			wp_insert_term( 'Purchase Order', 'inventory-category', [ 'Purchase Order', 'purchase-order' ] );
		}
		if ( ! has_term( 'work-order', 'inventory-category' ) ) {
			wp_insert_term( 'Work Order', 'inventory-category', [ 'Work Order', 'work-order' ] );
		}
		if ( ! has_term( 'receiving', 'inventory-category' ) ) {
			wp_insert_term( 'Receiving', 'inventory-category', [ 'Receiving', 'receiving' ] );
		}

		if ( ! has_term( 'shipping', 'inventory-category' ) ) {
			wp_insert_term( 'Shipping', 'inventory-category', [ 'Shipping', 'shipping' ] );
		}

	}

}


$obj = new WC_Bom_Inventory();