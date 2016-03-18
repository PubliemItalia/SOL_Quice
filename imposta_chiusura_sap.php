<?php
session_start();
$nome_buyer = $_SESSION['nome'];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_buyer = $_GET['id_utente'];
$id_rda = $_GET['id_rda'];
$data_chiusura = mktime();

//routine precedente, con RDA multiple
/*$righe_processare = array();
$d = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '4' AND output_mode = 'sap'";
$risultd = mysql_query($d) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
	if (!in_array($rigad[id],$righe_processare)) {
		$add_righe = array_push($righe_processare,$rigad[id]);
}
}
foreach ($righe_processare as $riga_sing) {
  $query = "UPDATE qui_righe_rda SET flag_chiusura = '1', data_chiusura = '$data_chiusura', stato_ordine = '4', flag_buyer = '2' WHERE id = '$riga_sing'";
	if (mysql_query($query)) {
  } else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
  }
}
$array_rda_evad = array();
$m = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '2' AND id_buyer = '$id_buyer' AND output_mode = 'sap' AND flag_chiusura = '1'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	if (!in_array($rigam[id_rda],$array_rda_evad)) {
		$add_rda = array_push($array_rda_evad,$rigam[id_rda]);
}
}
foreach($array_rda_evad as $ogni_rda) {
  $s = "SELECT * FROM qui_righe_rda WHERE id_rda = '$ogni_rda'";
  $risults = mysql_query($s) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tutte_righe = mysql_num_rows($risults);
  $t = "SELECT * FROM qui_righe_rda WHERE id_rda = '$ogni_rda' AND stato_ordine = '4'";
  $risultt = mysql_query($t) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $righe_evase = mysql_num_rows($risultt);
  if ($righe_evase == $tutte_righe) {
	$query = "UPDATE qui_rda SET data_chiusura = '$data_chiusura', data_ultima_modifica = '$data_chiusura', stato = '4' WHERE id = '$ogni_rda'";
	if (mysql_query($query)) {
	} else {
	  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}	
  }
}
*/
  $query = "UPDATE qui_righe_rda SET flag_chiusura = '1', data_chiusura = '$data_chiusura', stato_ordine = '4', flag_buyer = '2' WHERE flag_buyer = '4' AND output_mode = 'sap' AND id_rda = '$id_rda'";
	if (mysql_query($query)) {
  } else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
  }
  $s = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
  $risults = mysql_query($s) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tutte_righe = mysql_num_rows($risults);
  
  $t = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND flag_chiusura = '1'";
  $risultt = mysql_query($t) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $righe_evase = mysql_num_rows($risultt);
  if ($righe_evase == $tutte_righe) {
	$query = "UPDATE qui_rda SET data_chiusura = '$data_chiusura', data_ultima_modifica = '$data_chiusura', stato = '4' WHERE id = '$id_rda'";
	if (mysql_query($query)) {
	} else {
	  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
	}	
  }
  $w = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND flag_chiusura = '0' AND output_mode = 'sap'";
  $risultw = mysql_query($w) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $righe_zero = mysql_num_rows($risultw);
if ($righe_zero > 0) {
$sqly = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
	$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
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
	$tipo_negozio = "<img src=immagini/spacer.gif width=25 height=2>".ucfirst(str_replace("_"," ",$rigay[negozio]));
	}
//inizio div riassunto rda
$tab_output .= "<div class=riassunto_rda>";
$sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$resultm = mysql_query($sqlm);
$Num_righe_rda = mysql_num_rows($resultm);
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
$tab_output .= "<div class=riepilogo_rda>";
if ($tipo_negozio != "assets") {
//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
$tab_output .= $ut_rda.$tracciati_sap;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
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
$tab_output .= "<div class=sel_all style=\"width:30px;\">";
$tab_output .= "</div>";
$tab_output .= "</div>";
}



  $array_rda = array();
  $array_rda_completate = array();
	$num_rda_titolo = "";
//**********************
//solo per buyer
//************************
//INIZIO OUTPUT BLOCCO SING RDA

//*******************************************
//*******************************************
//inizio div rda

if ($clausole > 0) {
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'sap' AND flag_chiusura = '0' AND ";
if ($clausole == 1) {
if ($a != "") {
$sqln .= $a;
}
if ($b != "") {
$sqln .= $b;
}
if ($c != "") {
$sqln .= $c;
}
if ($d != "") {
$sqln .= $d;
}
if ($e != "") {
$sqln .= $e;
}
if ($f != "") {
$sqln .= $f;
}
} else {
if ($a != "") {
$sqln .= $a." AND ";
}
if ($b != "") {
$sqln .= $b." AND ";
}
if ($c != "") {
$sqln .= $c." AND ";
}
if ($d != "") {
$sqln .= $d." AND ";
}
if ($e != "") {
$sqln .= $e." AND ";
}
if ($f != "") {
$sqln .= $f;
}
}
} else {
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'sap' AND flag_chiusura = '0'";
}
//$tab_output .= "<span style=\"color:rgb(0,0,0);\">righe_evase: ".$righe_evase." - tutte_righe: ".$tutte_righe."<br>".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
if ($rigan[output_mode] != "") {
if ($rigan[output_mode] == "sap") {
$Num_righe_evadere = $Num_righe_evadere + 1;
} else {
if ($rigan[evaso_magazzino] == 1) {
$Num_righe_evadere = $Num_righe_evadere + 1;
}
}
}
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
$tab_output .= "<div class=descr4_riga style=\"width:430px;\">";
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
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
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
$tab_output .= "<a href=\"mailto:adv@publiem.it?bcc=publiem@publiem.it&Subject=Qui C'e', problema con RdA ".$id_rda."\"><span style=\"color:red; text-decoration:none;\">Contattare<br>webmaster</span></a>";
}
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
  switch ($rigan[flag_buyer]) {
  case "2":
  $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'4',".$id_rda.");\">";
  break;
  case "4":
  $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$id_rda.");\">";
  $contatore_righe_flag = $contatore_righe_flag + 1;
  break;
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

//fine div cont rda
$tab_output .= "</div>";

$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";

if ($righe_zero > 0) {
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


$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$id_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";

$tab_output .= "Stampa RdA";
$tab_output .= "</div></a>";
if ($contatore_righe_flag > 0) {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"chiusura(".$id_rda.")\"><div class=puls_servizio>";
	$tab_output .= "<div class=btnFrecciaRed><strong>Chiudi SAP</strong></div>";
$tab_output .= "</div></a>";
}

//fine blocco pulsantini a destra
$tab_output .= "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine blocco sing rda
}




//output finale

echo $tab_output;

?>