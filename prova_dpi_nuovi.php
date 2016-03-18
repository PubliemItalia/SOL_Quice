<?php
include "query.php";
$queryb = "SELECT * FROM qui_consumabili_online WHERE categoria1_it = 'DPI' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art = '$rowb[codice_art]' ORDER BY id ASC";
$resultc = mysql_query($queryc);
$presenti = mysql_num_rows($resultc);
//$querys = "SELECT * FROM qui_prodotti_consumabili WHERE descrizione1_it = '$descr' ";
if ($presenti > 0) {
} else {
echo "codice ".$rowb[codice_art]." mancante<br>";	
}
$presenti = "";
}
?>
