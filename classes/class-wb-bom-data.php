<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

namespace WooBom;

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2/24/17
 * Time: 6:43 PM
 *
 * @property  data
 */
/**
 * Class WC_Bom_Database
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Database
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Data
 *
 * @package WooBom
 */
class WC_Bom_Data {

	public function jal_install() {

		global $wpdb;
		global $jal_db_version;

		$table_name = $wpdb->prefix . 'liveshoutbox';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = 'CREATE TABLE $table_name (
		id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
		time DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL,
		name TINYTEXT NOT NULL,
		text TEXT NOT NULL,
		url VARCHAR(55) DEFAULT \'\' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'jal_db_version', $jal_db_version );
	}


	public function jal_install_data() {

		global $wpdb;

		$welcome_name = 'Mr. WordPress';
		$welcome_text = 'Congratulations, you just completed the installation!';

		$table_name = $wpdb->prefix . 'liveshoutbox';

		$wpdb->insert(
			$table_name,
			[
				'time' => current_time( 'mysql' ),
				'name' => $welcome_name,
				'text' => $welcome_text,
			]
		);
	}
}
