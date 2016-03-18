<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlg = "SELECT * FROM qui_rda WHERE stato = '3' AND id > '3209' ORDER BY id ASC";
//$sqlg = "SELECT * FROM qui_rda WHERE stato = '4' ORDER BY id ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	echo "rda n. ".$rigag[id]."<br>";
	echo "<strong>Righe:</strong><br>";
$sqlf = "SELECT * FROM qui_righe_rda WHERE id_rda = '$rigag[id]'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	echo $rigaf[id]." - stato ".$rigaf[stato_ordine]." - chiusura ".$rigaf[flag_chiusura]."<br>";
}
}
?>