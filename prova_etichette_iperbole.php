<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$queryb = "SELECT * FROM qui_prodotti_labels WHERE extra != '' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $query = "SELECT * FROM qui_righe_rda WHERE codice_art = '$rowb[codice_art]'";
  $resulty = mysql_query($query);
  while ($rowc = mysql_fetch_array($resulty)) {
	$queryd = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$rowb[extra]' AND quant = '$rowc[quant]'";
	$resultd = mysql_query($queryd);
	while ($rowd = mysql_fetch_array($resultd)) {
		$prezzo_listino = $rowd[prezzo];
	}
	echo "codice ".$rowc[codice_art]." - id rda ".$rowc[id_rda]." - id riga ".$rowc[id]." - quant ".$rowc[quant]." - prezzo listino ".$prezzo_listino." - prezzo pagato ".$rowc[totale]."<br>";
	$prezzo_listino = "";
  }
}
?>
