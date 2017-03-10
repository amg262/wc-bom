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
require_once WC_BOM_ABSTRACT . 'WC_Abstract_Settings.php';

/**
 * Class WC_Bom_Settings
 *
 * @package WooBom
 */
class WC_Bom_Settings implements WC_Abstract_Settings {

	/**
	 * @var null
	 */
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
			[ $this, 'settings_page' ],
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

	/**
	 * Options page callback
	 */
	public function settings_page() {

		global $wc_bom_options, $wc_bom_settings;
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		$wc_bom_options  = get_option( WC_BOM_OPTIONS );
		// Set class property
		?>

        <div class="wrap">

            <div class="wc-bom settings-page">

                <div id="icon-themes" class="icon32"></div>
                <h2>Sandbox Theme Options</h2>
				<?php settings_errors(); ?>

				<?php
				$name = 'License Key';
				$str  = str_replace( ' ', '_', $name );
				$key  = strtolower( $str );
				$id   = 'wc_bom_settings[' . $key . ']';
				$desc = 'desc';
				$obj  = $wc_bom_settings[ $key ];
				$icon = 'wp-menu-image dashicons-before dashicons-hammer';

				//if ( isset( $_GET[ 'tab' ] ) ) {
				// $active_tab = $_GET[ 'tab' ];
				//} // end if

				//$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options';
				?>

				<?php // if ( $obj !== '' ) { ?>
                <h2 class="nav-tab-wrapper">
                    <a href="?page=wc-bom-settings&tab=display_options" class="nav-tab">Display Options</a>
                    <a href="?page=wc-bom-settings&tab=social_options" class="nav-tab">Social Options</a>
                </h2>
				<?php //} ?>

                <form method="post" action="options.php">

					<?php //if ( $active_tab === 'display_options' ) {
					// This prints out all hidden setting fields
					//if (check_admin_referer($non, 'wc_non')) {
					//var_dump($wc_bom_settings);
					//}
					//wp_verify_nonce($non, 'wc_non');

					settings_fields( 'wc_bom_settings_group' );
					do_settings_sections( 'wc-bom-settings-admin' );
					submit_button( 'Save Options' );

					//} else {
					//echo 'hi';
					//settings_fields( 'sandbox_theme_social_options' );
					//do_settings_sections( 'sandbox_theme_social_options' );
					//} // end if/else//wc_bom_options_group2

					//				submit_button( 'Save Options' );
					?>

                </form>

            </div>

        </div>
		<?php
	}
}
