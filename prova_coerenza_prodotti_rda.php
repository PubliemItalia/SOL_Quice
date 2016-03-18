<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlf = "SELECT DISTINCT codice_art, azienda_prodotto FROM qui_righe_rda WHERE data_inserimento >= 1420070400 AND negozio = '$_GET[negozio]' ORDER BY codice_art ASC, id_rda DESC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	$sqlg = "SELECT * FROM qui_prodotti_".$_GET[negozio]." WHERE codice_art = '$rigaf[codice_art]'";
	$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigag = mysql_fetch_array($risultg)) {
		$azienda = $rigag[azienda];
	}
	if ($azienda != $rigaf[azienda_prodotto]) {
	echo "differenza negozio ".$_GET[negozio].": ".$rigaf[codice_art]." - ".$rigaf[azienda_prodotto]."<br>";
	}
$azienda = "";
}
?>