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
			->pass('context', $this)
			->pass('errors', []);
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_bruteforce_taccount()
	{
		$action = $this->actionkey();
		$errors = [];

		if (\app\Server::request_method() == 'POST')
		{
			$input_errors = \app\AcctgTAccountLib::push($_POST);
			$input_errors === null or $errors = [$action => $input_errors];
		}

		return $this->public_index()
			->pass('errors', $errors);
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_add_taccount()
	{
		$action = $this->actionkey();
		$errors = [];

		if (\app\Server::request_method() == 'POST')
		{
			$input_errors = \app\AcctgTAccountLib::tree_push($_POST);
			$input_errors === null or $errors = [$action => $input_errors];
		}

		return $this->public_index()
			->pass('errors', $errors);
	}

	// ------------------------------------------------------------------------
	// Helpers

	/**
	 * @return string
	 */
	function actionkey()
	{
		return $this->channel()->get('relaynode')->get('action', 'index');
	}

	// ------------------------------------------------------------------------
	// Context

	/**
	 * @return string action url
	 */
	function action($action)
	{
		return \app\URL::href('frontend.public', ['action' => $action]);
	}

} # class
