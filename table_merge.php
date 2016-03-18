<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db


//id|part_number|obsoleto|negozio|azienda|ric_mag|paese|foto_paese|flusso|categoria1_it|categoria2_it|categoria3_it|categoria4_it|extra|variante_pharma|etich_x_foglio|art_x_conf_ric|descrizione1_it|descrizione2_it|descrizione3_it|descrizione4_it|id_valvola|id_cappellotto|id_pescante|codice_art|cf|prodotto_multilingue|codice_numerico|gruppo_merci|coge|wbs|prezzo|prezzo2|confezione|um|foto|foto_sost|foto_famiglia|icona|rif_famiglia|precedenza|precedenza_int|categoria1_en|categoria2_en|categoria3_en|categoria4_en|descrizione1_en|descrizione2_en|descrizione3_en|descrizione4_en|filepath|codice_originale_duplicato|ordine_stampa|switch_lista_radio|ultima_modifica|percorso_pdf|simbolo_blister|soglia|gestione_scorta|giacenza

$queryb = "SELECT * FROM qui_prodotti_consumabili ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $cod_part = $rowb[categoria4_it];
	  $queryb = "INSERT INTO qui_catalogo 
	  (id, part_number, obsoleto, negozio, azienda, ric_mag, paese, foto_paese, flusso, categoria1_it, categoria2_it, categoria3_it, categoria4_it, extra, variante_pharma, etich_x_foglio, art_x_conf_ric, descrizione1_it, descrizione2_it, descrizione3_it, descrizione4_it, id_valvola, id_cappellotto, id_pescante, codice_art, cf, prodotto_multilingue, codice_numerico, gruppo_merci, coge, wbs, prezzo, prezzo2, confezione, um, foto, foto_sost, foto_famiglia, icona, rif_famiglia, precedenza, precedenza_int, categoria1_en, categoria2_en, categoria3_en, categoria4_en, descrizione1_en, descrizione2_en, descrizione3_en, descrizione4_en, filepath, codice_originale_duplicato, ordine_stampa, switch_lista_radio, ultima_modifica, percorso_pdf, simbolo_blister, soglia, gestione_scorta, giacenza) VALUES 
	  ('$rowb[id]', '$rowb[part_number]', '$rowb[obsoleto]', '$rowb[negozio]', '$rowb[azienda]', '$rowb[ric_mag]', '$rowb[paese]', '$rowb[foto_paese]', '$rowb[flusso]', '$rowb[categoria1_it]', '$rowb[categoria2_it]', '$rowb[categoria3_it]', '$rowb[categoria4_it]', '$rowb[extra]', '$rowb[variante_pharma]', '$rowb[etich_x_foglio]', '$rowb[art_x_conf_ric]', 'addslashes($rowb[descrizione1_it])', 'addslashes($rowb[descrizione2_it])', 'addslashes($rowb[descrizione3_it])', 'addslashes($rowb[descrizione4_it])', '$rowb[id_valvola]', '$rowb[id_cappellotto]', '$rowb[id_pescante]', '$rowb[codice_art]', '$rowb[cf]', '$rowb[prodotto_multilingue]', '$rowb[codice_numerico]', '$rowb[gruppo_merci]', '$rowb[coge]', '$rowb[wbs]', '$rowb[prezzo]', '$rowb[prezzo2]', 'addslashes($rowb[confezione])', '$rowb[um]', '$rowb[foto]', '$rowb[foto_sost]', '$rowb[foto_famiglia]', '$rowb[icona]', '$rowb[rif_famiglia]', '$rowb[precedenza]', '$rowb[precedenza_int]', '$rowb[categoria1_en]', '$rowb[categoria2_en]', '$rowb[categoria3_en]', '$rowb[categoria4_en]', 'addslashes($rowb[descrizione1_en])', 'addslashes($rowb[descrizione2_en])', 'addslashes($rowb[descrizione3_en])', 'addslashes($rowb[descrizione4_en])', '$rowb[filepath]', '$rowb[codice_originale_duplicato]', '$rowb[ordine_stampa]', '$rowb[switch_lista_radio]', '$rowb[ultima_modifica]', '$rowb[percorso_pdf]', '$rowb[simbolo_blister]', '$rowb[soglia]', '$rowb[gestione_scorta]', '$rowb[giacenza]')";
	  if (mysql_query($queryb)) {
	  } else {
		echo "Errore durante l'inserimento". mysql_error();
	  }
}
?>