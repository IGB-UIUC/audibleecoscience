<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}


if (isset($_POST['add_user'])) {
	$admin = 0;
	if (isset($_POST['admin'])) { 
		$admin = 1;
	}

	$user = new user($db,$ldap,$_POST['username']);
	if ($admin) {
		$result = $user->add($admin);
	}
	else {
		$result = $user->add($admin,$_POST['school_class'],$_POST['section'],$_POST['ta']);
	}

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
<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' class='form-vertical' name='addUserForm'>

<br>NetID: 
<br><input type='text' name='username' value='<?php if (isset($_POST['username'])) { echo $_POST['username']; } ?>'>
<br>Is Admin:
<br><input type='checkbox' name='admin' onClick='enableUserForm();'>
<br>Class:
<br><input type='text' name='school_class' value='<?php if (isset($_POST['school_class'])) { echo $_POST['school_class']; } ?>'>
<br>Section:
<br><input type='text' name='section' value='<?php if (isset($_POST['section'])) { echo $_POST['section']; } ?>'>
<br>TA (netID):
<br><input type='text' name='ta' value='<?php if (isset($_POST['ta'])) { echo $_POST['ta']; } ?>'>
<br><input class='btn btn-primary' type='submit' name='add_user' value='Add User'>
<input class='btn btn-warning' type='submit' name='cancel' value='Cancel'>
</form>



<?php

if (isset($messages)) {
	foreach ($messages as $message) {
		echo "<div class='alert error'>" . $message . "</div>";
	}
}
include 'includes/footer.inc.php';
?>
