<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}


$start = 0;
if (isset($_GET['start']) && is_numeric($_GET['start'])) {
        $start = $_GET['start'];
}

$count = __COUNT__;
$podcasts = getUnapprovedPodcasts($db);
$numPodcasts = count($podcasts);
$currentPage = $start / $count +1;
$pages_url = $_SERVER['PHP_SELF'] . "?" . http_build_query(array('start_date'=>$start_date,'end_date'=>$end_date));
$pages_html = get_pages_html($pages_url,$numPodcasts,$start,$count);


$unapprovedHtml = "";
if ($numPodcasts) {
	for ($i=$start;$i<$start+$count;$i++) {
        	if (array_key_exists($i,$podcasts)) {


			$unapprovedHtml .= "<tr><td><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>" . $podcasts[$i]['podcast_showName'] . "</td>";
			$unapprovedHtml .= "<td>" . $podcasts[$i]['podcast_source'] . "</td>";
			$unapprovedHtml .= "<td>" . $podcasts[$i]['podcast_programName'] . "</td>";
			$unapprovedHtml .= "<td>" . $podcasts[$i]['podcast_time'] . "</td>";
			$unapprovedHtml .= "<td>" . $podcasts[$i]['user_name'] . "</td>";
			$unapprovedHtml .= "<td><input type='button' value='Edit' ";
			$unapprovedHtml .= "onClick=\"window.location.href='editPodcast.php?id=" . $podcasts[$i]['podcast_id'] . "'\"></td>";
			$unapprovedHtml .= "</tr>";

		}
	}
}
else {
	$unapprovedHtml = "<tr><td colspan='6'>None</td></tr>";

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
        <th>Edit</th>
	</tr>


<?php echo $unapprovedHtml; ?>


</table>
<?php echo $pages_html; ?>
<?php
include 'includes/footer.inc.php';
?>
