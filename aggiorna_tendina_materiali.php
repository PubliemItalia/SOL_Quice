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

$array_materiali = array();
$blocco_materiali .= "<option selected value=>Seleziona un materiale</option>";
//costruzione query
//0
if ($materiale == "" AND $capacita == "" AND $diametro == "") {
//echo "caso 0<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' ORDER BY materiale ASC";
}
//1
if ($materiale != "" AND $capacita == "" AND $diametro == "") {
//echo "caso 1<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND materiale = '$materiale' ORDER BY materiale ASC";
}
//2
if ($materiale == "" AND $capacita != "" AND $diametro == "") {
//echo "caso 2<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' ORDER BY materiale ASC";
}
//3
if ($materiale == "" AND $capacita == "" AND $diametro != "") {
//echo "caso 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND diametro = '$diametro' ORDER BY materiale ASC";
}
//1 e 2
if ($materiale != "" AND $capacita != "" AND $diametro == "") {
//echo "caso 1 e 2<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' AND materiale = '$materiale' ORDER BY materiale ASC";
}
//1 e 3
if ($materiale != "" AND $capacita == "" AND $diametro != "") {
//echo "caso 1 e 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND materiale = '$materiale' AND diametro = '$diametro' ORDER BY materiale ASC";
}
//2 e 3
if ($materiale == "" AND $capacita != "" AND $diametro != "") {
//echo "caso 2 e 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' AND diametro = '$diametro' ORDER BY materiale ASC";
}
//1 e 2 e 3
if ($materiale != "" AND $capacita != "" AND $diametro != "") {
//echo "caso 1 e 2 e 3<br>";
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' AND capacita = '$capacita' AND materiale = '$materiale' AND diametro = '$diametro' ORDER BY materiale ASC";
}

$result = mysql_query($testoQuery);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
	while ($row = mysql_fetch_array($result)) {
		if (!in_array($row[materiale],$array_materiali)) {
			$add_cap = array_push($array_materiali,$row[materiale]);
			if ($row[materiale] == $materiale) {
			$blocco_materiali .= "<option selected value=".$row[materiale].">".$row[materiale]."</option>";
			} else {
			$blocco_materiali .= "<option value=".$row[materiale].">".$row[materiale]."</option>";
			}
		}
	}
}
//$output .= "selezionato ".$materiale."<br>";
$output .= "<select name=materiale id=materiale class=codice_lista_nopadding onChange=\"mat_contestuale()\">";
$output .= $blocco_materiali;
$output .= "</select>";
$output .= "<br>d:".$diametro."-m:".$materiale."-c:".$capacita;
//$output .= "<br>".$testoQuery;

	//output finale
	echo $output;
?>
