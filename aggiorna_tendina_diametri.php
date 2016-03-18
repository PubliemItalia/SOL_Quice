<?php
session_start();
$materiale = $_GET[materiale];
$capacita = $_GET[capacita];
$diametro = $_GET[diametro];
$categoria1 = $_SESSION[categoria1];
$categoria2 = $_SESSION[categoria2];
$categoria3 = $_SESSION[categoria3];
$categoria4 = $_SESSION[categoria4];
$paese = $_SESSION[paese];
$id_valvola = $_SESSION[id_valvola];
$lang = $_SESSION[lang];
$negozio = $_SESSION[negozio];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query


if (($materiale != "") AND ($capacita == "")) {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it='Bombole' AND categoria2_it='".$_SESSION[categoria2]."' AND categoria3_it='".$_SESSION[categoria3]."' AND paese='".$_SESSION[paese]."' AND id_valvola='".$_SESSION[id_valvola]."' AND lang='".$_SESSION[lang]."' AND materiale = '$materiale' ORDER BY id ASC";
}
if (($capacita != "") AND ($materiale == "")) {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it='Bombole' AND categoria2_it='".$_SESSION[categoria2]."' AND categoria3_it='".$_SESSION[categoria3]."' AND paese='".$_SESSION[paese]."' AND id_valvola='".$_SESSION[id_valvola]."' AND lang='".$_SESSION[lang]."' AND categoria4_it = '$capacita' ORDER BY id ASC";
}
if (($capacita == "") AND ($materiale == "")) {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it='Bombole' AND categoria2_it='".$_SESSION[categoria2]."' AND categoria3_it='".$_SESSION[categoria3]."' AND paese='".$_SESSION[paese]."' AND id_valvola='".$_SESSION[id_valvola]."' AND lang='".$_SESSION[lang]."' ORDER BY id ASC";
}
if ($materiale != "" AND $capacita != "") {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it='Bombole' AND categoria2_it='".$_SESSION[categoria2]."' AND categoria3_it='".$_SESSION[categoria3]."' AND paese='".$_SESSION[paese]."' AND id_valvola='".$_SESSION[id_valvola]."' AND lang='".$_SESSION[lang]."' AND categoria4_it = '$capacita' AND materiale = '$materiale' ORDER BY id ASC";
}

/*
if ($diametro != "") {
$c = "diametro = '$diametro'";
$clausole++;
}
*/

$array_diametri = array();
$blocco_diametri .= "<option selected value=>Seleziona un diametro;</option>";
//costruzione query

$result = mysql_query($testoQuery);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
	while ($row = mysql_fetch_array($result)) {
		if (!in_array($row[diametro],$array_diametri)) {
			$add_cap = array_push($array_diametri,$row[diametro]);
			if ($row[diametro] == $diametro) {
			$blocco_diametri .= "<option selected value=".$row[diametro].">".$row[diametro]."</option>";
			} else {
			$blocco_diametri .= "<option value=".$row[diametro].">".$row[diametro]."</option>";
			}
		}
	}
}
//$output .= "selezionato ".$materiale."<br>";
$output .= "<select name=diametro id=diametro class=codice_lista_nopadding onChange=\"dia_contestuale()\">";
$output .= $blocco_diametri;
$output .= "</select>";
$output .= "<br>d:".$diametro."-m:".$materiale."-c:".$capacita;
$output .= "<br>".$testoquery;
	//output finale
echo $output;
?>
