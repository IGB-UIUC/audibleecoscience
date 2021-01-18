<!DOCTYPE html>
<html lang="en"><head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="alternate" type="application/rss+xml" title="Podcast Website - University of Illinois at Urbana-Champaign RSS Feed" href="rss.php">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/tinynav.js" type="text/javascript"></script>
<link href="css/audible.css" rel="stylesheet" type="text/css">
<title>Podcast Website - University of Illinois at Urbana-Champaign</title>
</head>

<body>
<div class="header">
<h1><a href="index.php"><span class="color1">audible</span><span class="color2">eco</span><span class="color3">science</span></a></h1>

	<!-- Header Bar -->
	 <?php require_once('headerbar.php'); ?>
   <!-- end Header Bar -->
      
    
   <!-- Left side Navigation -->
	 <?php require_once('category_navigation.php'); ?>
   <!-- end Left side Navigation -->
    
    
    
    
<div class="main_container">
                    
              

<div class="clear"></div>

<div class="container_category_podcastlist">
   <h2>Category: Food Security</h2>     
   
   
<?php
  
  $numba = 1;
  
  while ($numba < 7)
  {?>
    	<div class="category">
  <div class="category_img"><a href="podcast.php"><img src="images/1280-country-food-security.jpg" alt="food security"></a></div>
  <div class="category_content">
    <h2><a href="podcast.php">Food Security</a></h2>
    <p><a href="podcast.php">Now that we know who you are, I know who I am. I'm not a mistake! It all makes sense! </a></p>
    <p><a href="podcast.php">In a comic, you know how you can tell who the arch-villain's</a></p>
  </div>
  <div class="clear"></div>
</div>
<?php
 	$numba = $numba + 1;
	
	
	 } // END: while($numba < 7)
  	
	
 
 ?>

<div class="pagination pagination-centered"><ul><li class="disabled"><a href="#">«</a></li><li class="disabled"><a href="index.php?&amp;start=0">1</a></li><li><a href="index.php?&amp;start=3">2</a></li><li><a href="index.php?&amp;start=3">»</a></li> </ul></div>

<!-- end class="container_category_podcastlist" -->
    </div>
    
    
<!-- top 10 podcasts -->
<?php
	require_once('top10_podcasts.php');
?>
<!-- end of top 10 -->

<?php require_once 'includes/footer.inc.php'; ?>
