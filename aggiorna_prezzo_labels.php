<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id = $_GET['id'];
$testo = str_replace(",",".",$_GET['testo']);
$query = "UPDATE qui_prodotti_labels SET prezzo = '$testo' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}	


//output finale

 ?>
