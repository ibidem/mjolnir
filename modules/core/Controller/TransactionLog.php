<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_TransactionLog extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['transaction log'];

	/**
	 * @return string base route url
	 */
	function baseroute()
	{
		return static::dashsingular().'.public';
	}

} # class
