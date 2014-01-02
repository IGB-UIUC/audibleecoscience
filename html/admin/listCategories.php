<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

$categories = get_categories($db);




$categoriesListHtml = "";
foreach ($categories as $category) {
	$url_data = array('id'=>$category['category_id']);
	$categoriesListHtml .= "<tr><td><img src='../" . __PICTURE_WEB_DIR__ . "/" . $category['category_nav_filename'] . "'></td>";
	$categoriesListHtml .= "<td><a href='category.php?" . http_build_query($url_data) . "'>" . $category['category_name'];
	$categoriesListHtml .= "</a></td></tr>";

}

include_once 'includes/header.inc.php';
?>

<h3>Categories</h3>
<table class='table table-bordered'>
	<tr><th></th><th>Category</th></tr>

<?php echo $categoriesListHtml; ?>
</table>



<?php

include 'includes/footer.inc.php';
?>
