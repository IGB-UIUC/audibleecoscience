<?php
////////////////////////////////////
//						
//	Leakey Podcasts				
//	settings.inc.php			
//						
//	Settings for the scripts.		
//						
//	David Slater				
//	May 2009				
//						
////////////////////////////////////


////////System Settings///////////
define("__TITLE__","Audibleecoscience");
define("__VERSION__","1.02");
define("__SESSION_NAME__","audibleecoscience");
define("__SESSION_TIMEOUT__",3000);
define("__TIMEZONE__","America/Chicago");

////////MySQL Settings///////////
define("__MYSQL_HOST__","");
define("__MYSQL_USER__","");
define("__MYSQL_PASSWORD__","");
define("__MYSQL_DATABASE__","");

//////LDAP settings//////////
define("__LDAP_HOST__","");
define("__LDAP_BASE_DN__","");
define("__LDAP_SSL__",TRUE);
define("__LDAP_PORT__",);
define("__LDAP_BIND_USER__","");
define("__LDAP_BIND_PASS__","");
define("__PODCAST_DIR__","");
define("__PODCAST_WEB_DIR__","");
define("__PICTURE_DIR__","");
define("__PICTURE_WEB_DIR__","");
///////Various Program Settings///////////
define("__FILETYPES__","mp3");
define("__COUNT__",10);
define("__MAX_SUMMARY_WORDS__",250);
define("__MAX_SHORT_SUMMARY_CHARS__",200);

//Possible errors when you upload a file
$uploadErrors = array(
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
    3 => 'The uploaded file was only partially uploaded.',
    4 => 'No file was uploaded.',
    6 => 'Missing a temporary folder.',
    7 => 'Failed to write file to disk.',
    8 => 'File upload stopped by extension.',
);


?>
