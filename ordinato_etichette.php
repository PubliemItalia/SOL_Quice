<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_codici = array();
$queryb = "SELECT DISTINCT codice_art FROM ordinato_etichette ORDER BY descrizione ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	$add_cod = array_push($array_codici,$rowb[codice_art]);
}
$inizio_2011 = mktime(1,0,0,1,1,2011);
$fine_2011 = mktime(1,0,0,12,31,2011);
$inizio_2012 = mktime(1,0,0,1,1,2012);
$fine_2012 = mktime(1,0,0,12,31,2012);
$inizio_2013 = mktime(1,0,0,1,1,2013);
$fine_2013 = mktime(1,0,0,12,31,2013);
$inizio_2014 = mktime(1,0,0,1,1,2014);
$fine_2014 = mktime(1,0,0,12,31,2014);
echo "<table border=1 width=960>";
	echo "<tr><td width=120>Codice</td><td width=390>Descrizione</td><td align=center width=100>2011</td><td align=center width=100>2012</td><td align=center width=100>2013</td><td align=center width=100>2014</td></tr>";
foreach ($array_codici as $sing_cod) {
	echo "<tr>";
	echo "<td>";
	echo $sing_cod;
	echo "</td>";
	echo "<td>";
	  $queryc = "SELECT descrizione FROM ordinato_etichette WHERE codice_art = '$sing_cod' LIMIT 1";
	  $resultc = mysql_query($queryc);
	  while ($rowc = mysql_fetch_array($resultc)) {
		  echo stripslashes($rowc[descrizione]);
	  }
	echo "</td>";
	echo "<td align=right>";
	$sumquery_2011 = "SELECT SUM(quant) as somma_2011 FROM ordinato_etichette WHERE codice_art = '$sing_cod' AND (data_inserimento BETWEEN '$inizio_2011' AND '$fine_2011')";
	$resultb_2011 = mysql_query($sumquery_2011);
	list($somma_2011) = mysql_fetch_array($resultb_2011);
	echo intval($somma_2011,0);
	$somma_2011 = "";
	echo "</td>";
	echo "<td align=right>";
	$sumquery_2012 = "SELECT SUM(quant) as somma_2012 FROM ordinato_etichette WHERE codice_art = '$sing_cod' AND (data_inserimento BETWEEN '$inizio_2012' AND '$fine_2012')";
	$resultb_2012 = mysql_query($sumquery_2012);
	list($somma_2012) = mysql_fetch_array($resultb_2012);
	echo intval($somma_2012,0);
	$somma_2012 = "";
	echo "</td>";
	echo "<td align=right>";
	$sumquery_2013 = "SELECT SUM(quant) as somma_2013 FROM ordinato_etichette WHERE codice_art = '$sing_cod' AND (data_inserimento BETWEEN '$inizio_2013' AND '$fine_2013')";
	$resultb_2013 = mysql_query($sumquery_2013);
	list($somma_2013) = mysql_fetch_array($resultb_2013);
	echo intval($somma_2013,0);
	$somma_2013 = "";
	echo "</td>";
	echo "<td align=right>";
	$sumquery_2014 = "SELECT SUM(quant) as somma_2014 FROM ordinato_etichette WHERE codice_art = '$sing_cod' AND (data_inserimento BETWEEN '$inizio_2014' AND '$fine_2014')";
	$resultb_2014 = mysql_query($sumquery_2014);
	list($somma_2014) = mysql_fetch_array($resultb_2014);
	echo intval($somma_2014);
	$somma_2014 = "";
	echo "</td>";
	echo "</tr>";
}
echo "</table>";

?>
