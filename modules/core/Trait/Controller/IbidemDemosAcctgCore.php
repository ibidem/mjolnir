<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Library
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
trait Trait_Controller_IbidemDemosAcctgCore
{
	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_index()
	{
		return \app\ThemeView::fortarget(static::dashsingular(), $this->theme())
			->pass('lang', $this->lang())
			->pass('control', $this)
			->pass('context', $this)
			->pass('errors', []);
	}

	// Helpers
	// ------------------------------------------------------------------------

	/**
	 * @return boolean
	 */
	function is_input_request()
	{
		return \app\Server::request_method() == 'POST';
	}

	/**
	 * @return mixed
	 */
	function param($key, $default = null)
	{
		return $this->channel()->get('relaynode')->get($key, $default);
	}

	/**
	 * @return string
	 */
	function actionkey()
	{
		return $this->param('action', 'index');
	}

	/**
	 * @return \mjolnir\types\Theme
	 */
	function theme()
	{
		return \app\Theme::instance();
	}

	/**
	 * @return \mjolnir\types\Lang
	 */
	function lang()
	{
		return \app\Lang::instance()
			->addlibrary('ibidem-demos-acctg');
	}

	/**
	 * @return string action url
	 */
	function action($action)
	{
		return \app\URL::href
			(
				static::dashsingular().'.public',
				[
					'action' => $action,
				]
			);
	}

} # trait
