<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Library
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
trait Trait_Controller_IbidemDemosAcctgCollection
{
	use Trait_Controller_IbidemDemosAcctgCommon;

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_index()
	{
		return \app\ThemeView::fortarget
			(
				static::dashplural().'.'.$this->actionkey(),
				$this->theme()
			)
			->pass('lang', $this->lang())
			->pass('control', $this)
			->pass('context', $this)
			->pass('errors', []);
	}

	// Context
	// ------------------------------------------------------------------------

	/**
	 * @return string action url
	 */
	function action($action)
	{
		return \app\URL::href
			(
				static::dashplural().'.public',
				[
					'action' => $action,
				]
			);
	}

	/**
	 * @return string action url
	 */
	function can($action)
	{
		return \app\Access::can
			(
				static::dashplural().'.public',
				[
					'action' => $action,
				]
			);
	}

} # trait
