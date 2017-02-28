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
			'wc-bom-admin',
			[ $this, 'settings_callback' ],
			'dashicons-clipboard',//plugins_url( 'myplugin/images/icon.png' ),
			57
		);

		add_submenu_page( 'wc-bom-admin', 'Parts', 'Parts', 'manage_options', 'edit.php?post_type=part' );
		//add_menu_page('separator2','','','','','',61);

		add_submenu_page( 'woocommerce', 'Bill of Materials', 'Bill of Materials', 'manage_options', 'wc-bom-admin', [
			$this,
			'settings_callback',
		] );

		add_submenu_page( 'wc-bom-admin', 'BOM Admin', 'BOM Settings', 'manage_options', 'bom-admin', [
			$this,
			'settings_callback',
		] );

		add_options_page( 'Bom Options', 'WooCommerce BOM', 'manage_options', 'bom-admin', [
			$this,
			'settings_callback',
		] );

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
        <div class="wrap">
            <h1>WooCommerce Bill of Materials</h1>
            <div>
                <p>
                <form method="post" action="options.php">

					<?php


					// This prints out all hidden setting fields
					settings_fields( 'wc_bom_options_group' );
					do_settings_sections( 'wc-bom-options-admin' );
					submit_button( 'Save Options' );
					?>
                </form>
                </p>
            </div>
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

		add_settings_section(
			'wc_bom_options_section', // ID
			'Title', // Title
			[ $this, 'print_option_info' ], // Callback
			'wc-bom-options-admin' // Page
		);

		add_settings_section(
			'wc_bom_option', // ID
			'Title', // Title
			[ $this, 'settings_callback' ], // Callback
			'wc-bom-options-admin', // Page
			'wc_bom_options_section' // Section
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


	/**
	 * Get the settings option array and print one of its values
	 */
	public function settings_callback() {
		//Get plugin options
		global $wc_bom_options;
		// Enqueue Media Library Use
		wp_enqueue_media(); ?>

        <ul class="tabs" data-tabs id="example-tabs">
            <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Tab 1</a></li>
            <li class="tabs-title"><a href="#panel2">Tab 2</a></li>
            <li class="tabs-title"><a href="#panel3">Tab 3</a></li>
            <li class="tabs-title"><a href="#panel4">Tab 4</a></li>
            <li class="tabs-title"><a href="#panel5">Tab 5</a></li>
            <li class="tabs-title"><a href="#panel6">Tab 6</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="example-tabs">
            <div class="tabs-panel is-active" id="panel1">
                <p>one</p>
                <p>Check me out! I'm a super cool Tab panel with text content!</p>
            </div>
            <div class="tabs-panel" id="panel2">
                <p>two</p>
                <img class="thumbnail" src="assets/img/generic/rectangle-7.jpg">
            </div>
            <div class="tabs-panel" id="panel3">
                <p>three</p>
                <p>Check me out! I'm a super cool Tab panel with text content!</p>
            </div>
            <div class="tabs-panel" id="panel4">
                <p>four</p>
                <img class="thumbnail" src="assets/img/generic/rectangle-2.jpg">
            </div>
            <div class="tabs-panel" id="panel5">
                <p>five</p>
                <p>Check me out! I'm a super cool Tab panel with text content!</p>
            </div>
            <div class="tabs-panel" id="panel6">
                <p>six</p>
                <img class="thumbnail" src="assets/img/generic/rectangle-8.jpg">
            </div>
        </div><?php
		$wc_bom_options = (array) get_option( 'wc_bom_options' );

		//var_dump($wc_bom_options);?>
        <div id="">

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