<?php

//Note: This file should be included first in every php page.
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER', 'simpleadmin');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

require_once BASE_PATH . '/lib/MysqliDb/MysqliDb.php';
require_once BASE_PATH . '/helpers/helpers.php';

/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */

define('DB_HOST', "localhost");
define('DB_USER', "staff");
define('DB_PASSWORD', "d.NmBAwSr[zg7s9t=h/<6+");
define('DB_NAME', "staff");
define('DB_NAME_FIVEM', "fxserveur");

/**
 * Get instance of DB object
 */
function getDbInstance() {
	return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

function getDbInstanceFivem() {
    return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_FIVEM);
}