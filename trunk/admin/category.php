<?php
include_once 'includes/main.inc.php';
include_once 'users.class.inc.php';
include_once 'categories.class.inc.php';

$user = new users($mysqlSettings);
$group = $user->getGroup($username);
if (!($group==1)){header( 'Location: invalid.php' ) ;}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id = $_GET['id'];

	$categories = new categories($mysqlSettings);

	$categoryName = $categories->getName($id);



	if (isset($_POST['remove'])) {
		$result = $categories->remove($id);
		if ($result == 0) {
			$removeMsg = "<b class='error'>Unable to remove category.  Podcasts or subcategories are still inside this category.</b>";


		}
		else {
			Header("Location: categories.php");
		}	
	}
	elseif (isset($_POST['updateName'])) {
		$newName = $_POST['newName'];
		$newName = trim(rtrim($newName));
		
		if ($newName == "") {
			$updateNameMsg = "<b class='error'>Unable to update category name.  Name is blank.</b>";
		}	
		else {
			$categories->setName($id,$newName);
			$categoryName = $categories->getName($id);
		}




	}




}

include_once 'includes/header.inc.php';
?>

<p class='subHeader'>Category - <?php echo $categoryName; ?></p>
<form method='post' action='category.php?id=<?php echo $id; ?>'>
<br>Name: <input type='text' name='newName' value='<?php echo $categoryName; ?>'><input type='submit' value='Change Name' name='updateName'>

<br><input type='submit' value='Remove' name='remove'>
<br><?php if (isset($removeMsg)) { echo $removeMsg; } ?>





</form>

<?php

include 'includes/footer.inc.php';
?>
