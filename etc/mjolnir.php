<?php namespace app;

	#
	# The following has been condensed to be as short as possible and updatable
	# via the system modules. You may customize it to suit your own needs.
	#

	// define a globally recognized version
	\defined('MJ_APP_VERSION') or \define('MJ_APP_VERSION', '1.0.0');

	// gurantee EXT is defined
	\defined('EXT') or \define('EXT', '.php');

	// set the full path to the docroot
	$syspath = \realpath(__DIR__.'/..').'/'; # used in default.mjolnir
	$cfsfilepath = "{$syspath}vendor/mjolnir/cfs/+App/";

	// fail gracefully when libraries are missing
	if ( ! \file_exists($cfsfilepath))
	{
		// check context for apropriate variables
		if (isset($wwwconfig, $wwwpath))
		{
			if ($wwwconfig['development'])
			{
				echo 'Missing system libraries. '.PHP_EOL;
				echo 'Please install by running "bin/vendor/install" in '
					. '['.$wwwconfig['sys.path'].']';
			}
			else # user error
			{
				include $wwwpath.'503'.EXT;
			}
		}
		else # console or other
		{
			echo 'Missing system libraries. Try bin/vendor/install'.PHP_EOL;
		}

		exit(1);
	}

	// inject defaults
	include $cfsfilepath.'default.mjolnir'.EXT;

	\app\CFS::cache(\app\Stash::instance());
	\mjolnir\log_settings(\app\CFS::config('mjolnir/base')['logging']);

	#
	# See [mjolnir/cfs/+App/bridges] for bridge declaration help
	#

	// cleanup dangling variables
	unset($syspath, $cfsfilepath);
