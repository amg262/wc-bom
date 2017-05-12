<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/12/17
 * Time: 2:02 AM
 */

namespace WooBom;


use function fclose;
use const FILE_APPEND;
use function file_exists;
use function file_get_contents;
use function fseek;
use const SEEK_CUR;
use function trailingslashit;

class WC_Bom_Logger {

	private $file, $data, $log, $path;
	private $filename, $filepath, $filedir, $unzipped;


	public function __construct() {
		add_action( 'admin_init', [ $this, 'init' ] );


	}

	public function init() {
		//$this->logger_write();
		$this->save_file( 'wcbom.txt', " SSSBOOBS"  );
	}

	/**
	 * @param $filename
	 * @param $data
	 *
	 * @return bool|int|void
	 */
	public function save_file( $filename, $data ) {

		$this->filename = $filename;
		$this->filedir  = WC_BOM_LOGS;
		$flags          = [ FILE_APPEND ];

		$this->filepath = trailingslashit( $this->filedir ) . $this->filename;
		$n              = '/n';


		$f = fopen(WC_BOM_LOGS.$filename, 'a+');
		//fseek($f, SEEK_END);
		fwrite($f, '/n');
		fwrite($f, $data);
		fclose($f);

	}

	public function get_file( $filename ) {
		$this->file = file_get_contents( $filename );

		return $this->file;
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

