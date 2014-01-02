<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

if (isset($_GET['username'])) {

	$user = new user($db,$ldap,$_GET['username']);	
	//Delete User
	if (isset($_POST['delete'])) {
		$result = $user->disable();
		header("Location: listUsers.php");
	}
	//Update User
	if (isset($_POST['update'])) {
		$is_admin = 0;
		if (isset($_POST['admin'])) {
			$is_admin = 1;
			$_POST['school_class'] = "";
			$_POST['section'] = "";
			$_POST['ta'] = "";
		}

		$result = $user->update($is_admin,$_POST['school_class'],$_POST['section'],$_POST['ta']);
		$message = $result['MESSAGE'];
	}

	$podcasts = $user->get_podcasts();
	$podcast_html = "";
	if (count($podcasts)) {	
		foreach ($podcasts as $podcast) {
			$approved = "No";
 	               if ($podcast['podcast_approved'] == 1) {
        	                $approved = "Yes";
                	}

	                $podcasts_html .= "<tr><td>" . $approved . "</td>";
        	        $podcasts_html .= "<td><a href='podcast.php?id=" . $podcast['podcast_id'] . "'>";
                	$podcasts_html .= $podcast['podcast_showName'] . "</a></td>";
	                $podcasts_html .= "<td>" . $podcast['podcast_source'] . "</td>";
        	        $podcasts_html .= "<td>" . $podcast['podcast_programName'] . "</td>";
                	$podcasts_html .= "<td>" . $podcast['podcast_time'] . "</td>";
			$podcasts_html .= "<td><span class='badge " . get_rating_label($podcast['podcast_quality']) . "'>" . $podcast['podcast_quality'] . "</span></td>";
                	$podcasts_html .= "<td><input type='button' value='Edit' ";
	                $podcasts_html .= "onClick=\"window.location.href='editPodcast.php?id=";
        	        $podcasts_html .= $podcast['podcast_id'] . "'\"></td>";
                	$podcasts_html .= "</tr>";
        	}
	}
	else {
		$podcasts_html = "<tr><td colspan='8'>None</td></tr>";

	}



}
	



include_once 'includes/header.inc.php';
?>


<h3><?php echo $user->get_firstname() . " " . $user->get_lastname(); ?></h3>

<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $user->get_username(); ?>' 
	class='form-vertical' name='userForm'>
<fieldset>
<div class='control-group'>
	<label class='control-label' for='inputNetId'>NetID:</label>
	<label class='control-label'> 
	<?php echo $user->get_username(); ?>
	</label>
</div>
<div class='control-group'>
	<label class='checkbox inline' for='inputAdmin'>	
	<input type='checkbox' id='inputAdmin' name='admin' <?php if ($user->is_admin()) { echo "checked=checked"; } ?> onClick='enableUserForm();'>
	Is Admin</label>
</div>
<div class='contorl-group'>
	<label class='control-label' for='inputClass'>Class:</label>
	<div class='controls'>
		<input type='text' name='school_class' value='<?php echo $user->get_school_class(); ?>'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label' for='inputSection'>Section:</label>
	<div class='controls'>
		<input type='text' name='section' value='<?php echo $user->get_section(); ?>'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>TA (netID):</label>
	<div class='controls'>
		<input type='text' name='ta' value='<?php echo $user->get_ta(); ?>'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Time Added: </label>
	<div class='controls'>
		<?php echo $user->get_time_created(); ?>
	</div>
</div>
<div class='control-group'>
	<div class='controls'>
		<input class='btn btn-primary' type='submit' name='update' value='Update User'>
		<input class='btn btn-danger' type='submit' name='delete' value='Delete User' onClick='return confirmUserDelete();'>
	</div>
</div>
</fieldset>
</form>

<script type='text/javascript'>
enableUserForm();
</script>
<hr>
<h4>User Podcast</h4>
<table class='table table-bordered'>
<tr>
                <th>Approved</th>
                <th>Show Name</th>
                <th>Source</th>
                <th>Program</th>
                <th>Time Uploaded</th>
                <th>Quality</th>
                <th>Edit</th>
        </tr>

<?php echo $podcasts_html; ?>
</table>
<?php

if (isset($message)) { echo "<div class='alert'>" . $message . "</div>"; } 


include 'includes/footer.inc.php';
?>
