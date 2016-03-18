<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$queryb = "SELECT * FROM ordinato_etichette ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	$array_data = explode("/",$rowb[data_inserimento_tx]);
	$timestamp = mktime(8,30,0,$array_data[1],$array_data[0],$array_data[2]);
$query = "UPDATE ordinato_etichette SET data_inserimento = '$timestamp' WHERE id = '$rowb[id]'";
if (mysql_query($query)) {
	echo "aggiorno riga ".$rowb[id]."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$timestamp = "";
}
?>
