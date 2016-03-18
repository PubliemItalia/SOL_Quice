<?php
$sqly = "SELECT * FROM qui_testi_interfaccia ORDER BY pag ASC";
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
//diciture generali--criteri di ricerca
if ($rigay[posizione] == "criterio_ricerca") {
switch($lingua) {
case "it":
$criterio_ricerca = $rigay[testo_it];
break;
case "en":
$criterio_ricerca = $rigay[testo_en];
break;
case "fr":
$criterio_ricerca = $rigay[testo_fr];
break;
case "de":
$criterio_ricerca = $rigay[testo_de];
break;
case "es":
$criterio_ricerca = $rigay[testo_es];
break;
}
}
//diciture generali--Lista
if ($rigay[posizione] == "lista") {
switch($lingua) {
case "it":
$lista1 = $rigay[testo_it];
break;
case "en":
$lista1 = $rigay[testo_en];
break;
case "fr":
$lista1 = $rigay[testo_fr];
break;
case "de":
$lista1 = $rigay[testo_de];
break;
case "es":
$lista1 = $rigay[testo_es];
break;
}
}
//diciture generali--Griglia
if ($rigay[posizione] == "griglia") {
switch($lingua) {
case "it":
$griglia = $rigay[testo_it];
break;
case "en":
$griglia = $rigay[testo_en];
break;
case "fr":
$griglia = $rigay[testo_fr];
break;
case "de":
$griglia = $rigay[testo_de];
break;
case "es":
$griglia = $rigay[testo_es];
break;
}
}
//diciture generali--pulsante trova
if ($rigay[posizione] == "trova") {
switch($lingua) {
case "it":
$pulsante_trova = $rigay[testo_it];
break;
case "en":
$pulsante_trova = $rigay[testo_en];
break;
case "fr":
$pulsante_trova = $rigay[testo_fr];
break;
case "de":
$pulsante_trova = $rigay[testo_de];
break;
case "es":
$pulsante_trova = $rigay[testo_es];
break;
}
}
//diciture generali--pulsante reset filtri
if ($rigay[posizione] == "reset_filtri") {
switch($lingua) {
case "it":
$pulsante_reset_filtri = $rigay[testo_it];
break;
case "en":
$pulsante_reset_filtri = $rigay[testo_en];
break;
case "fr":
$pulsante_reset_filtri = $rigay[testo_fr];
break;
case "de":
$pulsante_reset_filtri = $rigay[testo_de];
break;
case "es":
$pulsante_reset_filtri = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna CODICE
if ($rigay[posizione] == "testata_tab_prod_codice") {
switch($lingua) {
case "it":
$testata_codice = $rigay[testo_it];
break;
case "en":
$testata_codice = $rigay[testo_en];
break;
case "fr":
$testata_codice = $rigay[testo_fr];
break;
case "de":
$testata_codice = $rigay[testo_de];
break;
case "es":
$testata_codice = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna NAZIONE
if ($rigay[posizione] == "testata_tab_prod_nazione") {
switch($lingua) {
case "it":
$testata_nazione = $rigay[testo_it];
break;
case "en":
$testata_nazione = $rigay[testo_en];
break;
case "fr":
$testata_nazione = $rigay[testo_fr];
break;
case "de":
$testata_nazione = $rigay[testo_de];
break;
case "es":
$testata_nazione = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna PRODOTTO
if ($rigay[posizione] == "testata_tab_prod_prodotto") {
switch($lingua) {
case "it":
$testata_prodotto = $rigay[testo_it];
break;
case "en":
$testata_prodotto = $rigay[testo_en];
break;
case "fr":
$testata_prodotto = $rigay[testo_fr];
break;
case "de":
$testata_prodotto = $rigay[testo_de];
break;
case "es":
$testata_prodotto = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna PREZZO
if ($rigay[posizione] == "testata_tab_prod_prezzo") {
switch($lingua) {
case "it":
$testata_prezzo = $rigay[testo_it];
break;
case "en":
$testata_prezzo = $rigay[testo_en];
break;
case "fr":
$testata_prezzo = $rigay[testo_fr];
break;
case "de":
$testata_prezzo = $rigay[testo_de];
break;
case "es":
$testata_prezzo = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna QUANT
if ($rigay[posizione] == "testata_tab_prod_quant") {
switch($lingua) {
case "it":
$testata_quant = $rigay[testo_it];
break;
case "en":
$testata_quant = $rigay[testo_en];
break;
case "fr":
$testata_quant = $rigay[testo_fr];
break;
case "de":
$testata_quant = $rigay[testo_de];
break;
case "es":
$testata_quant = $rigay[testo_es];
break;
}
}
	//testata della tabella--colonna TOTALE
if ($rigay[posizione] == "testata_tab_prod_totale") {
switch($lingua) {
case "it":
$testata_totale = $rigay[testo_it];
break;
case "en":
$testata_totale = $rigay[testo_en];
break;
case "fr":
$testata_totale = $rigay[testo_fr];
break;
case "de":
$testata_totale = $rigay[testo_de];
break;
case "es":
$testata_totale = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna PREFERITO
if ($rigay[posizione] == "testata_tab_prod_preferito") {
switch($lingua) {
case "it":
$testata_preferito = $rigay[testo_it];
break;
case "en":
$testata_preferito = $rigay[testo_en];
break;
case "fr":
$testata_preferito = $rigay[testo_fr];
break;
case "de":
$testata_preferito = $rigay[testo_de];
break;
case "es":
$testata_preferito = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna CARRELLO
if ($rigay[posizione] == "testata_tab_prod_carrello") {
switch($lingua) {
case "it":
$testata_carrello = $rigay[testo_it];
break;
case "en":
$testata_carrello = $rigay[testo_en];
break;
case "fr":
$testata_carrello = $rigay[testo_fr];
break;
case "de":
$testata_carrello = $rigay[testo_de];
break;
case "es":
$testata_carrello = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna IMBALLO
if ($rigay[posizione] == "testata_tab_prod_imballo") {
switch($lingua) {
case "it":
$testata_imballo = $rigay[testo_it];
break;
case "en":
$testata_imballo = $rigay[testo_en];
break;
case "fr":
$testata_imballo = $rigay[testo_fr];
break;
case "de":
$testata_imballo = $rigay[testo_de];
break;
case "es":
$testata_imballo = $rigay[testo_es];
break;
}
}
//testata della tabella--colonna descrizione
if ($rigay[posizione] == "testata_tab_prod_descrizione") {
switch($lingua) {
case "it":
$testata_descrizione = $rigay[testo_it];
break;
case "en":
$testata_descrizione = $rigay[testo_en];
break;
case "fr":
$testata_descrizione = $rigay[testo_fr];
break;
case "de":
$testata_descrizione = $rigay[testo_de];
break;
case "es":
$testata_descrizione = $rigay[testo_es];
break;
}
}

//testata della tabella--colonna id ordine
if ($rigay[posizione] == "testata_tab_id_ordine") {
switch($lingua) {
case "it":
$testata_id_ordine = $rigay[testo_it];
break;
case "en":
$testata_id_ordine = $rigay[testo_en];
break;
case "fr":
$testata_id_ordine = $rigay[testo_fr];
break;
case "de":
$testata_id_ordine = $rigay[testo_de];
break;
case "es":
$testata_id_ordine = $rigay[testo_es];
break;
}
}

//testata della tabella--colonna data
if ($rigay[posizione] == "testata_tab_data") {
switch($lingua) {
case "it":
$testata_data = $rigay[testo_it];
break;
case "en":
$testata_data = $rigay[testo_en];
break;
case "fr":
$testata_data = $rigay[testo_fr];
break;
case "de":
$testata_data = $rigay[testo_de];
break;
case "es":
$testata_data = $rigay[testo_es];
break;
}
}

//testata della tabella--colonna stato ordine
if ($rigay[posizione] == "testata_tab_stato_ordine") {
switch($lingua) {
case "it":
$testata_status = $rigay[testo_it];
break;
case "en":
$testata_status = $rigay[testo_en];
break;
case "fr":
$testata_status = $rigay[testo_fr];
break;
case "de":
$testata_status = $rigay[testo_de];
break;
case "es":
$testata_status = $rigay[testo_es];
break;
}
}

//testata della tabella--colonna totale
if ($rigay[posizione] == "testata_tab_totale") {
switch($lingua) {
case "it":
$testata_totale = $rigay[testo_it];
break;
case "en":
$testata_totale = $rigay[testo_en];
break;
case "fr":
$testata_totale = $rigay[testo_fr];
break;
case "de":
$testata_totale = $rigay[testo_de];
break;
case "es":
$testata_totale = $rigay[testo_es];
break;
}
}

//testata della tabella--colonna nome utente
if ($rigay[posizione] == "testata_tab_utente") {
switch($lingua) {
case "it":
$testata_utente = $rigay[testo_it];
break;
case "en":
$testata_utente = $rigay[testo_en];
break;
case "fr":
$testata_utente = $rigay[testo_fr];
break;
case "de":
$testata_utente = $rigay[testo_de];
break;
case "es":
$testata_utente = $rigay[testo_es];
break;
}
}

//testata della tabella--colonna responsabile
if ($rigay[posizione] == "testata_tab_responsabiler") {
switch($lingua) {
case "it":
$testata_responsabile = $rigay[testo_it];
break;
case "en":
$testata_responsabile = $rigay[testo_en];
break;
case "fr":
$testata_responsabile = $rigay[testo_fr];
break;
case "de":
$testata_responsabile = $rigay[testo_de];
break;
case "es":
$testata_responsabile = $rigay[testo_es];
break;
}
}

//testata della finestra del  carrello
if ($rigay[posizione] == "titolo" AND $rigay[pag] == "carrello") {
switch($lingua) {
case "it":
$titolo_carrello = $rigay[testo_it];
break;
case "en":
$titolo_carrello = $rigay[testo_en];
break;
case "fr":
$titolo_carrello = $rigay[testo_fr];
break;
case "de":
$titolo_carrello = $rigay[testo_de];
break;
case "es":
$titolo_carrello = $rigay[testo_es];
break;
}
}
//testo totale dettaglio rda
if ($rigay[posizione] == "totale_carrello" AND $rigay[pag] == "carrello") {
switch($lingua) {
case "it":
$testo_totale_carrello = $rigay[testo_it];
break;
case "en":
$testo_totale_carrello = $rigay[testo_en];
break;
case "fr":
$testo_totale_carrello = $rigay[testo_fr];
break;
case "de":
$testo_totale_carrello = $rigay[testo_de];
break;
case "es":
$testo_totale_carrello = $rigay[testo_es];
break;
}
}
//tasti menu
//tasto tutti
if ($rigay[posizione] == "tasto_tutti" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_tutti = $rigay[testo_it];
break;
case "en":
$tasto_tutti = $rigay[testo_en];
break;
case "fr":
$tasto_tutti = $rigay[testo_fr];
break;
case "de":
$tasto_tutti = $rigay[testo_de];
break;
case "es":
$tasto_tutti = $rigay[testo_es];
break;
}
}
//tasto assets
if ($rigay[posizione] == "tasto_asset" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_asset = $rigay[testo_it];
break;
case "en":
$tasto_asset = $rigay[testo_en];
break;
case "fr":
$tasto_asset = $rigay[testo_fr];
break;
case "de":
$tasto_asset = $rigay[testo_de];
break;
case "es":
$tasto_asset = $rigay[testo_es];
break;
}
}
//tasto_consumabili
if ($rigay[posizione] == "tasto_consumabili" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_consumabili = $rigay[testo_it];
break;
case "en":
$tasto_consumabili = $rigay[testo_en];
break;
case "fr":
$tasto_consumabili = $rigay[testo_fr];
break;
case "de":
$tasto_consumabili = $rigay[testo_de];
break;
case "es":
$tasto_consumabili = $rigay[testo_es];
break;
}
}
//tasto_spare parts
if ($rigay[posizione] == "tasto_spare_parts" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_spare_parts = $rigay[testo_it];
break;
case "en":
$tasto_spare_parts = $rigay[testo_en];
break;
case "fr":
$tasto_spare_parts = $rigay[testo_fr];
break;
case "de":
$tasto_spare_parts = $rigay[testo_de];
break;
case "es":
$tasto_spare_parts = $rigay[testo_es];
break;
}
}
//tasto_labels
if ($rigay[posizione] == "tasto_labels" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_labels = $rigay[testo_it];
break;
case "en":
$tasto_labels = $rigay[testo_en];
break;
case "fr":
$tasto_labels = $rigay[testo_fr];
break;
case "de":
$tasto_labels = $rigay[testo_de];
break;
case "es":
$tasto_labels = $rigay[testo_es];
break;
}
}
//tasto_vivistore
if ($rigay[posizione] == "tasto_vivistore" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_vivistore = $rigay[testo_it];
break;
case "en":
$tasto_vivistore = $rigay[testo_en];
break;
case "fr":
$tasto_vivistore = $rigay[testo_fr];
break;
case "de":
$tasto_vivistore = $rigay[testo_de];
break;
case "es":
$tasto_vivistore = $rigay[testo_es];
break;
}
}
//tasto_meddevice
if ($rigay[posizione] == "tasto_meddevice" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_meddevice = $rigay[testo_it];
break;
case "en":
$tasto_meddevice = $rigay[testo_en];
break;
case "fr":
$tasto_meddevice = $rigay[testo_fr];
break;
case "de":
$tasto_meddevice = $rigay[testo_de];
break;
case "es":
$tasto_meddevice = $rigay[testo_es];
break;
}
}
//tasto_ricerca
if ($rigay[posizione] == "tasto_ricerca" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$tasto_ricerca = $rigay[testo_it];
break;
case "en":
$tasto_ricerca = $rigay[testo_en];
break;
case "fr":
$tasto_ricerca = $rigay[testo_fr];
break;
case "de":
$tasto_ricerca = $rigay[testo_de];
break;
case "es":
$tasto_ricerca = $rigay[testo_es];
break;
}
}
//testo 1 pag index
if ($rigay[posizione] == "1" AND $rigay[pag] == "index") {
switch($lingua) {
case "it":
$testo1_index = $rigay[testo_it];
break;
case "en":
$testo1_index = $rigay[testo_en];
break;
case "fr":
$testo1_index = $rigay[testo_fr];
break;
case "de":
$testo1_index = $rigay[testo_de];
break;
case "es":
$testo1_index = $rigay[testo_es];
break;
}
}
//testo 2 pag index
if ($rigay[posizione] == "2" AND $rigay[pag] == "index") {
switch($lingua) {
case "it":
$testo2_index = $rigay[testo_it];
break;
case "en":
$testo2_index = $rigay[testo_en];
break;
case "fr":
$testo2_index = $rigay[testo_fr];
break;
case "de":
$testo2_index = $rigay[testo_de];
break;
case "es":
$testo2_index = $rigay[testo_es];
break;
}
}
//testo 3 pag index
if ($rigay[posizione] == "3" AND $rigay[pag] == "index") {
switch($lingua) {
case "it":
$testo3_index = $rigay[testo_it];
break;
case "en":
$testo3_index = $rigay[testo_en];
break;
case "fr":
$testo3_index = $rigay[testo_fr];
break;
case "de":
$testo3_index = $rigay[testo_de];
break;
case "es":
$testo3_index = $rigay[testo_es];
break;
}
}
//testo ricerca menu
if ($rigay[posizione] == "cerca" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_ricerca = $rigay[testo_it];
break;
case "en":
$testo_ricerca = $rigay[testo_en];
break;
case "fr":
$testo_ricerca = $rigay[testo_fr];
break;
case "de":
$testo_ricerca = $rigay[testo_de];
break;
case "es":
$testo_ricerca = $rigay[testo_es];
break;
}
}
//testo carrello menu
if ($rigay[posizione] == $negozio_carrello AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_carrello = $rigay[testo_it];
break;
case "en":
$testo_carrello = $rigay[testo_en];
break;
case "fr":
$testo_carrello = $rigay[testo_fr];
break;
case "de":
$testo_carrello = $rigay[testo_de];
break;
case "es":
$testo_carrello = $rigay[testo_es];
break;
}
}
//testo prodotto carrello menu
if ($rigay[posizione] == "prodotto" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_prodotto = $rigay[testo_it];
break;
case "en":
$testo_prodotto = $rigay[testo_en];
break;
case "fr":
$testo_prodotto = $rigay[testo_fr];
break;
case "de":
$testo_prodotto = $rigay[testo_de];
break;
case "es":
$testo_prodotto = $rigay[testo_es];
break;
}
}
//testo prodotti carrello menu
if ($rigay[posizione] == "prodotti" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_prodotti = $rigay[testo_it];
break;
case "en":
$testo_prodotti = $rigay[testo_en];
break;
case "fr":
$testo_prodotti = $rigay[testo_fr];
break;
case "de":
$testo_prodotti = $rigay[testo_de];
break;
case "es":
$testo_prodotti = $rigay[testo_es];
break;
}
}
//testo carrello vuoto menu
if ($rigay[posizione] == "carrello_vuoto" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_carrello_vuoto = $rigay[testo_it];
break;
case "en":
$testo_carrello_vuoto = $rigay[testo_en];
break;
case "fr":
$testo_carrello_vuoto = $rigay[testo_fr];
break;
case "de":
$testo_carrello_vuoto = $rigay[testo_de];
break;
case "es":
$testo_carrello_vuoto = $rigay[testo_es];
break;
}
}
//tasto rda attive menu
if ($rigay[posizione] == "rda" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$tasto_rda = $rigay[testo_it];
break;
case "en":
$tasto_rda = $rigay[testo_en];
break;
case "fr":
$tasto_rda = $rigay[testo_fr];
break;
case "de":
$tasto_rda = $rigay[testo_de];
break;
case "es":
$tasto_rda = $rigay[testo_es];
break;
}
}
//tasto rda in lavorazione
if ($rigay[posizione] == "rda_lavorazione" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$tasto_rda_lav = $rigay[testo_it];
break;
case "en":
$tasto_rda_lav = $rigay[testo_en];
break;
case "fr":
$tasto_rda_lav = $rigay[testo_fr];
break;
case "de":
$tasto_rda_lav = $rigay[testo_de];
break;
case "es":
$tasto_rda_lav = $rigay[testo_es];
break;
}
}
//tasto archivio generale per buyer
if ($rigay[posizione] == "archivio_generale" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$tasto_arch_gen = $rigay[testo_it];
break;
case "en":
$tasto_arch_gen = $rigay[testo_en];
break;
case "fr":
$tasto_arch_gen = $rigay[testo_fr];
break;
case "de":
$tasto_arch_gen = $rigay[testo_de];
break;
case "es":
$tasto_arch_gen = $rigay[testo_es];
break;
}
}
//tasto archivio menu
if ($rigay[posizione] == "archive" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$tasto_archivio = $rigay[testo_it];
break;
case "en":
$tasto_archivio = $rigay[testo_en];
break;
case "fr":
$tasto_archivio = $rigay[testo_fr];
break;
case "de":
$tasto_archivio = $rigay[testo_de];
break;
case "es":
$tasto_archivio = $rigay[testo_es];
break;
}
}
//tasto bookmark menu
if ($rigay[posizione] == "bookmark" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$tasto_bookmark = $rigay[testo_it];
break;
case "en":
$tasto_bookmark = $rigay[testo_en];
break;
case "fr":
$tasto_bookmark = $rigay[testo_fr];
break;
case "de":
$tasto_bookmark = $rigay[testo_de];
break;
case "es":
$tasto_bookmark = $rigay[testo_es];
break;
}
}
//tasto scegli_categoria menu
if ($rigay[posizione] == "scegli_categoria" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scelta_categoria = $rigay[testo_it];
break;
case "en":
$scelta_categoria = $rigay[testo_en];
break;
case "fr":
$scelta_categoria = $rigay[testo_fr];
break;
case "de":
$scelta_categoria = $rigay[testo_de];
break;
case "es":
$scelta_categoria = $rigay[testo_es];
break;
}
}
//tasto scegli_paese menu
if ($rigay[posizione] == "scegli_paese" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scegli_paese = $rigay[testo_it];
break;
case "en":
$scegli_paese = $rigay[testo_en];
break;
case "fr":
$scegli_paese = $rigay[testo_fr];
break;
case "de":
$scegli_paese = $rigay[testo_de];
break;
case "es":
$scegli_paese = $rigay[testo_es];
break;
}
}

//testo carrello vuoto
if ($rigay[posizione] == "carrello_vuoto" AND $rigay[pag] == "tabelle") {
switch($lingua) {
case "it":
$carrello_vuoto = $rigay[testo_it];
break;
case "en":
$carrello_vuoto = $rigay[testo_en];
break;
case "fr":
$carrello_vuoto = $rigay[testo_fr];
break;
case "de":
$carrello_vuoto = $rigay[testo_de];
break;
case "es":
$carrello_vuoto = $rigay[testo_es];
break;
}
}
//testo ricerca senza risultati
if ($rigay[posizione] == "risultato_ricerca" AND $rigay[pag] == "tabelle") {
switch($lingua) {
case "it":
$risultato_ricerca = $rigay[testo_it];
break;
case "en":
$risultato_ricerca = $rigay[testo_en];
break;
case "fr":
$risultato_ricerca = $rigay[testo_fr];
break;
case "de":
$risultato_ricerca = $rigay[testo_de];
break;
case "es":
$risultato_ricerca = $rigay[testo_es];
break;
}
}
//testo tooltip visualizza_scheda
if ($rigay[posizione] == "visualizza_scheda" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$tooltip_visualizza_scheda = $rigay[testo_it];
break;
case "en":
$tooltip_visualizza_scheda = $rigay[testo_en];
break;
case "fr":
$tooltip_visualizza_scheda = $rigay[testo_fr];
break;
case "de":
$tooltip_visualizza_scheda = $rigay[testo_de];
break;
case "es":
$tooltip_visualizza_scheda = $rigay[testo_es];
break;
}
}
//testo tooltip elimina preferito
if ($rigay[posizione] == "elimina_preferito" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$tooltip_elimina_preferito = $rigay[testo_it];
break;
case "en":
$tooltip_elimina_preferito = $rigay[testo_en];
break;
case "fr":
$tooltip_elimina_preferito = $rigay[testo_fr];
break;
case "de":
$tooltip_elimina_preferito = $rigay[testo_de];
break;
case "es":
$tooltip_elimina_preferito = $rigay[testo_es];
break;
}
}
//testo tooltip registra preferito
if ($rigay[posizione] == "registra_preferito" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$tooltip_registra_preferito = $rigay[testo_it];
break;
case "en":
$tooltip_registra_preferito = $rigay[testo_en];
break;
case "fr":
$tooltip_registra_preferito = $rigay[testo_fr];
break;
case "de":
$tooltip_registra_preferito = $rigay[testo_de];
break;
case "es":
$tooltip_registra_preferito = $rigay[testo_es];
break;
}
}
//testo tooltip visualizza dettaglio
if ($rigay[posizione] == "visualizza_dettaglio" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$visualizza_dettaglio = $rigay[testo_it];
break;
case "en":
$visualizza_dettaglio = $rigay[testo_en];
break;
case "fr":
$visualizza_dettaglio = $rigay[testo_fr];
break;
case "de":
$visualizza_dettaglio = $rigay[testo_de];
break;
case "es":
$visualizza_dettaglio = $rigay[testo_es];
break;
}
}
//testo tooltip seleziona tutto
if ($rigay[posizione] == "seleziona_tutto" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$tooltip_seleziona_tutto = $rigay[testo_it];
break;
case "en":
$tooltip_seleziona_tutto = $rigay[testo_en];
break;
case "fr":
$tooltip_seleziona_tutto = $rigay[testo_fr];
break;
case "de":
$tooltip_seleziona_tutto = $rigay[testo_de];
break;
case "es":
$tooltip_seleziona_tutto = $rigay[testo_es];
break;
}
}
//testo tooltip deseleziona tutto
if ($rigay[posizione] == "deseleziona_tutto" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$tooltip_deseleziona_tutto = $rigay[testo_it];
break;
case "en":
$tooltip_deseleziona_tutto = $rigay[testo_en];
break;
case "fr":
$tooltip_deseleziona_tutto = $rigay[testo_fr];
break;
case "de":
$tooltip_deseleziona_tutto = $rigay[testo_de];
break;
case "es":
$tooltip_deseleziona_tutto = $rigay[testo_es];
break;
}
}
//testo tooltip inserisci carrello
if ($rigay[posizione] == "inserisci_carrello" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$tooltip_inserisci_carrello = $rigay[testo_it];
break;
case "en":
$tooltip_inserisci_carrello = $rigay[testo_en];
break;
case "fr":
$tooltip_inserisci_carrello = $rigay[testo_fr];
break;
case "de":
$tooltip_inserisci_carrello = $rigay[testo_de];
break;
case "es":
$tooltip_inserisci_carrello = $rigay[testo_es];
break;
}
}
//testo mail num rda
if ($rigay[posizione] == "testo_num_rda" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_num_rda = $rigay[testo_it];
break;
case "en":
$testo_num_rda = $rigay[testo_en];
break;
case "fr":
$testo_num_rda = $rigay[testo_fr];
break;
case "de":
$testo_num_rda = $rigay[testo_de];
break;
case "es":
$testo_num_rda = $rigay[testo_es];
break;
}
}
//testo mail num rda
if ($rigay[posizione] == "testo_data_rda" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_data_rda = $rigay[testo_it];
break;
case "en":
$testo_data_rda = $rigay[testo_en];
break;
case "fr":
$testo_data_rda = $rigay[testo_fr];
break;
case "de":
$testo_data_rda = $rigay[testo_de];
break;
case "es":
$testo_data_rda = $rigay[testo_es];
break;
}
}
//testo mail utente
if ($rigay[posizione] == "testo_email_utente" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_mail_utente = $rigay[testo_it];
break;
case "en":
$testo_mail_utente = $rigay[testo_en];
break;
case "fr":
$testo_mail_utente = $rigay[testo_fr];
break;
case "de":
$testo_mail_utente = $rigay[testo_de];
break;
case "es":
$testo_mail_utente = $rigay[testo_es];
break;
}
}
//testo mail responsabile
if ($rigay[posizione] == "testo_email_responsabile" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_mail_responsabile = $rigay[testo_it];
break;
case "en":
$testo_mail_responsabile = $rigay[testo_en];
break;
case "fr":
$testo_mail_responsabile = $rigay[testo_fr];
break;
case "de":
$testo_mail_responsabile = $rigay[testo_de];
break;
case "es":
$testo_mail_responsabile = $rigay[testo_es];
break;
}
}
//testo mail buyer
if ($rigay[posizione] == "testo_email_buyer" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_mail_buyer = $rigay[testo_it];
break;
case "en":
$testo_mail_buyer = $rigay[testo_en];
break;
case "fr":
$testo_mail_buyer = $rigay[testo_fr];
break;
case "de":
$testo_mail_buyer = $rigay[testo_de];
break;
case "es":
$testo_mail_buyer = $rigay[testo_es];
break;
}
}
//testo mail indirizzo filiale
if ($rigay[posizione] == "testo_email_indirizzo_filiale" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_mail_indirizzo_filiale = $rigay[testo_it];
break;
case "en":
$testo_mail_indirizzo_filiale = $rigay[testo_en];
break;
case "fr":
$testo_mail_indirizzo_filiale = $rigay[testo_fr];
break;
case "de":
$testo_mail_indirizzo_filiale = $rigay[testo_de];
break;
case "es":
$testo_mail_indirizzo_filiale = $rigay[testo_es];
break;
}
}

//testo mail indirizzo filiale
if ($rigay[posizione] == "testo_mail_negozio" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$testo_mail_negozio = $rigay[testo_it];
break;
case "en":
$testo_mail_negozio = $rigay[testo_en];
break;
case "fr":
$testo_mail_negozio = $rigay[testo_fr];
break;
case "de":
$testo_mail_negozio = $rigay[testo_de];
break;
case "es":
$testo_mail_negozio = $rigay[testo_es];
break;
}
}
//testo mail indirizzo mancante
if ($rigay[posizione] == "indirizzo_mancante" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$indirizzo_mancante = $rigay[testo_it];
break;
case "en":
$indirizzo_mancante = $rigay[testo_en];
break;
case "fr":
$indirizzo_mancante = $rigay[testo_fr];
break;
case "de":
$indirizzo_mancante = $rigay[testo_de];
break;
case "es":
$indirizzo_mancante = $rigay[testo_es];
break;
}
}
//testo scritta form carrello
if ($rigay[posizione] == "scritta_carrello" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$scritta_carrello = $rigay[testo_it];
break;
case "en":
$scritta_carrello = $rigay[testo_en];
break;
case "fr":
$scritta_carrello = $rigay[testo_fr];
break;
case "de":
$scritta_carrello = $rigay[testo_de];
break;
case "es":
$scritta_carrello = $rigay[testo_es];
break;
}
}
//testo scritta form rda
if ($rigay[posizione] == "scritta_rda" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$scritta_rda = $rigay[testo_it];
break;
case "en":
$scritta_rda = $rigay[testo_en];
break;
case "fr":
$scritta_rda = $rigay[testo_fr];
break;
case "de":
$scritta_rda = $rigay[testo_de];
break;
case "es":
$scritta_rda = $rigay[testo_es];
break;
}
}
//testo pulsante crea RdA form carrello
if ($rigay[posizione] == "crea_rda" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$crea_rda = $rigay[testo_it];
break;
case "en":
$crea_rda = $rigay[testo_en];
break;
case "fr":
$crea_rda = $rigay[testo_fr];
break;
case "de":
$crea_rda = $rigay[testo_de];
break;
case "es":
$crea_rda = $rigay[testo_es];
break;
}
}
//testo svuota form carrello
if ($rigay[posizione] == "svuota_carrello" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$svuota_carrello = $rigay[testo_it];
break;
case "en":
$svuota_carrello = $rigay[testo_en];
break;
case "fr":
$svuota_carrello = $rigay[testo_fr];
break;
case "de":
$svuota_carrello = $rigay[testo_de];
break;
case "es":
$svuota_carrello = $rigay[testo_es];
break;
}
}
//testo invia buyer form rda
if ($rigay[posizione] == "invia_buyer" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$invia_buyer = $rigay[testo_it];
break;
case "en":
$invia_buyer = $rigay[testo_en];
break;
case "fr":
$invia_buyer = $rigay[testo_fr];
break;
case "de":
$invia_buyer = $rigay[testo_de];
break;
case "es":
$invia_buyer = $rigay[testo_es];
break;
}
}
//testo processa buyer form rda per tutti i negozi tranne gli assets
if ($rigay[posizione] == "processa_buyer" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$processa_buyer = $rigay[testo_it];
break;
case "en":
$processa_buyer = $rigay[testo_en];
break;
case "fr":
$processa_buyer = $rigay[testo_fr];
break;
case "de":
$processa_buyer = $rigay[testo_de];
break;
case "es":
$processa_buyer = $rigay[testo_es];
break;
}
}
//testo processa buyer form rda per il negozio assets
if ($rigay[posizione] == "processa_buyer_assets" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$processa_buyer_assets = $rigay[testo_it];
break;
case "en":
$processa_buyer_assets = $rigay[testo_en];
break;
case "fr":
$processa_buyer_assets = $rigay[testo_fr];
break;
case "de":
$processa_buyer_assets = $rigay[testo_de];
break;
case "es":
$processa_buyer_assets = $rigay[testo_es];
break;
}
}
//testo annulla form
if ($rigay[posizione] == "annulla" AND $rigay[pag] == "form") {
switch($lingua) {
case "it":
$annulla = $rigay[testo_it];
break;
case "en":
$annulla = $rigay[testo_en];
break;
case "fr":
$annulla = $rigay[testo_fr];
break;
case "de":
$annulla = $rigay[testo_de];
break;
case "es":
$annulla = $rigay[testo_es];
break;
}
}
//testo eliminazione foto dalla gallery
if ($rigay[posizione] == "elimina_image_gallery" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$elimina_image_gallery = $rigay[testo_it];
break;
case "en":
$elimina_image_gallery = $rigay[testo_en];
break;
case "fr":
$elimina_image_gallery = $rigay[testo_fr];
break;
case "de":
$elimina_image_gallery = $rigay[testo_de];
break;
case "es":
$elimina_image_gallery = $rigay[testo_es];
break;
}
}
//testo seleziona radio button buyer form rda
if ($rigay[posizione] == "seleziona" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$seleziona_radio = $rigay[testo_it];
break;
case "en":
$seleziona_radio = $rigay[testo_en];
break;
case "fr":
$seleziona_radio = $rigay[testo_fr];
break;
case "de":
$seleziona_radio = $rigay[testo_de];
break;
case "es":
$seleziona_radio = $rigay[testo_es];
break;
}
}
//testo deseleziona radio button buyer form rda
if ($rigay[posizione] == "annulla_selezione" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$annulla_radio = $rigay[testo_it];
break;
case "en":
$annulla_radio = $rigay[testo_en];
break;
case "fr":
$annulla_radio = $rigay[testo_fr];
break;
case "de":
$annulla_radio = $rigay[testo_de];
break;
case "es":
$annulla_radio = $rigay[testo_es];
break;
}
}
//testo deseleziona radio button buyer form rda
if ($rigay[posizione] == "elimina_articolo" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$elimina_articolo = $rigay[testo_it];
break;
case "en":
$elimina_articolo = $rigay[testo_en];
break;
case "fr":
$elimina_articolo = $rigay[testo_fr];
break;
case "de":
$elimina_articolo = $rigay[testo_de];
break;
case "es":
$elimina_articolo = $rigay[testo_es];
break;
}
}
//testo visuallizzazione rda 
if ($rigay[posizione] == "visualizza_rda" AND $rigay[pag] == "tooltip") {
switch($lingua) {
case "it":
$visualizza_rda = $rigay[testo_it];
break;
case "en":
$visualizza_rda = $rigay[testo_en];
break;
case "fr":
$visualizza_rda = $rigay[testo_fr];
break;
case "de":
$visualizza_rda = $rigay[testo_de];
break;
case "es":
$visualizza_rda = $rigay[testo_es];
break;
}
}
//testo titolo mail
if ($rigay[posizione] == "titolo_mail" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$titolo_mail = $rigay[testo_it];
break;
case "en":
$titolo_mail = $rigay[testo_en];
break;
case "fr":
$titolo_mail = $rigay[testo_fr];
break;
case "de":
$titolo_mail = $rigay[testo_de];
break;
case "es":
$titolo_mail = $rigay[testo_es];
break;
}
}
//testo titolo mail
if ($rigay[posizione] == "dettaglio_mail" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$dettaglio_mail = $rigay[testo_it];
break;
case "en":
$dettaglio_mail = $rigay[testo_en];
break;
case "fr":
$dettaglio_mail = $rigay[testo_fr];
break;
case "de":
$dettaglio_mail = $rigay[testo_de];
break;
case "es":
$dettaglio_mail = $rigay[testo_es];
break;
}
}
//testo oggetto_invio mail
if ($rigay[posizione] == "oggetto_invio" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$oggetto_invio = $rigay[testo_it];
break;
case "en":
$oggetto_invio = $rigay[testo_en];
break;
case "fr":
$oggetto_invio = $rigay[testo_fr];
break;
case "de":
$oggetto_invio = $rigay[testo_de];
break;
case "es":
$oggetto_invio = $rigay[testo_es];
break;
}
}
//testo oggetto_approvazione mail
if ($rigay[posizione] == "oggetto_approvazione" AND $rigay[pag] == "mail") {
switch($lingua) {
case "it":
$oggetto_approvazione = $rigay[testo_it];
break;
case "en":
$oggetto_approvazione = $rigay[testo_en];
break;
case "fr":
$oggetto_approvazione = $rigay[testo_fr];
break;
case "de":
$oggetto_approvazione = $rigay[testo_de];
break;
case "es":
$oggetto_approvazione = $rigay[testo_es];
break;
}
}
//testo status rda 1
if ($rigay[posizione] == "1" AND $rigay[pag] == "status") {
switch($lingua) {
case "it":
$status1 = $rigay[testo_it];
break;
case "en":
$status1 = $rigay[testo_en];
break;
case "fr":
$status1 = $rigay[testo_fr];
break;
case "de":
$status1 = $rigay[testo_de];
break;
case "es":
$status1 = $rigay[testo_es];
break;
}
}
//testo status rda 2
if ($rigay[posizione] == "2" AND $rigay[pag] == "status") {
switch($lingua) {
case "it":
$status2 = $rigay[testo_it];
break;
case "en":
$status2 = $rigay[testo_en];
break;
case "fr":
$status2 = $rigay[testo_fr];
break;
case "de":
$status2 = $rigay[testo_de];
break;
case "es":
$status2 = $rigay[testo_es];
break;
}
}
//testo status rda 3
if ($rigay[posizione] == "3" AND $rigay[pag] == "status") {
switch($lingua) {
case "it":
$status3 = $rigay[testo_it];
break;
case "en":
$status3 = $rigay[testo_en];
break;
case "fr":
$status3 = $rigay[testo_fr];
break;
case "de":
$status3 = $rigay[testo_de];
break;
case "es":
$status3 = $rigay[testo_es];
break;
}
}
//testo status rda 4
if ($rigay[posizione] == "4" AND $rigay[pag] == "status") {
switch($lingua) {
case "it":
$status4 = $rigay[testo_it];
break;
case "en":
$status4 = $rigay[testo_en];
break;
case "fr":
$status4 = $rigay[testo_fr];
break;
case "de":
$status4 = $rigay[testo_de];
break;
case "es":
$status4 = $rigay[testo_es];
break;
}
}
//testo info dettaglio rda
if ($rigay[posizione] == "informazioni_rda" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$informazioni_rda = $rigay[testo_it];
break;
case "en":
$informazioni_rda = $rigay[testo_en];
break;
case "fr":
$informazioni_rda = $rigay[testo_fr];
break;
case "de":
$informazioni_rda = $rigay[testo_de];
break;
case "es":
$informazioni_rda = $rigay[testo_es];
break;
}
}
//testo utente dettaglio rda
if ($rigay[posizione] == "utente" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$utente_rda = $rigay[testo_it];
break;
case "en":
$utente_rda = $rigay[testo_en];
break;
case "fr":
$utente_rda = $rigay[testo_fr];
break;
case "de":
$utente_rda = $rigay[testo_de];
break;
case "es":
$utente_rda = $rigay[testo_es];
break;
}
}
//testo operazione dettaglio rda
if ($rigay[posizione] == "operazione" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$operazione_rda = $rigay[testo_it];
break;
case "en":
$operazione_rda = $rigay[testo_en];
break;
case "fr":
$operazione_rda = $rigay[testo_fr];
break;
case "de":
$operazione_rda = $rigay[testo_de];
break;
case "es":
$operazione_rda = $rigay[testo_es];
break;
}
}
//testo operazione dettaglio rda
if ($rigay[posizione] == "note_rda" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$note_rda = $rigay[testo_it];
break;
case "en":
$note_rda = $rigay[testo_en];
break;
case "fr":
$note_rda = $rigay[testo_fr];
break;
case "de":
$note_rda = $rigay[testo_de];
break;
case "es":
$note_rda = $rigay[testo_es];
break;
}
}
//testo totale dettaglio rda
if ($rigay[posizione] == "totale_rda" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$testo_totale_rda = $rigay[testo_it];
break;
case "en":
$testo_totale_rda = $rigay[testo_en];
break;
case "fr":
$testo_totale_rda = $rigay[testo_fr];
break;
case "de":
$testo_totale_rda = $rigay[testo_de];
break;
case "es":
$testo_totale_rda = $rigay[testo_es];
break;
}
}
//testo seleziona tutto dettaglio rda
if ($rigay[posizione] == "seleziona_tutto" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$seleziona_tutto = $rigay[testo_it];
break;
case "en":
$seleziona_tutto = $rigay[testo_en];
break;
case "fr":
$seleziona_tutto = $rigay[testo_fr];
break;
case "de":
$seleziona_tutto = $rigay[testo_de];
break;
case "es":
$seleziona_tutto = $rigay[testo_es];
break;
}
}
//testo seleziona tutto dettaglio rda
if ($rigay[posizione] == "deseleziona_tutto" AND $rigay[pag] == "dettaglio_rda") {
switch($lingua) {
case "it":
$deseleziona_tutto = $rigay[testo_it];
break;
case "en":
$deseleziona_tutto = $rigay[testo_en];
break;
case "fr":
$deseleziona_tutto = $rigay[testo_fr];
break;
case "de":
$deseleziona_tutto = $rigay[testo_de];
break;
case "es":
$deseleziona_tutto = $rigay[testo_es];
break;
}
}
//testo image gallery
if ($rigay[posizione] == "galleria" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$gallery = $rigay[testo_it];
break;
case "en":
$gallery = $rigay[testo_en];
break;
case "fr":
$gallery = $rigay[testo_fr];
break;
case "de":
$gallery = $rigay[testo_de];
break;
case "es":
$gallery = $rigay[testo_es];
break;
}
}
//testo main image
if ($rigay[posizione] == "main_image" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$main_image = $rigay[testo_it];
break;
case "en":
$main_image = $rigay[testo_en];
break;
case "fr":
$main_image = $rigay[testo_fr];
break;
case "de":
$main_image = $rigay[testo_de];
break;
case "es":
$main_image = $rigay[testo_es];
break;
}
}
//testo crea pdf
if ($rigay[posizione] == "pdf" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$crea_pdf = $rigay[testo_it];
break;
case "en":
$crea_pdf = $rigay[testo_en];
break;
case "fr":
$crea_pdf = $rigay[testo_fr];
break;
case "de":
$crea_pdf = $rigay[testo_de];
break;
case "es":
$crea_pdf = $rigay[testo_es];
break;
}
}
//testo codifica scheda
if ($rigay[posizione] == "codifica" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$codifica = $rigay[testo_it];
break;
case "en":
$codifica = $rigay[testo_en];
break;
case "fr":
$codifica = $rigay[testo_fr];
break;
case "de":
$codifica = $rigay[testo_de];
break;
case "es":
$codifica = $rigay[testo_es];
break;
}
}

//testo info utente rda
if ($rigay[posizione] == "info_utente_rda" AND $rigay[pag] == "rda") {
switch($lingua) {
case "it":
$testo_info_utente_rda = $rigay[testo_it];
break;
case "en":
$testo_info_utente_rda = $rigay[testo_en];
break;
case "fr":
$testo_info_utente_rda = $rigay[testo_fr];
break;
case "de":
$testo_info_utente_rda = $rigay[testo_de];
break;
case "es":
$testo_info_utente_rda = $rigay[testo_es];
break;
}
}
//testo info utente rda
if ($rigay[posizione] == "info_resp_rda" AND $rigay[pag] == "rda") {
switch($lingua) {
case "it":
$testo_info_resp_rda = $rigay[testo_it];
break;
case "en":
$testo_info_resp_rda = $rigay[testo_en];
break;
case "fr":
$testo_info_resp_rda = $rigay[testo_fr];
break;
case "de":
$testo_info_resp_rda = $rigay[testo_de];
break;
case "es":
$testo_info_resp_rda = $rigay[testo_es];
break;
}
}
//testo nessun utente
if ($rigay[posizione] == "nessun_utente" AND $rigay[pag] == "menu") {
switch($lingua) {
case "it":
$nessun_utente = $rigay[testo_it];
break;
case "en":
$nessun_utente = $rigay[testo_en];
break;
case "fr":
$nessun_utente = $rigay[testo_fr];
break;
case "de":
$nessun_utente = $rigay[testo_de];
break;
case "es":
$nessun_utente = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "file_sap" AND $rigay[pag] == "alert") {
switch($lingua) {
case "it":
$file_sap = $rigay[testo_it];
break;
case "en":
$file_sap = $rigay[testo_en];
break;
case "fr":
$file_sap = $rigay[testo_fr];
break;
case "de":
$file_sap = $rigay[testo_de];
break;
case "es":
$file_sap = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "gen_mag" AND $rigay[pag] == "alert") {
switch($lingua) {
case "it":
$gen_mag = $rigay[testo_it];
break;
case "en":
$gen_mag = $rigay[testo_en];
break;
case "fr":
$gen_mag = $rigay[testo_fr];
break;
case "de":
$gen_mag = $rigay[testo_de];
break;
case "es":
$gen_mag = $rigay[testo_es];
break;
}
}
//testo info buyer rda
if ($rigay[posizione] == "info_buyer_rda" AND $rigay[pag] == "rda") {
switch($lingua) {
case "it":
$testo_info_buyer_rda = $rigay[testo_it];
break;
case "en":
$testo_info_buyer_rda = $rigay[testo_en];
break;
case "fr":
$testo_info_buyer_rda = $rigay[testo_fr];
break;
case "de":
$testo_info_buyer_rda = $rigay[testo_de];
break;
case "es":
$testo_info_buyer_rda = $rigay[testo_es];
break;
}
}

//testo chiusura automatica rda da sistema
if ($rigay[posizione] == "chiusura_sistema" AND $rigay[pag] == "rda") {
switch($lingua) {
case "it":
$chiusura_sistema_rda = $rigay[testo_it];
break;
case "en":
$chiusura_sistema_rda = $rigay[testo_en];
break;
case "fr":
$chiusura_sistema_rda = $rigay[testo_fr];
break;
case "de":
$chiusura_sistema_rda = $rigay[testo_de];
break;
case "es":
$chiusura_sistema_rda = $rigay[testo_es];
break;
}
}
//testo chiusura automatica rda da sistema
if ($rigay[posizione] == "rda_chiusa" AND $rigay[pag] == "rda") {
switch($lingua) {
case "it":
$rda_chiusa = $rigay[testo_it];
break;
case "en":
$rda_chiusa = $rigay[testo_en];
break;
case "fr":
$rda_chiusa = $rigay[testo_fr];
break;
case "de":
$rda_chiusa = $rigay[testo_de];
break;
case "es":
$rda_chiusa = $rigay[testo_es];
break;
}
}

//testo chiusura automatica rda da sistema
if ($rigay[posizione] == "rda_attesa_chiusura" AND $rigay[pag] == "rda") {
switch($lingua) {
case "it":
$rda_attesa_chiusura = $rigay[testo_it];
break;
case "en":
$rda_attesa_chiusura = $rigay[testo_en];
break;
case "fr":
$rda_attesa_chiusura = $rigay[testo_fr];
break;
case "de":
$rda_attesa_chiusura = $rigay[testo_de];
break;
case "es":
$rda_attesa_chiusura = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "sost_imm" AND $rigay[pag] == "alert") {
switch($lingua) {
case "it":
$alert_sost_imm = $rigay[testo_it];
break;
case "en":
$alert_sost_imm = $rigay[testo_en];
break;
case "fr":
$alert_sost_imm = $rigay[testo_fr];
break;
case "de":
$alert_sost_imm = $rigay[testo_de];
break;
case "es":
$alert_sost_imm = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "nr_rda" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_nr_rda = $rigay[testo_it];
break;
case "en":
$testo_nr_rda = $rigay[testo_en];
break;
case "fr":
$testo_nr_rda = $rigay[testo_fr];
break;
case "de":
$testo_nr_rda = $rigay[testo_de];
break;
case "es":
$testo_nr_rda = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "nr_ord" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_nr_ord = $rigay[testo_it];
break;
case "en":
$testo_nr_ord = $rigay[testo_en];
break;
case "fr":
$testo_nr_ord = $rigay[testo_fr];
break;
case "de":
$testo_nr_ord = $rigay[testo_de];
break;
case "es":
$testo_nr_ord = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "codice" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_codice = $rigay[testo_it];
break;
case "en":
$testo_codice = $rigay[testo_en];
break;
case "fr":
$testo_codice = $rigay[testo_fr];
break;
case "de":
$testo_codice = $rigay[testo_de];
break;
case "es":
$testo_codice = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "data_inizio" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_data_inizio = $rigay[testo_it];
break;
case "en":
$testo_data_inizio = $rigay[testo_en];
break;
case "fr":
$testo_data_inizio = $rigay[testo_fr];
break;
case "de":
$testo_data_inizio = $rigay[testo_de];
break;
case "es":
$testo_data_inizio = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "data_fine" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_data_fine = $rigay[testo_it];
break;
case "en":
$testo_data_fine = $rigay[testo_en];
break;
case "fr":
$testo_data_fine = $rigay[testo_fr];
break;
case "de":
$testo_data_fine = $rigay[testo_de];
break;
case "es":
$testo_data_fine = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "testo_gruppo_merci" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$testo_gruppo_merci = $rigay[testo_it];
break;
case "en":
$testo_gruppo_merci = $rigay[testo_en];
break;
case "fr":
$testo_gruppo_merci = $rigay[testo_fr];
break;
case "de":
$testo_gruppo_merci = $rigay[testo_de];
break;
case "es":
$testo_gruppo_merci = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "stato" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$stato = $rigay[testo_it];
break;
case "en":
$stato = $rigay[testo_en];
break;
case "fr":
$stato = $rigay[testo_fr];
break;
case "de":
$stato = $rigay[testo_de];
break;
case "es":
$stato = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "unita" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$unita = $rigay[testo_it];
break;
case "en":
$unita = $rigay[testo_en];
break;
case "fr":
$unita = $rigay[testo_fr];
break;
case "de":
$unita = $rigay[testo_de];
break;
case "es":
$unita = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "filtra" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$filtra = $rigay[testo_it];
break;
case "en":
$filtra = $rigay[testo_en];
break;
case "fr":
$filtra = $rigay[testo_fr];
break;
case "de":
$filtra = $rigay[testo_de];
break;
case "es":
$filtra = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "scegli_stato" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scegli_stato = $rigay[testo_it];
break;
case "en":
$scegli_stato = $rigay[testo_en];
break;
case "fr":
$scegli_stato = $rigay[testo_fr];
break;
case "de":
$scegli_stato = $rigay[testo_de];
break;
case "es":
$scegli_stato = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "scegli_categ" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scegli_categ = $rigay[testo_it];
break;
case "en":
$scegli_categ = $rigay[testo_en];
break;
case "fr":
$scegli_categ = $rigay[testo_fr];
break;
case "de":
$scegli_categ = $rigay[testo_de];
break;
case "es":
$scegli_categ = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "scegli_unita" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scegli_unita = $rigay[testo_it];
break;
case "en":
$scegli_unita = $rigay[testo_en];
break;
case "fr":
$scegli_unita = $rigay[testo_fr];
break;
case "de":
$scegli_unita = $rigay[testo_de];
break;
case "es":
$scegli_unita = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "scegli_shop" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scegli_shop = $rigay[testo_it];
break;
case "en":
$scegli_shop = $rigay[testo_en];
break;
case "fr":
$scegli_shop = $rigay[testo_fr];
break;
case "de":
$scegli_shop = $rigay[testo_de];
break;
case "es":
$scegli_shop = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "scegli_gruppo_merci" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$scegli_gruppo_merci = $rigay[testo_it];
break;
case "en":
$scegli_gruppo_merci = $rigay[testo_en];
break;
case "fr":
$scegli_gruppo_merci = $rigay[testo_fr];
break;
case "de":
$scegli_gruppo_merci = $rigay[testo_de];
break;
case "es":
$scegli_gruppo_merci = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "negozio" AND $rigay[pag] == "filtri") {
switch($lingua) {
case "it":
$shop = $rigay[testo_it];
break;
case "en":
$shop = $rigay[testo_en];
break;
case "fr":
$shop = $rigay[testo_fr];
break;
case "de":
$shop = $rigay[testo_de];
break;
case "es":
$shop = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "edit" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$edit = $rigay[testo_it];
break;
case "en":
$edit = $rigay[testo_en];
break;
case "fr":
$edit = $rigay[testo_fr];
break;
case "de":
$edit = $rigay[testo_de];
break;
case "es":
$edit = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "salva" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$salva = $rigay[testo_it];
break;
case "en":
$salva = $rigay[testo_en];
break;
case "fr":
$salva = $rigay[testo_fr];
break;
case "de":
$salva = $rigay[testo_de];
break;
case "es":
$salva = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "dim_predefinita_gallery" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$dim_predefinita_gallery = $rigay[testo_it];
break;
case "en":
$dim_predefinita_gallery = $rigay[testo_en];
break;
case "fr":
$dim_predefinita_gallery = $rigay[testo_fr];
break;
case "de":
$dim_predefinita_gallery = $rigay[testo_de];
break;
case "es":
$dim_predefinita_gallery = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "dim_predefinita_img_princ" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$dim_predefinita_img_princ = $rigay[testo_it];
break;
case "en":
$dim_predefinita_img_princ = $rigay[testo_en];
break;
case "fr":
$dim_predefinita_img_princ = $rigay[testo_fr];
break;
case "de":
$dim_predefinita_img_princ = $rigay[testo_de];
break;
case "es":
$dim_predefinita_img_princ = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "back" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$back = $rigay[testo_it];
break;
case "en":
$back = $rigay[testo_en];
break;
case "fr":
$back = $rigay[testo_fr];
break;
case "de":
$back = $rigay[testo_de];
break;
case "es":
$back = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "duplicate" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$duplicate = $rigay[testo_it];
break;
case "en":
$duplicate = $rigay[testo_en];
break;
case "fr":
$duplicate = $rigay[testo_fr];
break;
case "de":
$duplicate = $rigay[testo_de];
break;
case "es":
$duplicate = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "delete" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$delete = $rigay[testo_it];
break;
case "en":
$delete = $rigay[testo_en];
break;
case "fr":
$delete = $rigay[testo_fr];
break;
case "de":
$delete = $rigay[testo_de];
break;
case "es":
$delete = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "ricerca" AND $rigay[pag] == "testata_alta") {
switch($lingua) {
case "it":
$ricerca_alta = $rigay[testo_it];
break;
case "en":
$ricerca_alta = $rigay[testo_en];
break;
case "fr":
$ricerca_alta = $rigay[testo_fr];
break;
case "de":
$ricerca_alta = $rigay[testo_de];
break;
case "es":
$ricerca_alta = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "guida" AND $rigay[pag] == "testata_alta") {
switch($lingua) {
case "it":
$guida_alta = $rigay[testo_it];
break;
case "en":
$guida_alta = $rigay[testo_en];
break;
case "fr":
$guida_alta = $rigay[testo_fr];
break;
case "de":
$guida_alta = $rigay[testo_de];
break;
case "es":
$guida_alta = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "lingua" AND $rigay[pag] == "testata_alta") {
switch($lingua) {
case "it":
$lingua_alta = $rigay[testo_it];
break;
case "en":
$lingua_alta = $rigay[testo_en];
break;
case "fr":
$lingua_alta = $rigay[testo_fr];
break;
case "de":
$lingua_alta = $rigay[testo_de];
break;
case "es":
$lingua_alta = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "remove" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$remove = $rigay[testo_it];
break;
case "en":
$remove = $rigay[testo_en];
break;
case "fr":
$remove = $rigay[testo_fr];
break;
case "de":
$remove = $rigay[testo_de];
break;
case "es":
$remove = $rigay[testo_es];
break;
}
}

if ($rigay[posizione] == "dida_ipiccy" AND $rigay[pag] == "scheda") {
switch($lingua) {
case "it":
$dida_ipiccy = $rigay[testo_it];
break;
case "en":
$dida_ipiccy = $rigay[testo_en];
break;
case "fr":
$dida_ipiccy = $rigay[testo_fr];
break;
case "de":
$dida_ipiccy = $rigay[testo_de];
break;
case "es":
$dida_ipiccy = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "titolo" AND $rigay[pag] == "gestione_gallery") {
switch($lingua) {
case "it":
$titolo_gestione_gallery = $rigay[testo_it];
break;
case "en":
$titolo_gestione_gallery = $rigay[testo_en];
break;
case "fr":
$titolo_gestione_gallery = $rigay[testo_fr];
break;
case "de":
$titolo_gestione_gallery = $rigay[testo_de];
break;
case "es":
$titolo_gestione_gallery = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "titolo" AND $rigay[pag] == "gestione_immagine_princ") {
switch($lingua) {
case "it":
$titolo_gestione_img_princ = $rigay[testo_it];
break;
case "en":
$titolo_gestione_img_princ = $rigay[testo_en];
break;
case "fr":
$titolo_gestione_img_princ = $rigay[testo_fr];
break;
case "de":
$titolo_gestione_img_princ = $rigay[testo_de];
break;
case "es":
$titolo_gestione_img_princ = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "salva" AND $rigay[pag] == "gestione_gallery") {
switch($lingua) {
case "it":
$salva_gestione_gallery = $rigay[testo_it];
break;
case "en":
$salva_gestione_gallery = $rigay[testo_en];
break;
case "fr":
$salva_gestione_gallery = $rigay[testo_fr];
break;
case "de":
$salva_gestione_gallery = $rigay[testo_de];
break;
case "es":
$salva_gestione_gallery = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "guida_utente" AND $rigay[pag] == "guida") {
switch($lingua) {
case "it":
$guida_utente = $rigay[testo_it];
break;
case "en":
$guida_utente = $rigay[testo_en];
break;
case "fr":
$guida_utente = $rigay[testo_fr];
break;
case "de":
$guida_utente = $rigay[testo_de];
break;
case "es":
$guida_utente = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "guida_responsabile" AND $rigay[pag] == "guida") {
switch($lingua) {
case "it":
$guida_responsabile = $rigay[testo_it];
break;
case "en":
$guida_responsabile = $rigay[testo_en];
break;
case "fr":
$guida_responsabile = $rigay[testo_fr];
break;
case "de":
$guida_responsabile = $rigay[testo_de];
break;
case "es":
$guida_responsabile = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "guida_photoediting" AND $rigay[pag] == "guida") {
switch($lingua) {
case "it":
$guida_photoediting = $rigay[testo_it];
break;
case "en":
$guida_photoediting = $rigay[testo_en];
break;
case "fr":
$guida_photoediting = $rigay[testo_fr];
break;
case "de":
$guida_photoediting = $rigay[testo_de];
break;
case "es":
$guida_photoediting = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "esporta" AND $rigay[pag] == "report") {
switch($lingua) {
case "it":
$esporta = $rigay[testo_it];
break;
case "en":
$esporta = $rigay[testo_en];
break;
case "fr":
$esporta = $rigay[testo_fr];
break;
case "de":
$esporta = $rigay[testo_de];
break;
case "es":
$esporta = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "wbs_mancante" AND $rigay[pag] == "alert") {
switch($lingua) {
case "it":
$avvert_wbs_vuoto = $rigay[testo_it];
break;
case "en":
$avvert_wbs_vuoto = $rigay[testo_en];
break;
case "fr":
$avvert_wbs_vuoto = $rigay[testo_fr];
break;
case "de":
$avvert_wbs_vuoto = $rigay[testo_de];
break;
case "es":
$avvert_wbs_vuoto = $rigay[testo_es];
break;
}
}
if ($rigay[posizione] == "carrello_div" AND $rigay[pag] == "alert") {
switch($lingua) {
case "it":
$carrello_diverso = $rigay[testo_it];
break;
case "en":
$carrello_diverso = $rigay[testo_en];
break;
case "fr":
$carrello_diverso = $rigay[testo_fr];
break;
case "de":
$carrello_diverso = $rigay[testo_de];
break;
case "es":
$carrello_diverso = $rigay[testo_es];
break;
}
}

}
?>