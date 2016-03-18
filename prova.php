<?php
/*ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
*/session_start();
//echo 'Max Life = ' . ini_get('session.gc_maxlifetime') . "<br>";
    $_SESSION[user_id]=$_POST[IDUser];
    $_SESSION[posta]=$_POST[posta];
    $_SESSION[IDResp]=$_POST[IDResp];
	$_SESSION[login]=$_POST[login];
	$_SESSION[nome]=$_POST[nome];
	$_SESSION[idlocalita]=$_POST[idlocalita];
	$_SESSION[idunita]=$_POST[idunita];
	$_SESSION[indirizzo]=$_POST[indirizzo];
	$_SESSION[CAP]=$_POST[CAP];
	$_SESSION[localita]=$_POST[localita];
	$_SESSION[company]=$_POST[company];
	$_SESSION[nazione]=$_POST[nazione];
	$_SESSION[nomeunita]=$_POST[nomeunita];
	$_SESSION[ruolo]="User";
//	}
require('query.php');
mysql_set_charset("utf8"); //settare la codifica della connessione al db
require('functions.php');
/*echo "array_post: ";
$array_sped = $_POST;
print_r($array_sped);
echo "<br>";
*/
echo "idUser: ".$array_sped[IDUser]."<br>";
?>