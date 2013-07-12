<?php

$categories = new categories($db);
$headCategories = $categories->getHeadCategories();

$categoriesHtml = "";
for ($i=0;$i<count($headCategories);$i++) {
	$category_id = $headCategories[$i]['category_id'];
	$category_name = $headCategories[$i]['category_name'];

	$children = $categories->getChildren($category_id);
	if (count($children) > 0) {
		$categoriesHtml .= "<li><a href='index.php?category=" . $category_id . "'>" . $category_name . "</a><ul>";
		for ($j=0;$j<count($children);$j++) { 
			$children_id = $children[$j]['category_id'];
			$children_name = $children[$j]['category_name'];
			$categoriesHtml .= "<li><a href='index.php?category=" . $children_id . "'>" . $children_name . "</a></li>";
			
		}
		$categoriesHtml .= "</ul></li>";

	}
	elseif (count($children) == 0) {
		$categoriesHtml .= "<li><a href='index.php?category=" . $category_id . "'>" . $category_name . "</a><li>";


	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?> RSS Feed" href="rss.php">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css"
        href="includes/bootstrap/css/bootstrap.min.css">
<script src="includes/johndyer-mediaelement-2601db5/build/jquery.js"></script>
<script src="includes/johndyer-mediaelement-2601db5/build/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="includes/johndyer-mediaelement-2601db5/build/mediaelementplayer.css" />
<TITLE><?php echo __TITLE__; ?></TITLE>
<script type='text/javascript' src='includes/main.inc.js'></script>
</head>

<body>
	<div class='navbar navbar-inverse'>
                <div class='navbar-inner'>
                        <div class='container'>
                                <div class='span8 brand'>
                                        <?php echo __TITLE__; ?>
                                </div>
                                <div class='span2 pull-right'>
                                        <p class='navbar-text pull-right'>
                                                <small>Version <?php echo __VERSION__; ?>
                                                </small>
                                        </p>
                                </div>
                        </div>
                </div>
        </div>
	<div class='container-fluid'>
                <div class='row'>
                        <div class='span2 well'>
                                <div class='sidebar-nav'>
                                        <ul class='nav nav-list'>
						<li><a href='index.php'>Main</a></li>
						<li class='nav-header'>Categories</li>
						<?php echo $categoriesHtml; ?>
						<li><a href='rss.php'>RSS Feed</a></li>
						<li><a href='login.php'>Login</a></li>
					</ul>
				</div>
			</div>
			<div class='span9'>

