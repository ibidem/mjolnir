<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_DemoEntities_Employees extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCommon;

	/** @var array puppet logic */
	protected static $grammar = ['demo entities employee'];

	/**
	 * @return string
	 */
	function viewtarget()
	{
		return static::dashplural();
	}

	/**
	 * @return string base route url
	 */
	function baseroute()
	{
		return 'demo-entities.public';
	}

} # class
