<?php

include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	$podcast = new podcast($id,$db);
	$relFile = __PODCAST_WEB_DIR__ . "/" . $podcast->getFile();	
}
?>


<h3><?php echo $podcast->getShowName(); ?></h3>
<br>Media Source: <?php echo $podcast->getSource(); ?>
<br>Program Name: <?php echo $podcast->getProgramName(); ?>
<br>Broadcast Year: <?php echo $podcast->getBroadcastYear(); ?>
<br>Original Link: <a href='<?php echo $podcast->getUrl(); ?>' target='_blank'><?php echo $podcast->getUrl(); ?></a>
<br>Summary: <?php echo $podcast->getSummary(); ?>
<br>Play Podcast: 
<audio id='player' type="audio/mp3" controls="controls" src='<?php echo $relFile; ?>'>
</audio>

<script>
$('audio,video').mediaelementplayer();
</script>

<br><a href='../download.php?id=<?php echo $id; ?>'>Download Podcast</a>


<?php

include 'includes/footer.inc.php';
?>
