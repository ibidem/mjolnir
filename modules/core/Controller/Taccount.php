<?php namespace ibidem\demos\acctg\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_Taccount extends \app\Controller_Base
{
	use \app\Trait_Controller_IbidemDemosAcctgCore;

	/**
	 * ...
	 */
	function public_remove()
	{
		\app\AcctgTAccountLib::tree_delete($_POST['id']);
		\app\Server::redirect(\app\URL::href('frontend.public'));
	}

	/**
	 * @return \mjolnir\types\Renderable
	 */
	function public_update()
	{
		$errors = [];

		if ($this->is_input_request())
		{
			$id = $this->param('id', null);

			$input_errors = \app\AcctgTAccountLib::tree_update($id, $_POST);

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

	// ------------------------------------------------------------------------
	// Context

	/**
	 * @return array
	 */
	function entry()
	{
		return \app\AcctgTAccountLib::entry($this->param('id'));
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
