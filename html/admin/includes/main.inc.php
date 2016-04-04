<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//Sets include path
set_include_path(get_include_path() . ':../../libs');
//Load Settings file
require_once '../../conf/settings.inc.php';
require_once 'functions.inc.php';

//Sets Timezone
date_default_timezone_set(__TIMEZONE__);


//Function to autoload needed classes
function __autoload($class_name) {
        if(file_exists("../../libs/" . $class_name . ".class.inc.php")) {
                require_once $class_name . '.class.inc.php';
        }
}

$db = new db(__MYSQL_HOST__,__MYSQL_DATABASE__,__MYSQL_USER__,__MYSQL_PASSWORD__);
$ldap = new ldap(__LDAP_HOST__,__LDAP_SSL__,__LDAP_PORT__,__LDAP_BASE_DN__);
$ldap->bind(__LDAP_BIND_USER__,__LDAP_BIND_PASS__);
?>
