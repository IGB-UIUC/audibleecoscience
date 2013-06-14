<?php
include_once 'includes/main.inc.php';

$user = new users($db);
$group = $user->getGroup($username);
if (!($group==1)){
header( 'Location: invalid.php' ) ;
}

include_once 'includes/header.inc.php';
?>

<br><a href='listCategories.php'>List Categories</a>
<br><a href='addCategory.php'>Add Category</a>

<?php

include 'includes/footer.inc.php';
?>
