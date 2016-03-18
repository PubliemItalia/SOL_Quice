<?php
session_start();
$capacita = $_GET[capacita];
$_SESSION[capacita] = $capacita;
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

$array_diametri = array();
$blocco_diametri .= "<option selected value=>Seleziona un diametro</option>";
//costruzione query
if ($_SESSION[materiale] != "") {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND categoria4_it = '$capacita' AND materiale = '$_SESSION[materiale]' AND paese = '$paese' ORDER BY diametro ASC";
} else {
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND categoria4_it = '$capacita' AND paese = '$paese' ORDER BY diametro ASC";
}
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
$output .= "<select name=diametro id=diametro class=codice_lista_nopadding onChange=\"dia_contestuale_capacita(this.value);dia_contestuale_materiali(this.value);\">";
$output .= $blocco_diametri;
$output .= "</select>";

	//output finale
	echo $output;
?>
