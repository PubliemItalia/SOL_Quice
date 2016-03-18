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
$descr_valvola_scelta = $rows[descrizione1_it];
}
$queryt = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$row[id_cappellotto]'";
$resultt = mysql_query($queryt);
while ($rowt = mysql_fetch_array($resultt)) {
$descr_cappellotto_scelta = $rowt[descrizione1_it];
}

}
if ($descr_prod_scelta == "") {
$descr_prod_scelta = $row[descrizione1_it];
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
if (substr($row[codice_art],0,1) != "*") {
  $codice = $row[codice_art];
} else {
  $codice = substr($row[codice_art],1);
}
$paese = stripslashes($row[paese]);
$confezione = $row[confezione];
$prezzo = $row[prezzo];
$gruppo_merci = $row[gruppo_merci];
$descrizione = $row[categoria4_it];
//fine while
}

//$div_dati .= "<div id=componente_dati>";
//$div_dati .= "<span class=Titolo_bianco_xspazio>DATI</span><br>";
$div_dati .= "<div class=Titolo_famiglia>";
$div_dati .= "</div>"; 
$div_dati .= "<div class=scritte_bottoncini>";
switch ($_SESSION[lang]) {
case "it":
$div_dati .= "Codice";
break;
case "en":
$div_dati .= "Code";
break;
}
$div_dati .= "</div>"; 
$div_dati .= "<div class=bottoncini>";
$div_dati .= $codice;
$div_dati .= "</div>";
/*
$div_dati .= "<div class=scritte_bottoncini>";
switch ($_SESSION[lang]) {
case "it":
$div_dati .= "Gr. Merci";
break;
case "en":
$div_dati .= "Goods gr.";
break;
}
$div_dati .= "</div>"; 
$div_dati .= "<div class=bottoncini>".$gruppo_merci."</div>";
*/
$div_dati .= "<div class=scritte_bottoncini>";
switch ($_SESSION[lang]) {
case "it":
$div_dati .= "Prezzo";
break;
case "en":
$div_dati .= "Price";
break;
}
$div_dati .= "</div>"; 
$div_dati .= "<div class=bottoncini>";
$div_dati .= number_format($prezzo,2,",",".");
$div_dati .= "</div>";
$div_dati .= "<div class=scritte_bottoncini>";
switch ($_SESSION[lang]) {
case "it":
$div_dati .= "Confezione";
break;
case "en":
$div_dati .= "Package";
break;
}
$div_dati .= "</div>"; 
$div_dati .= "<div class=bottoncini>";
switch ($_SESSION[lang]) {
case "it":
//$div_dati .= $confezione." Pezzi";
$div_dati .= $confezione;
break;
case "en":
//$div_dati .= $confezione." pcs";
$div_dati .= $confezione;
break;
}
$div_dati .= "</div>";
/*$div_dati .= "<div class=scritte_bottoncini>";
$div_dati .= "Gruppo merci";
$div_dati .= "</div>"; 
$div_dati .= "<div class=bottoncini>";
$div_dati .= $gruppo_merci;
$div_dati .= "</div>";
if ($negozio == "assets") {
$div_dati .= "<div class=scritte_bottoncini>";
$div_dati .= "WBS";
$div_dati .= "</div>"; 
$div_dati .= "<div class=bottoncini>";
$div_dati .= $rigaq[wbs];
$div_dati .= "</div>";
}
*/
	//output finale
	echo $div_dati;
?>
