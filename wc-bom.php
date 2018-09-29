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

define( 'WC_BOM_TBL', 'wc_bom' );


add_action( 'admin_notices', 'check_woocommerce' );

function check_woocommerce() {

	if ( class_exists( 'Woocommerce' ) ) {
		$text = '<div class="error"><p><strong>WooBOM</strong> needs WooCommerce installed and activated to work!</p></div> ';
		echo $text;
	}
}

add_action( 'admin_init', 'check_acf' );

function check_acf() {
	$acf     = 'advanced-custom-fields/acf.php';
	$active  = in_array( $acf, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	$has_acf = plugin_dir_url( $acf );

	echo $active;
}


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
	//  add_filter( 'acf/settings/show_admin', '__return_false' );
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

/**
 *
 */
function create_options() {


}

/**
 *
 */
function install_data() {
	global $wpdb;

	$welcome_name = 'Mr. WordPress';
	$welcome_text = 'Congratulations, you just completed the installation!';

	$table_name = $wpdb->prefix . WCB_TBL;

	$wpdb->insert( $table_name, [
		'time' => current_time( 'mysql' ),
		'name' => $welcome_name,
		'data' => $welcome_text,
		'url'  => 'http://cloudground.net/',
	] );
}


/**
 *
 */
function delete_db() {
	global $wpdb;

	$table_name = $wpdb->prefix . WCB_TBL;

	//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
	$wpdb->query( "DROP TABLE IF EXISTS  . $table_name . " );
}

/**
 *
 */
function upgrade_data() {
	global $wpdb;

	global $wcb_data;


	$table_name = $wpdb->prefix . WCB_TBL;

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					title varchar(255),
					post_id int(11),
					type varchar(255),
					sub_ids text,
					data text ,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1 NOT NULL,
					PRIMARY KEY  (id)
				);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


	dbDelta( $sql );


}

require __DIR__ . '/core.php';
