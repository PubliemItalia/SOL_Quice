<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$dest = $_GET['dest'];
$layout = $_GET['layout'];
$singola = $_GET['singola'];
$multipla = $_GET['multipla'];
$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];

//procedura per il buyer
  if ($singola == 1) {
	if ($check == "0") {
	$id_buyer = "";
	} else {
	  $id_buyer = $_GET['id_utente'];
	}
	  
	$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
	if (mysql_query($query)) {
	} else {
	  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}
  }

if ($multipla == 1) {
  if ($check == "0") {
	$id_buyer = "";
  } else {
	$id_buyer = $_GET['id_utente'];
  }

  $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$id_rda' AND output_mode = '' AND stato_ordine = '2'";
  if (mysql_query($query)) {
  } else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
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
if (isset($_GET['data_inizio'])) {
$data_inizio = $_GET['data_inizio'];
} 
if (isset($_GET['data_fine'])) {
$data_fine = $_GET['data_fine'];
} 
if ($data_inizio != "") {
if ($data_fine == "") {
$data_fine = date("d/m/Y",mktime());
}
}
if ($data_fine != "") {
if ($data_inizio == "") {
$pezzi_data_fine = explode("/",$data_fine);
$data_inizio = "01/".$pezzi_data_fine[1]."/".$pezzi_data_fine[2];
}
}
if ($data_inizio != "") {
$pieces_inizio = explode("/", $data_inizio);
$gginizio = $pieces_inizio[0]; 
$mminizio = $pieces_inizio[1];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
$ggfine = $pieces_fine[0]; 
$mmfine = $pieces_fine[1];
$aaaafine = $pieces_fine[2];
$fine_range = mktime(23,59,59,intval($mmfine), intval($ggfine), intval($aaaafine));
}
if (($inizio_range != "") AND ($fine_range != "")) {
if ($inizio_range > $fine_range) {
$campidate = "";
} else {
$campidate = 1;
$c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = "";
}
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
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
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 



//INIZIO OUTPUT BLOCCO SING RDA

//if ($id_rda != $num_rda_titolo) {
  $sqly = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
  $risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione09" . mysql_error());
  while ($rigay = mysql_fetch_array($risulty)) {
	$ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d.m.Y",$rigay[data_inserimento])."<img src=immagini/spacer.gif width=25 height=2>";
	if ($rigay[id_utente] == $rigay[id_resp]) {
	  $ut_rda .= "Ut./Resp. ".stripslashes($rigay[nome_utente]);
	} else {
	  $ut_rda .= "Ut. ".stripslashes($rigay[nome_utente])." - Resp. ".stripslashes($rigay[nome_resp]);
	}
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
  $querys = "SELECT * FROM qui_files_sap WHERE id_rda = '$id_rda'";
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
  //$tab_output .= "<div class=cont_rda id=glob_".$id_rda." >";
  //inizio div riassunto rda
  $tab_output .= "<div class=riassunto_rda>";
  $sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
  $resultm = mysql_query($sqlm);
  $num_righeXDim = mysql_num_rows($resultm);
  $altezza_finestra = ($num_righeXDim*37)+125+180;
  if ($altezza_finestra > 800) {
	  $altezza_finestra = 800;
  }

  $tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda.php?report=1&a=1&pers=&id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40'})\">";
  $tab_output .= "<div class=ind_num_rda style=\"cursor:pointer;\">";
  $tab_output .= "RDA ".$id_rda;
  $tab_output .= "</div>";
  $tab_output .= "</a>";
  $tab_output .= "<div class=riepilogo_rda onClick=\"vis_invis(".$id_rda.")\">";
  if ($tipo_negozio != "assets") {
	//$tab_output .= "RDA ".$id_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
	$tab_output .= $ut_rda.$tracciati_sap;
  } else {
	$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
	$output_wbs .= " (".$wbs_visualizzato.")";
	//$tab_output .= "RDA ".$id_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
	$tab_output .= $output_wbs.$ut_rda;
  }
  $wbs_visualizzato = "";
  $output_wbs = "";
  $ut_rda = "";
  $tab_output .= "</div>";
  $tab_output .= "<div class=stato_rda>";
  $tab_output .= $imm_status;
  $tab_output .= "</div>";
  $tracciati_sap = "";
   $sf = 1;
  
  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine != '4'";
  //$tab_output .= '<span style="color:#000;">sqlk: '.$sqlk.'<br>';
  $risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione11" . mysql_error());
  $Num_righe_rda = mysql_num_rows($risultk);
  while ($rigak = mysql_fetch_array($risultk)) {
	if ($rigak[flag_buyer] == 1) {
	  $Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
	}
	if ($rigak[output_mode] != "") {
	  //if ($rigak[flag_buyer] >= 2 AND $rigak[evaso_magazzino] == 1) {
	  if ($rigak[flag_buyer] >= 2) {
		$Num_righe_processate = $Num_righe_processate + 1;
	  }
	}
	if ($rigak[output_mode] != "") {
	  if (($rigak[output_mode] != "mag") && ($rigak[output_mode] != "lab")) {
		$Num_righe_evadere = $Num_righe_evadere + 1;
	  } else {
		if ($rigak[evaso_magazzino] == 1) {
		$Num_righe_evadere = $Num_righe_evadere + 1;
		}
	  }
	}

  if ($flag_ricerca != "") {
  } else {
	if ($Num_righe_rda_selezionate != $Num_righe_rda) {
	  $tooltip_select = "Seleziona tutto";
	  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	} else {
	  $tooltip_select = "Deseleziona tutto";
	  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	}
  }
}

$Num_righe_rda_selezionate = "";

$tab_output .= '<div class="sel_all" style="width:11px;">';
//if ($Num_righe_processate < $Num_righe_rda) {
//$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'gestione_evasione_rda.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$id_rda.")}})\"><img src=immagini/visione_righe.png width=17 height=17 border=0 title=".$visualizza_dettaglio."></a>";
//}
$tab_output .= "</div>";

if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= '<div id="bott_multi_"'.$id_rda.'" class="sel_all" style="width:25px; padding-left:10px; color:rgb(255,255,255);">';
if ($flag_ricerca != "") {
} else {
$tab_output .= $bottone_immagine;
}
} else {
$tab_output .= "<div class=sel_all style=\"width:60px; color:rgb(255,255,255);\">";
$tab_output .= "in attesa";
}
$tab_output .= "</div>";
//}
$tab_output .= "</div>";
//fine div riassunto rda
//inizio div testatina nuova
$tab_output .= '<div id=testatina_'.$id_rda.' class="cont_rda" style="background-color: #CDE5E3; padding: 2px 0px; color: #444 !important; min-height:10px; overflow: hidden: height: auto; font-size:8px; letter-spacing: 1px;">';
  $tab_output .= '<div class="confez5_riga" style="width: 55px; height:7px; padding-left:20px; float: left;color: #444 !important; ">
	CODICE
  </div>
  <div class="descr4_riga" style="width:378px; height:7px; padding-top: 0px;color: #444 !important; ">
	DESCRIZIONE
  </div>
  <div class="cod1_riga" style="height:7px; padding-top: 0px;color: #444 !important; ">
	UNIT&Agrave;
  </div>
  <div class="price6_riga_quant" style="height:7px; padding-top: 0px;color: #444 !important; ">
	QUANTIT&Agrave;
  </div>
  <div class="lente_prodotto" style="height:7px; padding-top: 0px;color: #444 !important; ">
  </div>
  <div class="lente_prodotto" style="height:7px; padding-top: 0px;color: #444 !important; ">
	DETTAGLI
  </div>
  <div class="price6_riga" style="height:7px; padding-top: 0px;color: #444 !important; ">
	COSTO TOTALE
  </div>
</div>';
//fine div testatina nuova


//inizio div rda
if ($Num_righe_evadere == $Num_righe_rda) {
$tab_output .= "<div id=blocco_rda_".$id_rda." class=cont_rda style=\"display:none;\">";
} else {
$tab_output .= "<div id=blocco_rda_".$id_rda." class=cont_rda style=\"display:block;\">";
}
//$tab_output .= "<div id=blocco_rda_".$id_rda." class=cont_rda style=\"display:none;\">";
$queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_rda_completa = $somma;
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine != '4'";
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
if ($sf == 1) {
//inizio contenitore riga
$tab_output .= "<div class=columns_righe2>";
} else {
$tab_output .= "<div class=columns_righe1>";
}
//div codice riga
if ($rigan[categoria] == "Bombole") {
	$tab_output .= '<a href="riepilogo_bombola.php?cod='.$rigan[codice_art].'" target="_blank">';
}
$tab_output .= '<div id="confez5_riga" style="padding-left:10px;">';
$tab_output .= '<span style="color:black;">';
if (substr($rigan[codice_art],0,1) != "*") {
  $tab_output .= $rigan[codice_art];
} else {
  $tab_output .= substr($rigan[codice_art],1);
}
$tab_output .= '</span>';
//fine div codice riga
$tab_output .= "</div>";
if ($rigan[categoria] == "Bombole") {
	$tab_output .= "</a>";
}

//div descrizione riga
$tab_output .= '<div class="descr4_riga" style="width:378px;">';
$tab_output .= $rigan[descrizione];
//fine div descrizione riga
$tab_output .= "</div>";


//div nome unità riga
$tab_output .= '<div class="cod1_riga" style="width:70px;">';
$tab_output .= $rigan[nome_unita];
//fine div nome unità riga
$tab_output .= "</div>";
//div quant riga
$tab_output .= '<div class="price6_riga_quant" style="width:70px;">';
$tab_output .= intval($rigan[quant]);
$tab_output .= "</div>";
//div pulsante per evasione parziale riga

$tab_output .= '<div class="lente_prodotto" style="width:30px;">';
if (($rigan[output_mode] == "") AND ($rigan[flag_buyer] == "1")) {
  if (($rigan[negozio] == "labels") AND ($label_ric_mag != "mag")) {
  } else {
	  $tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
}
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";
//div pulsante per visualizzare scheda
$tab_output .= '<div class="lente_prodotto" style="width:30px;">';
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	$giacenza = $rigam[giacenza];
	if ($rigam[categoria1_it] == "Bombole") {
  $tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigam[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
//fine div pulsante per visualizzare scheda
$tab_output .= "</div>";
//div totale riga
$tab_output .= '<div class="price6_riga" style="width:100px;">';
$tab_output .= number_format($rigan[totale],2,",",".");
$totale_rda = $totale_rda + $rigan[totale];
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
case "lab":
$button_style = "style_lab";
break;
}
$tab_output .= '<div class="'.$button_style.'" style="width:42px;">';
$tab_output .= strtoupper($rigan[output_mode]);
//fine div output mode riga
$tab_output .= "</div>";

$sqlc = "SELECT * FROM qui_rda WHERE id='".$rigan[id_rda]."'";
$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione15" . mysql_error());
$rda_exist = mysql_num_rows($risultc);	
//div evaso (vuoto)
$tab_output .= '<div class="vuoto9_riga" style="width:32px;">';
if ($rda_exist > 0) {
if ($rigan[evaso_magazzino] == 1) {
$tab_output .= " evaso";
}
} else {
$tab_output .= "<a href=\"mailto:adv@publiem.it?bcc=publiem@publiem.it&Subject=Qui C'e', problema con RdA".$id_rda."\"><span style=\"color:red; text-decoration:none; font-weight:bold;\">Contattare<br>webmaster</span></a>";
}
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= '<div class="sel_all_riga" id="'.$rigan[id].'" style="width:20px; padding-top: 0px;">';
if ($rigan[output_mode] == "") {
if ($rda_exist > 0) {
switch ($rigan[flag_buyer]) {
case "0":
  $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$id_rda.");\">";
break;
case "1":
$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$id_rda.");\">";
$contatore_righe_flag = $contatore_righe_flag + 1;
  break;
}
}
} else {
if ($rigan[flag_buyer] > 1) {
$contatore_x_chiusura = $contatore_x_chiusura + 1;
}

}
//fine div checkbox
$tab_output .= "</div>";
$tab_output .= '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
$tab_output .= '<div class="sel_all_riga" style="padding-top: 2px; width:40px; padding-left:10px;">';
//$tab_output .= 'neg: '.$rigan[negozio].'<br>';
switch ($rigan[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $tab_output .= '<img src="immagini/bottone-vivisol.png" style="margin-bottom:5px;">';
	break;
	case "SOL":
	  $tab_output .= '<img src="immagini/bottone-sol.png" style="margin-bottom:5px;">';
	break;
}
$tab_output .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
$giacenza = "";
$tab_output .= "</div>";
$tab_output .= "</a>";
$rda_exist = "";
//fine contenitore riga tabella
$tab_output .= "</div>";

//fine foreach
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}

//div riga bianca con totali
$tab_output .= '<div class="columns_righe2" style="font-weight:bold; border-bottom:1px solid;">';
//div codice riga
$tab_output .= '<div id="confez5_riga" style="padding-left:10px;">';
$tab_output .= "</div>";
//div descrizione riga
$tab_output .= '<div class="descr4_riga" style="width:400px;">';
$tab_output .= "</div>";
//div nome unità riga
$tab_output .= '<div class="cod1_riga">';
$tab_output .= "</div>";
//div quant riga
$tab_output .= '<div class="price6_riga_quant">';
$tab_output .= "</div>";
//div pulsante per evasione parziale riga
$tab_output .= '<div class="lente_prodotto">';
$tab_output .= "</div>";
//div pulsante per visualizzare scheda
$tab_output .= '<div class="lente_prodotto">';
$tab_output .= 'Totale';
$tab_output .= "</div>";
//div totale riga
$tab_output .= '<div class="price6_riga">';
$tab_output .= '<strong>&euro; '.number_format($totale_rda,2,",",".").'</strong>';
$tab_output .= "</div>";
//div output mode riga (vuoto)
$tab_output .= '<div class="'.$button_style.'">';
$tab_output .= "</div>";
//div evaso (vuoto)
$tab_output .= '<div class="vuoto9_riga" style="width:32px;">';
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= '<div class="sel_all_riga" id="'.$rigan[id].'">';
$tab_output .= "</div>";


$tab_output .= "</div>";
//div riga grigia separatrice
$tab_output .= "<div class=riga_divisoria>";
$tab_output .= "</div>";


$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";
$totale_rda_completa = "";
$somma = "";
//div per note e pulsanti processi
$tab_output .= "<div class=servizio>";
$tab_output .= "<div class=note_pregresse>";
  $tab_output .= "<div class=note>";
	if ($note_buyer != "") {
	 $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.");\">".$note_buyer."</textarea>";
	} else {
	 $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.");\">Note</textarea>";
	}
  $tab_output .= "</div>";
  $tab_output .= "<div class=messaggio id=mess_".$id_rda." title=mess_".$id_rda.">";
	if ($note_utente != "") {
	  $tab_output .= "Utente ".stripslashes($nome_utente_rda).": <strong>".$note_utente."</strong><br>";
	}
	if ($note_resp != "") {
	  $tab_output .= "Responsabile ".stripslashes($nome_resp_rda).": <strong>".$note_resp."</strong><br>";
	}
	if ($note_magazziniere != "") {
	  $tab_output .= "Magazziniere: <strong>".$note_magazziniere."</strong><br>";
	}
  $tab_output .= "</div>";
$tab_output .= "</div>";

$tab_output .= "<div style=\"height:auto; width:150px; float:left;\">";
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione16" . mysql_error());
$num_ordini = mysql_num_rows($risultp);
if ($num_ordini > 0) {
$tab_output .= "<div id=ordini_".$id_rda." class=puls_servizio style=\"height:auto; border-bottom:1px solid #CCC;\">";
while ($rigap = mysql_fetch_array($risultp)) {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('ordine_fornitore.php?id_ord=".$rigap[id]."&id_rda=".$rigap[id_rda]."&lang=".$lingua."', 'myPop1',800,800);\">";
if ($rigap[ordine_interno] != "") {
$tab_output .= "Ordine ".$rigap[ordine_interno];
} else {
$tab_output .= "Ordine ".$rigap[id];
}
$tab_output .= "</a><br>";

}
$tab_output .= "</div>";
}
if ($flag_ricerca == "") {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$id_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\">";
$tab_output .= "<div class=puls_servizio>";
//$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$id_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
$tab_output .= "Stampa RdA";
//$tab_output .= "<br>E:".$Num_righe_evadere;
//$tab_output .= "<br>T:".$Num_righe_rda."<br>";
$tab_output .= "</div></a>";
//$tab_output .= "Num_righe_evadere: ".$Num_righe_evadere."<br>";
//$tab_output .= "Num_righe_rda: ".$Num_righe_rda."<br>";
if ($Num_righe_evadere == $Num_righe_rda) {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"chiusura('".$id_rda."')\"><div class=puls_servizio>";
//$tab_output .= "<a href=ordini.php><div class=puls_servizio>";
	$tab_output .= "<div class=btnFrecciaRed><strong>Chiudi RdA</strong></div>";
$tab_output .= "</div></a>";
}
}
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

$tab_output .= "<div id=puls_processa_".$id_rda.">";
  if ($contatore_righe_flag > 0) {
	$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){ripristino_riga(".$id_rda.")}})\"><strong>Processa RdA</strong></a></div>";
  }
$tab_output .= "</div>";
//fine blocco pulsantini a destra
$tab_output .= "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine blocco sing rda
$tab_output .= "</div>";
$tab_output .= "</div>";
//fine contenitore esterno sing rda
//$tab_output .= "</div>";



//output finale

echo $tab_output;

//$tab_output .= "pippo";



 ?>
