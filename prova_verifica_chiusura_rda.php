<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlf = "SELECT DISTINCT id_rda FROM qui_righe_rda WHERE stato_ordine = '4' ORDER BY id_rda ASC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
  $id_rda = $rigaf[id_rda];
  $sqlg = "SELECT * FROM qui_rda WHERE id = '$id_rda' ORDER BY id ASC";
  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigag = mysql_fetch_array($risultg)) {
	if ($rigag[data_chiusura] == 0) {
	  echo "<strong>rda: ".$rigag[id]." - chiusura: ".$rigag[stato]."</strong><br>";
	  $sqlh = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' ORDER BY id ASC";
	  $risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigah = mysql_fetch_array($risulth)) {
		echo "<em>chiusura: ".$rigag[data_chiusura]." - id: ".$rigah[id]."</em><br>";
	  }
	}
  }
}
?>