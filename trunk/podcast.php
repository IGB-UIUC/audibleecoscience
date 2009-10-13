<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';
include_once 'podcast.class.inc.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	$podcast = new podcast($id,$mysqlSettings);
	$approved = $podcast->getApproved();

	if ($approved == 1) {
		$programName = $podcast->getProgramName();
		$showName = $podcast->getShowName();
		$year = $podcast->getBroadcastYear();
		$url = $podcast->getUrl();
		$summary = $podcast->getSummary();
		$source = $podcast->getSource();
		$relFile = $relPodcastDirectory . $podcast->getFile();
	}
	else {
		echo "This podcast does not exist";
		exit;
	}
}
?>

<script language='JavaScript' src='includes/audio-player.js'></script>
<p class='subHeader'><?php echo $showName; ?></p>
<br>Media Source: <?php echo $source; ?>
<br>Program Name: <?php echo $programName; ?>
<br>Broadcast Year: <?php echo $year; ?>
<br>Original Link: <a href='<?php echo $url; ?>' target='_blank'><?php echo $url; ?></a>
<br>Summary: <?php echo $summary; ?>
<br>Play Podcast: 
<object type='application/x-shockwave-flash' data='includes/player.swf' id='audioplayer1' height='18' width='200'>
	<param name='movie' value='includes/player.swf'>
	<param name='FlashVars' value='playerID=1&amp;soundFile=<?php echo $relFile; ?>'>
	<param name='quality' value='high'>
	<param name='menu' value='false'>
	<param name='wmode' value='transparent'>
</object>
<br><a href='download.php?id=<?php echo $id; ?>'>Download Podcast</a>


<?php

include 'includes/footer.inc.php';
?>
