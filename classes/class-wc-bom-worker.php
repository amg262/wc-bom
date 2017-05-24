<?php declare( strict_types=1 );
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

		wp_enqueue_script( 'postbox' );

		//wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/' .
		//                                 'sweetalert/1.1.3/sweetalert.min.js' );
		//wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/' .
		//                                'sweetalert/1.1.3/sweetalert.min.css' );
		//wp_enqueue_script( 'parsely_js', 'https://cdnjs.cloudflare.com/ajax/libs/' .
		//                               'parsley.js/2.7.2/parsley.min.js' );
		wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' .
		                             'sweetalert/1.1.3/sweetalert.min.css' );
		//https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js
		//wp_enqueue_script( 'select222', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js' );
		wp_enqueue_script( 'select222', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js' );


		$ajax_data = $this->get_data();

		$ajax_object = [
			'ajax_url'  => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'ajax_nonce' ),
			'ajax_data' => $ajax_data,
			'action'    => [ $this, 'wco_ajax' ]
			//'options'  => 'wc_bom_option[opt]',
		];
		wp_localize_script( 'bom_adm_js', 'ajax_object', $ajax_object );
		/* Output empty div. */
	}

	public function get_data() {

		$args = [
			'post_type'   => 'product',
			'post_status' => 'publish',
		];

		$out   = [];
		$posts = get_posts( $args );
		foreach ( $posts as $p ) {
			$out[] = [ 'id' => $p->ID, 'text' => $p->post_title ];
		}
		$json = json_encode($out);

		return $json;
	}

	/**
	 *
	 */
	public function wco_ajax() {

		//global $wpdb;
		check_ajax_referer( 'ajax_nonce', 'security' );
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		}

		//include_once __DIR__ . '/class-wc-bom-calculate.php';
		//$calc = new WC_Bom_Calculate();

		//$postdata = $_POST['postdata'];

		$data = $_POST['ajax_data'];

		$posts = $data['posts'];

		$args  = [
			'post_type'   => [ 'part', 'assembly', 'product' ],
			'post_status' => 'publish',
		];
		$posts = get_posts( $args );
		foreach ( $posts as $p ) {
			echo $p->post_title . '<br>';
		}

		delete_option( WC_BOM_OPTIONS );
		delete_option( WC_BOM_SETTINGS );

		wp_die( 'Ajax finished.' );
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

		$wc_bom_options  = get_option( 'wc_bom_options' );
		$wc_bom_settings = get_option( 'wc_bom_settings' );
		// Enqueue Media Library Use
		wp_enqueue_media();
		include_once __DIR__ . '/class-wc-bom-logger.php';
		$logger = new WC_Bom_Logger();
		//delete_option( WC_BOM_OPTIONS );
		//delete_option( WC_BOM_SETTINGS );


		//var_dump( $wc_bom_settings ); ?>

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

                            <tr>
								<?php
								$label = 'Beta Key';
								$key   = $this->format_key( $label );
								$id    = 'wc_bom_settings[' . $key . ']';
								$obj   = $wc_bom_settings[ $key ]; ?>
                                <th scope="row">
                                    <label for="<?php _e( $id ); ?>">
										<?php _e( $label ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="password"
                                           title="wc_bom_settings[<?php _e( $key ); ?>]"
                                           id="wc_bom_settings[<?php _e( $key ); ?>]"
                                           name="wc_bom_settings[<?php _e( $key ); ?>]"
                                           style="width:100%;max-width:100px;"

                                           value="<?php echo $wc_bom_settings[ $key ]; ?>"/>
                                </td>

								<?php $betakey = $logger->return_file( 'beta.key' );
								//var_dump( $logger );

								if ( $betakey === md5( $wc_bom_settings[ $key ] ) ) {
									echo 'time for icceama';
								}
								?>
								<?php var_dump( md5( $wc_bom_settings[ $key ] ) ); ?>
                            </tr>
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
                                           style="width:100%;max-width:500px;"
                                           value="<?php echo $wc_bom_settings[ $key ]; ?>"/>
                                </td>
								<?php $key2 = $logger->return_file( 'license.key' );

								//var_dump( $logger );

								if ( $key2 === $wc_bom_settings[ $key ] ) {
									echo '<b>SUCCESS</b>';
								}
								?>
								<?php var_dump( $key2 ); ?>

								<?php /*$betakey = $logger->return_file( 'license.key' );
	                            //var_dump( $logger );

	                            if ( $betakey === $wc_bom_settings[ $key ] )  {
		                            echo 'SUCCESS!';
	                            }
	                            ?>
	                            <?php echo wc_bom_settings[ $key ]; );*/ ?>
                            </tr>


                            <!----------- OPTION ----------->
                            <tr>
								<?php $label = 'Enable Beta'; ?>
								<?php $key = $this->format_key( $label ); ?>
								<?php $opt = $wc_bom_settings[ $key ]; ?>
                                <th scope="row">

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
                            <!----------- AJAX ----------->
                            <tr>
								<?php $label = 'Form Update'; ?>
								<?php $key = $this->format_key( $label ); ?>
								<?php $opt = $wc_bom_settings[ $key ]; ?>
                                <th scope="row">

                                    <label for="<?php _e( $key ); ?>">
										<?php _e( $label ); ?>
                                    </label>
                                </th>
                                <td>

                                    <span class="button secondary"
                                          id="form_ajax_update"
                                          name="wc_bom_settings[<?php _e( $key ); ?>]"
                                          value="yeah">
                                        Yeah
                                    </span>
                                    <div class="form_update_ouput">
                                        <p>
                                            <strong>
                                                <span id="form_update_ouput">
                                                    <br>
                                                </span>
                                            </strong>
                                        </p>
                                    </div>
                                   <div>
                                       <span class="button primary" id="button_hit" name="button_hit">
                                           Generate Data
                                       </span>
                                        <div>
                                            <span id="button_out"><hr></span>
                                        </div>
                                   </div>

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

                            </tbody>
                        </table>


                        <div class="settings_ajax_wrap">
                            <span id="yeahbtn" class="button secondary"> Yeah</span>
                            <span id="feedme"><br></span>
							<?php //submit_button( 'Save Options' ); ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
	<?php }

	public function format_key( $text ) {

		$str = str_replace( [ '-', ' ' ], '_', $text );

		return strtolower( $str );

	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function options_callback() {

		global $wc_bom_options, $wc_bom_settings;

		$wc_bom_options  = get_option( 'wc_bom_options' );
		$wc_bom_settings = get_option( 'wc_bom_settings' );
		// Enqueue Media Library Use
		wp_enqueue_media();
		//delete_option( WC_BOM_OPTIONS );
		//delete_option( WC_BOM_SETTINGS );


		var_dump( $wc_bom_options ); ?>

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
								$id    = 'wc_bom_options[' . $key . ']';
								$obj   = $wc_bom_options[ $key ]; ?>
                                <th scope="row">x

                                    <label for="<?php _e( $id ); ?>">
										<?php _e( $label ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="text"
                                           title="wc_bom_options[<?php _e( $key ); ?>]"
                                           id="wc_bom_options[<?php _e( $key ); ?>]"
                                           name="wc_bom_options[<?php _e( $key ); ?>]"
                                           value="<?php echo $wc_bom_options[ $key ]; ?>"/>
                                </td>
                            </tr>

                            <!----------- OPTION ----------->
                            <!----------- AJAX ----------->
                            <tr>
								<?php $label = 'Form Update'; ?>
								<?php $key = $this->format_key( $label ); ?>
								<?php $opt = $wc_bom_options[ $key ]; ?>
                                <th scope="row">

                                    <label for="<?php _e( $key ); ?>">
										<?php _e( $label ); ?>
                                    </label>
                                </th>
                                <td>

                                    <span class="button secondary"
                                          id="form_ajax_update"
                                          name="wc_bom_options[<?php _e( $key ); ?>]"
                                          value="yeah">
                                        Yeah
                                    </span>
                                    <div class="form_update_ouput">
                                        <p>
                                            <strong>
                                                <span id="form_update_ouput">
                                                    <br>
                                                </span>
                                            </strong>
                                        </p>
                                    </div>

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

                            </tbody>
                        </table>


                        <div class="settings_ajax_wrap">
                            <span id="yeahbtn" class="button secondary"> Yeah</span>
                            <span id="feedme"><br></span>
							<?php //submit_button( 'Save Options' ); ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
	<?php }


}
