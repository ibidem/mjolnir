<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class InvoiceExpenseLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'invoice_expenses';

	#
	# This class is used for demo-ing procedure integration
	#

	// ------------------------------------------------------------------------
	// Factory interface

	/** @var array field list */
	protected static $fields = array
		(
			'nums' => array
				(
					'id',
					'invoice',
					'quantity',
					'unit_value',
				),
			'strs' => array
				(
					'description',
					'unit_type',
				),
			'bools' => array
				(
					// empty
				),
		);

	/**
	 * @return \mjolnir\types\Validator
	 */
	static function check(array $input, $context = null)
	{
		return \app\Validator::instance();
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

} # class
