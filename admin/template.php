<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$user = new users($db);
$group = $user->getGroup($username);

?>



<?php

include 'includes/footer.inc.php';
?>
