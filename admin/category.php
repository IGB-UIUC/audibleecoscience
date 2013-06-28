<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id = $_GET['id'];

	$categories = new categories($db);
	$categoryName = $categories->getName($id);

	if (isset($_POST['remove'])) {
		$result = $categories->remove($id);
		if ($result['RESULT']) {
			header("Location: listCategories.php");
		}

	}
	elseif (isset($_POST['update'])) {
		$categoryName = $_POST['category_name'];	
		$result = $categories->setName($id,$_POST['category_name']);
		$message = $result['MESSAGE'];

	}




}

include_once 'includes/header.inc.php';
?>

<h3>Category - <?php echo $categoryName; ?></h3>
<form method='post' action='category.php?id=<?php echo $id; ?>'>
<br>Name: <input type='text' name='category_name' value='<?php echo $categoryName; ?>'>

<br><input class='btn btn-primary' type='submit' value='Change Name' name='update'>
<input class='btn btn-danger' type='submit' value='Remove' name='remove'>
<br><?php if (isset($message)) { 
	echo "<div class='alert'>" . $message . "</div>"; } ?>





</form>

<?php

include 'includes/footer.inc.php';
?>
