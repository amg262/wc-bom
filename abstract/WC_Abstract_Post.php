<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 3/9/2017
 * Time: 8:08 PM
 */
namespace WooBom;

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 3/6/17
 * Time: 8:03 PM
 */
/**
 * Interface WC_Bom_Abstract_Post
 *
 * @package WooBom
 */
interface WC_Bom_Abstract_Post {

	/**
	 *
	 */
	public function init();

	/**
	 *
	 */
	public function register_post();

	/**
	 *
	 */
	public function register_taxonomy();

	/**
	 *
	 */
	public function register_assembly();

	/**
	 *
	 */
	public function register_assembly_cat();

	/**
	 *
	 */
	public function register_part();

	/**
	 *
	 */
	public function register_part_cat();

	/**
	 *
	 */
	public function register_procurement_type();

	/**
	 *
	 */
	public function register_vendor();

	/**
	 *
	 */
	public function register_location();

	/**
	 *
	 */
	public function register_phase();

	/**
	 *
	 */
	public function register_material_tags();

	/**
	 *
	 */
	public function register_inventory();

	/**
	 *
	 */
	public function register_inventory_cat();

	/**
	 *
	 */
	public function register_ecn();
}