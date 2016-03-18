<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$array_rda = array();
$sqlz = "SELECT id FROM qui_rda WHERE stato = '4'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
	$add = array_push($array_rda,$rigaz[id]);
}
foreach ($array_rda as $ogni_rda) {
$sqlg = "SELECT * FROM qui_rda WHERE id = '$ogni_rda'";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	$tot_rda = $rigag[totale_rda];
}
$sqlf = "SELECT * FROM qui_righe_rda WHERE id_rda = '$ogni_rda' AND stato_ordine = '4'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	$tot_righe_sing_rda = $tot_righe_sign_rda+$rigaf[totale];
}
/*
$tot_righe_sing_rda = number_format($tot_righe_sing_rda,2,".","");
$queryq = "UPDATE qui_rda SET totale_rda = '$tot_righe_sing_rda' WHERE id = '$ogni_rda'";
if (mysql_query($queryq)) {
} else {
echo "Errore durante l'inserimento3: ".mysql_error();
}
*/
$diff = $tot_righe_sing_rda - $tot_rda;
$tot_gen_diff = $tot_gen_diff + $diff;
//if ($diff != 0) {
	echo "rda n. ".$ogni_rda." diff ".$diff."<br>";
//$tot_diff_sup10 = $tot_diff_sup10 + $diff;
//}
$diff = "";
$tot_rda = "";
$tot_righe_sing_rda = "";
}
	echo "totale differenza: ".$tot_gen_diff."<br>";
//	echo "totale differenze sup 10 euro: ".$tot_diff_sup10."<br>";
?>