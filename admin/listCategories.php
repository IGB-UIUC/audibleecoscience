<?php

include_once 'includes/main.inc.php';
include_once 'categories.class.inc.php';
include_once 'users.class.inc.php';
$user = new users($mysqlSettings);
$group = $user->getGroup($username);
if (!($group==1)){
        header('Location: invalid.php');
}


$categories = new categories($mysqlSettings);


$headCategories = $categories->getHeadCategories();


$categoriesListHtml;
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

<p class='subHeader'>Categories</p>
<table>
	<tr><td>Head Category</td><td>Sub Category</td></tr>

<?php echo $categoriesListHtml; ?>
</table>



<?php

include 'includes/footer.inc.php';
?>
