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
		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
		add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );
		add_action( 'wp_ajax_nopriv_wco_ajax', [ $this, 'wco_ajax' ] );
		//add_filter('custom_menu_order', [$this,'custom_menu_order']); // Activate custom_menu_order
		//add_filter('menu_order', [$this,'custom_menu_order']);
	}


	/**
	 * Add options page
	 */
	public function wc_bom_menu() {

		//$count         = wp_count_posts( 'part' );
		//$pending_count = $count->pending;
		// This page will be under "Settings"add_submenu_page( 'tools.php', 'SEO Image Tags', 'SEO Image Tags', 'manage_options', 'seo_image_tags', 'seo_image_tags_options_page' );

		// add_submenu_page()

		add_menu_page(
			__( 'WooCommerce BOM', 'wc_bom' ),
			'Woo BOM',
			'manage_options',
			'wc-bom-settings',
			[ $this, 'settings_page' ],
			'dashicons-clipboard',//plugins_url( 'myplugin/images/icon.png' ),
			57
		);

		//add_filter( 'add_menu_classes', [ $this, 'pending' ] );
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

		global $wc_bom_options, $wc_bom_settings;
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		$wc_bom_options  = get_option( WC_BOM_OPTIONS );

		// Set class property
		?>

        <div class="wrap wc-bom settings-page">

            <div id="icon-themes" class="icon32"></div>
            <h2>Sandbox Theme Options</h2>
			<?php settings_errors(); ?>

			<?php
			$name = 'Parts';
			$key  = strtolower( $name );
			$id   = 'wc_bom_settings[' . $key . ']';
			$desc = 'desc';
			$obj  = $wc_bom_settings[ $key ];
			$icon = 'wp-menu-image dashicons-before dashicons-hammer';

			//if ( isset( $_GET[ 'tab' ] ) ) {
			// $active_tab = $_GET[ 'tab' ];
			//} // end if

			//$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options';
			?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=wc-bom-settings&tab=display_options" class="nav-tab">Display Options</a>
                <a href="?page=wc-bom-settings&tab=social_options" class="nav-tab">Social Options</a>
            </h2>
            <form method="post" action="options.php">

				<?php //if ( $active_tab === 'display_options' ) {
				// This prints out all hidden setting fields
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
		<?php
	}


	/**
	 * Register and add settings
	 */
	public function page_init() {

		global $geo_mashup_options;
		register_setting(
			'wc_bom_settings_group', // Option group
			'wc_bom_settings', // Option name
			[ $this, 'sanitize' ] // Sanitize
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
			[ $this, 'settings_callback' ], // Callback
			'wc-bom-settings-admin', // Page
			'wc_bom_settings_section' // Section
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
	public function settings_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">

            </div>

        </div>
	<?php }


	/**
	 *
	 */
	public static function wco_admin() {

		//wp_register_script( 'wc_bom_admin_js', plugins_url( 'assets/js/wc_bom_admin.js', __FILE__ ), [ 'jquery' ] );

		$file = plugins_url( 'assets/lib/js/wc_bom_ajax.js', __DIR__ );

		if ( ! empty( $file ) ) {
			wp_register_script( 'wco_admin_js', $file, [ 'jquery' ] );
			wp_enqueue_script( 'wco_admin_js' );

			$ajax_object = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'ajax_nonce' ),
				'whatever' => 'product',
				'options'  => 'wc_bom_option[opt]',
			];
			wp_localize_script( 'wco_admin_js', 'ajax_object', $ajax_object );

			/* Output empty div. */
		}
	}


	/**
	 *
	 */
	public static function wco_ajax() {

		//global $wpdb;

		var_dump( check_ajax_referer( 'ajax_nonce', 'security' ) );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			// return;
			//return;
		}
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

		global $wc_bom_options, $wc_bom_settings;

		$wc_bom_options  = get_option( WC_BOM_OPTIONS );
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		// Enqueue Media Library Use
		wp_enqueue_media();

		var_dump( $wc_bom_settings );

		//var_dump($wc_bom_options);?>
        <div>
            <table class="form-table">
                <tbody>

                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
					<?php
					$name = 'License Key';
					$str  = str_replace( ' ', '_', $name );
					$key  = strtolower( $str );
					$id   = 'wc_bom_settings[' . $key . ']';
					$desc = 'desc';
					$obj  = $wc_bom_settings[ $key ];
					$icon = '';
					?>
                    <th scope="row">
                        <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                        </label>
                    </th>
                    <td>
                        <fieldset>
                            <input title="<?php _e( $id ); ?>"
                                   type="text"
                                   id="<?php _e( $id ); ?>"
                                   name="<?php _e( $id ); ?>"
                                   value="<?php _e( $obj ); ?>"/>

                        </fieldset>
                        
                    </td>
                </tr>

				<?php if ( $wc_bom_settings[ $key ] !== null ) { ?>

                    <tr class="wc-bom-settings" id="">
                        <!-- top setting -->
						<?php
						$name = 'Parts';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-admin-tools';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>

                        <!-- top setting -->
						<?php
						$name = 'Assemblies';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-hammer';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>
                    </tr>
                    <!-- end settings -->

                    <tr class="wc-bom-settings" id="">
                        <!-- top setting -->
						<?php
						$name = 'Shipments';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-migrate';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>

                        <!-- top setting -->
						<?php
						$name = 'Requisitions';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-clipboard';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>
                    </tr>
                    <!-- end settings -->

                    <tr class="wc-bom-settings" id="">
                        <!-- top setting -->
						<?php
						$name = 'Purchases';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-cart';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>

                        <!-- top setting -->
						<?php
						$name = 'Vendors';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-groups';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>
                    </tr>
                    <!-- end settings -->
                    <!-- end settings -->

                    <tr class="wc-bom-settings" id="">
                        <!-- top setting -->
						<?php
						$name = 'Production';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-schedule';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>

                        <!-- top setting -->
						<?php
						$name = 'ECN';
						$key  = strtolower( $name );
						$id   = 'wc_bom_settings[' . $key . ']';
						$desc = 'desc';
						$obj  = $wc_bom_settings[ $key ];
						$icon = 'wp-menu-image dashicons-before dashicons-flag';
						?>
                        <th scope="row">
                            <label for="<?php _e( $id ); ?>">
                            <span class="<?php _e( $icon ); ?>">
                                <?php _e( $name ); ?>
                            </span>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <input title="<?php _e( $id ); ?>"
                                       type="checkbox"
                                       id="<?php _e( $id ); ?>"
                                       name="<?php _e( $id ); ?>"
                                       value="1"
									<?php if ( $obj ) {
										checked( 1, $obj, true );
									} ?> />

                            </fieldset>
                        </td>
                    </tr>
				<?php } ?>
                <!-- end settings -->
                </tbody><!-- end tbody -->

            </table><!--end table -->

            <p>
                <span id="yeahbtn" class="button secondary"> Yeah</span>
            </p>
            <div>
                <div id="feedme">&nbps;</div>
            </div>
        </div>


	<?php }
}


if ( is_admin() ) {

	$settings = new WC_Bom_Settings();
}