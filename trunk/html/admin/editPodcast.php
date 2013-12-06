<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';



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
	$category = $_POST['category'];
	$contain_video = $_POST['contain_video'];
	$short_summary = $_POST['short_summary'];
	
	$test_short_summary = str_replace(" ","",$short_summary);
	if ($login_user->is_admin() && isset($_POST['quality'])) {
		$quality = $_POST['quality'];

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
        elseif (count(explode(" ",$summary)) > __MAX_SUMMARY_WORDS__) {
                $error++;
                $summaryMsg = "<b class='error'>Summary can not have more than " . __MAX_SUMMARY_WORDS__ . " words";

        }

	if ((strlen($test_short_summary) == 0) || (strlen($test_short_summary) > __MAX_SHORT_SUMMARY_CHARS__)) {
                $error++;
                $short_summary_msg = "<b>Please enter a short summary.  ";
                $short_summary_msg .= "Maximum length is " . __MAX_SHORT_SUMMARY_CHARS__ . " characters</b>";

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

	if ($category['category_id'] == $category_id) {
		$categoriesHtml .= "<option selected value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
	}
	else {
		$categoriesHtml .= "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
	}



}

$radio_html = "";
for ($i=1;$i<=10;$i++) {
	if ($i == $quality) {
		$radio_html .= "<input type='radio' name='quality' checked='checked' value='" . $i . "'>" . $i;
	}
	else {
		$radio_html .= "<input type='radio' name='quality' value='" . $i . "'>" . $i;
	}


}

include_once 'includes/header.inc.php';
?>

<table class='table'>
	<tr>
		<td>
		<?php if ($previous_podcast) {
			echo "<a href='editPodcast.php?id=" . $previous_podcast . "'>Previous Podcast</a>";
		}
		else {
			echo "Previous Podcast";
		}
		?>
		</td>
		<td>
		<?php if ($next_podcast) {
			echo "<a href='editPodcast.php?id=" . $next_podcast . "'>Next Podcast</a>";
		}
		else {
			echo "Next Podcast";
		}
		?>
		</td>
	</tr>
</table>
<form class='form-vertical' method='post' enctype='multipart/form-data' action='editPodcast.php?id=<?php echo $id; ?>'>
<input type='hidden' name='id' value='<?php echo $id; ?>'>
<br>Media Source: <?php if (isset($sourceMsg)) { echo $sourceMsg; } ?> 
<br><input class='span12' type='text' name='source' size='40' value='<?php echo $source; ?>'>
<br>Program Name: <?php if (isset($programMsg)) { echo $programMsg; } ?>
<br><input class='span12' type='text' name='programName' size='40' value='<?php echo $programName; ?>'>
<br>Show Name: <?php if (isset($showMsg)) { echo $showMsg; } ?>
<br><input class='span12' type='text' name='showName' size='40' value='<?php echo $showName; ?>'>
<br>Broadcast Year: <?php if (isset($yearMsg)) { echo $yearMsg; } ?>
<br><input class='span12' type='text' name='year' size='4' maxlength='4' value='<?php echo $year; ?>'>
<br>URL: <?php if (isset($urlMsg)) { echo $urlMsg; } ?>
<br><input class='span12' type='text' name='url' size='40' value='<?php echo $url; ?>'>
<br>Short Summary (Max 200 Characters): <?php if (isset($short_summary_msg)) { echo $short_summary_msg; } ?>
<br><textarea name='short_summary' rows='2' spellcheck='true' class='filed span12'>
<?php if (isset($short_summary)) { echo $short_summary; } ?></textarea>

<br>Summary: <?php if (isset($summaryMsg)) { echo $summaryMsg; } ?>
<br><textarea name='summary' rows='10' class='field span12'><?php echo $summary; ?></textarea>
<br>Category: <?php if (isset($categoryMsg)) { echo $categoryMsg; } ?>
<br><select name='category'>
<?php echo $categoriesHtml; ?>
</select>
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

	echo "<br>Quality:" . $radio_html;
	



}?>
<p><br><input class='btn btn-primary' type='submit' name='editPodcast' value='Edit Podcast'>
<input class='btn btn-danger' type='submit' name='removePodcast' value='Remove Podcast' onClick='return confirmRemove()'>
<input class='btn btn-warning' type='submit' name='cancel' value='Cancel'></p>
<?php

if ($login_user->is_admin()) {
	echo "<hr>";
	echo "<table class='table'>";
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
		echo "<tr><td><input class='btn btn-primary' type='submit' ";
		echo "name='unapprovePodcast' value='Unapprove Podcast' onClick='return confirmUnapprove()'></td><td></td></tr>";
	}
	elseif (!$approved) {
		echo "<tr><td><input class='btn btn-primary' type='submit' name='approvePodcast' ";
		echo "value='Approve Podcast' onClick='return confirmApprove()'></td><td></td></tr>";
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

include_once 'includes/footer.inc.php';
?>
