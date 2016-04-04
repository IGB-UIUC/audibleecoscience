<?php


function get_podcasts($db,$start_date = 0,$end_date = 0,$approved = 1,$category_id = 0,$search = "",$order_by = "podcast_time") {
        $search = strtolower(trim(rtrim($search)));
        $where_sql = array();

	$sql = "SELECT podcasts.*,users.user_name,categories.* ";
	$sql .= "FROM podcasts ";
        $sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
        $sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	
	if ($approved) {
		array_push($where_sql,"podcasts.podcast_approved='1'");
	}
	array_push($where_sql,"podcasts.podcast_enabled='1'"); 
	if ($category_id) {
		$category_sql = "podcasts.podcast_categoryId='" . $category_id . "' ";
		array_push($where_sql,$category_sql);

	}
	if ($search != "" ) {
                $terms = explode(" ",$search);
                foreach ($terms as $term) {
                        $search_sql = "(LOWER(categories.category_name) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(podcast_source) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(podcast_programName) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(podcast_showName) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(podcast_year) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(podcast_url) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(podcast_summary) LIKE '%" . $term . "%') ";
                        array_push($where_sql,$search_sql);
                }

        }
	if (($start_date != 0) && ($end_date != 0)) {
		$date_sql = "((DATE(podcast_time) >= DATE('" . $start_date . "')) AND (DATE(podcast_time) <= DATE('" . $end_date . "'))) ";
                array_push($where_sql,$date_sql);

        }
	
	$num_where = count($where_sql);
        if ($num_where) {
                $sql .= "WHERE ";
                $i = 0;
                foreach ($where_sql as $where) {
                        $sql .= $where;
                        if ($i<$num_where-1) {
                                $sql .= "AND ";
                        }
                        $i++;
                }

        }

        $sql .= "ORDER BY podcasts." . $order_by . " DESC ";
        $result = $db->query($sql);
        return $result;



}

function get_podcast_report($db,$month,$year) {


	$sql = "SELECT users.user_name as 'User', categories.category_name as 'Category', ";
	$sql .= "podcast_time as 'Time Created', podcast_source as 'Source', ";
	$sql .= "podcast_programName as 'Program Name', podcast_showName as 'Show', ";
	$sql .= "podcast_year as 'Year', podcast_url as 'URL', podcast_short_summary as 'Short Summary', ";
	$sql .= "podcast_acknowledgement as 'Acknowledgement', podcast_review_permission as 'Review Permission', ";
	$sql .= "podcast_approved as 'Approved', podcast_quality as 'Quality', ";
	$sql .= "podcast_video as 'Contains Video' ";
        $sql .= "FROM podcasts ";
        $sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
        $sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcast_enabled='1' AND ";
	$sql .= "(YEAR(podcasts.podcast_time)='" . $year . "' ";
        $sql .= "AND month(podcasts.podcast_time)='" . $month . "') ";
	$result = $db->query($sql);
	return $result;







}
function getApprovedPodcasts($db) {


	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_approved=1 AND podcasts.podcast_enabled=1 ORDER BY podcasts.podcast_time DESC";

	return $db->query($sql);

}

function getRecentPodcasts($db,$count = 10) {


	$sql = "SELECT podcasts.*,categories.* FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_approved=1 AND podcasts.podcast_enabled=1 ORDER BY podcasts.podcast_time DESC ";
	$sql .= "LIMIT 0," . $count;

	return $db->query($sql);

}

function getTopPodcasts($db) {
        $sql = "SELECT * FROM podcasts ";
        $sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
        $sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
        $sql .= "WHERE podcasts.podcast_approved=1 AND podcasts.podcast_enabled=1 ORDER BY podcasts.podcast_quality DESC ";
        $sql .= "LIMIT 0,10";
        return $db->query($sql);



}
function getUnapprovedPodcasts($db,$ta = "") {

	$sql = "SELECT * FROM podcasts ";
	$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
	$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
	$sql .= "WHERE podcasts.podcast_approved=0 AND podcasts.podcast_enabled=1 ";
	
	if ($ta != "") {
		$sql = " AND users.user_ta='" . $ta . "' ";

	}
	$sql .= "ORDER BY podcasts.podcast_time DESC";
	echo $sql;
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


function get_users($db,$search = "") {
	$search = strtolower(trim(rtrim($search)));
        $where_sql = array();

	$sql = "SELECT users.*,a.podcast_time as podcast_time FROM users ";
	$sql .= "LEFT JOIN ( ";
	$sql .= "SELECT MAX(podcasts.podcast_time) as podcast_time,podcasts.podcast_createBy as podcast_createBy ";
	$sql .= "FROM podcasts GROUP BY podcast_createBy) as a ";
	$sql .= "ON a.podcast_createBy=users.user_id ";
	array_push($where_sql,"users.user_enabled='1'");

	if ($search != "" ) {
                $terms = explode(" ",$search);
                foreach ($terms as $term) {
                        $search_sql = "(LOWER(users.user_name) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(users.user_firstname) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(users.user_lastname) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(users.user_class) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(users.user_section) LIKE '%" . $term . "%' OR ";
                        $search_sql .= "LOWER(users.user_ta) LIKE '%" . $term . "%') ";
                        array_push($where_sql,$search_sql);
                }

        }
	$num_where = count($where_sql);
        if ($num_where) {
                $sql .= "WHERE ";
                $i = 0;
                foreach ($where_sql as $where) {
                        $sql .= $where;
                        if ($i<$num_where-1) {
                                $sql .= "AND ";
                        }
                        $i++;
                }

        }
        $sql .= " ORDER BY users.user_name ASC ";
        $result = $db->query($sql);
        return $result;

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
		$admin = $data[1];
		$school_class = $data[2];
		$section = $data[3];
		$ta = $data[4];
		$username = strtolower(trim(rtrim($username)));
		$add_user = new user($db,$ldap,$username);
		if ($admin) {
			$result = $add_user->add($admin);
		}
		else {
			$result = $add_user->add($admin,$school_class,$section,$ta);
		}
		$message_array = array_merge($message_array,$result['MESSAGE']);

		if ($result['RESULT']) {
			$success++;
		}
		else {
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

//get_pages_html()
//$url - url of page
//$num_records - number of items
//$start - start index of items
//$count - number of items per page
//returns pagenation to navigate between pages of devices
function get_pages_html($url,$num_records,$start,$count) {

        $num_pages = ceil($num_records/$count);
        $current_page = $start / $count + 1;
        if (strpos($url,"?")) {
                $url .= "&start=";
        }
        else {
                $url .= "?start=";

        }

        $pages_html = "<div class='pagination pagination-centered'><ul>";

        if ($current_page > 1) {
                $start_record = $start - $count;
                $pages_html .= "<li><a href='" . $url . $start_record . "'>&laquo;</a></li> ";
        }
        else {
                $pages_html .= "<li class='disabled'><a href='#'>&laquo;</a></li>";
        }

        for ($i=0; $i<$num_pages; $i++) {
                $start_record = $count * $i;
                if ($i == $current_page - 1) {
                        $pages_html .= "<li class='disabled'>";
                }
                else {
                        $pages_html .= "<li>";
                }
                $page_number = $i + 1;
                $pages_html .= "<a href='" . $url . $start_record . "'>" . $page_number . "</a></li>";
        }

        if ($current_page < $num_pages) {
                $start_record = $start + $count;
                $pages_html .= "<li><a href='" . $url . $start_record . "'>&raquo;</a></li> ";
        }
        else {
                $pages_html .= "<li class='disabled'><a href='#'>&raquo;</a></li>";
        }
        $pages_html .= "</ul>\n<div class=\"clear\"></div>\n<!-- end: class=pagination -->\n</div>";
        return $pages_html;

}


function get_categories($db) {
                $sql = "SELECT * FROM categories WHERE category_enabled=1 ORDER BY category_name ASC";
                return $db->query($sql);


}

function get_rating_label($rating) {

	if ($rating <= 3) {
		return "badge-important";
	}
	elseif (($rating > 3) && ($rating <= 7)) {
		return "badge-warning";
	}
	elseif ($rating > 7) {
		return "badge-success";
	}

}


function verify_url($db,$url,$id = 0) {
	$url = trim(rtrim($url));
	$success = true;
	$message = "";
	if ($url == "") {
		$success = false;
		$message = "Please enter a URL";
	}
	elseif (filter_var($url,FILTER_VALIDATE_URL) === FALSE) {
		$success = false;
		$message = "Please enter a properly formatted URL";
	}
	elseif (!verify_url_curl($url)) {
		$success = false;
		$message = "URL does not exist.  Please verify URL";
	}
	elseif (!unique_url($db,$url,$id)) {
		$success = false;
		$message = "URL already exists in database.   Please use another podcast.";
	}
	return array('RESULT'=>$success,'MESSAGE'=>$message);
	

}

function verify_url_curl($url) {

                $handle   = curl_init($url);
                if (false === $handle)
                {
                        return false;
                }
                curl_setopt($handle, CURLOPT_HEADER, false);
                curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
                curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
                curl_setopt($handle, CURLOPT_NOBODY, true);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION,true);
                $connectable = curl_exec($handle);
                ##print $connectable;
                curl_close($handle);
                return $connectable;


}

function unique_url($db,$url,$id = 0) {

	$sql = "SELECT count(1) as count ";
	$sql .= "FROM podcasts ";
	$sql .= "WHERE podcast_url='" . $url . "' ";
	if ($id) {
		$sql .= "AND podcast_id!='" . $id . "'";
	}
	$result = $db->query($sql);
	if ($result[0]['count']) {
		return false;
	}
	return true;


}

function verify_spelling($input_string) {
	return true;
	$input_string = trim(rtrim($input_string));
	$string_array = explode(" ",$input_string);
	//preg_match_all("/[A-Z\']{1,16}/i", $input_string,$string_array);
	$pspell_link = pspell_new("en");
	foreach ($string_array as $word) {
		if (!pspell_check($pspell_link,$word)) {
			return false;
		}
	}
	return true;
}
?>
