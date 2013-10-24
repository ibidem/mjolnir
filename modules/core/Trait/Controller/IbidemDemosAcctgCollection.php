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
	 * @return string
	 */
	function viewtarget()
	{
		return static::dashplural();
	}

	// ------------------------------------------------------------------------
	// Context

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
