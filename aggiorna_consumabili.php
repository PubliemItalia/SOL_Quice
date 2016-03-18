<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_consumabili_ins ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$id = $rigaz[id];
$obsoleto = $rigaz[obsoleto];
$negozio = $rigaz[negozio];
$paese = $rigaz[paese];
$categoria1_it = $rigaz[categoria1_it];
$categoria2_it = $rigaz[categoria2_it];
$categoria3_it = $rigaz[categoria3_it];
$categoria4_it = $rigaz[categoria4_it];
$descrizione1_it = $rigaz[descrizione1_it];
$descrizione2_it = $rigaz[descrizione2_it];
$descrizione3_it = $rigaz[descrizione3_it];
$descrizione4_it = $rigaz[descrizione4_it];
$id_valvola = $rigaz[id_valvola];
$id_cappellotto = $rigaz[id_cappellotto];
$id_pescante = $rigaz[id_pescante];
$codice_art = $rigaz[codice_art];
$codice_numerico = $rigaz[codice_numerico];
$gruppo_merci = $rigaz[gruppo_merci];
$coge = $rigaz[coge];
$wbs = $rigaz[wbs];
$prezzo = $rigaz[prezzo];
$confezione = $rigaz[confezione];
$foto = $rigaz[foto];
$precedenza = $rigaz[precedenza];
$categoria1_en = $rigaz[categoria1_en];
$categoria2_en = $rigaz[categoria2_en];
$categoria3_en = $rigaz[categoria3_en];
$categoria4_en = $rigaz[categoria4_en];
$descrizione1_en = $rigaz[descrizione1_en];
$descrizione2_en = $rigaz[descrizione2_en];
$descrizione3_en = $rigaz[descrizione3_en];
$descrizione4_en = $rigaz[descrizione4_en];
$filepath = $rigaz[filepath];
$codice_originale_duplicato = $rigaz[codice_originale_duplicato];

$query = "UPDATE qui_prodotti_consumabili SET obsoleto = '$obsoleto', negozio = '$negozio', paese = '$paese', categoria1_it = '$categoria1_it', categoria2_it = '$categoria2_it', categoria3_it = '$categoria3_it', categoria4_it = '$categoria4_it', descrizione1_it = '$descrizione1_it', descrizione2_it = '$descrizione2_it', descrizione3_it = '$descrizione3_it', descrizione4_it = '$descrizione4_it', id_valvola = '$id_valvola', id_cappellotto = '$id_cappellotto', id_pescante = '$id_pescante', codice_art = '$codice_art', codice_numerico = '$codice_numerico', gruppo_merci = '$gruppo_merci', coge = '$coge', wbs = '$wbs', prezzo = '$prezzo', confezione = '$confezione', foto = '$foto', precedenza = '$precedenza', categoria1_en = '$categoria1_en', categoria2_en = '$categoria2_en', categoria3_en = '$categoria3_en', categoria4_en = '$categoria4_en', descrizione1_en = '$descrizione1_en', descrizione2_en = '$descrizione2_en', descrizione3_en = '$descrizione3_en', descrizione4_en = '$descrizione4_en', filepath = '$filepath', codice_originale_duplicato = '$codice_originale_duplicato' WHERE id = '$id'"; 
if (mysql_query($query)) {
	echo "riga aggiornata: ".$id."<br>";
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}
?>