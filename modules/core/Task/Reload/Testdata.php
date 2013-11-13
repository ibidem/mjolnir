<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Task
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Task_Reload_Testdata extends \app\Task_Base
{
	/**
	 * ...
	 */
	function run()
	{
		\app\Task::consolewriter($this->writer);

		$taccounts = \app\AcctgTAccountLib::count();

		if ($taccounts != 0)
		{
			$this->writer->printf('error', 'Test data cna only be injected on a fresh database; please run pdx:reset.')->eol();
			exit;
		}

		$taccounts = \app\CFS::config('ibidem/acctg/data/demo.taccounts');

		$typemap = \app\AcctgTAccountTypeLib::typemap();

		foreach ($taccounts as $type => $typetaccounts)
		{
			foreach ($typetaccounts as $key => $taccount)
			{
				if (\is_array($taccount))
				{
					$this->add_taccount($typemap[$type], $key, null, $taccount);
				}
				else # no sub accounts
				{
					$this->add_taccount($typemap[$type], $taccount, null, null, $key);
				}
			}
		}

		$this->writer->writef(' Test TAccounts loaded in.')->eol();

		$inventory = \app\CFS::config('ibidem/acctg/data/demo.inventory');

		foreach ($inventory as $item)
		{
			\app\InventoryLib::push($item);
		}

		$this->writer->writef(' Test Inventory loaded in.')->eol();

		$vendors = \app\CFS::config('ibidem/acctg/data/demo.vendors');

		foreach ($vendors as $vendor)
		{
			\app\VendorLib::push($vendor);
		}

		$this->writer->writef(' Test Vendors loaded in.')->eol();

		$customers = \app\CFS::config('ibidem/acctg/data/demo.customers');

		foreach ($customers as $customer)
		{
			\app\CustomerLib::push($customer);
		}

		$this->writer->writef(' Test Customers loaded in.')->eol();

		$employees = \app\CFS::config('ibidem/acctg/data/demo.employees');

		foreach ($employees as $employee)
		{
			\app\EmployeeLib::push($employee);
		}

		$this->writer->writef(' Test Employees loaded in.')->eol();

		\app\AcctgTAccountLib::install_special_taccounts(null);
		$this->writer->writef(' Special TAccounts added.')->eol();

		// Report Testdata
		// ---------------

		#
		# The following is hardcoded... but for testing purposes it's all the
		# same, hardcoded or not. It should be noted that the transactions are
		# not suppose to make much sense, only the sums per account are
		# significant.
		#

		$data = array
			(
				'2013' => array
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

				'2014' => array
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

		$this->writer->writef(' Cash Flow Statement data added.')->eol();
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

	/**
	 * ...
	 */
	function add_taccount($type, $title, $parent = null, $subaccounts = null, $slugid = null)
	{
		$input = array
			(
				'title' => $title,
				'sign' => +1,
				'type' => $type,
				'parent' => $parent,
				'slugid' => $slugid,
			);

		\app\AcctgTAccountLib::tree_push($input);
		$id = \app\AcctgTAccountLib::last_inserted_id();

		if ( ! empty($subaccounts))
		{
			foreach ($subaccounts as $key => $taccount)
			{
				if (\is_array($taccount))
				{
					$this->add_taccount($type, $key, $id, $taccount);
				}
				else # no sub accounts
				{
					$this->add_taccount($type, $taccount, $id, null);
				}
			}
		}
	}

} # class
