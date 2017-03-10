<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 3/9/2017
 * Time: 8:03 PM
 */
namespace WooBom;

/**
 * Class WC_Bom
 *
 * @package WooBom
 */
/**
 * Interface WC_Abstract_Bom
 *
 * @package WooBom
 */
interface WC_Abstract_Bom {

	/**
	 *
	 */
	public function init();

	/**
	 *
	 */
	public function load_plugin_scripts();

	/**
	 *
	 */
	public function load_dist_scripts();

	/**
	 *
	 */
	public function load_vendor_scripts();

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $actions, $plugin_file );

	/**
	 * @return mixed
	 */
	public function create_options();

	/**
	 * @return mixed
	 */
	public function create_settings();

	/**
	 * @return bool
	 */
	public function is_woo_activated();

	/**
	 * @return bool
	 */
	public function is_acf_deactivated();

	/**
	 * @return bool
	 */
	public function is_acf_included();
}