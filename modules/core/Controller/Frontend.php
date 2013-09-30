<?php namespace ibidem\demos\acctg\core;

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
		return $this->perform_action('push');
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_add_taccount()
	{
		return $this->perform_action('tree_push');
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_move_taccount()
	{
		return $this->perform_action('tree_move');
	}

	// ------------------------------------------------------------------------
	// Helpers

	/**
	 * @param \mjolnir\types\Renderable
	 */
	protected function perform_action($process, $handler = null)
	{
		$errors = [];

		if ($this->is_input_request())
		{
			$handler !== null or $handler = '\app\AcctgTAccountLib';
			$input_errors = $handler::$process($_POST);
			
			if ($input_errors === null)
			{
				\app\Server::redirect($this->action(null));
			}
			else # got errors
			{
				$action = $this->actionkey();
				$errors = [$action => $input_errors];
			}
		}

		return $this->public_index()
			->pass('errors', $errors);
	}

	/**
	 * @return boolean
	 */
	function is_input_request()
	{
		return \app\Server::request_method() == 'POST';
	}

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
