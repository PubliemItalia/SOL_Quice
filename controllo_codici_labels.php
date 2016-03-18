<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$sqld = "SELECT * FROM qui_prodotti_labels_test WHERE codice_art LIKE '%*50%' AND obsoleto = '0' ORDER BY id ASC";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
  echo "codice_art = ".$rigad[codice_art]." - ";
  $tot = $tot + 1;
  $codice_controllo = substr($rigad[codice_art],1);
  $sqla = "SELECT * FROM qui_prodotti_consumabili_12042014 WHERE codice_art = '".$codice_controllo."'";
  $risulta = mysql_query($sqla) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  if (mysql_num_rows($risulta) > 0) {
	  echo "OK";
  } else {
	  echo "NOOOOOOOOOO";
  }
  echo "<br>";
}
echo "totale: ".$tot;

?>
