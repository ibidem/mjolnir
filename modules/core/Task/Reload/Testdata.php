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
		$taccounts = array
			(
				[
					'title' => 'ING',
					'lft' => 1,
					'rgt' => 10
				],
				[
					'title' => '2x13',
					'lft' => 2,
					'rgt' => 7
				],
				[
					'title' => 'AX',
					'lft' => 3,
					'rgt' => 4
				],
				[
					'title' => 'EX',
					'lft' => 5,
					'rgt' => 6
				],
				[
					'title' => '2x14',
					'lft' => 8,
					'rgt' => 9
				],
				[
					'title' => 'BRD',
					'lft' => 11,
					'rgt' => 12
				],
				[
					'title' => 'Masters',
					'lft' => 13,
					'rgt' => 16
				],
				[
					'title' => 'X1',
					'lft' => 14,
					'rgt' => 15
				],
			);

		$banktype = \app\AcctgTAccountTypeLib::find_entry(['slugid' => 'bank']);

		foreach ($taccounts as $taccount)
		{
			$taccount['sign'] = +1;
			$taccount['type'] = $banktype['id'];
			\app\AcctgTAccountLib::process($taccount);
		}

		$this->writer->writef(' Test TAccounts loaded in.')->eol();
	}

} # class
