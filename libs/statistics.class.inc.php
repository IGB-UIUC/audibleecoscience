<?php

class statistics {

	public static function get_num_podcasts($db) {
		$sql = "SELECT count(1) as count ";
		$sql .= "FROM podcasts ";
		$result = $db->query($sql);
		return $result[0]['count'];

	}
	public static function get_num_approved_podcasts($db) {
		$sql = "SELECT count(1) as count ";
		$sql .= "FROM podcasts ";
		$sql .= "WHERE podcast_approved='1'";
		$result = $db->query($sql);
		return $result[0]['count'];

	}

}






?>
