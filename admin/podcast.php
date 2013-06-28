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

<script language='JavaScript' src='../includes/audio-player.js'></script>

<h3><?php echo $podcast->getShowName(); ?></h3>
<br>Media Source: <?php echo $podcast->getSource(); ?>
<br>Program Name: <?php echo $podcast->getProgramName(); ?>
<br>Broadcast Year: <?php echo $podcast->getBroadcastYear(); ?>
<br>Original Link: <a href='<?php echo $podcast->getUrl(); ?>' target='_blank'><?php echo $podcast->getUrl(); ?></a>
<br>Summary: <?php echo $podcast->getSummary(); ?>
<br>Play Podcast: 
<object type='application/x-shockwave-flash' data='../includes/player.swf' id='audioplayer1' height='18' width='200'>
	<param name='movie' value='../includes/player.swf'>
	<param name='FlashVars' value='playerID=1&amp;soundFile=<?php echo $relFile; ?>'>
	<param name='quality' value='high'>
	<param name='menu' value='false'>
	<param name='wmode' value='transparent'>
</object>
<br><a href='../download.php?id=<?php echo $id; ?>'>Download Podcast</a>


<?php

include 'includes/footer.inc.php';
?>
