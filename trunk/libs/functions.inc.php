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
?>
