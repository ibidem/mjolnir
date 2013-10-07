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

		$taccounts = \app\CFS::config('ibidem/acctg/demo.taccounts');

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
					$this->add_taccount($typemap[$type], $taccount, null, null);
				}
			}
		}

		$this->writer->writef(' Test TAccounts loaded in.')->eol();
	}

	/**
	 * ...
	 */
	function add_taccount($type, $title, $parent = null, $subaccounts = null)
	{
		$input = array
			(
				'title' => $title,
				'sign' => +1,
				'type' => $type,
				'parent' => $parent,
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
