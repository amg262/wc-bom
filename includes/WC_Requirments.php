<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 3/6/17
 * Time: 1:21 PM
 */

namespace WooBom;

function check_requirements() {

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	$woo       = 'woocommerce';
	$woo_url   = $woo . '/' . $woo . '.php';
	$is_active = in_array( $woo_url, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );

	if ( ! $is_active ) {
		if ( plugin_dir_url( $woo_url ) ) {
			//activate_plugins($woo_url);

		}
		deactivate_plugins( __FILE__ );

		add_action( 'admin_notices', [ $this, 'requirements_error' ] );

		//wp_die();
		return false;
		//return false;
	}

	return true;
	//}

}