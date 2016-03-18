<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$array_rda = array();
$sqlz = "SELECT DISTINCT id_rda FROM qui_righe_rda WHERE stato_ordine = '4' AND (data_inserimento BETWEEN '1388647273' AND '1412860015') ORDER BY id DESC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
	$add = array_push($array_rda,$rigaz[id_rda]);
}
echo '<table border="1">';
echo '<tr><td>RdA</td><td>tot_rda</td><td>tot_righe</td></tr>';
foreach ($array_rda as $ogni_rda) {
$sqlg = "SELECT * FROM qui_rda WHERE id = '$ogni_rda'";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	$tot_rda = $rigag[totale_rda];
	$tot_gen_rda = $tot_gen_rda + $rigag[totale_rda];
}
$sqlf = "SELECT * FROM qui_righe_rda WHERE id_rda = '$ogni_rda'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	$tot_righe_sing_rda = $tot_righe_sing_rda+$rigaf[totale];
	$tot_gen_righe = $tot_gen_righe+$rigaf[totale];
}
$diff = $tot_righe_sing_rda - $tot_rda;
if ($diff != 0) {
echo '<tr bgcolor=yellow><td>'.$ogni_rda.'</td><td>'.$tot_rda.'</td><td>'.$tot_righe_sing_rda.'</td></tr>';
} else {
echo '<tr bgcolor=white><td>'.$ogni_rda.'</td><td>'.$tot_rda.'</td><td>'.$tot_righe_sing_rda.'</td></tr>';
}
/*
$diff = $tot_righe_sing_rda - $tot_rda;
$tot_gen_diff = $tot_gen_diff + $diff;
if ($diff != 0) {
echo "<span style=\"color:red;\"> rda n. ".$ogni_rda." diff ".$diff."</span><br>";
} else {
echo "rda n. ".$ogni_rda." diff ".$diff."<br>";
//$tot_diff_sup10 = $tot_diff_sup10 + $diff;
}
*/
$diff = "";
$tot_rda = "";
$tot_righe_sing_rda = "";
}
echo '<tr bgcolor=white><td>Totale</td><td>'.$tot_gen_rda.'</td><td>'.$tot_gen_righe.'</td></tr>';
echo '</table>';
	echo "totale differenza: ".$tot_gen_diff."<br>";
//	echo "totale differenze sup 10 euro: ".$tot_diff_sup10."<br>";
?>