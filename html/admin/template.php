<?php
require_once 'includes/main.inc.php';
require_once 'includes/session.inc.php';
require_once 'includes/header.inc.php';

if (!($login_user->is_admin())){
        header('Location: invalid.php');
}

require_once 'includes/header.inc.php';

?>



<?php

require_once 'includes/footer.inc.php';
?>
