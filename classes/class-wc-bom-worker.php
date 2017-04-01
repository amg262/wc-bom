<?php declare( strict_types = 1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */
namespace WooBom;
/**
 * Class WC_Bom_Worker
 *
 * @package WooBom
 */
class WC_Bom_Worker {

	/**
	 * WC_Bom_Worker constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
		add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );
		//add_action( 'wp_ajax_nopriv_wco_ajax', [ $this, 'wco_ajax' ] );
	}

	/**
	 *
	 */
	public function wco_admin() {

		$ajax_object = [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'ajax_nonce' ),
			'whatever' => 'product',
			'action'   => [ $this, 'wco_ajax' ]
			//'options'  => 'wc_bom_option[opt]',
		];
		wp_localize_script( 'bom_adm_js', 'ajax_object', $ajax_object );
		/* Output empty div. */
	}

	/**
	 *
	 */
	public function wco_ajax() {

		//global $wpdb;
		check_ajax_referer( 'ajax_nonce', 'security' );
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		}
		$whatever = $_POST['whatever'];
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
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 *
	 * @return array
	 */
	public function sanitize( $input ) {

		$new_input = [];
		if ( isset( $input['license_key'] ) ) {
			$new_input['license_key'] = sanitize_text_field( $input['license_key'] );
		}

		//if ( isset( $input[ 'title' ] ) ) {
		//	$new_input[ 'title' ] = sanitize_text_field( $input[ 'title' ] );
		//}
		return $new_input;
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
		//var_dump($wc_bom_options);?>
        <div>
			<?php ?>

            <table class="form-table">
                <tbody>

                <h4>License</h4>
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

                <h4>Modules</h4>
				<?php //if ( $wc_bom_settings[ $key ] !== '' ) { ?>

                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
					<?php
					$name = 'Material';
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


                </tr>
                <!-- end settings -->

                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
					<?php
					$name = 'Assembly';
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
					$name = 'Inventory';
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

                </tr>
                <!-- end settings -->
                <!-- end settings -->

                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
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

                <!-- end settings -->
                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
                    <!-- top setting -->
					<?php
					$name = 'Enable Cron';
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
                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
                    <!-- top setting -->
					<?php
					$name = 'Enable API';
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

                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
                    <!-- top setting -->
					<?php
					$name = 'Passphrase';
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
                                   type="password"
                                   id="<?php _e( $id ); ?>"
                                   name="<?php _e( $id ); ?>"
                                   value="<?php _e( $obj ); ?>"/>

                        </fieldset>
                    </td>
                </tr>

                <tr class="wc-bom-settings" id="">
                    <!-- top setting -->
                    <!-- top setting -->
					<?php
					$name = 'Enable Charts';
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
				<?php //} ?>
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
