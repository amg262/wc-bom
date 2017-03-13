<?php declare( strict_types = 1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */
namespace WooBom;
/**
 * Class WC_Bom_Data
 *
 * @package WooBom
 */
class WC_Bom_Data {

	/**
	 * @var
	 */
	private $table;

	/**
	 * WC_Bom_Assembly constructor.
	 */
	public function __construct() {

	}

	/**
	 *
	 */
	public function install() {
		global $wpdb;
		global $jal_db_version;

		$table_name = $wpdb->prefix . 'liveshoutbox';

		$charset_collate = $wpdb->get_charset_collate();

		$sql =
			"CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			name tinytext NOT NULL,
			text text NOT NULL,
			url varchar(55) DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 *
	 */
	public function install_data() {
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

$obj = new WC_Bom_Data();