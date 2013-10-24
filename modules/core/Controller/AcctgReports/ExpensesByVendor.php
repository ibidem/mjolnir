<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgReports_ExpensesByVendor extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg reports expenses by vendor'];

	/**
	 * @return string base route url
	 */
	function baseroute()
	{
		return 'acctg-reports.public';
	}

	// ------------------------------------------------------------------------
	// Context

	/**
	 * @return \mjolnir\accounting\AcctgReportInterface
	 */
	function acctgreport_expensebyvendor($options, $group = null)
	{
		return \app\AcctgReport_ExpenseByVendor::instance($options, $group);
	}

} # class
