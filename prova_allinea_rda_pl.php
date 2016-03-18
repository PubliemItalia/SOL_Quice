<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_fatti = array();
$queryb = "SELECT * FROM qui_righe_rda WHERE pack_list > '0' AND data_chiusura = '0' AND flag_chiusura = '1' ORDER BY id_rda DESC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$querys = "SELECT * FROM qui_packing_list WHERE id = '$rowb[pack_list]'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
	$spedizione = $rows[data_spedizione];
}
	echo "RDA ".$rowb[id_rda]." - riga ".$rowb[id]." - PL ".$rowb[pack_list]." spedito ".$spedizione."<br>";
$query = "UPDATE qui_righe_rda SET data_chiusura = '$spedizione', data_ultima_modifica = '$spedizione' WHERE id = '$rowb[id]'";
if (mysql_query($query)) {
	echo "aggiorno riga ".$rowb[id]."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
/*
*/
$spedizione = '';
}
?>
