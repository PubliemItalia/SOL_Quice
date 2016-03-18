<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
echo '<table border="1">';
echo '<tr><td>RdA</td><td>tot_rda</td><td>tot_righe</td></tr>';
$sqlz = "SELECT DISTINCT id_rda,id_unita FROM qui_righe_rda WHERE id_rda >= '9700' ORDER BY id_rda DESC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
  $sqlg = "SELECT * FROM qui_unita WHERE id_unita = '$rigaz[id_unita]'";
  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $presenza_unita = mysql_num_rows($risultg);
  if ($presenza_unita == 0) {
	  $tot_non_trovate = $tot_non_trovate +1;
	echo '<tr bgcolor=yellow><td>'.$rigaz[id_rda].'</td><td>'.$rigaz[id_unita].'</td><td>Unita non trovata</td></tr>';
  } else {
/*	while ($rigag = mysql_fetch_array($risultg)) {
	  echo '<tr bgcolor=white><td>'.$rigaz[id_rda].'</td><td>'.$rigaz[id_unita].'</td><td>'.$rigag[nome_unita].'</td></tr>';
	}*/
  }
$presenza_unita = "";
}
echo '<tr bgcolor=white><td>Totale</td><td>'.$tot_non_trovate.'</td><td></td></tr>';
echo '</table>';
?>