<?php
class user {


	///////////////Private Variables//////////////
        private $db;
	private $ldap;
	private $user_id;
	private $username;
	private $firstname;
	private $lastname;
	private $admin;
	private $enabled;
	private $time_created;
	//////////////Public Functions///////////////

        public function __construct($db,$ldap,$username = "") {

                $this->db = $db;
		$this->ldap = $ldap;
		if ($username != "") {
			$this->username = $username;
			$this->get_user();
		}

        }


        public function __destruct() {
        }

	public function add($username,$admin) {
		$filter = "(CN=" . $username . ")";
		$attributes = array('sn','givenname');
		$result = $this->ldap->search($filter,$ou,$attributes);

		$firstname = $result[0]['givenname'][0];
		$lastlast = $result[0]['sn'][0];

		$insert_array = array('user_firstname'=>$firstname,
				'user_lastname'=>$lastname,
				'user_name'=>$username,
				'user_admin'=>$admin);
		$result = $this->db->build_insert("users",$insert_array);
		return $result;
	}
	public function get_user_id() { return $this->user_id; }
	public function get_username() { return $this->username; }
	public function get_firstname() { return $this->firstname; }
	public function get_lastname() { return $this->lastname; }
	public function is_admin() { return $this->admin; }
	public function is_enabled() { return $this->enabled; }	
	public function get_time_created() { return $this->time_created; }
	public function authenticate($password) {
		$result = false;
		$rdn = $this->get_user_rdn();
		if (($this->ldap->bind($rdn,$password)) && ($this->is_enabled())) {
			$result = true;

		}
		return $result;
	}

	public function get_user_rdn() {
		$filter = "(CN=" . $this->get_username() . ")";
		$attributes = array('dn');
                $result = $this->ldap->search($filter,'',$attributes);
                if (isset($result[0]['dn'])) {
                        return $result[0]['dn'];
                }
                else {
                        return false;
                }
        }

	public function set_admin($admin) {
		$sql = "UPDATE users SET user_admin='" . $admin . "' ";
		$sql .= "WHERE user_id='" . $this->get_user_id() . "' LIMIT 1";
		$result = $this->db->non_select_query($sql);
		$this->get_user();
		return $result;

	}

	public function disable() {
		$sql = "UPDATE users SET user_enabled='0' ";
		$sql .= "WHERE user_id='" . $this->get_user_id() . "' LIMIT 1";
		                $result = $this->db->non_select_query($sql);
                $this->get_user();
                return $result;


	}

        public function enable() {
                $sql = "UPDATE users SET user_enabled='1' ";
                $sql .= "WHERE user_id='" . $this->get_user_id() . "' LIMIT 1";
                                $result = $this->db->non_select_query($sql);
                $this->get_user();
                return $result;


        }

	/////////////////////Private Functions/////////////


	private function get_user() {
		$sql = "SELECT * FROM users WHERE user_name='" . $this->username . "' LIMIT 1";
		$result = $this->db->query($sql);
		if (count($result)) {
			$this->user_id = $result[0]['user_id'];
			$this->firstname = $result[0]['user_firstname'];
			$this->lastname = $result[0]['user_lastname'];
			$this->admin = $result[0]['user_admin'];
			$this->enabled = $result[0]['user_enabled'];
			$this->time_created = $result[0]['user_time_created'];

		}

	}


}

?>
