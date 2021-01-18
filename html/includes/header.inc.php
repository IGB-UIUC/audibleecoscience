<?php

$categories = get_categories($db);

$nav_html = "";
$footer_html = "";
$category_html = "";
$i=1;
foreach ($categories as $category) {

	$nav_html .= "<li class='sidenav_cat category_" . $i . "' style='background: url(" . __PICTURE_WEB_DIR__ . "/" . $category['category_nav_filename'] . ") right no-repeat' data-url='podcasts.php?category=" . $category['category_id'] . "'>";
	$nav_html .= "<div class='cat_title cat_title_" . $i . "'><a href='podcasts.php?category=" . $category['category_id'] . "'>";
	$nav_html .= $category['category_name'] . "</a></div></li>";
	$footer_html .= "<li><a href='podcasts.php?category=" . $category['category_id'] . "'>" . $category['category_name'] . "</a></li>";
	$category_html .= "<div class='category'><div class='category_img'>";
	$category_html .= "<a href='podcasts.php?category=" . $category['category_id'] . "'><img src='" . __PICTURE_WEB_DIR__ . "/" . $category['category_filename'] . "' alt='" . $category['category_name'] . "'></a>";
	$category_html .= "</div><div class='category_content'>";
	$category_html .= "<h2><a href='podcasts.php?category=" . $category['category_id'] . "'>" . $category['category_name'] . "</a></h2>";
	$category_html .= "<p></p><p></p></div></div>";
	$i++;
}

?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?>" href="rss.php">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" type="image/ico" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="vendor/components/bootstrap/css/bootstrap.css">
<script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>
<script src="js/tinynav.js" type="text/javascript"></script> 
<link href="css/audible.css" rel="stylesheet" type="text/css">
<TITLE><?php echo __TITLE__; ?></TITLE>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="main_main_container">
<div class="header">
<h1><a href="index.php"><span class="color1">audible</span><span class="color2">eco</span><span class="color3">science</span> <img src="images/earthphones.png" alt="Earth Headphones"></a></h1>
<div class="mission">Audibleecoscience is a database of podcasts on subjects related to global change biology. It is designed as a resource for the general public and for educators looking to assign "required listening" to their students. Reviews of each podcast and links to the original source have been provided by students taking the IB107 class at the University of Illinois. The database is fully text searchable or you can browse on your favorite subject...</div>
<div class="logo_searchbar_area"> <a href="http://illinois.edu" target="_blank"><img src="images/uilogo.jpg" alt="University of Illinois" class="uilogo"></a>
  

    <form class="form-search" method="get" action="podcasts.php">
        <div class="input-prepend">
                  <button type="submit" class="btn">Search</button>      
                   <input name="search" class="input-long search-query" type="text">
               
        </div>
    </form>
    <div class="icons">
  <a href="https://www.facebook.com/pages/Audibleecoscience/404085019693037" target="_blank"><img src="images/icon_facebook.png" alt="facebook" class="icon"></a>
         <a href="http://www.twitter.com/audibleecosci" target="_blank"><img src="images/icon_twitter.png" alt="twitter" class="icon"></a>
       <a href="rss.php"><img src="images/icon_rss.png" alt="rss" class="icon"></a>
       <div class="fb-like fb" data-href="http://audibleecoscience.org/" data-width="50" data-layout="button_count" data-show-faces="false" data-send="false"></div>
			
 </div>
  <div class="clear"></div>
<!-- end: class="logo_searchbar_area" -->
</div>
<!-- end: class="header" -->
</div>

      
   <!-- Left side Navigation -->
  <?php require_once('category_navigation.inc.php'); ?>
   <!-- end Left side Navigation -->
    
    
    
    
 <div class="main_container">

