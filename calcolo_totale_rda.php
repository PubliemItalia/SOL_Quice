<?php
$id_riga = $_GET['id_riga'];
$quant = str_replace(",",".",$_GET['quant']);

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$queryg = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$resultg = mysql_query($queryg) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowg = mysql_fetch_array($resultg)) {
$negozio_rda = $rowg[negozio];
$id_prodotto = $rowg[id_prodotto];
$id_rda = $rowg[id_rda];
}
//echo "id_riga: ".$id_riga."<br>";
//echo "negozio: ".$negozio_carrello."<br>";
switch ($negozio_rda) {
case "assets":
$queryb = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$queryb = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
case "labels":
$queryb = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prodotto'";
break;
case "vivistore":
$queryb = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto'";
break;
}
$resultb = mysql_query($queryb) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rowb = mysql_fetch_array($resultb)) {
$prezzo_aggiornato = $rowb[prezzo];
}
$totale_aggiornato = $prezzo_aggiornato*$quant;
$query = "UPDATE qui_righe_rda SET quant_modifica = '', quant = '$quant', totale = '$totale_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
//echo "aggiornato prezzo<br>";
	echo number_format($totale_aggiornato,2,",",".");
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
  $queryb = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$resultb = mysql_query($queryb);
while($rigab = mysql_fetch_array($resultb)) {
	//$lista_totali .= $rigab[totale]."<br>";
	//echo $lista_totali;
$totale_rda = $totale_rda + $rigab[totale];
}
$query = "UPDATE qui_rda SET totale_rda = '$totale_rda' WHERE id = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

	//output finale
	
	
	
	
	//echo $id_riga;

 ?>
