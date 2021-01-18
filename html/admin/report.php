<?php
require_once 'includes/main.inc.php';
require_once 'includes/session.inc.php';

if (isset($_POST['podcast_report'])) {

	$year = $_POST['year'];
	$month = $_POST['month'];
	$filename = "podcast_report";	
	$podcast_report = get_podcast_report($db,$month,$year);
	if ($_POST['report_type'] == 'csv') {
		$ext = 'csv';
		$filename .= "." . $ext;
		\IGBIllinois\report::create_csv_report($podcast_report,$filename);
	}
	elseif ($_POST['report_type'] == 'excel2003') {
		$ext = 'xls';
		$filename .= "." . $ext;
		\IGBIllinois\report::create_excel_2003_report($podcast_report,$filename);
	}
	elseif ($_POST['report_type'] == 'excel2007') {
		$ext = 'xlsx';
		$filename .= "." . $ext;
		\IGBIllinois\report::create_excel_2007_report($podcast_report,$filename);
	}
}

?>
