<?php
echo "ricerca_duplicati<br>";include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
	  $sqlg = "SELECT * FROM qui_prodotti_consumabili ORDER BY id ASC";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
	$sqlH = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$rigag[codice_art]'";
	  $risultH = mysql_query($sqlH) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  $ricorrenze = mysql_num_rows($risultH);
	  echo "ricorrenze: ".$ricorrenze." - codice: ".$rigag[codice_art]."<br>";
	  if ($ricorrenze > 1) {
	  while ($rigaH = mysql_fetch_array($risultH)) {
		  echo "Negozio ".$rigaH[negozio].": ".$rigaH[codice_art]." - id: ".$rigaH[id]."<br>";
	  }
	  }
		
$ricorrenze = "";
}

?>