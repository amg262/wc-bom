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

		$this->check_requirements();
		//register_activation_hook( __FILE__, [ $this, 'activate' ] );
		$this->plugin_options();
		//$this->load_assets();
		//add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		include_once __DIR__ . '/classes/class-wc-bom-post.php';
		include_once __DIR__ . '/classes/class-wc-bom-settings.php';
		//include_once __DIR__.'/classes/settingsPage.php';
        include_once __DIR__ . '/includes/acf/acf.php';
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

		$this->options = get_option( 'wc_bom_options' );
		if ( ! $this->options ) {
			$args = [ 'init' => true, 'config' => false ];
			add_option( 'wc_bom_options', $args );
		}
		if ( function_exists( 'acf_add_options_page' ) ) {
			$option_page =
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
		wp_localize_script( 'host_info', 'host', $host );
	}


	/**
	 *
	 */
	public function check_requirements() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$woo       = 'woocommerce';
		$woo_url   = $woo . '/' . $woo . '.php';
		$is_active = in_array( $woo_url, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		if ( ! $is_active ) {
			if ( plugin_dir_url( $woo_url ) ) {
				//activate_plugins($woo_url);
				$error = '<span>WooCommerce must be installed and activated to use this plugin!</span>';
			} else {
				$error = '<h5>WooCommerce must be installed and activated to use this plugin!</h5>';
			}
			deactivate_plugins( __FILE__ );
			add_action( 'admin_notices', [ $this, 'requirements_error' ] );

			return false;
		}

		return true;
		//}
	}


	// display custom admin notice
	/**
	 *
	 */
	public function requirements_error() { ?>

        <div class="notice error is-dismissible">
            <p><?php _e( '<span>WooCommerce must be installed and activated to use this plugin!</span>',
			             'wc-bom' ); ?></p>
        </div>

	<?php }




	/**
	 *
	 */
	public function load_vendor_assets() {
		/*wp_register_script( 'wc_bom_js', plugins_url( 'assets/js/wc_bom.js' ), [ 'jquery' ] );
		wp_register_script( 'wc_bom_min_js', plugins_url( 'assets/js/wc_bom.min.js' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_css', plugins_url( 'assets/css/wc_bom.css' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_min_css', plugins_url( 'assets/css/wc_bom.min.css' ), [ 'jquery' ] );

		wp_enqueue_script( 'wc_bom_js' );
		wp_enqueue_script( 'wc_bom_min_js' );
		wp_enqueue_style( 'wc_bom_css' );
		wp_enqueue_style( 'wc_bom_min_css' );*/
	}


	/**
	 *
	 */
	public function load_assets() {

		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_style( 'sweet',
		                  'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
		wp_enqueue_script( 'sweet',
		                   'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );

		wp_register_style( 'font_css', plugins_url( 'assets/css/font-awesome.min.css', __FILE__ ) );
		wp_register_script( 'wc_bom_wp_js', plugins_url( 'assets/js/wc_bom_wp.js', __FILE__ ), [ 'jquery' ] );
		wp_register_script( 'wc_bom_wp_min_js', plugins_url( 'assets/js/wc_bom_wp.min.js', __FILE__ ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_css', plugins_url( 'assets/css/wc_bom.css', __FILE__ ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_min_css', plugins_url( 'assets/css/wc_bom.min.css', __FILE__ ), [ 'jquery' ] );

		wp_enqueue_script( 'wc_bom_js' );
		//wp_enqueue_script( 'wc_bom_min_js' );
		wp_enqueue_script( 'wc_bom_wp_js' );
		//wp_enqueue_script( 'wc_bom_wp_min_js' );
		wp_enqueue_style( 'wc_bom_css' );
		wp_enqueue_style( 'fontawesome_css' );

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
