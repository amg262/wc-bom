<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;


use function get_posts;

class WC_Bom_Calculate {

	/**
	 * @var null
	 */

	private $post_type, $meta_args, $posts_objs;

	public function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {

	}


	public function show() {

		//$p = $this->get_parts();
		//var_dump( $p );
	}


	public function get_post_objs( $post_type, $meta_args ) {


		$type            = (string) $post_type;
		$this->meta_args = $meta_args

		$args = [
			'post_type'      => $type,
			'posts_per_page' => - 1,
			/*'meta_key'         => '',
			'meta_value'       => '',
			'author'           => '',
			'author_name'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'date',
			'order'            => 'DESC',*/
		];

		$this->posts_objs = get_posts( $args );


		return $this->posts_objs;
		//var_dump( $parts );
		//wp_cache_set( 'wc_bom_parts', $parts );


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

	public function get_single_par( $part_ID ) {

		$part_data = [];

		$part_no   = get_field( 'part_no', $part_ID );
		$part_name = get_field( 'part_name', $part_ID );
		$part_cost = get_field( 'part_cost', $part_ID );


		$part_data = [ $part_no, $part_name, $part_cost ];

		return $part_data;

	}
}