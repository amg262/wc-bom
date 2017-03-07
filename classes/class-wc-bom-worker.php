<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

namespace WooBom;

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 3/7/17
 * Time: 8:44 AM
 */
class WC_Bom_Worker {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
		add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );
		//add_action( 'wp_ajax_nopriv_wco_ajax', [ $this, 'wco_ajax' ] );
	}


	public function wco_admin() {

		//wp_register_script( 'wc_bom_admin_js', plugins_url( 'assets/js/wc_bom_admin.js', __FILE__ ), [ 'jquery' ] );

		$file = plugins_url( 'assets/lib/js/wc_bom_admin.js', __DIR__ );

		if ( ! empty( $file ) ) {
			wp_register_script( 'wco_adm_js', $file, [ 'jquery' ] );
			wp_enqueue_script( 'wco_adm_js' );

			$ajax_object = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'ajax_nonce' ),
				'whatever' => 'product',
				'action'   => [ $this, 'wco_ajax' ]
				//'options'  => 'wc_bom_option[opt]',
			];
			wp_localize_script( 'wco_adm_js', 'ajax_object', $ajax_object );

			/* Output empty div. */
		}
	}


	public function wco_ajax() {

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

}

$obj = new WC_Bom_Worker();