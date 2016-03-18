<?php
include "query.php";
$queryb = "SELECT * FROM qui_righe_rda WHERE negozio = 'spare_parts' AND codice_art != '' AND gruppo_merci = '' AND id_rda != '' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$codice_art = $rowb[codice_art];
$negozio = $rowb[negozio];
$id_riga = $rowb[id];
$querys = "SELECT * FROM qui_prodotti_spare_parts WHERE codice_art = '$codice_art'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
$gruppo_merci = $rows[gruppo_merci];
$id_prodotto = $rows[id];
}
$query = "UPDATE  qui_righe_rda_10102013 SET gruppo_merci = '$gruppo_merci' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
echo "aggiornata riga ".$id_riga." - negozio ".$negozio." - id_prodotto ".$id_prodotto." - gruppo merci ".$gruppo_merci."<br>";
$gruppo_merci = "";
}
?>