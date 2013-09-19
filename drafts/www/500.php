<? \header('HTTP/1.1 500 Internal Server Error'); ?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>500 // Server Error</title>
		
		<?
			// get domain info
			$config = include __DIR__.'/config.php';
			$base_url = '//'.$config['domain'].$config['path'];
		?>

		<link rel="shortcut icon" href="<?= $base_url ?>favicon.ico" type="image/x-icon">
		
<style>
	#page {
		background: #fff; color: #222;
		border-radius: 5px;
		font-family: Georgia, cursive;
		padding: 20px;
		margin: 0 auto;
		box-shadow: #000000 2px 3px 10px;
		width: 700px;
	}

	h1 {
		font-size: 350%;
		color: #999;
		margin-top: 0;
		float: left;
		height: 90px;
		width: 200px;
		text-align: center;
		padding-top: 30px;
		padding-bottom: 10px;
		border-right: 1px dashed #999;
		font-style: italic;
		margin-right: 50px;
	}

	body {
		background: #bbb;
		padding-top: 150px;
	}
</style>

	</head>

	<body>

		<div id="page">
			<h1>500</h1>
			<div>
				<h2>Server Error</h2>
				<p>The server encountered an unexpected error and was unable to handle the request.</p>
				<p><i>We're very sorry. The problem has been logged and will be fix'ed as soon as possible.</i></p>
			</div>
		</div>

	</body>

</html>