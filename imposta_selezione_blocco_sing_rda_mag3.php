<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$flusso_mag = $_SESSION[flusso];

$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$sing_rda = $_GET['id_rda'];
$mode = $_GET['mode'];
$unita = $_GET['unita'];
$categoria_ricerca = $_GET['categoria_ricerca'];
$data_inizio = $_GET['data_inizio'];
$data_fine = $_GET['data_fine'];
$shop = $_GET['shop'];
$codice_art = $_GET['codice_art'];


//procedura per il magazziniere
switch ($check) {
	case 2:
	  $id_magazz = "";
	  break;
	case 3:
	  $id_magazz = $_GET['id_utente'];
	  break;
}


switch ($mode) {
	//selezione singola riga
	case 1:
	$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id = '$id_riga'";
	if (mysql_query($query)) {
	} else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}
	break;
	
case 2:
	//selezione tutte le righe
  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND stato_ordine = '3' AND pack_list = '0'";
  if (mysql_query($query)) {
  } else {
  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
  }
break;
}

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
	  if ($rigav[rif_blocco] == 'singola_riga_evasa') {
		$blocco_singola_riga_evasa = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_riepilogo_sing_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'indir_rda') {
		$blocco_indir_sing_rda = $rigav[codice_php];
	  }
  }


//INIZIO OUTPUT BLOCCO SING RDA

  $codice_php_riepilogo_sing_rda = $blocco_riepilogo_sing_rda;
  $codice_php_testatina_righe = $blocco_testatina_righe;
  $sost_id_rda = $sing_rda;
  $sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
	  $data_approvazione = $rigay[data_approvazione];
	  $data_chiusura = $rigay[data_chiusura];
	  $data_ultima_modifica = $rigay[data_ultima_modifica];
  $note_utente = stripslashes($rigay[note_utente]);
  $nome_utente_rda = stripslashes($rigay[nome_utente]);
  $note_resp = stripslashes($rigay[note_resp]);
  $nome_resp_rda = stripslashes($rigay[nome_resp]);
  $nome_buyer_rda = stripslashes($rigay[nome_buyer]);
  $note_buyer = stripslashes($rigay[note_buyer]);
  $note_magazziniere = str_replace("<br>","\n",stripslashes($rigay[note_magazziniere]));
  }

  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
  if ($clausole > 0) {
  if ($a != "") {
  $sqlk .= " AND ".$a;
  }
  if ($b != "") {
  $sqlk .= " AND ".$b;
  }
  if ($c != "") {
  $sqlk .= " AND ".$c;
  }
  if ($d != "") {
  $sqlk .= " AND ".$d;
  }
  if ($e != "") {
  $sqlk .= " AND ".$e;
  }
  if ($f != "") {
  $sqlk .= " AND ".$f;
  }
  }
  $risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $Num_righe_rda = mysql_num_rows($risultk);
  while ($rigak = mysql_fetch_array($risultk)) {
  if ($rigak[flag_buyer] == 3) {
  $Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
  }
  if ($rigak[evaso_magazzino] == 1) {
  $Num_righe_processate = $Num_righe_processate + 1;
  } else {
  $Num_righe_evadere = $Num_righe_evadere + 1;
  }
  }
  
  if ($Num_righe_rda_selezionate == 0) {
	$tooltip_select = $tooltip_seleziona_tutto;
	$bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,3,'.$sing_rda.',2);"><img src="immagini/select-all.png" width="17" height="17" border="0" title="'.$tooltip_select.'"></a>';
  } else {
	$tooltip_select = $tooltip_deseleziona_tutto;
	$bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,2,'.$sing_rda.',2);"><img src="immagini/select-none.png" width="17" height="17" border="0" title="'.$tooltip_select.'"></a>';
  }
  
  
  if ($flag_ricerca == "") {
	if ($stampa != "1") {
	  if ($Num_righe_processate < $Num_righe_rda) {
  } else {
	  $bottone_immagine == '';
	  }
	}
  }
  //$tab_output .= "selezionate: ".$Num_righe_rda_selezionate."<br>";
  //$tab_output .= "processate: ".$Num_righe_processate."<br>";
  //$tab_output .= "righe totali: ".$Num_righe_rda."<br>";
  //$tab_output .= "righe da evadere: ".$Num_righe_evadere."<br>";
  $Num_righe_rda_selezionate = "";
  $Num_righe_evadere = "";
  $Num_righe_rda = "";
	$immagine_print = '<img src="immagini/btn_multi_stampa.jpg" border="0"></a>';
	$codice_php_testatina_righe = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace('id="col09c" style="width: 55px;','id="col09c" style="width: 95px !important;',$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace('id="col10c" style="width: 60px;','id="col10c" style="width: 52px !important;',$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace("width: 19px; padding-left: 13px;","width: 19px; padding-left: 20px !important;",$codice_php_testatina_righe);
	
	//$codice_php_testatina_righe = str_replace("*YY*",$immagine_print,$codice_php_testatina_righe);
  $tab_output .= $codice_php_testatina_righe;
  //inizio div rda
  $tab_output .= '<div class="cont_rda blocco_rda" id="blocco_rda_'.$sing_rda.'">';
  
  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
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
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_totale_righe = mysql_num_rows($risultn);
  while ($rigan = mysql_fetch_array($risultn)) {
	$codice_php_singola_riga = $blocco_singola_riga;
	if (substr($rigan[codice_art],0,1) != "*") {
	  $sost_codice_art .= $rigan[codice_art];
	} else {
	  $sost_codice_art .= substr($rigan[codice_art],1);
	}
	$sost_descrizione = $rigan[descrizione];
if ($rigan[urgente] == 1) {
	$sost_descrizione.= '<span style="color:red; font-weight: bold;"> - Urgente</span>';
}
	if ($rigan[negozio] == "labels") {
	  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		  $label_ric_mag = $rigap[ric_mag];
		/*if ($rigap[ric_mag] != "mag") {
			  $tab_output .= "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
		}*/
	  }
	}
 
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
if ($stampa != "1") {
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
  if ($stampa != "1") {
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	  $giacenza = $rigam[giacenza];
	  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  }
  // totale riga
  $sost_totale_riga = number_format($rigan[totale],2,",",".");
  $totale_rda = $totale_rda + $rigan[totale];
	if ($rigan[evaso_magazzino] == 0) {
	  if ($stampa != "1") {
		switch ($rigan[flag_buyer]) {
		  case "2":
			$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'3',".$sing_rda.",1);\">";
		  break;
		  case "3":
			$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.",1);\">";
			$contatore_righe_flag = $contatore_righe_flag + 1;
		  break;
		}
	  }
	}
$indicatore_fatturazione = substr($rigan[dest_contab],0,1);
switch ($indicatore_fatturazione) {
	case "":
	break;
	case "F":
	  $sost_logo .= '<img src="immagini/bottone-F.png" border="0" style="margin-bottom:5px; margin-right:3px;">';
	break;
	case "G":
	  $sost_logo .= '<img src="immagini/bottone-G.png" border="0" style="margin-bottom:5px; margin-right:3px;">';
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
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	
	$codice_php_singola_riga = str_replace('id="col01d" class="confez5_riga" style="width: 63px;','id="col01d" class="confez5_riga" style="width: 54px !important;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col02d" style="width: 55px;','id="col02d" style="width: 40px !important;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col03d" class="descr4_riga" style="width: 40px;','id="col03d" class="descr4_riga" style="width: 290px !important; padding-left: 10px; padding-top: 0px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col04d" class="cod1_riga" style="width: 200px;','id="col04d" class="cod1_riga" style="width: 70px !important; padding-top: 0px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col07d" class="lente_prodotto" style="width: 25px; float: left; height: 19px;','id="col07d" class="lente_prodotto" style="width: 30px; float: left; height: 19px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col08d" class="modifica_prodotto" style="width: 55px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: right; margin-right: 15px;','id="col08d" class="modifica_prodotto" style="width: 25px; float: left; min-height: 19px; overflow: hidden; height: auto; text-align: right; margin-right: 7px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col09d" style="width: 60px;','id="col09d" style="width: 167px !important;',$codice_php_singola_riga);
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
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_aggiornamento*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*aggiornamento_stato*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
	/*$codice_php_singola_riga = str_replace("*casella_print*",$casella_print,$codice_php_singola_riga);*/
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  $tab_output .= $codice_php_singola_riga;
$giacenza = "";
$rda_exist = "";

  //fine contenitore riga tabella
  
  //fine foreach
  }
  //RIGHE EVASE MAGAZZINO
    $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '1'";
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
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_totale_righe = mysql_num_rows($risultn);
  while ($rigan = mysql_fetch_array($risultn)) {
$codice_php_singola_riga_evasa = $blocco_singola_riga_evasa;
	if (substr($rigan[codice_art],0,1) != "*") {
	  $sost_codice_art .= $rigan[codice_art];
	} else {
	  $sost_codice_art .= substr($rigan[codice_art],1);
	}
	$sost_descrizione = $rigan[descrizione];
	if ($rigan[negozio] == "labels") {
	  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		  $label_ric_mag = $rigap[ric_mag];
		/*if ($rigap[ric_mag] != "mag") {
			  $tab_output .= "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
		}*/
	  }
	}
 
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
	$bottone_edit = "";
  if ($stampa != "1") {
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	  $giacenza = $rigam[giacenza];
	  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  }
  // totale riga
  $sost_totale_riga = number_format($rigan[totale],2,",",".");
  $totale_rda = $totale_rda + $rigan[totale];
	$casella_check = "";
	$sost_logo = '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
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
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "mag":
$colore_scritta = "style_mag";
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
}
break;
case "lab":
case "bmc":
case "htc":
$colore_scritta = "style_lab";
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
}
break;
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
	$codice_php_singola_riga_evasa = str_replace('id="col01d" class="confez5_riga" style="width: 63px;','id="col01d" class="confez5_riga" style="width: 54px !important;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col02d" style="width: 55px;','id="col02d" style="width: 40px !important;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col03d" class="descr4_riga" style="width: 40px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: center;','id="col03d" class="descr4_riga" style="width: 290px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: left; padding-left: 10px; padding-top: 0px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col04d" class="cod1_riga" style="width: 200px;','id="col04d" class="cod1_riga" style="width: 70px !important; padding-top: 0px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col07d" class="lente_prodotto" style="width: 25px; float: left; height: 19px;','id="col07d" class="lente_prodotto" style="width: 30px; float: left; height: 19px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col08d" class="modifica_prodotto" style="width: 55px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: right; margin-right: 15px;','id="col08d" class="modifica_prodotto" style="width: 25px; float: left; min-height: 19px; overflow: hidden; height: auto; text-align: right; margin-right: 7px;',$codice_php_singola_riga_evasa);
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
	/*$codice_php_singola_riga_evasa = str_replace("*casella_print_evasa*",$casella_print_evasa,$codice_php_singola_riga_evasa);*/
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  $tab_output .= $codice_php_singola_riga_evasa;
$dettaglio_stato = "";
$giacenza = "";
$rda_exist = "";

  //fine contenitore riga tabella
  
  //fine while
  }
  
  
  
  
  
  if ($data_approvazione == 0) {
	$data_approvazione = date("d.m.Y",$data_inserimento);
  } else {
	$data_approvazione = date("d.m.Y",$data_approvazione);
  }
  if ($data_chiusura == 0) {
	$data_chiusura = date("d.m.Y",$data_ultima_modifica);
  } else {
	$data_chiusura = date("d.m.Y",$data_chiusura);
  }
$tracking = "Inserita il ".date("d.m.Y",$data_inserimento);
$tracking .= "<br>Approvata il ".$data_approvazione;
		$tracking .= "<br>In processo dal ".$data_approvazione;
		  if ($note_utente != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_utente_rda.'</strong> - '.$note_utente.'<br>';
		  } else {
			  $sost_note_immodificabili .= '';
		  }
		  if ($note_resp != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_resp_rda.'</strong> - '.$note_resp.'<br>';
		  }
		  if ($note_buyer != "") {
			  $sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer.'<br>';
		  }
		  $sost_autore = '<strong>Magazziniere</strong>';
		  if ($note_magazziniere != "") {
		   $sost_nota_modificabile = '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onfocus="azzera_nota('.$sing_rda.');" onblur="ripristina_nota('.$sing_rda.');" onClick="controllo('.$sing_rda.');" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">'.$note_magazziniere.'</textarea>';
		  } else {
		   $sost_nota_modificabile = '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onfocus="azzera_nota('.$sing_rda.');" onblur="ripristina_nota('.$sing_rda.');" onClick="controllo('.$sing_rda.');" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">Note</textarea>';
		  }
		$sost_pulsante_sap = "";
		$sost_pulsante_ord = "";
  if ($contatore_righe_flag > 0) {
  $sost_pulsante_processo = "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?id_rda=".$sing_rda."&lang=".$lingua."&id_utente=".$id_utente."&mode=nuovo', 'myPop1',800,800);\">";
  $sost_pulsante_processo .= '<img src="immagini/btn_creaPL.png" width="160" height="25" border="0"></a>';
  }
		if ($Num_righe_rdasap_selezionate > 0) {
		  $altezza_finestra = ($Num_righe_rdasap_selezionate*37)+125+180;
		  if ($altezza_finestra > 800) {
			  $altezza_finestra = 800;
		  }
		}

	$codice_php_note_singola_rda = $blocco_note_singola_rda;
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
 $codice_php_indir_singola_rda = $blocco_indir_sing_rda;
$codice_php_indir_singola_rda = str_replace("*testo_indirizzo*",$indirizzo_spedizione,$codice_php_indir_singola_rda);
$tab_output .= $codice_php_indir_singola_rda;

//output finale

echo $tab_output;



 ?>
