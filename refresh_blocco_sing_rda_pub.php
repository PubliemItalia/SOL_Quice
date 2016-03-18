<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];




//inizio div rda

if ($_SESSION['unita'] != "") {
$unitaDaModulo = $_SESSION['unita'];
} 
if ($unitaDaModulo != "") {
$a = "id_unita = '$unitaDaModulo'";
$clausole++;
}
if ($_SESSION['societa'] != "") {
$societaDaModulo = $_SESSION['societa'];
} 
if ($societaDaModulo != "") {
$b = "azienda_prodotto = '$societaDaModulo'";
$clausole++;
}

if ($_SESSION['data_inizio'] != "") {
$data_inizio = $_SESSION['data_inizio'];
} 


if ($_SESSION['data_fine'] != "") {
$data_fine = $_SESSION['data_fine'];
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
if ($_SESSION['shop'] != "") {
$shopDaModulo = $_SESSION['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
if ($_SESSION['categoria_righe'] != "") {
$categoria_righeDaModulo = $_SESSION['categoria_righe'];
} 
if ($categoria_righeDaModulo != "") {
$e = "categoria = '$categoria_righeDaModulo'";
$clausole++;
}
if ($_SESSION['codice_art'] != "") {
$codice_artDaModulo = "*".$_SESSION['codice_art'];
} else {
$codice_artDaModulo == "";
} 
if ($codice_artDaModulo != "") {
$f = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}


//INIZIO OUTPUT BLOCCO SING RDA

$sqly = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
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
$note_buyer = str_replace("<br>","\n",stripslashes($rigay[note_buyer]));
}
//*******************************************
//*******************************************
  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine = '3' AND output_mode = 'lab' AND flag_chiusura = '0'";
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
  } else {
  }
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_totale_righe = mysql_num_rows($risultn);
  while ($rigan = mysql_fetch_array($risultn)) {
  if ($sf == 1) {
  //inizio contenitore riga
  $tab_output .= '<div class="columns_righe2">';
  } else {
  $tab_output .= '<div class="columns_righe1">';
  }
  //div codice riga
  $tab_output .= '<div id="confez5_riga" style="padding-left:10px;">';
  if (substr($rigan[codice_art],0,1) != "*") {
    $tab_output .= $rigan[codice_art];
  } else {
    $tab_output .= substr($rigan[codice_art],1);
  }
  //fine div codice riga
  $tab_output .= '</div>';
  //div descrizione riga
  $tab_output .= '<div class="descr4_riga" style="width:400px;">';
  $tab_output .= $rigan[descrizione];
if ($rigan[negozio] == "labels") {
  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigap = mysql_fetch_array($risultp)) {
	  $giacenza = $rigap[giacenza];
  $label_ric_mag = $rigap[ric_mag];
	if ($rigap[ric_mag] != "mag") {
		  $tab_output .= "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
	}
  }
}
  //fine div descrizione riga
  $tab_output .= '</div>';
  //div nome unità riga
  $tab_output .= '<div class="cod1_riga">';
  $tab_output .= $rigan[nome_unita];
  //fine div nome unità riga
  $tab_output .= '</div>';
  //div quant riga
  $tab_output .= '<div class="price6_riga_quant">';
  $tab_output .= $rigan[quant];
  $tab_output .= "</div>";
//div pulsante per evasione parziale riga
$tab_output .= '<div class="lente_prodotto">';
if ($stampa != "1") {
  if (($rigan[output_mode] == "lab") AND ($rigan[flag_buyer] == "3")) {
	  $tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_magazz.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
}
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";
//div pulsante per visualizzare scheda
  $tab_output .= '<div class="lente_prodotto">';
if ($stampa != "1") {
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
}
  //fine div pulsante per visualizzare scheda
  $tab_output .= "</div>";
  //div totale riga
  $tab_output .= '<div class="price6_riga">';
  $tab_output .= number_format($rigan[totale],2,",",".");
  //fine div totale riga
  $tab_output .= "</div>";
  
  //div output mode riga (vuoto)
  $tab_output .= '<div class="vuoto9_riga" style="width:65px;">';
  $tab_output .= $rigan[output_mode];
  //fine div output mode riga
  $tab_output .= "</div>";

  //div checkbox (vuoto)
  $tab_output .= '<div class="sel_all_riga" id='.$rigan[id].'>';
  if ($rigan[evaso_magazzino] == 0) {
if ($stampa != "1") {
    /*if ($flag_ricerca != "") {
      switch ($rigan[flag_buyer]) {
        case "2":
          $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'3',".$id_rda.");\">";
        break;
        case "3":
          $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'2',".$id_rda.");\">";
        break;
      }
    } else {*/
      switch ($rigan[flag_buyer]) {
        case "2":
          $tab_output .= '<input name="id_riga[]" type="checkbox" id="id_riga[]" value="'.$rigan[id].'" onClick="axc_mag('.$rigan[id].',\'3\','.$id_rda.');">';
        break;
        case "3":
          $tab_output .= '<input name="id_riga[]" type="checkbox" id="id_riga[]" checked value="'.$rigan[id].'" onClick="axc_mag('.$rigan[id].',\'2\','.$id_rda.');">';
          $contatore_righe_flag = $contatore_righe_flag + 1;
        break;
      }
    //}
}
  }
  //fine div checkbox
  $tab_output .= "</div>";
	$tab_output .= '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
	  $tab_output .= '<div class="sel_all_riga" style="width:auto; padding:12px 5px 0px 0px;">';
	  //$tab_output .= 'neg: '.$rigan[negozio].'<br>';
	  if ($rigan[azienda_prodotto] == "VIVISOL") {
		$tab_output .= '<img src="immagini/bottone-vivisol.png">';
	  }
	  if ($rigan[azienda_prodotto] == "SOL") {
		$tab_output .= '<img src="immagini/bottone-sol.png">';
	  }
	  $tab_output .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
	  $giacenza = "";
	  $tab_output .= "</div>";
	$tab_output .= "</a>";

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
  
if ($stampa != "1") {
  //div per note e pulsanti processi
  $tab_output .= '<div class="servizio">';
  $tab_output .= '<div class="note_pregresse">';
  $tab_output .= '<div class="note">';
     $tab_output .= '<textarea name="nota_'.$id_rda.'" class="campo_note" id="nota_'.$id_rda.'" onKeyUp="aggiorna_nota(nota_'.$id_rda.','.$id_rda.');">';
          if ($note_magazziniere != "") {
     $tab_output .= $note_magazziniere;
          } else {
     $tab_output .= 'Note';
          }
     $tab_output .= '</textarea>';
  $tab_output .= '</div>';
  $tab_output .= '<div class="messaggio" id="mess_'.$id_rda.'" title="mess_'.$id_rda.'">';
  if ($note_utente != "") {
  $tab_output .= 'Utente '.stripslashes($nome_utente_rda).'<br><strong>'.$note_utente.'</strong><br>';
  }
  if ($note_resp != "") {
  $tab_output .= 'Responsabile '.stripslashes($nome_resp_rda).'<br><strong>'.$note_resp.'</strong><br>';
  }
  if ($note_buyer != "") {
  $tab_output .= 'Buyer '.stripslashes($nome_buyer_rda).'<br><strong>'.$note_buyer.'</strong><br>';
  }
  $tab_output .= '</div>';
  $tab_output .= '</div>';
  
  
  $tab_output .= '<div style="height:auto; width:320px; float:left;">';
  $sqlp = "SELECT * FROM qui_corrispondenze_pl_rda WHERE rda = '$id_rda'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_pack = mysql_num_rows($risultp);
  if ($num_pack > 0) {
  $tab_output .= '<div id="pack_'.$id_rda.'" style="width:320px; float:left; height:auto; border-bottom:1px solid #CCC; margin-bottom:10px;">';
	while ($rigap = mysql_fetch_array($risultp)) {
	  $tab_output .= '<div style="width:310px; min-height:15px; height:auto; overflow: hidden;">';
		$sqlb = "SELECT * FROM qui_packing_list WHERE id = '".$rigap[pl]."'";
		$risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigab = mysql_fetch_array($risultb)) {
		  if ($rigab[n_ord_sap] == "") {
			$tab_output .= '<div class="puls_servizio">';
			$tab_output .= 'PL '.$rigap[pl];
			$tab_output .= '</div>';
			$tab_output .= '<a href="javascript:void(0);" onclick="elimina_pl('.$rigap[pl].','.$id_rda.');">';
			$tab_output .= '<div class="bott_pl" style="color:red;">';
			$tab_output .= 'Elimina';
			//$tab_output .= '<img src=immagini/button_elimina.gif width=19 height=19 border=0 title="Elimina PL">';
			$tab_output .= '</div>';
			$tab_output .= '</a>';
			$tab_output .= '<a href="javascript:void(0);" onclick="chiusura_grigia('.$rigap[pl].',3);">';
			$tab_output .= '<div class="bott_pl" style="color:#000;">';
			$tab_output .= 'Chiudi';
			//$tab_output .= '<img src=immagini/button_elimina.gif width=19 height=19 border=0 title="Elimina PL">';
			$tab_output .= '</div>';
			$tab_output .= '</a>';
			$tab_output .= '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=cons&n_pl='.$rigap[pl].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
			$tab_output .= '<div class="bott_pl" style="color:orange;">';
			$tab_output .= 'Modifica';
			//$tab_output .= '<img src=immagini/bottone-edit.png width=19 height=19 border=0 title="Modifica PL">';
			$tab_output .= '</div>';
			$tab_output .= '</a>';
			$tab_output .= '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=print&n_pl='.$rigap[pl].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
			$tab_output .= '<div class="bott_pl" style="color:blue;">';
			$tab_output .= 'Stampa';
			//$tab_output .= '<img src=immagini/bottone_stamp.png width=19 height=19 border=0 title="Stampa PL">';
			$tab_output .= '</div>';
			$tab_output .= '</a>';
		  } else {
			$tab_output .= '<div class="puls_servizio">';
			$tab_output .= '<span style="color:rgb(130,130,130);">PL '.$rigap[pl].'</span>';
			$tab_output .= '<br>';
			$tab_output .= '</div>';
		  }
		}
	  $tab_output .= "</div>";
	}
  $tab_output .= "</div>";
  }
  
  
  $Num_righe_evadere = "";
  $Num_righe_processate = ""; 
  $Num_righe_rda = "";
  
  $tab_output .= "<div id=puls_processa_".$id_rda.">";
  if ($contatore_righe_flag > 0) {
	$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?id_rda=".$id_rda."&lang=".$lingua."&id_utente=".$id_utente."&mode=vis&behav=publiem', 'myPop1',800,800);\">";
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

//output finale

echo $tab_output;
//echo "queri:".$sqln;



 ?>
