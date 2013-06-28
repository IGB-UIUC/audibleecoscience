<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}



$categories = new categories($db);



if (isset($_POST['add_category'])) {
	if (isset($_POST['subCategory'])) {
		$result = $categories->addChild($_POST['category'],$_POST['headCategory']);

	}
	else {
		$result = $categories->add($_POST['category']);
		$message = $result['MESSAGE'];
		if ($result['RESULT']) {
			unset($_POST);
		}
	}
	if ($result['RESULT']) {
		unset($_POST);
	}
	$message = $result['MESSAGE'];

}
elseif (isset($_POST['cancel'])) {
	unset($_POST);
	
}


$headCategories = $categories->getHeadCategories();


$headCategoriesHtml = "";
foreach ($headCategories as $category) {
	$category_id = $category['category_id'];
	$category_name = $category['category_name'];
	$headCategoriesHtml .= "<option value='" . $category_id . "'>" . $category_name . "</option>";


}


include_once 'includes/header.inc.php';
?>

<h3>Add Category</h3>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' class='form-vertical' name='addCategoryForm'>
<br>Category Name: 
<br><input type='text' name='category' value='<?php if (isset($_POST['category'])) { echo $_POST['category']; } ?>'>
<br>Sub Category: <input type='checkbox' OnClick='javascript:enableHeadCategories()' name='subCategory' id='subCategory'>
<br><select name='headCategory' id='headCategory' disabled='true'>
<?php echo $headCategoriesHtml; ?>

</select>
<br><input class='btn btn-primary' type='submit' name='add_category' value='Add'>
<input class='btn btn-warning' type='submit' name=cancel' value='Cancel'>
</form>

<?php 
if (isset($message)) { 
	echo "<div class='alert'>" . $message . "</div>"; 
} 

?>
<?php

include 'includes/footer.inc.php';
?>
