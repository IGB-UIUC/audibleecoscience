<?php
include_once 'includes/main.inc.php';
include_once 'functions.inc.php';
include_once 'podcast.class.inc.php';
include_once 'categories.class.inc.php';


if (isset($_POST['addPodcast'])) {
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
	$filename = $_FILES['file']['name'];
	$tmpFile = $_FILES['file']['tmp_name'];
	$fileError = $_FILES['file']['error'];
	$filetype = strtolower(end(explode(".",$filename)));
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
	if ($fileType != 0) {
		$error++;
		$fileMsg = "<b class='error'>File Type must be Mp3.</b>";

	}

	if ($fileError != 0) {
		$error++;
		$fileMsg = "<b class='error'>" . $uploadErrors[$fileError] . "</b>";
	}	
	
	if ($error == 0) {
	
		$id = addPodcast($mysqlSettings);
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$podcast = new podcast($id,$mysqlSettings);
		$podcast->setSource($source);
		$podcast->setProgramName($programName);
		$podcast->setShowName($showName);
		$podcast->setBroadcastYear($year);
		$podcast->setUrl($url);
		$podcast->setCategory($category);
		$podcast->setSummary($summary);	
		$podcast->setIPAddress($ipAddress);
		$podcast->setCreateBy($username);
		$podcast->uploadPodcast($filename,$tmpFile,$absPodcastDirectory);		

		$success = "<b class='msg'>Podcast successfully submitted";
		$source = "";
		$programName = "";
		$showName = "";
		$year = "";
		$url = "";
		$summary = "";
		
	}



}

$categories = new categories($mysqlSettings);

$categoryList = $categories->getCategories();

for ($i=0;$i<count($categoryList);$i++) {
	$category_id = $categoryList[$i]['category_id'];
	$category_name = $categoryList[$i]['category_name'];
	$categoriesHtml .= "<option value='" . $category_id . "'>" . $category_name . "</option>";
	



}

include_once 'includes/header.inc.php';
if (isset($success)) { echo $success; }
?>

<p class='subHeader'>Add Podcast</p>
<form method='post' enctype='multipart/form-data' action='addPodcast.php'>
<input type='hidden' name='MAX_FILE_SIZE' value='134217728000'>
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

<br>Podcast: <?php if (isset ($fileMsg)) { echo $fileMsg; } ?>
<br><input type='file' name='file'>
<br><input type='submit' name='addPodcast' value='Add Podcast'>
</form>


<?php

include 'includes/footer.inc.php';
?>
