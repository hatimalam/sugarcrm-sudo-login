<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Desc: Overridden view.detail.php to add custom button in User detail view
 * We are overrding only preDisplay function as new button is added in this function
 * Written by: Hatim Alam
 * Dated: 11th Feb 2016
 */

require_once('modules/Users/views/view.detail.php');

class CustomUsersViewDetail extends UsersViewDetail {
    function __construct(){
 	parent::__construct();
    }

    function preDisplay() {
        global $current_user, $app_strings, $sugar_config;
        parent::preDisplay();

	//used constructor instead of Static create method as it doesn't support SugarCE 6.5
	//by Hatim Alam
        $viewHelper = new UserViewHelper($this->ss, $this->bean, 'DetailView');
        $viewHelper->setupAdditionalFields();

	//re-build buttons array to include all buttons along with sudo user button
        $buttons = array();
        if ((is_admin($current_user) || $_REQUEST['record'] == $current_user->id
                )
            && !empty($sugar_config['default_user_name'])
            && $sugar_config['default_user_name'] == $this->bean->user_name
            && isset($sugar_config['lock_default_user_name'])
            && $sugar_config['lock_default_user_name']) {
            $buttons[] = "<input id='edit_button' accessKey='".$app_strings['LBL_EDIT_BUTTON_KEY']."' name='Edit' title='".$app_strings['LBL_EDIT_BUTTON_TITLE']."' value='".$app_strings['LBL_EDIT_BUTTON_LABEL']."' onclick=\"this.form.return_module.value='Users'; this.form.return_action.value='DetailView'; this.form.return_id.value='".$this->bean->id."'; this.form.action.value='EditView'\" type='submit' value='" . $app_strings['LBL_EDIT_BUTTON_LABEL'] .  "'>";
        }
        elseif (is_admin($current_user)|| ($GLOBALS['current_user']->isAdminForModule('Users')&& !$this->bean->is_admin)
                || $_REQUEST['record'] == $current_user->id) {
            $buttons[] = "<input title='".$app_strings['LBL_EDIT_BUTTON_TITLE']."' accessKey='".$app_strings['LBL_EDIT_BUTTON_KEY']."' name='Edit' id='edit_button' value='".$app_strings['LBL_EDIT_BUTTON_LABEL']."' onclick=\"this.form.return_module.value='Users'; this.form.return_action.value='DetailView'; this.form.return_id.value='".$this->bean->id."'; this.form.action.value='EditView'\" type='submit' value='" . $app_strings['LBL_EDIT_BUTTON_LABEL'] .  "'>";
            if ((is_admin($current_user)|| $GLOBALS['current_user']->isAdminForModule('Users')
                    )) {
                if (!$current_user->is_group){
                    $buttons[] = "<input id='duplicate_button' title='".$app_strings['LBL_DUPLICATE_BUTTON_TITLE']."' accessKey='".$app_strings['LBL_DUPLICATE_BUTTON_KEY']."' class='button' onclick=\"this.form.return_module.value='Users'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value=true; this.form.action.value='EditView'\" type='submit' name='Duplicate' value='".$app_strings['LBL_DUPLICATE_BUTTON_LABEL']."'>";

                    if($this->bean->id != $current_user->id) {
                        $buttons[] ="<input id='delete_button' type='button' class='button' onclick='confirmDelete();' value='".$app_strings['LBL_DELETE_BUTTON_LABEL']."' />";
                    }

                    if (!$this->bean->portal_only && !$this->bean->is_group && !$this->bean->external_auth_only
                        && isset($sugar_config['passwordsetting']['SystemGeneratedPasswordON']) && $sugar_config['passwordsetting']['SystemGeneratedPasswordON']){
                        $buttons[] = "<input title='".translate('LBL_GENERATE_PASSWORD_BUTTON_TITLE','Users')."' class='button' LANGUAGE=javascript onclick='generatepwd(\"".$this->bean->id."\");' type='button' name='password' value='".translate('LBL_GENERATE_PASSWORD_BUTTON_LABEL','Users')."'>";
                    }
                }
            }
        }

	//add sudo user button for login and logout
	if($current_user->id != $this->bean->id) {
		//show button only for active users
		$new_user_bean = BeanFactory::getBean("Users", $this->bean->id);
		if($new_user_bean->status == "Active") {
			$buttons[] = "<input type='submit' onclick=\"this.form.module.value='Users';this.form.action.value='sudo_login_user'\" class='button' id='sudo_login_user' value='".translate('LBL_USER_LOGIN_AS','Users')." {$this->bean->user_name}'/>";
		}
	} else if(($current_user->id == $this->bean->id) && (!empty($_SESSION['original_sudo_user_id']))) {
		$buttons[] = "<input type='submit' onclick=\"this.form.module.value='Users';this.form.action.value='sudo_logout_user'\" class='button' id='sudo_logout_user' value='".translate('LBL_USER_LOGIN_BACK_AS','Users')." {$_SESSION[original_sudo_user_name]}'/>";
	}
        $buttons = array_merge($buttons, $this->ss->get_template_vars('BUTTONS_HEADER'));
        $this->ss->assign('EDITBUTTONS',$buttons);
    }
}
