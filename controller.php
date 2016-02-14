<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * SugarCRM sudo login as another user
 * Written by: Hatim Alam
 * Dated: 11th Feb 2016
 */

require_once("modules/Users/controller.php");

class CustomUsersController extends UsersController
{
	function __construct() {
		parent::__construct();
	}

	/**
	 * Written by: Hatim Alam
	 * Dated: 11th Feb 2016
	 * Custom controller action to login with provided user id
	 */
	protected function action_sudo_login_user() {

		if(!empty($_REQUEST) && isset($_REQUEST['record']) && ($_REQUEST['module']=='Users')) {
			//get user id for whom you need to login as
			$new_user_id = $_REQUEST['record'];

			//if current user is admin
			if($GLOBALS['current_user']->is_admin)  {
				//store original sudo id in session
				if(empty($_SESSION['original_sudo_user_id'])) {
					$_SESSION['original_sudo_user_id'] = $GLOBALS['current_user']->id;
					$_SESSION['original_sudo_user_name'] = $GLOBALS['current_user']->user_name;
				}

				//
				$new_user_bean = BeanFactory::getBean('Users', $new_user_id);
				//echo "<pre>";print_r($_SESSION);
				$GLOBALS['current_user'] = $new_user_bean;
				$_SESSION['authenticated_user_id'] = $new_user_bean->id;
				$_SESSION['user_id'] = $new_user_bean->id;
				//echo "<pre>";print_r($_SESSION);
				$query_params = array(
					'module' => 'Users',
					'action' => 'DetailView',
					'record' => $new_user_bean->id,
				);
				SugarApplication::redirect('index.php?'.http_build_query($query_params));
			}
		}
	}

	/**
	 * Written by: Hatim Alam
	 * Dated: 11th Feb 2016
	 * Controller action to logout temporary user and login back the original user
	 */
	protected function action_sudo_logout_user() {
		//check if current user id is same as record id
		if(!empty($_REQUEST) && isset($_REQUEST['record']) && ($_REQUEST['module']=='Users')) {
			$requested_user_id = $_REQUEST['record'];
			if(($GLOBALS['current_user']->id == $requested_user_id) && !empty($_SESSION['original_sudo_user_id'])) {
				$original_user_bean = BeanFactory::getBean('Users', $_SESSION['original_sudo_user_id']);
				$GLOBALS['current_user'] = $original_user_bean;
				$_SESSION['authenticated_user_id'] = $original_user_bean->id;
				$_SESSION['user_id'] = $original_user_bean->id;

				//unset session variables
				unset($_SESSION['original_sudo_user_id']);
				unset($_SESSION['original_sudo_user_name']);

				//redirect to original sudo user profile
				$query_params = array(
					'module' => 'Users',
					'action' => 'DetailView',
					'record' => $original_user_bean->id,
				);
				SugarApplication::redirect('index.php?'.http_build_query($query_params));
			}
		}
	}
}

