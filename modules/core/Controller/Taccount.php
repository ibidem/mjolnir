<?php namespace ibidem\core;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem Team
 * @copyright  (c) 2013, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_Taccount extends \app\Controller_Base
{
	/**
	 * ...
	 */
	function public_delete()
	{
		\app\AcctgTAccountLib::delete([ $_POST['id'] ]);
		\app\Server::redirect(\app\URL::href('frontend.public'));
	}

	/**
	 * ...
	 */
	function public_remove()
	{
		\app\AcctgTAccountLib::tree_delete($_POST['id']);
		\app\Server::redirect(\app\URL::href('frontend.public'));
	}

} # class
