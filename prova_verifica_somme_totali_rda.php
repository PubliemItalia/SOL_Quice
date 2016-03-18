<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
echo '<table width="600" border="1" cellpadding="1" cellspacing="1">
<tr><td>RdA</td><td>Somma Rda</td><td>Somma Rigne Rda</td></tr>';
$sqlg = "SELECT id, totale_rda FROM qui_rda ORDER BY id DESC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '".$rigag[id]."'";
	$resultf = mysql_query($sqlf);
	list($somma) = mysql_fetch_array($resultf);
	echo '<tr>
	<td>'.$rigag[id].'</td><td>'.$rigag[totale_rda].'</td>';
	if (number_format($somma,2,",",".") != number_format($rigag[totale_rda],2,",",".")) {
	echo '<td bgcolor="#FFCC00">'.$somma.'</td>';
	} else {
	echo '<td>'.$somma.'</td>';
	}
	echo '</tr>';
}
echo '</table>';
?>