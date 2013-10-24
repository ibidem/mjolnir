<?php namespace ibidem\demos\acctg\api\v1;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_V1AcctgProcedures_Checks extends \app\Controller_Base_V1Api
{
	/**
	 * @return array
	 */
	function post($req)
	{
		$validator = \app\CheckLib::integrity_validator($req);

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
						'method' => \app\CheckLib::transaction_method(),
						'journal' => \app\CheckLib::journal(),
						'description' => 'Automatic transaction for check records.',
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
			$operations_array = \app\CheckLib::to_operations($req);

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

			\app\CheckLib::push
				(
					[
						'transaction' => $transaction['id'],
						'orderof' => $req['orderof']
					]
				);

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
