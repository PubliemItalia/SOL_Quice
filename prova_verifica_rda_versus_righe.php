<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlf = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$id_rda = $rigaf[id_rda];
$tot_righe_sing_rda = $tot_righe_sing_rda + $rigaf[totale];
$sqlg = "SELECT * FROM qui_rda WHERE id = '$id_rda' ORDER BY id ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$n_rda_presenti = mysql_num_rows($risultg);
//if ($n_rda_presenti < 1) {
	echo "n_rda_presenti: ".$n_rda_presenti."<br>";
//}
$id_rda = "";
$n_rda_presenti = "";
}

?>