<?php
include_once 'includes/main.inc.php';
include_once 'users.class.inc.php';
include_once 'categories.class.inc.php';

$user = new users($mysqlSettings);
$group = $user->getGroup($username);
if (!($group==1)){header( 'Location: invalid.php' ) ;}



$categories = new categories($mysqlSettings);



if (isset($_POST['addCategories'])) {
	$category = $_POST['category'];
	$subCategory = $_POST['subCategory'];
	$headCategoryId = $_POST['headCategory'];
	if ($subCategory == "on") {
		$categories->addChild($category,$headCategoryId);

	}
	else {
		$categories->add($category);
	}
	header("Location:categories.php");

}



$headCategories = $categories->getHeadCategories();


$headCategoriesHtml;
for ($i=0;$i<count($headCategories);$i++) {
	$category_id = $headCategories[$i]['category_id'];
	$category_name = $headCategories[$i]['category_name'];
	$headCategoriesHtml .= "<option value='" . $category_id . "'>" . $category_name . "</option>";


}


include_once 'includes/header.inc.php';
?>
<script type='text/javascript' src='includes/categories.js'></script>

<p class='subHeader'>Add Category</p>
<form action='addCategory.php' method='post' name='addCategoryForm' id='addCategoryForm'>
<br>Category Name: <input type='text' name='category' value='<?php echo $category; ?>'>
<br>Sub Category: <input type='checkbox' OnClick='javascript:enableHeadCategories()' name='subCategory' id='subCategory'>
<br><select name='headCategory' id='headCategory' disabled='true'>
<?php echo $headCategoriesHtml; ?>

</select>
<br><input type='submit' name='addCategories' value='Add'>
</form>


<?php

include 'includes/footer.inc.php';
?>
