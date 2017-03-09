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
/**
 *
 */
const WC_BOM_OPTIONS = 'wc_bom_options';
/**
 *
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
	 * @var null
	 */
	protected static $instance = null;


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
	 * WC_Bom constructor.
	 */
	private function __construct() {

		$this->init();
	}


	/**
	 *
	 */
	protected function init() {

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		//add_action( 'admin_init', [ $this, 'activate' ] );
		/*add_action( 'admin_init', [ $this, 'check_requirements' ] );
		add_action( 'admin_init', [ $this, 'plugin_options' ] );
		add_action( 'admin_init', [ $this, 'plugin_settings' ] );*/
		include_once __DIR__ . '/classes/class-wc-bom-part.php';
		include_once __DIR__ . '/classes/class-wc-bom-assembly.php';
		include_once __DIR__ . '/classes/class-wc-bom-inventory.php';
		include_once __DIR__ . '/classes/class-wc-bom-ecn.php';
		include_once __DIR__ . '/classes/class-wc-bom-settings.php';
		add_action( 'init', [ $this, 'load_assets' ] );

		$this->acf_options();
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
	}


	/**
	 *
	 */
	public function activate() {

		$this->check_requirements();
		$this->add_options();
		flush_rewrite_rules();
	}


	/**
	 *
	 */
	public function check_requirements() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$active        = 'active_plugins';
		$woo           = 'woocommerce/woocommerce.php';
		$acf           = 'advanced-custom-fields/acf.php';
		$is_woo        = plugin_dir_url( $woo );
		$is_woo_active = in_array( $woo, apply_filters( $active, get_option( $active ) ) );
		$is_acf        = plugin_dir_url( $acf );
		$is_acf_active = in_array( $acf, apply_filters( $active, get_option( $active ) ) );

		if ( $is_acf_active ) {
			//if ( plugin_dir_url( WC_BOM_WOO ) ) { activate_plugin( WC_BOM_WOO ); }
			deactivate_plugins( __FILE__ );
			$message =
				'<div style="text-align: center;"><h3>' .
				'ACF must be installed and activated!</h3>' .
				'<a href=' . admin_url( 'plugins.php' ) . '>' .
				'Back to plugins&nbsp;&rarr;</a>' .
				'<p>' . $is_acf . '</p>' .
				'</div>';

			wp_die( $message );
		}
		if ( ! $is_woo_active ) {
			//if ( plugin_dir_url( WC_BOM_WOO ) ) { activate_plugin( WC_BOM_WOO ); }
			deactivate_plugins( __FILE__ );
			$message =
				'<div style="text-align: center;"><h3>' .
				'WooCommerce must be installed and activated!</h3>' .
				'<a href=' . admin_url( 'plugins.php' ) . '>' .
				'Back to plugins&nbsp;&rarr;</a>' .
				'</div>';

			wp_die( $message );
		}

		return true;
	}


	/**
	 * @return mixed|void
	 */
	public function add_options() {

		global $wc_bom_options;
		$key            = 'init';
		$wc_bom_options = get_option( WC_BOM_OPTIONS );
		if ( $wc_bom_options[ $key ] !== true ) {
			add_option( WC_BOM_OPTIONS, [ $key => true ] );
		}

		//return $wc_bom_options;
	}


	/**
	 *
	 */
	public function acf_options() {

		///include_once __DIR__ . '/assets/vendor/acf/acf.php';

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
	public function load_assets() {

		$url = 'assets/dist/scripts/';
		wp_register_script( 'bom_js', plugins_url( $url . 'wc-bom.min.js', __FILE__ ) );
		wp_register_script( 'api_js', plugins_url( $url . 'wc-bom-api.min.js', __FILE__ ) );
		wp_register_script( 'wp_js', plugins_url( $url . 'wc-bom-wp.min.js', __FILE__ ) );
		wp_register_style( 'bom_css', plugins_url( $url . 'wc-bom.min.css', __FILE__ ) );
		wp_enqueue_script( 'bom_js' );
		//wp_enqueue_script( 'api_js' );
		//wp_enqueue_script( 'wp_js' );
		wp_enqueue_style( 'bom_css' );
		wp_enqueue_script(
			'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/' .
			                'sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style(
			'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/' .
			                  'sweetalert/1.1.3/sweetalert.min.css' );
		wp_enqueue_script(
			'validate_js', 'https://cdnjs.cloudflare.com/ajax/libs/' .
			               'jquery-validate/1.16.0/jquery.validate.min.js' );
	}


	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $actions, $plugin_file ) {

		static $plugin;
		if ( ! isset( $plugin ) ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin == $plugin_file ) {
			$settings = [
				'settings' => '<a href="admin.php?page=wc-bom-settings>' . __( 'Settings', 'wc-bom' ) . '</a>',
				'support'  => '<a href="http://andrewgunn.org/support">' . __( 'Support', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}


$wc_bom = WC_Bom::getInstance();
//add_filter('acf/settings/show_admin', '__return_false');
