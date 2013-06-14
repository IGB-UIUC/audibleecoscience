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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="includes/styles.css">
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?> RSS Feed" href="rss.php">
<TITLE><?php echo __TITLE__; ?></TITLE>

</HEAD>

<BODY>

<div id='container'>
	<div id='header'>
		<img src='images/logo.jpg' align='left'>
		<p align='absmiddle' class='subHeader'>Andrew Leakey's Podcasts Webpage</p>
	</div>
	<div id='date'>
	
	<?php echo $today; ?>
	</div>
	<div id='navigation'>
		<ul>
			<li><a href='index.php'>Main</a></li>
			<li><a href='search.php'>Search</a></li>
			<?php echo $categoriesHtml; ?>
			<li><a href='rss.php'>RSS Feed</a></li>
			<li><a href='login.php'>Login</a></li>
		</ul>
	</div>
	<div id='main'>
