<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'authentication.inc.php';

$user = new user($db,$ldap,$username);
$admin = $user->is_admin();

if (!($admin)){
        header('Location: invalid.php');
}


if (isset($_POST['add_user'])) {
	$admin = 0;
	if (isset($_POST['admin'])) { 
		$admin = $_POST['admin'];
	}

	$add_user = new user($db,$ldap);
	$result = $user->add($_POST['username'], $admin);

	if ($result['RESULT']) {
		unset($_POST);
		header('Location: listUsers.php');
	}
	$message = $result['MESSAGE'];

}
elseif (isset($_POST['cancel'])) {
	unset($_POST);
	
}

include_once 'includes/header.inc.php';
?>
<h3>Add User Form</h3>
<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' class='form-vertical'>

<br>NetID: 
<br><input type='text' name='username' value='<?php if (isset($_POST['username'])) { echo $_POST['username']; } ?>'>
<br>Is Admin: 
<br><input type='checkbox' name='admin'>
<br><input class='btn' type='submit' name='add_user' value='Add User'>
<input class='btn' type='submit' name='cancel' value='Cancel'>
</form>



<?php

if (isset($msg)) {
	echo $msg;

}
include 'includes/footer.inc.php';
?>
