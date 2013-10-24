<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_DemoEntities extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;

	/** @var array puppet logic */
	protected static $grammar = ['demo entity', 'demo entities'];

	/**
	 * @return string
	 */
	function viewtarget()
	{
		return static::dashplural();
	}

} # class
