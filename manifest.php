<?php

/**
 * SugarCRM manifest.php file to install sugarcrm-sudo-login package via Module Loader
 * Modified by: Hatim Alam
 * Dated: 14th Feb 2016
 */

$manifest = array (
  0 => 
  array (
    'acceptable_sugar_versions' => 
    array (
      0 => '6.5.*',
      1 => '7.*',
    ),
  ),
  1 => 
  array (
    'acceptable_sugar_flavors' => 
    array (
      0 => 'CE',
      1 => 'PRO',
      2 => 'ENT',
      3 => 'CORP',
    ),
  ),
  'readme' => 'README.txt',
  'key' => 'sugarcrm_sudo_login',
  'author' => 'Hatim Alam',
  'description' => 'Easy login to other users account without password',
  'icon' => '',
  'is_uninstallable' => true,
  'name' => 'SugarCRM Sudo Login',
  'published_date' => '2016-02-14 10:25:00',
  'type' => 'module',
  'version' => 1.0,
  'remove_tables' => '',
);


$installdefs = array (
  'id' => 'sugarcrm_sudo_login',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/Files/controller.php',
      'to' => 'custom/modules/Users/controller.php',
    ),
    1 => 
    array (
      'from' => '<basepath>/Files/view.detail.php',
      'to' => 'custom/modules/Users/views/view.detail.php',
    ),
  ),
);