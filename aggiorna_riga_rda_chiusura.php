<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];



///////////////////////////////////////////////
//INIZIO QUERY RDA
///////////////////////////////////////////////
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

//inizio div rda
/*
$tab_output .= "<div class=riassunto_rda>";
if ($tipo_negozio != "assets") {
$tab_output .= "RDA ".$id_rda." ".$tipo_negozio." ".$tracciati_sap." ".$ut_rda;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
$tab_output .= "RDA ".$id_rda." ".$tipo_negozio." ".$output_wbs." ".$ut_rda;
}
$tab_output .= "</div>";

$tab_output .= "<div class=stato_rda>";
$tab_output .= $imm_status;
$tab_output .= "</div>";
$sf = 1;

//determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$Num_righe_rda = mysql_num_rows($risultk);
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[flag_buyer] == 1) {
$Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
}
if ($rigak[output_mode] != "") {
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

if ($Num_righe_rda_selezionate == 0) {
$tooltip_select = $tooltip_seleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
} else {
$tooltip_select = $tooltip_deseleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
}
}

$Num_righe_rda_selezionate = "";

$tab_output .= "<div class=sel_all>";
//if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'gestione_evasione_rda.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$id_rda.")}})\"><img src=immagini/visione_righe.png width=17 height=17 border=0 title=".$visualizza_dettaglio."></a>";
//}
$tab_output .= "</div>";
$tab_output .= "<div class=sel_all>";
if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= $bottone_immagine;
}
$tab_output .= "</div>";
*/
///////////////////////////////////////////////
//FINE  QUERY RDA
///////////////////////////////////////////////



///////////////////////////////////////////////
//INIZIO QUERY RIGHE RDA
///////////////////////////////////////////////

$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
//div codice riga
$tab_output .= "<div id=confez5_riga>";
if (substr($rigan[codice_art],0,1) != "*") {
  $tab_output .= $rigan[codice_art];
} else {
  $tab_output .= substr($rigan[codice_art],1);
}
//fine div codice riga
$tab_output .= "</div>";
//div descrizione riga
$tab_output .= "<div class=descr4_riga>";
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
	$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";

//div pulsante per visualizzare scheda
$tab_output .= "<div class=lente_prodotto>";
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
if ($rigam[categoria3_it] == "") {
$tab_output .= "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
$tab_output .= "<a href=scheda_visuale.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
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
//div evaso (vuoto)
$tab_output .= "<div class=vuoto9_riga>";
if ($rigan[evaso_magazzino] == 1) {
$tab_output .= " evaso";
}
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
if ($rigan[output_mode] == "") {
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
//fine div checkbox
$tab_output .= "</div>";

//fine contenitore riga tabella
$tab_output .= "</div>";

if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}
///////////////////////////////////////////////
//FINE QUERY RIGHE RDA
///////////////////////////////////////////////


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
$tab_output .= "<div class=note>";
		if ($note_buyer != "") {
   $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.");\">".$note_buyer."</textarea>";
		} else {
   $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.");\">Note</textarea>";
		}
$tab_output .= "</div>";
$tab_output .= "<div class=messaggio id=mess_".$id_rda." title=mess_".$id_rda.">";
$tab_output .= $avviso_no_selez;
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

echo $tab_output;
 ?>
