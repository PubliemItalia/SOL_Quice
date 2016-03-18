<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db


$queryb = "SELECT * FROM servizio_abbigliamento ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $querya = "UPDATE qui_prodotti_consumabili SET giacenza = '$rowb[giac_mc]' WHERE id = '$rowb[id]'";
  if (mysql_query($querya)) {
  } else {
  echo "Errore durante l'inserimento: ".mysql_error();
  }
	 
/*
*/
  echo "id ".$rowb[id]." - giacenza ".$rowb[giac_mc]."<br>";
}
?>