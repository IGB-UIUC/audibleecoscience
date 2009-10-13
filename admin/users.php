<?php 
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';
include_once 'users.class.inc.php';

$user = new users($mysqlSettings);

$group = $user->getGroup($username);
if (!($group==1)){header( 'Location: invalid.php' ) ;}

 
$body = "<div id='main'><br>
	<a href='addUser.php'>{ Add User Account }<br></a>
	<a href='listUsers.php'>{ List All Accounts }<br></a>
	<a href='editUsers.php'>{ Edit User Accounts }<br></a>
	</div>";


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="includes/styles.css">
<br>

<?php echo $body ?>

</html>

<?php

include 'includes/footer.inc.php';
?>
