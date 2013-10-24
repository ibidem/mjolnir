<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgReports_BalanceSheet extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg reports balance sheet'];

	/**
	 * @return string base route url
	 */
	function baseroute()
	{
		return 'acctg-reports.public';
	}

	// ------------------------------------------------------------------------
	// Control helpers

	/**
	 * @return string
	 */
	function action($action)
	{
		return \app\URL::href
			(
				'acctg-reports--balance-sheet.public',
				[
					'action' => $action
				]
			);
	}

} # class
