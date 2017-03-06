<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


/**
 * PLUGIN SETTINGS PAGE
 */
class WC_BomSettings {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	public $wc_bom_settings;


	/**
	 * Start up
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'add_wc_bom_menu_page' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
		add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );
	}


	/**
	 * Add options page
	 */
	public function add_wc_bom_menu_page() {

		//$count = wp_count_posts('geopost');
		//$pending_count = $count->pending;

		add_menu_page(
			__( 'WooCommerce BOM', 'wc_bom' ),
			'Woo BOM',
			'manage_options',
			'wc-bom',
			[ $this, 'wc_bom_setting_callback' ],
			'dashicons-clipboard',//plugins_url( 'myplugin/images/icon.png' ),
			57
		);
		// add_filter( 'add_menu_classes', array( $this, 'show_pending_number_trail_segment') );

	}


	public static function wco_admin() {

		//wp_register_script( 'wc_bom_admin_js', plugins_url( 'assets/js/wc_bom_admin.js', __FILE__ ), [ 'jquery' ] );

		$file = plugins_url( 'assets/js/wc_bom_admin.js', __DIR__ );

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


	public static function wco_ajax() {

		//global $wpdb;

		check_ajax_referer( 'ajax_nonce', 'security' );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

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


	public function add_target_to_links( $menu ) {

		// loop through $menu items, find match, add indicator
		foreach ( $menu as $menu_key => $menu_data ) {
			$menu[ $menu_key ][ 0 ] .= "<span class='geo-trail-map-menu'>&nbsp;</span>";
		}

		return $menu;
	}


	/**
	 * Options page callback
	 */
	public function create_wc_bom_menu_page() {

		// Set class property
		$this->wc_bom_settings = get_option( 'wc_bom_option' );
		?>
        <div class="wrap">
            <h1>GeoCMSx Map Maker</h1>
            <div>
                <p>
                <form method="post" action="options.php">
                    <h2 class="nav-tab-wrapper">
                        <a href="?page=wc-bom&tab=display_options" class="nav-tab">Display Options</a>
                        <a href="?page=wc-bom&tab=social_options" class="nav-tab">Social Options</a>
                    </h2>
					<?php

					// This prints out all hidden setting fields
					settings_fields( 'wc_bom_settings_group' );
					do_settings_sections( 'wc-bom-settings-admin' );
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

		global $geo_mashup_options;
		register_setting(
			'wc_bom_settings_group', // Option group
			'wc_bom_settings', // Option name
			[ $this, 'sanitize' ] // Sanitize
		);

		add_settings_section(
			'wc_bom_settings_section', // ID
			'', // Title
			[ $this, 'print_setting_info' ], // Callback
			'wc-bom-settings-admin' // Page
		);

		add_settings_section(
			'wc_bom_setting', // ID
			'', // Title
			[ $this, 'wc_bom_setting_callback' ], // Callback
			'wc-bom-settings-admin', // Page
			'wc_bom_settings_section' // Section
		);

	}


	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {

		$new_input = [];

		///foreach ($input as $var) {
		echo( $input );

		//}

		return $input;
	}
	/**
	 * Print the Section text
	 */

	/**
	 * Print the Section text
	 */
	public function print_setting_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">

                <p>
                <h3>Plugin developed by <a target="_blank" href="http://andrewgunn.xyz/">Andrew Gunn</a>. For Support
                    please <a href="http://andrewgunn.xyz/support/" target="_blank">follow this link.</a></h3>
                </p>
                <p>
                <h3>You can also <a href="mailto:andrewmgunn26@gmail.com" target="_blank">email me</a> to to in touch
                    faster, any feedback is welcomed!</h3>
                </p>http://fileground.net/wp-content/uploads/2016/10/mapiconscollection-markers.zip
                <br>
                <h3>
                    <div class="mapsmarker">Find more Map icons at <a href="https://mapicons.mapsmarker.com/"
                                                                      target="_blank">Maps Marker's</a> website
                    </div>
                </h3>
                </p>
                <br>
            </div>

        </div>
	<?php }


	/**
	 * Get the settings option array and print one of its values
	 */
	public function wc_bom_setting_callback() {

		//Get plugin options
		global $wc_bom_settings;
		// Enqueue Media Library Use
		wp_enqueue_media();

		// Get trail story options
		$wc_bom_settings = (array) get_option( 'wc_bom_settings' );

		//var_dump($wc_bom_settings);?>
        <div>
        <div>
            <hr>
            <table class="form-table">
                <tbody>
                <tr>

					<?php //$key = 'delete_data'; ?>
                    <th scope="row">
                        GeoCMS License
                    </th>
                    <td>

                        <fieldset><?php $key = 'gsx_license';
							//var_dump($wc_bom_settings[$key]);?>
                            <label for="wc_bom_settings[<?php echo $key; ?>]">
                                <input id='wc_bom_settings[<?php echo $key; ?>]'
                                       name="wc_bom_settings[<?php echo $key; ?>]" type="text"
                                       value="<?php echo sanitize_text_field( $wc_bom_settings[ $key ] ); ?>"/>

                            </label>

                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        Database
                    </th>
                    <td>
                        <fieldset><?php $key = 'update'; ?>

                            <input class="button button-primary" id='sit_settings[<?php echo $key; ?>]'
                                   name="sit_settings[<?php echo $key; ?>]" type="submit" value="Update Tags"/>


							<?php $key = 'delete'; ?>
                            &nbsp;
                            <input class="button-secondary delete" id='sit_settings[<?php echo $key; ?>]'
                                   name="sit_settings[<?php echo $key; ?>]" type="submit" value="Delete Tags"/>

                        </fieldset>
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        Delete All Data
                    </th>
                    <td>
                        <fieldset><?php $key = 'delete_data';
							//var_dump(isset($wc_bom_settings["delete_dbo"])); ?>

                            <label for="wc_bom_settings[<?php echo $key; ?>]">
                                <input id='wc_bom_settings[<?php echo $key; ?>]'
                                       name="wc_bom_settings[<?php echo $key; ?>]" type="checkbox"
                                       value="1" <?php checked( 1, $wc_bom_settings[ $key ], true ); ?> />
                                Drop all database tables and plugin data when uninstalled.
                            </label>
                            <p class="description"><span class="icon warn">&nbsp;</span>
                                ON UNINSTALL. Use at your own risk. A backup is recommended beforehand.</p>
                        </fieldset>

                    </td>
                </tr>
                </tbody>
            </table>


			<?php submit_button( 'Save Options' ); ?>
        </div>
        <p>
        <hr></p>
        <div id="">
            <h1><strong>Map Customization and Data Layers</strong></h1>
            <p>
                <table class="form-table">
                    <tbody>
                    <tr>
						<?php //$key = 'delete_data'; ?>
                        <th scope="row">
                            Traffic Layer
                        </th>
                        <td>

                            <fieldset><?php $key = 'traffic_layer';
								//var_dump($wc_bom_settings[$key]);?>
                                <label for="wc_bom_settings[<?php echo $key; ?>]">
                                    <input id='wc_bom_settings[<?php echo $key; ?>]'
                                           name="wc_bom_settings[<?php echo $key; ?>]" type="checkbox"
                                           value="1" <?php checked( 1, $wc_bom_settings[ $key ], true ); ?> />
                                </label>
            <p class="description"></p>

            </td>
            </tr>

            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    Transit Layer
                </th>
                <td>

                    <fieldset><?php $key = 'transit_layer';
						//var_dump($wc_bom_settings[$key]);?>
                        <label for="wc_bom_settings[<?php echo $key; ?>]">
                            <input id='wc_bom_settings[<?php echo $key; ?>]' name="wc_bom_settings[<?php echo $key; ?>]"
                                   type="checkbox" value="1" <?php checked( 1, $wc_bom_settings[ $key ], true ); ?> />
                        </label>
                        <p class="description"></p>

                </td>
            </tr>
            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    Bicicyle Layer
                </th>
                <td>

                    <fieldset><?php $key = 'bike_layer';
						//var_dump($wc_bom_settings[$key]);?>
                        <label for="wc_bom_settings[<?php echo $key; ?>]">
                            <input id='wc_bom_settings[<?php echo $key; ?>]' name="wc_bom_settings[<?php echo $key; ?>]"
                                   type="checkbox" value="1" <?php checked( 1, $wc_bom_settings[ $key ], true ); ?> />
                        </label>
                        <p class="description"></p>

                </td>
            </tr>
            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    Fusion Heat Layer
                </th>
                <td>

                    <fieldset><?php $key = 'fusion_heat_layer';
						//var_dump($wc_bom_settings[$key]);?>
                        <label for="wc_bom_settings[<?php echo $key; ?>]">
                            <input id='wc_bom_settings[<?php echo $key; ?>]' name="wc_bom_settings[<?php echo $key; ?>]"
                                   type="checkbox" value="1" <?php checked( 1, $wc_bom_settings[ $key ], true ); ?> />
                        </label>
                        <p class="description"></p>

                </td>
            </tr>
            <hr>
            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    Map Type
                </th>
                <td>

                    <fieldset>
						<?php $key = 'map_type';
						//var_dump($wc_bom_settings[$key]);?>
                        <label for="wc_bom_settings[<?php echo $key; ?>]">

                            <select id='wc_bom_settings[<?php echo $key; ?>]'
                                    name="wc_bom_settings[<?php echo $key; ?>]" type="checkbox"
                                    value="wc_bom_settings[<?php echo $key; ?>]">
                                <option value="Subtle Grayscale" <?php selected( $wc_bom_settings[ $key ],
								                                                 'Subtle Grayscale' ); ?>>Subtle
                                    Grayscale
                                </option>
                                <option value="Unsaturated Browns" <?php selected( $wc_bom_settings[ $key ],
								                                                   'Unsaturated Browns' ); ?>>
                                    Unsaturated Browns
                                </option>
                                <option value="Paper" <?php selected( $wc_bom_settings[ $key ], 'Paper' ); ?>>Paper
                                </option>
                                <option value="Pale Dawn" <?php selected( $wc_bom_settings[ $key ], 'Pale Dawn' ); ?>>
                                    Pale Dawn
                                </option>
                                <option value="Midnight Commander" <?php selected( $wc_bom_settings[ $key ],
								                                                   'Midnight Commander' ); ?>>Midnight
                                    Commander
                                </option>
                                <option value="Retro" <?php selected( $wc_bom_settings[ $key ], 'Retro' ); ?>>Retro
                                </option>
                                <option value="Bright" <?php selected( $wc_bom_settings[ $key ], 'Bright' ); ?>>Bright
                                </option>
                                <option value="Avocado" <?php selected( $wc_bom_settings[ $key ], 'Avocado' ); ?>>
                                    Avocado
                                </option>
                                <option value="Hopper" <?php selected( $wc_bom_settings[ $key ], 'Hopper' ); ?>>Hopper
                                </option>
                            </select>
                        </label>
                        <p class="description"></p>

                </td>
            </tr>
            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    # of Data Layers
                </th>
                <td>
                    <fieldset><?php $key = 'count_data_layers';
						if ( $wc_bom_settings[ $key ] == null ):
							$wc_bom_settings[ $key ] = '1';
						endif;
						//var_dump($wc_bom_settings[$key]); ?>


                        <input type="text" style="width:50px;" name="wc_bom_settings[<?php echo $key; ?>]"
                               id="wc_bom_settings[<?php echo $key; ?>]" value="<?php echo $wc_bom_settings[ $key ]; ?>"
                               placeholder="1" value="<?php if ( $wc_bom_settings[ $key ] == null ) {
							echo '1';
							$wc_bom_settings[ $key ] = '1';
						} else {
							echo $wc_bom_settings[ $key ];
						} ?>"/>
                        <input type="submit" value="Add Layer"/>
                        <br>
						<?php ?>
                </td>
            </tr>

			<?php if ( $wc_bom_settings[ 'count_data_layers' ] ) {
				$count = intval( $wc_bom_settings[ 'count_data_layers' ] );
				// var_dump($count);
				for ( $i = 1; $i <= $count; $i ++ ) { ?>

                    <tr>
						<?php //$key = 'delete_data'; ?>
                        <th scope="row">
                            Layer <?php echo '<strong>' . $i . '</strong>'; ?>
                        </th>
                        <td>
							<?php $str = 'data-layer-' . $i; ?>
                            <fieldset><?php $key = 'wc-bom-add-icon-text-box-' . $str ?>



								<?php
								$local_layers = [];
								$var          = 'data_layer_' . $i;
								$post_type    = $var; ?>
                                <div class="icon-wrapper">
                                    <div class="icon-header">
                                        <div class="icon-content">
                                            <div class="<?php echo $post_type; ?>">
                                                <div class="icon-post-type">
                                                    <h4><?php// _e( esc_html( $post_type ) ); ?></h4>
                                                </div>
                                                <div class="icon-image-buttons">

													<?php $key = 'wc_bom_add_icon_text_box_' . $post_type; ?>

                                                    <div class="trail-story-icon-button-container">
														<?php // Holster for Image url (Hidden) ?>
                                                        <label for="trail-story-add-icon-button-<?php echo $post_type; ?>">
															<?php _e( esc_html( $wc_bom_settings[ 'wc_bom_add_icon_text_box_' . $post_type ] ),
															          'geocmsx' ); ?>
                                                            <input type="hidden"
                                                                   id="wc_bom_add_icon_text_box_<?php echo $post_type; ?>"
                                                                   class="trail-story-icon-url"
                                                                   name="wc_bom_settings[wc_bom_add_icon_text_box_<?php echo $post_type; ?>]"
                                                                   value="<?php echo $wc_bom_settings[ 'wc_bom_add_icon_text_box_' . $post_type ]; ?>"/>

															<?php if ( $wc_bom_settings[ 'wc_bom_add_icon_text_box_' . $post_type ] ) {
															} ?>

															<?php // Button to add Image icon ?>
                                                            <input type="button"
                                                                   id="trail-story-add-icon-button-<?php echo $post_type; ?>"
                                                                   class="button trail-story-add-icon-button <?php echo $wc_bom_settings[ $key ] ?
																       'hidden' : ''; ?>"
                                                                   name="trail-story-add-icon-button"
                                                                   value="<?php _e( 'Add File',
															                        'geo-mashup-cms-add-on' ); ?>"/>

															<?php // Button to remove Image icon ?>
                                                            <input type="button"
                                                                   id="trail-story-remove-icon-button-<?php echo $post_type; ?>"
                                                                   class="button trail-story-remove-icon-button <?php echo ! $wc_bom_settings[ $key ] ?
																       'hidden' : ''; ?>"
                                                                   name="trail-story-add-icon-button"
                                                                   value="<?php _e( 'Remove File',
															                        'geo-mashup-cms-add-on' ); ?>"/>

                                                            <div style="clear:both;height:0;"></div>
                                                    </div>

                                                    <div class="trail-story-icon-image-container">

														<?php if ( $wc_bom_settings[ $key ] ) { ?>

                                                            <img src="<?php echo esc_attr( $wc_bom_settings[ $key ] ); ?>"
                                                                 alt="" style="max-width:100%;"/>

														<?php } ?>

                                                    </div>
                                                    </label>
                                                </div>
                                                <div style="clear:both;height:0;"></div>
                                            </div>
                                        </div>
                                    </div>
                        </td>
                    </tr>
				<?php }
			} ?>
            <hr>
			<?php //var_dump($wc_bom_settings); ?>
            <hr>
            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    Data Layer URLs
                </th>
                <td>
                    <fieldset>
						<?php $key = 'custom_kml_layers';
						//var_dump($wc_bom_settings[$key]); ?>


                        <input type="text" style="width:700px;" name="wc_bom_settings[<?php echo $key; ?>]"
                               id="wc_bom_settings[<?php echo $key; ?>]"
                               value="<?php echo( $wc_bom_settings[ $key ] ); ?>"/>
                        <br>

                        <p class="description">DEFAULT IS COMMA DELIMITED</p>

                </td>
            </tr>
            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    Earthquake GeoRSS
                </th>
                <td>
                    <fieldset>
						<?php $key = 'eq_geo_rss';
						//var_dump($wc_bom_settings[$key]); ?>


                        <input type="text" style="width:700px;" name="wc_bom_settings[<?php echo $key; ?>]"
                               id="wc_bom_settings[<?php echo $key; ?>]"
                               value="<?php echo sanitize_text_field( $wc_bom_settings[ $key ] ); ?>"/>
                        <br>

                        <p class="description">DEFAULT IS COMMA DELIMITED</p>

                </td>
            </tr>

            <tr>
				<?php //$key = 'delete_data'; ?>
                <th scope="row">
                    GeoJSON URLs
                </th>
                <td>
                    <fieldset>
						<?php $key = 'geo_json';
						//var_dump($wc_bom_settings[$key]); ?>

                        <label for="wc_bom_settings[<?php echo $key; ?>]">
                        </label>
                        <input type="text" style="width:700px;" name="wc_bom_settings[<?php echo $key; ?>]"
                               id="wc_bom_settings[<?php echo $key; ?>]"
                               value="<?php echo sanitize_text_field( $wc_bom_settings[ $key ] ); ?>"/>

                    </fieldset>
                    <p class="description">DEFAULT IS COMMA DELIMITED</p>

                </td>

            </tr>


            </tbody>
            </table></p>
			<?php submit_button( 'Save Options' ); ?>
        </div>
        <p>
        <hr></p>
        <div>


            <div style="clear:both;height:0;"></div>
        </div>
        <br><br>

	<?php }
	// TODO: Input fields for KMLs
	/**
	 * Get the settings option array and print one of its values
	 */
	/*public function wc_bom_setting_callback() {
		//Get plugin options
		global $wc_bom_settings, $geo_mashup_options;
		$wc_bom_settings = (array) get_option( 'wc_bom_settings' );
		if( isset( $wc_bom_settings['wc_bom_option'] ) ) { ?>
			<input type="checkbox" id="wc_bom_settings" name="wc_bom_settings[wc_bom_setting]" value="1" <?php checked( 1, $wc_bom_settings['wc_bom_setting'], false ); ?> />

		<?php } else { ?>
			<input type="checkbox" id="wc_bom_settings" name="wc_bom_settings[wc_bom_setting]" value="1" <?php checked( 1, $wc_bom_settings['wc_bom_setting'], false ); ?> />

		<?php }
		echo $html;
	}*/
}


if ( is_admin() ) {
	$wc_bom = new WC_BomSettings();
}