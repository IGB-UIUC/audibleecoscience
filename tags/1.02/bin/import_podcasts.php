<?php

function add_podcast($db,$data_in) {
	$data = explode("\t",$data_in);
        $url = $data[1];
        $summary = strip_tags($data[2]);
        $keywords = $data[3];
        $year = $data[4];
        $showName = $data[5];
        $programName = $data[6];
        $source = $data[7];
        $dateEntry = $data[8];
        $ta = $data[9];
        $id = addPodcast($db);
        $podcast = new podcast($id,$db);
        $podcast->setSource($source);
        $podcast->setProgramName($programName);
        $podcast->setShowName($showName);
        $podcast->setBroadcastYear($year);
        $podcast->setUrl($url);
        $podcast->setSummary($summary);
        $podcast_time = date("Y-m-d H:i:s",$dateEntry);
        $sql = "UPDATE podcasts SET podcast_time='" . $podcast_time . "' WHERE podcast_id='" . $id . "' LIMIT 1";
        $db->non_select_query($sql);
}


chdir(dirname(__FILE__));
set_include_path(get_include_path() . ':../libs');
function __autoload($class_name) {
        if(file_exists("../libs/" . $class_name . ".class.inc.php")) {
                require_once $class_name . '.class.inc.php';
        }
}
include_once '../conf/settings.inc.php';
include_once 'functions.inc.php';

$sapi_type = php_sapi_name();
//If run from command line
if ($sapi_type != 'cli') {
        echo "Error: This script can only be run from the command line.\n";
	exit;
}

if (isset($argv[1])) {
                $podcast_data = $argv[1];
}
else {
	echo "Error: First argument must be a csv file.\n";
}

$db = new db(__MYSQL_HOST__,__MYSQL_DATABASE__,__MYSQL_USER__,__MYSQL_PASSWORD__);
$file_handle = @fopen($podcast_data,"r") or
                die("Error: Podcast import file not found in.\n");

while (($data = fgets($file_handle)) !== FALSE) {
                $result = add_podcast($db,$data);
                if ($result['RESULT']) {
                        $number_new_podcasts++;
                }
                elseif (isset($result['MESSAGE'])) {
                        print $result['MESSAGE'] . "\n";
                }
        }



?>
