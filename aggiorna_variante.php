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

$testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($row = mysql_fetch_array($result)) {
switch ($_SESSION[lang]) {
case "it":
$descr_prod_scelta = $row[descrizione1_it];
break;
case "en":
$descr_prod_scelta = $row[descrizione1_en];
break;
case "fr":
$descr_prod_scelta = $row[descrizione_fr];
break;
case "de":
$descr_prod_scelta = $row[descrizione_de];
break;
case "es":
$descr_prod_scelta = $row[descrizione_es];
break;
}
if ($row[categoria1_it] == "Bombole") {
$querys = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$row[id_valvola]'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
switch ($_SESSION[lang]) {
	case "it":
$descr_valvola_scelta = $rows[descrizione1_it];
	break;
	case "en":
$descr_valvola_scelta = $rows[descrizione1_en];
	break;
	}	
}
$queryt = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$row[id_cappellotto]'";
$resultt = mysql_query($queryt);
while ($rowt = mysql_fetch_array($resultt)) {
switch ($_SESSION[lang]) {
	case "it":
$descr_cappellotto_scelta = $rowt[descrizione1_it];
	break;
	case "en":
$descr_cappellotto_scelta = $rowt[descrizione1_en];
	break;
	}					
}

}
if ($descr_prod_scelta == "") {
switch ($_SESSION[lang]) {
	case "it":
$descr_prod_scelta = $row[descrizione1_it];
	break;
	case "en":
$descr_prod_scelta = $row[descrizione1_en];
	break;
	}					
} else {
if ($row[categoria1_it] == "Bombole") {
$descr_prod_scelta .= $descr_prod_scelta;
if ($descr_valvola != "") {
$descr_prod_scelta .= " - ".$descr_valvola_scelta;
}
if ($descr_cappellotto != "") {
$descr_prod_scelta .= " - ".$descr_cappellotto_scelta;
}
} else {
$descr_prod_scelta .= $descr_prod;
}
}
$descr_prod_scelta = "";
$descr_valvola_scelta = "";
$descr_cappellotto_scelta = "";

//dati fondamentali da visualizzare
$codice = $row[codice_art];
$paese = stripslashes($row[paese]);
$confezione = $row[confezione];
$prezzo = $row[prezzo];
$gruppo_merci = $row[gruppo_merci];
switch ($_SESSION[lang]) {
	case "it":
$descrizione = $row[categoria4_it];
	break;
	case "en":
$descrizione = $row[categoria4_en];
	break;
	}					
//fine while
}

$div_dati .= $descrizione;
	//output finale
	echo $div_dati;
?>
