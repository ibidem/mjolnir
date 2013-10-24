<?php namespace ibidem\demos\acctg\api\v1;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_V1AcctgProcedures_Invoices extends \app\Controller_Base_V1Api
{
	/**
	 * @return array
	 */
	function post($req)
	{
		$validator = \app\InvoiceLib::integrity_validator($req);

		if ( ! $validator->check())
		{
			throw new \app\Exception_APIError
				(
					'Failed Check Validation',
					[
						'error' => 'Failed validation',
						'validation' => $validator->errors()
					]
				);
		}

		$db = \app\SQLDatabase::instance();
		$db->begin();
		try
		{
			$transactions = \app\AcctgTransactionCollection::instance($db);

			$transaction = $transactions->post
				(
					[
						'method' => \app\InvoiceLib::transaction_method(),
						'journal' => \app\InvoiceLib::journal(),
						'description' => 'Invoice'.( ! empty($req['description']) ? ': '.$req['description'] : ''),
						'date' => $req['date'],
					# sign-off
						'timestamp' => \date('Y-m-d H:i:s'),
						'user' => \app\Auth::id(),
					]
				);

			if ($transaction === null)
			{
				throw new \Exception('Failed to create acctg transaction.');
			}

			$transaction['operations'] = [];

			$operations = \app\AcctgTransactionOperationCollection::instance($db);

			// convert to operations
			$operations_array = \app\InvoiceLib::to_operations($req);

			foreach ($operations_array as $req_op)
			{
				$operation = $operations->post
					(
						[
							'transaction' => $transaction['id'],
							'type' => $req_op['type'],
							'taccount' => $req_op['taccount'],
							'note' => $req_op['note'],
							'amount' => array
								(
									'value' => $req_op['amount_value'],
									'type' => $req_op['amount_type'],
								),
						]
					);

				if ($operation === null)
				{
					throw new \Exception('Failed to create acctg transaction operation.');
				}

				$transaction['operations'][] = $operation;
			}

			\app\InvoiceLib::push
				(
					[
						'transaction' => $transaction['id'],
						'description' => $req['description'],
						'duedate' => $req['duedate'],
					]
				);

			$invoice_id = \app\InvoiceLib::last_inserted_id();

			foreach ($req['expenses'] as $expense)
			{
				$expense['invoice'] = $invoice_id;
				\app\InvoiceExpenseLib::push($expense);
			}

			foreach ($req['payments'] as $payment)
			{
				// Create Payment Transaction
				// --------------------------

				$transactions = \app\AcctgTransactionCollection::instance($db);

				$transaction = $transactions->post
					(
						[
							'method' => \app\InvoiceLib::transaction_method(),
							'journal' => \app\InvoiceLib::journal(),
							'description' => 'Invoice #'.$invoice_id.' Payment'.( ! empty($payment['note']) ? ': '.$payment['note'] : ''),
							'date' => $req['date'],
						# sign-off
							'timestamp' => \date('Y-m-d H:i:s'),
							'user' => \app\Auth::id(),
						]
					);

				$operations = \app\AcctgTransactionOperationCollection::instance($db);

				$operations_array = \app\InvoicePaymentLib::to_operations($payment);

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
							'invoice' => $invoice_id,
							'transaction' => $transaction['id']
						);

					$errors = \app\InvoicePaymentLib::push($payment_entry);

					if ($errors !== null)
					{
						throw new \Exception('Failed to create acctg invoice payment.');
					}
				}
			}

			$db->commit();
		}
		catch (\Exception $e)
		{
			$db->rollback();
			throw $e;
		}

		return $transaction;
	}

} # class
