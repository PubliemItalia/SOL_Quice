<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_assets ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$nuovo_codice_art = "1".str_pad($rowb[id], 5, "0", STR_PAD_LEFT);
//aggiornamento campo id_valvola
$array_valvole = array();
$querys = "SELECT * FROM qui_prodotti_assets WHERE id_valvola = '$codice_art' ORDER BY id ASC";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
$addvalv = array_push($array_valvole,$rows[id]);
}
foreach ($array_valvole as $singvalv) {
$queryt = "UPDATE qui_prodotti_assets SET id_valvola = '$nuovo_codice_art' WHERE id = '$singvalv'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}

/*//aggiornamento campo id_cappellotto
$queryb = "UPDATE qui_prodotti_assets SET id_cappellotto = '$nuovo_codice_art' WHERE id_cappellotto = '$codice_art'";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

//aggiornamento campo id_pescante
$queryb = "UPDATE qui_prodotti_assets SET id_pescante = '$nuovo_codice_art' WHERE id_pescante = '$codice_art'";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
*/
$query = "UPDATE qui_prodotti_assets SET codice_art = '$nuovo_codice_art' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
echo "aggiornato prodotto ".$id."<br>";
}
?>