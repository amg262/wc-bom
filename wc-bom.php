<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2018-09-19
 * Time: 02:43
 */

/*
*
*
*
* Plugin Name: WooBOM - WooCommerce Bill of Materials
* Plugin URI: http://andrewgunn.org
* Description: Bill of Materials add-on for WooCommerce for raw material tracking, inventory, and production metrics.
* Version: 1.0.0
* Author: Andrew Gunn
* Author URI: https/andrewgunn.org
* Text Domain: wc-bom
* License: license.txt
*
*/

//namespace WC_Bom;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access allowed' );
}


/* Checks to see if the acf pro plugin is activated  */
if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	/* load the plugin and anything else you want to do */
}

/* Checks to see if the acf pro plugin is activated  */
if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
	/* load the plugin and anything else you want to do */
}

/* Checks to see if the acf plugin is activated  */
if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {

}
/** Start: Detect ACF Pro plugin. Include if not present. */
if ( ! class_exists( 'acf' ) ) { // if ACF Pro plugin does not currently exist
	/** Start: Customize ACF path */
	add_filter( 'acf/settings/path', 'cysp_acf_settings_path' );
	function cysp_acf_settings_path( $path ) {

		$path = plugin_dir_path( __FILE__ ) . 'acf/';

		return $path;
	}

	/** End: Customize ACF path */
	/** Start: Customize ACF dir */
	add_filter( 'acf/settings/dir', 'cysp_acf_settings_dir' );
	function cysp_acf_settings_dir( $path ) {

		$dir = plugin_dir_url( __FILE__ ) . 'acf/';

		return $dir;
	}

	/** End: Customize ACF path */
	/** Start: Hide ACF field group menu item */
//	add_filter( 'acf/settings/show_admin', '__return_false' );
	/** End: Hide ACF field group menu item */
	/** Start: Include ACF */
	include_once( plugin_dir_path( __FILE__ ) . 'acf/acf.php' );
	/** End: Include ACF */
	/** Start: Create JSON save point */
	add_filter( 'acf/settings/save_json', 'cysp_acf_json_save_point' );
	function cysp_acf_json_save_point( $path ) {

		$path = plugin_dir_path( __FILE__ ) . 'acf-json/';

		return $path;
	}

	/** End: Create JSON save point */
	/** Start: Create JSON load point */
	add_filter( 'acf/settings/load_json', 'cysp_acf_json_load_point' );
	/** End: Create JSON load point */
	/** Start: Stop ACF upgrade notifications */
	add_filter( 'site_transient_update_plugins', 'cysp_stop_acf_update_notifications', 11 );
	function cysp_stop_acf_update_notifications( $value ) {

		unset( $value->response[ plugin_dir_path( __FILE__ ) . 'acf/acf.php' ] );

		return $value;
	}
	/** End: Stop ACF upgrade notifications */
} else { // else ACF Pro plugin does exist
	/** Start: Create JSON load point */
	add_filter( 'acf/settings/load_json', 'cysp_acf_json_load_point' );
	/** End: Create JSON load point */
} // end-if ACF Pro plugin does not currently exist
/** End: Detect ACF Pro plugin. Include if not present. */
/** Start: Function to create JSON load point */
function cysp_acf_json_load_point( $paths ) {

	$paths[] = plugin_dir_path( __FILE__ ) . 'acf-json-load';

	return $paths;
}

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( [
		'page_title' => 'BOM Fields',
		'menu_title' => 'BOM Fields',
		'menu_slug'  => 'wc-bom-fields',
		'capability' => 'edit_posts',
		'redirect'   => false,
	] );
}

if ( ! class_exists( 'WCB_Core' ) ) {
	require __DIR__ . '/includes/class-wcb-core.php';
	$wcb_core = WCB_Core::getInstance();
}