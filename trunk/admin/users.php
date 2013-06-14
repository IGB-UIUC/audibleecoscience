<?php 
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';

$user = new users($db);

$group = $user->getGroup($username);
if (!($group==1)){header( 'Location: invalid.php' ) ;}

 


?>

<h3>Users</h3>
<p><a href='addUser.php'>Add User Account<br></a></p>
<p><a href='listUsers.php'>List All Accounts<br></a></p>
<p><a href='editUsers.php'>Edit User Accounts<br></a></p>


<?php include_once 'includes/footer.inc.php'; ?>
