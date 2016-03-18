<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_assets WHERE categoria1_it = 'Valvole' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id_prodotto = $rowb[id];
$cat2_prec = $rowb[categoria3_en];
$cat3_prec = $rowb[categoria2_en];
$cat2_it = $rowb[categoria2_en];
$cat3_it = $rowb[categoria3_en];

$query = "UPDATE qui_prodotti_assets SET categoria2_en = '$rowb[categoria3_en]', categoria3_en = '$rowb[categoria2_en]' WHERE id = '$rowb[id]'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
echo "aggiornata riga ".$rowb[id]." ".$cat2_it." = ".$cat2_prec." || ".$cat3_it." = ".$cat3_it."<br>";
}
?>