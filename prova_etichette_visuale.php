<?php
$array_codici = array();
include "query.php";
echo "ETICHETTE E COLLARI<br>";
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE categoria1_it = 'Etichette_ADR' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$add_codice = array_push($array_codici,$rowb[codice_art]);
}
foreach ($array_codici as $sing_codice) {
$queryb = "SELECT * FROM qui_prodotti_consumabili_attuale WHERE codice_art = '$sing_codice'";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$categoria3_it = $rowb[categoria3_it];
$categoria4_it = $rowb[categoria4_it];
$extra = $rowb[extra];
}
$queryt = "UPDATE qui_prodotti_consumabili SET categoria3_it = '$categoria3_it', categoria4_it = '$categoria4_it', extra = '$extra' WHERE codice_art = '$sing_codice'";
if (mysql_query($queryt)) {
echo "aggiornato codice ".$sing_codice."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$categoria3_it = "";
$categoria4_it = "";
$extra = "";
}
?>
