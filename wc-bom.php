<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */
/*
* Plugin Name: WooBOM
* Plugin URI: https/nextraa.us
* Description: Bill of Materials add-on for WooCommerce for raw material tracking, inventory, and production metrics.
* Version: 1.0
* Author: Andrew Gunn, Ryan Van Ess
* Author URI: https/nextraa.us
* Text Domain: logicbom
* License: GPL2
*/

namespace WooBom;


global $wc_bom_options, $wc_bom_settings;

$wc_bom_options  = get_option( WC_BOM_OPTIONS );
$wc_bom_settings = get_option( WC_BOM_SETTINGS );

/**
 *
 */
const WC_BOM_OPTIONS = 'wc_bom_options';
/**
 *
 */
const WC_BOM_SETTINGS = 'wc_bom_settings';

/**
 *
 */
const WC_BOM_ACF = 'assets/vendor/acf/acf.php';

/**
 *
 */
const WC_BOM_WOO = 'woocommerce/woocommerce.php';

/**
 * Class WC_Bom
 */


/**
 * Class WC_Bom
 *
 * @package WooBom
 */
class WC_Bom {

	/**
	 * @var
	 */
	private $options;
	/**
	 * @var
	 */
	private $posts;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {

		include_once __DIR__ . '/assets/vendor/acf/acf.php';
		include_once __DIR__ . '/classes/class-wc-bom-part.php';
		include_once __DIR__ . '/classes/class-wc-bom-assembly.php';
		include_once __DIR__ . '/classes/class-wc-bom-inventory.php';
		include_once __DIR__ . '/classes/class-wc-bom-ecn.php';
		include_once __DIR__ . '/classes/class-wc-bom-settings.php';
		//include_once __DIR__ . '/classes/settingsPage.php';

		$this->acf_options();

		add_action( 'admin_init', [ $this, 'check_requirements' ] );

		add_action( 'init', [ $this, 'load_assets' ] );
		add_action( 'init', [ $this, 'load_vendor_assets' ] );

		add_action( 'admin_init', [ $this, 'plugin_options' ] );
		//$this->load_assets();
		//add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );

		//include_once __DIR__.'/classes/settingsPage.php';
		/**
		 * Including files in other directories
		 */
		//register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
	}

	/**
	 *
	 */
	public function activate() {

		flush_rewrite_rules();
	}

	/**
	 * @return mixed|void
	 */
	public function plugin_options() {

		global $wc_bom_options, $wc_bom_settings;
		$wc_bom_options  = get_option( WC_BOM_OPTIONS );
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );

		if ( $wc_bom_options[ 'init' ] !== true ) {
			add_option( WC_BOM_OPTIONS, [ 'init' => true ] );
		}

		if ( $wc_bom_settings[ 'init' ] !== true ) {
			add_option( WC_BOM_SETTINGS, [ 'init' => true ] );
		}
	}

	/**
	 *
	 */
	public function acf_options() {

		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page( [
				                      'page_title' => 'Theme General Settings',
				                      'menu_title' => 'Theme Settings',
				                      'menu_slug'  => 'theme-general-settings',
				                      'capability' => 'edit_posts',
				                      'redirect'   => false,
			                      ] );
		}
	}

	/**
	 *
	 */
	public function localize_host_info() {

		$host = [
			'url'   => bloginfo( 'url' ),
			'wpurl' => bloginfo( 'wpurl' ),
			'name'  => bloginfo( 'name' ),
			'admin' => bloginfo( 'admin_email' ),
		];
		wp_localize_script( 'host', 'host', $host );
	}

	/**
	 *
	 */
	public function check_requirements() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		$is_active = in_array( WC_BOM_WOO, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );

		if ( ! $is_active ) {
			if ( plugin_dir_url( WC_BOM_WOO ) ) {
				activate_plugin( WC_BOM_WOO );
			}

			deactivate_plugins( __FILE__ );

			wp_die( $this->requirements_error() );
		}

		return true;
	}



// display custom admin notice
	/**
	 *
	 */
	public function requirements_error() {

		$message = '<div class="wc-bom notice error is-dismissible">' .
		           '<p><span>WooCommerce must be installed and activated to use this plugin!</span>&nbsp;' .
		           '<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a>' .
		           '</p>' .
		           '</div>';

		return $message;
	}

	// display custom admin notice
	/**
	 *
	 */
	public function setup_notice() {

		$message = '<div class="wc-bom notice updated is-dismissible">' .
		           '<p><span>WooCommerce must be installed and activated to use this plugin!</span>&nbsp;' .
		           '<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a>' .
		           '</p>' .
		           '</div>';

		return $message;
	}

	/**
	 *
	 */

	public function load_admin_assets() {

		$url = 'assets/dist/js';

		//wp_register_script( 'admin_js', plugins_url( $url . '/wc_bom_admin.js', __FILE__ ), [ 'jquery' ] );
		//wp_register_style( 'admin_css', plugins_url( $url . 'assets/d/wc_bom_admin.css', __FILE__ ) );

		//wp_enqueue_script( 'admin_js' );
		//wp_enqueue_style( 'admin_css' );

	}

	/**
	 *
	 */
	public function load_vendor_assets() {

		$url = 'assets/vendor/';

		wp_enqueue_script( 'jquery-ui' );


		wp_enqueue_script( 'sweetalertjs',
		                   'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		//wp_enqueue_script( 'chart_js' );
		wp_enqueue_style( 'sweetalert_css',
		                  'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		//wp_enqueue_script( 'chart_js' );
		wp_enqueue_script( 'validate_js',
		                   'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js' );
	}

	/**
	 *
	 */
	public function load_assets() {

		/*$url = 'assets/lib/js';

		//wp_register_script( 'wp_js', plugins_url( 'assets/lib/js/wc_bom_wp.js', __FILE__ ), [ 'jquery' ] );
		wp_register_script( 'js', plugins_url( 'assets/lib/js/wc_bom.js', __FILE__ ), [ 'jquery' ] );
		wp_register_style( 'css', plugins_url( 'assets/lib/css/wc_bom.css', __FILE__ ) );

		wp_enqueue_script( 'wp_js' );
		wp_enqueue_script( 'js' );
		wp_enqueue_style( 'css' );*/
		/*wp_register_script( 'wp_js', plugins_url( $url . '/wc_bom_wp.min.js', __FILE__ ), [ 'jquery' ] );
		wp_register_script( 'js', plugins_url( $url . '/wc_bom.min.js', __FILE__ ), [ 'jquery' ] );
		wp_register_style( 'css', plugins_url( $url . '/wc_bom.min.css', __FILE__ ) );

		wp_enqueue_script( 'wp_js' );
		wp_enqueue_script( 'js' );
		wp_enqueue_style( 'css' );*/
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public
	function plugin_links(
		$actions, $plugin_file
	) {

		static $plugin;
		if ( ! isset( $plugin ) ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin == $plugin_file ) {
			$settings = [
				'settings' => '<a href="admin.php?page=wc-settings&tab=settings_tab_wco">' . __( 'Settings',
				                                                                                 'General' ) . '</a>',
				'support'  => '<a href="http://andrewgunn.org/support" target="_blank">' . __( 'Support',
				                                                                               'General' ) . '</a>'
				//,
				//'pro' => '<a href="http://andrewgunn.xyz/woocommerce-custom-overlays-pro" target="_blank">' . __('Pro', 'General') . '</a>'
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}


$cl = new WC_Bom();

//add_filter('acf/settings/show_admin', '__return_false');
