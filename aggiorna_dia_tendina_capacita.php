<?php
session_start();
$diametro = $_GET[diametro];
$_SESSION[diametro] = $diametro;
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
if (strlen($_SESSION[diametro]) > 0) {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND diametro = '$diametro' AND materiale = '$_SESSION[materiale]' AND paese = '$paese' ORDER BY categoria4_it ASC";
} else {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND diametro = '$diametro' AND paese = '$paese' ORDER BY categoria4_it ASC";
}
$result = mysql_query($testoQuery);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
	while ($row = mysql_fetch_array($result)) {
		if (!in_array($row[categoria4_it],$array_capacita)) {
			$add_cap = array_push($array_capacita,$row[categoria4_it]);
			if ($row[categoria4_it] == $_SESSION[capacita]) {
			$blocco_capacita .= "<option selected value=".$row[categoria4_it].">".$row[categoria4_it]."</option>";
			} else {
			$blocco_capacita .= "<option value=".$row[categoria4_it].">".$row[categoria4_it]."</option>";
			}
		}
	}
}
//$output .= "selezionato ".$materiale."<br>";
$output .= "<select name=capacita id=capacita class=codice_lista_nopadding onChange=\"cap_contestuale_materiali(this.value);cap_contestuale_diametri(this.value);\">";
$output .= $blocco_capacita;
$output .= "</select>";

	//output finale
	echo $output;
?>
