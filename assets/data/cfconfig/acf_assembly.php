<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 9/25/18
 * Time: 4:15 PM
 */
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_58bec9c065391',
		'title' => 'Assembly',
		'fields' => array (
			array (
				'key' => 'field_59077aa89c6ff',
				'label' => 'Assembly ID',
				'name' => 'assembly_id',
				'type' => 'text',
				'instructions' => 'ID number of assembly',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'GBPP-808',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_58bec9fc4dcd4',
				'label' => 'Assembly Items',
				'name' => 'assembly_items',
				'type' => 'repeater',
				'instructions' => 'Enter qty of parts & sub-assemblies used in building this assmelby.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Add Item',
				'sub_fields' => array (
					array (
						'key' => 'field_5baa9f1eee1b3',
						'label' => 'Part or Sub-Assembly',
						'name' => 'part_or_sub_assembly',
						'type' => 'select',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'Part' => 'Part',
							'Sub-Assembly' => 'Sub-Assembly',
						),
						'default_value' => array (
							0 => 'Part',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 1,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
					array (
						'key' => 'field_58beca774dcd6',
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
						'key' => 'field_58beca404dcd5',
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
					'value' => 'assembly',
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
		'description' => 'Collection of components, parts, sub-assemblies to create an assembly used in creation of products.',
	));

endif;