<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
$lingua = $_GET[lang];
$categoria1 = $_GET[categoria1];
$categoria2 = $_GET[categoria2];
$categoria3 = $_GET[categoria3];
$categoria4 = $_GET[categoria4];
$ordinamento = $_GET[ordinamento];
$asc_desc = $_GET[asc_desc];
$nazioneDaModulo = $_SESSION[nazione_ric];
$descrizioneDaModulo = $_SESSION[descrizione];
$negozio = $_GET[negozio];



if ($nazioneDaModulo != "") {
$b = "nazione LIKE '%$nazioneDaModulo%'";
$clausole++;
}
switch($lingua) {
case "it":
$categoria1_lang = "categoria1_it";
$categoria2_lang = "categoria2_it";
$categoria3_lang = "categoria3_it";
$categoria4_lang = "categoria4_it";
break;
case "en":
$categoria1_lang = "categoria1_en";
$categoria2_lang = "categoria2_en";
$categoria3_lang = "categoria3_en";
$categoria4_lang = "categoria4_en";
break;
}

if ($categoria2 != "") {
$c = "categoria2_it = '$categoria2'";
$clausole++;
}

if ($negozio != "") {
$d = "negozio = '$negozio'";
$clausole++;
}

if ($categoria1 != "") {
$e = "categoria1_it = '$categoria1'";
$clausole++;
}
if ($categoria3 != "") {
$f = "categoria3_it = '$categoria3'";
$clausole++;
}
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$h = "paese = '$paese'";
$clausole++;
}



//costruzione query, query diversa a seconda del negozio prescelto
switch ($negozio) {
case "assets":
$testoQuery = "SELECT * FROM qui_prodotti_assets ";
break;
case "consumabili":
$testoQuery = "SELECT * FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery = "SELECT * FROM qui_prodotti_spare_parts ";
break;
case "labels":
$testoQuery = "SELECT * FROM qui_prodotti_labels ";
break;
case "vivistore":
$testoQuery = "SELECT * FROM qui_prodotti_vivistore ";
break;
}
if ($clausole > 0) {
$testoQuery .= "WHERE obsoleto = '0' AND ";
if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
}
if ($b != "") {
$testoQuery .= $b;
}
if ($c != "") {
$testoQuery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
}
if ($g != "") {
$testoQuery .= $g;
}
if ($h != "") {
$testoQuery .= $h;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h;
}
}

//} else {
//$testoQuery .= "WHERE obsoleto = '' ";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

//$testoQuery .= " ORDER BY ".$ordinamento." ".$asc_desc;

//echo "testoQuery: ".$testoQuery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
$result = mysql_query($testoQuery);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
while ($row = mysql_fetch_array($result)) {
switch($lingua) {
case "it":
$descr_prod_scelta = str_replace(" Capacità","",$row[descrizione1_it]);
break;
case "en":
$descr_prod_scelta = str_replace(" Capacity","",$row[descrizione1_en]);
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
$descr_prod_scelta = $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
if ($row[categoria1_it] == "Bombole") {
//$tabella_prodotti .= "<a href=# title=".str_replace(" ","_",$descr_valvola).">";
$descr_prod_scelta .= $descr_prod_scelta;
if ($descr_valvola != "") {
$descr_prod_scelta .= " - ".$descr_valvola_scelta;
}
if ($descr_cappellotto != "") {
$descr_prod_scelta .= " - ".$descr_cappellotto_scelta;
}
//$tabella_prodotti .= "</a>";
} else {
$descr_prod_scelta .= $descr_prod;
}
}
$descr_prod_scelta = "";
$descr_valvola_scelta = "";
$descr_cappellotto_scelta = "";

//dati fondamentali da visualizzare
$negozio_scelta = $row[negozio];
$id_scelta = $row[id];
$codice_scelta = $row[codice_art];
$paese_scelta = stripslashes($row[paese]);
$confezione_scelta = $row[confezione];
$prezzo_scelta = number_format($row[prezzo],2,",",".");
//fine while
}
//fine if
}

//div per il codice art
$tabella_scheda .= "<div class=comp_scheda>";
//modulino bianco con etichetta
$tabella_scheda .= "<div class=etichetta_valore>";
$tabella_scheda .= "Codice art.";
$tabella_scheda .= "</div>";
//modulino trasparente con valore e filo di contorno
$tabella_scheda .= "<div class=valore_scelta>";
$tabella_scheda .= $codice_scelta;
$tabella_scheda .= "</div>";
$tabella_scheda .= "</div>";
//div per il prezzo art
$tabella_scheda .= "<div class=comp_scheda>";
//modulino bianco con etichetta
$tabella_scheda .= "<div class=etichetta_valore>";
$tabella_scheda .= "Prezzo";
$tabella_scheda .= "</div>";
//modulino trasparente con valore e filo di contorno
$tabella_scheda .= "<div class=valore_scelta>";
$tabella_scheda .= $prezzo_scelta;
$tabella_scheda .= "</div>";
$tabella_scheda .= "</div>";
//div per la confezione art
$tabella_scheda .= "<div class=comp_scheda>";
//modulino bianco con etichetta
$tabella_scheda .= "<div class=etichetta_valore>";
$tabella_scheda .= "Confezione";
$tabella_scheda .= "</div>";
//modulino trasparente con valore e filo di contorno
$tabella_scheda .= "<div class=valore_scelta>";
$tabella_scheda .= $confezione_scelta;
$tabella_scheda .= "</div>";
$tabella_scheda .= "</div>";
//div per pulsante inserimento nel carrello
$tabella_scheda .= "<div class=comp_scheda>";
$tabella_scheda .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$negozio_scelta."&id_prod=".$id_scelta."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">Inserisci nel carrello</div></a>";
/*$tabella_scheda .= "";
*/
$tabella_scheda .= "</div>";

	//output finale
	echo $tabella_scheda;
?>
