<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_assets WHERE categoria1_it = 'Erogatori' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$categoria2_en = str_replace("Erogatore","Cold converter",$rowb[categoria2_it]);
$id = $rowb[id];
//$querys = "SELECT * FROM qui_prodotti_consumabili WHERE descrizione1_it = '$descr' ";
$queryt = "UPDATE qui_prodotti_assets SET categoria2_en = '$categoria2_en' WHERE id = '$rowb[id]'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$categoria2_en = "";
}
?>
