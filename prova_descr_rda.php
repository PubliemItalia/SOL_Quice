<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_prodotti_consumabili WHERE categoria1_it = 'DPI' AND categoria4_it != '' ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$descr_it = addslashes($rigaz[descrizione1_it]);
$codice_art = $rigaz[codice_art];
$sqlh = "SELECT * FROM qui_righe_rda WHERE codice_art = '$codice_art'";
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
echo "da modificare cod. ".$rigah[codice_art]." - ".$rigah[descrizione]."<br>";
}

$query = "UPDATE qui_righe_rda SET descrizione = '$descr_it' WHERE codice_art = '$codice_art'"; 
if (mysql_query($query)) {
	echo "Nuova descr aggiornato: ".$descr_it."<br>";
} else {
echo "Errore durante l'inserimento". mysql_error();
}
$codice_art = "";
}
?>