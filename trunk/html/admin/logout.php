<?php
include_once 'includes/main.inc.php';
$session = new session(__SESSION_NAME__);
$session->destroy_session();
?>
<html lang="en">
<head>
<script language='JavaScript' src='includes/main.inc.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="alternate" type="application/rss+xml" title="<?php echo __TITLE__; ?> RSS Feed" href="rss.php">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css"
        href="../includes/bootstrap/css/bootstrap.min.css">
<script src="../includes/johndyer-mediaelement-2601db5/build/jquery.js"></script>
<script src="../includes/johndyer-mediaelement-2601db5/build/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="../includes/johndyer-mediaelement-2601db5/build/mediaelementplayer.css" />
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

include_once 'includes/footer.inc.php';
?>
