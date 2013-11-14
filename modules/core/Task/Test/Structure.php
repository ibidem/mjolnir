<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Task
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Task_Test_Structure extends \app\Task_Base
{
	/**
	 * ...
	 */
	function run()
	{
		\app\Task::consolewriter($this->writer);

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
