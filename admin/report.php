<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'data_functions.inc.php';
include_once 'reports.inc.php';


elseif (isset($_POST['podcast_report'])) {

	if ($_POST['report_type'] == 'csv') {
		$ext = 'csv';
		create_csv_report($job_report,$filename);
	}
	elseif ($_POST['report_type'] == 'excel2003') {
		$ext = 'xls';
		create_excel_2003_report($job_report,$filename);
	}
	elseif ($_POST['report_type'] == 'excel2007') {
		$ext = 'xlsx';
		create_excel_2007_report($job_report,$filename);
	}
}

?>
