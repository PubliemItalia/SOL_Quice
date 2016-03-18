<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_fatti = array();
$queryb = "SELECT * FROM qui_righe_rda WHERE pack_list != '0' AND data_chiusura = '0' AND flag_chiusura = '1' AND id_rda > '9000' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $queryc = "SELECT * FROM qui_packing_list WHERE id = '$rowb[pack_list]'";
  $resultc = mysql_query($queryc);
  while ($rowc = mysql_fetch_array($resultc)) {
	$spedizione_pack_list = $rowc[data_spedizione];
  }
  $query = "UPDATE qui_righe_rda SET data_chiusura = '$spedizione_pack_list', data_ultima_modifica = '$spedizione_pack_list' WHERE id = '$rowb[id]'";
  if (mysql_query($query)) {
	  echo "aggiorno riga ".$rowb[id_rda]." - ".$rowb[pack_list]." - ".$spedizione_pack_list."<br>";
	$spedizione_pack_list = '';
  } else {
	echo "Errore durante l'inserimento: ".mysql_error();
  }

}
?>
