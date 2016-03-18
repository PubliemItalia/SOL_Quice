<?php
include "query.php";
$queryb = "SELECT * FROM qui_righe_ordini_for ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = "*".$rowb[codice_art];
$queryt = "UPDATE qui_righe_ordini_for SET codice_art = '$codice_art' WHERE id = '$rowb[id]'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
echo $codice_art."<br>";
$codice_art = "";
}
?>