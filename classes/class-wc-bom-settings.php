<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 *
 */
namespace WooBom;

/**
 * PLUGIN SETTINGS PAGE
 */
/**
 * Class WC_Bom_Settings
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Settings
 *
 * @package WooBom
 *
 */


/**
 * Class WC_Bom_Settings
 *
 * @package WooBom
 */
class WC_Bom_Settings {

    private $worker = null;
	/**
	 * @var null
	 */
	protected static $instance = null;

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

		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 */
	protected function init() {

		if ( ! is_admin() ) {
			wp_die( 'You must be an admin to view this.' );
		}
		include_once __DIR__ . '/class-wc-bom-worker.php';
		$this->worker = new WC_Bom_Worker();
		add_action( 'admin_menu', [ $this, 'wc_bom_menu' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );
	}

	/**
	 *W
	 *
	 * /**
	 * Add options page
	 */
	public function wc_bom_menu() {

		add_menu_page(
			__( 'WooCommerce BOM', 'wc_bom' ),
			'Woo BOM',
			'manage_options',
			'wc-bom-settings',
			[ $this->worker, 'settings_page' ],
			'dashicons-clipboard',//plugins_url( 'myplugin/images/icon.png' ),
			57
		);
	}


	/**
	 * Register and add settings
	 */
	public function page_init() {

		global $geo_mashup_options;
		register_setting(
			'wc_bom_settings_group', // Option group
			'wc_bom_settings', // Option name
			[ $this->worker, 'sanitize' ] // Sanitize
		);

		add_settings_section(
			'wc_bom_settings_section', // ID
			'', // Title
			[ $this, 'settings_info' ], // Callback
			'wc-bom-settings-admin' // Page
		);

		add_settings_section(
			'wc_bom_setting', // ID
			'wc-bom-settings', // Title
			[ $this->worker, 'settings_callback' ], // Callback
			'wc-bom-settings-admin', // Page
			'wc_bom_settings_section' // Section
		);
	}

	/**
	 * Print the Section text
	 */

	/**
	 * Print the Section text
	 */
	public function settings_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">

            </div>

        </div>
	<?php }


}
