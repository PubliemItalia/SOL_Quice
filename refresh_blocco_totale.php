<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$lingua = $_GET['lang'];


$ordinamento = "id_rda DESC";


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
if (isset($_GET['categoria_righe'])) {
$categ_DaModulo = $_GET['categoria_righe'];
} 
if ($categ_DaModulo != "") {
$b = "categoria = '$categ_DaModulo'";
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
if ($_GET['status'] != "") {
$statusDaModulo = $_GET['status'];
} 
if ($statusDaModulo != "") {
	switch ($statusDaModulo) {
		case "no_process":
		  $g = "output_mode = ''";
		break;
		case "sap":
		  $g = "output_mode = 'sap'";
		break;
		case "mag":
		  $g = "output_mode = 'mag' AND evaso_magazzino = '0'";
		break;
		case "mag_evaso":
		  $g = "output_mode = 'mag' AND evaso_magazzino = '1'";
		break;
		case "ordine":
		  $g = "output_mode = 'ord'";
		break;
	}
$clausole++;
}
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 
//$tab_output .= "shopDaModulo: ".$shopDaModulo."<br>";

//costruzione query
//ogni buyer ha alcuni negozi da gestire e sono indicati nella tabella "qui_buyer_negozi"
//ATTENZIONE: lo switch qui sotto serve perchè se nei filtri viene specificato il negozio, la ricerca va fatta solo su quello, e la tabella deve essere esclusa
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '".$_SESSION[user_id]."' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
	$num_negozi_buyer = mysql_num_rows($risultt);
	$z = 1;
    while ($rigat = mysql_fetch_array($risultt)) {
	  if ($z == 1) {
		$blocco_negozi_buyer .= "(negozio = '".$rigat[negozio]."'";
	  } else {
		$blocco_negozi_buyer .= " OR negozio = '".$rigat[negozio]."'";
	  }
	  $z = $z+1;
	  if ($z > $num_negozi_buyer) {
		$blocco_negozi_buyer .= ")";
	  }
	}
if ($clausole > 0) {
  if ($shopDaModulo != "") {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
	$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
  } else {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '3') AND ";
	$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '3') AND ";
  }
  if ($clausole == 1) {
	if ($a != "") {
	  $testoQuery .= $a;
	  $sumquery .= $a;
	}
	if ($b != "") {
	  $testoQuery .= $b;
	  $sumquery .= $b;
	}
	if ($c != "") {
	  $testoQuery .= $c;
	  $sumquery .= $c;
	}
	if ($d != "") {
	  $testoQuery .= $d;
	  $sumquery .= $d;
	}
	if ($e != "") {
	  $testoQuery .= $e;
	  $sumquery .= $e;
	}
	if ($f != "") {
	  $testoQuery .= $f;
	  $sumquery .= $f;
	}
	if ($g != "") {
	  $testoQuery .= $g;
	  $sumquery .= $g;
	}
  } else {
	if ($a != "") {
	  $testoQuery .= $a." AND ";
	  $sumquery .= $a." AND ";
	}
	if ($b != "") {
	  $testoQuery .= $b." AND ";
	  $sumquery .= $b." AND ";
	}
	if ($c != "") {
	  $testoQuery .= $c." AND ";
	  $sumquery .= $c." AND ";
	}
	if ($d != "") {
	  $testoQuery .= $d." AND ";
	  $sumquery .= $d." AND ";
	}
	if ($e != "") {
	  $testoQuery .= $e." AND ";
	  $sumquery .= $e." AND ";
	}
	if ($f != "") {
	  $testoQuery .= $f." AND ";
	  $sumquery .= $f." AND ";
	}
	if ($g != "") {
	  $testoQuery .= $g;
	  $sumquery .= $g;
	}
  }
} else {
  $testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '3')";
  $sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '3')";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
$lungsum = strlen($sumquery);
$finale_sum = substr($sumquery,($lungsum-5),5);
if ($finale_sum == " AND ") {
$sumquery = substr($sumquery,0,($lungsum-5));
}

//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//$tab_output .= "limit in errore<br>";
     $limit = 25; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//$tab_output .= "page in errore<br>";
      $page = 1; //default
 } 

//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito più sotto
$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);


//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento;
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;
//$tab_output .= "testoQuery: ".$testoQuery."<br>";
//$tab_output .= "sumquery: ".$sumquery."<br>";



  $array_rda = array();
  $array_rda_completate = array();
	$num_rda_titolo = "";
//**********************
//solo per buyer
//************************
 $querya = $testoQuery;

//inizia il corpo della tabella
$result = mysql_query($querya);
//inizio while RDA
while ($row = mysql_fetch_array($result)) {
	$discrim = "0";
  if ($row[output_mode] == "") {
	$discrim = "1";
  } else {
  if (($row[output_mode] == "mag") AND ($row[evaso_magazzino] == "0")) {
	$discrim = "1";
  }
  }
  //$tab_output .= "RdA ".$row[id_rda]." - discrim:".$discrim."<br>";
  if ($discrim == "1") {
	if (!in_array($row[id_rda],$array_rda)) {
	$add_rda = array_push($array_rda,$row[id_rda]);
	}
  } else {
	if ($row[nazione] == "italy") {
		$flag_sap = "ok";
	} else {
		$flag_sap = "";
	}
	if ($row[output_mode] != "sap") {
	if ($row[output_mode] != "lab") {
$query = "UPDATE qui_righe_rda SET id_buyer = '$_SESSION[user_id]', flag_chiusura = '1', stato_ordine = '4', n_ord_sap = '$flag_sap', n_fatt_sap = '$flag_sap' WHERE id = '$row[id]'";
	} else {
	}
	} else {
$query = "UPDATE qui_righe_rda SET id_buyer = '$_SESSION[user_id]', stato_ordine = '4' WHERE id = '$row[id]'";
	}
	if (mysql_query($query)) {
	} else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}
/*	*/
	if (!in_array($row[id_rda],$array_rda_completate)) {
	$add_rda = array_push($array_rda_completate,$row[id_rda]);
	}
  }
}
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">array_rda: ";
//print_r($array_rda);
//$tab_output .= "<br>";
foreach ($array_rda_completate as $sing_rda_completa) {
  $m = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	if ($rigam[nazione] == "italy") {
		$flag_sap = "ok";
	} else {
		$flag_sap = "";
	}
  }
  $g = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_completa'";
  $risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tot_righe_rda = mysql_num_rows($risultg);
  //$tab_output .= "RdA ".$sing_rda." - Righe in tutto:".$tot_righe_rda."<br>";
  $d = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_completa' AND stato_ordine = '4'";
  $risultd = mysql_query($d) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tot_righe_rda_evase = mysql_num_rows($risultd);
  //$tab_output .= "RdA ".$sing_rda." - Righe evase:".$tot_righe_rda_evase."<br>";
  if ($tot_righe_rda_evase == $tot_righe_rda) {
	$query = "UPDATE qui_rda SET buyer_output = '$id_buyer', id_buyer = '$id_buyer', nome_buyer = '$nome_buyer', data_chiusura = '$data_chiusura', data_ultima_modifica = '$data_chiusura', stato = '4', n_ord_sap = '$flag_sap', n_fatt_sap = '$flag_sap' WHERE id = '$sing_rda_completa'";
	if (mysql_query($query)) {
	} else {
	  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}
	//inserimento nel LOG
	$riepilogo = "Chiusura automatica rda (".$sing_rda_completa.") utente ".$id_utente;
	$datalog = mktime();
	$datalogtx = date("d.m.Y H:i",$datalog);
	$operatore = $nome_sessione;
	$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
	if (mysql_query($queryb)) {
	} else {
	  $tab_output .= "Errore durante l'inserimento". mysql_error();
	}
  }
}
//INIZIO OUTPUT BLOCCO SING RDA

foreach ($array_rda as $sing_rda) {
 if ($sing_rda != $num_rda_titolo) {
$sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
$ut_rda = "<img src=immagini/spacer.gif width=25 height=2>Utente ".stripslashes($rigay[nome_utente])."<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
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
$tab_output .= "<div class=cont_rda id=glob_".$sing_rda." >";
//inizio div riassunto rda
$tab_output .= "<div class=riassunto_rda>";
$sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
$resultm = mysql_query($sqlm);
$num_righeXDim = mysql_num_rows($resultm);
$altezza_finestra = ($num_righeXDim*37)+125+180;
if ($altezza_finestra > 700) {
	$altezza_finestra = 700;
}

	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda.php?report=1&a=1&pers=&id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40'})\">";
$tab_output .= "<div class=ind_num_rda>";
$tab_output .= "RDA ".$sing_rda;
$tab_output .= "</div>";
$tab_output .= "</a>";
$tab_output .= "<div class=riepilogo_rda onClick=\"vis_invis(".$sing_rda.")\">";
if ($tipo_negozio != "assets") {
//$tab_output .= "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
$tab_output .= $tracciati_sap.$ut_rda;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
//$tab_output .= "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
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
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine != '4'";
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
if ($g != "") {
$sqlk .= " AND ".$g;
}
}
$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
if ($rigak[output_mode] != "mag") {
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
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$sing_rda.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	} else {
	$tooltip_select = "Deseleziona tutto";
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$sing_rda.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	}
  }
}

$Num_righe_rda_selezionate = "";

$tab_output .= "<div class=sel_all style=\"width:30px;\">";
//if ($Num_righe_processate < $Num_righe_rda) {
//$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'gestione_evasione_rda.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$sing_rda.")}})\"><img src=immagini/visione_righe.png width=17 height=17 border=0 title=".$visualizza_dettaglio."></a>";
//}
$tab_output .= "</div>";

if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= "<div id=bott_multi_".$sing_rda." class=sel_all style=\"width:35px; padding-left:25px; color:rgb(255,255,255);\">";
if ($flag_ricerca != "") {
} else {
$tab_output .= $bottone_immagine;
}
} else {
$tab_output .= "<div class=sel_all style=\"width:60px; color:rgb(255,255,255);\">";
$tab_output .= "in attesa";
}
$tab_output .= "</div>";
}
$tab_output .= "</div>";


//inizio div rda
if ($Num_righe_evadere == $Num_righe_rda) {
$tab_output .= "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
} else {
$tab_output .= "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:block;\">";
}
//$tab_output .= "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine != '4'";
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
if ($g != "") {
$sqln .= " AND ".$g;
}
}
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
if ($sf == 1) {
//inizio contenitore riga
$tab_output .= "<div class=columns_righe2>";
} else {
$tab_output .= "<div class=columns_righe1>";
}
//div codice riga
$tab_output .= "<div id=confez5_riga style=\"padding-left:10px;\">";
if (substr($rigan[codice_art],0,1) != "*") {
  $tab_output .= $rigan[codice_art];
} else {
  $tab_output .= substr($rigan[codice_art],1);
}
//fine div codice riga
$tab_output .= "</div>";

//div descrizione riga
$tab_output .= '<div class="descr4_riga" style="width:400px;">';
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
$tab_output .= $rigan[quant];
$tab_output .= "</div>";
//div pulsante per evasione parziale riga
$tab_output .= "<div class=lente_prodotto>";
if (($rigan[output_mode] == "") AND ($rigan[flag_buyer] == "1")) {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";
//div pulsante per visualizzare scheda
$tab_output .= "<div class=lente_prodotto>";
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	if ($rigam[categoria1_it] == "Bombole") {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
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
$tab_output .= strtoupper($rigan[output_mode]);
//fine div output mode riga
$tab_output .= "</div>";

$sqlc = "SELECT * FROM qui_rda WHERE id='".$rigan[id_rda]."'";
$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$rda_exist = mysql_num_rows($risultc);	
//div evaso (vuoto)
$tab_output .= "<div class=vuoto9_riga style=\"width:32px;\">";
if ($rda_exist > 0) {
if ($rigan[evaso_magazzino] == 1) {
$tab_output .= " evaso";
}
} else {
$tab_output .= "<a href=\"mailto:adv@publiem.it?bcc=publiem@publiem.it&Subject=Qui C'e', problema con RdA".$sing_rda."\"><span style=\"color:red; text-decoration:none; font-weight:bold;\">Contattare<br>webmaster</span></a>";
}
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
if ($rigan[output_mode] == "") {
if ($rda_exist > 0) {
switch ($rigan[flag_buyer]) {
case "0":
  $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.");\">";
break;
case "1":
$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.");\">";
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
//div riga grigia separatrice
$tab_output .= "<div class=riga_divisoria>";
$tab_output .= "</div>";


$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";

//div per note e pulsanti processi
$tab_output .= "<div class=servizio>";
$tab_output .= "<div class=note_pregresse>";
  $tab_output .= "<div class=note>";
	if ($note_buyer != "") {
	 $tab_output .= "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">".$note_buyer."</textarea>";
	} else {
	 $tab_output .= "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">Note</textarea>";
	}
  $tab_output .= "</div>";
  $tab_output .= "<div class=messaggio id=mess_".$sing_rda." title=mess_".$sing_rda.">";
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
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$sing_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_ordini = mysql_num_rows($risultp);
if ($num_ordini > 0) {
$tab_output .= "<div id=ordini_".$sing_rda." class=puls_servizio style=\"height:auto; border-bottom:1px solid #CCC;\">";
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
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$sing_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\">";
$tab_output .= "<div class=puls_servizio>";
//$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$sing_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
$tab_output .= "Stampa RdA";
//$tab_output .= "<br>E:".$Num_righe_evadere;
//$tab_output .= "<br>T:".$Num_righe_rda."<br>";
$tab_output .= "</div></a>";
//$tab_output .= "Num_righe_evadere: ".$Num_righe_evadere."<br>";
//$tab_output .= "Num_righe_rda: ".$Num_righe_rda."<br>";
if ($Num_righe_evadere == $Num_righe_rda) {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"chiusura('".$sing_rda."')\"><div class=puls_servizio>";
//$tab_output .= "<a href=ordini.php><div class=puls_servizio>";
	$tab_output .= "<div class=btnFrecciaRed><strong>Chiudi RdA</strong></div>";
$tab_output .= "</div></a>";
}
}
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

$tab_output .= "<div id=puls_processa_".$sing_rda.">";
//if ($flag_ricerca == "") {
  if ($contatore_righe_flag > 0) {
//	$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$sing_rda.")}})\"><strong>Processa RdA</strong></a></div>";
	$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$sing_rda.")}})\"><strong>Processa RdA</strong></a></div>";
  }
//}
$tab_output .= "</div>";
//fine blocco pulsantini a destra
$tab_output .= "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
/*			$tab_output .= "<a href=# onClick=\"this.form.submit()\"><div class=btnFreccia>";
		$tab_output .= "<strong>Processa RdA</strong>";
		$tab_output .= "</div></a>";
*/

//fine blocco sing rda
$tab_output .= "</div>";
$tab_output .= "</div>";
//fine contenitore esterno sing rda
$tab_output .= "</div>";
}




//riga del totale generale
$tab_output .= "<div class=columns_righe2>";
//div num rda riga
$tab_output .= "<div class=cod1_riga>";
//fine div num rda riga
$tab_output .= "</div>";
//div data riga
$tab_output .= "<div class=cod1_riga>";
//fine div data riga
$tab_output .= "</div>";
//div codice riga
$tab_output .= "<div id=confez5_riga>";
//fine div codice riga
$tab_output .= "</div>";
//div descrizione riga
$tab_output .= "<div class=descr4_riga>";
//fine div descrizione riga
$tab_output .= "</div>";
//div nome unità riga
$tab_output .= "<div class=cod1_riga>";
//fine div nome unità riga
$tab_output .= "</div>";
//div quant riga
$tab_output .= "<div class=price6_riga_quant>";
$tab_output .= "<strong>TOTALE</strong>";
$tab_output .= "</div>";
//div totale riga
$tab_output .= "<div class=price6_riga style=\"width:75px;\">";
$tab_output .= number_format($totale_storico_rda,2,",",".");
//fine div totale riga
$tab_output .= "</div>";
//div output mode riga (vuoto)
$tab_output .= "<div class=vuoto9_riga>";
//fine div output mode riga
$tab_output .= "</div>";
//div evaso (vuoto)
$tab_output .= "<div class=vuoto9_riga>";
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=vuoto9_riga style=\"width:32px;\">";
//fine div checkbox
$tab_output .= "</div>";

//fine contenitore totale
$tab_output .= "</div>";




//output finale

//$tab_output .= "pippo";
echo $tab_output;



 ?>
