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
define("__TITLE__","Podcast Website - University of Illinois at Urbana-Champaign");
define("__VERSION__","0.91Beta");
define("__SESSION_NAME__","leakeylab");
define("__SESSION_TIMEOUT__",600);
define("__TIMEZONE__","America/Chicago");

////////MySQL Settings///////////
define("__MYSQL_HOST__","127.0.0.1");
define("__MYSQL_USER__","leakey_user");
define("__MYSQL_PASSWORD__","9CPqhprMaH7RLpsP");
define("__MYSQL_DATABASE__","leakey_podcasts");

//////LDAP settings//////////
define("__LDAP_HOST__","ad.uillinois.edu");
define("__LDAP_BASE_DN__","dc=ad,dc=uillinois,dc=edu");
define("__LDAP_SSL__",TRUE);
define("__LDAP_PORT__",636);
define("__LDAP_BIND_USER__","CN=igb-ad,OU=IGB,OU=Urbana,DC=ad,DC=uillinois,DC=edu");
define("__LDAP_BIND_PASS__","ha2a8aveqazE7rUW");
define("__PODCAST_DIR__","/var/www/eclipse/leakeylab/html/podcasts");
define("__PODCAST_WEB_DIR__","/eclipse/leakeylab/html/podcasts");

///////Various Program Settings///////////
define("__FILETYPES__","mp3");
define("__COUNT__",3);
define("__MAX_SUMMARY_WORDS__",200);
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
