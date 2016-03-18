<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
	$sqlr = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'gestione_rda'";
    $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione02" . mysql_error());
    while ($rigar = mysql_fetch_array($risultr)) {
		switch ($rigar[posizione]) {
			case "lista_attesa_approvazione":
			  $lista_attesa_approvazione = $rigar[testo_it];
			  $colore_attesa_approvazione = $rigar[colore_scritta];
			break;
			case "lista_attesa_gestione":
			  $lista_attesa_gestione = $rigar[testo_it];
			  $colore_attesa_gestione = $rigar[colore_scritta];
			break;
			case "inoltrato_lab":
			  $inoltrato_lab = $rigar[testo_it];
			  $colore_inoltrato_lab = $rigar[colore_scritta];
			break;
			case "inoltrato_ord":
			  $inoltrato_ord = $rigar[testo_it];
			  $colore_inoltrato_ord = $rigar[colore_scritta];
			break;
			case "inoltrato_mag":
			  $inoltrato_mag = $rigar[testo_it];
			  $colore_inoltrato_mag = $rigar[colore_scritta];
			break;
			case "inoltrato_sap":
			  $inoltrato_sap = $rigar[testo_it];
			  $colore_inoltrato_sap = $rigar[colore_scritta];
			break;
			case "inoltrato_bmc":
			  $inoltrato_bmc = $rigar[testo_it];
			  $colore_inoltrato_bmc = $rigar[colore_scritta];
			break;
			case "inoltrato_htc":
			  $inoltrato_htc = $rigar[testo_it];
			  $colore_inoltrato_htc = $rigar[colore_scritta];
			break;
			case "finito_ord":
			  $finito_ord = $rigar[testo_it];
			  $colore_finito_ord = $rigar[colore_scritta];
			break;
			case "finito_mag":
			  $finito_mag = $rigar[testo_it];
			  $colore_finito_mag = $rigar[colore_scritta];
			break;
			case "finito_lab":
			  $finito_lab = $rigar[testo_it];
			  $colore_finito_lab = $rigar[colore_scritta];
			break;
			case "finito_sap":
			  $finito_sap = $rigar[testo_it];
			  $colore_finito_sap = $rigar[colore_scritta];
			break;
			case "finito_bmc":
			  $finito_bmc = $rigar[testo_it];
			  $colore_finito_bmc = $rigar[colore_scritta];
			break;
			case "finito_htc":
			  $finito_htc = $rigar[testo_it];
			  $colore_finito_htc = $rigar[colore_scritta];
			break;
		}
	}
$dest = $_GET['dest'];
$layout = $_GET['layout'];
$mode = $_GET['mode'];
$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$sing_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];
$statusDaModulo = $_GET['status'];
//procedura per il buyer
	  if ($check == "0") {
	  $id_buyer = "";
	  } else {
		$id_buyer = $_GET['id_utente'];
	  }
switch ($mode) {
	case 0://nessuna selezione, solo refresh del blocco RdA
	break;
	case 1://selezione riga singola PROCESSO NORMALE
	case 3://selezione riga singola PROCESSO SAP
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 2://selezione tutte le righe selezionabili della RdA PROCESSO NORMALE
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$sing_rda' AND output_mode = ''";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 4://selezione tutte le righe (CON CAMPO ORDINE FORNITORE VUOTO) della RdA PROCESSO SAP
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$sing_rda' AND ord_fornitore = ''";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 5://selezione singola riga CON CAMPO OUTPUT_MODE = ord per visualizzazione ordine
	  $queryd = "UPDATE qui_righe_rda SET flag_buyer = '2', id_buyer = '0' WHERE output_mode = 'ord' AND flag_buyer = '6'";
	  if (mysql_query($queryd)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	  $t = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda = '$id_riga'";
	  $esit_t = mysql_query($t) or die("Impossibile eseguire l'interrogazione07" . mysql_error());
	  while ($rowt = mysql_fetch_array($esit_t)) {
		$ordine_for = $rowt[id_ordine_for];
	  }
	  $array_righe_ord = array();
	  $b = "SELECT * FROM qui_righe_ordini_for WHERE id_ordine_for = '$ordine_for'";
	  $esit_b = mysql_query($b) or die("Impossibile eseguire l'interrogazione07" . mysql_error());
	  while ($rowb = mysql_fetch_array($esit_b)) {
		  if (!in_array($rowb[id_riga_rda],$array_righe_ord)) {
			  array_push($array_righe_ord,$rowb[id_riga_rda]);
		  }
	  }
	  foreach($array_righe_ord as $ogni_riga_ord) {
		$queryh = "UPDATE qui_righe_rda SET flag_buyer = '2' WHERE id = '$ogni_riga_ord'";
		if (mysql_query($queryh)) {
		} else {
		  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
		}
	  }
	  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 10://aggiorna la riga per la stampa parziale della RdA 
	  $query = "UPDATE qui_righe_rda SET printable = '$check' WHERE id = '$id_riga'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
	case 11://riporta tutte le righe della RdA alla condizione no stampa  
	  $query = "UPDATE qui_righe_rda SET printable = '0' WHERE id_rda = '$sing_rda'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
	break;
}

$s = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
  $risults = mysql_query($s) or die("Impossibile eseguire l'interrogazione07" . mysql_error());
  $tot_righe_rda = mysql_num_rows($risults);
  while ($rigas = mysql_fetch_array($risults)) {
	  if ($rigas[flag_chiusura] == 1) {
		$righe_fatte = $righe_fatte + 1;
	  }
  }
if ($righe_fatte == $tot_righe_rda) {
$tab_output = '';
} else {
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'processo'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'note_sing_rda') {
		$blocco_note_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_riepilogo_sing_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga_evasa') {
		$blocco_singola_riga_evasa = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'indir_rda') {
		$blocco_indir_sing_rda = $rigav[codice_php];
	  }
  }
  $codice_php_riepilogo_sing_rda = $blocco_riepilogo_sing_rda;
  $codice_php_testatina_righe = $blocco_testatina_righe;


//$tab_output .= "</span><br>";
//INIZIO OUTPUT BLOCCO SING RDA

$sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
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
$data_inserimento = $rigay[data_inserimento];
$data_output = $rigay[data_output];
$data_approvazione = $rigay[data_approvazione];
$data_chiusura = $rigay[data_chiusura];
$data_ultima_modifica = $rigay[data_ultima_modifica];
$stato_orig_rda = stripslashes($rigay[stato]);
$sost_id_rda = $sing_rda;
$ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d.m.Y",$data_inserimento)."<img src=immagini/spacer.gif width=25 height=2>";
if ($rigay[id_utente] == $rigay[id_resp]) {
$ut_rda .= "Ut./Resp. ".stripslashes($rigay[nome_utente]);
} else {
$ut_rda .= "Ut. ".stripslashes($rigay[nome_utente])." - Resp. ".stripslashes($rigay[nome_resp]);
}
/*
	$sqlx = "SELECT * FROM qui_utenti WHERE user_id = '$rigay[id_utente]'";
$risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
while ($rigax = mysql_fetch_array($risultx)) {
$ut_rda .= "Utente ".$rigay[id_utente]." - ".stripslashes($rigax[nome]);
}
*/
$ut_rda .= "<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
switch ($rigay[stato]) {
case "1":
$imm_status = "<img src=immagini/stato1.png width=62 height=17 title=\"$status1\">";
break;
case "2":
$imm_status = "<img src=immagini/stato2.png width=62 height=17 title=\"$status2\">";
break;
case "3":
$imm_status = "<img src=immagini/stato3.png width=62 height=17 title=\"$status3\">";
break;
case "4":
$imm_status = "<img src=immagini/stato4.png width=62 height=17 title=\"$status4\">";
break;
}
$indicazione_negozio_rda = "<img src=immagini/spacer.gif width=25 height=2>".ucfirst(str_replace("_"," ",$rigay[negozio]));
$tipo_negozio = stripslashes($rigay[negozio]);
$wbs_visualizzato = stripslashes($rigay[wbs]);
$note_utente = stripslashes($rigay[note_utente]);
$nome_utente_rda = stripslashes($rigay[nome_utente]);
$note_resp = stripslashes($rigay[note_resp]);
$nome_resp_rda = stripslashes($rigay[nome_resp]);
$note_magazziniere = stripslashes($rigay[note_magazziniere]);
$note_buyer = str_replace("<br>","\n",stripslashes($rigay[note_buyer]));
}
$querys = "SELECT * FROM qui_files_sap WHERE id_rda = '$sing_rda'";
$results = mysql_query($querys);
$num_tracciati = mysql_num_rows($results);
if ($num_tracciati > 0) {
$tracciati_sap .= "<img src=immagini/spacer.gif width=25 height=2>SAP ";
while ($rows = mysql_fetch_array($results)) {
$nome_file_sap = $rows[nome_file];
if ($nome_file_sap != "") {
$pos = strrpos($nome_file_sap,"_");
$nome_vis = substr($nome_file_sap,($pos+1),5);
$tracciati_sap .= " (".$nome_vis.")";
}
}
}

//inizio contenitore esterno sing rda
$tab_output .= '<div class="cont_rda" id="glob_'.$sing_rda.'">';
//inizio div riassunto rda
$sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
$resultm = mysql_query($sqlm);
$num_righeXDim = mysql_num_rows($resultm);
$altezza_finestra = ($num_righeXDim*37)+125+180;
if ($altezza_finestra > 800) {
	$altezza_finestra = 800;
}

if ($tipo_negozio != "assets") {
//$tab_output .= "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
$sost_ut_rda = $ut_rda.$tracciati_sap;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
//$tab_output .= "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
$sost_ut_rda = $output_wbs.$ut_rda;
}
$wbs_visualizzato = "";
$output_wbs = "";
$ut_rda = "";
$tracciati_sap = "";

  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
  //echo '<span style="color:#000;">sqlk: '.$sqlk.'<br>';
  $risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione11" . mysql_error());
  $Num_righe_rda = mysql_num_rows($risultk);
  while ($rigak = mysql_fetch_array($risultk)) {
	if ($rigak[stato_ordine] != 4) {
	  if (($rigak[flag_buyer] == 4) && ($rigak[output_mode] == "sap")) {
		$Num_righe_rdasap_selezionate = $Num_righe_rdasap_selezionate + 1;
	  }
	  if ($rigak[flag_buyer] == 1) {
		$Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
	  }
	  if ($rigak[output_mode] == "sap") {
		$Num_righe_sap_rda = $Num_righe_sap_rda + 1;
		if ($rigak[ord_fornitore] == "") {
		  $righeSapDaProcessare = $righeSapDaProcessare + 1;
		} else {
		  $righeSapProcessate = $righeSapProcessate + 1;
		}
	  }
	  if (($rigak[output_mode] == "ord") && ($rigak[flag_buyer] == "6")) {
		$Num_righe_ord_rda = $Num_righe_ord_rda + 1;
	  }
	  if ($rigak[output_mode] != "") {
		if ($rigak[flag_buyer] >= 2) {
		  $Num_righe_processate = $Num_righe_processate + 1;
		}
		if (($rigak[output_mode] != "mag") && ($rigak[output_mode] != "lab")) {
		  $Num_righe_evadere = $Num_righe_evadere + 1;
		} else {
		  if ($rigak[evaso_magazzino] == 1) {
			$Num_righe_evadere = $Num_righe_evadere + 1;
		  }
		}
	  }
	} else {
	  if ($rigak[flag_chiusura] == 0) {
		$Num_righe_evadere_chiusura = $Num_righe_evadere_chiusura + 1;
	  }
	}
  }
 /* echo '<span style="color: #000;">Num_righe_evadere_chiusura: '.$Num_righe_evadere_chiusura.'<br>';
 $tab_output .= '<span style="color: #000;">Num_righe_rdasap_selezionate: '.$Num_righe_rdasap_selezionate.'<br>';
 echo 'righeSapDaProcessare: '.$righeSapDaProcessare.'<br>
  righeSapProcessate: '.$righeSapProcessate.'<br></span>'; */
switch ($statusDaModulo) {
  case "sap":
	if ($righeSapDaProcessare > 0) {
	  if ($Num_righe_rdasap_selezionate < $righeSapDaProcessare) {
		$tooltip_select = "Seleziona tutto";
		$bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,4,'.$sing_rda.',4);"><img src="immagini/select-all.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	  } else {
	  $tooltip_select = "Deseleziona tutto";
	  $bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,2,'.$sing_rda.',4);"><img src="immagini/select-none.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	  }
	} else {
	  $bottone_immagine = '';
	}
  break;
  case "":
  case "no_process":
	if ($Num_righe_rda_selezionate == ($Num_righe_rda-$Num_righe_processate)) {
	  $tooltip_select = "Deseleziona tutto";
	  $bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,0,'.$sing_rda.',2);"><img src="immagini/select-none.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	} else {
	  $tooltip_select = "Seleziona tutto";
	  $bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,1,'.$sing_rda.',2);"><img src="immagini/select-all.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	}
  break;
}
/*
switch ($statusDaModulo) {
  case "":
  case "no_process":
	  $sost_chiudi = "";
  break;
  case "mag":
  case "lab":
  case "ord":
  case "sap":
*/  
	if ($Num_righe_evadere_chiusura == $Num_righe_rda) {
	  $sost_chiudi = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_modal_chiusura_rda.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."',boxid:'frameless',width:500,height:200,fixed:false,maskid:'bluemask',maskopacity:'40',closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><div>ARCHIVIA</div></a>";
	} else {
	  $sost_chiudi = "";
	}
/*

  break;
}

*/

	$div_bloccoRdA = '<div id="blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda" style="display:block;">';
	$sost_puls_piumeno = 'immagini/a-meno.png';

//$tab_output .= '<span style="color: #000;">Num_righe_ord_rda: '.$Num_righe_ord_rda.'</span><br>';
$codice_php_riepilogo_sing_rda = str_replace("*sost_puls_piumeno*",$sost_puls_piumeno,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_chiudi*",$sost_chiudi,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_ut_rda*",$sost_ut_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_imm_status*",$imm_status,$codice_php_riepilogo_sing_rda);
$tab_output .= $codice_php_riepilogo_sing_rda;
//fine div riassunto rda
/*$tab_output .= '<span style="color:#000; font-size:9px;">selezionate: '.$Num_righe_rda_selezionate.'<br>.
Num_righe_processate: '.$Num_righe_processate.'<br>
Num_righe_rda: '.$Num_righe_rda.'</span><br>';*/
//inizio div testatina nuova
//fine div testatina nuova


//inizio div rda
$tab_output .= $div_bloccoRdA;
$div_bloccoRdA = '';
$immagine_print = '<img src="immagini/btn_multi_stampa.jpg" border="0"></a>';
$codice_php_testatina_righe = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*YY*",$immagine_print,$codice_php_testatina_righe);
  $tab_output .= $codice_php_testatina_righe;
		$righeSapDaProcessare = "0";
//$tab_output .= "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
$queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_rda_completa = $somma;
//*********************************************************
//INIZIO WHILE RIGHE DELLA RDA ANCORA IN PROCESSO 
	$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine != '4'";
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
$codice_php_singola_riga = $blocco_singola_riga;
$codice_php_note_singola_rda = $blocco_note_singola_rda;
//inizio contenitore riga, preso dal database, imposto le variabile da sostituire alla struttura di base
$sost_id_riga = $rigan[id];
/*
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
*/
// codice riga
//if ($rigan[categoria] == "Bombole") {
	//$sost_codice_art = '<a href="riepilogo_bombola.php?cod='.$rigan[codice_art].'" target="_blank">';
//}
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}
//if ($rigan[categoria] == "Bombole") {
	//$sost_codice_art .= "</a>";
//}

// descrizione riga
$sost_descrizione = $rigan[descrizione];
if ($rigan[urgente] == 1) {
	$sost_descrizione.= '<span style="color:red; font-weight: bold;"> - Urgente</span>';
}
// nome unità riga
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
// pulsante per evasione parziale riga
if (($rigan[output_mode] == "") AND ($rigan[flag_buyer] == "1")) {
  if (($rigan[negozio] == "labels") AND ($label_ric_mag != "mag")) {
  } else {
	if ($sost_quant > 1) {
	  $bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:980,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	$bottone_edit = "";
	}
  }
} else {
	$bottone_edit = "";
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
// totale riga
$sost_totale_riga = number_format($rigan[totale],2,",",".");
$totale_rda = $totale_rda + $rigan[totale];

$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "":
$colore_scritta = $colore_attesa_gestione;
$dettaglio_stato = $lista_attesa_gestione;
if ($rigan[data_approvazione] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_approvazione]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_inserimento]);
}
break;
case "mag":
$colore_scritta = $colore_inoltrato_mag;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$inoltrato_mag.' '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_mag;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
case "sap":
$colore_scritta = $colore_inoltrato_sap;
if ($rigan[ord_fornitore] != "") {
$dettaglio_stato = $finito_sap." ".$rigan[ord_fornitore]."<br>".$rigan[fornitore_tx];
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
$campo_ordsap = '';
} else {
$campo_ordsap = '';
$dettaglio_stato = $inoltrato_sap;
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
break;
case "ord":
$colore_scritta = $colore_inoltrato_ord;
$sqlz = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda='".$rigan[id]."'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$dettaglio_stato = '<a href="ordine_fornitore.php?id_ord='.$rigaz[id_ordine_for].'&id_rda='.$rigan[id_rda].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$inoltrato_ord.' '.$rigaz[id_ordine_for].'</span></a>';
}
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
break;
case "lab":
$colore_scritta = $colore_inoltrato_lab;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_lab.' '.$rigan[pack_list].'</span></a>';
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$dettaglio_stato = $inoltrato_lab;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
case "bmc":
$colore_scritta = $colore_inoltrato_bmc;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_bmc.' '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_bmc;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
case "htc":
$colore_scritta = $colore_inoltrato_htc;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_htc.' '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_htc;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
//div checkbox (vuoto)
switch ($rigan[output_mode]) {
	default:
		$casella_check = "";
	break;
	case "":
	  switch ($rigan[flag_buyer]) {
	  case "0":
		$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.",1);\">";
	  break;
	  case "1":
		$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.",1);\">";
		$contatore_righe_flag = $contatore_righe_flag + 1;
	  break;
	  }
	break;
	case "sap":
	  //if ($statusDaModulo == "sap") {
		  //IL MODE 3 serve a far capire al file di jquery che sono in modalità "gestione SAP"
		  if ($rigan[ord_fornitore] == "") {
			switch ($rigan[flag_buyer]) {
			case "2":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'4',".$sing_rda.",3);\">";
			break;
			case "4":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.",3);\">";
			  $contatore_righe_flag_sap = $contatore_righe_flag_sap + 1;
			break;
			}
		  } else {
			$casella_check = '';
		  }
	  //} else {
		//$casella_check = "";
	  //}
	break;
	case "ord":
		  //IL MODE 5 serve a far capire al file di jquery che sono in modalità "visualizzazione ordine fornitore"
			switch ($rigan[flag_buyer]) {
			case "2":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'6',".$sing_rda.",5);\">";
			break;
			case "6":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.",5);\">";
			  $contatore_righe_flag_ord = $contatore_righe_flag_ord + 1;
			break;
			}
	break;
}
$indicatore_fatturazione = substr($rigan[dest_contab],0,1);
switch ($indicatore_fatturazione) {
	case "":
	break;
	case "F":
	  $sost_logo = '<img src="immagini/bottone-F.png" border="0" style="margin-bottom:5px; margin-right:3px;">';
	break;
	case "G":
	  $sost_logo = '<img src="immagini/bottone-G.png" border="0" style="margin-bottom:5px; margin-right:3px;">';
	break;
}
$indicatore_fatturazione = "";
$sost_logo .= '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
//$tab_output .= 'neg: '.$rigan[negozio].'<br>';
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
$sost_logo .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
$sost_logo .= "</a>";
//IL MODE 10 serve a far capire al file di jquery che sono in modalità "stampa selettiva delle righe"
switch ($rigan[printable]) {
	case "0":
	  $casella_print = "<input name=id_riga_print[] type=checkbox id=id_riga_print[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.",10);\">";
	break;
	case "1":
	  $casella_print = "<input name=id_riga_print[] type=checkbox id=id_riga_print[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.",10);\">";
	break;
}
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	$codice_php_singola_riga = str_replace("*sost_id_riga*",$sost_id_rda,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_aggiornamento*",$colore_aggiornamento,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*aggiornamento_stato*",$aggiornamento_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_print*",$casella_print,$codice_php_singola_riga);
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  $tab_output .= $codice_php_singola_riga;
$giacenza = "";
$rda_exist = "";
//fine contenitore riga tabella

}
//FINE WHILE RIGHE DELLA RDA ANCORA IN PROCESSO 
//*********************************************************
//*********************************************************
//INIZIO WHILE RIGHE GIA' COMPLETATE DELLA RDA 
	$sqlw = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine = '4'";
$risultw = mysql_query($sqlw) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
while ($rigaw = mysql_fetch_array($risultw)) {
$codice_php_singola_riga_evasa = $blocco_singola_riga_evasa;
//inizio contenitore riga, preso dal database, imposto le variabile da sostituire alla struttura di base
$sost_id_riga = $rigaw[id];
//if ($rigaw[categoria] == "Bombole") {
	//$sost_codice_art = '<a href="riepilogo_bombola.php?cod='.$rigaw[codice_art].'" target="_blank">';
//}
if (substr($rigaw[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigaw[codice_art];
} else {
  $sost_codice_art .= substr($rigaw[codice_art],1);
}
//if ($rigaw[categoria] == "Bombole") {
	//$sost_codice_art .= "</a>";
//}

// descrizione riga
$sost_descrizione = $rigaw[descrizione];
// nome unità riga
$sost_unita = $rigaw[nome_unita];
// quant riga
$sost_quant = intval($rigaw[quant]);
// pulsante per evasione parziale riga
	  $bottone_edit = "";
// pulsante per visualizzare scheda
$sqlm = "SELECT * FROM qui_prodotti_".$rigaw[negozio]." WHERE codice_art='".$rigaw[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	$giacenza = $rigam[giacenza];
	if ($rigam[categoria1_it] == "Bombole") {
  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigaw[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigaw[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
// totale riga
$sost_totale_riga = number_format($rigaw[totale],2,",",".");
$totale_rda = $totale_rda + $rigaw[totale];

$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
switch ($rigaw[output_mode]) {
case "":
$dettaglio_stato = "In attesa di gestione";
if ($rigaw[data_approvazione] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_approvazione]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_inserimento]);
}
break;
case "mag":
$colore_scritta = "style_mag";
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigaw[pack_list].'</span></a>';
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$dettaglio_stato = "Inoltrato al Magazzino ";
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
case "sap":
$colore_scritta = "style_sap";
if ($rigaw[ord_fornitore] != "") {
  $dettaglio_stato = "Ordine Sap ".$rigaw[ord_fornitore]."<br>".$rigaw[fornitore_tx];
  if ($rigaw[data_chiusura] > 0) {
  $aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
  } else {
  $aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
  }
  $campo_ordsap = '';
} else {
  $campo_ordsap = '';
  $dettaglio_stato = "Inoltrato a Sap";
  $aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
break;
case "ord":
$colore_scritta = "style_ord";
$sqlz = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda='".$rigaw[id]."'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$dettaglio_stato = '<a href="ordine_fornitore.php?id_ord='.$rigaz[id_ordine_for].'&id_rda='.$rigaw[id_rda].'" target="_blank"><span class="'.$colore_scritta.'">Ordine fornitore '.$rigaz[id_ordine_for].'</span></a>';
}
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
break;
case "lab":
$colore_scritta = "style_lab";
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigaw[pack_list].'</span></a>';
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$dettaglio_stato = "Inoltrato al Magazzino Labels";
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
case "bmc":
$colore_scritta = $colore_inoltrato_bmc;
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_bmc.' '.$rigaw[pack_list].'</span></a>';
if ($rigaw[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_bmc;
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
case "htc":
$colore_scritta = $colore_inoltrato_htc;
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_htc.' '.$rigaw[pack_list].'</span></a>';
if ($rigaw[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_htc;
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
//div checkbox (vuoto)
  $casella_check = "";
$sost_logo = '<a href="report_prodotti.php?shop='.$rigaw[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigaw[codice_art].'&categoria4=&ricerca=1" target="_blank">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($rigaw[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $sost_logo .= '<img src="immagini/bottone-vivisol.png" border="0" style="margin-bottom:5px;">';
	break;
	case "SOL":
	  $sost_logo .= '<img src="immagini/bottone-sol.png" border="0" style="margin-bottom:5px;">';
	break;
}
$sost_logo .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
$sost_logo .= "</a>";
//IL MODE 10 serve a far capire al file di jquery che sono in modalità "stampa selettiva delle righe"
switch ($rigan[printable]) {
	case "0":
	  $casella_print_evasa = "<input name=id_riga_print[] type=checkbox id=id_riga_print[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.",10);\">";
	break;
	case "1":
	  $casella_print_evasa = "<input name=id_riga_print[] type=checkbox id=id_riga_print[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.",10);\">";
	break;
}
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	$codice_php_singola_riga_evasa = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*colore_aggiornamento*",$colore_aggiornamento,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*aggiornamento_stato*",$aggiornamento_stato,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*casella_print_evasa*",$casella_print_evasa,$codice_php_singola_riga_evasa);
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  //$tab_output .= "qui cominciano le righe evase RdA ".$sing_rda;
  $tab_output .= $codice_php_singola_riga_evasa;
$giacenza = "";
$rda_exist = "";
//fine contenitore riga tabella

}
//FINE WHILE RIGHE GIA' COMPLETATE DELLA RDA 
//*********************************************************

//div riga bianca con totali
$tab_output .= '<div id="totale_rda" class="columns_righe2" style="font-weight:bold; border-bottom:1px solid;">';
$tab_output .= '<div class="dicitura_totale_rda">';
$tab_output .= 'Totale';
$tab_output .= "</div>";
$tab_output .= '<div class="cifra_totale_rda">';
$tab_output .= '<strong>&euro; '.number_format($totale_rda,2,",",".").'</strong>';
$tab_output .= "</div>";
$tab_output .= "</div>";


$tracking = "Inserita il ".date("d.m.Y",$data_inserimento);
  if ($data_output == 0) {
	  $data_output = $data_ultima_modifica;
  }
  if ($data_approvazione == 0) {
	$data_approvazione = date("d.m.Y",$data_inserimento);
  } else {
	$data_approvazione = date("d.m.Y",$data_approvazione);
  }
	$tracking .= "<br>Approvata il ".$data_approvazione;
  switch ($stato_orig_rda) {
	  case 3:
		$tracking .= "<br>In processo dal ".date("d.m.Y",$data_output);
	  break;
	  case 4:
		$tracking .= "<br>Evasa completamente il ".date("d.m.Y",$data_chiusura);
	  break;
  }
  switch ($_SESSION[ruolo]) {
		case "buyer":
		  if ($note_utente != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_utente_rda.'</strong> - '.$note_utente.'<br>';
		  } else {
			  $sost_note_immodificabili .= '';
		  }
		  if ($note_resp != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_resp_rda.'</strong> - '.$note_resp.'<br>';
		  }
		  if ($note_magazziniere != "") {
			  $sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere.'<br>';
		  }
		  $sost_autore = '<strong>Buyer</strong>';
		  if ($note_buyer != "") {
		   $sost_nota_modificabile = "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onfocus=\"azzera_nota(".$sing_rda.");\" onblur=\"ripristina_nota(".$sing_rda.");\" onClick=\"controllo(".$sing_rda.");\">".$note_buyer."</textarea>";
		  } else {
		   $sost_nota_modificabile = "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onfocus=\"azzera_nota(".$sing_rda.");\" onblur=\"ripristina_nota(".$sing_rda.");\" onClick=\"controllo(".$sing_rda.");\">Note</textarea>";
		  }
		break;
  }
  
//switch ($statusDaModulo) {
//	case "":
//	case "no_process":
	
		if ($contatore_righe_flag > 0) {
		  $sost_pulsante_processo = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:500,height:320,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=\"immagini/btn_processarda.png\" width=\"160\" height=\"25\" border=\"0\"></a>";
		}
//	break;
//	default:
	  //if ($righeSapProcessate == $Num_righe_sap_rda) {
		//$sost_pulsante_processo = "";
	  //} else {
		if ($Num_righe_rdasap_selezionate > 0) {
		  $altezza_finestra = ($Num_righe_rdasap_selezionate*37)+125+180;
		  if ($altezza_finestra > 800) {
			  $altezza_finestra = 800;
		  }
		  $sost_pulsante_sap = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda_ordsap.php?report=1&a=1&pers=&id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40',closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=\"immagini/btn_inserisciOrdSap.png\" width=\"160\" height=\"25\" border=\"0\"></a>";
		} else {
			$sost_pulsante_sap = "";
		}
	  //}
	  if ($Num_righe_ord_rda > 0) {
		  $sost_pulsante_ord = '<a href="ordine_fornitore.php?id_ord='.$ordine_for.'&id_rda='.$sing_rda.'" target="_blank"><img src="immagini/btn_visOrd.jpg" width="160" height="25" border="0"></a>';
		} else {
			$sost_pulsante_ord = "";
	  }
//	break;
//}
$sost_pulsante_stampa = '<a href="stampa_rda.php?id_rda='.$sing_rda.'&mode=print&lang='.$lingua.'" target="_blank"><img src="immagini/btn_stampa.png" width="160" height="25" border="0"></a>';
//div per note e pulsanti processi
	$codice_php_note_singola_rda = str_replace("*sost_autore*",$sost_autore,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*tracking*",$tracking,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_note_immodificabili*",$sost_note_immodificabili,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_nota_modificabile*",$sost_nota_modificabile,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_stampa*",$sost_pulsante_stampa,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_sap*",$sost_pulsante_sap,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_ord*",$sost_pulsante_ord,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_processo*",$sost_pulsante_processo,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_id_riga*",$sing_rda,$codice_php_note_singola_rda);
	
  $tab_output .= $codice_php_note_singola_rda;
  $sost_note_immodificabili = "";
  $sost_pulsante_processo = "";
$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";
$totale_rda_completa = "";
$somma = "";
$Num_righe_processate = ""; 
$righeSapDaProcessare = "";
$Num_righe_rdasap_selezionate = '';

$contatore_x_chiusura = "";
$codice_php_indir_singola_rda = $blocco_indir_sing_rda;
$codice_php_indir_singola_rda = str_replace("*testo_indirizzo*",$indirizzo_spedizione,$codice_php_indir_singola_rda);
$tab_output .= $codice_php_indir_singola_rda;
//fine contenitore esterno sing rda
//$tab_output .= "</div>";

}
/*
$tab_output .= '<span style="color: #000;">';
$tab_output .= '<br>contatore_righe_flag: '.$contatore_righe_flag;
$tab_output .= '<br>Num_righe_evadere: '.$Num_righe_evadere;
$tab_output .= '<br>Num_righe_rda: '.$Num_righe_rda;
$tab_output .= '</span>';
*/
//output finale

echo $tab_output;

//echo "pippo";



 ?>
