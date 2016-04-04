<?php
require_once 'includes/main.inc.php';
require_once 'includes/session.inc.php';



if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
	$id = $_GET['id'];
	$podcast = new podcast($id,$db);
	$category_id = $podcast->getCategoryId();
	$source = $podcast->getSource();
	$programName = $podcast->getProgramName();
	$showName = $podcast->getShowName();
	$year = $podcast->getBroadcastYear();
	$url = $podcast->getUrl();
	$short_summary = $podcast->getShortSummary();
	$summary = $podcast->getSummary();
	$createdBy = $podcast->getCreatedBy();
	$ip = $podcast->getIPAddress();
	$time = $podcast->getUploadTime();
	$approved = $podcast->getApproved();
	$approvedBy = $podcast->getApprovedBy();
	$quality = $podcast->getQuality();
	$next_podcast = $podcast->get_next_podcast();
	$previous_podcast = $podcast->get_previous_podcast();
	$contain_video = $podcast->getContainVideo();

}

if (isset($_POST['removePodcast'])) {

	$podcast->remove();
	$message = "Podcast has been successfully removed";
}
elseif (isset($_POST['approvePodcast'])) {
	$podcast->approve($login_user->get_user_id());
	$approved = $podcast->getApproved();
	$approvedBy = $podcast->getApprovedBy();
	$message = "Podcast has been approved";

}

elseif (isset($_POST['unapprovePodcast'])) {

	$podcast->unapprove();
	$approved = $podcast->getApproved();
	$approvedBy = $podcast->getApprovedBy();
	$message = "Podcast has been unapproved";


}
elseif (isset($_POST['editPodcast'])) {
	foreach ($_POST as $var) {
		$var = trim(rtrim($var));
	}
	$source = $_POST['source'];
	$programName = $_POST['programName'];
	$showName = $_POST['showName'];
	$year = $_POST['year'];
	$url = $_POST['url'];
	$summary = $_POST['summary'];
	$category_id = $_POST['category'];
	$contain_video = $_POST['contain_video'];
	$short_summary = $_POST['short_summary'];
	
	$test_short_summary = str_replace(" ","",$short_summary);
	if ($login_user->is_admin() && isset($_POST['quality'])) {
		$quality = $_POST['quality'];

	}	
	$error = 0;
	if ($source == "") {
		$error++;
		$sourceMsg = "<b style='color:red;font-size:large'>Please fill in the source.</b>";
	}
	if ($programName == "") {
		$error++;
		$programMsg = "<b style='color:red;font-size:large'>Please fill in the program name.</b>";
	}
	if ($showName == "") {
		$error++;
		$showMsg = "<b style='color:red;font-size:large'>Please fill in the show name.</b>";
	}	

	if (($year == "") || (!is_numeric($year))) {
		$error++;
		$yearMsg = "<b style='color:red;font-size:large'>Please fill in the broadcast year.</b>";
	}
	$url_result = verify_url($db,$url,$id);
	if (!$url_result['RESULT']) {
		$error++;
		$urlMsg = "<b style='color:red;font-size:large'>" . $url_result['MESSAGE'] . "</b>";

	}

	if (($summary == "") || (!verify_spelling($summary))) {
                $error++;
                $summaryMsg = "<b style='color:red;font-size:large'>Please verify the spelling of the summary</b>";

        }
        elseif (count(explode(" ",$summary)) > __MAX_SUMMARY_WORDS__) {
                $error++;
                $summaryMsg = "<b style='color:red;font-size:large'>Summary can not have more than " . __MAX_SUMMARY_WORDS__ . " words.</b>";

        }

	if ((strlen($test_short_summary) == 0) || (strlen($test_short_summary) > __MAX_SHORT_SUMMARY_CHARS__)) {
                $error++;
                $short_summary_msg = "<b style='color:red;font-size:large'>Please enter a short summary.  ";
                $short_summary_msg .= "Maximum length is " . __MAX_SHORT_SUMMARY_CHARS__ . " characters.</b>";

        }
	elseif (!verify_spelling($short_summary)) {
		$error++;
		$short_summary_msg = "<b style='color:red;font-size:large'>Please verify the spelling of the short summary.</b>";
	}
	
	if ($error == 0) {
		$podcast = new podcast($id,$db);
		$podcast->setSource($source);
		$podcast->setProgramName($programName);
		$podcast->setShowName($showName);
		$podcast->setBroadcastYear($year);
		$podcast->setUrl($url);
		$podcast->setCategory($category_id);
		$podcast->setSummary($summary);	
		$podcast->setShortSummary($short_summary);
		$podcast->setQuality($quality);	
		$podcast->setContainVideo($contain_video);
		$message = "Podcast successfully updated";
	}

}

elseif (isset($_POST['cancel'])) {
	unset($_POST);

}



$categories = get_categories($db);

$categoriesHtml = "";
foreach ($categories as $category) {
	$categoriesHtml .= "<label class='control-label' for='inlineOption" . $category['category_id'] . "'>";
	if ($category['category_id'] == $category_id) {
		$categoriesHtml .= "<option selected='selected' id='inlineOption" . $category['category_id'] . "' value='" . $category['category_id'] . "'>" . $category['category_name'];
	}
	else {
		$categoriesHtml .= "<option id='inlineOption" . $category['category_id'] . "' value='" . $category['category_id'] . "'>" . $category['category_name'];
	}
	$categoriesHtml .= "</label>";

}

$radio_html = "";

for ($i=1;$i<=10;$i++) {
	$radio_html .= "<label class='radio inline'>";
	if ($i == $quality) {
		$radio_html .= "<input id='inputQuality' type='radio' name='quality' checked='checked' value='" . $i . "'>" . $i;
	}
	else {
		$radio_html .= "<input id='inputQuality' type='radio' name='quality' value='" . $i . "'>" . $i;
	}
	$radio_html .= "</label>";


}

require_once 'includes/header.inc.php';
?>
<ul class='pager'>
	
<?php 
	if ($previous_podcast) {
		echo "<li class='previous'><a href='editPodcast.php?id=" . $previous_podcast . "'>Previous Podcast</a></li>";
	}
	else {
		echo "<li class='previous disabled'><a href='#'>Previous Podcast</a></li>";
	}
	if ($next_podcast) {
		echo "<li class='next'><a href='editPodcast.php?id=" . $next_podcast . "'>Next Podcast</a></li>";
	}
	else {
		echo "<li class='next disabled'><a href='#'>Next Podcast</a></li>";
	}
?>
</ul>

<?php if (isset($message)) {
        echo "<div class='alert'>" . $message . "</div>";
}
?>

<form class='form-vertical' method='post' enctype='multipart/form-data' action='<?php echo $_SERVER['PHP_SELF'] . "?id=" . $id; ?>'>
<input type='hidden' name='id' value='<?php echo $id; ?>'>
<fieldset>
<div class='control-group <?php if (isset($sourceMsg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputSource'>Media Source: <?php if (isset($sourceMsg)) { echo $sourceMsg; } ?><label>
	<div class='controls'>
		<input class='span12' id='inputSource' type='text' name='source' value='<?php echo $source; ?>' maxlength='100'>
	</div>
</div>
<div class='control-group <?php if (isset($programMsg)) { echo "error"; }  ?>'>
	<label class='control-label' for='inputProgram'>Program Name: <?php if (isset($programMsg)) { echo $programMsg; } ?></label>
	<div class='controls'>
		<input class='span12' id='inputProgram' type='text' name='programName' value='<?php echo $programName; ?>' maxlength='100'>
	</div>
</div>
<div class='control-group <?php if (isset($showMsg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputShow'>Show Name: <?php if (isset($showMsg)) { echo $showMsg; } ?></label>
	<div class='controls'>
		<input class='span12' id='inputShow' type='text' name='showName' value='<?php echo $showName; ?>' maxlength='100'>
	</div>
</div>
<div class='control-group <?php if (isset($yearMsg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputYear'>Broadcast Year: <?php if (isset($yearMsg)) { echo $yearMsg; } ?></label>
	<div class='controls'>
		<input class='span12' id='inputYear' type='text' name='year' maxlength='4' value='<?php echo $year; ?>'>
	</div>
	
</div>
<div class='control-group <?php if (isset($urlMsg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputUrl'>URL: <?php if (isset($urlMsg)) { echo $urlMsg; } ?></label>
	<div class='controls'>
		<input class='span12' id='inputUrl' type='text' name='url' value='<?php echo $url; ?>'>
	</div>
</div>
<div class='control-group <?php if (isset($short_summary_msg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputShortSummary'>Short Summary (Max <?php echo __MAX_SHORT_SUMMARY_CHARS__; ?> Characters):
	<?php if (isset($short_summary_msg)) { echo $short_summary_msg; } ?>
	</label>
	<div class='controls'>
		<textarea lang='en' name='short_summary' id='inputShortSummary' rows='2' spellcheck='true' class='filed span12'><?php 
		if (isset($short_summary)) { echo $short_summary; } ?></textarea>
	</div>
</div>
<div class='control-group <?php if (isset($summaryMsg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputSummary'>Summary (Max <?php echo __MAX_SUMMARY_WORDS__; ?> Words): <?php if (isset($summaryMsg)) { echo $summaryMsg; } ?></label>
	<div class='controls'>
		<textarea name='summary' spellcheck='true' lang='en' id='inputSummary' rows='10' class='field span12'><?php if (isset($summary)) { echo $summary; } ?></textarea>
	</div>
</div>
<div class='control-group <?php if (isset($categoryMsg)) { echo "error"; } ?>'>
	<label class='control-label' for='inputCategory'>Category: <?php if (isset($categoryMsg)) { echo $categoryMsg; } ?></label>
	<div class='controls'>
		<select name='category' id='inputCategory'>
		<?php echo $categoriesHtml; ?>
		</select>
	</div>
</div>
<div class='control-group'>
        <div class='controls'>
                <label class='radio'>
                <input type='radio' name='contain_video' value='0' <?php if (!$contain_video) { echo "checked='checked'"; } ?>>Audio Only
                </label>
                <label class='radio'>
                <input type='radio' name='contain_video' value='1' <?php if ($contain_video) { echo "checked='checked'"; }?>>Audio and Video
                </label>
        </div>
</div>

<?php if ($login_user->is_admin()) {

	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputQuality'>Quality:</label>";
	echo "<div class='controls'>" . $radio_html;
	echo "</div></div>";
	



}?>
<div class='control-group'>
	<div class='controls'>
		<input class='btn btn-primary' type='submit' name='editPodcast' value='Submit Changes'>
		<input class='btn btn-danger' type='submit' name='removePodcast' value='Remove Podcast' onClick='return confirmRemove()'>
		<input class='btn btn-warning' type='submit' name='cancel' value='Cancel'>
	</div>
</div>
</fieldset>
<?php

if ($login_user->is_admin()) {
	echo "<hr>";
	echo "<table class='table table-bordered table-condensed'>";
	echo "<tr><td>Created By:</td><td>" . $createdBy . "</td></tr>";
	echo "<tr><td>IP Address:</td><td>" . $ip . "</td></tr>";
	echo "<tr><td>Time Uploaded:</td><td>" . $time . "</td></tr>";
	if ($podcast->getAcknowledgement()) {
		$acknowledgement = "Yes";
	}
	else {
		$acknowledgement = "No";
	}
	echo "<tr><td>Review Acknowledgement Allowed:</td><td>" . $acknowledgement . "</td></tr>";

	if ($podcast->getReviewPermission()) {
		$permission = "Yes";
	}
	else {
		$permission = "No";
	}
	echo "<tr><td>Review Permission:</td><td>" . $permission . "</td></tr>";
	if ($approved) {
		echo "<tr><td>Approved By:</td><td>" . $approvedBy . "</td></tr>";
		echo "<tr><td colspan='2'><input class='btn btn-primary' type='submit' ";
		echo "name='unapprovePodcast' value='Unapprove Podcast' onClick='return confirmUnapprove()'></td></tr>";
	}
	elseif (!$approved) {
		echo "<tr><td colspan='2'><input class='btn btn-primary' type='submit' name='approvePodcast' ";
		echo "value='Approve Podcast' onClick='return confirmApprove()'></td></tr>";
	}
	echo "</table>";
}

?>
</form>

<?php if (isset($message)) {
	echo "<div class='alert'>" . $message . "</div>";
} 
?>

<?php

require_once 'includes/footer.inc.php';
?>
