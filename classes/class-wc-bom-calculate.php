<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;


class WC_Bom_Calculate {

	/**
	 * @var null
	 */
	protected static $instance = null;


	private function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {

	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	public function log_stuff() {
		// Logging class initialization
		$log = new Logging();

// set path and name of log file (optional)
		$log->lfile( '/tmp/mylog.txt' );

// write message to the log file
		$log->lwrite( 'Test message1' );
		$log->lwrite( 'Test message2' );
		$log->lwrite( 'Test message3' );

// close log file
		$log->lclose();
	}

}