<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$queryb = "SELECT * FROM qui_prodotti_labels_temp WHERE categoria4_en = '' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	
$query = "UPDATE qui_prodotti_labels_temp SET categoria4_en = '$rowb[categoria4_it]' WHERE id = '$rowb[id]'";
if (mysql_query($query)) {
	echo "aggiorno riga ".$rowb[categoria4_it]."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

}
?>
