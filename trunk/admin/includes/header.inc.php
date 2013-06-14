<?php

include_once 'users.class.inc.php';


$user = new users($db);
$group = $user->getGroup($username);

$nopermission = "<div id='error'>You do not have permission to view this page.</div>";


if ($group=="1"){
	$sidebar = "<div id='navigation'>
		<ul> 
		<li><a href='index.php'>My Podcasts</a></li>
		<li><a href='addPodcast.php'>Add Podcast</a></li>
		<li><a href='approve.php'>Unapproved Podcasts</a></li>
		<li><a href='listPodcasts.php'>List All Podcasts</a></li>
		<li><a href='instructions.php'>Instructions</a></li>
		<li><a href='categories.php'>Categories</a>
			<ul>
				<li><a href='addCategory.php'>Add Category</a></li>
				<li><a href='listCategories.php'>List Categories</a></li>
			</ul>
		</li>
		<li><a href='users.php'>Manage Users</a>
			<ul>	
				<li><a href='addUser.php'>Add User Account</a></li>
				<li><a href='listUsers.php'>List Accounts</a></li>
				<li><a href='importUsers.php'>Import Users</a></li>
			</ul>
		</li>
		<li><a href='logout.php'>Log Out</a></li>			
		</ul>
		</div>";
}
else{
	$sidebar = "<div id='navigation'>	
		<ul> 
			<li><a href='index.php'>My Podcasts</a></li>
			<li><a href='addPodcast.php'>Add Podcast</a></li>
			<li><a href='instructions.php'>Instructions</a></li>
			<li><a href='logout.php'>Log Out</a></li>			
			</ul>
		</div>";
}

$today = date("F j, Y");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../includes/styles.css">

<TITLE>Leakey Podcasts</TITLE>

</HEAD>

<BODY>
<div id='container'>
<div id='header'>
<img src='../images/logo.jpg'>
</div>
<div id='date'>
<?php echo $today; ?>
</div>

<?php echo $sidebar;
 
?>

<div id="main">
