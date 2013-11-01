<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class InvoicePaymentLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'acctg_ib__invoice_payments';

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
					'invoice',
					'transaction',
				),
			'strs' => array
				(
					// empty
				),
			'bools' => array
				(
					// empty
				),
		);

	/**
	 * @return \mjolnir\types\Validator
	 */
	static function check(array $input, $context = null)
	{
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

		static::clear_cache();
	}

	/**
	 * @return array
	 */
	static function reference_push(array $reference_input)
	{
		\app\SQL::begin();

		try
		{
			$db = \app\SQL::database();

			// Create Payment Transaction
			// --------------------------

			$transactions = \app\AcctgTransactionCollection::instance($db);

			$transaction = $transactions->post
				(
					[
						'method' => \app\InvoiceLib::transaction_method(),
						'journal' => \app\InvoiceLib::journal(),
						'description' => 'Invoice #'.$reference_input['invoice'].' Payment'.( ! empty($reference_input['note']) ? ': '.$reference_input['note'] : ''),
						'date' => $reference_input['date'],
					# sign-off
						'timestamp' => \date('Y-m-d H:i:s'),
						'user' => \app\Auth::id(),
					]
				);

			$operations = \app\AcctgTransactionOperationCollection::instance($db);

			$operations_array = static::to_operations($reference_input);

			foreach ($operations_array as $payment_operation)
			{
				$payment_operation['transaction'] = $transaction['id'];

				$operation = $operations->post($payment_operation);

				if ($operation === null)
				{
					throw new \Exception('Failed to create acctg transaction operation.');
				}

				// Create Invoice Payment
				// ----------------------

				$payment_entry = array
					(
						'invoice' => $reference_input['invoice'],
						'transaction' => $transaction['id']
					);

				$errors = \app\InvoicePaymentLib::push($payment_entry);

				if ($errors !== null)
				{
					throw new \Exception('Failed to create acctg invoice payment.');
				}
			}

			// Convert reference input to actual input
			// ---------------------------------------

			$input = array
				(
					'invoice' => $reference_input['invoice'],
					'transaction' => $transaction['id']
				);

			$errors = static::push($input);

			if ($errors !== null)
			{
				\app\SQL::rollback();
				return $errors;
			}
			else # no errors
			{
				\app\SQL::commit();
				return null;
			}
		}
		catch (\Exception $e)
		{
			\app\SQL::rollback();
			throw $e;
		}
	}

	// ------------------------------------------------------------------------
	// Transaction helpers

	/**
	 * @return array request converted to transaction operations
	 */
	static function to_operations($req)
	{
		return array
			(
				[
					'type' => -1,
					'amount' => array
						(
							'value' => $req['amount_value'],
							'type' => $req['amount_type'],
						),
					'taccount' => \app\InvoiceLib::recievables_account(),
					'note' => '',
				],
				[
					'type' => +1,
					'amount' => array
						(
							'value' => $req['amount_value'],
							'type' => $req['amount_type'],
						),
					'taccount' => $req['taccount'],
					'note' => '',
				],
			);
	}

	/**
	 * @return string transaction method identifier
	 */
	static function transaction_method()
	{
		return 'record-invoice-payment';
	}

	/**
	 * @return int journal id
	 */
	static function journal()
	{
		return \app\AcctgJournalLib::namedjournal('system-ledger');
	}

} # class
