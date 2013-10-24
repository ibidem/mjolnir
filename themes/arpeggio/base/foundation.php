<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */
?>

<style type="text/css">
	body {
		min-height: 1000px;
		padding-top: 70px;
	}
</style>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle"
					data-toggle="collapse"
					data-target=".navbar-collapse">

				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>

			</button>
			<a class="navbar-brand" href="<?= \app\Server::url_homepage() ?>">
				Demo
			</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<? foreach ($context->navlinks() as $link): ?>
					<li class="<?= $link['state'] ?>">
						<a href="<?= $link['url'] ?>">
							<?= $link['title'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<? foreach ($context->pageactions() as $action): ?>
					<li class="<?= $action['state'] ?>">
						<a href="<?= $action['url'] ?>">
							<?= $action['title'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>


<div class="container">

	<?= $entrypoint
		->pass('h', null)
		->render() ?>

</div> <!-- /container -->
