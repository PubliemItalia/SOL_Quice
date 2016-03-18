<style type="text/css">
.allin_centr {
	text-align: center;
	font-family:Arial;
	font-size:12px;
}
</style>
<table width="900" border="0">
  <tr>
    <td width="120">CONSUM.</td>
    <td colspan="3" class="allin_centr">ONLINE</td>
    <td colspan="3" class="allin_centr">NUOVO</td>
  </tr>
  <tr>
    <td class="allin_centr">COD.</td>
    <td width="55" class="allin_centr">ID</td>
    <td width="223" class="allin_centr">Descr.</td>
    <td width="100" class="allin_centr">Prezzo</td>
    <td width="55" class="allin_centr">ID</td>
    <td width="217" class="allin_centr">Descr.</td>
    <td width="100" class="allin_centr">Prezzo</td>
  </tr>
<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$queryb = "SELECT * FROM qui_consumabili_online ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rigad = mysql_fetch_array($resultb)) {
$id_prodotto = $rigad[id];
$codice_art = $rigad[codice_art];
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art = '$rigad[codice_art]' ORDER BY id ASC";
$resultc = mysql_query($queryc);
$presenza = mysql_num_rows($resultc);
if ($presenza == 0) {
echo "codice_art: ".$codice_art." - presenza: ".$presenza."<br>";

//id 	obsoleto 	negozio 	paese 	categoria1_it 	categoria2_it 	categoria3_it 	categoria4_it 	extra 	descrizione1_it 	descrizione2_it 	descrizione3_it 	descrizione4_it 	id_valvola 	id_cappellotto 	id_pescante 	codice_art 	cf 	codice_numerico 	gruppo_merci 	coge 	wbs 	prezzo 	confezione 	foto 	foto_gruppo 	foto_famiglia 	icona 	rif_famiglia 	precedenza 	categoria1_en 	categoria2_en 	categoria3_en 	categoria4_en 	descrizione1_en 	descrizione2_en 	descrizione3_en 	descrizione4_en 	filepath 	codice_originale_duplicato 	ordine_stampa 	switch_lista_radio 	ultima_modifica
$queryb = "INSERT INTO qui_prodotti_consumabili (obsoleto, negozio, paese, categoria1_it, categoria2_it, categoria3_it, categoria4_it, extra, descrizione1_it, descrizione2_it, descrizione3_it, descrizione4_it, id_valvola, id_cappellotto, id_pescante, codice_art, cf, codice_numerico, gruppo_merci, coge, wbs, prezzo, confezione, foto, foto_gruppo, foto_famiglia, icona, rif_famiglia, precedenza, categoria1_en, categoria2_en, categoria3_en, categoria4_en, descrizione1_en, descrizione2_en, descrizione3_en, descrizione4_en, filepath, codice_originale_duplicato, ordine_stampa, switch_lista_radio) VALUES ('$rigad[obsoleto]', '$rigad[negozio]', '$rigad[paese]', '$rigad[categoria1_it]', '$rigad[categoria2_it]', '$rigad[categoria3_it]', '$rigad[categoria4_it]', '$rigad[extra]', '$rigad[descrizione1_it]', '$rigad[descrizione2_it]', '$rigad[descrizione3_it]', '$rigad[descrizione4_it]', '$rigad[id_valvola]', '$rigad[id_cappellotto]', '$rigad[id_pescante]', '$rigad[codice_art]', '$rigad[cf]', '$rigad[codice_numerico]', '$rigad[gruppo_merci]', '$rigad[coge]', '$rigad[wbs]', '$rigad[prezzo]', '$rigad[confezione]', '$rigad[foto]', '$rigad[foto_gruppo]', '$rigad[foto_famiglia]', '$rigad[icona]', '$rigad[rif_famiglia]', '$rigad[precedenza]', '$rigad[categoria1_en]', '$rigad[categoria2_en]', '$rigad[categoria3_en]', '$rigad[categoria4_en]', '$rigad[descrizione1_en]', '$rigad[descrizione2_en]', '$rigad[descrizione3_en]', '$rigad[descrizione4_en]', '$rigad[filepath]', '$rigad[codice_originale_duplicato]', '$rigad[ordine_stampa]', '$rigad[switch_lista_radio]')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

$presenza = "";
$prezzo_nuovo = "";
$id_nuovo = "";
$descr_nuovo = "";
$codice_nuovo = "";
}
}
?>
</table>
