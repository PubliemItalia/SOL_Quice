<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlg = "SELECT * FROM qui_rda WHERE stato = '4' AND id > '3209' ORDER BY id ASC";
//$sqlg = "SELECT * FROM qui_rda WHERE stato = '4' ORDER BY id ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	$tot_rda = $rigag[totale_rda];
$sqlf = "SELECT * FROM qui_righe_rda WHERE id_rda = '$rigag[id]'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	$tot_righe_sing_rda = $tot_righe_sing_rda + $rigaf[totale];
}
$diff = $tot_righe_sing_rda - $tot_rda;
//if (($diff > "0.5") OR ($diff < "0.5")) {
$tot_gen_diff = $tot_gen_diff + $diff;
	echo "rda n. ".$rigag[id]." RDA: ".$tot_rda." - Righe: ".$tot_righe_sing_rda." | diff ".number_format($diff,2,",",".")." | diff_gen ".number_format($tot_gen_diff,2,",",".")."<br>";
/*$queryv = "UPDATE qui_rda SET totale_rda = '$tot_righe_sing_rda', totale_pre_condono = '$tot_rda' WHERE id = '$rigag[id]'";
//echo $queryv."<br>";
if (mysql_query($queryv)) {
} else {
echo "Errore durante l'inserimento2: ".mysql_error();
}
*///
$diff = "";
$tot_rda = "";
$tot_righe_sing_rda = "";
}
//}
	echo "totale differenza: ".$tot_gen_diff."<br>";
?>