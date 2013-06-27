<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

$user = new users($db);
$group = $user->getGroup($username);

if (!($group==1)){
        header('Location: invalid.php');
}


$categories = new categories($db);


$headCategories = $categories->getHeadCategories();


$categoriesListHtml = "";
for ($i=0;$i<count($headCategories);$i++) {
	$category_id = $headCategories[$i]['category_id'];
	$category_name = $headCategories[$i]['category_name'];

	$categoriesListHtml .= "<tr><td><a href='category.php?id=" . $category_id . "'>" . $category_name . "</a></td><td></td></tr>";
	$childCategories = $categories->getChildren($category_id);
	for ($j=0;$j<count($childCategories);$j++) {
		$child_name = $childCategories[$j]['category_name'];
		$child_id = $childCategories[$j]['category_id'];
		$categoriesListHtml .= "<tr><td></td>";
		$categoriesListHtml .= "<td><a href='category.php?id=" . $child_id . "'>" . $child_name . "</a></td></tr>";
	}

}

include_once 'includes/header.inc.php';
?>

<h3>Categories</h3>
<table class='table table-bordered'>
	<tr><th>Head Category</th><th>Sub Category</th></tr>

<?php echo $categoriesListHtml; ?>
</table>



<?php

include 'includes/footer.inc.php';
?>
