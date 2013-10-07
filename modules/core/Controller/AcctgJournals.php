<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgJournals extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCollection;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg journal'];

	/** @var array page actions */
	protected static $actions = ['Add' => 'add'];

	/** @var string */
	protected static $handler = '\app\AcctgJournalLib';

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_add()
	{
		return $this->perform_action('push');
	}

} # class
