<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgProcedures_Transfer extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg procedures transfer'];

	/** @var string */
	protected static $handler = '\app\TransferLib';

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_record()
	{
		return $this->perform_action('push');
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
				'acctg-procedures--transfer.public',
				[
					'action' => $action
				]
			);
	}

	/**
	 * @return string base route url
	 */
	function baseroute()
	{
		return 'acctg-procedures.public';
	}

} # class
