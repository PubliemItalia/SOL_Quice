<?php
session_start();
$nome_buyer = $_SESSION['nome'];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_rda = $_GET['id_rda'];
$id_buyer = $_GET['id_utente'];
$data_chiusura = mktime();

$m = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$nazione_rda = $rigam[nazione];
}

if ($nazione_rda == "italy") {
	$flag_sap = "ok";
} else {
	$flag_sap = "";
}
$query = "UPDATE qui_righe_rda SET id_buyer = '$id_buyer', flag_chiusura = '1', stato_ordine = '4', n_ord_sap = '$flag_sap', n_fatt_sap = '$flag_sap' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$query = "UPDATE qui_rda SET buyer_output = '$id_buyer', id_buyer = '$id_buyer', nome_buyer = '$nome_buyer', data_chiusura = '$data_chiusura', data_ultima_modifica = '$data_chiusura', stato = '4', n_ord_sap = '$flag_sap', n_fatt_sap = '$flag_sap' WHERE id = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}	

$tab_output .= "<div style=\"width:960px; height:10px\">";
$tab_output .= "</div>";

//output finale
echo $tab_output;
 ?>