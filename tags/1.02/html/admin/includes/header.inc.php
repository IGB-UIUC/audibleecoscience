<!DOCTYPE html>
<html lang="en">
<head>
<script language='JavaScript' src='includes/main.inc.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?> RSS Feed" href="rss.php">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css"
        href="../includes/bootstrap/css/bootstrap.min.css">
<script src="../includes/johndyer-mediaelement-2601db5/build/jquery.js"></script>
<script src="../includes/johndyer-mediaelement-2601db5/build/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="../includes/johndyer-mediaelement-2601db5/build/mediaelementplayer.css" />
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
<div class='container-fluid'>
<div class='row'>
	<div class='span3 well'>
		<div class='sidebar-nav'>
			<ul class='nav nav-list'>
				<li class='nav-header'><i class='icon-music'></i>Podcasts</li>
				<li><a href='index.php'>My Podcasts</a></li>
				<li><a href='addPodcast.php'>Add Podcast</a></li>
				<?php if ($login_user->is_admin()) {

				echo "<li><a href='approve.php'>All Unapproved Podcasts</a></li>
					<li><a href='listApprovedPodcasts.php'>All Approved Podcasts</a></li>
					<li><a href='ta_approve.php'>TA's Unapproved Podcasts</a></li>
					
					<li><a href='listPodcasts.php'>List All Podcasts</a></li>
					<li><a href='statistics.php'>Statistics</a></li>
					<li class='nav-header'><i class='icon-tasks'></i>Categories</li>
					<li><a href='addCategory.php'>Add Category</a></li>
					<li><a href='listCategories.php'>List Categories</a></li>
					<li class='nav-header'><i class='icon-user'></i>Users</li>
					<li><a href='addUser.php'>Add User Account</a></li>
					<li><a href='listUsers.php'>List Accounts</a></li>
					<li><a href='importUsers.php'>Import Users</a></li>";
				} ?>
				<li><a href='logout.php'>Log Out</a></li>
			</ul>
                </div>
	</div>
	<div class='span9'>


