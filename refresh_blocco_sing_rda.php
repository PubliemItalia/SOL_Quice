<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$dest = $_GET['dest'];
$singola = $_GET['singola'];
$multipla = $_GET['multipla'];
$check = $_GET['check'];
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];



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

//inizio div rda

if ($clausole > 0) {
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine != '4' AND ";
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
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine != '4'";
}
//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
if ($rigan[output_mode] != "") {
if ($rigan[output_mode] != "mag") {
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
//div codice riga
$tab_output .= '<div id="confez5_riga" style="padding-left:10px;">';
if (substr($rigan[codice_art],0,1) != "*") {
  $tab_output .= $rigan[codice_art];
} else {
  $tab_output .= substr($rigan[codice_art],1);
}
//fine div codice riga
$tab_output .= "</div>";

//div descrizione riga
$tab_output .= "<div class=descr4_riga style=\"width:400px;\">";
$tab_output .= $rigan[descrizione];
if ($rigan[negozio] == "labels") {
  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigap = mysql_fetch_array($risultp)) {
	  $label_ric_mag = $rigap[ric_mag];
	if ($rigap[ric_mag] != "mag") {
		 $tab_output .= "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
	}
  }
}
//fine div descrizione riga
$tab_output .= "</div>";


//div nome unità riga
$tab_output .= "<div class=cod1_riga>";
$tab_output .= $rigan[nome_unita];
//fine div nome unità riga
$tab_output .= "</div>";
//div quant riga
$tab_output .= "<div class=price6_riga_quant>";
$tab_output .= intval($rigan[quant]);
$tab_output .= "</div>";



//div pulsante per evasione parziale riga
$tab_output .= "<div class=lente_prodotto>";
if (($rigan[output_mode] == "") AND ($rigan[flag_buyer] == "1")) {
  if (($rigan[negozio] == "labels") AND ($label_ric_mag != "mag")) {
  } else {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";

//div pulsante per visualizzare scheda
$tab_output .= "<div class=lente_prodotto>";
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
if ($rigam[categoria3_it] == "") {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'ricerca_prodotti.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
/*
$tab_output .= "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
$tab_output .= "<a href=scheda_visuale.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
*/
}
}
//fine div pulsante per visualizzare scheda
$tab_output .= "</div>";
//div totale riga
$tab_output .= "<div class=price6_riga>";
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
$tab_output .= "<a href=\"mailto:adv@publiem.it?bcc=publiem@publiem.it&Subject=Qui C'e', problema con RdA".$rigan[id_rda]."\"><span style=\"color:red; text-decoration:none; font-weight:bold;\">Contattare<br>webmaster</span></a>";
}
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
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
$tab_output .= '<div class="sel_all_riga" style="padding-top:2px; width:20px; padding-left:10px;">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($rigan[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $tab_output .= '<img src="immagini/bottone-vivisol.png">';
	break;
	case "SOL":
	  $tab_output .= '<img src="immagini/bottone-sol.png">';
	break;
}
$tab_output .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
$giacenza = "";
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

//fine div cont rda
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
if ($flag_ricerca == "") {
$tab_output .= "<div style=\"height:auto; width:150px; float:left;\">";
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
$num_ordini = mysql_num_rows($risultp);
if ($num_ordini > 0) {
$tab_output .= "<div id=ordini_".$id_rda." class=puls_servizio style=\"height:auto; border-bottom:1px solid #CCC;\">";
while ($rigap = mysql_fetch_array($risultp)) {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('ordine_fornitore.php?id_ord=".$rigap[id]."&id_rda=".$rigap[id_rda]."&lang=".$lingua."&mode=', 'myPop1',800,800);\">";
if ($rigap[ordine_interno] != "") {
$tab_output .= "Ordine ".$rigap[ordine_interno];
} else {
$tab_output .= "Ordine ".$rigap[id];
}
$tab_output .= "</a><br>";

}
$tab_output .= "</div>";
}
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$id_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";

//$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?id=".$id_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$id_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
$tab_output .= "Stampa RdA";
//$tab_output .= "<br>E:".$Num_righe_evadere;
//$tab_output .= "<br>T:".$num_totale_righe."<br>";
$tab_output .= "</div></a>";
if ($Num_righe_evadere == $num_totale_righe) {
$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"chiusura(".$id_rda.");\"><div class=puls_servizio>";
$tab_output .= "<span style=\"color:red;\">Chiudi RdA</span>";
$tab_output .= "</div></a>";
} else {
//$tab_output .= "<div class=puls_servizio>";
//$tab_output .= "</div>";
}

$tab_output .= "<div id=puls_processa_".$id_rda.">";
if ($contatore_righe_flag > 0) {
$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$id_rda.")}})\"><strong>Processa RdA</strong></a></div>";
}
$tab_output .= "</div>";
//fine blocco pulsantini a destra
$tab_output .= "</div>";
}

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
/*		$tab_output .= "<a href=# onClick=\"this.form.submit()\"><div class=btnFreccia>";
		$tab_output .= "<strong>Processa RdA</strong>";
		$tab_output .= "</div></a>";
*/
//fine blocco sing rda




//output finale

//echo "pippo";
echo $tab_output;



 ?>
