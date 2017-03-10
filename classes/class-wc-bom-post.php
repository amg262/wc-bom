<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

namespace WooBom;


require_once WC_BOM_ABSTRACT . 'WC_Abstract_Post.php';
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 3/6/17
 * Time: 8:03 PM
 */
class WC_Bom_Post implements WC_Bom_Abstract_Post {

	/**
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * WC_Bom_Post_Type constructor.
	 */
	private function __construct() {

		$this->init();
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 */
	public function init() {

		add_action( 'init', [ $this, 'register_part' ] );
		add_action( 'init', [ $this, 'register_assembly' ] );
		add_action( 'init', [ $this, 'register_inventory' ] );
		add_action( 'init', [ $this, 'register_ecn' ] );

		add_action( 'init', [ $this, 'register_part_cat' ] );
		add_action( 'init', [ $this, 'register_procurement_type' ] );
		add_action( 'init', [ $this, 'register_location' ] );
		add_action( 'init', [ $this, 'register_phase' ] );

		add_action( 'init', [ $this, 'register_vendor' ] );
		add_action( 'init', [ $this, 'register_material_tags' ] );

		add_action( 'init', [ $this, 'register_assembly_cat' ] );
		add_action( 'init', [ $this, 'register_inventory_cat' ] );

		//flush_rewrite_rules();
		//$this->register_part();
		//$this->register_taxonomy();
	}

	/**
	 *
	 */
	public function register_post() {

		add_action( 'init', [ $this, 'register_part' ] );
		add_action( 'init', [ $this, 'register_assembly' ] );
		add_action( 'init', [ $this, 'register_inventory' ] );
		add_action( 'init', [ $this, 'register_ecn' ] );
	}

	/**
	 *
	 */
	public function register_taxonomy() {

		add_action( 'init', [ $this, 'register_part_cat' ] );
		add_action( 'init', [ $this, 'register_procurement_type' ] );
		add_action( 'init', [ $this, 'register_location' ] );
		add_action( 'init', [ $this, 'register_phase' ] );

		add_action( 'init', [ $this, 'register_vendor' ] );
		add_action( 'init', [ $this, 'register_material_tags' ] );

		add_action( 'init', [ $this, 'register_assembly_cat' ] );
		add_action( 'init', [ $this, 'register_inventory_cat' ] );
	}

	/**
	 *
	 */
	public function register_assembly() {

		$labels = [
			'name'          => __( 'Assemblies', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assembly', 'wc-bom' ),
			'all_items'     => __( 'All Assemblies', 'wc-bom' ),
		];
		$args   = [
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

	/**
	 *
	 */
	public function register_assembly_cat() {

		$labels = [
			'name'          => __( 'Assembly Categories', 'wc-bom' ),
			'singular_name' => __( 'Assembly Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];
		$args   = [
			'label'              => __( 'Assembly Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'sssembly-category',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'assembly_category', [ 'assembly' ], $args );
	}

	/**
	 *
	 */
	public function register_part() {

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

	/**
	 *
	 */
	public function register_part_cat() {

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

	/**
	 *
	 */
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
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'procurement-type',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'procurement_type', [ 'part' ], $args );
	}

	/**
	 *
	 */
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
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'vendors',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'vendors', [ 'part' ], $args );
	}

	/**
	 *
	 */
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
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'locations',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'locations', [ 'part' ], $args );
	}

	/**
	 *
	 */
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
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'phases',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'phases', [ 'part' ], $args );
	}

	/**
	 *
	 */
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
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'part_tags', [ 'part', 'assembly', 'inventory', 'ecn' ], $args );
	}

	/**
	 *
	 */
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

	/**
	 *
	 */
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

	/**
	 *
	 */
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
			'query_var'           => true,
			'menu_icon'           => 'dashicons-flag',
			'supports'            => [
				'title',
				//  'editor',
				'thumbnail',
				'revisions',
				'author',
				'page-attributes',
			],
		];

		register_post_type( 'ecn', $args );
	}
}
