<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */
namespace WooBom;

use function str_replace;
use function strtolower;

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

		wp_enqueue_script( 'postbox' );

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

		//$new_input = [];
		//if ( isset( $input['license_key'] ) ) {
			//$new_input['license_key'] = sanitize_text_field( $input['license_key'] );
		//}

		//if ( isset( $input[ 'title' ] ) ) {
		//	$new_input[ 'title' ] = sanitize_text_field( $input[ 'title' ] );
		//}
		return $input;
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function settings_callback() {

		global $wc_bom_options, $wc_bom_settings;

		//$wc_bom_options  = get_option( 'wc_bom_options' );
		$wc_bom_settings = get_option( 'wc_bom_settings' );
		// Enqueue Media Library Use
		wp_enqueue_media();
		///delete_option(WC_BOM_OPTIONS);
		///delete_option(WC_BOM_SETTINGS);

		var_dump( $wc_bom_settings ); ?>

        <div id="postbox-container-1" class="postbox-container">

            <div id="normal-sortables" class="meta-box-sortables">

                <div id="postbox" class="postbox">

                    <button type="button" class="handlediv button-link" aria-expanded="true">
                        <span class="screen-reader-text">Toggle panel: General</span>
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                    <!----------- COLUMN BREAK -------------->

                    <h2 class='hndle'><span>General</span></h2>

                    <div class="inside ">
                        alskdjflkasjdfjal;skdfjl;aksjdf
                        asdfkjas;dkfjlasd
                        fasldkfj;laksjdf
                        asldkfjsa
                    </div>
                    <!----------- COLUMN BREAK -------------->

                    <div id="major-publishing-actions">
                        <div id="publishing-action">
                            <span class="spinner"></span>
                            <input type="submit" accesskey="p" value="Update"
                                   class="button button-primary button-large"
                                   id="publish" name="publish">
                            <button class="button button-secondary button-large">
                                Reset
                            </button>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <!----------- COLUMN BREAK -------------->
        <!----------- COLUMN BREAK -------------->
        <div id="postbox-container-2" class="postbox-container">

            <div id="normal-sortables" class="meta-box-sortables">

                <div id="postbox" class="postbox">

                    <button type="button" class="handlediv button-link" aria-expanded="true">
                        <span class="screen-reader-text">Toggle panel: General</span>
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                    <!----------- COLUMN BREAK -------------->

                    <h2 class='hndle'><span>General</span></h2>

                    <div class="inside acf-fields -left">


                        <!----------- COLUMN BREAK -------------->

                        <table class="form-table">
                            <tbody>
                            <!----------- OPTION ----------->
                            <tr>
								<?php
								$label = 'License Key';
								$key   = $this->format_key( $label );
								$id    = 'wc_bom_settings[' . $key . ']';
								$obj   = $wc_bom_settings[ $key ]; ?>
                                <th scope="row">x

                                    <label for="<?php _e( $id ); ?>">
										<?php _e( $label ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="text"
                                           title="wc_bom_settings[<?php _e( $key ); ?>]"
                                           id="wc_bom_settings[<?php _e( $key ); ?>]"
                                           name="wc_bom_settings[<?php _e( $key ); ?>]"
                                           value="<?php echo $wc_bom_settings[ $key ]; ?>"/>
                                </td>
                            </tr>


                            <!----------- OPTION ----------->
                            <tr>
								<?php $label = 'Enable Beta'; ?>
								<?php $key = $this->format_key( $label ); ?>
								<?php $opt = $wc_bom_settings[ $key ]; ?>
                                <th scope=" row">

                                    <label for="<?php _e( $key ); ?>">
										<?php _e( $label ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="checkbox"
                                           id="wc_bom_settings[<?php _e( $key ); ?>]"
                                           name="wc_bom_settings[<?php _e( $key ); ?>]"
                                           value="1"
										<?php checked( 1, $wc_bom_settings[ $key ], true ); ?> />
                                </td>
                            </tr>
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->
                            <!----------- OPTION ----------->

                            </tbody>
                        </table>


                        <span id="yeahbtn" class="button secondary"> Yeah</span>
                        <span id="feedme"><br></span>
						<?php //submit_button( 'Save Options' ); ?>
                    </div>
                </div>

            </div>
        </div>
	<?php }

	protected function format_key( $text ) {

		$str = str_replace( [ '-', ' ' ], '_', $text );
		$str = strtolower( $str );

		return $str;
	}


}
