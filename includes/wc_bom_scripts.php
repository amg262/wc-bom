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
 * Date: 2/25/17
 * Time: 4:04 PM
 */

/**
 * Script styles to run jQuery on pages
 */
add_action( 'wp_enqueue_scripts', 'wco_setup_scripts' );
add_action( 'wp_enqueue_scripts', 'wco_scripts', 1 );
add_action( 'wp_enqueue_scripts', 'wco_styles' );

function wco_setup_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
}

/**
 * Enqueue scripts
 */


function wco_scripts() { ?>



	<?php
}

function wco_styles() { ?>



	<?php
}
