<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_labels ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $cod_part = $rowb[categoria4_it];
  $query = "UPDATE qui_prodotti_labels SET part_number = '$rowb[categoria4_it]' WHERE id = '$rowb[id]'";
  if (mysql_query($query)) {
  echo "aggiornata riga ".$rowb[id]." - cod ".$rowb[categoria4_it]."<br>";
  } else {
  echo "Errore durante l'inserimento: ".mysql_error();
  }
}
?>