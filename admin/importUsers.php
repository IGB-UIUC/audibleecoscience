<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$user = new user($db,$ldap,$username);
$admin = $user->is_admin();

if (!($admin)){
        header('Location: invalid.php');
}



if (isset($_POST['importUsers'])) {
	$fileName = $_FILES['usersFile']['name'];
	$fileError = $_FILES['usersFile']['error'];
	$fileType = strtolower(end(explode(".",$fileName)));
	if (($fileName !== "") & ($fileError == '0') && (($fileType == 'txt') || ($fileType == 'csv'))) {
		$tmpFileLocation = $_FILES['usersFile']['tmp_name'];

		$users = new users($db);
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

elseif (isset($_POST['cancel'])) {
	unset($_POST);


}

include_once 'includes/header.inc.php';

?>

<h3>Import Users</h3>
<p>Create a text file which lists the users netID.  One netID per line.
<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
<input type='hidden' name='MAX_FILE_SIZE' value='5242880'>
<br>Users File:
<br><input class='btn btn-file' type='file' name='usersFile' size='40'>
<p><input class='btn btn-primary' type='submit' name='importUsers' value='Import Users'>
<input class='btn btn-warning' type='submit' name='cancel' value='Cancel'></p>
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
