<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;


use function var_dump;
use function wp_cache_set;
use function wp_parse_args;

class WC_Bom_Calculate {

	/**
	 * @var null
	 */

	private $post_types = [];
	private $post_data = [];
	private $cache_keys = [];

	public function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {
		$this->get_post_objs();
		var_dump( $this->cache_keys );
		var_dump( wp_cache_get( $this->cache_keys[0] ) );
	}

	public function get_post_objs( $query_args ) {

		$defaults = [
			'post_types'       => [ 'part', 'assembly', 'product' ],
			'meta_keys'        => [ 'key' ],
			'meta_values'      => [ 'value' ],
			'posts_per_page'   => - 1,
			'post_status'      => 'publish',
			'suppress_filters' => true,

		];

		// Parse incoming $args into an array and merge it with $defaults
		$args               = wp_parse_args( $query_args, $defaults );
		$key                = 'wc_bom_postdata';
		$this->cache_keys[] = $key;

		$this->post_types = (array) $args['post_types'];

		foreach ( $this->post_types as $post_type ) {
			$post_args = [
				'post_type'        => $post_type,
				'posts_per_page'   => $args['posts_per_page'],
				'post_status'      => $args['post_status'],
				'suppress_filters' => $args['suppress_filters'],
			];

			$this->post_data[] = get_posts( $post_args );
		}


		var_dump( $this->post_data );

		wp_cache_set( $key, $this->post_data );

		return $this->post_data;
	}


	public function get_single_assembly( $assembly_ID ) {


		$id       = get_field( 'assembly_no', $assembly_ID );
		$sku      = get_field( 'assembly_sku', $assembly_ID );
		$sub      = 'sub_assemblies';
		$sub_objs = [];
		$objs     = [];

		if ( have_rows( 'sub_assemblies' ) ):

			while ( have_rows( 'sub_assemblies' ) ) : the_row();

				// Your loop code
				$assembly_objs = get_sub_field( 'assembly' );
				$qty           = get_sub_field( 'qty' );

				$objs = [ $assembly_objs, $qty ];

				$sub_objs[] = $objs;
			endwhile;
			//else :
		endif;

		$objs = [ $id, $sku, $sub_objs ];

		return $objs;

	}

	public function get_single_part( $part_ID ) {

		$part_data = [];

		$part_no   = get_field( 'part_no', $part_ID );
		$part_name = get_field( 'part_name', $part_ID );
		$part_cost = get_field( 'part_cost', $part_ID );


		$part_data = [ $part_no, $part_name, $part_cost ];

		return $part_data;

	}
}