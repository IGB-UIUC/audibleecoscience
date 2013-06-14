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


include_once 'includes/header.inc.php';
?>

<form method='post' enctype='multipart/form-data' action='addUser.php'>
<p class='subHeader'>Add User Form</p>

<br>NetID: 
<br><input type='text' name='netid' value='<?php if (isset($netid)) { echo $netid; } ?>'>
<br>Group Privileges: 
<br>
<?php echo $list; ?>
<br><input type='submit' name='addUser' value='Add User'>
</form>



<?php

if (isset($msg)) {
	echo $msg;

}
include 'includes/footer.inc.php';
?>
