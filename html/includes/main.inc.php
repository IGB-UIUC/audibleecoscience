<?php

//Sets include path

$include_paths = array('../libs');

set_include_path(get_include_path() . ":" . implode(':',$include_paths));

//Load Settings file
require_once __DIR__ . '/../../conf/app.inc.php';
require_once __DIR__ . '/../../conf/settings.inc.php';
require_once 'functions.inc.php';
require_once __DIR__ . '/../../vendor/autoload.php';
//Sets Timezone
date_default_timezone_set(__TIMEZONE__);

function my_autoloader($class_name) {
	if(file_exists("../libs/" . $class_name . ".class.inc.php")) {
		require_once $class_name . '.class.inc.php';
	}
}
spl_autoload_register('my_autoloader');

$db = new \IGBIllinois\db(__MYSQL_HOST__,__MYSQL_DATABASE__,__MYSQL_USER__,__MYSQL_PASSWORD__);


?>
