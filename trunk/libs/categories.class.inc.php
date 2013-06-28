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


class categories {

//////////////Private Variables/////////
	
	private $db;





/////////////Public Functions///////////


	public function __construct($db) {

		$this->db = $db;
	}


	public function __destruct() {
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
		if ($name == "") {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Please enter a category name");
		}
		elseif (preg_match("/[^a-z0-9\s-]/i", $name)) {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Category " . $name . " has invalid characters");

                }

		elseif ($this->exists($name)) {
			return array('RESULT'=>false,
				'MESSAGE'=>"Category " . $name . " already exists");
		}
		else {
	
			$sql = "INSERT INTO categories(category_name) VALUES('" . $name . "')";
			$category_id = $this->db->insert_query($sql);
			return array('RESULT'=>true,
				'category_id'=>$category_id,
				'MESSAGE'=>"Category " . $name . " successfully added");
		}
	}

	public function addChild($name,$headCategoryId) {
		$name = trim(rtrim($name));
		if ($name == "") {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Please enter a category name");
                }
		elseif (preg_match("/[^a-z0-9\s-]/i", $name)) {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Category " . $name . " has invalid characters");

                }
		elseif ($this->exists($name)) {
			return array('RESULT'=>false,
                                'MESSAGE'=>"Category " . $name . " already exists");

		}
		else {
			$sql = "INSERT INTO categories(category_name,category_parent) ";
			$sql .= "VALUES('" . $name . "','" . $headCategoryId . "')";
			$category_id = $this->db->insert_query($sql);
			
			return array('RESULT'=>true,
                                'category_id'=>$category_id,
                                'MESSAGE'=>"Category " . $name . " successfully added");


		}



	}
	public function remove($category_id) {
		$sql = "SELECT 1 FROM podcasts WHERE podcast_categoryId='" . $category_id ."'";
		if (count($this->db->query($sql))) {
			return array('RESULT'=>false,
				'MESSAGE'=>"Unable to remove, category does not exist");
		}
		elseif (count($this->getChildren($category_id))) {
			return array('RESULT'=>false,
				'MESSAGE'=>"Unable to remove, category has children");
		}
		else {
			$sql = "UPDATE categories SET category_enabled=0 ";
			$sql .= "WHERE category_id='" . $category_id . "'";
			$result = $this->db->non_select_query($sql);
			return array('RESULT'=>true,
				'MESSAGE'=>"Category successfully removed");
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
		if ($this->exists($name)) {
			return array('RESULT'=>false,
				'MESSAGE'=>"Category name " . $name . " already exists");
		}
		
		else {
			$sql = "UPDATE categories SET category_name='" . $name . "' ";
			$sql .= "WHERE category_id='" . $id . "' LIMIT 1";
			$result = $this->db->non_select_query($sql);
			return array('RESULT'=>true,
				'MESSAGE'=>"Category name " . $name . " successfully updated");
		}
		

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
