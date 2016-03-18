<?php
session_start();
$id = $_GET[id];
$negozio = $_GET[shop];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$query = "UPDATE qui_prodotti_".$negozio." SET obsoleto = '1' WHERE id = '$id'";
//$titolo_pop1 = levapar($_POST[titolo_pop1]);
if (mysql_query($query)) {
	//$output .= "OK";
	$output .= "<input name=check id=check type=hidden value=OK>";
	
} else {
$output .= "Errore durante l'inserimento1: ".mysql_error();
}
/*$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$riepilogo = "Eliminazione prodotto id".$id." negozio ".$negozio." - da parte dell utente ".$id_utente;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'prodotti', '$id', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
*/	
//output finale
	echo $output;
?>
