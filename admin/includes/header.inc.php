<?php

$user = new users($db);
$group = $user->getGroup($username);

$nopermission = "<div id='error'>You do not have permission to view this page.</div>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?> RSS Feed" href="rss.php">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css"
        href="../includes/bootstrap/css/bootstrap.min.css">
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
					<small>Version <?php echo __VERSION__; ?></small>
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
				<li><a href='index.php'>My Podcasts</a></li>
				<li><a href='addPodcast.php'>Add Podcast</a></li>
	                        <li><a href='instructions.php'>Instructions</a></li>
				<?php if ($group == "1") {

				echo "<li><a href='approve.php'>Unapproved Podcasts</a></li>
					<li><a href='listPodcasts.php'>List All Podcasts</a></li>
					<li class='nav-header'>Categories</li>
					<li><a href='addCategory.php'>Add Category</a></li>
					<li><a href='listCategories.php'>List Categories</a></li>
					<li class='nav-header'>Users</li
					<li><a href='addUser.php'>Add User Account</a></li>
					<li><a href='listUsers.php'>List Accounts</a></li>
					<li><a href='importUsers.php'>Import Users</a></li>";
				} ?>
				<li><a href='logout.php'>Log Out</a></li>
			</ul>
                </div>
	</div>
	<div class='span9'>


