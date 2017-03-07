<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

namespace WooBom;


/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2/24/17
 * Time: 6:43 PM
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
class WC_Bom_Post {

	/**
	 * WC_Bom_Post constructor.
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'register_posts' ] );
		add_action( 'init', [ $this, 'register_tax' ] );

	}

	public function register_tax() {
		/**
		 * Taxonomy: Inventory Types.
		 */

		$labels = array(
			'name' => __( 'Procurement Types', 'wc-bom' ),
			'singular_name' => __( 'Procurement Type', 'wc-bom' ),
			'menu_name' => __( 'Procurement Types', 'wc-bom' ),
		);

		$args = array(
			'label' => __( 'Procurement Types', 'wc-bom' ),
			'labels' => $labels,
			'public' => true,
			'hierarchical' => true,
			//'label' => 'Inventory Types',
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'procurement-type', 'with_front' => true,  'hierarchical' => true, ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => 'procurement-type',
			'show_in_quick_edit' => true,
		);
		register_taxonomy( 'procurement_type', array( 'part','post','page' ), $args );
	}

	/**
	 *
	 */
	public function register_posts() {

		/**
		 * Post Type: Parts.
		 */

		$labels = [
			'name'          => __( 'Parts', 'wc-bom' ),
			'singular_name' => __( 'Part', 'wc-bom' ),
			'menu_name'     => __( 'Part', 'wc-bom' ),
			'all_items'     => __( 'All Parts', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Parts', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Parts post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'part',
			'has_archive'         => 'parts',
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

		/**
		 * Post Type: Materials.
		 */

		$labels = [
			'name'          => __( 'Materials', 'wc-bom' ),
			'singular_name' => __( 'Material', 'wc-bom' ),
			'menu_name'     => __( 'Materials', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Materials', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Materials post type for the low level raw materials received by a company that are the lowest level of the Bill of Materials.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'material',
			'has_archive'         => 'materials',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'material', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-clipboard',
			'supports'            => [
				'title',
				//'editor',
				'thumbnail',
				'revisions',
				'author',
				'page-attributes' ],
		];

		//register_post_type( 'material', $args );

		/**
		 * Post Type: Assemblies.
		 */

		$labels = [
			'name'          => __( 'Assemblies', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assembly', 'wc-bom' ),

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
			'supports'            => [ 'title',
			                           //'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'assembly', $args );

		/**
		 * Post Type: Change Notices.
		 */

		$labels = [
			'name'          => __( 'Change Notices', 'wc-bom' ),
			'singular_name' => __( 'Change Notice', 'wc-bom' ),
			'menu_name'     => __( 'Change Notices', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Change Notices', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'change-notice',
			'has_archive'         => 'change-notices',
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

		register_post_type( 'change_notice', $args );


		/* Post Type: Purchases.
		 */

		$labels = [
			'name'          => __( 'Purchase Orders', 'wc-bom' ),
			'singular_name' => __( 'Purchase Order', 'wc-bom' ),
			'menu_name'     => __( 'Purchases', 'wc-bom' ),
		    'all_items' => __('All Purchases', 'wc-bom'),
			//'archives'      => __( 'Purchase Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Purchase Orders', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'purchase-order',
			'has_archive'         => 'purchase-orders',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'purchase-order', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-cart',
			'supports'            => [ 'title',
			                           //'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'purchase', $args );


		/* Post Type: Purchases.
		 */

		$labels = [
			'name'          => __( 'Vendors', 'wc-bom' ),
			'singular_name' => __( 'Vendor', 'wc-bom' ),
			'menu_name'     => __( 'Vendors', 'wc-bom' ),
			//'archives'      => __( 'Purchase Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Vendors', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'vendor',
			'has_archive'         => 'vendors',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'vendor', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => [ 'title',
			                           //'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'vendor', $args );


		/* Post Type: Purchases.
		 */

		$labels = [
			'name'          => __( 'Requisitions', 'wc-bom' ),
			'singular_name' => __( 'Requisition', 'wc-bom' ),
			'menu_name'     => __( 'Requisitions', 'wc-bom' ),
			//'archives'      => __( 'Purchase Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Requisitions', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'requisitions',
			'has_archive'         => 'requisitions',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'requisitions', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-clipboard',
			'supports'            => [ 'title',
			                           //'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'requisitions', $args );


		/* Post Type: Purchases.
		 */

		$labels = [
			'name'          => __( 'Shipments', 'wc-bom' ),
			'singular_name' => __( 'Shipment', 'wc-bom' ),
			'menu_name'     => __( 'Shipments', 'wc-bom' ),
			//'archives'      => __( 'Purchase Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Shipments', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'shipment',
			'has_archive'         => 'shipments',
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-settings',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'shipment', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-migrate',
			'supports'            => [ 'title',
			                           //'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'shipment', $args );


		/* Post Type: Purchases.
		 */

		$labels = [
			'name'          => __( 'Production Order', 'wc-bom' ),
			'singular_name' => __( 'Production', 'wc-bom' ),
			'menu_name'     => __( 'Production', 'wc-bom' ),
			//'archives'      => __( 'Purchase Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Production Orders', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'production-order',
			'has_archive'         => 'production-orders',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'production-order', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-schedule',
			'supports'            => [ 'title',
			                           //'editor',
			                           'thumbnail',
			                           'revisions',
			                           'author',
			                           'page-attributes' ],
		];

		register_post_type( 'production', $args );


	}

}


$wc_bom_post = new WC_Bom_Post();
