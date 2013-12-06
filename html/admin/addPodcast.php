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
	$contain_video = $_POST['contain_video'];
	$test_short_summary = str_replace(" ","",$short_summary);
	$allowed_file_types = explode(",",__FILETYPES__);

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
		$filetype = strtolower(end(explode(".",$filename)));
	}
	$error = 0;
	if ($source == "") {
		$error++;
		$sourceMsg = "<b style='color:red;font-size:large'>Please fill in the source</b>";
	}
	if ($programName == "") {
		$error++;
		$programMsg = "<b style='color:red;font-size:large'>Please fill in the program name</b>";
	}
	if ($showName == "") {
		$error++;
		$showMsg = "<b style='color:red;font-size:large'>Please fill in the show name</b>";
	}	

	if (($year == "") || (!is_numeric($year))) {
		$error++;
		$yearMsg = "<b style='color:red;font-size:large'>Please fill in the broadcast year</b>";
	}
	if ($url == "") {
		$error++;
		$urlMsg = "<b style='color:red;font-size:large'>Please fill in the original web address</b>";

	}
	if ($summary == "") {
		$error++;
		$summaryMsg = "<b style='color:red;font-size:large'>Please enter a summary</b>";

	}
	elseif (count(explode(" ",$summary)) > __MAX_SUMMARY_WORDS__) {
		$error++;
		$summaryMsg = "<b style='color:red;font-size:large'>Summary can not have more than " . __MAX_SUMMARY_WORDS__ . " words</b>";

	}
	if ((strlen($test_short_summary) == 0) || (strlen($test_short_summary) > __MAX_SHORT_SUMMARY_CHARS__)) {
		$error++;
		$short_summary_msg = "<b style='color:red;font-size:large'>Please enter a short summary.  ";
		$short_summary_msg .= "Maximum length is " . __MAX_SHORT_SUMMARY_CHARS__ . " characters</b>";

	}

	if ((isset($_POST['upload_file'])) && (!in_array($filetype,$allowed_file_types))) {
		$error++;
		$fileMsg = "<div class='alert alert-error'>Invalid filetype.</div>";

	}

	if ((isset($_POST['upload_file'])) && ($fileError != 0)){
		$error++;
		$fileMsg = "<div class='alert alert-error'>" . $uploadErrors[$fileError] . "</div>";
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
		$podcast->setContainVideo($contain_video);
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

$categories = get_categories($db);

$categoriesHtml = "";
foreach ($categories as $category) {
	$categoriesHtml .= "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
	



}

include_once 'includes/header.inc.php';
?>

<h3>Add Podcast</h3>
<form method='post' enctype='multipart/form-data' action='<?php echo $_SERVER['PHP_SELF']; ?>' name='addPodcastForm'>
<input type='hidden' name='MAX_FILE_SIZE' value='<?php echo get_max_upload_size('bytes'); ?>'>
<fieldset>
<br>Media Source: (ie National Public Radio, Nature Podcast, Scientific America)<?php if (isset($sourceMsg)) { echo $sourceMsg; } ?> 
<br><input class='span12' type='text' name='source' maxlength='100' value='<?php if (isset($source)) { echo $source; } ?>'>
<br>Program Name: (ie Science Friday, Nature Podcast, Living on Earth) <?php if (isset($programMsg)) { echo $programMsg; } ?>
<br><input class='span12' type='text' name='programName' maxlength='100' value='<?php if (isset($programName)) { echo $programName; } ?>'>
<br>Show Name: (ie With climate change, no happy clams; Show 191 - Tree death in a warming western U.S.) <?php if (isset($showMsg)) { echo $showMsg; } ?>
<br><input class='span12' type='text' name='showName' maxlength='100' value='<?php if (isset($showName)) { echo $showName; }?>'>
<br>Broadcast Year: <?php if (isset($yearMsg)) { echo $yearMsg; } ?>
<br><input class='span12' type='text' name='year' maxlength='4' value='<?php if (isset($year)) { echo $year; } ?>'>
<br>URL: <?php if (isset($urlMsg)) { echo $urlMsg; } ?>
<br><input class='span12' type='text' name='url' maxlength='100' value='<?php if (isset($url)) { echo $url; } ?>'>
<br>Short Summary (Max <?php echo __MAX_SHORT_SUMMARY_CHARS__; ?> Characters): 
<br><?php if (isset($short_summary_msg)) { echo $short_summary_msg; } ?>
<br><textarea name='short_summary' rows='2' spellcheck='true' class='filed span12'><?php if (isset($short_summary)) { echo $short_summary; } ?></textarea>
<br>Summary (Max <?php echo __MAX_SUMMARY_WORDS__; ?> Words): <?php if (isset($summaryMsg)) { echo $summaryMsg; } ?>
<br><textarea name='summary' rows='10' spellcheck='true' class='field span12'>
<?php if (isset($summary)) { echo $summary; } ?></textarea>
<br>Category: <?php if (isset($categoryMsg)) { echo $categoryMsg; } ?>
<br><select name='category'>
<?php echo $categoriesHtml; ?>
</select>

<div class='control-group'>
	<div class='controls'>
		<label class='radio'>
		<input type='radio' name='contain_video' value='0'>Audio Only
		</label>
		<label class='radio'>
		<input type='radio' name='contain_video' value='1'>Audio and Video
		</label>
	</div>
</div>
<div class='control-group'>
	<div class='controls'>
		<label class='checkbox'>
			<input type='checkbox' name='upload_file' onClick='return enablePodcastUpload()'>
			Upload Podcast:</label>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>
		Podcast (Max Size: <?php echo get_max_upload_size(); ?> MB): <?php if (isset ($fileMsg)) { echo $fileMsg; } ?> </label>
	</label>
	<div class='controls'>
		<input type='file' name='file' disabled='disabled'>
	</div>
</div>
<div class='control-group'>
	<label class='checkbox'>
	<input type='checkbox' name='acknowledgment'>Should review be acknowledged by you </label>
</div>

<div class='control-group'>
        <label class='checkbox'>
        <input type='checkbox' name='review_permission'>Allow your review to be used publicly</label>
</div>
<div class='control-group'>

<div class='control-group'>
	<div class='controls'>
		<input class='btn btn-primary' type='submit' name='addPodcast' value='Add Podcast'>
		<input class='btn btn-warning' type='submit' name='cancel' value='Cancel'>
	</div>
</div>
</fieldset>
</form>

<?php if (isset($message)) { 
	echo "<div class='alert'>" . $message . "</div>";
}

?>

<?php

include 'includes/footer.inc.php';
?>
