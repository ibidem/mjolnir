<?php namespace app;

	\defined('EXT') or \define('EXT', '.php');

	// load the configuration
	$wwwconfig = include 'config.php';

	# Hard Routing
	# -------------------------------------------------------------------------

	// Hard routing is designed for nginx and other servers with hard to use
	// rewrite rules. As long as hard-routing is on, passing the request to
	// this index.php will cause Mjolnir to perform the rewrites itself; edit
	// the following if you need to add more rewrites
	if ($wwwconfig['hard-routing'])
	{
		$parts = null;
		if (\preg_match("#^{$wwwconfig['path']}media(?P<uri>/.+)$#", $_SERVER['REQUEST_URI'], $parts))
		{
			require 'media/index.php';
			exit;
		}
		else if (\preg_match("#^{$wwwconfig['path']}thumbs/(?P<width>[0-9]+)/(?P<height>[0-9]+)/(?P<path>.+)$#", $_SERVER['REQUEST_URI'], $parts))
		{
			$_SERVER['REQUEST_URI'] = "{$wwwconfig['path']}thumbs/timthumb.php";
			$_GET = [ 'h' => $parts['height'], 'w' => $parts['width'], 'src' => $parts['path'] ];
			require 'thumbs/timthumb.php';
			exit;
		}
	}

	# Handle Request
	# -------------------------------------------------------------------------

	// this variable acts as a global and is passed down to help initialized
	$wwwpath = \realpath(__DIR__).'/';

	// require core files; the include is intentional since we're passing,
	// wwwconfig and wwwpath to the underlying code
	include $wwwconfig['sys.path'].'etc/mjolnir'.EXT;

	// set environment path
	Env::ensure('www.path', $wwwpath);

	// run as a web http based application
	Mjolnir::www($wwwconfig, $wwwpath);
