<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Library
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
trait Trait_Controller_IbidemDemosAcctgCommon
{

	// Context
	// ------------------------------------------------------------------------

	/**
	 * @return array of links
	 */
	function navlinks()
	{
		$all_links = array
			(
				'acctg-taccounts.public' => 'Accounts',
				'acctg-journals.public' => 'Journals'
			);

		$allowed_links = [];

		foreach ($all_links as $route => $title)
		{
			if (\app\Access::can($route))
			{
				$allowed_links[$route] = array
					(
						'url' => \app\URL::href($route),
						'title' => $title,
						'state' => 'inactive'
					);
			}
		}

		$thisroute = static::dashsingular().'.public';
		if (isset($allowed_links[$thisroute]))
		{
			$allowed_links[$thisroute]['state'] = 'active';
		}

		return $allowed_links;
	}

	/**
	 * @return array of link
	 */
	function pageactions()
	{
		$allowed_actions = [];

		if (isset(static::$actions))
		{
			foreach (static::$actions as $actiontitle => $action)
			{
				if ($this->can($action))
				{
					$allowed_actions[$action] = array
						(
							'state' => 'inactive',
							'title' => $actiontitle,
							'url' => $this->action($action)
						);
				}
			}
		}

		return $allowed_actions;
	}


	// Helpers
	// ------------------------------------------------------------------------

	/**
	 * @return \mjolnir\types\Renderable
	 */
	protected function perform_action($process, $handler = null)
	{
		$errors = [];

		if ($this->is_input_request())
		{
			$handler !== null or $handler = static::$handler;
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

} # trait
