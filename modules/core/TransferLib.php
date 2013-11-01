<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class TransferLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'acctg_ib__transfers';

	#
	# This class is used for demo-ing procedure integration
	#

	// ------------------------------------------------------------------------
	// Factory interface

	/** @var array fields */
	static $fields = array
		(
			'nums' => array
				(
					'id',
					'group',
					'transaction'
				),
			'strs' => array
				(
					'note',
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
		// @todo proper validation
		return \app\Validator::instance($input);
	}

	/**
	 * ...
	 */
	static function process(array $input)
	{
		// create transaction

		$transactions = \app\AcctgTransactionCollection::instance(\app\SQL::database());

		$transaction = $transactions->post
			(
				[
					'method' => static::transaction_method(),
					'journal' => static::journal(),
					'description' => 'Automatic transaction for transfer records.',
					'date' => $input['date'],
				# sign-off
					'timestamp' => \date('Y-m-d H:i:s'),
					'user' => \app\Auth::id(),
				]
			);

		// create transaction operations

		$operations = \app\AcctgTransactionOperationCollection::instance(\app\SQL::database());

		$operation = $operations->post
			(
				[
					'transaction' => $transaction['id'],
					'type' => +1,
					'taccount' => $input['toaccount'],
					'note' => 'trasfer destination account',
					'amount' => array
						(
							'value' => $input['amount_value'],
							'type' => $input['amount_type'],
						),
				]
			);

		if ($operation === null)
		{
			throw new \Exception('Failed to create acctg transaction operation.');
		}

		$operation = $operations->post
			(
				[
					'transaction' => $transaction['id'],
					'type' => -1,
					'taccount' => $input['fromaccount'],
					'note' => 'trasfer source account',
					'amount' => array
						(
							'value' => $input['amount_value'],
							'type' => $input['amount_type'],
						),
				]
			);

		if ($operation === null)
		{
			throw new \Exception('Failed to create acctg transaction operation.');
		}

		// create transfer

		$fields = static::fieldlist();

		$transfer_input = array
			(
				'transaction' => $transaction['id'],
				'note' => $input['note']
			);

		static::inserter
			(
				$transfer_input,
				$fields['strs'],
				$fields['bools'],
				\array_diff($fields['nums'], ['id'])
			)
			->run();

		static::clear_cache();
	}

	// ------------------------------------------------------------------------
	// Transaction helpers

	/**
	 * @return string transaction method identifier
	 */
	static function transaction_method()
	{
		return 'record-transfer';
	}

	/**
	 * @return int journal id
	 */
	static function journal()
	{
		return \app\AcctgJournalLib::namedjournal('system-ledger');
	}

} # class
