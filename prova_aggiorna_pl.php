<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_fatti = array();
$queryb = "SELECT * FROM qui_packing_list WHERE id_unita > '0' AND nome_unita = '' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$querys = "SELECT * FROM qui_unita WHERE id_unita = '$rowb[id_unita]'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
	$nome_unita = $rows[nome_unita];
}
$query = "UPDATE qui_packing_list SET nome_unita = '$nome_unita' WHERE id = '$rowb[id]'";
if (mysql_query($query)) {
	echo "aggiorno pl ".$rowb[id]."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$nome_unita = '';
}
?>
