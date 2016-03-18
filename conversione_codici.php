<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$negozio_origine = "consumabili";
$negozio_dest = "labels";

$sqld = "SELECT * FROM qui_prodotti_consumabili_12042014 WHERE categoria1_it LIKE '%etichette%' AND codice_art LIKE '%50%' AND obsoleto = '0' ORDER BY id ASC";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
	$inizio = substr($rigad[codice_art],0,2);
	//$pos_ast = stripos($rigad[codice_art]);
	if ($inizio == "50") {
		$resto = substr($rigad[codice_art],2);
		$cod_new = "*70".$resto;
		$cod_vecc = "*".$rigad[codice_art];
		echo "codice_art = ".$rigad[codice_art]." - ".$cod_new." - ";
		$tot = $tot + 1;
		$sqla = "SELECT * FROM qui_prodotti_labels_test WHERE codice_art = '".$cod_new."'";
		$risulta = mysql_query($sqla) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		if (mysql_num_rows($risulta) > 0) {
			echo "OK";
			while ($rigaa = mysql_fetch_array($risulta)) {
				$query = "UPDATE qui_prodotti_labels_test SET codice_art = '$cod_vecc' WHERE id = '$rigaa[id]'";
				if (mysql_query($query)) {
				} else {
				echo "Errore durante l'inserimento: ".mysql_error();
				}
			}
		} else {
			echo "NOOOOOOOOOO";
		}
		echo "<br>";
	}
}
echo "totale: ".$tot;

 ?>
