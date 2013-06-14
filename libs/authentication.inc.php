<?php
//////////////////////////////////////////////////
//						//
//	Leakey Podcasts				//
//	authentication.inc.php			//
//						//
//	Functions to verify IGB users		//
//						//
//	David Slater				//
//	May 2009				//
//						//
//////////////////////////////////////////////////


include_once 'users.class.inc.php';

function authenticate($username,$password,$authenticationSettings,$db) {

	$ldaphost = $authenticationSettings['host'];
	$baseDN = $authenticationSettings['baseDN'];	
	$peopleDN = $authenticationSettings['peopleOU'] . "," . $baseDN;
	$ssl = $authenticationSettings['ssl'];
	$port = $authenticationSettings['port'];
	$connect;

	$users = new users($db);
	
	if ($ssl == 1) {
		$connect = ldap_connect("ldaps://" . $ldaphost,$port);
	}
	elseif ($ssl == 0) {
		$connect = ldap_connect("ldap://" . $ldaphost,$port);
	}

	ldap_start_tls($connect);

	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
		
	$bindDN = "cn=" . $username . "," . $peopleDN;

	$success = 0;

	if (@ldap_bind($connect, $bindDN, $password)) { //search in users table

		$exist = $users->userexists($username);
		if($exist)
			$exist = $users->userstatus($username);
		$success = $exist ;
		
	}
	return $success;
	
}



?>
