<?php
require_once 'includes/main.inc.php';
require_once 'includes/session.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

require_once 'includes/header.inc.php';

?>
<h3>Statistics</h3>
<table class='table table-bordered table-condensed table-striped'>

<tr>
	<td>Total Number of Podcasts</td>
	<td><?php echo statistics::get_num_podcasts($db); ?></td>
</tr>
<tr>
	<td>Number Approved Podcasts</td>
	<td><?php echo statistics::get_num_approved_podcasts($db); ?></td>
</tr>


</table>


<?php

require_once 'includes/footer.inc.php';
?>
