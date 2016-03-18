<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_fatti = array();
$queryb = "SELECT * FROM qui_rda WHERE stato = '4' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$query = "UPDATE qui_righe_rda SET stato_ordine = '4', flag_buyer = '0' WHERE id_rda = '$rowb[id]'";
if (mysql_query($query)) {
	echo "aggiorno riga ".$rowb[id]."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

}
?>
