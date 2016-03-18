<?php
include "query.php";
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$array_esclusi = array("DPI","Etichette_ADR");
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto = '0'ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$categoria1_it = $rowb[categoria1_it];
$descrizione1_it = $rowb[descrizione1_it];
if (!in_array($categoria1_it,$array_esclusi)) {
//$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art != '$rowb[codice_art]' ORDER BY id ASC";
$queryc = "SELECT * FROM qui_righe_rda WHERE codice_art = '$codice_art'";
$resultc = mysql_query($queryc);
$presenti = mysql_num_rows($resultc);
//$querys = "SELECT * FROM qui_prodotti_consumabili WHERE descrizione1_it = '$descr' ";
if ($presenti > 0) {
} else {
echo "non acquistato ID: ".$id." - categoria: ".$categoria1_it." - codice: ".$codice_art." - descrizione: ".$descrizione1_it."<br>";	
}
$presenti = "";
$id = "";
$codice_art = "";
$descrizione1_it = "";
$categoria1_it = "";
}
}
?>
