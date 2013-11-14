<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Task
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Task_Test_Cashflow extends \app\Task_Base
{
	/**
	 * ...
	 */
	function run()
	{
		\app\Task::consolewriter($this->writer);

		#
		# The following is hardcoded... but for testing purposes it's all the
		# same, hardcoded or not. It should be noted that the transactions are
		# not suppose to make much sense, only the sums per account are
		# significant.
		#

		$this_year = \date_create()->format('Y');
		$last_year = \date_create()->modify('-1 year')->format('Y');

		$data = array
		(
			$this_year => array
			(
				[
					[ # credit
						'cash' => 30000,
					],
					[ # debit
						'accts-payable' => 30000,
					]
				],
				[
					[ # credit
						'accts-recievables' => 21000,
					],
					[ # debit
						'salaries' => 3000,
						'notes-payable' => 3000,
						'bonds-payable' => 10000,
						'treasury-stock' => 5000,
					]
				],
				[
					[ # credit
						'inventory' => 30000,
					],
					[ # debit
						'treasury-stock' => 30000,
					]
				],
				[
					[ # credit
						'equipment' => 180000,
					],
					[ # debit
						'accts-payable' => 3000,
						'salaries' => 36000,
						'bonds-payable' => 10000,
						'common-stock' => 80000,
						'treasury-stock' => 4000,
						'retained-earnings' => 47000,
					]
				],
				[
					[ # credit
						'building-depreciation' => -36000,
					],
					[ # debit
						'salaries' => -36000,
					]
				]
			),

			$last_year => array
			(
				[
					[ # credit
						'cash' => 4000,
					],
					[ # debit
						'salaries' => 2000,
						'notes-payable' => 2000,
					]
				],
				[
					[ # credit
						'accts-recievables' => 10000,
					],
					[ # debit
						'accts-payable' => 10000,
					]
				],
				[
					[ # credit
						'inventory' => 36000,
					],
					[ # debit
						'accts-payable' => 20000,
						'notes-payable' => 1000,
						'treasury-stock' => 15000,
					]
				],
				[
					[ # credit
						'equipment' => 150000,
					],
					[ # debit
						'accts-payable' => 10000,
						'bonds-payable' => 60000,
						'common-stock' => 50000,
						'retained-earnings' => 30000,
					]
				],
				[
					[ # credit
						'building-depreciation' => -30000,
					],
					[ # debit
						'salaries' => -30000,
					]
				],
				[
					[ # credit
						'land' => 30000,
					],
					[ # debit
						'salaries' => 30000,
					]
				]
			),
		);

		foreach ($data as $year => $transactions)
		{
			foreach ($transactions as $transaction)
			{
				$this->make_transaction("$year-05-05", $transaction[0], $transaction[1]);
			}
		}

		$this->writer->writef(' Cash Flow Statement test data loaded in.')->eol();
	}

	/**
	 * ...
	 */
	function make_transaction($date, $credits, $debits)
	{
		$acct = \app\AcctgTAccountLib::namedacctsmap();

		$transactions = \app\AcctgTransactionCollection::instance();
		$operations = \app\AcctgTransactionOperationCollection::instance();

		$transaction = $transactions->post
			(
				[
					'timestamp' => \date('Y-m-d'),
					'date' => $date,
					'method' => 'manual',
					'description' => 'Cash Flow Test Case',
					'journal' => \app\AcctgJournalLib::namedjournal('system-ledger')
				]
			);

		foreach ($credits as $taccount => $val)
		{
			$operations->post
				(
					[
						'transaction' => $transaction['id'],
						'type' => +1,
						'taccount' => $acct[$taccount],
						'amount' => array
						(
							'value' => $val,
							'type' => 'USD',
						),
						'note' => 'example'
					]
				);
		}

		foreach ($debits as $taccount => $val)
		{
			$operations->post
				(
					[
						'transaction' => $transaction['id'],
						'type' => -1,
						'taccount' => $acct[$taccount],
						'amount' => array
						(
							'value' => $val,
							'type' => 'USD',
						),
						'note' => 'example'
					]
				);
		}
	}

} # class
