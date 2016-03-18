<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$testoQuery = "SELECT * FROM qui_prodotti_labels WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($row = mysql_fetch_array($result)) {
switch ($_SESSION[lang]) {
case "it":
$div_dati .= stripslashes($row[descrizione2_it]);
break;
case "en":
$div_dati .= stripslashes($row[descrizione2_en]);
break;
}					
//fine while
}

	//output finale
	echo $div_dati;
//	echo $id;
?>
