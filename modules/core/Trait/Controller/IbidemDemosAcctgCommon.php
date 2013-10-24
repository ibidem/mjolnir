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
	/**
	 * @return string
	 */
	function viewtarget()
	{
		return static::dashsingular();
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_index()
	{
		return \app\ThemeView::fortarget
			(
				static::viewtarget().'.'.$this->actionkey(),
				$this->theme()
			)
			->pass('lang', $this->lang())
			->pass('control', $this)
			->pass('context', $this)
			->pass('errors', []);
	}

	// ------------------------------------------------------------------------
	// Context

	/**
	 * @return array
	 */
	function user($user_id)
	{
		return \app\Model_User::entry($user_id);
	}

	/**
	 * @return array system procedures (recording checks, deposits, etc)
	 */
	function procedures()
	{
		$procedures = \app\CFS::config('ibidem/acctg/procedures');

		$allowed_procedures = [];

		foreach ($procedures as $key => $procedure)
		{
			if (\app\Access::can($procedure['relay']))
			{
				$allowed_procedures[$key] = $procedure;
			}
		}

		return $allowed_procedures;
	}

	/**
	 * @return array system procedures (recording checks, deposits, etc)
	 */
	function financial_statements()
	{
		$statements = \app\CFS::config('ibidem/acctg/statements');

		$allowed_statements = [];

		foreach ($statements as $key => $statement)
		{
			if (\app\Access::can($statement['relay']))
			{
				$allowed_statements[$key] = $statement;
			}
		}

		return $allowed_statements;
	}

	/**
	 * @return array system procedures (recording checks, deposits, etc)
	 */
	function analysis_reports()
	{
		$reports = \app\CFS::config('ibidem/acctg/analysis-reports');

		$allowed_reports = [];

		foreach ($reports as $key => $report)
		{
			if (\app\Access::can($report['relay']))
			{
				$allowed_reports[$key] = $report;
			}
		}

		return $allowed_reports;
	}

	/**
	 * @return array
	 */
	function assets()
	{
		$reports = \app\CFS::config('ibidem/assets');

		$allowed_reports = [];

		foreach ($reports as $key => $report)
		{
			if (\app\Access::can($report['relay']))
			{
				$allowed_reports[$key] = $report;
			}
		}

		return $allowed_reports;
	}

	/**
	 * @return array
	 */
	function entities()
	{
		$reports = \app\CFS::config('ibidem/entities');

		$allowed_reports = [];

		foreach ($reports as $key => $report)
		{
			if (\app\Access::can($report['relay']))
			{
				$allowed_reports[$key] = $report;
			}
		}

		return $allowed_reports;
	}

	/**
	 * @return array
	 */
	function inventory()
	{
		return \app\InventoryLib::entries(null, null);
	}

	/**
	 * @return array
	 */
	function customers()
	{
		return \app\CustomerLib::entries(null, null);
	}

	/**
	 * @return array
	 */
	function vendors()
	{
		return \app\VendorLib::entries(null, null);
	}

	/**
	 * @return array
	 */
	function employees()
	{
		return \app\EmployeeLib::entries(null, null);
	}

	/**
	 * @return string base route url
	 */
	function baseroute()
	{
		return static::dashplural().'.public';
	}

	/**
	 * @return array of links
	 */
	function navlinks()
	{
		$all_links = array
			(
				'demo-assets.public' => 'Assets',
				'demo-entities.public' => 'Entities',
				'acctg-taccounts.public' => 'TAccounts',
				'acctg-journals.public' => 'Journals',
				'acctg-procedures.public' => 'Procedures',
				'acctg-reports.public' => 'Reports',
				'transaction-log.public' => 'Transaction Log',
				'acctg-settings.public' => 'Settings',
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

		$thisroute = $this->baseroute();

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

	// Form Helpers
	// ------------------------------------------------------------------------

	/**
	 * @return int
	 */
	function journal_id()
	{
		return (int) $this->entry()['id'];
	}

	/**
	 * @return array
	 */
	function options_customers()
	{
		return \app\CustomerLib::entries(null, null);
	}

	function options_vendors()
	{
		return \app\VendorLib::entries(null, null);
	}

	/**
	 * @return array
	 */
	function options_bankaccounts()
	{
		return $this->acctgtaccounts_options_liefs
			(['entry.type' => $this->acctgtype('bank')]);
	}

	// Control Helpers
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
