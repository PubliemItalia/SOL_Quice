<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_pl = $_GET['id_pl'];
$testo = addslashes(nl2br($_GET['testo']));

$query = "UPDATE qui_packing_list SET note = '$testo' WHERE id = '$id_pl'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}	


//output finale
echo $testo;
 ?>
