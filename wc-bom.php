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

function check_woocommerce() {

	if ( class_exists( 'Woocommerce' ) ) {
		$text = '<div class="error"><p><strong>WooBOM</strong> needs WooCommerce installed and activated to work!</p></div> ';
		echo $text;
	}
}

add_action( 'admin_notices', 'check_woocommerce' );
//
///* Checks to see if the acf pro plugin is activated  */
//if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
//  /* load the plugin and anything else you want to do */
//}
//
///* Checks to see if the acf plugin is activated  */
//if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
//
//}
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




class WCB_Core {

	/**
	 * @var null
	 */
	protected static $instance = null;


	/**
	 * WCB_Init constructor.
	 */
	private function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	protected function init() {

		if ( ! add_option( 'wc_bom_1', '' ) ) {
			update_option( 'wc_bom_1', 'true' );
		}

		$opt = get_option( 'wc_bom_1' );
		//echo json_encode( $opt );
		require __DIR__ . '/includes/class-wcb-post.php';
		require __DIR__ . '/includes/class-wcb-groups.php';
		require __DIR__ . '/includes/admin/class-wcb-settings-api.php';
		require __DIR__ . '/includes/admin/class-wcb-settings.php';

		$g = WCB_Field_Groups::getInstance();
		$t = new WeDevs_Settings_API_Test();
		//$p = WCB_Post::getInstance();

		add_action( 'init', [ $this, 'load_assets' ] );

		//add_action( 'init', [ $this, 'check_acf' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 */
	public function activate() {

		flush_rewrite_rules();
	}

	/**
	 *
	 */
	public function deactivate() {

		flush_rewrite_rules();
	}

	/**
	 *
	 */
	public function load_assets() {

		wp_register_script( 'bom_adm_js', plugins_url( 'assets/wc-bom.js', __FILE__ ), [ 'jquery' ] );

		wp_enqueue_script( 'bom_adm_js' );
		//wp_enqueue_script( 'bom_adm_a_js' );

		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		wp_register_script( 'chosen_js', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js', [ 'jquery' ] );
		wp_register_style( 'chosen_css', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css' );
		//wp_enqueue_script( 'bom_adm_js' );
		wp_enqueue_script( 'chosen_js' );
		wp_enqueue_style( 'chosen_css' );
		//wp_enqueue_style( 'bom_css' );
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $actions, $plugin_file ) {

		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [
				//edit.php?post_type=part
				'parts'    => '<a href="edit.php?post_type=part">' . __( 'Parts', 'wc-bom' ) . '</a>',
				'assembly' => '<a href="edit.php?post_type=assembly">' . __( 'Assembly', 'wc-bom' ) . '</a>',

				'settings' => '<a href="admin.php?page=wc-bill-materials">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}


$wcb_core = WCB_Core::getInstance();
