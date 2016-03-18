<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_consumabili ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
//aggiornamento campo id_valvola
$querys = "SELECT * FROM qui_prodotti_consumabili_test WHERE codice_art = '$codice_art'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
$categoria3_it = $rows[categoria3_it];
$categoria4_it = $rows[categoria4_it];
$foto_gruppo = $rows[foto_gruppo];
$foto_famiglia = $rows[foto_famiglia];
}
$query = "UPDATE qui_prodotti_consumabili SET categoria3_it = '$categoria3_it', categoria4_it = '$categori4_it', foto_gruppo = '$foto_gruppo', foto_famiglia = '$foto_famiglia' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
echo "aggiornato prodotto ".$id."<br>";
}
?>