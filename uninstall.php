<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/1/17
 * Time: 11:39 AM
 */

function delete_posts( $post_type ) {

	$args = [
		'post_type' = $post_type,
		'posts_per_page' = - 1,
	];

	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		wp_delete_post( $post->id, true );
	}

}


function delete_terms( $taxonomy ) {

	$args = [
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
	];

	$terms = get_terrms( $args );

	foreach ( $terms as $term ) {
		wp_delete_term($term->id, $taxonomy);
	}

}