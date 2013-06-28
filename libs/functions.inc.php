<?php

include_once 'db.class.inc.php';

function getApprovedPodcasts($db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_approved=1 AND podcasts.podcast_enabled=1 ORDER BY podcasts.podcast_time DESC";

	return $db->query($sql);

}

function getRecentPodcasts($db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_approved=1 AND podcasts.podcast_enabled=1 ORDER BY podcasts.podcast_time DESC ";
	$sql .= "LIMIT 0,10";

	return $db->query($sql);

}

function getUnapprovedPodcasts($db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_approved=0 AND podcasts.podcast_enabled=1 ORDER BY podcasts.podcast_time DESC";
	return $db->query($sql);






}
function getAllPodcasts($db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_enabled=1 ";
	$sql .= "ORDER BY podcast_time DESC";
	return $db->query($sql);

}

function getYourPodcasts($username,$db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_enabled=1 ";
	$sql .= "AND users.user_name='" . $username . "' ";
	$sql .= "ORDER BY podcast_time DESC";
	return $db->query($sql);

}
function addPodcast($db) {
	$sql = "INSERT INTO podcasts(podcast_enabled) VALUES('1')";
	return $db->insert_query($sql);




}

function getNumPages($numRecords,$count) {
	$numPages = floor($numRecords/$count);
	$remainder = $numRecords % $count;
	if ($remainder > 0) {
		$numPages++;
	}
	return $numPages;


}

function search($search,$db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE (podcasts.podcast_enabled='1' ";
	$sql .= "AND podcasts.podcast_approved='1') ";
	$sql .= "AND (podcast_summary LIKE '%" . $search . "%' ";
	$sql .= "OR podcast_source LIKE '%" . $search . "%' ";
	$sql .= "OR podcast_programName LIKE '%" . $search . "%' ";
	$sql .= "OR podcast_showName LIKE '%" . $search . "%' ";
	$sql .= "OR podcast_year LIKE '%" . $search . "%' ";
	$sql .= "OR podcast_url LIKE '%" . $search . "%') ";
	$sql .= "ORDER BY podcast_time DESC";
	return $db->query($sql);

}


function get_users($db) {


	$sql = "SELECT users.* FROM users ";
	$sql .= "WHERE user_enabled='1' ";
	$sql .= "ORDER BY user_name";
	return  $db->query($sql);
}

function import_users($db,$ldap,$file) {
	$handle = fopen($file, "r");
	$row = 0;
	$result;
	$success = 0;
	$failures = 0;
	$message_array = array();
	while (($data = fgetcsv($handle)) !== FALSE) {
		$username = $data[0];
		$username = strtolower(trim(rtrim($username)));
		if (preg_match("/(A-Za-z0-9]+/", $username)) {
			$add_user = new user($db,$ldap,$username);
			$admin = 0;
			$result = $add_user->add($admin);
			$message_array = array_merge($message_array,$result['MESSAGE']);
			$success++;
		}
		else {
			array_push($message_array,"User " . $username . " is invalid");
			$failures++;
		}

		$row++;


	}

	fclose($handle);
	return array('RESULT'=>true,
			'MESSAGE'=>$message_array,
			'SUCCESS'=>$success,
			'FAILURES'=>$failures);
}

function get_max_upload_size($units = "megabytes") {
	$upload_size_mb = ini_get('upload_max_filesize');
	$upload_size_mb = substr($upload_size_mb,0,strpos($upload_size_mb,"M"));
	$result = 0;
	if ($units == "bytes") {
		$result = $upload_size_mb * 1048576;	
	}
	elseif ($units == "kilobytes") {
		$result = $upload_size_mb * 1024;
	}
	else {
		$result = $upload_size_mb;
	}
	return $result;


} 

?>
