<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_fatti = array();
$queryb = "SELECT * FROM qui_preferiti WHERE negozio = 'consumabili' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id_prod = $rowb[id_prod];
$descrizione = $rowb[descrizione];
if (!in_array($id_prod,$array_fatti)) {
	$add_id = array_push($array_fatti,$id_prod);
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod'";
$resultc = mysql_query($queryc);
$presenti = mysql_num_rows($resultc);
//$querys = "SELECT * FROM qui_prodotti_consumabili WHERE descrizione1_it = '$descr' ";
while ($rowc = mysql_fetch_array($resultc)) {
$descriz_cons = addslashes($rowc[descrizione1_it]);
if ($descrizione != $descriz_cons) {
	echo "ID: ".$id_prod." - descr preferiti: ".$descrizione."<br>descriz_cons: ".$descriz_cons."<br><br>";
	$query = "UPDATE qui_preferiti SET descrizione = '$descriz_cons' WHERE id_prod = '$id_prod'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

}
}
$presenti = "";
$id_prod = "";
$codice_art = "";
$descrizione = "";
$descriz_cons = "";
}
}
?>
