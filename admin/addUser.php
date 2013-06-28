<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}


if (isset($_POST['add_user'])) {
	$admin = 0;
	if (isset($_POST['admin'])) { 
		$admin = $_POST['admin'];
	}

	$user = new user($db,$ldap,$_POST['username']);
	$result = $user->add($admin);

	if ($result['RESULT']) {
		unset($_POST);
		header('Location: listUsers.php');
	}
	$messages = $result['MESSAGE'];

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

if (isset($messages)) {
	foreach ($messages as $message) {
		echo "<div class='alert error'>" . $message . "</div>";
	}
}
include 'includes/footer.inc.php';
?>
