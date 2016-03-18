<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$dest = $_GET['dest'];
$singola = $_GET['singola'];
$multipla = $_GET['multipla'];
$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];
$codice_art = $_GET['codice_art'];
$categoria_ricerca = $_GET['categoria_ricerca'];
$unita = $_GET['unita'];
$shop = $_GET['shop'];
$data_inizio = $_GET['data_inizio'];
$data_fine = $_GET['data_fine'];

if ($unita != "") {
$a = "id_unita = '$unita'";
$clausole++;
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
if ($shop != "") {
$d = "negozio = '$shop'";
$clausole++;
}
if ($categoria_ricerca != "") {
$e = "categoria = '$categoria_ricerca'";
$clausole++;
}
if ($codice_art != "") {
$f = "codice_art = '$codice_art'";
$clausole++;
}

if ($dest != "mag") {
//procedura per il buyer
if ($singola == 1) {
if ($check == "0") {
$id_buyer = "";
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "111<br>";
} else {
$id_buyer = $_GET['id_utente'];
}

/*
$array_rda_exist = array();
$queryv = "SELECT * FROM qui_righe_rda WHERE id_buyer = '$id_buyer' AND flag_buyer = '1' AND stato_ordine < '4'";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
if (!in_array($rowv[id_rda],$array_rda_exist)) {
$add_rda = array_push($array_rda_exist,$rowv[id_rda]);
}
}
$elementi_array = count($array_rda_exist);
$queryh = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$resulth = mysql_query($queryh) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowh = mysql_fetch_array($resulth)) {
$rda_selez = $rowh[id_rda];
}
	
if ((in_array($rda_selez,$array_rda_exist)) OR ($elementi_array == 0)) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "222<br>";
$avviso_no_selez = "";
$_SESSION[rda_rif] = "";
} else {
$avviso_no_selez = "ATTENZIONE: Le RdA possono essere processate una per volta. <br>Hai gi&agrave; selezionato uno o pi&ugrave; elementi della RdA ".$array_rda_exist[0].".";
$_SESSION[rda_rif] = $id_rda;
}
*/
}


if ($multipla == 1) {
if ($check == "0") {
$id_buyer = "";
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$id_rda' AND output_mode = ''";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "333<br>";
} else {
$id_buyer = $_GET['id_utente'];
}

$array_rda_exist = array();
$queryv = "SELECT * FROM qui_righe_rda WHERE id_buyer = '$id_buyer' AND flag_buyer = '1' AND stato_ordine < '4'";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
if (!in_array($rowv[id_rda],$array_rda_exist)) {
$add_rda = array_push($array_rda_exist,$rowv[id_rda]);
}
}
$rda_selez = $id_rda;
$elementi_array = count($array_rda_exist);
	
if ((in_array($rda_selez,$array_rda_exist)) OR ($elementi_array == 0)) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$id_rda' AND output_mode = '' AND flag_buyer = '0'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "444<br>";
$avviso_no_selez = "";
$_SESSION[rda_rif] = "";
} else {
$avviso_no_selez = "ATTENZIONE: Le RdA possono essere processate una per volta. <br>Hai gi&agrave; selezionato uno o pi&ugrave; elementi della RdA ".$array_rda_exist[0].".";
$_SESSION[rda_rif] = $id_rda;
}
}

} else {

//procedura per il magazziniere
if ($check == "2") {
$evaso_magazzino = "0";
}
if ($check == "3") {
$evaso_magazzino = "1";
}

$id_magazz = $_GET['id_utente'];
if ($singola == 1) {
if ($check == "2") {
$id_magazz = "";
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "555<br>";
} else {
$id_magazz = $_GET['id_utente'];
}
$array_rda_exist = array();
$queryv = "SELECT * FROM qui_righe_rda WHERE id_magazz = '$id_magazz' AND flag_buyer = '3'";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
if (!in_array($rowv[id_rda],$array_rda_exist)) {
$add_rda = array_push($array_rda_exist,$rowv[id_rda]);
}
}
$queryh = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$resulth = mysql_query($queryh) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowh = mysql_fetch_array($resulth)) {
$rda_selez = $rowh[id_rda];
}
$elementi_array = count($array_rda_exist);
	
if ((in_array($rda_selez,$array_rda_exist)) OR ($elementi_array == 0)) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', evaso_mamazzino = '$evaso_magazzino' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "666<br>";
$avviso_no_selez = "";
$_SESSION[rda_rif] = "";
} else {
$avviso_no_selez = "ATTENZIONE: Le RdA possono essere processate una per volta. <br>Hai gi&agrave; selezionato uno o pi&ugrave; elementi della RdA ".$array_rda_exist[0].".";
$_SESSION[rda_rif] = $id_rda;
}
}


if ($multipla == 1) {
if ($check == "2") {
$id_magazz = "";
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id_rda = '$id_rda' AND output_mode = 'mag'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "777<br>";
} else {
$id_magazz = $_GET['id_utente'];
}

$array_rda_exist = array();
$queryv = "SELECT * FROM qui_righe_rda WHERE id_magazz = '$id_magazz' AND flag_buyer = '3'";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
if (!in_array($rowv[id_rda],$array_rda_exist)) {
$add_rda = array_push($array_rda_exist,$rowv[id_rda]);
}
}
$rda_selez = $id_rda;
$elementi_array = count($array_rda_exist);
	
if ((in_array($rda_selez,$array_rda_exist)) OR ($elementi_array == 0)) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//$tab_output .= "888<br>";
$avviso_no_selez = "";
$_SESSION[rda_rif] = "";
} else {
$avviso_no_selez = "ATTENZIONE: Le RdA possono essere processate una per volta. <br>Hai gi&agrave; selezionato uno o pi&ugrave; elementi della RdA ".$array_rda_exist[0].".";
$_SESSION[rda_rif] = $id_rda;
}
}
//fine if dest mag
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
$tipo_negozio = "<img src=immagini/spacer.gif width=25 height=2>".ucfirst(str_replace("_"," ",$rigay[negozio]));
}





//*******************************************
//*******************************************
//inizio div riassunto

$tab_output .= "<div class=riassunto_rda>";
if ($tipo_negozio != "assets") {
$tab_output .= "RDA ".$id_rda.$tipo_negozio.$tracciati_sap.$ut_rda;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
$tab_output .= "RDA ".$id_rda.$tipo_negozio.$output_wbs.$ut_rda;
}
$wbs_visualizzato = "";
$output_wbs = "";
$tab_output .= "</div>";

$tab_output .= "<div class=stato_rda>";
$tab_output .= $imm_status;
$tab_output .= "</div>";
$tracciati_sap = "";
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

$codice_art = $_GET['codice_art'];
$categoria_ricerca = $_GET['categoria_ricerca'];
$unita = $_GET['unita'];
$shop = $_GET['shop'];
$data_inizio = $_GET['data_inizio'];
$data_fine = $_GET['data_fine'];
/*  if (($codice_art != "") AND (($categoria_ricerca !="") OR ($unita !="") OR ($_GET[unita] !="") OR ($shop !="") OR ($data_inizio !="") OR ($data_fine !=""))) {
  } else {
if ($Num_righe_rda_selezionate == 0) {
$tooltip_select = $tooltip_seleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
} else {
$tooltip_select = $tooltip_deseleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
}
  }
*/
}

$Num_righe_rda_selezionate = "";

$tab_output .= "<div class=sel_all>";
/*if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= $bottone_immagine;
}
*/
$tab_output .= "</div>";

//inizio div rda
$tab_output .= "<div class=cont_rda id=rda_".$id_rda.">";

$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";

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
//div num rda riga
$tab_output .= "<div class=cod1_riga>";
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
//div pulsante per visualizzare scheda
$tab_output .= "<div class=lente_prodotto>";
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
if ($rigam[categoria3_it] == "") {
$tab_output .= "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
$tab_output .= "<a href=scheda_visuale.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id_rda."&lang=".$lingua."><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
//fine div pulsante per visualizzare scheda
$tab_output .= "</div>";

//div descrizione riga
$tab_output .= "<div class=descr4_riga>";
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
$tab_output .= $rigan[quant];
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
  $tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc_parz(".$rigan[id].",'1',".$sing_rda.");\">";
break;
case "1":
$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc_parz(".$rigan[id].",'0',".$id_rda.");\">";
$contatore_righe_flag = $contatore_righe_flag + 1;
break;
}
} else {
if ($rigan[flag_buyer] > 1) {
$contatore_x_chiusura = $contatore_x_chiusura + 1;
}

}
//fine div checkbox
$tab_output .= "</div>";

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
$tab_output .= "<div style=\"height:auto; width:150px; float:left;\">";
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
$tab_output .= "</div></a>";
if ($Num_righe_evadere == $Num_righe_rda) {
$tab_output .= "<a href=\"javascript:void(0);\" onClick=\"chiusura(".$id_rda.");\"><div class=puls_servizio>";
$tab_output .= "Chiudi RdA";
$tab_output .= "</div></a>";
} else {
$tab_output .= "<div class=puls_servizio>";
$tab_output .= "</div>";
}
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

$tab_output .= "<div id=puls_processa_".$id_rda.">";
/*if ($contatore_righe_flag > 0) {
$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:290,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$id_rda.")}})\"><strong>Processa RdA</strong></a></div>";
}
*/
$tab_output .= "</div>";
//fine blocco pulsantini a destra
$tab_output .= "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine blocco sing rda




//output finale

//echo "pippo";
echo $tab_output;



 ?>
