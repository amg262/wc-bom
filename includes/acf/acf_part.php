<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 9/25/18
 * Time: 4:16 PM
 */
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_58be21633a48e',
		'title' => 'Part',
		'fields' => array (
			array (
				'key' => 'field_58be224180f49',
				'label' => 'Part No.',
				'name' => 'part_no',
				'type' => 'text',
				'instructions' => 'Unique identifier of part',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'STEEL-9032',
				'placeholder' => 'STEEL-9032',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5ae4d247994c8',
				'label' => 'SKU',
				'name' => 'sku',
				'type' => 'text',
				'instructions' => 'Unique identifier of part',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'ST9',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_58be26e874984',
				'label' => 'Cost',
				'name' => 'cost',
				'type' => 'number',
				'instructions' => 'Unit price of part',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '1.00',
				'placeholder' => '',
				'prepend' => '$',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_58be25d7bc42b',
				'label' => 'Weight',
				'name' => 'weight',
				'type' => 'number',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '1.5',
				'placeholder' => '',
				'prepend' => '',
				'append' => 'lbs',
				'min' => '',
				'max' => '',
				'step' => '.5',
			),
			array (
				'key' => 'field_5ae7bba2657f8',
				'label' => 'Stock',
				'name' => 'stock',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 10,
				'placeholder' => '',
				'prepend' => '',
				'append' => 'units',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_5af1f8533f9bc',
				'label' => 'Vendor',
				'name' => 'vendor',
				'type' => 'taxonomy',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'vendor',
				'field_type' => 'select',
				'allow_null' => 1,
				'add_term' => 1,
				'save_terms' => 1,
				'load_terms' => 1,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array (
				'key' => 'field_5af1f875a3e69',
				'label' => 'Category',
				'name' => 'category',
				'type' => 'taxonomy',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'product_cat',
				'field_type' => 'checkbox',
				'allow_null' => 1,
				'add_term' => 1,
				'save_terms' => 1,
				'load_terms' => 1,
				'return_format' => 'id',
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'part',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => 'Part object used in process of manufacturing assemblies or products.',
	));

endif;