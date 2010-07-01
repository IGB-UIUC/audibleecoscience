<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';
include_once 'users.class.inc.php';

$user = new users($mysqlSettings);
$group = $user->getGroup($username);
if (!($group==1)){
        header('Location: invalid.php');
}



if (isset($_POST['importUsers'])) {
	$fileName = $_FILES['usersFile']['name'];
	$fileError = $_FILES['usersFile']['error'];
	$fileType = strtolower(end(explode(".",$fileName)));
	if (($fileName !== "") & ($fileError == '0') && (($fileType == 'txt') || ($fileType == 'csv'))) {
		$tmpFileLocation = $_FILES['usersFile']['tmp_name'];

		$users = new users($mysqlSettings);
		$result = $users->importUsers($tmpFileLocation,$authenticationSettings);

		$success = 0;
	        $failure = 0; 
        	
		for ($i=0;$i<count($result);$i++) {
                	if ($result[$i]['success'] == '0') {
                        	$failure++;
                	}
                	elseif ($result[$i]['success'] == '1') {
                        	$success++;
                	}
                	$resultMsg .=  "<br>" . $result[$i]['user'] . ": " . $result[$i]['message'];
        	}
				
	


	}
	elseif ($fileError !== 0) {
		$importMsg = "<b class='error'>Error uploading users file. Error: " . $uploadErrors[$fileError];

	}
	elseif (($fileName !== '') && ($fileType !== 'txt') && ($fileType !== 'csv')) {
		$importMsg = "<b class='error'>Error uploading users file. Error: File type must be .txt or .csv</b>";

	}




}

include_once 'includes/header.inc.php';

?>

<p class='subHeader'>Import Users</p>
<p>Create a txt file which lists the users netID.  One netID per line.
<form method='post' action='importUsers.php' enctype='multipart/form-data'>
<input type='hidden' name='MAX_FILE_SIZE' value='5242880'>
<br>Users File:
<br><input type='file' name='usersFile' size='40'>
<br><input type='submit' name='importUsers' value='Import Users'>
<br><?php if (isset($importMsg)) { echo $importMsg; } ?>

<?php 

if (isset($resultMsg)) {
	echo "<br>" . $success . " users successfully added.";
	echo "<br>" . $failure . " users unsuccessfully added.";
	echo $resultMsg;	




}
?>
</form>

<?php

include 'includes/footer.inc.php';
?>
