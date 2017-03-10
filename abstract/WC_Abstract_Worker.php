<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 3/9/2017
 * Time: 8:34 PM
 */
namespace WooBom;

/**
 * Class WC_Bom_Worker
 *
 * @package WooBom
 */
/**
 * Interface WC_Abstract_Worker
 *
 * @package WooBom
 */
interface WC_Abstract_Worker {

	/**
	 *
	 */
	public function wco_admin();

	/**
	 *
	 */
	public function wco_ajax();

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 *
	 * @return array
	 */
	public function sanitize( $input );

	/**
	 * Get the settings option array and print one of its values
	 */
	public function settings_callback();
}