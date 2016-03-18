<?php
session_start();
$materiale = $_GET[materiale];
$capacita = $_GET[capacita];
$diametro = $_GET[diametro];
$lang = $_SESSION[lang];
$categoria1 = $_SESSION[categoria1];
$categoria2 = $_SESSION[categoria2];
$categoria3 = $_SESSION[categoria3];
$categoria4 = $_SESSION[categoria4];
$paese = $_SESSION[paese];
$id_valvola = $_SESSION[id_valvola];
$negozio = $_SESSION[negozio];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$array_capacita = array();
$blocco_capacita .= "<option selected value=>Seleziona una capacit&agrave;</option>";
//costruzione query
//0
if ($materiale == "" AND $capacita == "" AND $diametro == "") {
//echo "caso 0<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' ORDER BY categoria4_it ASC";
}
//1
if ($materiale != "" AND $capacita == "" AND $diametro == "") {
//echo "caso 1<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND materiale = '$materiale' ORDER BY categoria4_it ASC";
}
//2
if ($materiale == "" AND $capacita != "" AND $diametro == "") {
//echo "caso 2<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' ORDER BY categoria4_it ASC";
}
//3
if ($materiale == "" AND $capacita == "" AND $diametro != "") {
//echo "caso 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND diametro = '$diametro' ORDER BY categoria4_it ASC";
}
//1 e 2
if ($materiale != "" AND $capacita != "" AND $diametro == "") {
//echo "caso 1 e 2<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' AND materiale = '$materiale' ORDER BY categoria4_it ASC";
}
//1 e 3
if ($materiale != "" AND $capacita == "" AND $diametro != "") {
//echo "caso 1 e 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND materiale = '$materiale' AND diametro = '$diametro' ORDER BY categoria4_it ASC";
}
//2 e 3
if ($materiale == "" AND $capacita != "" AND $diametro != "") {
//echo "caso 2 e 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' AND diametro = '$diametro' ORDER BY categoria4_it ASC";
}
//1 e 2 e 3
if ($materiale != "" AND $capacita != "" AND $diametro != "") {
//echo "caso 1 e 2 e 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' AND materiale = '$materiale' AND diametro = '$diametro' ORDER BY categoria4_it ASC";
}

$result = mysql_query($testoQuery);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
	while ($row = mysql_fetch_array($result)) {
		if (!in_array($row[categoria4_it],$array_capacita)) {
			$add_cap = array_push($array_capacita,$row[categoria4_it]);
			if ($row[categoria4_it] == $capacita) {
			$blocco_capacita .= "<option selected value=".$row[categoria4_it].">".$row[categoria4_it]."</option>";
			} else {
			$blocco_capacita .= "<option value=".$row[categoria4_it].">".$row[categoria4_it]."</option>";
			}
		}
	}
}
//$output .= "selezionato ".$materiale."<br>";
$output .= "<select name=capacita id=capacita class=codice_lista_nopadding onChange=\"cap_contestuale()\">";
$output .= $blocco_capacita;
$output .= "</select>";
$output .= "<br>d:".$diametro."-m:".$materiale."-c:".$capacita;

	//output finale
	echo $output;
?>
