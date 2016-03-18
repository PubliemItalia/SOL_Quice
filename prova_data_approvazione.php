<?php
include "query.php";
  $querys = "SELECT * FROM qui_log_utenti WHERE riepilogo LIKE '%Approvazione rda%'";
  $results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
	  $rda = substr($rows[riepilogo],18,4);
		$query = "UPDATE qui_rda SET data_approvazione = '$rows[data]' WHERE id = '$rda'";
		if (mysql_query($query)) {
		echo "id_rda: ".$rda." - ".$rows[data]."<br>";
		} else {
		echo "Errore durante l'inserimento: ".mysql_error();
		}

$rda = "";
	}


?>