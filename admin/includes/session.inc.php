<?php
//////////////////////////////////////////////////
//						//
//	Leakey Podcasts				//
//	session.inc.php				//
//						//
//	Used to verify the user is		// 
//	logged in before proceeding		//
//						//
//	David Slater				//
//	May 2009				//
//						//
//////////////////////////////////////////////////

include_once 'main.inc.php';
$session = new session(__SESSION_NAME__);

//If not logged in
if (!($session->get_var('login'))) {
	header('Location: logout.php');
}
//If session timeout is reach
elseif (time() > $session->get_var('timeout') + __SESSION_TIMEOUT__) {
        header('Location: logout.php');
}
//If IP address is different
elseif ($_SERVER['REMOTE_ADDR'] != $session->get_var('ipaddress')) {
        header('Location: logout.php');
}

else {
	$login_user = new user($db,$ldap,$session->get_var('username'));	
	//Reset Timeout
	$session_vars = array('timeout'=>time());
	$session->set_session($session_vars);
}
	
?>
