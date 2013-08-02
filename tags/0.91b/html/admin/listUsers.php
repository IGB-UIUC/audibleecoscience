<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

$get_array = array();
$count = 30;
$start = 0;
if (isset($_GET['start']) && is_numeric($_GET['start'])) {
        $start = $_GET['start'];
        $get_array['start'] = $start;
}

$search = "";
if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $get_array['search'] = $search;
}


$userList = get_users($db,$search);
$num_users = count($userList);
$pages_url = $_SERVER['PHP_SELF'] . "?" . http_build_query($get_array);
$pages_html = get_pages_html($pages_url,$num_users,$start,$count);



$usersHtml = "";
for ($i=$start;$i<$start+$count;$i++) {
	if (array_key_exists($i,$userList)) {
		$usersHtml .= "<tr>";
		$usersHtml .= "<td>" . $userList[$i]['user_firstname'] . " " . $userList[$i]['user_lastname'] . "</td>";
		$usersHtml .= "<td>" . $userList[$i]['user_name'] . "</td>";
		$usersHtml .= "<td>" . $userList[$i]['user_class'] . "</td>";
		$usersHtml .= "<td>" . $userList[$i]['user_section'] . "</td>";
		$usersHtml .= "<td>" . $userList[$i]['user_ta'] . "</td>";
		$usersHtml .= "<td>" . $userList[$i]['user_admin'] . "</td>";
		$usersHtml .= "<td><input type='button' value='Edit' ";
		$usersHtml .= "onClick=\"window.location.href='user.php?username=" . $userList[$i]['user_name'] . "'\"></td>";
	}

}




?>
<form class='form-search' method='get' action='<?php echo $_SERVER['PHP_SELF'];?>'>
        <div class='input-append'>
                <input type='text' name='search' class='input-long search-query' value='<?php if (isset($search)) { echo $search; } ?>'>
                <input type='submit' class='btn' value='Search'>
        </div>
</form>




<h3>Users</h3>

<?php if (isset($msg)) { echo $msg; } ?>
<table class='table table-bordered'>
	<tr>
		<th>Name</th>
		<th>Username</th>
		<th>Class</th>
		<th>Section</th>
		<th>TA</th>
		<th>Admin</th>
		<th></th>
	</tr>
<?php
	echo $usersHtml;
?>

</table>

<?php
echo $pages_html;

include_once 'includes/footer.inc.php';
?>
