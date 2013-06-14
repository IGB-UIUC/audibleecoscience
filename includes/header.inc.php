<?php

$categories = new categories($db);
$headCategories = $categories->getHeadCategories();

$categoriesHtml = "";
for ($i=0;$i<count($headCategories);$i++) {
	$category_id = $headCategories[$i]['category_id'];
	$category_name = $headCategories[$i]['category_name'];

	$children = $categories->getChildren($category_id);
	if (count($children) > 0) {
		$categoriesHtml .= "<li><a href='listPodcasts.php?id=" . $category_id . "'>" . $category_name . "</a><ul>";
		for ($j=0;$j<count($children);$j++) { 
			$children_id = $children[$j]['category_id'];
			$children_name = $children[$j]['category_name'];
			$categoriesHtml .= "<li><a href='listPodcasts.php?id=" . $children_id . "'>" . $children_name . "</a></li>";
			
		}
		$categoriesHtml .= "</ul></li>";

	}
	elseif (count($children) == 0) {
		$categoriesHtml .= "<li><a href='listPodcasts.php?id=" . $category_id . "'>" . $category_name . "</a><li>";


	}
}


$today = date("F j, Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?> RSS Feed" href="rss.php">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css"
        href="includes/bootstrap/css/bootstrap.min.css">
<TITLE><?php echo __TITLE__; ?></TITLE>

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
	<div class='container'>
                <div class='row-fluid'>
                        <div class='span3 well'>
                                <div class='sidebar-nav'>
                                        <ul class='nav nav-list'>
						<li><a href='index.php'>Main</a></li>
						<li><a href='search.php'>Search</a></li>
						<?php echo $categoriesHtml; ?>
						<li><a href='rss.php'>RSS Feed</a></li>
						<li><a href='login.php'>Login</a></li>
					</ul>
				</div>
			</div>
			<div class='span9'>

