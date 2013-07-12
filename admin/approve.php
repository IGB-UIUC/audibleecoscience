<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}


$podcasts = getUnapprovedPodcasts($db);
$unapprovedHtml = "";
foreach ($podcasts as $podcast) {

	$unapprovedHtml .= "<tr><td><a href='podcast.php?id=" . $podcast['podcast_id'] . "'>" . $podcast['podcast_showName'] . "</td>";
	$unapprovedHtml .= "<td>" . $podcast['podcast_source'] . "</td>";
	$unapprovedHtml .= "<td>" . $podcast['podcast_programName'] . "</td>";
	$unapprovedHtml .= "<td>" . $podcast['podcast_time'] . "</td>";
	$unapprovedHtml .= "<td>" . $podcast['user_name'] . "</td>";
	$unapprovedHtml .= "<td><input type='button' value='Edit' ";
	$unapprovedHtml .= "onClick=\"window.location.href='editPodcast.php?id=" . $podcast['podcast_id'] . "'\"></td>";
	$unapprovedHtml .= "</tr>";

}

include_once 'includes/header.inc.php';
?>
<h3>Unapproved Podcasts</h3>
<table class='table table-bordered'>
	<tr>
	<th>Show Name</th>
        <th>Source</th>
        <th>Program</th>
        <th>Time Uploaded</th>
	<th>Created By</th>
        <th></th>
	</tr>


<?php echo $unapprovedHtml; ?>


</table>

<?php
include 'includes/footer.inc.php';
?>
