<?php namespace app;

#
# This script is specifically designed to be used on systems with no ssh access
#

	\defined('EXT') or \define('EXT', '.php');

	// load the configuration
	$wwwconfig = include 'config.php';

	// is system under maintenance
	if ( ! $wwwconfig['maintenance']['enabled'] || $wwwconfig['overlord']['password'] === null)
	{
		include '404'.EXT;
		exit;
	}

	// this variable acts as a global and is passed down to help initialized
	$wwwpath = \realpath(__DIR__.'/../').'/';

	// require core files; the include is intentional since we're passing,
	// wwwconfig and wwwpath to the underlying code
	include $wwwconfig['sys.path'].'etc/mjolnir'.EXT;

	// set environment path
	Env::ensure('www.path', $wwwpath);

	if (isset($_GET['ip']))
	{
		echo ' Your IP address is '.Server::client_ip();
		exit;
	}

	// check if authorized
	$authorized = Session::get('mjolnir:overlord:web-access', false);

	// check if authorized
	if ( ! $authorized && isset($_POST) && isset($_POST['password']))
	{
		if ($_POST['password'] === $wwwconfig['overlord']['password'])
		{
			$authorized = true;
			Session::set('mjolnir:overlord:web-access', true);
		}
	}

	// intentionally independent test of the above for security reasons
	if (Server::client_ip() !== $wwwconfig['overlord']['ip'])
	{
		$authorized = false;
	}
?>
<!DOCTYPE html>
<meta charset="UTF-8"/>
<title>Overlord Console</title>
<link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

<?php

	if ($authorized)
	{
		// autocomplete command
		$cmd = isset($_POST['cmd']) ? $_POST['cmd'] : 'help';

		if (isset($_POST['cmd']))
		{
			\preg_match_all('#[^\s"\']+|"([^"]*)"|\'([^\']*)\'#', \trim($_POST['cmd']), $args);
			$args = array_merge([$cmd], $args[0]);
		}
		else # no command
		{
			$args = ['overlord help', 'help'];
		}
	}

?>

<div class="container">

	<br/>

	<?php if ($authorized): ?>

		<pre>
			<?php 
				// run web based overlord
				Mjolnir::weboverlord($wwwconfig, $wwwpath, $args);
			 ?>
		</pre>

		<hr/>

		<form action="overlord.php" method="POST">
			<div class="form-inline">
				<span style="font-family: monospace;">order&nbsp;</span>

				<input name="cmd" type="text" class="span6" 
				       style="font-family: monospace;" 
				       value="<?php echo \htmlspecialchars($cmd) ?>" 
				       autocomplete="off"/>

				<button class="btn btn-primary">Run</button>
			</div>
		</form>

	<?php else: # not authorized ?>

		<h1>Maintenance</h1>

		<hr/>

		<form action="overlord.php" method="POST">
			<div class="form-inline">
				Password
				<input name="password" type="password"/>
				<button class="btn btn-primary">Access</button>
			</div>
		</form>

	<?php endif; ?>

</div>
