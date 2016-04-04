<?php
require_once 'includes/main.inc.php';
require_once 'includes/session.inc.php';

$message = "";
if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

if (isset($_GET['id']) && (is_numeric($_GET['id']))) {

	$category_id = $_GET['id'];

	$category = new category($db,"",$category_id);
	$categoryName = $category->get_name();
	$url_data = array('id'=>$category_id);
	if (isset($_POST['update'])) {
		//Update category name
		if ($_POST['category'] != $category->get_name()) {	
			$categoryName = $_POST['category'];
			$result = $category->set_name($categoryName);
			$message = "<div class='alert'>" . $result['MESSAGE'] . "</div>";
		}

		//Update Main Picture
		if (isset($_FILES['picture']['name'])) {
		
			$pictureName = $_FILES['picture']['name'];
	        	$pictureError = $_FILES['picture']['error'];
	        	$pictureTmpLocation = $_FILES['picture']['tmp_name'];
			if ($pictureError !== 0) {
				$message .= "<div class='alert'>Error uploading main picture. Error: " . $uploadErrors[$pictureError];
				$message .= "</div>";

        		}	
			else {
				$category->set_picture($pictureName,$pictureTmpLocation,__PICTURE_DIR__);
				
			}


		}
		//Update Navigation Picture
		if (isset($_FILES['nav_picture']['name'])) {
                        $navPictureName = $_FILES['nav_picture']['name'];
                        $navPictureError = $_FILES['nav_picture']['error'];
                        $navPictureTmpLocation = $_FILES['nav_picture']['tmp_name'];
                        if ($navPictureError !== 0) {
                                $message .= "<div class='alert'>Error uploading navigation bar picture. Error: " . $uploadErrors[$navPictureError];
				$message .= "</div>";

                        }
                        else {
                                $category->set_nav_picture($navPictureName,$navPictureTmpLocation,__PICTURE_DIR__);

                        }


                }

		unset($_POST);
	}

	elseif (isset($_POST['cancel'])) {
		unset($_POST);
		$message = "No Changes made";
	}


}

require_once 'includes/header.inc.php';
?>

<form method='post' class='form-horizontal' action='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query($url_data); ?>' enctype='multipart/form-data'>
<input type='hidden' name='MAX_FILE_SIZE' value='<?php echo get_max_upload_size('bytes'); ?>'>
<fieldset>
                <legend>Category - <?php echo $category->get_name(); ?></legend>
                <div class='control-group'>
                        <label class='control-label' for='category_input'>New Category Name:</label>
                        <div class='controls'>
                                <input type='text' name='category' id='category_input'
                                        value='<?php if (isset($categoryName)) { echo $categoryName; } ?>'>
                        </div>
                </div>
		<div class='control-group'>
			<label class='control-label' for='current_pic_input'>Current Picture:</label>
				<img width='400' height='400' src='../<?php echo __PICTURE_WEB_DIR__ . "/" . $category->get_picture(); ?>'>
		</div>
                <div class='control-group'>
                        <label class='control-label' for='picture_input'>New Picture:</label>
                        <div class='controls'>
                                <input type='file' class='btn btn-file' name='picture' id='picture_input' size='40'>
                        </div>
                </div>
		<div class='control-group'>
			<label class='control-label' for='current_nav_input'>Current Navigation Picture:</label>
			<img src='../<?php echo __PICTURE_WEB_DIR__ . "/" . $category->get_nav_picture(); ?>'>

		</div>
		<div class='control-group'>
                        <label class='control-label' for='nav_picture_input'>New Navigation Picture:</label>
                        <div class='controls'>
                                <input type='file' class='btn btn-file' name='nav_picture' id='nav_picture_input' size='40'>
                        </div>
                </div>
                <div class='control-group'>
                        <div class='controls'>
                                <input class='btn btn-primary' type='submit' name='update'
                                        value='Update Category'> <input class='btn btn-warning' type='submit'
                                        name='cancel' value='Cancel'>
                        </div>
                </div>
        </fieldset>

</form>


<?php if (isset($message)) { 
	echo $message;
}

?>
<?php require_once 'includes/footer.inc.php'; ?>
