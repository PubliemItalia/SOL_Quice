<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_rda = $_GET['id_rda'];
$ruolo = $_SESSION['ruolo'];
$ruolo_report = $_SESSION['ruolo_report'];
$testo = addslashes(nl2br($_GET['testo']));
switch($ruolo) {
	case "utente":
switch($ruolo_report) {
	case "":
	  $query = "UPDATE qui_rda SET note_utente = '$testo' WHERE id = '$id_rda'";
	break;
	case "buyer":
	  $query = "UPDATE qui_rda SET note_buyer = '$testo' WHERE id = '$id_rda'";
	break;
	case "magazziniere":
	  $query = "UPDATE qui_rda SET note_magazziniere = '$testo' WHERE id = '$id_rda'";
	break;
}
	break;
	case "responsabile":
switch($ruolo_report) {
	case "":
	  $query = "UPDATE qui_rda SET note_resp = '$testo' WHERE id = '$id_rda'";
	break;
	case "buyer":
	  $query = "UPDATE qui_rda SET note_buyer = '$testo' WHERE id = '$id_rda'";
	break;
	case "magazziniere":
	  $query = "UPDATE qui_rda SET note_magazziniere = '$testo' WHERE id = '$id_rda'";
	break;
}
	break;
	case "buyer":
	  $query = "UPDATE qui_rda SET note_buyer = '$testo' WHERE id = '$id_rda'";
	break;
	case "magazziniere":
	  $query = "UPDATE qui_rda SET note_magazziniere = '$testo' WHERE id = '$id_rda'";
	break;
}
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}	


//output finale

 ?>
