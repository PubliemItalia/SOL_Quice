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
	$azienda_prodotto = $rigan[azienda_prodotto];
	$azienda_utente = $rigan[azienda_utente];
	$dest_contab = $rigan[dest_contab];
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

mysql_query("INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, quant_modifica, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, pack_list, stato_ordine, flag_buyer, flag_chiusura, flag_packing_list, output_mode, file_sap, n_ord_sap, n_fatt_sap, evaso_magazzino, vecchio_codice, report_select, gruppo_merci, wbs, ordine_stampa, id_buyer, id_magazz, nazione, azienda_prodotto, azienda_utente, dest_contab) SELECT id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, quant_modifica, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, pack_list, stato_ordine, flag_buyer, flag_chiusura, flag_packing_list, output_mode, file_sap, n_ord_sap, n_fatt_sap, evaso_magazzino, vecchio_codice, report_select, gruppo_merci, wbs, ordine_stampa, id_buyer, id_magazz, nazione, azienda_prodotto, azienda_utente, dest_contab FROM qui_righe_rda WHERE id = '".$id_riga."'") or die("Impossibile eseguire l'inserimento 1" . mysql_error());
$nuovo_id = mysql_insert_id();


$querya = "UPDATE qui_righe_rda SET quant = '$quant_evasa', totale = '$totale_evaso' WHERE id = '$id_riga'";
	if (mysql_query($querya)) {
	} else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}
$queryb = "UPDATE qui_righe_rda SET quant = '$quant_residua', flag_buyer = '2', totale = '$totale_da_evadere' WHERE id = '$nuovo_id'";
	if (mysql_query($queryb)) {
	} else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'processo'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
  }
$codice_php_testatina_righe = $blocco_testatina_righe;

$sqln = "SELECT * FROM qui_righe_rda WHERE id = '$nuovo_id'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigan = mysql_fetch_array($risultn)) {
$codice_php_singola_riga = $blocco_singola_riga;
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}

// descrizione riga
$sost_descrizione = $rigan[descrizione];
$sost_unita = $rigan[nome_unita];
switch ($rigan[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $sost_logo .= '<img src="immagini/bottone-vivisol.png" border="0" style="margin-bottom:5px;">';
	break;
	case "SOL":
	  $sost_logo .= '<img src="immagini/bottone-sol.png" border="0" style="margin-bottom:5px;">';
	break;
}

    $sost_quant = intval($rigan[quant]);
$bottone_edit = '';
  	$bottone_lente = "";
  $sost_totale_riga .= number_format($rigan[totale],2,",",".");




	$codice_php_singola_riga = str_replace('id="col02d" style="width: 55px;','id="col02d" style="width: 40px; text-align: right; margin-right: 10px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col03d" class="descr4_riga" style="width: 40px;','id="col03d" class="descr4_riga" style="width: 290px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col04d" class="cod1_riga" style="width: 200px;','id="col04d" class="cod1_riga" style="width: 70px !important;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_id_riga*",$sost_id_rda,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_scritta*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*campo_ordsap*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_aggiornamento*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*aggiornamento_stato*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",'',$codice_php_singola_riga);
  $tab_output .= $codice_php_singola_riga;

//fine contenitore riga tabella
//$tab_output .= "</div>";

}
//fine blocco sing rda




//output finale

//echo "pippo";
echo $tab_output;



 ?>
