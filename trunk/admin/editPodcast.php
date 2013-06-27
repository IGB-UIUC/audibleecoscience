<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

$user = new users($db);
$group = $user->getGroup($username);
$uploadErrors = array(
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
    3 => 'The uploaded file was only partially uploaded.',
    4 => 'No file was uploaded.',
    6 => 'Missing a temporary folder.',
    7 => 'Failed to write file to disk.',
    8 => 'File upload stopped by extension.',
);

$users = new users($db);
if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
	$id = $_GET['id'];
	$podcast = new podcast($id,$db);
	$category_id = $podcast->getCategoryId();
	$source = $podcast->getSource();
	$programName = $podcast->getProgramName();
	$showName = $podcast->getShowName();
	$year = $podcast->getBroadcastYear();
	$url = $podcast->getUrl();
	$summary = $podcast->getSummary();
	$createdBy = $podcast->getCreatedBy();
	$ip = $podcast->getIPAddress();
	$time = $podcast->getUploadTime();
	$approved = $podcast->getApproved();
	$approvedBy = $podcast->getApprovedBy();
}

if (isset($_POST['removePodcast'])) {

	$podcast->remove();
	$success = "<b class='msg'>Podcast has been successfully removed";
}
elseif (isset($_POST['approvePodcast'])) {
	$users = new users($db);
	$user_id = $users->getUserID($username);
	$users->__destruct();
	$podcast->approve($user_id);
	$approved = $podcast->getApproved();
	$approvedBy = $podcast->getApprovedBy();
	$success = "<b class='msg'>Podcast has been approved</b>";

}

elseif (isset($_POST['unapprovePodcast'])) {

	$podcast->unapprove();
	$approved = $podcast->getApproved();
	$approvedBy = $podcast->getApprovedBy();
	$success = "<b class='msg'>Podcast has been unapproved</b>";


}
elseif (isset($_POST['editPodcast'])) {
	$source = $_POST['source'];
	$programName = $_POST['programName'];
	$showName = $_POST['showName'];
	$year = $_POST['year'];
	$url = $_POST['url'];
	$summary = $_POST['summary'];
	$category = $_POST['category'];
	
	$source = trim(rtrim($source));
	$programName = trim(rtrim($programName));
	$showName = trim(rtrim($showName));
	$year = trim(rtrim($year));
	$url = trim(rtrim($url));
	$summary = trim(rtrim($summary));
	$error = 0;
	if ($source == "") {
		$error++;
		$sourceMsg = "<b class='error'>Please fill in the source</b>";
	}
	if ($programName == "") {
		$error++;
		$programMsg = "<b class='error'>Please fill in the program name</b>";
	}
	if ($showName == "") {
		$error++;
		$showMsg = "<b class='error'>Please fill in the show name</b>";
	}	

	if (($year == "") || (!is_numeric($year))) {
		$error++;
		$yearMsg = "<b class='error'>Please fill in the broadcast year</b>";
	}
	if ($url == "") {
		$error++;
		$urlMsg = "<b class='error'>Please fill in the original web address</b>";

	}
	if ($summary == "") {
		$error++;
		$summaryMsg = "<b class='error'>Please enter a summary</b>";

	}

	
	if ($error == 0) {
		$podcast = new podcast($id,$db);
		$podcast->setSource($source);
		$podcast->setProgramName($programName);
		$podcast->setShowName($showName);
		$podcast->setBroadcastYear($year);
		$podcast->setUrl($url);
		$podcast->setCategory($category);
		$podcast->setSummary($summary);	

		$success = "<b class='msg'>Podcast successfully updated.</b";
	}

}

elseif (isset($_POST['cancel'])) {
	unset($_POST);

}



$categories = new categories($db);

$categoryList = $categories->getCategories();
$categoriesHtml = "";
for ($i=0;$i<count($categoryList);$i++) {
	$categoryList_id = $categoryList[$i]['category_id'];
	$categoryList_name = $categoryList[$i]['category_name'];

	if ($categoryList_id == $category_id) {
		$categoriesHtml .= "<option selected value='" . $categoryList_id . "'>" . $categoryList_name . "</option>";
	}
	else {
		$categoriesHtml .= "<option value='" . $categoryList_id . "'>" . $categoryList_name . "</option>";
	}



}


include_once 'includes/header.inc.php';
?>


<?php
if (isset($success)) { 
	echo $success; 
} 
else {

?>

<form method='post' enctype='multipart/form-data' action='editPodcast.php?id=<?php echo $id; ?>'>
<input type='hidden' name='MAX_FILE_SIZE' value='134217728000'>
<input type='hidden' name='id' value='<?php echo $id; ?>'>
<br>Media Source: <?php if (isset($sourceMsg)) { echo $sourceMsg; } ?> 
<br><input type='text' name='source' size='40' value='<?php echo $source; ?>'>
<br>Program Name: <?php if (isset($programMsg)) { echo $programMsg; } ?>
<br><input type='text' name='programName' size='40' value='<?php echo $programName; ?>'>
<br>Show Name: <?php if (isset($showMsg)) { echo $showMsg; } ?>
<br><input type='text' name='showName' size='40' value='<?php echo $showName; ?>'>
<br>Broadcast Year: <?php if (isset($yearMsg)) { echo $yearMsg; } ?>
<br><input type='text' name='year' size='4' maxlength='4' value='<?php echo $year; ?>'>
<br>URL: <?php if (isset($urlMsg)) { echo $urlMsg; } ?>
<br><input type='text' name='url' size='40' value='<?php echo $url; ?>'>
<br>Summary: <?php if (isset($summaryMsg)) { echo $summaryMsg; } ?>
<br><textarea name='summary' rows='10' cols='60'><?php echo $summary; ?></textarea>
<br>Category: <?php if (isset($categoryMsg)) { echo $categoryMsg; } ?>
<br><select name='category'>
<?php echo $categoriesHtml; ?>
</select>
<br><input class='btn btn-primary' type='submit' name='editPodcast' value='Edit Podcast'>
<input class='btn btn-warning' type='submit' name='cancel' value='Cancel'>

<?php

if ($users->getGroup($username) == 1) {
	echo "<br>Created By: " . $createdBy;
	echo "<br>IP Address: " . $ip;
	echo "<br>Time Uploaded: " . $time;
	if ($approved == 1) {
		echo "<br>Approved By: " . $approvedBy;
		echo "<br><input class='btn btn-primary' type='submit' name='unapprovePodcast' value='Unapprove Podcast' onClick='return confirmUnapprove()'>";
	}
	elseif ($approved == 0) {
		echo "<br><input class='btn btn-primary' type='submit' name='approvePodcast' value='Approve Podcast' onClick='return confirmApprove()'>";
	}
}

?>

<p><input class='btn btn-danger' type='submit' name='removePodcast' value='Remove Podcast' onClick='return confirmRemove()'></p>
</form>


<?php
}

include 'includes/footer.inc.php';
?>
