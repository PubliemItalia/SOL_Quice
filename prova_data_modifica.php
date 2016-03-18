<?php
include "query.php";
$queryb = "SELECT * FROM qui_righe_rda WHERE output_mode = 'ord' ORDER BY id_rda ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	if ($rowb[data_ultima_modifica] == 0) {
	  $querys = "SELECT * FROM qui_log_utenti WHERE riepilogo LIKE '%su  - utente%'";
	  $results = mysql_query($querys);
	  $trovati = mysql_num_rows($results);
	  if ($trovati > 0) {
		while ($rows = mysql_fetch_array($results)) {
		  $pos = stripos($rows[riepilogo],"(".$rowb[id_rda].")");
			if ($pos > 0) {
			  $query = "UPDATE qui_righe_rda SET data_ultima_modifica = '$rows[data]' WHERE id = '$rowb[id]'";
			  if (mysql_query($query)) {
			  echo "id_rda: ".$rowb[id_rda]." - ".$rows[data]."<br>";
			  } else {
			  echo "Errore durante l'inserimento: ".mysql_error();
			  }
			  $pos = "";
			}
		}
	  }
	  $trovati = "";
}

}



/*
$queryb = "SELECT * FROM qui_righe_rda WHERE output_mode = 'sap' ORDER BY id_rda ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	if ($rowb[data_ultima_modifica] == 0) {
	  $querys = "SELECT * FROM qui_log_utenti WHERE riepilogo LIKE '%su sap%'";
	  $results = mysql_query($querys);
	  $trovati = mysql_num_rows($results);
	  if ($trovati > 0) {
		while ($rows = mysql_fetch_array($results)) {
		  $pos = stripos($rows[riepilogo],"(".$rowb[id_rda].")");
			if ($pos > 0) {
			  $query = "UPDATE qui_righe_rda SET data_ultima_modifica = '$rows[data]' WHERE id = '$rowb[id]'";
			  if (mysql_query($query)) {
			  echo "id_rda: ".$rowb[id_rda]." - ".$rows[data]."<br>";
			  } else {
			  echo "Errore durante l'inserimento: ".mysql_error();
			  }
			  $pos = "";
			}
		}
	  }
	  $trovati = "";
}

}


$queryb = "SELECT * FROM qui_righe_rda WHERE output_mode = 'sap' ORDER BY id_rda ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	  if ($rowb[data_inserimento] == $rowb[data_ultima_modifica]) {
		$querys = "SELECT * FROM qui_log_utenti WHERE riepilogo LIKE '%su sap%'";
		$results = mysql_query($querys);
		$trovati = mysql_num_rows($results);
		if ($trovati > 0) {
		  while ($rows = mysql_fetch_array($results)) {
			$pos = stripos($rows[riepilogo],"(".$rowb[id_rda].")");
			  if ($pos > 0) {
				$query = "UPDATE qui_righe_rda SET data_ultima_modifica = '$rows[data]' WHERE id = '$rowb[id]'";
				if (mysql_query($query)) {
				echo "id_rda: ".$rowb[id_rda]." - ".$rows[data]."<br>";
				} else {
				echo "Errore durante l'inserimento: ".mysql_error();
				}
				$pos = "";
			  }
		  }
		}
	  $trovati = "";
}

}
*/
?>