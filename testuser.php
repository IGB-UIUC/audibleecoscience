<?php


	$host = "AD-DC-P1.ad.uiuc.edu";
	$baseDN = "dc=ad,dc=uiuc,dc=edu";	
	$peopleDN = "ou=IGB" . "," . $baseDN;

	
	$connect = ldap_connect("ldap://AD-DC-P1.ad.uiuc.edu",636);

	//ldap_set_option($connect, LDAP_OPT_DEBUG_LEVEL, 7);
	//ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	//ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);

	ldap_bind($connect,"cn=igb_ad,ou=igb,dc=ad,dc=uiuc,dc=edu","ha2a8aveqazE7rUW");
	$ldap_result = ldap_search($connect,"OU=Campus Accounts,DC=ad,DC=uiuc,DC=edu","(CN=crystala)", array("sn","givenName"));
	
	$result = ldap_get_entries($connect,$ldap_result);
/*
	echo "test<br>";
	echo $result["0"]["sn"]["0"]."<br>";
	echo $result["0"]["0"][0]."<br>";
	echo $result["0"]["1"][CN] ."<br>";
	echo $result[0][sn][0]."<br>";

$test = $result[0][0];
echo $test[0];
	print_r($result);
*/
/*
Array ( 
	[count] => 1 
	[0] => Array ( 
		[sn] => Array ( [count] => 1 [0] => Ahn ) 
		[0] => sn [givenname] => Array ( [count] => 1 [0] => Crystal ) 
		[1] => givenname [count] => 2 [dn] => CN=crystala,OU=Campus Accounts,DC=ad,DC=uiuc,DC=edu ) 
) 

*/

print_r($result);
echo "<br>" . $result[0]['givenname'][0];
echo "<br>" . $result[0]['sn'][0];
echo "<br>" . $result[0]['dn'];




$html = "<select name='admin'>
	<option value='1'>Admin</option>
	<option value='0'>User</option>
</select>";



echo $html;



?>
