<?php namespace ibidem\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_Frontend extends \app\Controller_Base
{
	use \app\Trait_AcctgContext;

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_index()
	{
		return \app\ThemeView::fortarget('frontend')
			->pass('control', $this)
			->pass('context', $this);
	}

	/**
	 * @return string action url
	 */
	function action($action)
	{
		return \app\URL::href('frontend.public', ['action' => $action]);
	}

} # class
