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
session_start();
if (($_SESSION['login']) == 1) {
	
	$username = $_SESSION['username'];
}
else {
	session_start();
	$_SESSION['webpage'] = $_SERVER['REQUEST_URI'];
	header('Location: ../login.php');
	exit;
	
}
	
?>
