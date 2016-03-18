<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$pl = $_GET['pl'];
$id_magazz = $_GET['id_utente'];
$lingua = $_GET['lang'];
$data_attuale = mktime();
$query = "UPDATE qui_righe_rda SET flag_buyer = '2', evaso_magazzino = '1', id_magazz = '$id_magazz', data_ultima_modifica = '$data_attuale' WHERE pack_list = '$pl' AND flag_buyer = '3' AND output_mode = 'mag'";
if (mysql_query($query)) {
} else {
$tab_output .= "Errore durante l'inserimento: ".mysql_error();
}

$ordinamento = "data_inserimento DESC";
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
$codice_artDaModulo = "*".$_GET['codice_art'];
} else {
$codice_artDaModulo == "";
} 
if ($codice_artDaModulo != "") {
$f = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 


//costruzione query
if ($clausole > 0) {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0' AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0' AND ";

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
$testoQuery .= $f;
$sumquery .= $f;
}
}
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
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
//$tab_output .= "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////





    $array_rda = array();
      $num_rda_titolo = "";
  //**********************
  //solo per buyer
  //************************
   $querya = $testoQuery;
  
  //inizia il corpo della tabella
  $result = mysql_query($querya);
  //inizio while RDA
  while ($row = mysql_fetch_array($result)) {
  if (!in_array($row[id_rda],$array_rda)) {
  $add_rda = array_push($array_rda,$row[id_rda]);
  }
  }
  /*$tab_output .= "array_rda: ";
  print_r($array_rda);
  $tab_output .= "<br>";
  */
  foreach ($array_rda as $sing_rda) {
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
  $note_utente = stripslashes($rigay[note_utente]);
  $nome_utente_rda = stripslashes($rigay[nome_utente]);
  $note_resp = stripslashes($rigay[note_resp]);
  $nome_resp_rda = stripslashes($rigay[nome_resp]);
  $nome_buyer_rda = stripslashes($rigay[nome_buyer]);
  $note_buyer = stripslashes($rigay[note_buyer]);
  $note_magazziniere = str_replace("<br>","\n",stripslashes($rigay[note_magazziniere]));
  }
  $tab_output .= "<div id=generale_".$sing_rda." class=cont_rda>";
	$tab_output .= '<div style="width: 100%; min-height: 30px; overflow: hidden; height: auto; background-color: #97b4b5;">';
	$tab_output .= "<div class=riassunto_rda>";
	$tab_output .= "RDA ".$sing_rda.$ut_rda;
	$tab_output .= "</div>";
	$tab_output .= "<div class=stato_rda>";
	$tab_output .= $imm_status;
	$tab_output .= "</div>";
	 $sf = 1;
	 $ut_rda = "";
  
	//determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
	$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = 'mag' AND evaso_magazzino = '0'";
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
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi_mag(".$sing_rda.",3);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	} else {
	$tooltip_select = $tooltip_deseleziona_tutto;
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi_mag(".$sing_rda.",2);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	}
	
	
	$tab_output .= "<div class=sel_all>";
	if ($flag_ricerca == "") {
	  if ($Num_righe_processate < $Num_righe_rda) {
	  $tab_output .= $bottone_immagine;
	  }
	}
	$tab_output .= "</div>";
  $tab_output .= "</div>";
  //$tab_output .= "righe totali: ".$Num_righe_rda."<br>";
  //$tab_output .= "righe da evadere: ".$Num_righe_evadere."<br>";
  $Num_righe_rda_selezionate = "";
  $Num_righe_evadere = "";
  $Num_righe_rda = "";
  //inizio div rda
  $tab_output .= "<div class=cont_rda id=blocco_rda_".$sing_rda.">";
  
  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = 'mag' AND evaso_magazzino = '0'";
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
  $tab_output .= "<div class=descr4_riga style=\"width:384px;\">";
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
if (($rigan[output_mode] == "mag") AND ($rigan[flag_buyer] == "3")) {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";
//div pulsante per visualizzare scheda
  $tab_output .= "<div class=lente_prodotto>";
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  //fine div pulsante per visualizzare scheda
  $tab_output .= "</div>";
  //div totale riga
  $tab_output .= "<div class=price6_riga>";
  $tab_output .= number_format($rigan[totale],2,",",".");
  //fine div totale riga
  $tab_output .= "</div>";
  
  //div output mode riga (vuoto)
  $tab_output .= "<div class=vuoto9_riga style=\"width:65px;\">";
  $tab_output .= $rigan[output_mode];
  //fine div output mode riga
  $tab_output .= "</div>";

  //div checkbox (vuoto)
  $tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
  if ($rigan[evaso_magazzino] == 0) {
    /*if ($flag_ricerca != "") {
      switch ($rigan[flag_buyer]) {
        case "2":
          $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'3',".$sing_rda.");\">";
        break;
        case "3":
          $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'2',".$sing_rda.");\">";
        break;
      }
    } else {*/
      switch ($rigan[flag_buyer]) {
        case "2":
          $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc_mag(".$rigan[id].",'3',".$sing_rda.");\">";
        break;
        case "3":
          $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc_mag(".$rigan[id].",'2',".$sing_rda.");\">";
          $contatore_righe_flag = $contatore_righe_flag + 1;
        break;
      }
    //}
  }
  //fine div checkbox
  $tab_output .= "</div>";
  	$tab_output .= '<div class="sel_all_riga" style="width:auto; padding:12px 5px 0px 0px;">';
	//echo 'neg: '.$rigan[negozio].'<br>';
	if ($rigan[azienda_prodotto] == "VIVISOL") {
	  $tab_output .= '<img src="immagini/bottone-vivisol.png">';
	}
	if ($rigan[azienda_prodotto] == "SOL") {
	  $tab_output .= '<img src="immagini/bottone-sol.png">';
	}
	$tab_output .= "</div>";
  
  //fine contenitore riga tabella
  $tab_output .= "</div>";
  
  if ($sf == 1) {
  $sf = 0;
  } else {
  $sf = 1;
  }
  //fine foreach
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
     $tab_output .= "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">";
          if ($note_magazziniere != "") {
     $tab_output .= $note_magazziniere;
          } else {
     $tab_output .= "Note";
          }
     $tab_output .= "</textarea>";
  $tab_output .= "</div>";
  $tab_output .= "<div class=messaggio id=mess_".$sing_rda." title=mess_".$sing_rda.">";
  if ($note_utente != "") {
  $tab_output .= "Utente ".stripslashes($nome_utente_rda)."<br><strong>".$note_utente."</strong><br>";
  }
  if ($note_resp != "") {
  $tab_output .= "Responsabile ".stripslashes($nome_resp_rda)."<br><strong>".$note_resp."</strong><br>";
  }
  if ($note_buyer != "") {
  $tab_output .= "Buyer ".stripslashes($nome_buyer_rda)."<br><strong>".$note_buyer."</strong><br>";
  }
  $tab_output .= "</div>";
  $tab_output .= "</div>";
  
  
  $tab_output .= '<div style="height:auto; width:320px; float:left;">';
  $sqlp = "SELECT * FROM qui_corrispondenze_pl_rda WHERE rda = '$sing_rda'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_pack = mysql_num_rows($risultp);
  if ($num_pack > 0) {
  $tab_output .= '<div id="pack_'.$sing_rda.' style="width:320px; float:left; min-height: 15px; overflow: hidden; height:auto; border-bottom:1px solid #CCC; margin-bottom:10px;">';
  while ($rigap = mysql_fetch_array($risultp)) {
/*
  $tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$rigap[pl]."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
  $tab_output .= "Packing list ".$rigap[pl];
  $tab_output .= "</a><br>";
  $tab_output .= "</div>";
*/  
  $tab_output .= '<div class=puls_servizio>';
  $tab_output .= 'PL '.$rigap[pl];
  $tab_output .= '</div>';
	$tab_output .= '<div class="box_130" style="padding-top:1px;">';
	  $tab_output .= '<a href="javascript:void(0);" onclick="elimina_pl('.$rigap[pl].',0);">';
	  $tab_output .= '<div class="bott_pl" style="color:red; border-color: red; margin-right:10px;">';
	  $tab_output .= 'EliminaPL';
	  //echo '<img src=immagini/button_elimina.gif width=19 height=19 border=0 title="Elimina PL">';
	  $tab_output .= '</div>';
	  $tab_output .= '</a>';
	  $tab_output .= '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=print&n_pl='.$rigap[pl].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
	  $tab_output .= '<div class="bott_pl" style="color:blue;  border-color:blue;">';
	  $tab_output .= 'StampaPL';
	  //echo '<img src=immagini/bottone_stamp.png width=19 height=19 border=0 title="Stampa PL">';
	  $tab_output .= '</div>';
	  $tab_output .= '</a>';
	  $tab_output .= '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=cons&n_pl='.$rigap[pl].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
	  $tab_output .= '<div class="bott_pl" style="color:#F90;  border-color:#F90;">';
	  $tab_output .= 'ModificaPL';
	  //echo '<img src=immagini/bottone-edit.png width=19 height=19 border=0 title="Modifica PL">';
	  $tab_output .= '</div>';
	  $tab_output .= '</a>';
	$tab_output .= "</div>";
  }
  $tab_output .= '</div>';
  }
  
  
  $Num_righe_evadere = "";
  $Num_righe_processate = ""; 
  $Num_righe_rda = "";
  
  $tab_output .= '<div id="puls_processa_'.$sing_rda.'" style="margin-top: 10px;">';
  if ($contatore_righe_flag > 0) {
//  $tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?id_rda=".$sing_rda."&lang=".$lingua."&id_utente=".$id_utente."&mode=nuovo', 'myPop1',800,800);\">";
  $tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?lang=".$lingua."&id_utente=".$id_utente."&mode=nuovo', 'myPop1',800,800);\">";
  $tab_output .= "<div class=btnFreccia><strong>Crea PL</strong></div></a>";
  }
  $tab_output .= "</div>";
  $tab_output .= "</div>";
  
  $contatore_righe_flag = "";
  $contatore_x_chiusura = "";
  /*			$tab_output .= "<a href=# onClick=\"this.form.submit()\"><div class=btnFreccia>";
          $tab_output .= "<strong>Processa RdA</strong>";
          $tab_output .= "</div></a>";
  */
  //fine contenitore pulsantini destra
  $tab_output .= "</div>";
  $tab_output .= "</div>";
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
  $tab_output .= "<div class=price6_riga>";
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
  $tab_output .= "<div class=vuoto9_riga>";
  //fine div checkbox
  $tab_output .= "</div>";
  
  //fine div cont rda
  $tab_output .= "</div>";
  //fine contenitore totale
  $tab_output .= "</div>";
  //fine contenitore totale
  $tab_output .= "</div>";
//output finale

//$tab_output .= "pippo";
echo $tab_output;
//$tab_output .= "id_rda: ".$id_rda;
 ?>
