<?php
declare( strict_types=1 );

namespace WooBom;

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/1/17
 * Time: 11:39 AM
 */

/*
 *
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
 */

function delete_posts( $post_type ) {


	foreach ( $post_type as $type ) {
		$args = [
			'post_type'      => $type,
			'posts_per_page' => - 1,
		];

		$posts = get_posts( $args );

		foreach ( $posts as $post ) {
			wp_delete_post( $post->id, true );
		}
	}


}


function delete_terms( $taxonomy ) {

	foreach ( $taxonomy as $tax ) {
		$args = [
			'taxonomy'   => $tax,
			'hide_empty' => false,
		];

		$terms = get_terrms( $args );

		foreach ( $terms as $term ) {
			wp_delete_term( $term->id, $tax );
		}
	}


}

function drop_table( $table ) {
	global $wpdb;

	$table_name = $wpdb->prefix . $table;
	$sql        = "DROP TABLE IF EXISTS " . $table_name . "";

	dbDelta( $sql );
}

/**
 *
 */

function delete_options() {

	delete_option( WC_BOM_OPTIONS );
	//add_option( 'wc', $jal_db_version );
}

/**
 *
 */

function delete_settings() {

	delete_option( WC_BOM_SETTINGS );
	//add_option( 'wc', $jal_db_version );
}

delete_posts( 'part' );
delete_posts( 'assembly' );
delete_terms( 'assembly_category' );
delete_terms( 'part-category' );
delete_terms( 'part_tags' );
drop_table( 'woo_bom' );
delete_options();
delete_settings();
