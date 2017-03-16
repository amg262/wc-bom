<?php declare( strict_types = 1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */
namespace WooBom;
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

global $wc_bom_options, $wc_bom_settings;

/**
 *
 */
const WC_BOM_ABSTRACT = __DIR__ . '/abstract/';

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
const WC_BOM_ACF = __DIR__ . 'assets/dist/acf/acf.php';
/**
 *
 */
const WC_BOM_WOO = 'woocommerce/woocommerce.php';

//require_once WC_BOM_ABSTRACT . 'WC_Abstract_Bom.php';
//require_once __DIR__ . '/assets/dist/acf/acf.php';

/**
 * Class WC_Bom
 *
 * @package WooBom
 */
class WC_Bom {

	/**
	 * @var null
	 */
	protected static $instance;
	/**
	 * @var string
	 */
	/**
	 * WC_Bom constructor.
	 */
	private function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {
		include_once __DIR__ . '/classes/class-wc-bom-data.php';
		//require_once __DIR__ . '/assets/dist/acf/acf.php';

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'admin_init', [ $this, 'acf_installed' ] );
		$this->include_acf();

		add_action( 'init', [ $this, 'load_plugin_scripts' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );

		$this->load_classes();
		$settings = WC_Bom_Settings::getInstance();
		$post     = WC_Bom_Post::getInstance();
	}



	/**
	 *
	 */
	protected function load_classes() {

		include_once __DIR__ . '/classes/class-wc-bom-post.php';
		include_once __DIR__ . '/classes/class-wc-bom-settings.php';
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( null === static::$instance ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 * //     */
	public function load_plugin_scripts() {

		$this->load_dist_scripts();
		$this->load_vendor_scripts();
	}

	/**
	 *
	 */
	public function load_dist_scripts() {

		$url = 'assets/dist/scripts/';
		wp_register_script( 'bom_js', plugins_url( $url . 'wc-bom.min.js', __FILE__ ) );
		wp_register_script( 'bom_adm_js', plugins_url( $url . 'wc-bom-admin.min.js', __FILE__ ) );
		wp_register_script( 'api_js', plugins_url( $url . 'wc-bom-api.min.js', __FILE__ ) );
		wp_register_script( 'wp_js', plugins_url( $url . 'wc-bom-wp.min.js', __FILE__ ) );
		wp_register_style( 'bom_css', plugins_url( $url . 'wc-bom.min.css', __FILE__ ) );
		wp_enqueue_script( 'bom_js' );
		wp_enqueue_script( 'bom_adm_js' );
		//wp_enqueue_script( 'ajax_js' );
		//wp_enqueue_script( 'api_js' );
		//wp_enqueue_script( 'wp_js' );
		wp_enqueue_style( 'bom_css' );
	}

	/**
	 *
	 */
	public function load_vendor_scripts() {

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
				'settings' => '<a href="admin.php?page=wc-bom-settings">' . __( 'Settings', 'wc-bom' ) . '</a>',
				'support'  => '<a href="http://andrewgunn.org/support">' . __( 'Support', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}

	/**
	 * @return bool
	 */
	public function acf_installed() {

		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$acf     = 'advanced-custom-fields/acf.php';
		$active  = in_array( $acf, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
		$has_acf = plugin_dir_url( $acf );

		if ( $has_acf && $active ) {

			deactivate_plugins( $acf );
			deactivate_plugins( __FILE__ );

			$message =
				'<div style="text-align: center;"><h3>' .
				'<strong>ACF</strong> must be deactivated as ACF Pro is required and included in this plugin.' .
				'You must deactivate it before using this plugin.' .
				'<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a></div>';
			wp_die( $message );

			return false;
		} else {
			$this->include_acf();

			return true;
		}
	}

	/**
	 * @return bool
	 */
	public function include_acf() {
		require_once __DIR__ . '/assets/dist/acf/acf.php';


		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				[
					'page_title' => 'Theme General Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug'  => 'theme-general-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
				] );

			return true;
		}

		return false;
	}

	/**
	 *
	 */
	protected function activate() {

		$this->create_options();
		$this->create_settings();
		$this->is_woo_activated();
		$data = WC_Bom_Data::getInstance();
		//$this->is_acf_deactivated();
		flush_rewrite_rules();
	}

	/**
	 * @return mixed
	 */
	public function create_options() {

		global $wc_bom_options;
		$key            = 'init';
		$wc_bom_options = get_option( WC_BOM_OPTIONS );
		if ( $wc_bom_options[ $key ] !== true ) {
			add_option( WC_BOM_OPTIONS, [ $key => true ] );
		}

		return $wc_bom_options;
	}

	/**
	 * @return mixed
	 */
	public function create_settings() {

		global $wc_bom_settings;
		$key             = 'setup';
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		if ( $wc_bom_settings[ $key ] !== true ) {
			add_option( WC_BOM_SETTINGS, [ $key => false ] );
		}

		return $wc_bom_settings;
	}

	/**
	 * @return bool
	 */
	public function is_woo_activated() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$active        = 'active_plugins';
		$woo           = 'woocommerce/woocommerce.php';
		$is_woo        = plugin_dir_url( $woo );
		$is_woo_active = in_array( $woo, apply_filters( $active, get_option( $active ) ), true );
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

			return false;
		} else {
			return true;
		}
	}
}

$wc_bom = WC_Bom::getInstance();
//add_filter('acf/settings/show_admin', '__return_false');
