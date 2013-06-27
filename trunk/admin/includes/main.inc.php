<?php

//Sets include path
set_include_path(get_include_path() . ':../libs');
//Load Settings file
include_once '../includes/settings.inc.php';
include_once 'functions.inc.php';

//Sets Timezone
date_default_timezone_set(__TIMEZONE__);

//Function to autoload needed classes
function __autoload($class_name) {
        if(file_exists("../libs/" . $class_name . ".class.inc.php")) {
                require_once $class_name . '.class.inc.php';
        }
}

$db = new db(__MYSQL_HOST__,__MYSQL_DATABASE__,__MYSQL_USER__,__MYSQL_PASSWORD__);


?>
