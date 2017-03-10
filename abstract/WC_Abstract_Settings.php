<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 3/9/2017
 * Time: 8:33 PM
 */
namespace WooBom;

/**
 * Class WC_Bom_Settings
 *
 * @package WooBom
 */
interface WC_Abstract_Settings {

	/**
	 *W
	 *
	 * /**
	 * Add options page
	 */
	public function wc_bom_menu();

	/**
	 * Register and add settings
	 */
	public function page_init();

	/**
	 * Print the Section text
	 */
	public function settings_info();

	/**
	 * Options page callback
	 */
	public function settings_page();
}