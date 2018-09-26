<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 9/25/18
 * Time: 4:16 PM
 */
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_590779985a45c',
		'title' => 'Product',
		'fields' => array (
			array (
				'key' => 'field_5ae4d314160cc',
				'label' => 'Product Assembly',
				'name' => 'product_assembly',
				'type' => 'repeater',
				'instructions' => 'Parts, Assemblies used in creation of this product.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => 'field_5ae4d348160cd',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Add Item',
				'sub_fields' => array (
					array (
						'key' => 'field_5baaa26dfa0d1',
						'label' => 'Part or Assembly',
						'name' => 'part_or_assembly',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'Part' => 'Part',
							'Assembly' => 'Assembly',
						),
						'default_value' => array (
							0 => 'Part',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 1,
						'ajax' => 1,
						'return_format' => 'value',
						'placeholder' => '',
					),
					array (
						'key' => 'field_5ae4d366160ce',
						'label' => 'Quantity',
						'name' => 'quantity',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '20',
							'class' => '',
							'id' => '',
						),
						'default_value' => 1,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'units',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_5ae4d348160cd',
						'label' => 'Item',
						'name' => 'item',
						'type' => 'post_object',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '80',
							'class' => '',
							'id' => '',
						),
						'post_type' => array (
							0 => 'part',
							1 => 'assembly',
						),
						'taxonomy' => array (
						),
						'allow_null' => 0,
						'multiple' => 0,
						'return_format' => 'object',
						'ui' => 1,
					),
				),
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => 'List of parts, assemblies and their quantities to create products.',
	));

endif;