<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class CheckLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'checks';

	#
	# This class is used for demo-ing procedure integration.
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
					'orderof',
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
		return 'record-check';
	}

	/**
	 * @return int journal id
	 */
	static function journal()
	{
		return \app\AcctgJournalLib::namedjournal('system-ledger');
	}

	/**
	 * Convert check format request, into operations array.
	 *
	 * Essentially the bank account is credited and all the other accounts are
	 * debited. @todo check use cases for potential credit requirements
	 *
	 * @return array transaction operations
	 */
	static function to_operations($req)
	{
		$operations = [];

		$operations[] = array
			(
				'type' => -1,
				'amount_value' => $req['amount_value'],
				'amount_type' => $req['amount_type'],
				'taccount' => $req['taccount'],
				'note' => 'check amount, for order of '.$req['orderof']
			);

		foreach ($req['expenses'] as $expense)
		{
			$operations[] = array
				(
					'type' => +1,
					'amount_value' => $expense['amount_value'],
					'amount_type' => $expense['amount_type'],
					'taccount' => $expense['taccount'],
					'note' => $expense['note']
				);
		}

		return $operations;
	}

} # class
