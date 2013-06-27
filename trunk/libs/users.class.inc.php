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


include_once 'db.class.inc.php';

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
		$sql = "select users.*, groups.* from users ";
		$sql .= "inner join groups on users.user_groupsid = groups.group_id ";
		$sql .= "WHERE user_enabled='1' ";
		$sql .= "order by user_lastname";
		return  $this->db->query($sql);
	}

	/*  getUserInfo
		returns array with one user's information
		user_id required	*/
	public function getUserInfo($id) { 
		$result = "";
		$sql = "select users.*, groups.* from users inner join groups 
			on users.user_groupsid = groups.group_id 
			where users.user_id = " . $id . " LIMIT 0,1";
		return  $this->db->query($sql);
	}

	/*  userExists
		returns 1 if user exists in the db
		both enabled and disabled users are considered
		(to check for enabled user see userstatus function)
		requires netid		*/
	public function userExists($username) {
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
              	$sql = "SELECT count(1) as count from users WHERE user_name='" . $safeUser . "'";			 
		$result = $this->db->query($sql);
		if ($result[0]['count']) {
			return true;
		}
		else {
			return false;
		}

	
	}


	/*  addUser
		checks to see if given user/netid exists in Active Directory
		adds user if true, else does not
		returns $Msg indicating if user has AD account or not
		requires netid, level of privilege, and authentication settings		*/
	public function addUser($netid, $admin, $authenticationSettings) {
		$success = '0';
			//check if user exists first......
		$safeNetID = mysql_real_escape_string($netid,$this->db->get_link());
		$exist = $this->userExists($safeNetID);

			//if user doesnt exists
		if (!$exist) { 
				//and netid is not blank
			if ($safeNetID == "") {
				$Msg = "Please enter a netID.";
			}
			else {	//then add
				
				$ldaphost = $authenticationSettings['host'];
				$baseDN = $authenticationSettings['baseDN'];	
				$peopleOU = $authenticationSettings['peopleOU'] . "," . $baseDN;
				$ssl = $authenticationSettings['ssl'];
				$bind_user = $authenticationSettings['bind_user'];
				$bind_pass = $authenticationSettings['bind_pass'];

				$connect;

				if ($ssl == 1) {
					$connect = ldap_connect("ldaps://" . $ldaphost,$port);
				}
				elseif ($ssl == 0) {
					$connect = ldap_connect("ldap://" . $ldaphost,$port);
				}

				ldap_bind($connect,$bind_user,$bind_pass);
				$ldap_result = ldap_search($connect,$peopleOU,"(CN=$netid)", array("sn","givenname"));
	
				$result = ldap_get_entries($connect,$ldap_result);

				$first = $result[0]['givenname'][0];
				$last = $result[0]['sn'][0];

				$sql = "INSERT into users (user_firstname, user_lastname, user_name, user_groupsId) 
					 VALUES ('" . $first . "','" . $last . "','" . $safeNetID ."','" . $admin ."')";
	
				if($result[count]){ 
					$this->db->non_select_query($sql); 
					$success = '1';
					$Msg = "User Account has successfully been created.";
				}
				else{
					$Msg = "User does not have an Active Directory account.";
				}
			}

		}
		else {
			$enabled = $this->userStatus($safeNetID);

			if (!$enabled){
				$this->enableUser($safeNetID);
				$success = '1';
				$Msg = "User Account has successfully been created.";
				$this->setGroup($safeNetID,$admin);
			}
			else {
				$Msg = "User account already exists!"; 			}
		}
		$array = array($success, $Msg);
		return $array;
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
	public function getGroup($username) {
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
		$sql = "Select user_groupsID from users WHERE user_name = '" . $safeUser . "' LIMIT 1";
		$result = $this->db->query($sql); //return 1 for admin
		return $result[0]['user_groupsID'];
		
	}

	public function lastID() {
		$sql = "Select max(user_ID) as max from users";
		$result = $this->db->query($sql); //return 1 for admin
		return $result[0]['max'];
		
	}

	/* userStatus
		returns 1 if enabled
		returns 0 if disabled 
		requires netid         	*/
	public function userStatus($username) {
		//$result = $this->userExists($username);
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
		$sql = "SELECT user_enabled FROM users WHERE user_name = '" . $safeUser . "' LIMIT 1";
		$result = $this->db->query($sql); 	
		return $result[0]['user_enabled'];
	}
	
	
	public function setGroup($username, $group_id) { //dunno if i wanna do this a different way...
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
			$sql = "UPDATE users SET user_groupsId ='" . $group_id . "' WHERE user_name = '" . $safeUser . "'";
		$result = $this->db->non_select_query($sql);
		//return?
	}

	public function getGroups() { 
		$sql = "SELECT group_id, group_name FROM groups WHERE group_enabled='1' ORDER BY group_id";
		$result = $this->db->query($sql);
		return $result;
	}

	/*  enableUser
		enables a previously created user account 
		requires netid  		*/
	public function enableUser($username) { 
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
			$sql = "UPDATE users SET user_enabled = '1' WHERE user_name = '" . $safeUser . "'";
		$result = $this->db->non_select_query($sql);
		//return $result;
	}
	
	/*  disableUser
		disables user 
		alternative to deleting account
		requires netid 		*/
	public function disableUser($username) { 
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
		$sql = "UPDATE users SET user_enabled = '0' WHERE user_name = '" . $safeUser . "'";
		$result = $this->db->non_select_query($sql);
		return $result;
	}

	/*  getUserID
		returns user_id (primary key) given the netid
		requires netid		*/
	public function getUserID($username) { 
		$safeUser = mysql_real_escape_string($username,$this->db->get_link());
		$sql = "Select user_id from users WHERE user_name = '" . $safeUser . "' LIMIT 1";
		$result = $this->db->query($sql);
		return $result[0]['user_id'];
	}
		
	/*  getUserNetID
		returns user's netid given their user_id
		requires user_id 		*/
	public function getUserNetID($userid) { 
		$safeID = mysql_real_escape_string($userid,$this->db->get_link());
		$sql = "Select user_name from users WHERE user_id = '" . $safeID . "' LIMIT 1";
		$result = $this->db->query($sql);
		return $result[0]['user_name'];
	}

	public function dropdowngroup(){
		$grouplist = $this->getGroups();
		$result = "<select name='group'>";
		foreach ($grouplist as &$value) {
			$result .= "<option value=".$value['group_id'].">".$value['group_name']."</option>";
		}
		$result .= "</select>";
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
