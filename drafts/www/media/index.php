<?php namespace app;

	\defined('EXT') or \define('EXT', '.php');

	// load the configuration
	$wwwconfig = include '../config.php';

	# Handle Request
	# -------------------------------------------------------------------------

	// this variable acts as a global and is passed down to help initialized
	$wwwpath = \realpath(__DIR__.'/../').'/';

	// require core files; the include is intentional since we're passing,
	// wwwconfig and wwwpath to the underlying code
	include $wwwconfig['sys.path'].'etc/mjolnir'.EXT;

	// set environment path
	Env::ensure('www.path', $wwwpath);

	// run as a web http based application
	Mjolnir::resource($wwwconfig, $wwwpath);
