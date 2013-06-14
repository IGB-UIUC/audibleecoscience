<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';
include_once 'functions.inc.php';

$user = new users($db);

$group = $user->getGroup($username);
if (!($group==1)){ header( 'Location: invalid.php' ) ;}


if (isset($_POST['search'])) {
	$terms = $_POST['terms'];
	
	$userList = $user->search($terms);

	if (count($userList) == '0') {
		$msg = "<b class='error'>No Search Results</b>";
	}

}
else {
	$userList = $user->getUsers();

}

$count = 40;

$numUsers = count($userList);
$numPages = getNumPages($numUsers,$count);
$currentPage = $start / $count +1;

//Number of pages
$pagesHtml = "<p>";
if ($currentPage > 1) {
        $startRecord = $start - $count;
        $pagesHtml .= "<a href='listUsers.php?id=" . $category_id . "&start=" . $startRecord . "'>Back</a> |";
}
for ($i=0;$i<$numPages;$i++) {
        $pageNumber = $i +1;
        $startRecord = $i * $count;
        $pagesHtml .= " <a href='listUsers.php?id=" . $category_id . "&start=" . $startRecord . "'>" . $pageNumber . "</a> ";
        if ($pageNumber != $numPages) {
                $pagesHtml .= " | ";
        }
}
if ($currentPage < $numPages) {
        $startRecord = $start + $count;
        $pagesHtml .= " | <a href='listUsers.php?id=" . $category_id . "&start=" . $startRecord . "'>Next</a> ";
}
        $pagesHtml .= "</p>";





$usersHtml = "";
for ($i=0;$i<count($userList);$i++) {

	$user_id = $userList[$i]['user_id'];
	$first_name = $userList[$i]['user_firstname'];
	$last_name = $userList[$i]['user_lastname'];
	$user_name = $userList[$i]['user_name'];
	$groupname = $userList[$i]['group_name'];
	$usersHtml .= "<tr>";
	$usersHtml .= "<td>" . $first_name . " " . $last_name . "</td>";
	$usersHtml .= "<td>" . $user_name . "</td>";
	$usersHtml .= "<td>" . $groupname . "</td>";
	$usersHtml .= "<td><input type='button' value='Edit' onClick=\"window.location.href='user.php?id=" . $user_id . "'\"></td>";








}




?>

<div id='rightside'>
	<form method='post' action='listUsers.php'>
	<input type='text' name='terms' value='<?php if (isset($terms)) { echo $terms; } ?>'>&nbsp&nbsp<input type='submit' name='search' value='Search'>
	</form>
	<br>
</div>


<p class='subHeader'>Search Users</p>

<?php if (isset($msg)) { echo $msg; } ?>
<table>

<?php
	echo $usersHtml;
?>

</table>

<?php
if ($numPages > 1) { echo $pagesHtml; }

include 'includes/footer.inc.php';
?>
