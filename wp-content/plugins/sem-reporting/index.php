<?php
/*
Plugin Name: Tower Marketing SEM/Social Reporting
Plugin URI: http://towermarketing.net
Description: SEM/Social reporting plugin
Author: Adam Miller
Version: 1.0
Author URI: http://www.towermarketing.net
*/

require_once 'include/socialreporting.class.php';
require_once 'include/report-components/framework.php';
require_once 'include/api-classes/framework.php';

$social_reporting = new SocialReporting();
$social_reporting->init();