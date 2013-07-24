<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';


if (isset($_POST['addPodcast'])) {
	foreach ($_POST as $var) {
		$var = trim(rtrim($var));
	}
	$source = $_POST['source'];
	$programName = $_POST['programName'];
	$showName = $_POST['showName'];
	$year = $_POST['year'];
	$url = $_POST['url'];
	$summary = $_POST['summary'];
	$category = $_POST['category'];
	$short_summary = $_POST['short_summary'];
	$acknowledgement = false;
	if (isset($_POST['acknowledgement'])) {
		$acknowledgement = true;
	}
	$review_permission = false;
	if (isset($_POST['review_permission'])) {
		$review_permission = true;
	}

	if (isset($_POST['upload_file'])) {
		$filename = $_FILES['file']['name'];
		$tmpFile = $_FILES['file']['tmp_name'];
		$fileError = $_FILES['file']['error'];
		$allowed_file_types = explode(",",__FILETYPES__);
		$filetype = strtolower(end(explode(".",$filename)));
	}
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
	if ($short_summary == "") {
		$error++;
		$short_summary_msg = "<div class='alert'>Please enter a short summary</div>";

	}
	if (!in_array($filetype,$allowed_file_types) && isset($_POST['upload_file'])) {
		$error++;
		$fileMsg = "<b class='error'>Invalid filetype.</b>";

	}

	if (($fileError != 0) && isset($_POST['upload_file'])){
		$error++;
		$fileMsg = "<b class='error'>" . $uploadErrors[$fileError] . "</b>";
	}	
	
	if ($error == 0) {

		$id = addPodcast($db);
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$podcast = new podcast($id,$db);
		$podcast->setSource($source);
		$podcast->setProgramName($programName);
		$podcast->setShowName($showName);
		$podcast->setBroadcastYear($year);
		$podcast->setUrl($url);
		$podcast->setCategory($category);
		$podcast->setSummary($summary);
		$podcast->setShortSummary($short_summary);	
		$podcast->setIPAddress($ipAddress);
		$podcast->setCreatedBy($login_user->get_user_id());
		$podcast->setReviewPermission($review_permission);
		$podcast->setAcknowledgement($acknowledgement);
		if (isset($_POST['upload_file'])) {
			$podcast->uploadPodcast($filename,$tmpFile,__PODCAST_DIR__);		
		}

		$message = "<b class='msg'>Podcast successfully submitted";
		$source = "";
		$programName = "";
		$showName = "";
		$year = "";
		$url = "";
		$summary = "";
		$short_summary = "";	
	}



}

//Hit Cancel button.  Clears form
elseif (isset($_POST['cancel'])) {
	unset($_POST);
}

$categories = new categories($db);

$categoryList = $categories->getCategories();
$categoriesHtml = "";
for ($i=0;$i<count($categoryList);$i++) {
	$category_id = $categoryList[$i]['category_id'];
	$category_name = $categoryList[$i]['category_name'];
	$categoriesHtml .= "<option value='" . $category_id . "'>" . $category_name . "</option>";
	



}

include_once 'includes/header.inc.php';
?>

<h3>Add Podcast</h3>
<form method='post' enctype='multipart/form-data' action='<?php echo $_SERVER['PHP_SELF']; ?>' name='addPodcastForm'>
<input type='hidden' name='MAX_FILE_SIZE' value='<?php echo get_max_upload_size('bytes'); ?>'>
<br>Media Source: <?php if (isset($sourceMsg)) { echo $sourceMsg; } ?> 
<br><input class='input-xlarge' type='text' name='source' maxlength='100' value='<?php if (isset($source)) { echo $source; } ?>'>
<br>Program Name: <?php if (isset($programMsg)) { echo $programMsg; } ?>
<br><input class='input-xlarge' type='text' name='programName' maxlength='100' value='<?php if (isset($programName)) { echo $programName; } ?>'>
<br>Show Name: <?php if (isset($showMsg)) { echo $showMsg; } ?>
<br><input class='input-xlarge' type='text' name='showName' maxlength='100' value='<?php if (isset($showName)) { echo $showName; }?>'>
<br>Broadcast Year: <?php if (isset($yearMsg)) { echo $yearMsg; } ?>
<br><input class='input-xlarge' type='text' name='year' maxlength='4' value='<?php if (isset($year)) { echo $year; } ?>'>
<br>URL: <?php if (isset($urlMsg)) { echo $urlMsg; } ?>
<br><input class='input-xlarge' type='text' name='url' maxlength='100' value='<?php if (isset($url)) { echo $url; } ?>'>
<br>Short Summary (Max 200 Characters): <?php if (isset($short_summary_msg)) { echo $short_summary_msg; } ?>
<br><textarea name='short_summary' rows='2' spellcheck='true' class='filed span7'>
<?php if (isset($short_summary)) { echo $short_summary; } ?></textarea>
<br>Summary (Max 200 Words): <?php if (isset($summaryMsg)) { echo $summaryMsg; } ?>
<br><textarea name='summary' rows='10' spellcheck='true' class='field span7'>
<?php if (isset($summary)) { echo $summary; } ?></textarea>
<br>Category: <?php if (isset($categoryMsg)) { echo $categoryMsg; } ?>
<br><select name='category'>
<?php echo $categoriesHtml; ?>
</select>
<br><input type='checkbox' name='upload_file' onClick='return enablePodcastUpload()'>Upload Podcast
<br>Podcast (Max Size: <?php echo get_max_upload_size(); ?> MB): <?php if (isset ($fileMsg)) { echo $fileMsg; } ?>
<br><input type='file' name='file' disabled='disabled'>
<br><input type='checkbox' name='acknowledgement'>Should review be acknowledge by you
<br><input type='checkbox' name='review_permission'>Allow your review to be used
<br><input class='btn' type='submit' name='addPodcast' value='Add Podcast'>
<input class='btn' type='submit' name='cancel' value='Cancel'>
</form>

<?php if (isset($message)) { 
	echo "<div class='alert'>" . $message . "</div>";
}

?>

<?php

include 'includes/footer.inc.php';
?>
