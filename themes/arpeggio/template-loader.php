<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$scriptsconfig = include '+scripts/+scripts'.EXT;

	if ( ! isset($extratemplates))
	{
		$extratemplates = [];
	}

	if ( ! isset($templatetarget))
	{
		$templatetarget = $control->viewtarget().'.'.$context->actionkey();
	}

	#
	# The following detects which templates needs to be loaded based on the
	# current script configuration. Single page app assumed; all targets are
	# loaded.
	#

    $templates = $extratemplates;

	foreach ($scriptsconfig['targeted-mapping'] as $target => $scripts)
	{
		if ($templatetarget !== null && $target !== $templatetarget)
		{
			continue;
		}
		
		// resolve any alias mapping
		while (\is_string($scripts))
		{
			$scripts = $scriptsconfig['targeted-mapping'][$scripts];
		}

		foreach ($scripts as $key => $script)
		{
			if (\is_string($key))
			{
				if (\preg_match('/app-([A-Z].+)/', $key, $matches))
				{
					$templates[$matches[1]] = 'templates/modules/'.\str_replace('-', '/', $matches[1]);
				}
				else if (\preg_match('/app-(.+)/', $key, $matches))
				{
					$templates[$matches[1]] = 'templates/'.\str_replace('-', '/', $matches[1]);
				}
				else # extention
				{
					$templates[$key] = 'templates/extentions/'.\str_replace('-', '/', $key);
				}
			}
		}
	}
?>

<? foreach ($templates as $template => $path): ?>
	<script type="text/x-underscore-template" id="<?= $template ?>-template">
		<?= $theme->partial($path)->render() ?>
	</script>
<? endforeach; ?>
