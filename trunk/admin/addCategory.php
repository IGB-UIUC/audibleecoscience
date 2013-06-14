<?php
include_once 'includes/main.inc.php';

$user = new users($db);
$group = $user->getGroup($username);
if (!($group==1)){header( 'Location: invalid.php' ) ;}



$categories = new categories($db);



if (isset($_POST['add_category'])) {
	$subCategory = $_POST['subCategory'];
	if ($subCategory == "on") {
		$categories->addChild($_POST['category'],$_POST['headCategory']);

	}
	else {
		$categories->add($category);
	}
	header("Location:categories.php");

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
<script type='text/javascript' src='includes/categories.js'></script>

<h3>Add Category</h3>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' name='addCategoryForm' id='addCategoryForm'>
<br>Category Name: 
<br><input type='text' name='category' value='<?php if (isset($_POST['category'])) { echo $_POST['category']; } ?>'>
<br>Sub Category: <input type='checkbox' OnClick='javascript:enableHeadCategories()' name='subCategory' id='subCategory'>
<br><select name='headCategory' id='headCategory' disabled='true'>
<?php echo $headCategoriesHtml; ?>

</select>
<br><input class='btn' type='submit' name='add_category' value='Add'>
</form>


<?php

include 'includes/footer.inc.php';
?>
