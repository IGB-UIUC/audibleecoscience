<?php

//////////////////////////////////////////
//					//
//	users.class.inc.php		//
//					//
//	class referring to user db 	//
//					//
//	By Crystal Ahn		//
//	June 2009			//
//					//
//////////////////////////////////////////



class users {


///////////////Private Variables//////////////
	private $db;


//////////////Public Functions///////////////

	public function __construct($db) {

		$this->db = $db;
	}
	public function __destruct() {
        	
                
    }

	/*  getUsers
		returns array of all users in the user db
		ordered by last name
		no parameters required	*/
	public function getUsers() { 
		$result = "";
		$sql = "select users.* from users ";
		$sql .= "WHERE user_enabled='1' ";
		$sql .= "order by user_lastname";
		return  $this->db->query($sql);
	}



	public function importUsers($file,$authenticationSettings) {
		//group is User group
		$group = 2;		
		$handle = fopen($file, "r");
		$row = 0;
		$result;
		while (($data = fgetcsv($handle)) !== FALSE) {
			$user = $data[0];
			$user = trim(rtrim($user));
			$num = count($data);
			if ($user !== "") {
			
				$success = $this->addUser($user,$group,$authenticationSettings);	
				$result[$row]['user'] = $user;
				$result[$row]['success'] = $success[0];
				$result[$row]['message'] = $success[1];
			}
			else {
				$result[$row]['user'] = "Blank User";
				$result[$row]['success'] = 0;
				$result[$row]['message'] = "User account is blank and was ignored.";

			}
			$row++;


		}

		fclose($handle);
		return $result;
	}


	


	/*  alphalink
		returns link
		requires letter 		*/
	public function alphalink($letter) { 
		$safeID = mysql_real_escape_string($letter,$this->db->get_link());
		/*$link = "<a href 'edituser.php?id=" . $letter . "'>" . $letter . "</a>";*/
		$link = "<a href ='#" . $letter . "'>" . $letter . "</a>";
		return $link;
	}


	public function search($term) {
		$term = trim(rtrim($term));
		$safeTerm = mysql_real_escape_string($term,$this->db->get_link());
		$sql = "SELECT users.* FROM users WHERE users.user_enabled='1' ";
		$sql .= "AND (users.user_name LIKE '%" .$term . "%' ";
		$sql .= "OR users.user_firstname LIKE '%" . $term . "%' ";
		$sql .= "OR users.user_lastname LIKE '%" . $term . "%') ";
		$sql .= "ORDER BY user_lastname ASC";
		return $this->db->query($sql);



	}	
}
