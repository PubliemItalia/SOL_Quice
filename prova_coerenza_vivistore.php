<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

	$sqlg = "SELECT * FROM qui_prodotti_vivistore";
	$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigag = mysql_fetch_array($risultg)) {
		$sqlf = "SELECT * FROM qui_righe_rda WHERE codice_art = '$rigag[codice_art]' AND negozio != 'vivistore' ORDER BY codice_art ASC, id_rda DESC";
		$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigaf = mysql_fetch_array($risultf)) {
			echo "differenza negozio ".$rigaf[negozio].": ".$rigaf[codice_art]." - ".$rigaf[azienda_prodotto]."<br>";
			$querys = "UPDATE qui_righe_rda SET negozio = 'vivistore', azienda_prodotto = 'VIVISOL' WHERE id = '$rigaf[id]'";
			  if (mysql_query($querys)) {
			  } else {
			  echo "Errore durante l'inserimento: ".mysql_error();
			  }

	}
}
?>