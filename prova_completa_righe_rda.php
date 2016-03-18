<?php
include "query.php";
$queryb = "SELECT * FROM qui_righe_rda WHERE azienda_utente = ''";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	if ($rowb[data_inserimento] >=1420070400) {
	  $queryc = "SELECT * FROM qui_utenti WHERE user_id = '$rowb[id_utente]'";
	  $resultc = mysql_query($queryc);
	  while ($rowc = mysql_fetch_array($resultc)) {
		  $IDCompany = $rowc[IDCompany];
	  }
	  if ($IDCompany != "") {
		$query = "UPDATE qui_righe_rda SET azienda_utente = '$IDCompany' WHERE id = '$rowb[id]' AND azienda_utente = ''";
		if (mysql_query($query)) {
		} else {
		echo "Errore durante l'inserimento: ".mysql_error();
		}
		echo "aggiornata riga ".$rowb[id]." - utente ".$rowb[id_utente]." - IDCompany ".$IDCompany."<br>";
		$IDCompany = "";
	  }
	}
}
?>