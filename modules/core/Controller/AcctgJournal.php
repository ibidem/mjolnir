<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_AcctgJournal extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgEntry;
	use \app\Trait_AcctgContext;

	/** @var array puppet logic */
	protected static $grammar = ['acctg journal'];

	/** @var array page actions */
	protected static $actions = array
		(
			'View' => null,
			'Edit' => 'edit',
			'Add Transactions' => 'add-transactions'
		);

	/**
	 * ...
	 */
	function public_delete()
	{
		\app\AcctgJournalLib::delete([ $_POST['id'] ]);
		\app\Server::redirect(\app\URL::href('journals.public'));
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_edit()
	{
		$errors = [];

		if ($this->is_input_request())
		{
			$id = $this->param('id', null);

			$_POST['id'] = $id;
			$input_errors = \app\AcctgJournalLib::update($id, $_POST);

			if ($input_errors === null)
			{
				\app\Server::redirect($this->action(null)); # ie. index
			}
			else # got errors
			{
				$action = $this->actionkey();
				$errors = [$action => $input_errors];
			}
		}

		return $this->public_index()
			->pass('errors', $errors);
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_add_transactions()
	{
		return $this->public_index();
	}

	// ------------------------------------------------------------------------
	// Context

	/**
	 * @return array
	 */
	function entry()
	{
		return \app\AcctgJournalLib::entry($this->param('id'));
	}

	/**
	 * @return string action url
	 */
	function action($action)
	{
		return \app\URL::href
			(
				static::dashsingular().'.public',
				[
					'action' => $action,
					'id' => $this->param('id')
				]
			);
	}

} # class
