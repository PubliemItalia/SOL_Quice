<?php
session_start();
$check_ord = $_POST[check_ord];
$check_fatt = $_POST[check_fatt];
$venditore = $_POST[venditore];
$n_ord = $_POST[n_ord];
$n_fatt = $_POST[n_fatt];
$id_fatt = $_POST[id];
$id_company = $_POST[company];
$blocco_pl = $_POST[blocco_pl];
$data_attuale = mktime();
$data_tx_attuale = date("d/m/Y",$data_attuale);
//$out_value .= "check_ord: ".$check_ord."<br>";
//$out_value .= "check_fatt: ".$check_fatt."<br>";
	$pos = strpos($blocco_pl,";");
	if ($pos > 0) {
		$array_pl = explode(";",$blocco_pl);
	} else {
		$array_pl = array($blocco_pl);
	}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

//PROCEDURA INSERIMENTO NUMERO FATTURA SAP

if ($check_fatt == 1) {
  //aggiorno fatt quice
  $query = "UPDATE qui_RdF SET n_fatt_sap = '$n_fatt', data_fattura = '$data_attuale', data_ultima_modifica = '$data_attuale' WHERE id = '$id_fatt'"; 
  if (mysql_query($query)) {
	  //$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
  } else {
	$out_value .= "Errore durante l'inserimento1". mysql_error();
  }
  //aggiorno packing list
	foreach ($array_pl as $sing_pl) {
	$query2 = "UPDATE qui_packing_list SET n_fatt_sap = '$n_fatt', data_chiusura = '$data_attuale', data_chiusura_tx = '$data_tx_attuale' WHERE id = '$sing_pl'"; 
	if (mysql_query($query2)) {
		//$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
	} else {
	$out_value .= "Errore durante l'inserimento1". mysql_error();
	}
  //aggiorno righe_rda
	$query3 = "UPDATE qui_righe_rda SET n_fatt_sap = '$n_fatt' WHERE pack_list = '$sing_pl'"; 
	if (mysql_query($query3)) {
		//$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
	} else {
	$out_value .= "Errore durante l'inserimento1". mysql_error();
	}
	}

	$queryx = "SELECT * FROM qui_RdF WHERE n_fatt_sap = '".$n_fatt."'";
	$resultx = mysql_query($queryx);
	while ($rowx = mysql_fetch_array($resultx)) {
	$sing_company = $rowx[id_company];
	$nome_sing_company = $rowx[nome_company];
	$id_ord = $rowx[n_ord_sap];
	}


  $sommapl =  "SELECT SUM(totale) as totale_fatt FROM qui_righe_rda WHERE n_fatt_sap = '".$n_fatt."'";
  $resulth = mysql_query($sommapl);
  list($totale_fatt) = mysql_fetch_array($resulth);
  $importo_fatt = $totale_fatt;
	  $out_value .= '<div id= "glob_'.$id_fatt.'" style="width: 100%; min-height: 30px; overflow: hidden; height: auto;">';
	$out_value .= "<a name=".$id_fatt.">";
	  $out_value .= '<div class="contenitore_rda_testfatt" style="padding-top: 10px; background-color: #888; color:white; text-decoration:none;">';
	  $out_value .= '<div style="width: 150px; height: 20px; float: left;">'.$nome_sing_company.'</div>
	  <div style="text-align: right; width: 130px; height: 20px; float: left; margin: 0px 50px 0px 10px;">Totale euro '.number_format($importo_fatt,2,",",".").'</div>';
	  $out_value .= '<div style="width: 400px; height: 20px; float: left; margin-top: -3px;">';
		  $out_value .= '<div style ="width:154px; height:22px; float:left;">';
			$out_value .= "<span style=\"margin:1px 5px 0px 0px; color: #dedede;\">Ord. n. </span><input type=text name=ord".$id_fatt." id=ord".$id_fatt." disabled style =\"width:100px; height:22px; background-color: transparent !important; border: none; color: #dedede; font-weight: normal !important; padding-left:0px; margin-top: -1px;\" onFocus=\"azzera_campoord(this.id,".$id_fatt.")\"";
			$out_value .= " value=".$id_ord.">";
		  $out_value .= "</div>";	
	$out_value .= '<div style="width:154px; height:22px; margin-left:10px; float:left;">';
		$out_value .= '<div style="margin:3px 5px 0px 0px; color: #dedede; font-weight: normal !important;">Fatt. n '.$n_fatt.'</div>';
	$out_value .= "</div>";	
			  $blocco_pl = str_replace("|",";",$blocco_pl);
			  $blocco_pl = str_replace(""," ",$blocco_pl);
			$out_value .= "</div>";




	  $out_value .= '<div id="pulsante_'.$id_fatt.'" style="width: 30px; height: 20px; float: right; margin-right: 20px; margin-top: -3px; cursor:pointer; text-align: right;" onclick="vis_invis_unit('.$id_fatt.')"><img src="immagini/a-piu.png"></div>';
	  if ($nrRdaDaModulo == "") {
	  $out_value .= "<div style=\"width: 30px; height: 20px; float: right; margin-right: 20px; cursor:pointer;\" onclick=\"PopupCenter('vista_fattura.php?mode=print&blocco_pl=".$blocco_pl."&unit=".$sing_company."', 'myPop1',800,800);\">PDF</div>";
	  }
/*	  
foreach ($array_pl as $cad_pl) {
	$queryw = "SELECT * FROM qui_packing_list WHERE id = '$cad_pl'";
	$resultw = mysql_query($queryw);
	while ($roww = mysql_fetch_array($resultw)) {
	  $logo_pl = $roww[logo];
	}
}
*/
	$out_value .= "<div id=logo_".$cad_pl." style =\"width:30px; height:20px; margin-right:25px; float:right;\">";
	/*
	switch($logo_pl) {
		case "sol":
		  $out_value .= '<img src="immagini/bottone-sol.png" border="0">';
		break;
		case "vivisol":
		  $out_value .= '<img src="immagini/bottone-vivisol.png" border="0">';
		break;
	}
*/	
	$out_value .= "</div>";
	  $out_value .= "</div>";
	$out_value .= "</a>";
  $out_value .= "<div id=unit".$id_fatt." class=contenitore_pl_unit>";
foreach ($array_pl as $sing_pl) {
  $array_rda_pl = array();
  $array_resp = array();
  $out_value .= '<div id="test'.$sing_pl.'" class="contenitore_rda_testfatt" style="width:943px;">';
	$querys = "SELECT * FROM qui_corrispondenze_pl_rda WHERE pl = '$sing_pl'";
	$results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
	  if (!in_array($rows[rda],$array_rda_pl)) {
		$add_rdapl = array_push($array_rda_pl,$rows[rda]);
	  }
	}
	foreach ($array_rda_pl as $sing_rdapl) {
	  $lista_rdapl .= $sing_rdapl." ";
	  $queryh = "SELECT * FROM qui_rda WHERE id = '$sing_rdapl'";
	  $resulth = mysql_query($queryh);
	  while ($row = mysql_fetch_array($resulth)) {
		  $lista_unita = $row[nome_unita]." ";
		$queryk = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
		$resultk = mysql_query($queryk);
		while ($rowk = mysql_fetch_array($resultk)) {
		  $lista_resp = $rowk[nome]." ";
		}
	  }
	}
	$out_value .= "<a name=".$sing_pl.">";
	  $out_value .= "<div class=box_450 style=\"width:680px; color:white; text-decoration:none; cursor:pointer;\" onClick=\"vis_invis(".$sing_pl.")\">";
		$out_value .= "RdA ".$lista_rdapl."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		$out_value .= "Resp. ".$lista_resp."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		$out_value .= "Unit&agrave; ".$lista_unita."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		$out_value .= "PL ".$sing_pl;
	  $out_value .= "</div>";
	$out_value .= "</a>";
	$lista_rdapl = "";
	$lista_resp = "";
	$lista_unita = "";
	$out_value .= "<div id=rif_ord_".$sing_pl." style =\"width:90px; height:20px; margin-top:5px; float:left;\">";
	if ($n_ord_sap != "") {
	  $out_value .= "ODV ".$n_ord_sap;
	}
	$out_value .= "</div>";
	$out_value .= "<div id=rif_fatt_".$sing_pl." style =\"width:90px; height:20px; margin-top:5px; float:left;\">";
	if ($n_fatt_sap != "") {
	  $out_value .= "FT ".$n_fatt;
	}
	$out_value .= "</div>";
	//tasto pdf
	//$out_value .= "<a href=\"javascript:void(0);\">";
	$out_value .= "<div style =\"width:30px; height:20px; margin-top:5px; float:left; text-decoration:none; color:white; cursor:pointer; text-align: right;\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$sing_pl."&lang=".$lingua."', 'myPop1',800,800);\">";
	$out_value .= "PDF";
	$out_value .= "</div>";
	//$out_value .= "</a>";
  $out_value .= "</div>";
  //singolo contenitore
  if ($pl_gest == $sing_pl) {
  $out_value .= '<div id="pl'.$sing_pl.'" class="contenitore_rda_fattura" style="display:block; padding-left: 0px !important; width: 947px;">';
  } else {
  $out_value .= '<div id="pl'.$sing_pl.'" class="contenitore_rda_fattura" style="display:none; padding-left: 0px !important; width: 947px;">';
  }
	foreach ($array_rda_pl as $sing_rdapl) {
	  $out_value .= "<div class=contenitore_gruppo_merci style=\"margin-top:5px; width:800px; float:left;\">";
	  $out_value .= "RdA ".$sing_rdapl;
	  $out_value .= "</div>";
		$sum_parz_rda = "SELECT SUM(totale) as somma_parz_rda FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl'";
		  $resultf = mysql_query($sum_parz_rda);
		  list($somma_parz_rda) = mysql_fetch_array($resultf);
	  $out_value .= '<div class="box_130_dx" style="font-weight:bold; width: 100px; float: right; padding-right:0px;">';
	  $out_value .= number_format($somma_parz_rda,2,",",".");
	  $out_value .= "</div>";
	  $somma_parz_rda = "";
	  //if ($clausole <= 5) {
		$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' ORDER BY gruppo_merci ASC";
	  //} else {
		//$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND dest_contab = '$dest_contab' ORDER BY gruppo_merci ASC";
	  //}
	 //$out_value .= '<span style="color:red;">clausole: '.$clausole.'<br>';
	 //$out_value .= $queryg.'</span><br>';
	  $resultg = mysql_query($queryg);
	  while ($rowg = mysql_fetch_array($resultg)) {
		if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
		  if ($gruppo_merci_uff != "") {
			$out_value .= "<div class=riga_separazione>";
			$out_value .= "</div>";
		  }
		  $gruppo_merci_uff = $rowg[gruppo_merci];
		  $querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
		  $results = mysql_query($querys);
		  while ($rows = mysql_fetch_array($results)) {
			$descrizione_gruppo_merci = $rows[descrizione];
			$codice_sap = $rows[codice_sap];
		  }
			$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE pack_list = '$sing_pl' AND gruppo_merci = '$gruppo_merci_uff'";
		  $resultz = mysql_query($sum_grm);
		  list($somma_grm) = mysql_fetch_array($resultz);
		  $totale_grm = $somma_grm;
		  //$TOTALE_pl = $TOTALE_pl + $totale_grm;
		  $out_value .= '<div class="contenitore_gruppo_merci" style="width: 938px;">';
			$out_value .= "<div class=box_120>";
			  $out_value .= $gruppo_merci_uff;
			$out_value .= "</div>";
			$out_value .= "<div class=box_570>";
			  $out_value .= $codice_sap." ".stripslashes($descrizione_gruppo_merci);
			$out_value .= "</div>";
			$out_value .= "<div class=box_130_dx>";
			  $out_value .= "-";
			  //$out_value .= number_format($rowg[quant],2,",",".");
			$out_value .= "</div>";
			$out_value .= '<div class="box_130_dx" style="width: 100px; float: right; padding-right:0px;">';
			  $out_value .= number_format($totale_grm,2,",",".");
			$out_value .= "</div>";
		  $out_value .= "</div>";
		  $totale_grm = "";
		}
		$out_value .= '<div class="contenitore_riga_fattura" style="width: 938px;">';
		  $out_value .= "<div class=box_120>";
			if (substr($rowg[codice_art],0,1) != "*") {
			  $out_value .= $rowg[codice_art];
			} else {
			  $out_value .= substr($rowg[codice_art],1);
			}
		  $out_value .= "</div>";
		  $out_value .= "<div class=box_570>";
			$out_value .= stripslashes($rowg[descrizione]);
			//$out_value .= " - ".$rowg[output_mode];
		  $out_value .= "</div>";
		  $out_value .= "<div class=box_130_dx>";
			$out_value .= intval($rowg[quant]);
		  $out_value .= "</div>";
		  $out_value .= '<div class="box_130_dx" style="width: 100px; float: right; padding-right:0px;">';
			$out_value .= number_format($rowg[totale],2,",",".");
			$TOTALE_pl = $TOTALE_pl + $rowg[totale];
		  $out_value .= "</div>";
		$out_value .= "</div>";	
	  //fine while $sing_rdapl
	  }
	//fine foreach ($array_rda_pl as $sing_rdapl) {
	}

	$out_value .= "<div class=riga_separazione>";
	$out_value .= "</div>";	
  $gruppo_merci_uff = "";
  $out_value .= '<div class="contenitore_gruppo_merci" style="padding-left:0px; width:938px;">';
  $out_value .= '<div style ="width:105px; height:20px; margin-top:10px; float:right; padding-top:3px; text-align:right;">';
  $out_value .= 'euro '.number_format($TOTALE_pl,2,",",".");
  $out_value .= "</div>";	
  $out_value .= "<div style =\"width:60px; height:20px; margin-top:10px; float:right; padding-top:3px;\">";
  $out_value .= "Totale";
  $out_value .= "</div>";	
  $out_value .= "</div>";	
  //$out_value .= "</div>";	
  //fine singolo contenitore
  $out_value .= "</div>";	
  $TOTALE_pl = "";
  //FINE FOREACH PL
}
$totale_fattura = "";

  $n_ord_sap = "";
  $out_value .= "</div>";	
  //fine div glob_
  $out_value .= "</div>";	
$blocco_pl = '';
  //FINE FOREACH ORDINI SAP'
}

//PROCEDURA INSERIMENTO NUMERO ORDINE SAP
if ($check_ord == 1) {
		$logo = $venditore;
	$pp = "SELECT * FROM qui_company WHERE IDCompany = '$id_company'";
	$risultpp = mysql_query($pp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rowp = mysql_fetch_array($risultpp)) {
	  $nome_company = $rowp[Company];
	}
	$array_date_pl = array();
	foreach ($array_pl as $sing_pl) {
	  $rr = "SELECT * FROM qui_packing_list WHERE id = '$sing_pl' ORDER BY data_spedizione DESC";
	  $risultrr = mysql_query($rr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rowr = mysql_fetch_array($risultrr)) {
		if (!in_array($rowr[data_spedizione], $array_date_pl)) {
			$add_data = array_push($array_date_pl,$rowr[data_spedizione]);
		}
	  }
	  $sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE pack_list = '$sing_pl' AND azienda_prodotto = '$venditore'";
		$resultb = mysql_query($sumquery);
		list($somma) = mysql_fetch_array($resultb);
	  $totale_rdf = $totale_rdf + $somma;
	}
  
	//inserisco nuovo num fattura quice
	$data_fattura = $array_date_pl[0];
		$queryss = "INSERT INTO qui_RdF (id_company, nome_company, id_operatore, nome_operatore, totale_RdF, data_ordine, data_ultima_modifica, n_ord_sap, logo, data_fattura) VALUES ('$id_company', '$nome_company', '$_SESSION[user_id]', '$_SESSION[nome]', '$totale_rdf', '$data_attuale', '$data_attuale', '$n_ord', '$logo', '$data_fattura')";
		if (mysql_query($queryss)) {
		} else {
		  $out_value .= "Errore durante l'inserimento1". mysql_error();
		}
		$sqld = "SELECT * FROM qui_RdF ORDER BY id DESC LIMIT 1";
		$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigad = mysql_fetch_array($risultd)) {
		$n_rdf = $rigad[id];
		}
		
	//aggiorno packing list
	foreach ($array_pl as $sing_pl) {
		$query = "UPDATE qui_packing_list SET n_ord_sap = '$n_ord', id_fatt_quice = '$n_rdf' WHERE id = '$sing_pl'"; 
		if (mysql_query($query)) {
			//$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
		} else {
		$out_value .= "Errore durante l'inserimento1". mysql_error();
		}
		if ($n_ord != "") {
		$query = "UPDATE qui_righe_rda SET n_ord_sap = '$n_ord' WHERE pack_list = '$sing_pl' AND azienda_prodotto = '$venditore'"; 
		if (mysql_query($query)) {
			//$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
		} else {
		$out_value .= "Errore durante l'inserimento3". mysql_error();
		}
		}
	  }
	/*	
		if ($n_fatt != "") {
		$query = "UPDATE qui_packing_list SET n_fatt_sap = '$n_fatt' WHERE id = '$sing_pl'"; 
		  if (mysql_query($query)) {
			  //$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
		  } else {
		  $out_value .= "Errore durante l'inserimento2". mysql_error();
		  }
		}
	*/	
		//aggiorno anche le righe relative
		
		//*OPERAZIONI FINALI
		  include "traduzioni_interfaccia.php";
		  //costruzione testatina tabella dettagli rda x email
		  $tx_html .= "<table width=640 border=0 align=center cellpadding=1 cellspacing=0>";
		  $tx_html .= "<tr valign=top>";
		  $tx_html .= "<td class=table_mail_codice style=\"font-size:16px; font-weigth:bold;\">L'Ordine SAP ".$n_ord." &egrave; stato inserito.<br>E' possibile concludere il processo inserendo il numero della relativa fattura SAP</td>";
		  $tx_html .= "</tr>";
													  
		  //chiusura tabellina dettaglio rda
		  $tx_html .= "</table>";
		  //costruzione righe tabellina dettagli rda x invio email
		  
		  //RIPRISTINARE
		  $queryd = "SELECT * FROM qui_buyer_funzioni WHERE F_gestione_sap = '1' AND riceve_email_rda = '1' AND azienda = '$logo'";
		  $resultd = mysql_query($queryd);
		  while ($rowd = mysql_fetch_array($resultd)) {
		  $mail_destinatario = $rowd[mail];
		  }
		  
		  include "spedizione_mail_fatt.php";
		  $out_value .= '<div style="color:#ccc; font-size: 16px; font-weight: bold; text-align: center; width: 100%; padding-top: 15px; height: auto;">ODV '.$n_ord.' inserito. RdF trasmessa alla fatturazione.</div>';
  }




echo $out_value;
?>