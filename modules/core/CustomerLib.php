<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Core
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class CustomerLib
{
	use \app\Trait_ModelLib;

	/** @var string */
	static $table = 'customers';

	#
	# This class is used for demo-ing entity integration in the acctg system.
	#

	// ------------------------------------------------------------------------
	// Factory interface

	/** @var array field list */
	protected static $fields = array
		(
			'nums' => array
				(
					'id',
					'group',
				),
			'strs' => array
				(
					'title',
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
