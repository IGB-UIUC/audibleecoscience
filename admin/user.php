<?php
include_once 'includes/main.inc.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	$user = new users($db);

	//Sets current users information
	$userInfo = $user->getUserInfo($id);
	$user_name = $userInfo[0]['user_name'];
	$first_name = $userInfo[0]['user_firstname'];
	$last_name = $userInfo[0]['user_lastname'];
	$group_name = $userInfo[0]['group_name'];
	$user_groupId = $userInfo[0]['user_groupsId'];
	
	//Delete User
	if (isset($_POST['delete'])) {
		$result = $user->disableUser($user_name);
		header("Location: listUsers.php");
	}
	//Change Group Membership
	if (isset($_POST['changeGroup'])) {
		$group_id = $_POST['group_id'];
		$user->setGroup($user_name,$group_id);
		$msg = "<b class='msg'>Group membership successfully changed.</b>";


	}
	
	//Gets possible groups and makes a combo box for them with current group selected
	$groups = $user->getGroups();
	$groupHtml;
	for ($i=0;$i<count($groups);$i++) {
		$group_id = $groups[$i]['group_id'];
		$group_name = $groups[$i]['group_name'];
		
		if ($user_groupId == $group_id) {
			$groupHtml .= "<option value='" . $group_id . "' selected='selected'>" . $group_name . "</option>";

		}
		elseif ($user_groupId != $group_id) {
			$groupHtml .= "<option value='" . $group_id . "'>" . $group_name . "</option>"; 
		}



	}

}

include_once 'includes/header.inc.php';
?>

<script language='JavaScript' src='includes/user.js'></script>

<h3><?php echo $first_name . " " . $last_name; ?></h3>

<form method='post' action='user.php?id=<?php echo $id; ?>' class='form-vertical'>
<input type='hidden' name='id' value='<?php echo $id; ?>'>
<br>NetID: <?php echo $user_name; ?>
<br>Group: <select name='group_id'>

<?php echo $groupHtml; ?>
</select>
<br><input class='btn' type='submit' name='changeGroup' value='Change Group' onClick='return confirmChangeGroup();'>
<input class='btn' type='submit' name='delete' value='Delete User' onClick='return confirmUserDelete();'>
</form>



<?php

if (isset($msg)) { echo $msg; } 


include 'includes/footer.inc.php';
?>
