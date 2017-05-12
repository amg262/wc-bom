<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/12/17
 * Time: 2:02 AM
 */

namespace WooBom;


use function fclose;
use function file_exists;
use function file_get_contents;
use function tmpfile;

class WC_Bom_Logger {

	private $file, $filedata, $log, $path;
	private $filename, $filepath, $filedir, $output, $unzipped;


	public function __construct() {
		add_action( 'admin_init', [ $this, 'init' ] );


	}

	public function init() {
		//$this->logger_write();
		$this->write_file( date('mdy').'_wcbom.log', " SSSBOOBS" );
	}

	/**
	 * @param $filename
	 * @param $data
	 *
	 * @return bool|int|void
	 */
	public function write_file( $filename, $data, $overwrite = false ) {

		$this->filename = $filename;
		$this->filedir  = WC_BOM_LOGS;
		$this->filepath = WC_BOM_LOGS . $filename;
		$this->filedata = $data;
		$flag           = 'a+';

		if ( $overwrite === true || ! ( ! file_exists( $this->filepath ) ) ) {
			$flag = 'w+';
		}

		$t = tmpfile();

		$this->file = fopen( $this->filepath, $flag );
		//fseek($f, SEEK_END);
		fwrite( $this->file, $this->filedata );
		fclose( $this->file );
	}

	public function return_file( $filename, $array = false ) {

		$this->filename = $filename;
		$this->filedir  = WC_BOM_LOGS;
		$this->filepath = WC_BOM_LOGS . $filename;


		if ( $array === true ) {
			$this->output = file_get_contents( $this->filepath );

		} else {
			$this->output = file( $this->filepath,
				FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
		}

		return $this->output;
	}

	public function get_filepath() {
		return $this->filepath;
	}

	public function get_filename() {
		return $this->filename;
	}

	public function get_filedata() {
		return $this->filedata;
	}

	public function get_file() {
		return $this->file;
	}

	public function get_output() {
		return $this->output;
	}

	public function scramble( $data ) {
		return base64_encode( str_rot13( base64_encode( $data ) ) );
	}

	public function unscramble( $data ) {
		return base64_decode( str_rot13( base64_decode( $data ) ) );
	}

	public function crunch( $data ) {
		return gzdeflate( base64_encode( str_rot13( $data ) ) );
	}

	public function uncrunch( $data ) {
		return str_rot13( base64_decode( gzinflate( $data ) ) );
	}
}

$log = new WC_Bom_Logger();

