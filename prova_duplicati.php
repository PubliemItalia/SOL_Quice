<?php
include "query.php";
$queryv = "SELECT * FROM qui_prodotti_consumabili ORDER BY id ASC";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
$queryX = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$rowv[codice_art]'";
$resultX = mysql_query($queryX) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
$presenze = mysql_num_rows($resultX);
if ($presenze > 0) {
echo "duplicato: ".$rowv[codice_art]."<br>";
$presenze = "";
}
}
 ?>
