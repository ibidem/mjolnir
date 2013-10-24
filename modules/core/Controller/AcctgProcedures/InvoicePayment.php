<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgProcedures_InvoicePayment extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg procedures invoice payment'];

	/** @var string */
	protected static $handler = '\app\InvoicePaymentLib';

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_record()
	{
		return $this->perform_action('reference_push');
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
				'acctg-procedures--invoice-payment.public',
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

	// ------------------------------------------------------------------------
	// Context helpers

	/**
	 * @return array
	 */
	function invoices($group = null)
	{
		$invoices = \app\InvoiceLib::entries
			(
				null, null, 0,
				null,
				[
					'group' => $group
				]
			);

		$options = [];

		foreach ($invoices as $invoice)
		{
			$options[$invoice['id']] = \sprintf('%010s - %s', $invoice['id'], $invoice['description']) ;
		}

		return $options;
	}

} # class
