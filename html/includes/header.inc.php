<?php

$categories = get_categories($db);

$nav_html = "";
$footer_html = "";
$category_html = "";
foreach ($categories as $category) {

	$nav_html .= "<li class='sidenav_cat' style='background: url(" . __PICTURE_WEB_DIR__ . "/" . $category['category_nav_filename'] . ") right no-repeat' data-url='category.php?=1'>";
	$nav_html .= "<div class='cat_title cat_title_1'><a href='podcasts.php?=category=" . $category['category_id'] . "'>";
	$nav_html .= $category['category_name'] . "</a></div></li>";
	$footer_html .= "<li><a href='podcasts.php?category=" . $category['category_id'] . "'>" . $category['category_name'] . "</a></li>";
	$category_html .= "<div class='category'><div class='category_img'>";
	$category_html .= "<img src='" . __PICTURE_WEB_DIR__ . "/" . $category['category_filename'] . "' alt='" . $category['category_name'] . "'>";
	$category_html .= "</div><div class='category_content'>";
	$category_html .= "<h2><a href='podcasts.php?category=" . $category['category_id'] . "'>" . $category['category_name'] . "</a></h2>";
	$category_html .= "<p></p><p></p></div></div>";

}

?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?>" href="rss.php">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="includes/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/tinynav.js" type="text/javascript"></script> 
<script src="includes/johndyer-mediaelement-2601db5/build/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="css/mediaelementplayer.css">
<link href="css/audible.css" rel="stylesheet" type="text/css">
<TITLE><?php echo __TITLE__; ?></TITLE>
</head>

<body>
<div class="main_main_container">
<div class="header">
<h1><a href="index.php"><span class="color1">audible</span><span class="color2">eco</span><span class="color3">science</span></a></h1>

<div class="logo_searchbar_area"> <a href="http://illinois.edu" target="_blank"><img src="images/uilogo.jpg" alt="University of Illinois" class="uilogo"></a>
  <a href="http://sib.illinois.edu" target="_blank"><img src="images/banner_school.png" alt="School of Integrative Biology"></a>

    <form class="form-search" method="get" action="podcasts.php">
        <div class="input-append">
                        <input name="search" class="input-long search-query" type="text">
                <button type="submit" class="btn">Search</button>
        </div>
    </form>
    <div class="icons">
  <a href="#"><img src="images/icon_facebook.png" alt="facebook" class="icon"></a>
         <a href="#"><img src="images/icon_twitter.png" alt="twitter" class="icon"></a>
       <a href="rss.php"><img src="images/icon_rss.png" alt="rss" class="icon"></a>
 </div>
  <div class="clear"></div>
<!-- end: class="header" -->
</div>

      
   <!-- Left side Navigation -->
  <?php include_once('category_navigation.inc.php'); ?>
   <!-- end Left side Navigation -->
    
    
    
    
 <div class="main_container">

