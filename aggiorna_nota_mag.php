<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_rda = $_GET['id_rda'];
$testo = addslashes(str_replace("\n","<br>",$_GET['testo']));
$query = "UPDATE qui_rda SET note_magazziniere = '$testo' WHERE id = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}	

//output finale

 ?>
