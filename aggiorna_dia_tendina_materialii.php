<?php
session_start();
$diametro = $_GET[diametro];
$_SESSION[diametro] = $diametro;
$lang = $_SESSION[lang];
$categoria1 = $_SESSION[categoria1];
$categoria2 = $_SESSION[categoria2];
$categoria3 = $_SESSION[categoria3];
$paese = $_SESSION[paese];
$id_valvola = $_SESSION[id_valvola];
$negozio = $_SESSION[negozio];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$array_materiali = array();
$blocco_materiali .= "<option selected value=>Seleziona una capacit&agrave;</option>";
//costruzione query
if ($_SESSION[capacita] != "") {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND diametro = '$diametro' AND categoria4_it = '$_SESSION[capacita]' AND paese = '$paese' ORDER BY diametro ASC";
} else {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND diametro = '$diametro' AND paese = '$paese' ORDER BY diametro ASC";
}
$result = mysql_query($testoQuery);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
	while ($row = mysql_fetch_array($result)) {
		if (!in_array($row[materiale],$array_materiali)) {
			$add_cap = array_push($array_materiali,$row[materiale]);
			if ($row[materiale] == $_SESSION[materiale]) {
			$blocco_materiali .= "<option selected value=".$row[materiale].">".$row[materiale]."</option>";
			} else {
			$blocco_materiali .= "<option value=".$row[materiale].">".$row[materiale]."</option>";
			}
		}
	}
}
//$output .= "selezionata ".$capacita."<br>";
$output .= "<select name=materiale id=materiale class=codice_lista_nopadding onChange=\"mat_contestuale_capacita(this.value);mat_contestuale_diametri(this.value);\">";
$output .= $blocco_materiali;
$output .= "</select>";

	//output finale
	echo $output;
?>
