<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

?>



<?php

include 'includes/footer.inc.php';
?>
