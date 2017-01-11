# sugarcrm-sudo-login
Easy login to another user account without password (Works well with both SugarCRM 6.5.X and 7.X)

As a SugarCRM admin, it happens so many times that we need to access another user account to troubleshoot any issue or to setup a dashboard or any other changes.
It's not always feasible to ask User for his/her password due to several reasons. In that case, the only option we are left with is to reset the user password and continue our work but all together it is a little painful process for admin as well as user.
To get away from this problem, I have written a little code snippet to login to any other user in CRM without their password.

# Only Admin users are allowed to login as another user
- Admin User can login to another admin or regular user
- User can log out from another user account and login back to his/her account

#Installation Instructions
- Install this package through SugarCRM module loader
- Navigate to User Management in Admin panel
- Click on any user whom you want to login as
- Click on the action menu and click on 'Login as '
- You will now be logged in as that user
- To go back to your original admin user, navigate to your current user profile, click on action menu and click on 'Login Back as '

It is easily unistallable via module loader and compatible with on-demand instances as well.

Note: It will override your custom controller.php and view.detail.php files in Users module if already exist. So, please make sure you do not have these 2 files in your custom folder and if you have, please backed it up before installing this package.
