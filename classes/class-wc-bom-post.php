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
			'add_new'       => __( 'Add New', 'wc-bom' ),
			'add_new_item'  => __( 'Add New Part', 'wc-bom' ),
			'edit_item'     => __( 'Edit Part', 'wc-bom' ),
			'new_item'      => __( 'New Part', 'wc-bom' ),
			'view_item'     => __( 'View Part', 'wc-bom' ),
			'view_items'    => __( 'View Parts', 'wc-bom' ),
			'archives'      => __( 'Part Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Parts', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => 'Parts post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'part',
			'has_archive'         => 'part-directory',
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'part', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-hammer',
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'comments',
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
			'menu_name'     => __( 'Material', 'wc-bom' ),
			'all_items'     => __( 'All Materials', 'wc-bom' ),
			'add_new'       => __( 'Add New', 'wc-bom' ),
			'add_new_item'  => __( 'Add New Material', 'wc-bom' ),
			'edit_item'     => __( 'Edit Material', 'wc-bom' ),
			'new_item'      => __( 'New Material', 'wc-bom' ),
			'archives'      => __( 'Material Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Materials', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => 'Materials post type for the low level raw materials received by a company that are the lowest level of the Bill of Materials.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'materials',
			'has_archive'         => 'material-directory',
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'material', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-clipboard',
			'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions', 'author', 'page-attributes' ],
		];

		register_post_type( 'material', $args );

		/**
		 * Post Type: Assemblies.
		 */

		$labels = [
			'name'          => __( 'Assemblies', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assembly', 'wc-bom' ),
			'all_items'     => __( 'All Assemblies', 'wc-bom' ),
			'archives'      => __( 'Assembly Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Assemblies', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => 'Post type for assemblies build by combining materials with parts.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'assembly',
			'has_archive'         => 'product-directory',
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'assembly', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-nametag',
			'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions', 'author', 'page-attributes' ],
		];

		register_post_type( 'assembly', $args );

		/**
		 * Post Type: Inventory Records.
		 */

		$labels = [
			'name'          => __( 'Inventory Records', 'wc-bom' ),
			'singular_name' => __( 'Inventory Record', 'wc-bom' ),
			'menu_name'     => __( 'Inventory', 'wc-bom' ),
			'archives'      => __( 'Inventory Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Inventory Records', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'rest_base'           => 'inventory',
			'has_archive'         => 'inventory-records',
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'inventory_records', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-networking',
			'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions', 'author', 'page-attributes' ],
		];

		register_post_type( 'inventory_records', $args );

		/**
		 * Post Type: Change Notices.
		 */

		$labels = [
			'name'          => __( 'Change Notices', 'wc-bom' ),
			'singular_name' => __( 'Change Notice', 'wc-bom' ),
			'menu_name'     => __( 'Change Notice', 'wc-bom' ),
			'archives'      => __( 'Change Notice Directory', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Change Notices', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'ecn',
			'has_archive'         => 'ecn-directory',
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'change_notice', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-warning',
			'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions', 'author', 'page-attributes' ],
		];

		register_post_type( 'change_notice', $args );

		/**
		 * Taxonomy: Inventory Types.
		 */

		$labels = array(
			'name' => __( 'Inventory Types', 'wc-bom' ),
			'singular_name' => __( 'Inventory Type', 'wc-bom' ),
			'menu_name' => __( 'Inventory Type', 'wc-bom' ),
		);

		$args = array(
			'label' => __( 'Inventory Types', 'wc-bom' ),
			'labels' => $labels,
			'public' => true,
			'hierarchical' => true,
			//'label' => 'Inventory Types',
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'Inventory_type', 'with_front' => true,  'hierarchical' => true, ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => 'Inventory-type',
			'show_in_quick_edit' => true,
		);
		register_taxonomy( 'inventory_type', array( 'inventory_records' ), $args );

	}
}


$wc_bom_post = new WC_Bom_Post();
