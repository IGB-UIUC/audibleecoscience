<?php

require_once 'includes/main.inc.php';
require_once 'includes/session.inc.php';
require_once 'includes/header.inc.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	$podcast = new podcast($id,$db);
	$relFile = __PODCAST_WEB_DIR__ . "/" . $podcast->getFile();	
}
?>


<h3>Podcast - <?php echo $podcast->getShowName(); ?></h3>
<table class='table'>
<tr>
	<td>Category:</td>
	<td><?php echo $podcast->getCategory(); ?></td>
</tr>
<tr>
	<td>Media Source:</td>
	<td><?php echo $podcast->getSource(); ?></td>
</tr>
<tr>
	<td>Program Name:</td>
	<td><?php echo $podcast->getProgramName(); ?></td>
</tr>
<tr>
	<td>Broadcast Year: </td>
	<td><?php echo $podcast->getBroadcastYear(); ?></td>
</tr>
<tr>
	<td>Original Link: </td>
	<td><a href='<?php echo $podcast->getUrl(); ?>' target='_blank'><?php echo $podcast->getUrl(); ?></a></td>
</tr>
<tr>
	<td>Short Summary: </td>
	<td><?php echo $podcast->getShortSummary(); ?></td>
<tr>
	<td>Summary: </td>
	<td><?php echo $podcast->getSummary(); ?></td>
</tr>
<tr>
	<td>Audio or Audio/Video:</td>
	<td><?php 
		if ($podcast->getContainVideo()) { echo "Audio/Video"; }
		else { echo "Audio Only"; } ?>
	</td>
		
</tr>
<?php if (($podcast->getFile() != "") && $podcast->getContainVideo()) {
	echo "<tr><td>Play Podcast: </td>";
        echo "<td><video width='320' height='240'>";
	echo "<source src='" . $relFile . "' type='video/mp4'></video>";
        echo "<br><a href='../download.php?id=" . $id . "'>Download Podcast</a></td></tr>";


}
elseif (($podcast->getFile() != "") && (!$podcast->getContainVideo())) {
	echo "<tr><td>Play Podcast: </td>";
	echo "<td><audio id='player' type='audio/mp3' controls='controls' src='" . $relFile . "'></audio>";
	echo "<br><a href='../download.php?id=" . $id . "'>Download Podcast</a></td></tr>";
} ?>
<tr>
	<td><input class='btn btn-primary' type='button' value='Edit' 
	onClick="window.location.href='editPodcast.php?id=<?php echo $id; ?>'"></td>
	<td></td>
</tr>
</table>

<?php

include 'includes/footer.inc.php';
?>
