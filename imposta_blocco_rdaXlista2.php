<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$dest = $_GET['dest'];
$layout = $_GET['layout'];
$sm = $_GET['sm'];
$unita = $_GET['unita'];
$categoria_ricerca = $_GET['categoria_ricerca'];
$codice_art = $_GET['codice_art'];
$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);

//procedura per il buyer
  if ($check == "0") {
	$id_buyer = "";
  } else {
	$id_buyer = $_GET['id_utente'];
  }
//procedura per il magazziniere
if ($check == "2") {
$id_magazz = "";
}
if ($check == "3") {
$id_magazz = $_GET['id_utente'];
}
switch ($sm) {
	case 1:
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 2:
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$id_rda' AND output_mode = '' AND stato_ordine = '2'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 4:
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id = '$id_riga'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 5:
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id_rda = '$id_rda' AND output_mode = 'mag' AND flag_chiusura = '0'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
}
	$sqly = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
	$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione09" . mysql_error());
	while ($rigay = mysql_fetch_array($risulty)) {
  	$indirizzo_spedizione = $rigay[indirizzo_spedizione];
	if ($indirizzo_spedizione == "") {
	  $sqld = "SELECT * FROM qui_utenti WHERE user_id = '$rigay[id_utente]'";
	  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigad = mysql_fetch_array($risultd)) {
		if ($rigad[companyName] != "") {
		$indirizzo_spedizione .= "<strong>".$rigad[companyName]."</strong><br>";
		}
		$indirizzo_spedizione .= "<strong>".$rigad[nomeunita]."</strong><br>";
		$indirizzo_spedizione .= $rigad[indirizzo]."<br>";
		$indirizzo_spedizione .= $rigad[cap]." ";
		$indirizzo_spedizione .= $rigad[localita]."<br>";
		$indirizzo_spedizione .= $rigad[nazione];
	  }
	}
	  $stato_orig_rda = stripslashes($rigay[stato]);
	  $tipo_negozio = stripslashes($rigay[negozio]);
	  $wbs_visualizzato = stripslashes($rigay[wbs]);
	  $note_utente = stripslashes($rigay[note_utente]);
	  $note_resp = stripslashes($rigay[note_resp]);
	  $note_magazziniere = stripslashes($rigay[note_magazziniere]);
	  $note_buyer = str_replace("<br>","\n",stripslashes($rigay[note_buyer]));
	  $riga_con_id = 'riga_'.$id_rda;
	  $colore_con_id = 'colore_orig_riga_'.$id_rda;
	  $open_status_con_id = 'open_status_'.$id_rda;
	  $pulsante_con_id = 'pulsante_'.$id_rda;
	  $sost_id_riga = $id_rda;
	  $data_inserimento = date("d.m.Y",$rigay[data_inserimento]);
	  $sost_nome_unita = $rigay[nome_unita];
	  $sqlx = "SELECT * FROM qui_utenti WHERE user_id = '$rigay[id_utente]'";
	  $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigax = mysql_fetch_array($risultx)) {
		$sost_nome_utente = stripslashes($rigax[nome]);
	  }
	  $sqlw = "SELECT * FROM qui_utenti WHERE user_id = '$rigay[id_resp]'";
	  $risultw = mysql_query($sqlw) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaw = mysql_fetch_array($risultw)) {
		$sost_nome_resp = stripslashes($rigaw[nome]);
	  }
	}

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
if (isset($_GET['unita'])) {
$unitaDaModulo = $_GET['unita'];
} 
if ($unitaDaModulo != "") {
$a = "id_unita = '$unitaDaModulo'";
$clausole++;
}
if (isset($_GET['categoria_ricerca'])) {
$categoria_ricercaDaModulo = $_GET['categoria_ricerca'];
} 
if ($categoria_ricercaDaModulo != "") {
$e = "categoria = '$categoria_ricercaDaModulo'";
$clausole++;
}
if ($_GET['codice_art'] != "") {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$f = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'rda'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testata_generale_lista_rda') {
		$blocco_testata_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga_evasa') {
		$blocco_singola_riga_evasa = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'note_sing_rda') {
		$blocco_note_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'indir_rda') {
		$blocco_indir_sing_rda = $rigav[codice_php];
	  }
  }
    switch ($lingua) {
	  case "":
	  case "it":
		$attesa_approvazione = "In attesa di approvazione";
		$attesa_gestione = "In attesa di gestione";
		$gestione = "In gestione";
		$spedito_pl = "Spedito con Packing List n. ";
		$spedito_ord = "Inoltrato al fornitore - ord. n. ";
		$spedito_sap = "Inoltrato ordine SAP n. ";
		$dicitura_aggiornata = "Aggiornato al ";
		$dicitura_codice = "Codice";
		$dicitura_nazione = "Nazione";
		$dicitura_descrizione = "Descrizione";
		$dicitura_confezione = "Confezione";
		$dicitura_prezzo = "Prezzo &euro;";
		$dicitura_quantita = "Quantit&agrave;";
		$dicitura_totale = "Totale &euro;";
		$dicitura_stato = "Stato singolo prodotto";
	  break;
	  case "en":
		$attesa_approvazione = "Awaiting approval";
		$attesa_gestione = "Awaiting process";
		$gestione = "Processing";
		$spedito_pl = "Delivered with Packing List n. ";
		$spedito_ord = "Placed Order n. ";
		$spedito_sap = "Placed SAP Order n. ";
		$dicitura_aggiornata = "Updated ";
		$dicitura_codice = "Code";
		$dicitura_nazione = "Country";
		$dicitura_descrizione = "Description";
		$dicitura_confezione = "Packing";
		$dicitura_prezzo = "Price &euro;";
		$dicitura_quantita = "Quantity";
		$dicitura_totale = "Total &euro;";
		$dicitura_stato = "Single product condition";
	  break;
  }
	  $sqlz = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = ''";
	  $resultz = mysql_query($sqlz);
	  $righe_totali = mysql_num_rows($resultz);
	  $queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = ''";
	  $resultb = mysql_query($queryb);
	  list($somma) = mysql_fetch_array($resultb);
	  $sost_totale_rda = number_format($somma,2,",",".");
	  $stato_rda = 2;
	  $classe_riga = "riga row bianco";
	  $colore_fondo_riga = '#80b6e2';
	  switch ($stato_orig_rda) {
		  case 1:
			$sost_imm_status = '<img src="immagini/stato1.png" title="'.$status2.'">';
		  break;
		  case 2:
			$sost_imm_status = '<img src="immagini/stato2.png" title="'.$status2.'">';
		  break;
	  }

//INIZIO OUTPUT BLOCCO SING RDA
//echo "<!-- TESTATA colonna codice-->";
		$codice_php_singola_rda = $blocco_singola_rda;
	$codice_php_singola_rda = str_replace("*classe_riga*",$classe_riga,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace('*riga_con_id*"',$riga_con_id.'" style="background-color:'.$colore_fondo_riga.';"',$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*colore_con_id*",$colore_con_id,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*colore_fondo_riga*","#fff",$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*data_inserimento*",$data_inserimento,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_nome_unita*",$sost_nome_unita,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_nome_utente*",$sost_nome_utente,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_nome_resp*",$sost_nome_resp,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_totale_rda*",$sost_totale_rda,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace('*open_status_con_id*" value="0"',$open_status_con_id.'" value="1"',$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_imm_status*",$sost_imm_status,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*pulsante_con_id*",$pulsante_con_id,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*visualizza_rda*",$visualizza_rda,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("immagini/a-piu","immagini/a-meno",$codice_php_singola_rda);
/**/
  $tab_output .= $codice_php_singola_rda;
    $tab_output .= '<div id="dettaglio_rda_'.$id_rda.'" class="riga dettaglio_rda" style="display:block;">';

  $codice_php_testatina_righe = $blocco_testatina_righe;

switch ($_SESSION[ruolo_report]) {
case "":
  $bottone_select_all = '';
break;
case "buyer":
//$bottone_select_all = '<img src="immagini/bottone-check-all.png" width="12" height="12" title="Seleziona tutto" onClick="axc(0,'.$checkXBottone_all.','.$id_rda.',2)" style="cursor: pointer;">';
  $bottone_select_all = '';
break;
case "magazziniere":
//$bottone_select_all = '<img src="immagini/bottone-check-all.png" width="12" height="12" title="Seleziona tutto" onClick="axc(0,'.$checkXBottone_all.','.$id_rda.',5)" style="cursor: pointer;">';
  $bottone_select_all = '';
break;
}
  $codice_php_testatina_righe = str_replace("*codice_riga*",$dicitura_codice,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*nazione_riga*",$dicitura_nazione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*descrizione_riga*",$dicitura_descrizione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*confezione_riga*",$dicitura_confezione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*prezzo_riga*",$dicitura_prezzo,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*quant_riga*",$dicitura_quantita,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*totale_riga*",$dicitura_totale,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*stato_prodotto*",$dicitura_stato,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*bottone_select_all*",$bottone_select_all,$codice_php_testatina_righe);
  //DIV CON RIGHE RDA

//inizio div testatina nuova
  $tab_output .= $codice_php_testatina_righe;
//fine div testatina nuova

//inizio div con righe (vere e proprie) rda
  switch ($_SESSION[ruolo_report]) {
	case "buyer":
	case "":
	  if ($statusDaModulo == "sap") {
		$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
	  } else {
		$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine != '4'";
	  }
	break;
	case "magazziniere":
	  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'mag' AND evaso_magazzino = '0'";
	  if ($clausole > 0) {
	  if ($a != "") {
	  $sqln .= " AND ".$a;
	  }
	  if ($b != "") {
	  $sqln .= " AND ".$b;
	  }
	  if ($c != "") {
	  $sqln .= " AND ".$c;
	  }
	  if ($d != "") {
	  $sqln .= " AND ".$d;
	  }
	  if ($e != "") {
	  $sqln .= " AND ".$e;
	  }
	  if ($f != "") {
	  $sqln .= " AND ".$f;
	  }
	  }
	break;
  }
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
  $codice_php_singola_riga = $blocco_singola_riga;
	switch ($_SESSION[ruolo_report]) {
	  case "":
		switch ($lingua) {
		  case "":
		  case "it":
			$attesa_approvazione = "In attesa di approvazione";
			$attesa_gestione = "In attesa di gestione";
			$gestione = "In gestione";
			$spedito_pl = "Spedito con Packing List n. ";
			$spedito_ord = "Inoltrato al fornitore - ord. n. ";
			$spedito_sap = "Inoltrato ordine SAP n. ";
			$dicitura_aggiornata = "Aggiornato al ";
		  break;
		  case "en":
			$attesa_approvazione = "Awaiting approval";
			$attesa_gestione = "Awaiting process";
			$gestione = "Processing";
			$spedito_pl = "Delivered with Packing List n. ";
			$spedito_ord = "Placed Order n. ";
			$spedito_sap = "Placed SAP Order n. ";
			$dicitura_aggiornata = "Updated ";
		  break;
	  }
	  
		$tot = $tot + 1;
		$data_leggibile = date("d.m.Y",$rigan[data]);
		$id_prod_riga = $rigan[id_prodotto];
		$codice_art_riga = $rigan[codice_art];
		$descrizione_prodotto = $rigan[descrizione];
		$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
		$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
		while ($rigam = mysql_fetch_array($risultm)) {
		  if ($rigam[categoria1_it] == "Bombole") {
			$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		  } else {
			$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		  }
		}
		$bottone_edit = '';
		  if ($rigan[flag_chiusura] == 1) {
			  //se riga RdA completata
			$colore_scritta = '#009ee0';
			switch ($rigan[output_mode]) {
				case "mag":
				case "lab":
				  $queryf = "SELECT * FROM qui_packing_list WHERE id = '$rigan[pack_list]'";
				  $resultf = mysql_query($queryf);
				  while ($rowf = mysql_fetch_array($resultf)) {
					if ($rowf[data_spedizione] > 0) {
						$data_aggiornata = date("d.m.Y",$rowf[data_spedizione]);
					} else {
						$data_aggiornata = date("d.m.Y",$rowf[data_output]);
	
					}
				  }
				  $dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'&lang='.$lingua.'" target="_blank"><span style="color:#23ad36;">'.$spedito_pl.$rigan[pack_list].'</span></a>';
				break;
				case "sap":
				  if ($rown[data_chiusura] > 0) {
					  $data_aggiornata = date("d.m.Y",$rigan[data_chiusura]);
				  }
				  $dettaglio_stato = $spedito_sap.$rigan[ord_fornitore].' '.$rigan[fornitore_tx];
				break;
				case "ord":
				  $sqlg = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda ='".$rigan[id]."'";
				  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
				  while ($rigag = mysql_fetch_array($risultg)) {
					$ordine_for = $rigag[id_ordine_for];
				  }
				  $dettaglio_stato = '<a href="ordine_fornitore.php?id_ord='.$ordine_for."&id_rda=".$rigan[id_rda].'&lang='.$lingua.'" target="_blank"><span style="color:#23ad36;">'.$spedito_ord.$ordine_for.'</span></a>';
				  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
				break;
			}
			$ordine_for = '';
			$scritta_stato = 'Consegnato';
		  } else {
			  //se riga RdA non completata
			$scritta_stato = 'In gestione';
			switch ($rigan[output_mode]) {
			  case "":
				switch ($rigan[stato_ordine]) {
				  case 1:
					$colore_scritta = '#939393';
					$dettaglio_stato = $attesa_approvazione;
					$data_aggiornata = date("d.m.Y",$rigan[data_inserimento]);
				  break;
				  case 2:
					$colore_scritta = '#feba0a';
					$dettaglio_stato = $attesa_gestione;
					$data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
				  break;
				}
			  break;
			  case "mag":
			  case "lab":
			  case "sap":
			  case "ord":
				if ($rigan[data_output] > 0) {
				  $data_aggiornata = date("d.m.Y",$rigan[data_output]);
				} else {
				  $data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
				}
				switch ($rigan[stato_ordine]) {
				  case 3:
					$colore_scritta = '#009036';
					$dettaglio_stato = $gestione;
				  break;
				  case 4:
					$colore_scritta = '#009ee0';
					$dettaglio_stato = $gestione;
				  break;
				}
			  break;
			}
		  }
			//fine switch ($rigan[output_mode])
	  break;
	  case "buyer":
	  if ($rigan[flag_chiusura] == 1) {
		$colore_scritta = '#23ad36';
		switch ($rigan[output_mode]) {
			case "mag":
			case "lab":
			  $queryf = "SELECT * FROM qui_packing_list WHERE id = '$rigan[pack_list]'";
			  $resultf = mysql_query($queryf);
			  while ($rowf = mysql_fetch_array($resultf)) {
				if ($rowf[data_spedizione] > 0) {
					$data_aggiornata = date("d.m.Y",$rowf[data_spedizione]);
				}
			  }
			  $dettaglio_stato = "Spedizione avvenuta con Packing List n. ".$rigan[pack_list];
			break;
			case "sap":
			  if ($rigan[data_chiusura] > 0) {
				  $data_aggiornata = date("d.m.Y",$rigan[data_chiusura]);
			  }
			  $dettaglio_stato = "ord. ".$rigan[ord_fornitore].' '.$rigan[fornitore_tx];
			break;
			case "ord":
			  $dettaglio_stato = "ord. ".$rigan[ord_fornitore].' '.$rigan[fornitore_tx];
				$data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
			break;
		}
		$scritta_stato = 'Consegnato';
	  } else {
		$colore_scritta = '#000';
		$scritta_stato = 'In gestione';
		switch ($rigan[stato_ordine]) {
			case 1:
			  $dettaglio_stato = 'In attesa di approvazione';
			  $data_aggiornata = date("d.m.Y",$rigan[data_inserimento]);
			break;
			case 2:
			  $dettaglio_stato = 'In attesa di gestione';
			  $data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
			break;
			case 3:
			  switch ($rigan[output_mode]) {
				case "":
				  $dettaglio_stato = 'In attesa di gestione';
				break;
				case "mag":
				  $colore_scritta = '#e27305';
				  $dettaglio_stato = 'Articolo inoltrato al Magazzino';
				break;
				case "lab":
				  $colore_scritta = '#e27305';
				  $dettaglio_stato = 'Articolo inoltrato al Mag Label';
				break;
				case "sap":
				  $dettaglio_stato = 'Articolo inoltrato al fornitore Sap';
				break;
				case "ord":
				  $dettaglio_stato = 'Articolo inoltrato al fornitore';
				break;
			  }
			  if ($rigan[data_output] > 0) {
				$data_aggiornata = date("d.m.Y",$rigan[data_output]);
			  } else {
				$data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
			  }
			break;
			case 4:
			  $dettaglio_stato = 'Articolo inoltrato al reparto di competenza';
			  if ($rigan[data_output] > 0) {
				$data_aggiornata = date("d.m.Y",$rigan[data_output]);
			  } else {
				$data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
			  }
			break;
		}
	  }
		  break;
		  case "magazziniere":
			  $dettaglio_stato = 'Articolo inoltrato al Magazzino';
			  $data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
			  $colore_scritta = '#e27305';
			  $scritta_stato = 'In gestione';
		  break;
		}
// codice riga
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art .= '<a href="riepilogo_bombola.php?cod='.$rigan[codice_art].'" target="_blank">';
}
$sost_codice_art .= '<span style="color:black;">';
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}
$sost_codice_art .= '</span>';
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art .= "</a>";
}

// descrizione riga
$sost_descrizione = $rigan[descrizione];
if ($rigan[urgente] == 1) {
	$sost_descrizione.= '<span style="color:red; font-weight: bold;"> - Urgente</span>';
}

// NAZIONE riga
$sost_nazione = stripslashes($rigan[nazione]);
// quant riga
$sost_quant = intval($rigan[quant]);
// quant prezzo
  $sost_prezzo = number_format($rigan[prezzo],2,",",".");
// quant confezione
	  $sost_confezione = stripslashes($rigan[confezione]);
// pulsante per evasione parziale riga

  switch ($_SESSION[ruolo_report]) {
	case "buyer":
  //if ($rigan[negozio] == "labels") {
	  $bottone_edit = '';
  //} else {
	//if ($rigan[output_mode] == "") {
		 // $bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$rigan[id_rda].",3)}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	//} else {
		//$bottone_edit = '';
	//}
  //}
	break;
	case "magazziniere":
	  $bottone_edit = '';
	  //$bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_magazz.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$rigan[id_rda].",6)}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	break;
  }
// pulsante per visualizzare scheda
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	$giacenza = $rigam[giacenza];
	if ($rigam[categoria1_it] == "Bombole") {
  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigam[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
  $sost_totale_riga = number_format($rigan[totale],2,",",".");
  $totale_rda = $totale_rda + $rigan[totale];
		if ($rigan[output_mode] == "") {
		  switch ($_SESSION[ruolo_report]) {
			case "":
			case "buyer":
			if ($rigan[stato_ordine] == 1) {
			$casella_check = "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$rigan[id]."&id_rda=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:190,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_elimina.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
			} else {
			$casella_check = '';
			}
			break;
/*			
			case "buyer":
			  switch ($rigan[flag_buyer]) {
				case "0":
					//echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." ";
				  $casella_check = '<img src="immagini/bottone-checkOff.png" width="12" height="12" title="Seleziona" onClick="axc('.$rigan[id].',1,'.$id_rda.',1)" style="cursor: pointer;">';
				break;
				case "1":
				  $casella_check = '<img src="immagini/bottone-checkOn.png" width="12" height="12" title="Seleziona" onClick="axc('.$rigan[id].',0,'.$id_rda.',1)" style="cursor: pointer;">';
				  //echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id].">";
				  $contatore_righe_flag = $contatore_righe_flag + 1;
				break;
			  }
			break;
*/			
		  }
		  //}
		} else {
		  switch ($_SESSION[ruolo_report]) {
			case "":
				$casella_check = '';
			break;
		  }
		}
	//$tab_output .= 'neg: '.$rigan[negozio].'<br>';
	switch ($rigan[azienda_prodotto]) {
		case "":
			$sost_logo .= '<img src="immagini/bottone-sol.png" border=0>';
		break;
		case "VIVISOL":
			$sost_logo .= '<img src="immagini/bottone-vivisol.png" border=0>';
		break;
		case "SOL":
			$sost_logo .= '<img src="immagini/bottone-sol.png" border=0>';
		break;
	}
  $data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_nazione*",$sost_nazione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_confezione*",$sost_confezione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_prezzo*",$sost_prezzo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*data_aggiornata*",$data_aggiornata,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
	$sost_logo = '';
	
	$tab_output .= $codice_php_singola_riga;
	  $x = $x+1;
	  $sost_codice_art = "";
	  $giacenza = "";
	  $descrizione_prodotto = "";
	  $descr_ita = "";
	  $rda_exist = "";

  if ($sf == 1) {
  $sf = 0;
  } else {
  $sf = 1;
  }
  //fine foreach
}
$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";
$totale_rda_completa = "";
$somma = "";


//blocco righe eventualmente già evase
  switch ($_SESSION[ruolo_report]) {
	case "buyer":
	case "":
		$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND flag_chiusura = '1'";
	break;
	case "magazziniere":
	  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'mag' AND evaso_magazzino = '1'";
	  if ($clausole > 0) {
	  if ($a != "") {
	  $sqln .= " AND ".$a;
	  }
	  if ($b != "") {
	  $sqln .= " AND ".$b;
	  }
	  if ($c != "") {
	  $sqln .= " AND ".$c;
	  }
	  if ($d != "") {
	  $sqln .= " AND ".$d;
	  }
	  if ($e != "") {
	  $sqln .= " AND ".$e;
	  }
	  if ($f != "") {
	  $sqln .= " AND ".$f;
	  }
	  }
	break;
  }
	//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
	//echo "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
	$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
	while ($rigan = mysql_fetch_array($risultn)) {
	$codice_php_blocco_singola_riga_evasa = $blocco_singola_riga_evasa;
			$colore_scritta = '#23ad36';
			  switch ($rigan[output_mode]) {
				  case "lab":
					if ($rigan[flag_chiusura] == 1) {
					$queryf = "SELECT * FROM qui_packing_list WHERE id = '$rigan[pack_list]'";
					$resultf = mysql_query($queryf);
					while ($rowf = mysql_fetch_array($resultf)) {
					  if ($rowf[data_spedizione] > 0) {
						  $data_aggiornata = date("d.m.Y",$rowf[data_spedizione]);
					  }
					}
					$dettaglio_stato = "Spedizione in preparazione";
					} else {
					$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'&lang='.$lingua.'" target="_blank"><span style="color:#23ad36;"> Spedito con Packing List n. '.$rigan[pack_list].'</span></a>';
					}
				  break;
				  case "mag":
					$queryf = "SELECT * FROM qui_packing_list WHERE id = '$rigan[pack_list]'";
					$resultf = mysql_query($queryf);
					while ($rowf = mysql_fetch_array($resultf)) {
					  if ($rowf[data_spedizione] > 0) {
						  $data_aggiornata = date("d.m.Y",$rowf[data_spedizione]);
					  }
					}
					$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'&lang='.$lingua.'" target="_blank"><span style="color:#23ad36;"> Spedito con Packing List n. '.$rigan[pack_list].'</span></a>';
				  break;
				  case "sap":
					if ($rigan[data_chiusura] > 0) {
						$data_aggiornata = date("d.m.Y",$rigan[data_chiusura]);
					}
					$dettaglio_stato = "ord. ".$rigan[ord_fornitore].' '.$rigan[fornitore_tx];
				  break;
				  case "ord":
					$dettaglio_stato = "ord. ".$rigan[ord_fornitore].' '.$rigan[fornitore_tx];
					  $data_aggiornata = date("d.m.Y",$rigan[data_ultima_modifica]);
				  break;
			  }
			  $scritta_stato = 'Consegnato';
	// codice riga
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art .= '<a href="riepilogo_bombola.php?cod='.$rigan[codice_art].'" target="_blank">';
}
$sost_codice_art .= '<span style="color:black;">';
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}
$sost_codice_art .= '</span>';
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art .= "</a>";
}

$sost_id_riga = $rigan[id];
// descrizione riga
$sost_descrizione = $rigan[descrizione];

// NAZIONE riga
$sost_nazione = stripslashes($rigan[nazione]);
// quant riga
$sost_quant = intval($rigan[quant]);
// quant prezzo
  $sost_prezzo = number_format($rigan[prezzo],2,",",".");
// quant confezione
	$sost_confezione = stripslashes($rigan[confezione]);
	$bottone_edit = '';
	$bottone_lente = '';
	$sost_totale_riga = number_format($rigan[totale],2,",",".");
	$totale_rda = $totale_rda + $rigan[totale];
	$casella_check = '';
	$sost_logo = '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
	//echo 'neg: '.$rigan[negozio].'<br>';
	switch ($rigan[azienda_prodotto]) {
		case "":
		break;
		case "VIVISOL":
			$sost_logo .= '<img src="immagini/bottone-vivisol.png" border=0>';
		break;
		case "SOL":
			$sost_logo .= '<img src="immagini/bottone-sol.png" border=0>';
		break;
	}
	$sost_logo .= '</a>';
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*bottone_lente*",$bottone_lente,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*bottone_edit*",$bottone_edit,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_nazione*",$sost_nazione,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_logo*",$sost_logo,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_confezione*",$sost_confezione,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_prezzo*",$sost_prezzo,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_quant*",$sost_quant,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*colore_scritta*",$colore_scritta,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*data_aggiornata*",$data_aggiornata,$codice_php_blocco_singola_riga_evasa);
	$codice_php_blocco_singola_riga_evasa = str_replace("*casella_check*",$casella_check,$codice_php_blocco_singola_riga_evasa);
	
	$tab_output .= $codice_php_blocco_singola_riga_evasa;
	$sost_codice_art = '';
	$sost_logo = '';
}
//fine blocco righe evase

		switch ($lingua) {
			case "":
			case "it":
			  $inserita = "Inserita il ";
			  $approvata = "<br>Approvata il ";
			  $evasa = "<br>Evasa completamente ";
			  $inprocesso = "<br>In processo";
			  $dicitura_note = "<br><br>NOTE<br>";
			break;
			case "en":
			  $inserita = "Placed on ";
			  $approvata = "<br>Approved on ";
			  $evasa = "<br>Delivered";
			  $inprocesso = "<br>Processing";
			  $dicitura_note = "<br><br>NOTES<br>";
			break;
		}
		$tracking = $inserita.$data_inserimento;
		if ($data_approvazione == 0) {
		  $data_approvazione = $data_inserimento;
		}
		if ($stato_orig_rda >= 2) {
		  $tracking .= $approvata.$data_approvazione;
		}
		switch ($stato_rda) {
			case 3:
			  $tracking .= $inprocesso;
			break;
			case 4:
			$tracking .= $evasa;
			break;
		}

  switch ($_SESSION[ruolo_report]) {
	  case "":
		switch ($_SESSION[ruolo]) {
			  case "utente":
				if ($note_resp != "") {
					$sost_note_immodificabili = '<strong>'.$sost_nome_utente.'</strong> - '.$note_resp.'<br>';
				} else {
					$sost_note_immodificabili = '';
				}
				if ($note_buyer != "") {
					$sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
				}
				if ($note_magazziniere != "") {
					$sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere;
				}
				$sost_autore = '<strong>Utente</strong>';
				$sost_nota_modificabile = '<textarea name=nota_'.$sost_id_riga.' class=campo_note id=nota_'.$sost_id_riga.' onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
				if ($note_utente != "") {
				   $sost_nota_modificabile .= $note_utente;
				} else {
				   $sost_nota_modificabile .= 'Note';
				}
				$sost_nota_modificabile .= '</textarea>';
			  break;
			  case "responsabile":
				if ($note_utente != "") {
					$sost_note_immodificabili .= '<strong>'.$sost_nome_utente.'</strong> - '.$note_utente.'<br>';
				} else {
					$sost_note_immodificabili .= '';
				}
				if ($note_buyer != "") {
					$sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
				}
				if ($note_magazziniere != "") {
					$sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere;
				}
				$sost_autore = '<strong>Responsabile</strong>';
				$sost_nota_modificabile = '<textarea name=nota_'.$sost_id_riga.' class=campo_note id=nota_'.$sost_id_riga.' onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
				if ($note_resp != "") {
				   $sost_nota_modificabile .= $note_resp;
				} else {
				   $sost_nota_modificabile .= 'Note';
				}
				$sost_nota_modificabile .= '</textarea>';
			  break;
			case "utente":
			case "responsabile":
			  if ($note_buyer != "") {
				  $sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
			  }
			  $sost_autore = '<strong>Magazziniere</strong>';
			  $sost_nota_modificabile = '<textarea name=nota_'.$sost_id_riga.' class=campo_note id=nota_'.$sost_id_riga.' onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
			  if ($note_magazziniere != "") {
				 $sost_nota_modificabile .= $note_magazziniere;
			  } else {
				 $sost_nota_modificabile .= 'Note';
			  }
			  $sost_nota_modificabile .= '</textarea>';
			break;
		}
	  break;
	  case "buyer":
	  case "magazziniere":
		if ($note_utente != "") {
			$sost_note_immodificabili = '<strong>'.$sost_nome_utente.'</strong> - '.$note_utente.'<br>';
		} else {
			$sost_note_immodificabili = '';
		}
		if ($note_resp != "") {
			$sost_note_immodificabili .= '<strong>'.$sost_nome_resp.'</strong> - '.$note_resp.'<br>';
		}
	  break;
	  case "buyer":
		if ($note_magazziniere != "") {
			$sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere;
		}
		$sost_autore = '<strong>Buyer</strong>';
		$sost_nota_modificabile = '<textarea name=nota_'.$id_rda.' class=campo_note id=nota_'.$id_rda.' onKeyUp="aggiorna_nota(nota_'.$id_rda.','.$id_rda.');">';
		if ($note_buyer != "") {
		   $sost_nota_modificabile .= $note_buyer;
		} else {
		   $sost_nota_modificabile .= 'Note';
		}
		$sost_nota_modificabile .= '</textarea>';
	  break;
	  case "magazziniere":
		if ($note_buyer != "") {
			$sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
		}
		$sost_autore = '<strong>Magazziniere</strong>';
		$sost_nota_modificabile = '<textarea name=nota_'.$id_rda.' class=campo_note id=nota_'.$id_rda.' onKeyUp="aggiorna_nota(nota_'.$id_rda.','.$id_rda.');">';
		if ($note_magazziniere != "") {
		   $sost_nota_modificabile .= $note_magazziniere;
		} else {
		   $sost_nota_modificabile .= 'Note';
		}
		$sost_nota_modificabile .= '</textarea>';
	  break;
  }
  $sost_pulsante_stampa = '<a href="stampa_rda.php?id_rda='.$id_rda.'&mode=print&lang='.$lingua.'" target="_blank">
	  <img src="immagini/btn_stampa.png" width="160" height="25" border="0">
	  </a>';
/*
  $sost_pulsante_stampa = '<a href="javascript:void(0);" onclick="PopupCenter(\'stampa_rda.php?id_rda="'.$id_rda.'"&mode=print&lang='.$lingua.'\', \'myPop1\',800,800);">
	  <img src="immagini/btn_stampa.png" width="160" height="25" border="0" border=0>
	  </a>';
	  if ($Num_righe_evadere == $Num_righe_rda) {
	  $sost_pulsante_chiusura = '<a href="javascript:void(0);" onclick="chiusura('.$id_rda.')">
		  <img src="immagini/btn_archivia.png" width="160" height="25" title="Stampa RdA">
		  </a>';
	  } else {
		  $sost_pulsante_chiusura = '';
	}
*/	
  if ($contatore_righe_flag > 0) {
  switch ($_SESSION[ruolo_report]) {
	  case "":
	  break;
	  case "buyer":
		//gli argomenti assegnati alla funzione axc per la chiusura del popup di output sono impostati a numeri fissi tranne la RdA
		//(id riga,valore del check, n rda, caso singola/multipla) il vaòlore 3 assegnato al check e al caso singola/multipla non fa parte della casistica
		//impostata nel file di jquery, quindi in questo caso la chiusura della finestra di output determina solamente un refresh della visualizzazione della RdA
		$sost_pulsante_processo = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$id_rda.",3)}})\"><img src=\"immagini/btn_processa.png\" width=\"160\" height=\"25\" border=0></a>";
	  break;
	  case "magazziniere":
		$sost_pulsante_processo = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$id_rda.",3)}})\"><img src=\"immagini/btn_creaPL.png\" width=\"160\" height=\"25\" border=0></a>";
	  break;
  }
	  } else {
		switch ($_SESSION[ruolo]) {
		  case "responsabile":
		  case "buyer":
			if ($stato_orig_rda < 2) {
				//if ($report != 1) {
				  //include "form_rda.php"; 
				  $sost_pulsante_processo = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_modal_approva_rda_resp.php?avviso=approva_rda_resp&id_rda=".$sost_id_riga."&id_utente=".$_SESSION[user_id]."&lang=".$_SESSION[lang]."',boxid:'frameless',width:460,height:190,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$sost_id_riga.",3)}})\"><img src=\"immagini/btn_approvaordine.png\" width=\"160\" height=\"25\" border=\"0\"></a>";       
				//}
			}
		  break;
		  default:
			$sost_pulsante_processo = '';
		  break;
		}
  }
  switch ($_SESSION[ruolo_report]) {
	case "buyer":
	case "":
	  $sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id_rda'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione16" . mysql_error());
	  $num_ordini = mysql_num_rows($risultp);
	  if ($num_ordini > 0) {
		$sost_ordini .= '<div id="ordini_'.$id_rda.'" class="puls_servizio" style="height:auto; border-bottom:1px solid #CCC;">';
		while ($rigap = mysql_fetch_array($risultp)) {
		  $sost_ordini .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('ordine_fornitore.php?id_ord=".$rigap[id]."&id_rda=".$rigap[id_rda]."&lang=".$lingua."', 'myPop1',800,800);\">";
		  if ($rigap[ordine_interno] != "") {
		  $sost_ordini .= "Ordine ".$rigap[ordine_interno];
		  } else {
		  $sost_ordini .= "Ordine ".$rigap[id];
		  }
		  echo "</a><br>";
		}
	  } else {
		  $sost_ordini = '';
	  }
	break;
  }
	

//echo "Num_righe_evadere: ".$Num_righe_evadere."<br>";
//echo "Num_righe_rda: ".$Num_righe_rda."<br>";
	$codice_php_note_singola_rda = $blocco_note_singola_rda;
	$codice_php_note_singola_rda = str_replace("*sost_autore*",$sost_autore,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*tracking*",$tracking,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_note_immodificabili*",$sost_note_immodificabili,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_nota_modificabile*",$sost_nota_modificabile,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_stampa*",$sost_pulsante_stampa,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_processo*",$sost_pulsante_processo,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_ordini*",$sost_ordini,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_note_singola_rda);
	$tab_output .= $codice_php_note_singola_rda;
	$codice_php_indir_singola_rda = $blocco_indir_sing_rda;
	$codice_php_indir_singola_rda = str_replace("*testo_indirizzo*",$indirizzo_spedizione,$codice_php_indir_singola_rda);
	$tab_output .= $codice_php_indir_singola_rda;

	//$tab_output .= '<span style="color:#000;">ruolo_report: '.$_SESSION[ruolo_report].'</span>';
    $tab_output .= '</div>';
	//fine id="dettaglio_rda_'.$row[id].'" class="riga dettaglio_rda" style="display:block;">';
	
	$Num_righe_evadere = "";
	$Num_righe_processate = ""; 
	$Num_righe_rda = "";
	$sost_ordini = "";
	
	$contatore_righe_flag = "";
	$contatore_x_chiusura = "";
/*

*/
//output finale
echo $tab_output;

//echo "pippo";
 ?>
