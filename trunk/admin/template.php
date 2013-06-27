<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$user = new user($db,$ldap,$username);
$admin = $user->is_admin();

if (!($admin)){
        header('Location: invalid.php');
}

?>



<?php

include 'includes/footer.inc.php';
?>
