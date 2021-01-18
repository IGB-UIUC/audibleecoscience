<?php
require_once 'includes/main.inc.php';
$session = new \IGBIllinois\session(__SESSION_NAME__);
$session->destroy_session();
?>
<html lang="en">
<head>
<meta charset='UTF-8'>
<link rel="stylesheet" type="text/css"
        href="../vendor/components/bootstrap/css/bootstrap.min.css">
<TITLE><?php echo __TITLE__; ?></TITLE>

</head>

<body>

<div class='navbar navbar-inverse'>
        <div class='navbar-inner'>
                <div class='container'>
                        <div class='span8 brand'>
                                <?php echo __TITLE__; ?>
                        </div>
                        <div class='span2 pull-right'>
                                <p class='navbar-text pull-right'>
                                        <small>Version <?php echo __VERSION__; ?></small>
                                </p>
                        </div>
                </div>
        </div>
</div>
<div class='container-fluid'>


<div class='alert alert-block alert-success' style='text-align: center'>You are logged out of the website.
<br>Click <a href='../index.php'>here</a> to go back to homepage
</div>

<?php

require_once 'includes/footer.inc.php';
?>
