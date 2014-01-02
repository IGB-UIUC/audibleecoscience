<?php

include_once 'includes/main.inc.php';
include_once 'rss.inc.php';

$webaddress = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
$rssData = getRss($db,$webaddress);

$output = "<?xml version='1.0' encoding='ISO-8859-1' ?>";
$output .= "<rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'>";
$output .= "<channel>";

$output .= "<title>" . __TITLE__ . "</title>";
$output .= "<link>" . $webaddress . "</link>";
$output .= "<description>Latest Audibleecoscience Podcasts</description>";
$output .= "<language>en-us</language>";
$output .= "<docs>" . $webaddress . substr($_SERVER['PHP_SELF'],1) . "</docs>";


$output .= $rssData;
$output .= "</channel>";
$output .= "</rss>";

header("Content-Type: application/rss+xml; charset=ISO-8859-1");
echo $output;










?>













