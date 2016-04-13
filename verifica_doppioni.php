<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$negozio1 = "labels";
$negozio2 = "labels";
$sqld = "SELECT * FROM qui_globale_prodotti ORDER BY id ASC";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$sqle = "SELECT * FROM qui_globale_prodotti WHERE codice_art = '$rigad[codice_art]'";
$risulte = mysql_query($sqle) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_ricorrenze = mysql_num_rows($risulte);
if ($num_ricorrenze > 1) {
	echo $num_ricorrenze." doppioni del codice ".$rigad[codice_art]."<br>";
}
$num_ricorrenze = "";
}
 ?>
