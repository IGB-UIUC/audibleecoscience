<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
}
else {
        $start_date = date('Ym') . "01";
        $end_date = date('Ymd',strtotime('-1 second',strtotime('+1 month',strtotime($start_date))));
}

$month_name = date('F',strtotime($start_date));
$month = date('m',strtotime($start_date));
$year = date('Y',strtotime($start_date));
$previous_end_date = date('Ymd',strtotime('-1 second', strtotime($start_date)));
$previous_start_date = substr($previous_end_date,0,4) . substr($previous_end_date,4,2) . "01";
$next_start_date = date('Ymd',strtotime('+1 day', strtotime($end_date)));
$next_end_date = date('Ymd',strtotime('-1 second',strtotime('+1 month',strtotime($next_start_date))));
$back_url = $_SERVER['PHP_SELF'] . "?start_date=" . $previous_start_date . "&end_date=" . $previous_end_date;
$forward_url = $_SERVER['PHP_SELF'] . "?start_date=" . $next_start_date . "&end_date=" . $next_end_date;


$start = 0;
if (isset($_GET['start']) && is_numeric($_GET['start'])) {
        $start = $_GET['start'];
}

$count = __COUNT__;
$approved = 0;
$podcasts = get_podcasts($db,$start_date,$end_date,$approved);

$numPodcasts = count($podcasts);
$currentPage = $start / $count +1;
$pages_url = $_SERVER['PHP_SELF'] . "?" . http_build_query(array('start_date'=>$start_date,'end_date'=>$end_date));
$pages_html = get_pages_html($pages_url,$numPodcasts,$start,$count);


$podcastsHtml = "";

for ($i=$start;$i<$start+$count;$i++) {
	if (array_key_exists($i,$podcasts)) {
		$approved = "No";
		if ($podcasts[$i]['podcast_approved'] == 1) { 
			$approved = "Yes"; 
		}
	
		$podcastsHtml .= "<tr><td>" . $approved . "</td>";
		$podcastsHtml .= "<td><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
		$podcastsHtml .= $podcasts[$i]['podcast_showName'] . "</a></td>";	
		$podcastsHtml .= "<td>" . $podcasts[$i]['podcast_source'] . "</td>";
		$podcastsHtml .= "<td>" . $podcasts[$i]['podcast_programName'] . "</td>";
		$podcastsHtml .= "<td>" . $podcasts[$i]['podcast_time'] . "</td>";
		$podcastsHtml .= "<td>" . $podcasts[$i]['user_name'] . "</td>"; 
		$podcastsHtml .= "<td><span class='label " . get_rating_label($podcasts[$i]['podcast_quality']) . "'>" . $podcasts[$i]['podcast_quality'] . "</span></td>";
		$podcastsHtml .= "<td><input type='button' class='btn btn-primary btn-small' value='Edit' ";
		$podcastsHtml .= "onClick=\"window.location.href='editPodcast.php?id=";
		$podcastsHtml .= $podcasts[$i]['podcast_id'] . "'\"></td>";
		$podcastsHtml .= "</tr>";
	}
}


?>

<h3>All Podcasts: <?php echo $month_name . " - " . $year; ?></h3>
<ul class='pager'>
	<li class='previous'><a href='<?php echo $back_url; ?>'>Previous Month</a></li>

	<?php
		$next_month = strtotime('+1 day', strtotime($end_date));
		$today = mktime(0,0,0,date('m'),date('d'),date('y'));
		if ($next_month > $today) {
			echo "<li class='next disabled'><a href='#'>Next Month</a></li>";
		}
		else {
			echo "<li class='next'><a href='" . $forward_url . "'>Next Month</a></li>";
		}
	?>
</ul>
<table class='table table-bordered table-condensed table-striped'>

	<tr>
		<th>Approved</th>
		<th>Show Name</th>
		<th>Source</th>
		<th>Program</th>
		<th>Time Uploaded</th>
		<th>Create By</th>
		<th>Quality</th>
		<th>Edit</th>
	</tr>
<?php echo $podcastsHtml; ?>

</table>
<form method='post' action='report.php' class='form-inline'>
<input type='hidden' name='year' value='<?php echo $year; ?>'> 
<input type='hidden' name='month' value='<?php echo $month; ?>'> 
<select name='report_type' class='input-medium'>
	<option value='excel2003'>Excel 2003</option>
	<option value='excel2007'>Excel 2007</option>
	<option value='csv'>CSV</option>
</select>
<input type='submit' class='btn btn-primary' name='podcast_report' value='Download Report'>
</form>
<?php

echo $pages_html;

include_once 'includes/footer.inc.php';
?>
