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

//set_include_path('libs');
//include 'authentication.inc.php';
//include 'includes/settings.inc.php';
//session_start();
include_once 'includes/main.inc.php';
include_once 'authentication.inc.php';

session_start();
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
	
	$success = authenticate($username,$password,$authenticationSettings,$db);
	if ($success == "1") {
		
		session_destroy();
		session_start();

		$_SESSION['login'] = 1;		
		$_SESSION['username'] = $username;

		$location = "http://" . $_SERVER['SERVER_NAME'] . $webpage;
		header("Location: " . $location);
	}
	else {//if ($success != "1") {
	
		$loginMsg = "<div id='error'><b class='error'>Invalid Login</b></div>";
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
<div class='row span4 offset3'>
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
<?php if (isset($loginMsg)) { echo $loginMsg; } ?>
<?php

include 'includes/footer.inc.php';
?>
