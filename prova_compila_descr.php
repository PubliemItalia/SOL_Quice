<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE descrizione2_en = '' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$descrizione1_it = addslashes($rowb[descrizione1_it]);
$descrizione2_it = addslashes($rowb[descrizione2_it]);
$id_riga = $rowb[id];
$query = "UPDATE qui_prodotti_consumabili SET descrizione2_en = '$descrizione2_it' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

echo "aggiornata riga ".$id_riga." - negozio ".$negozio." - id_prodotto ".$id_prodotto."<br>";
$descrizione1_it = "";
$descrizione2_it = "";
$id_riga = "";
}
?>