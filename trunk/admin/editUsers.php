<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$user = new users($db);
$group = $user->getGroup($username);

if (!($group==1)){header( 'Location: invalid.php' ) ;}


	$links = "<br>";
	$letter = "a";
	for ($temp=1; $temp<27; $temp++){
		$links = $links . $user->alphalink($letter);
		$letter++;
	}
	//$links .= "</center>";
	


		$userlist = $user->getUsers();
		$resulttable = "<br><br><div id='user'><table><tr><td>";

		while($row=mysql_fetch_assoc($userlist)) {
			if(isset($row[user_name]) and ($user->userstatus($row[user_name])))
				if($username == $row[user_name]){
					$resulttable .= "<a href = 'user.php?id=" . $row[user_id] . "'>". $row[user_firstname]." ".$row[user_lastname]."</a>
							<td> " .$row[user_name]."<td>" .$row[group_name]."<tr><td>";
				}
				else {
					$resulttable .= "<a href = 'user.php?id=" . $row[user_id] . "'>". $row[user_firstname]." ".$row[user_lastname]."</a>
							<td> " .$row[user_name]."<td>" .$row[group_name]."<td>
							<input type='submit' name='edit"."$row[user_id]"."' value='edit'> "."
							<input type='submit' name='delete"."$row[user_id]"."' value='delete'> "." <tr><td>";
				}
		} 
		$resulttable .= "</div>";
		$default = $resulttable;

		$highid = $user->lastID();


		for($counter=1;$counter<=$highid;$counter++) {
  			if(isset($_POST["edit"."$counter"])) {
				$netid = $user->getUserNetID($counter);
				$resulttable = "<br><br>Change ".$netid."'s privileges to &nbsp&nbsp" . $user->dropdowngroup() . 
						 "<br><br><input type='submit' name='subedit"."$counter' value='Submit' />
						  <input type='submit' name='default' value='Cancel' />";
			}
			else if(isset($_POST["delete"."$counter"])) {				
				$netid = $user->getUserNetID($counter);
				$resulttable = "<br><br>Are you sure you want to delete ".$netid."'s account?<br>
						  <br><input type='submit' name='subdelete"."$counter' value='Yes' />&nbsp
						  <input type='submit' name='default' value='No' />";
			}
			else if(isset($_POST["subedit"."$counter"])) {	
				$group = trim(rtrim($_POST['group']));			
				$netid = $user->getUserNetID($counter);
				$user->setGroup($netid, $group);
				$resulttable = "<br><br>User privileges have been successfully changed.";
			}
			else if(isset($_POST["subdelete"."$counter"])) {
				$netid = $user->getUserNetID($counter);
				$user->disableUser($netid);
				$resulttable = "<br><br>User account has been successfully removed from the system.";
			}
			else if(isset($_POST["default"])) {
				$resulttable = $default;
			}
		}

?>

<form method='post' action='editUsers.php'>
<div id='rightside'>
	<input type='text' name='terms'>&nbsp&nbsp<input type='submit' name='search' value='Search'>
	<br>
</div>


<p class='subHeader'>Search Users</p>

<?php
	 echo $links; 
	echo $resulttable;
?>

<a name="A"></a>

</form>

<?php

include 'includes/footer.inc.php';
?>
