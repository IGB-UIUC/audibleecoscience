<?php
//////////////////////////////////////////////////
//						//
//	Leakey Podcasts				//
//	login.php				//
//						//
//	Logges in the admin users so 		//
//	they can view orders and download	//
//	the poster files			//
//						//
//	David Slater				//
//	May 2009				//
//						//
//////////////////////////////////////////////////

require_once 'includes/main.inc.php';

$session = new session(__SESSION_NAME__);
if (isset($_SESSION['webpage'])) {
	$webpage = $_SESSION['webpage'];
}
else {
	$dir = dirname($_SERVER['PHP_SELF']);
	$webpage = $dir . "/admin/index.php";
}

if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$ldap = new ldap(__LDAP_HOST__,__LDAP_SSL__,__LDAP_PORT__,__LDAP_BASE_DN__);
	$ldap->bind(__LDAP_BIND_USER__,__LDAP_BIND_PASS__);
	$user = new user($db,$ldap,$username);	
	$success = $user->authenticate($password);
	if ($success) {
		
		$session_vars = array('login'=>true,
			'username'=>$username,
			'timeout'=>time(),
			'ipaddress'=>$_SERVER['REMOTE_ADDR']
		);
		$session->set_session($session_vars);


		$location = "https://" . $_SERVER['SERVER_NAME'] . $webpage;
		header("Location: " . $location);
	}
	else {//if ($success != "1") {
	
		$message = "<div class='alert alert-error'>Invalid Login</div>";
		//echo $success;
	
	}
	
}

//Hit Cancel Button - Redirects to logout.php
elseif (isset($_POST['cancel'])) {
        unset($_POST);
        header('Location: index.php');


}



include 'includes/header.inc.php';

?>
<BODY OnLoad="document.login.username.focus();">


<h3>Login</h3>
<div class='row span3 offset3'>
<form action='login.php' method='post' name='login' class='form-vertical'>
	<br>NetID:
	<br><input type='text' name='username' tabindex='1'>
	<br>Active Directory (AD)  Password:
	<br><input type='password' name='password' tabindex='2'>
	<br><a href='https://passwords.cites.uiuc.edu'>Forgot Password</a>
	<br><input class='btn' type='submit' value='Login' name='login'>
	<button type='submit' name='cancel' class='btn'>Cancel</button>

</form>
</div>
<div class='row span9'>
<?php if (isset($message)) { echo $message; } ?>
</div>
<?php

include 'includes/footer.inc.php';
?>
