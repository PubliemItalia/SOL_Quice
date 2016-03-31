<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
echo '<table border="1">';
$sqlg = "SELECT * FROM qui_packing_list WHERE id > 2500 ORDER BY id DESC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$array_vend = array();
	$sqlz = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE pack_list = '$rigag[id]'";
	$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigaz = mysql_fetch_array($risultz)) {
		if (!in_array($rigaz[azienda_prodotto],$array_vend)) {
		$add = array_push($array_vend,$rigaz[azienda_prodotto]);
		}
	}
	if (count($array_vend) > 1) {
	  echo '<tr><td>Pack list</td><td>'.$rigag[id].'</td><td>'.print_r($array_vend).'</td></tr>';
	}
}
echo '</table>';
?>