<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgSettings extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg setting'];

	/**
	 * @return string
	 */
	function viewtarget()
	{
		return static::dashplural();
	}

	function public_save()
	{
		$view = $this->public_index();
		$errors = [];

		if ($this->is_input_request())
		{
			$input = array
				(
					'invoice:recievables.acct' => $_POST['invoice_recievables'],
					'invoice:liabilities.acct' => $_POST['invoice_liabilities']
				);

			// @todo proper validation for settings

			$validator = \app\Validator::instance($input)
				->rule('invoice:recievables.acct', 'not_empty')
				->rule('invoice:liabilities.acct', 'not_empty');

			$input_errors = $validator->errors();

			if ($input_errors === null)
			{
				foreach ($input as $key => $taccount)
				{
					$setting_id = \app\AcctgSettingsLib::find_entry(['slugid' => $key])['id'];

					\app\AcctgSettingsLib::update
						(
							$setting_id,
							[
								'taccount' => $taccount
							]
						);
				}

				\app\Server::redirect($this->action(null));
			}
			else # got errors
			{

				$action = $this->actionkey();
				$errors = [$action => $input_errors];
			}
		}

		return $view->pass('errors', $errors);
	}

	// ------------------------------------------------------------------------
	// Context helpers

	/**
	 * @return array
	 */
	function options_current_assets()
	{
		return $this->acctgtaccounts_options_hierarchy
			(
				[ $this->acctgtype('current-assets') ],
				[],
				null, # default indenter
				null, # default accounts label
				false # disable blank
			);
	}

	/**
	 * @return array
	 */
	function options_revenue()
	{
		return $this->acctgtaccounts_options_hierarchy
			(
				[ $this->acctgtype('revenue') ],
				[],
				null, # default indenter
				null, # default accounts label
				false # disable blank
			);
	}

	/**
	 * @return int taccount
	 */
	function invoice_recievables_account()
	{
		return \app\InvoiceLib::recievables_account();
	}

	/**
	 * @return int taccount
	 */
	function invoice_revenue_account()
	{
		return \app\InvoiceLib::revenue_account();
	}

	// ------------------------------------------------------------------------
	// Control helpers

	/**
	 * @return string url
	 */
	function action($action)
	{
		return \app\URL::href
			(
				'acctg-settings.public',
				[
					'action' => $action
				]
			);
	}

} # class
