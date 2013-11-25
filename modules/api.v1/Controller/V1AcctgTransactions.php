<?php namespace ibidem\demos\acctg\api\v1;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_V1AcctgTransactions extends \app\Controller_Base_V1Api
{
	/**
	 * @return array
	 */
	function post($req)
	{
		$validator = \app\AcctgTransactionLib::integrity_validator($req);

		if ( ! $validator->check())
		{
			throw new \app\Exception_APIError
				(
					'Failed Transaction Validation',
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
			$collection = \app\AcctgTransactionCollection::instance($db);

			$transaction = $collection->post
				(
					[
						'method' => 'manual',
						'journal' => $req['journal'],
						'description' => $req['description'],
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

			$collection = \app\AcctgTransactionOperationCollection::instance($db);

			foreach ($req['operations'] as $req_op)
			{
				$operation = $collection->post
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

			if (($error = \app\AcctgTAccountLib::check_integrity()) !== 0)
			{
				throw new \app\Exception_NotApplicable("System has detected inconsistency with required operation. Error delta of $error");
			}

			$db->commit();
		}
		catch (\app\Exception_NotApplicable $e)
		{
			$db->rollback();
			throw new \app\Exception_APIError($e->getMessage());
		}
		catch (\Exception $e)
		{
			$db->rollback();
			throw $e;
		}

		return $transaction;
	}

} # class
