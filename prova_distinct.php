<?php
include "query.php";

$queryv = "SELECT DISTINCT categoria3_it FROM qui_prodotti_consumabili";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
echo $rowv[categoria3_it]."<br>";
$cat = $cat+1;
}
echo "categorie: ".$cat."<br>";
 ?>
