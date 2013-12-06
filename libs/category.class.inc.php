<?php
class category {

//////////////Private Variables/////////

        private $db;
	private $category_id;
	private $category_name;
	private $picture;	
	private $nav_picture;



/////////////Public Functions///////////


        public function __construct($db,$category_name = "",$id = 0) {

                $this->db = $db;
		if (($category_name != "") && ($id == 0)){
			$this->get_category_by_name($category_name);
		}
		if (($category_name == "") && ($id != 0)) {
			$this->get_category_by_id($id);
		}
        }


        public function __destruct() {
        }

	public function get_category_id() { return $this->category_id; }
	public function get_name() { return $this->category_name; }
	public function get_picture() { return $this->picture; }
	public function get_nav_picture() { return $this->nav_picture; }
	public function set_name($name) {
		$name = trim(rtrim($name));
                if ($name == "") {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Please enter a category name");
                }
		elseif (preg_match("/[^a-z0-9\s-:]/i", $name)) {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Category " . $name . " has invalid characters");

                }
		elseif ($this->exists($name)) {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Category " . $name . " already exists");
                }
		else {
			$sql = "UPDATE categories SET category_name='" . $name . "' ";
                        $sql .= "WHERE category_id='" . $this->get_category_id() . "' LIMIT 1";
                        $result = $this->db->non_select_query($sql);
			$this->get_category_by_name($name);
                        return array('RESULT'=>true,
                                'MESSAGE'=>"Category name " . $name . " successfully updated");
		}


	}

	public function set_picture($pictureName,$tmpPictureLocation,$picturePath) {
		$filetype = end(explode(".",$pictureName));
                $filename = $this->get_category_id() . "." . $filetype;
		$fullPath = $picturePath . "/" . $filename;

		if (file_exists($picturePath . "/".  $this->get_picture())) {
			unlink($picturePath . "/" . $this->get_picture());
		}
		if (move_uploaded_file($tmpPictureLocation, $fullPath)) {
			$sql = "UPDATE categories SET category_filename='" . $filename . "' ";
			$sql .= "WHERE category_id='" . $this->get_category_id() . "' LIMIT 1 ";
			$this->db->non_select_query($sql);
			$this->get_category_by_id($this->get_category_id());
			return true;
		}
		return false;
		
	}

	public function set_nav_picture($pictureName,$tmpPictureLocation,$picturePath) {
                $filetype = end(explode(".",$pictureName));
                $filename = $this->get_category_id() . "_nav." . $filetype;
                $fullPath = $picturePath . "/" . $filename;

		if (file_exists($picturePath . "/" . $this->get_nav_picture())) {
                	unlink($picturePath . "/" . $this->get_nav_picture());
		}
                if (move_uploaded_file($tmpPictureLocation, $fullPath)) {
                        $sql = "UPDATE categories SET category_nav_filename='" . $filename . "' ";
                        $sql .= "WHERE category_id='" . $this->get_category_id() . "' LIMIT 1 ";
                        $this->db->non_select_query($sql);
                        $this->get_category_by_id($this->get_category_id());
                        return true;
                }
                return false;

        }
	public function create($name) {
		$name = trim(rtrim($name));
                if ($name == "") {
                        return array('RESULT'=>false,
                                'MESSAGE'=>"Please enter a category name");
                }
                elseif (preg_match("/[^a-z0-9\s-:]/i", $name)) {
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
			$this->get_category_by_name($name);
                        return array('RESULT'=>true,
                                'category_id'=>$category_id,
                                'MESSAGE'=>"Category " . $name . " successfully added");
                }



	}

	public function get_podcasts($start,$count) {
                $sql = "SELECT * FROM podcasts WHERE podcast_categoryID='" . $this->get_category_id() . "' AND podcast_enabled=1 ";
                $sql .= "AND podcast_approved=1 AND podcast_enabled=1 ORDER BY podcast_time DESC ";
                $sql .= "LIMIT " . $start . "," . $count;
                return $this->db->query($sql);


        }

//////////////////Private Functions////////////////

	private function get_category_by_name($name) {
		$sql = "SELECT * FROM categories ";
		$sql .= "WHERE category_name='" . $name . "'";
		$sql .= "LIMIT 1";
		$result = $this->db->query($sql);
		if (count($result)) {
			$this->category_name = $result[0]['category_name'];
			$this->category_id = $result[0]['category_id'];
			$this->picture = $result[0]['category_filename'];	

		}
	}

	private function get_category_by_id($id) {
                $sql = "SELECT * FROM categories ";
                $sql .= "WHERE category_id='" . $id . "'";
                $sql .= "LIMIT 1";
                $result = $this->db->query($sql);
                if (count($result)) {
                        $this->category_name = $result[0]['category_name'];
                        $this->category_id = $result[0]['category_id'];
                        $this->picture = $result[0]['category_filename'];
			$this->nav_picture = $result[0]['category_nav_filename'];
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

}
?>
