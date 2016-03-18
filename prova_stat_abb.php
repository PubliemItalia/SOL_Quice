<table width="600" border="1">
  <tr>
    <td>CODICE</td>
    <td>CATEGORIA</td>
    <td>RICHIESTE</td>
    <td>EVASI</td>
    <td>IN ATTESA</td>
  </tr>
<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$array_cod = array();
$sqlz = "SELECT DISTINCT codice_art FROM qui_righe_rda WHERE categoria LIKE '%abbigliamento%'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
	$add = array_push($array_cod,$rigaz[codice_art]);
}
foreach ($array_cod as $ogni_cod) {
$sqlg = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art = '$ogni_cod'";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$sqlf = "SELECT * FROM qui_righe_rda WHERE codice_art = '$ogni_cod'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_pezzi = mysql_num_rows($risultf);
  echo "<tr>";
    echo "<td>".$ogni_cod."</td>";
    echo "<td>".$rigag[categoria2_it]."</td>";
    echo "<td>".$num_pezzi."</td>";
while ($rigaf = mysql_fetch_array($risultf)) {
if ($rigag[categoria2_it] == "Abbigliamento_Sol") {
	if ($rigaf[stato_ordine] == 4) {
		$evasi = $evasi + $rigaf[quant];
	$tot_evasi_sol = $tot_evasi_sol + $rigaf[quant];
	} else {
		$in_attesa = $in_attesa + $rigaf[quant];
$tot_attesa_sol = $tot_attesa_sol + $rigaf[quant];
	}
	} else {
	if ($rigaf[stato_ordine] == 4) {
		$evasi = $evasi + $rigaf[quant];
	$tot_evasi_vivisol = $tot_evasi_vivisol + $rigaf[quant];
	} else {
		$in_attesa = $in_attesa + $rigaf[quant];
$tot_attesa_vivisol = $tot_attesa_vivisol = $tot_attesa_sol + $rigaf[quant];
	}
}
	}
    echo "<td>".$evasi."</td>";
    echo "<td>".$in_attesa."</td>";
  echo "</tr>";
	$num_pezzi = 0;
	$evasi = 0;
	$in_attesa = 0;
}
}
  echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td>SOL</td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td>".$tot_evasi_sol."</td>";
    echo "<td>".$tot_attesa_sol."</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td>VIVISOL</td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td>".$tot_evasi_vivisol."</td>";
    echo "<td>".$tot_attesa_vivisol."</td>";
  echo "</tr>";
?>
</table>
