<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class DepositLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'deposits';

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
					'description',
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

	// ------------------------------------------------------------------------
	// Transaction helpers

	/**
	 * @return \mjolnir\types\Validator
	 */
	static function integrity_validator()
	{
		// @todo proper integrity validation
		return \app\Validator::instance();
	}

	/**
	 * @return string transaction method identifier
	 */
	static function transaction_method()
	{
		return 'record-deposit';
	}

	/**
	 * @return int journal id
	 */
	static function journal()
	{
		return \app\AcctgJournalLib::namedjournal('system-ledger');
	}

	/**
	 * Convert deposit format request, into operations array.
	 *
	 * Essentially the bank account is debitted and all the other accounts are
	 * credited. @todo check use cases for potential debit requirements
	 *
	 * @return array transaction operations
	 */
	static function to_operations($req)
	{
		$operations = [];

		$operations[] = array
			(
				'type' => +1,
				'amount_value' => $req['amount_value'],
				'amount_type' => $req['amount_type'],
				'taccount' => $req['taccount'],
				'note' => $req['description']
			);

		foreach ($req['payments'] as $payment)
		{
			$operations[] = array
				(
					'type' => -1,
					'amount_value' => $payment['amount_value'],
					'amount_type' => $payment['amount_type'],
					'taccount' => $payment['taccount'],
					'note' => $payment['note']
				);
		}

		return $operations;
	}

} # class
