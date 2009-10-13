<?php
//////////////////////////////////////////
//					//
//	categories.class.inc.php	//
//					//
//	Class that implements		//
//	functions for categories.	//
//					//
//	By David Slater			//
//	June 2009			//
//					//
//////////////////////////////////////////

include_once 'db.class.inc.php';

class categories {

//////////////Private Variables/////////
	
	private $db;





/////////////Public Functions///////////


	public function __construct($mysqlSettings) {

		$this->db = new db($mysqlSettings['host'],$mysqlSettings['database'],$mysqlSettings['username'],$mysqlSettings['password']);
	}


	public function __destruct() {
		$this->db->close();
	}


	public function getCategories() {
		$sql = "SELECT * FROM categories WHERE category_enabled=1";
		return $this->db->query($sql);

	
	}
	public function getParent($category_id) {
		$sql = "SELECT category_parent FROM categories WHERE category_id='" . $category_id . "'";
		return $this->db->query($sql);

	}

	public function setParent($category_id,$parent_id) {
		$sql = "UPDATE categories SET category_parent=" . $parent_id . " WHERE category_id='" . $category_id . "'";
		return $this->db->query_non_select($sql);

	}

	public function getChildren($category_id) {
		$sql = "SELECT * FROM categories WHERE category_parent='" . $category_id . "' AND category_enabled='1'";
		return $this->db->query($sql);

	}

	public function getPodcasts($category_id,$start,$count) {
		$sql = "SELECT * FROM podcasts WHERE podcast_categoryID='" . $category_id . "' AND podcast_enabled=1 ";
		$sql .= "AND podcast_approved=1 AND podcast_enabled=1 ORDER BY podcast_time DESC ";
		$sql .= "LIMIT " . $start . "," . $count;
		return $this->db->query($sql);


	}

	public function getHeadCategories() {
		$sql = "SELECT * FROM categories WHERE category_parent IS NULL AND category_enabled=1";
		return $this->db->query($sql);


	}

	public function add($name) {
		$name = trim(rtrim($name));
		if ($this->exists($name)) {
			return 0;
		}
		else {
	
			$sql = "INSERT INTO categories(category_name) VALUES('" . $name . "')";
			return $this->db->insert_query($sql);
		}
	}

	public function addChild($name,$headCategoryId) {
		$name = trim(rtrim($name));
		if ($this->exists($name)) {
			return 0;
		}
		else {
			$sql = "INSERT INTO categories(category_name,category_parent) ";
			$sql .= "VALUES('" . $name . "','" . $headCategoryId . "')";
			return $this->db->insert_query($sql);


		}



	}
	public function remove($category_id) {
		$podcastSearchSql = "SELECT 1 FROM podcasts WHERE podcast_categoryId='" . $category_id ."'";
		if (count($this->db->query($podcastSearchSql))) {
			return 0;
		}
		elseif (count($this->getChildren($category_id))) {
			return 0;
		}
		else {
			$sql = "UPDATE categories SET category_enabled=0 WHERE category_id='" . $category_id . "'";
			return $this->db->non_select_query($sql);
		}
	}
	public function numHeadCategories() {
		$sql = "SELECT count(1) as count FROM categories WHERE category_parent IS NULL AND category_enabled='1'";
		$result = $this->db->query($sql);
		return $result[0]['count'];

	}

	public function numCategories() {
		$sql = "SELECT count(1) as count FROM categories WHERE category_enabled='1'";
		$result = $this->db->query($sql);
		return $result[0]['count'];

	}

	public function numPodcasts($category_id) {
		$sql = "SELECT count(1) as count FROM podcasts WHERE podcast_categoryId='" . $category_id . "' ";
		$sql .= "AND podcast_enabled=1";
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}

	public function getName($id) {
		$sql = "SELECT category_name FROM categories WHERE category_id='" . $id . "'";
		$result = $this->db->query($sql);
		return $result[0]['category_name'];


	}
	
	public function setName($id,$name) {
		$name = trim(rtrim($name));
		$sql = "UPDATE categories SET category_name='" . $name . "' WHERE category_id='" . $id . "'";
		return $this->db->non_select_query($sql);

	}
	public function exists($category) {
		$category = trim(rtrim($category));
		$sql = "SELECT * FROM categories WHERE category_name='" . $category . "' AND category_enabled=1";
		$result = $this->db->query($sql);
		if (count($result) > 0) {
			return true;
		}
		else {
			return false;
		}

	}

/////////////Private Functions////////////





}



?>
