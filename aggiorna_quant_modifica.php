<?php
$id_riga = $_GET['id_riga'];
$id = $_GET['id'];
$quant = $_GET['quant'];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

if ($quant > 0) {
$query = "UPDATE qui_righe_carrelli SET quant_modifica = '$quant' WHERE id = '$id_riga'";
} else {
$query = "UPDATE qui_righe_carrelli SET quant_modifica = '' WHERE id = '$id_riga'";
}
if (mysql_query($query)) {
	//output finale
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
 ?>
