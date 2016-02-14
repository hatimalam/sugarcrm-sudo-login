# sugarcrm-sudo-login
Easy login to another user account without password

As a SugarCRM admin, it happens so many times that we need to access another user account to troubleshoot any issue or to setup a dashboard or any other changes.
It's not always feasible to ask User for his/her password due to several reasons. In that case, the only option we are left with is to reset the user password and continue our work but all together it is a little painful process for admin as well as user.
To get away from this problem, I have written a little code snippet to login to any other user in CRM without their password.

# Only Admin users are allowed to login as another user
- Admin User can login to another admin or regular user
- User can log out from another user account and login back to his/her account
