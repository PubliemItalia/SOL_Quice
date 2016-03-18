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

if ($dest != "mag") {
//procedura per il buyer
if ($check == "0") {
$id_buyer = "";
} else {
$id_buyer = $_GET['id_utente'];
}

if ($singola == 1) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}

if ($multipla == 1) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
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
} else {
$id_magazz = $_GET['id_utente'];
}
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}


if ($multipla == 1) {
if ($check == "2") {
$id_magazz = "";
} else {
$id_magazz = $_GET['id_utente'];
}
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
//fine if dest mag
}
$ordinamento = "data_inserimento DESC";

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
$tab_output .= "<div class=riassunto_rda>";
if ($tipo_negozio != "assets") {
$tab_output .= "RDA ".$id_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
$tab_output .= "RDA ".$id_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
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
if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= $bottone_immagine;
}
$tab_output .= "</div>";
///////////////////////////////////////////////
//FINE  QUERY RDA
///////////////////////////////////////////////



///////////////////////////////////////////////
//INIZIO QUERY RIGHE RDA
///////////////////////////////////////////////

$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
$tab_output .= $rigan[codice_art];
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


//div per note e pulsanti processi
$tab_output .= "<div class=servizio>";
$tab_output .= "<div class=note_pregresse>";
if ($note_utente != "") {
$tab_output .= "Utente ".stripslashes($nome_utente_rda).": <strong>".$note_utente."</strong><br>";
}
if ($note_resp != "") {
$tab_output .= "Responsabile ".stripslashes($nome_resp_rda).": <strong>".$note_resp."</strong><br>";
}
$tab_output .= "</div>";
$tab_output .= "<div id=ordini_".$id_rda.">";
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_ordini = mysql_num_rows($risultp);
if ($num_ordini > 0) {
while ($rigap = mysql_fetch_array($risultp)) {
$tab_output .= "<a href=ordine_fornitore.php?id_ord=".$rigap[id]."&id_rda=".$rigap[id_rda]."&lang=".$lingua." target=_blank>Ord. forn. n. ".$rigap[id]."</a><br>";
}
}
$tab_output .= "</div>";

$tab_output .= "<div class=note>";
if ($note_buyer != "") {
   $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.",this.value);\">".$note_buyer."</textarea>";
} else {
   $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.",this.value);\">Note</textarea>";
}
$tab_output .= "</div>";
$tab_output .= "<div class=messaggio id=mess_".$id_rda.">";
if ($rda_selez == $id_rda) {
$tab_output .= $avviso_no_selez;
}
$tab_output .= "</div>";
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$id_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
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
$Num_righe_processate = ""; 
$Num_righe_rda = "";
$tab_output .= "<div id=puls_processa_".$id_rda.">";
if ($contatore_righe_flag > 0) {
$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:240,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$id_rda.")}})\"><strong>Processa RdA</strong></a></div>";
}
$tab_output .= "</div>";

$tab_output .= "</div>";

//output finale

echo $tab_output;
 ?>
