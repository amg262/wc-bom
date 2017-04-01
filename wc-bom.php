<?php declare( strict_types=1 );
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
use function add_action;
use function validate_active_plugins;
use function var_dump;


/**
 *
 */
const WC_BOM_VERSION = '1.0.0';
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
	protected static $instance = null;
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
	public function init() {

		$this->load_classes();
		$this->require_woocommerce();
		$this->require_acf();
		$this->create_options();
		$this->install();
		$this->install_data();
		//$this->load_assets();
		add_action('init',[$this,'load_assets']);
		//add_action( 'admin_init', [ $this, 'is_woo_activated' ] );
		//add_action( 'admin_init', [ $this, 'is_woo_activated' ] );
		//register_activation_hook( __FILE__, [ $this, 'create_options' ] );
		//register_activtion_hook( __FILE__, [ $this, 'install' ] );
		//add_action( 'admin_init', [ $this, 'acf_installed' ] );
		//$this->include_acf();

		//add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );

		//$this->load_classes();
		$settings = WC_Bom_Settings::getInstance();
		$post     = WC_Bom_Post::getInstance();

		//flush_rewrite_rules();
//var_dump($settings);
	}

	/**
	 *
	 */
	public function load_classes() {
		//include_once __DIR__ . '/classes/class-wc-bom-data.php';
		include_once __DIR__ . '/classes/class-wc-bom-post.php';
		include_once __DIR__ . '/classes/class-wc-bom-settings.php';
	}

	/**
	 * @return bool
	 */
	public function require_woocommerce() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$active        = 'active_plugins';
		$woo           = 'woocommerce/woocommerce.php';
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
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function require_acf() {
		require_once __DIR__ . '/assets/dist/acf/acf.php';
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
		}


		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				[
					'page_title' => 'Theme General Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug'  => 'theme-general-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
				] );
		}

		return true;
	}

	/**
	 * @return mixed
	 */
	public function create_options() {

		global $wc_bom_options;
		global $wc_bom_settings;

		$key            = 'init';
		$wc_bom_options = get_option( WC_BOM_OPTIONS );
		if ( $wc_bom_options[ $key ] !== true ) {
			add_option( WC_BOM_OPTIONS, [ $key => true ] );
		}
		$key             = 'setup';
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		if ( $wc_bom_settings[ $key ] !== true ) {
			add_option( WC_BOM_SETTINGS, [ $key => false ] );
		}
	}

	/**
	 *
	 */
	public function install() {
		global $wpdb;
		global $wc_bom_settings;

		//var_dump( $wc_bom_settings );

		$table_name = $wpdb->prefix . 'woo_bom';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				name tinytext NOT NULL,
				text text NOT NULL,
				url varchar(55) DEFAULT '' NOT NULL,
				PRIMARY KEY  (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$wc_bom_settings['db_install'] = true;
		add_option( 'wc_bom_settings', [ 'db_install' => true ] );

		dbDelta( $sql );

		//add_option( 'wc', $jal_db_version );
	}

	/**
	 *
	 */
	public function install_data() {
		global $wpdb;

		$welcome_name = 'Mr. WordPress';
		$welcome_text = 'Congratulations, you just completed the installation!';

		$table_name = $wpdb->prefix . 'woo_bom';

		$wpdb->insert(
			$table_name,
			[
				'time' => current_time( 'mysql' ),
				'name' => $welcome_name,
				'text' => $welcome_text,
			]
		);
	}

	/**
	 *
	 */
	public function load_assets() {
		$url = 'assets/dist/scripts/';
		$url2 = 'assets/dist/styles';
		wp_register_script( 'bom_js', plugins_url( $url . 'wc-bom.min.js', __FILE__ ) );
		wp_register_script( 'bom_adm_js', plugins_url( $url . 'wc-bom-admin.min.js', __FILE__ ) );
		wp_register_script( 'api_js', plugins_url( $url . 'wc-bom-api.min.js', __FILE__ ) );
		wp_register_script( 'wp_js', plugins_url( $url . 'wc-bom-wp.min.js', __FILE__ ) );
		wp_register_style( 'bom_css', plugins_url( $url2 . 'wc-bom.min.css', __FILE__ ) );
		wp_enqueue_script( 'bom_js' );
		wp_enqueue_script( 'bom_adm_js' );
		//wp_enqueue_script( 'ajax_js' );
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

		if ( $plugin == null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [
				'settings' => '<a href="admin.php?page=wc-bom-settings">' . __( 'Settings', 'wc-bom' ) . '</a>',
				'support'  => '<a href="http://andrewgunn.org/support">' . __( 'Support', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}

$wc_bom = WC_Bom::getInstance();
//global $wc_bom_settings;

//var_dump( $wc_bom_settings );
//add_filter('acf/settings/show_admin', '__return_false');
