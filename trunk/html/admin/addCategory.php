<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

if (isset($_POST['add_category'])) {
	$pictureName = $_FILES['picture']['name'];
        $pictureError = $_FILES['picture']['error'];
	$pictureTmpLocation = $_FILES['picture']['tmp_name'];
	$navPictureName = $_FILES['nav_picture']['name'];
	$navPictureError = $_FILES['nav_picture']['error'];
        $navPictureTmpLocation = $_FILES['nav_picture']['tmp_name'];

	$error = false;
	if ($pictureError != 0) {
		$message = "<div class='alert alert-error'>Error uploading picture. Error: " . $uploadErrors[$pictureError] . "</div>";
		$error = true;
	}
	if ($navPictureError != 0) {
		$message = "<div class='alert alert-error'>Error uploading navigation picture. Error: " . $uploadErrors[$navPictureError] . "</div>";
                $error = true;
	}

	if ($error == false) {
		$category = new category($db);
		$result = $category->create($_POST['category']);
		$message = $result['MESSAGE'];
		if ($result['RESULT']) {
			$category->set_picture($pictureName,$pictureTmpLocation,__PICTURE_DIR__);
			$category->set_nav_picture($navPictureName,$navPictureTmpLocation,__PICTURE_DIR__);
			unset($_POST);
		}
	}
}
elseif (isset($_POST['cancel'])) {
	unset($_POST);
	
}



include_once 'includes/header.inc.php';
?>

<form action='<?php echo $_SERVER['PHP_SELF']; ?>' 
	method='post' class='form-horizontal' name='addCategoryForm' 
	enctype='multipart/form-data'>
<input type='hidden' name='MAX_FILE_SIZE' value='<?php echo get_max_upload_size('bytes'); ?>'>
	<fieldset>
                <legend>Add Category</legend>
                <div class='control-group'>
                        <label class='control-label' for='category_input'>Category Name:</label>
                        <div class='controls'>
                                <input type='text' name='category' id='category_input'
                                        value='<?php if (isset($_POST['category'])) { echo $_POST['category']; } ?>'>
                        </div>
                </div>
                <div class='control-group'>
                        <label class='control-label' for='picture_input'>Category Picture:</label>
                        <div class='controls'>
                                <input type='file' class='btn btn-file' name='picture' id='picture_input' size='40'>
                        </div>
                </div>
		<div class='control-group'>
                        <label class='control-label' for='nav_picture_input'>Navigation Picture:</label>
                        <div class='controls'>
                                <input type='file' class='btn btn-file' name='nav_picture' id='nav_picture_input' size='40'>
                        </div>
                </div>

                <div class='control-group'>
                        <div class='controls'>
                                <input class='btn btn-primary' type='submit' name='add_category'
                                        value='Add Category'> <input class='btn btn-warning' type='submit'
                                        name='cancel' value='Cancel'>
                        </div>
                </div>
	</fieldset>
</form>

<?php 
if (isset($message)) { 
	echo "<div class='alert'>" . $message . "</div>"; 
} 

?>
<?php

include 'includes/footer.inc.php';
?>
