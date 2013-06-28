<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$valid_file_types = array('txt','csv');

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}


if (isset($_POST['importUsers'])) {
	$fileName = $_FILES['usersFile']['name'];
	$fileError = $_FILES['usersFile']['error'];
	$filetype = strtolower(end(explode(".",$fileName)));
	if (($fileName !== "") & ($fileError == '0') && (($filetype == 'txt') || ($fileType == 'csv'))) {
		$tmpFileLocation = $_FILES['usersFile']['tmp_name'];

		$result = import_users($db,$ldap,$tmpFileLocation);
		$message = $result['MESSAGE'];		
	


	}
	elseif ($fileError !== 0) {
		$message = "<div class='alert alert-error'>Error uploading users file. Error: ";
		$message .= $uploadErrors[$fileError] . "</div>";

	}
	elseif (($fileName !== '') && ($fileType !== 'txt') && ($fileType !== 'csv')) {
		$message = "<div class='alert alert-error'>Error uploading users file. Error: File type must be .txt or .csv</div>";

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

if (isset($result['RESULT'])) {
	echo "<div class='alert alert-success>" . $result['SUCCESS'] . " users successfully added</div>";
	echo "<div class='alert alert-failure'>" . $result['FAILURE'] . " users unsuccessfully added</div>";




}
?>
</form>

<?php

include 'includes/footer.inc.php';
?>
