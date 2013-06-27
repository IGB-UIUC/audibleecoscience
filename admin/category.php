<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

$user = new user($db,$ldap,$username);
$admin = $user->is_admin();
if (!($admin)){
        header('Location: invalid.php');
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id = $_GET['id'];

	$categories = new categories($db);

	$categoryName = $categories->getName($id);



	if (isset($_POST['remove'])) {
		$result = $categories->remove($id);
		if ($result == 0) {
			$message = "<b class='error'>Unable to remove category.  Podcasts or subcategories are still inside this category.</b>";


		}
		else {
			Header("Location: categories.php");
		}	
	}
	elseif (isset($_POST['updateName'])) {
		$newName = $_POST['newName'];
		$newName = trim(rtrim($newName));
		
		if ($newName == "") {
			$message = "<b class='error'>Unable to update category name.  Name is blank.</b>";
		}	
		else {
			$categories->setName($id,$newName);
			$categoryName = $categories->getName($id);
		}




	}




}

include_once 'includes/header.inc.php';
?>

<h3>Category - <?php echo $categoryName; ?></h3>
<form method='post' action='category.php?id=<?php echo $id; ?>'>
<br>Name: <input type='text' name='newName' value='<?php echo $categoryName; ?>'>

<br><input class='btn btn-primary' type='submit' value='Change Name' name='update_name'>
<input class='btn btn-danger' type='submit' value='Remove' name='remove'>
<br><?php if (isset($message)) { echo $message; } ?>





</form>

<?php

include 'includes/footer.inc.php';
?>
