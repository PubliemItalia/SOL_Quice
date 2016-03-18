<?php
include "query.php";
  $querys = "SELECT * FROM qui_log_utenti WHERE riepilogo LIKE '%Chiusura automatica rda%'";
  $results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
	  $rda = substr($rows[riepilogo],25,4);
		echo "id_rda: ".$rda." - ".$rows[data]."<br>";
  $sqlg = "SELECT * FROM qui_rda_20150128 WHERE id = '$id_rda' ORDER BY id ASC";
  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigag = mysql_fetch_array($risultg)) {
	if ($rigag[data_chiusura] == 0) {
		$query = "UPDATE qui_rda_20150128 SET data_chiusura = '$rows[data]' WHERE id = '$rda'";
		if (mysql_query($query)) {
		} else {
		echo "Errore durante l'inserimento: ".mysql_error();
		}
	}
  }

$rda = "";
	}


?>