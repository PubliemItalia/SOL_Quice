<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_riga = $_GET['id_riga'];
$quant_evasa = $_GET['quant_evasa'];

$sqln = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigan = mysql_fetch_array($risultn)) {
	$originale_quant = $rigan[quant];
	$prezzo_prodotto = $rigan[prezzo];
	$codice_art = $rigan[codice_art];
	$negozio_riga = $rigan[negozio];
}
if ($negozio_riga == "labels") {
  $sqlr = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$codice_art'";
  $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
  while ($rigar = mysql_fetch_array($risultr)) {
	if ($rigar[ric_mag] == "mag") {
		$prezzo_prodotto = $rigar[prezzo];
	}
  }
}
  $quant_residua = $originale_quant - $quant_evasa;
  $totale_evaso = $quant_evasa * $prezzo_prodotto;
  $totale_da_evadere = $quant_residua * $prezzo_prodotto;

mysql_query("INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, quant_modifica, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, pack_list, stato_ordine, flag_buyer, flag_chiusura, flag_packing_list, output_mode, file_sap, n_ord_sap, n_fatt_sap, evaso_magazzino, vecchio_codice, report_select, gruppo_merci, wbs, ordine_stampa, id_buyer, id_magazz, nazione) SELECT id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, quant_modifica, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, pack_list, stato_ordine, flag_buyer, flag_chiusura, flag_packing_list, output_mode, file_sap, n_ord_sap, n_fatt_sap, evaso_magazzino, vecchio_codice, report_select, gruppo_merci, wbs, ordine_stampa, id_buyer, id_magazz, nazione FROM qui_righe_rda WHERE id = '".$id_riga."'") or die("Impossibile eseguire l'inserimento 1" . mysql_error());
$nuovo_id = mysql_insert_id();


$querya = "UPDATE qui_righe_rda SET quant = '$quant_evasa', totale = '$totale_evaso' WHERE id = '$id_riga'";
	if (mysql_query($querya)) {
	} else {
	echo "Errore durante l'inserimento: ".mysql_error();
	}
$queryb = "UPDATE qui_righe_rda SET quant = '$quant_residua', flag_buyer = '0', totale = '$totale_da_evadere' WHERE id = '$nuovo_id'";
	if (mysql_query($queryb)) {
	} else {
	echo "Errore durante l'inserimento: ".mysql_error();
	}








$sqln = "SELECT * FROM qui_righe_rda WHERE id = '$nuovo_id'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigan = mysql_fetch_array($risultn)) {

$tab_output .= "<div class=columns_righe1>";
//div num rda riga
$tab_output .= "<div class=cod1_riga style=\"width:50px;\">";
$tab_output .= $rigan[id_rda];
//fine div num rda riga
$tab_output .= "</div>";
//div data riga
$tab_output .= "<div class=cod1_riga>";
$tab_output .= date("d.m.Y",$rigan[data_inserimento]);
//fine div data riga
$tab_output .= "</div>";
//div codice riga
$tab_output .= "<div id=confez5_riga>";
if (substr($rigan[codice_art],0,1) != "*") {
  $tab_output .= $rigan[codice_art];
} else {
  $tab_output .= substr($rigan[codice_art],1);
}
//fine div codice riga
$tab_output .= "</div>";

//div descrizione riga
$tab_output .= "<div class=descr4_riga>";
$tab_output .= $rigan[descrizione];
//fine div descrizione riga
$tab_output .= "</div>";


//div nome unità riga
$tab_output .= "<div class=cod1_riga>";
$tab_output .= $rigan[nome_unita];
//fine div nome unità riga
$tab_output .= "</div>";
//div quant riga
$tab_output .= "<div class=price6_riga_quant>";
$tab_output .= intval($rigan[quant]);
$tab_output .= "</div>";



//div pulsante per evasione parziale riga
$tab_output .= "<div class=lente_prodotto>";
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";

//div pulsante per visualizzare scheda
$tab_output .= "<div class=lente_prodotto>";
//fine div pulsante per visualizzare scheda
$tab_output .= "</div>";
//div totale riga
$tab_output .= "<div class=price6_riga>";
$tab_output .= number_format($rigan[totale],2,",",".");
//fine div totale riga
$tab_output .= "</div>";

//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "":
$button_style = "vuoto9_riga";
break;
case "mag":
$button_style = "style_mag";
break;
case "sap":
$button_style = "style_sap";
break;
case "ord":
$button_style = "style_ord";
break;
}
$tab_output .= "<div class=".$button_style.">";
//fine div output mode riga
$tab_output .= "</div>";

//div evaso (vuoto)
$tab_output .= "<div class=vuoto9_riga>";
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
//fine div checkbox
$tab_output .= "</div>";

//fine contenitore riga tabella
$tab_output .= "</div>";

//fine foreach
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}
//fine blocco sing rda




//output finale

//echo "pippo";
echo $tab_output;



 ?>
