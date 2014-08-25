<?php
/*
Plugin Name: Tower Marketing SEM Reporting
Plugin URI: http://towermarketing.net
Description: SEM reporting plugin
Author: Adam Miller
Version: 1.0
Author URI: http://www.towermarketing.net
*/

require_once 'include/semreporting.class.php';
require_once 'include/sem-report-components/framework.php';

$sem_reporting = new SemReporting();
$sem_reporting->init();