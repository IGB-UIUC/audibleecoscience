<?php
//////////////////////////////////////////
//					//
//	logout.php			//
//					//
//	Logs user out			//
//					//
//	By: David Slater		//
//	Date: May 2009			//
//					//
//////////////////////////////////////////

include 'includes/session.inc.php';
session_destroy();
header("Location: ../login.php")

?>
