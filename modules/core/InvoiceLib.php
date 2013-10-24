<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class InvoiceLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'invoices';

	#
	# This class is used for demo-ing procedure integration
	#

	// ------------------------------------------------------------------------
	// Factory interface

	/** @var array field list */
	protected static $fields = array
		(
			'nums' => array
				(
					'id',
					'group',
				),
			'strs' => array
				(
					'duedate',
					'description'
				),
			'bools' => array
				(
					// empty
				),
		);

	/**
	 * ...
	 */
	static function cleanup(&$input)
	{
		isset($input['group']) or $input['group'] = null;
	}

	/**
	 * @return \mjolnir\types\Validator
	 */
	static function check(array $input, $context = null)
	{
		// @todo CLEANUP proper validation
		return \app\Validator::instance();
	}

	/**
	 * ...
	 */
	static function process(array $input)
	{
		$fields = static::fieldlist();

		static::inserter
			(
				$input,
				$fields['strs'],
				$fields['bools'],
				\array_diff($fields['nums'], ['id'])
			)
			->run();

		static::$last_inserted_id = \app\SQL::last_inserted_id();
		static::clear_cache();
	}

	// ------------------------------------------------------------------------
	// Transaction helpers

	/**
	 * @return \mjolnir\types\Validator
	 */
	static function integrity_validator()
	{
		// @todo proper integrity validation
		return \app\Validator::instance();
	}

	/**
	 * @return string transaction method identifier
	 */
	static function transaction_method()
	{
		return 'record-invoice';
	}

	/**
	 * @return int journal id
	 */
	static function journal()
	{
		return \app\AcctgJournalLib::namedjournal('system-ledger');
	}

	/**
	 * Convert deposit format request, into operations array.
	 *
	 * Essentially the bank account is debitted and all the other accounts are
	 * credited. @todo check use cases for potential debit requirements
	 *
	 * @return array transaction operations
	 */
	static function to_operations($req)
	{
		$operations = [];

		$total = 0.00;

		foreach ($req['expenses'] as $payment)
		{
			$operations[] = array
				(
					'type' => -1,
					'amount_value' => $payment['unit_value'],
					'amount_type' => $payment['unit_type'],
					'taccount' => static::revenue_account(),
					'note' => $payment['note']
				);

			$total += $payment['unit_value'];
		}

		$operations[] = array
			(
				'type' => +1,
				'amount_value' => $total,
				'amount_type' => $payment['unit_type'],
				'taccount' => static::revenue_account(),
				'note' => $req['description']
			);

		return $operations;
	}

	/**
	 * @return int recievables account used by invoices
	 */
	static function recievables_account()
	{
		return \app\AcctgSettings::instance()
			->acct('invoice:recievables.acct', 'current-assets');
	}

	/**
	 * @return int liabilities account used by invoices
	 */
	static function revenue_account()
	{
		return \app\AcctgSettings::instance()
			->acct('invoice:revenue.acct', 'revenue');
	}

} # class
