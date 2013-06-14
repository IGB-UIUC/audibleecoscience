<?php
include_once 'includes/main.inc.php';
include_once 'authentication.inc.php';

$user = new users($db);
$group = $user->getGroup($username);
if (!($group==1)){
        header('Location: invalid.php');
}

$list = $user->dropdowngroup();




if (isset($_POST['addUser'])) {
	$netid = trim(rtrim($_POST['netid']));
	$group = trim(rtrim($_POST['group']));


	
	$result = $user->addUser($netid, $group, $authenticationSettings);

	if ($result[0] == 1) {
		$netid = "";

	}
	$msg = "<b class='error'>" . $result[1] . "</b>";
	$netid = "";
}

elseif (isset($_POST['cancel'])) {
	unset($_POST);
}

include_once 'includes/header.inc.php';
?>
<h3>Add User Form</h3>
<form method='post' enctype='multipart/form-data' action='addUser.php'>

<br>NetID: 
<br><input type='text' name='netid' value='<?php if (isset($netid)) { echo $netid; } ?>'>
<br>Group Privileges: 
<br>
<?php echo $list; ?>
<br><input class='btn' type='submit' name='addUser' value='Add User'>
<input class='btn' type='submit' name='cancel' value='Cancel'>
</form>



<?php

if (isset($msg)) {
	echo $msg;

}
include 'includes/footer.inc.php';
?>
