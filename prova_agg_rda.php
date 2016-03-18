<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_rda WHERE stato = '1' ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$id = $rigaz[id];
$id_utente = $rigaz[id_utente];
$sqlk = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$id_resp = $rigak[idresp];
}
$sqls = "SELECT * FROM qui_utenti WHERE user_id = '$id_resp'";
$risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
$nome_resp = $rigas[nome];
}
$query = "UPDATE qui_rda SET id_resp = '$id_resp', nome_resp = '$nome_resp' WHERE id = '$id'"; 
if (mysql_query($query)) {
	echo "RDA aggiornata: ".$id."<br>";
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}
?>