<?php
include "query.php";
$queryb = "SELECT * FROM qui_rda ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$queryc = "SELECT * FROM qui_utenti WHERE user_id = '$rowb[id_utente]'";
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$nazione = $rowc[nazione];
}
$query = "UPDATE qui_rda SET nazione = '$nazione' WHERE id = '$rowb[id]'";
if (mysql_query($query)) {
	echo "La RdA ".$rowb[id]."&egrave; stata correttamente modificata<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

$query = "UPDATE qui_righe_rda SET nazione = '$nazione' WHERE id_rda = '$rowb[id]'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$nazione = "";
}
?>
