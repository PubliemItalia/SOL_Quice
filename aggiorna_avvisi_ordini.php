<?php
session_start();
$id_riga = $_GET['id_riga'];
$tot = $_GET['id'];
$quant = $_GET['quant'];
$prezzo = str_replace(",",".",$_GET['prezzo']);
include "query.php";
if ($quant != "") {
	$out_value = $quant*$prezzo;
}
$query = "UPDATE qui_righe_ordini_for SET quant = '$quant', prezzo = '$prezzo', totale = '$out_value' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
	//output finale
	
	echo number_format($out_value,2,",",".");
	//echo $out_value;
	//echo "pippo";

 ?>
