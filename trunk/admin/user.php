<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

$user = new user($db,$ldap,$username);
$admin = $user->is_admin();
if (!($admin)){
        header('Location: invalid.php');
}

if (isset($_GET['username'])) {

	$selected_user = new user($db,$ldap,$_GET['username']);	
	//Delete User
	if (isset($_POST['delete'])) {
		$result = $selected_user->disable();
		header("Location: listUsers.php");
	}
	//Update admin flag
	if (isset($_POST['update'])) {
		$is_admin = 0;
		if (isset($_POST['admin'])) {
			$is_admin = 1;
		}
		if ($selected_user->set_admin($is_admin)) {
			$msg = "<b class='msg'>Administrator membership successfully changed.</b>";
		}

	}
}
	



include_once 'includes/header.inc.php';
?>


<h3><?php echo $selected_user->get_firstname() . " " . $selected_user->get_lastname(); ?></h3>

<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $selected_user->get_username(); ?>' 
	class='form-vertical'>
<br>NetID: <?php echo $selected_user->get_username(); ?>
<br>Time Added: <?php echo $selected_user->get_time_created(); ?>
<br>Is Admin:
<input type='checkbox' name='admin' <?php if ($selected_user->is_admin()) { echo "checked=checked"; } ?>>
<br><input class='btn btn-primary' type='submit' name='update' value='Update User'>
<input class='btn btn-danger' type='submit' name='delete' value='Delete User' onClick='return confirmUserDelete();'>
</form>



<?php

if (isset($msg)) { echo $msg; } 


include 'includes/footer.inc.php';
?>
