<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

if (isset($_GET['username'])) {

	$user = new user($db,$ldap,$_GET['username']);	
	//Delete User
	if (isset($_POST['delete'])) {
		$result = $user->disable();
		header("Location: listUsers.php");
	}
	//Update User
	if (isset($_POST['update'])) {
		$is_admin = 0;
		if (isset($_POST['admin'])) {
			$is_admin = 1;
			$_POST['school_class'] = "";
			$_POST['section'] = "";
			$_POST['ta'] = "";
		}

		$result = $user->update($is_admin,$_POST['school_class'],$_POST['section'],$_POST['ta']);
		$message = $result['MESSAGE'];
	}
}
	



include_once 'includes/header.inc.php';
?>


<h3><?php echo $user->get_firstname() . " " . $user->get_lastname(); ?></h3>

<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $user->get_username(); ?>' 
	class='form-vertical' name='userForm'>
<br>NetID: <?php echo $user->get_username(); ?>
<br>Is Admin: <input type='checkbox' name='admin' <?php if ($user->is_admin()) { echo "checked=checked"; } ?> onClick='enableUserForm();'>
<br>Class:
<br><input type='text' name='school_class' value='<?php echo $user->get_school_class(); ?>'>
<br>Section:
<br><input type='text' name='section' value='<?php echo $user->get_section(); ?>'>
<br>TA (netID):
<br><input type='text' name='ta' value='<?php echo $user->get_ta(); ?>'>

<br>Time Added: <?php echo $user->get_time_created(); ?>
<br><input class='btn btn-primary' type='submit' name='update' value='Update User'>
<input class='btn btn-danger' type='submit' name='delete' value='Delete User' onClick='return confirmUserDelete();'>
</form>

<script type='text/javascript'>
enableUserForm();
</script>

<?php

if (isset($message)) { echo "<div class='alert'>" . $message . "</div>"; } 


include 'includes/footer.inc.php';
?>
