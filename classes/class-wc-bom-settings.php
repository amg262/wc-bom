<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 *
 */
//namespace WooBom;

/**
 * PLUGIN SETTINGS PAGE
 */
class WC_Bom_Settings {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	public $wc_bom_options;


	/**
	 * Start up
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'wc_bom_menu' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );
		add_action( 'admin_enqueue_scripts', [ $this,'wco_admin'] );
		add_action( 'wp_ajax_wco_ajax',[ $this,'wco_ajax'] );
		//add_action( 'wp_ajax_nopriv_wco_ajax', [ $this,'wco_admin'] );
		//add_filter('custom_menu_order', [$this,'custom_menu_order']); // Activate custom_menu_order
		//add_filter('menu_order', [$this,'custom_menu_order']);
	}


	/**
	 * Add options page
	 */
	public function wc_bom_menu() {

		$count         = wp_count_posts( 'part' );
		$pending_count = $count->pending;
		// This page will be under "Settings"add_submenu_page( 'tools.php', 'SEO Image Tags', 'SEO Image Tags', 'manage_options', 'seo_image_tags', 'seo_image_tags_options_page' );

		// add_submenu_page()

		add_menu_page(
			__( 'WooCommerce BOM', 'wc_bom' ),
			'Woo BOM',
			'manage_options',
			'wc-bom',
			[ $this, 'settings_page' ],
			'dashicons-clipboard',//plugins_url( 'myplugin/images/icon.png' ),
			57
		);

		//add_submenu_page( 'wc-bom', 'Parts', 'Parts', 'manage_options', 'edit.php?post_type=part' );
		//add_menu_page('separator2','','','','','',61);

		/*add_submenu_page( 'woocommerce', 'Bill of Materials', 'Bill of Materials', 'manage_options', 'wc-bom-admin', [
			$this,
			'settings_callback',
		] );*/

		add_submenu_page( 'wc-bom-options', 'BOM Admin', 'BOM Settings', 'manage_options', 'bom-admin', [
			$this,
			'settings_page',
		] );

		/*add_options_page( 'Bom Options', 'WooCommerce BOM', 'manage_options', 'bom-admin', [
			$this,
			'settings_callback',
		] );*/

		add_filter( 'add_menu_classes', [ $this, 'pending' ] );
	}


	/**
	 * @param $menu
	 *
	 * @return mixed
	 */
	public function link_target( $menu ) {

		// loop through $menu items, find match, add indicator
		foreach ( $menu as $menu_key => $menu_data ) {
			$menu[ $menu_key ][ 0 ] .= "<span class='wc-bom-admin-menu'>&nbsp;</span>";
		}

		return $menu;
	}


	/**
	 * Shows pending for trail stories
	 */
	public function pending( $menu ) {

		$post_types    = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping' ];
		$type          = "part";
		$status        = "pending";
		$num_posts     = wp_count_posts( $type, 'readable' );
		$pending_count = 0;
		if ( ! empty( $num_posts->$status ) ) {
			$pending_count = $num_posts->$status;
		}
		// build string to match in $menu array
		if ( $type == 'post' ) {
			$menu_str = 'edit.php';
		} else {
			$menu_str = 'edit.php?post_type=' . $type;
		}
		// loop through $menu items, find match, add indicator
		foreach ( $menu as $menu_key => $menu_data ) {
			if ( $menu_str !== $menu_data[ 2 ] ) {
				continue;
			}
			$menu[ $menu_key ][ 0 ] .= " <span class='awaiting-mod count-$pending_count'><span class='pending-count'>" . number_format_i18n( $pending_count ) . '</span></span>';
		}

		return $menu;
	}


	/**
	 * Options page callback
	 */
	public function settings_page() {

		// Set class property
		$this->wc_bom_options = get_option( 'wc_bom_option' );
		?>

        <div class="wrap wc-bom-settings">

            <div id="icon-themes" class="icon32"></div>
            <h2>Sandbox Theme Options</h2>
			<?php settings_errors(); ?>

			<?php if ( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} // end if

			$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options';
			?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=wc-bom&tab=display_options" class="nav-tab">Display Options</a>
                <a href="?page=wc-bom&tab=social_options" class="nav-tab">Social Options</a>
            </h2>
            <form method="post" action="options.php">

				<?php if ( $active_tab === 'display_options' ) {
					// This prints out all hidden setting fields
					settings_fields( 'wc_bom_options' );
					do_settings_sections( 'wc-bom-options' );
				} else {
					echo 'hi';
					settings_fields( 'sandbox_theme_social_options' );
					do_settings_sections( 'sandbox_theme_social_options' );
				} // end if/else//wc_bom_options_group2

				submit_button( 'Save Options' );
				?>

                submit_button(); ?>

            </form>

        </div>
		<?php
	}


	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting(
			'wc_bom_options_group', // Option group
			'wc_bom_options', // Option name
			[ $this, 'sanitize' ] // Sanitize
		);

		register_setting(
			'wc_bom_options_group2', // Option group
			'wc_bom_options_2', // Option name
			[ $this, 'sanitize' ] // Sanitize
		);

		add_settings_section(
			'wc_bom_options_info', // ID
			'Title', // Title
			[ $this, 'print_option_info' ], // Callback
			'wc-bom-options' // Page
		);

		add_settings_section(
			'wc_bom_options_main', // ID
			'Title', // Title
			[ $this, 'settings_callback' ], // Callback
			'wc-bom-options' // Page
		);

	}


	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 *
	 * @return array
	 */
	public function sanitize( $input ) {

		$new_input = [];

		return $input;
	}
	/**
	 * Print the Section text
	 */

	/**
	 * Print the Section text
	 */
	public function print_option_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">

            </div>

        </div>
	<?php }


	public static function wco_admin() {
		//wp_register_script( 'wc_bom_admin_js', plugins_url( 'assets/js/wc_bom_admin.js', __FILE__ ), [ 'jquery' ] );

		$file = plugins_url( 'assets/js/wc_bom_admin.js', __DIR__ );

		if ( ! empty( $file ) ) {
			wp_register_script( 'wco_admin_js', $file, [ 'jquery' ] );
			wp_enqueue_script( 'wco_admin_js' );

			$ajax_object = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'=> wp_create_nonce('ajax_nonce'),
                'whatever'=>'product',
			];
			wp_localize_script( 'wco_admin_js', 'ajax_object', $ajax_object );

			/* Output empty div. */
		}
	}


	public static function wco_ajax() {
		//global $wpdb;


        var_dump( check_ajax_referer('ajax_nonce', 'security'));

		$whatever = $_POST[ 'whatever' ];
		$posts    = get_posts( [ 'post_type' => $whatever ] );

		foreach ( $posts as $p ) {
			echo $p->post_title . '<br>';
		}
		//$whatever = intval( $_POST['whatever'] );
		//$whatever += 10;
		//echo $whatever;
		wp_die();
	}
	/**
	 * Get the settings option array and print one of its values
	 */
	public function settings_callback() {

		//Get plugin options
		global $wc_bom_options;
		// Enqueue Media Library Use
		wp_enqueue_media();

		$wc_bom_options = (array) get_option( 'wc_bom_options' ); ?>

		<?php

		//var_dump($wc_bom_options);?>
        <div id="">
            <fieldset>
		       <button id="yeah" name="yeah"><a href="#" >Yeah</a></button>
            </fieldset>
        </div>
        <div>
            <div id="feedme">&nbps;</div>
        </div>

	<?php }
	/**
	 * Get the settings option array and print one of its values
	 */
	/*public function trail_story_setting_callback() {
		//Get plugin options
		global $wc_bom_options, $geo_mashup_options;
		$wc_bom_options = (array) get_option( 'trail_story_settings' );
		if( isset( $wc_bom_options['wc_bom_option'] ) ) { ?>
			<input type="checkbox" id="trail_story_settings" name="trail_story_settings[trail_story_setting]" value="1" <?php checked( 1, $wc_bom_options['trail_story_setting'], false ); ?> />

		<?php } else { ?>
			<input type="checkbox" id="trail_story_settings" name="trail_story_settings[trail_story_setting]" value="1" <?php checked( 1, $wc_bom_options['trail_story_setting'], false ); ?> />

		<?php }
		echo $html;
	}*/
}


if ( is_admin() ) {
	$settings = new WC_Bom_Settings();
}