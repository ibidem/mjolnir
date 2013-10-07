<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgTaccounts extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCollection;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg taccount'];

	/** @var array page actions */
	protected static $actions = ['Add' => 'add', 'Move' => 'move'];

	/** @var string */
	protected static $handler = '\app\AcctgTAccountLib';

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_add()
	{
		return $this->perform_action('tree_push');
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_move()
	{
		return $this->perform_action('tree_move');
	}

} # class
