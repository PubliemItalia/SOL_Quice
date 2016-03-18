<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_prodotti_assets WHERE categoria1_it = 'Valvole' ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$descrizione2_it = str_replace("\"","",($rigaz[descrizione2_it]));
echo "descrizione2_it: ".$descrizione2_it."<br>";
$id_riga = $rigaz[id];
$sqlq = "UPDATE qui_prodotti_assets SET descrizione2_it = '$descrizione2_it' WHERE id = '$id_riga'";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
if (mysql_query($risultq)) {
} else {
//echo "Errore durante la modifica". mysql_error()."<br>";
}
$descrizione2_it = "";
}
?>