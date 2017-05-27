<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/26/2017
 * Time: 9:56 PM
 */
if ( class_exists( 'acf' ) ) {
	//wp_die( 'ACF' );
}
if ( class_exists( 'acf_pro' ) ) {
	//wp_die( 'pro' );
}

function found_products() {
	$products = get_posts( [ 'post_type' => 'product' ] );

	if ( count( $products ) !== null ) {
		wp_cache_set( 'wcb_prod', $products );
	} else {
		echo '<h2>noprods</h2>';

		return false;
	}

	return true;
}

if ( ! found_products() ) {
	wp_die( 'pro' );
}

//require_once __DIif ( get_posts( [ 'post_type' => 'product' ] ) ) {


require_once __DIR__ . '/acf/acf.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';
$acf     = 'advanced-custom-fields/acf.php';
$active  = in_array( $acf, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
$has_acf = plugin_dir_url( $acf );

if ( $has_acf && $active ) {

	deactivate_plugins( $acf );
	deactivate_plugins( __FILE__ );

	$message =
		'<div style="text-align: center;"><h3>' .
		'ACF Pro is included in <strong>WooBOM</strong>.' .
		'&nbsp;<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a></div>';
	wp_die( $message );

}
if ( function_exists( 'acf_add_options_page' ) ) {
	//acf_add_options_page();
	$args = [

		/* (string) The title displayed on the options page. Required. */
		'page_title' => 'Site  Options',

		/* (string) The title displayed in the wp-admin sidebar. Defaults to page_title */
		'menu_title' => 'Site Options',
		/* (string) The slug name to refer to this menu by (should be unique for this menu).
		Defaults to a url friendly version of menu_slug */
		'menu_slug'  => '',
		/* (string) The capability required for this menu to be displayed to the user. Defaults to edit_posts.
		Read more about capability here: http://codex.wordpress.org/Roles_and_Capabilities */
		'capability' => 'manage_options',

		'position'    => false,

		/* (string) The slug of another WP admin page. if set, this will become a child page. */
		'parent_slug' => 'wc-bom-settings',

		//	'icon_url'    => 'dashicons-admin-site',

		/* (boolean) If set to true, this options page will redirect to the first child page (if a child page exists).
			If set to false, this parent page will appear alongside any child pages. Defaults to true */
		'redirect'    => true,

		/* (int|string) The '$post_id' to save/load data to/from. Can be set to a numeric post ID (123), or a string ('user_2').
		Defaults to 'options'. Added in v5.2.7 */
		'post_id'     => 'options',

		'autoload' => false,

	];
	acf_add_options_page( $args );
}

function register_custom_acf_fields() {if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_5928e3cc1d58f',
		'title' => 'Inventory',
		'fields' => array (
			array (
				'key' => 'field_5928e4447ca57',
				'label' => 'ID',
				'name' => 'id',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5928e4a17ca5a',
				'label' => 'PO',
				'name' => 'po',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5928e45d7ca59',
				'label' => 'Received',
				'name' => 'recieved',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd/m/Y',
				'return_format' => 'd/m/Y',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5928e4eeae891',
				'label' => 'Description',
				'name' => 'description',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5928e4f4ae892',
				'label' => 'File',
				'name' => 'file',
				'type' => 'file',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'library' => 'all',
				'min_size' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array (
				'key' => 'field_5928e50eae893',
				'label' => '',
				'name' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'inventory',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array (
		'key' => 'group_58bec9c065391',
		'title' => 'Part & Assembly',
		'fields' => array (
			array (
				'key' => 'field_58bec9d3ae35b',
				'label' => 'ID',
				'name' => 'id',
				'type' => 'text',
				'instructions' => 'Unique identifier of assembly',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '40',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'Part 100',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_59077aa89c6ff',
				'label' => 'SKU',
				'name' => 'sku',
				'type' => 'text',
				'instructions' => 'SKU number used to characterize part.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '40',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'PARTSKU',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_592905dd17d52',
				'label' => 'Unit Cost',
				'name' => 'unit_cost',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '0.00',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_58bed72466f45',
				'label' => 'Description',
				'name' => 'description',
				'type' => 'textarea',
				'instructions' => 'Description of assembly',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '70',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'Some text describing the nature of this assembly.',
				'maxlength' => '',
				'rows' => 3,
				'new_lines' => '',
			),
			array (
				'key' => 'field_5907799d06cf9',
				'label' => 'Sub Assembly',
				'name' => 'sub_assembly',
				'type' => 'repeater',
				'instructions' => 'Sub assemblies are used to relate any number of	low level items to other	items.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => 'field_590779b206cfa',
				'min' => 1,
				'max' => 0,
				'layout' => 'row',
				'button_label' => 'Add Item',
				'sub_fields' => array (
					array (
						'key' => 'field_590779b206cfa',
						'label' => 'Item',
						'name' => 'item',
						'type' => 'post_object',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => array (
							0 => 'part',
							1 => 'assembly',
						),
						'taxonomy' => array (
						),
						'allow_null' => 0,
						'multiple' => 0,
						'return_format' => 'object',
						'ui' => 1,
					),
					array (
						'key' => 'field_592876d6a0fbb',
						'label' => 'Qty',
						'name' => 'qty',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => 1,
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '',
					),
				),
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'assembly',
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'part',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => 'Assembly object made of parts and sub-assemblies that make up a product.',
	));

endif;
}

//add_action( 'init', 'register_custom_acf_fields' );