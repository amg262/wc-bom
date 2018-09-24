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
*
*
*/

//namespace WC_Bom;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access allowed' );
}
/* Checks to see if "is_plugin_active" function exists and if not load the php file that includes that function */
if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/* Checks to see if the acf pro plugin is activated  */
if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
	/* load the plugin and anything else you want to do */
}

/* Checks to see if the acf plugin is activated  */
if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
	/* load the plugin and anything else you want to do */
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
	add_filter( 'acf/settings/show_admin', '__return_false' );
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
/** End: Function to create JSON load point */
//if ( class_exists( 'WC_Bom' ) ) {
//return;
//}

//define( 'WC_BOM_URL', plugins_url( '', __FILE__ ) );

class WC_Bom {

	protected static $instance = null;


	private function __construct() {

		$this->init();


	}

	protected function init() {


		require __DIR__ . '/includes/class-wcb-post.php';
		require __DIR__ . '/includes/class.settings-api.php';
		require __DIR__ . '/includes/oop-example.php';

		$t = new WeDevs_Settings_API_Test();
		$p = WCB_Post::getInstance();

		add_action( 'init', [ $this, 'load_assets' ] );

		//add_action( 'init', [ $this, 'check_acf' ] );
		//add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );


	}


	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 */
	public function load_assets() {

		$url  = 'assets/';
		$url2 = 'assets/';

		//$val = 'http://cdnjs.cloudflare.com/ajax/libs/validate.js/0.12.0/validate.min.js';
		//wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js' );
		//wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
		//wp_register_script( 'bom_adm_js', plugins_url( $url . 'wc-bom-admin.js', __FILE__ ), [ 'jquery' ] );
		//wp_register_style( 'bom_css', plugins_url( $url2 . 'wc-bom.css', __FILE__ ) );

		//wp_enqueue_script( 'valjs', $val );

		wp_register_script( 'bom_adm_js', plugins_url( 'assets/wc-bom.js', __FILE__ ), [ 'jquery' ] );
		//wp_register_script( 'bom_adm_min_js', plugins_url( $url . 'wc-bom-admin.min.js', __FILE__ ), [ 'jquery' ] );

		wp_enqueue_script( 'bom_adm_js' );
//		//	if ( file_exists( __DIR__ . '/dist/wc-bom.min.css' ) ) {
//		wp_register_style( 'bom_css', plugins_url( $url . 'wc-bom.css', __FILE__ ) );
//		wp_register_style( 'bom_min_css', plugins_url( $url . 'wc-bom.min.css', __FILE__ ) );
//
//		wp_enqueue_style( 'bom_css' );
		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		wp_register_script( 'chosen_js', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js', [ 'jquery' ] );
		wp_register_style( 'chosen_css', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css' );
		wp_enqueue_script( 'postbox' );
		//wp_enqueue_script( 'bom_adm_js' );
		wp_enqueue_script( 'chosen_js' );
		wp_enqueue_style( 'chosen_css' );
		//wp_enqueue_style( 'bom_css' );
	}

	protected function plugin_links( $actions, $plugin_file ) {

		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [
				'settings' => '<a href="admin.php?page=wc-bill-materials">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}

$wcb = WC_Bom::getInstance();


//if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
