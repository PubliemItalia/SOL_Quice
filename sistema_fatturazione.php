<?php
include "query.php";
$query = "UPDATE qui_righe_rda SET n_fatt_sap = 'SI' WHERE nazione = 'Italy' AND n_fatt_sap = '' ORDER BY id ASC";
if (mysql_query($query)) {
	echo "La RdA ".$rowb[id]."&egrave; stata correttamente modificata<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
?>
