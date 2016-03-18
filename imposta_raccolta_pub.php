<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$id_rda = $_GET['id_rda'];
//procedura per il magazziniere
if ($check == "2") {
$id_magazz = "";
}
if ($check == "3") {
$id_magazz = $_GET['id_utente'];
}
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id = '$id_riga'";
if (mysql_query($query)) {
//$tab_output .= "l'inserimento ok: ".mysql_error();
} else {
$tab_output .= "Errore durante l'inserimento: ".mysql_error();
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

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//inizio div riassunto

$tab_output .= "<div class=riassunto_rda>";
$tab_output .= "RDA ".$id_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
$tab_output .= "</div>";
$tab_output .= "<div class=stato_rda>";
$tab_output .= $imm_status;
$tab_output .= "</div>";
$tracciati_sap = "";
 $sf = 1;

//determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
//costruzione query
if ($clausole > 0) {
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'lab' AND evaso_magazzino = '0' AND ";
if ($clausole == 1) {
if ($a != "") {
$sqlk .= $a;
}
if ($b != "") {
$sqlk .= $b;
}
if ($c != "") {
$sqlk .= $c;
}
if ($d != "") {
$sqlk .= $d;
}
if ($e != "") {
$sqlk .= $e;
}
if ($f != "") {
$sqlk .= $f;
}
} else {
if ($a != "") {
$sqlk .= $a." AND ";
}
if ($b != "") {
$sqlk .= $b." AND ";
}
if ($c != "") {
$sqlk .= $c." AND ";
}
if ($d != "") {
$sqlk .= $d." AND ";
}
if ($e != "") {
$sqlk .= $e." AND ";
}
if ($f != "") {
$sqlk .= $f;
}
}
} else {
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'lab' AND evaso_magazzino = '0'";
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
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi_mag(".$id_rda.",3);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
} else {
$tooltip_select = $tooltip_deseleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi_mag(".$id_rda.",2);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
}

if ($Num_righe_rda_selezionate == 0) {
$tooltip_select = $tooltip_seleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi_mag(".$id_rda.",3);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
} else {
$tooltip_select = $tooltip_deseleziona_tutto;
$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi_mag(".$id_rda.",2);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
}


$tab_output .= "<div class=sel_all>";
$tab_output .= "</div>";
//$tab_output .= "righe totali: ".$Num_righe_rda."<br>";
//$tab_output .= "righe da evadere: ".$Num_righe_evadere."<br>";
$Num_righe_rda_selezionate = "";
$Num_righe_evadere = "";
$Num_righe_rda = "";

//inizio div rda
$tab_output .= "<div class=cont_rda id=rda_".$id_rda.">";

if ($clausole > 0) {
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'lab' AND evaso_magazzino = '0' AND ";
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
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND output_mode = 'lab' AND evaso_magazzino = '0'";
}
//$tab_output .= $sqln."<br>";
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
$tab_output .= "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
$tab_output .= "<a href=scheda_visuale.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
//fine div pulsante per visualizzare scheda
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
$tab_output .= "<div class=vuoto9_riga>";
$tab_output .= $rigan[output_mode];
//fine div output mode riga
$tab_output .= "</div>";
//div evaso (vuoto)
$tab_output .= "<div class=vuoto9_riga>";
if ($rigan[evaso_magazzino] == 1) {
$tab_output .= "evaso";
}
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
if ($rigan[evaso_magazzino] == 0) {
	switch ($rigan[flag_buyer]) {
	  case "2":
		$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'3',".$id_rda.");\">";
	  break;
	  case "3":
		$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'2',".$id_rda.");\">";
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
//fine foreach
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
if ($note_buyer != "") {
$tab_output .= "Buyer ".stripslashes($nome_buyer_rda).": <strong>".$note_buyer."</strong><br>";
}
$tab_output .= "</div>";
$tab_output .= "<div class=note>";
   $tab_output .= "<textarea name=nota_".$id_rda." class=campo_note id=nota_".$id_rda." onKeyUp=\"aggiorna_nota(nota_".$id_rda.",".$id_rda.");\">";
		if ($note_magazziniere != "") {
   $tab_output .= $note_magazziniere;
		} else {
   $tab_output .= "Note";
		}
   $tab_output .= "</textarea>";
$tab_output .= "</div>";
$tab_output .= "<div class=messaggio id=mess_".$id_rda." title=mess_".$id_rda.">";
$tab_output .= "</div>";

$tab_output .= "<div style=\"height:auto; width:160px; float:left;\">";
$sqlp = "SELECT * FROM qui_corrispondenze_pl_rda WHERE rda = '$id_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_pack = mysql_num_rows($risultp);
if ($num_pack > 0) {
$tab_output .= "<div id=pack_".$id_rda." style=\"width:160px; float:left; height:auto; border-bottom:1px solid #CCC; margin-bottom:10px;\">";
while ($rigap = mysql_fetch_array($risultp)) {
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$rigap[pl]."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
$tab_output .= "Packing list ".$rigap[pl];
$tab_output .= "</a><br>";
//fine contenitore lista packing
$tab_output .= "</div>";

}
//fine contenitore lista packing
$tab_output .= "</div>";
}


$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine contenitore pulsantini destra
$tab_output .= "</div>";
$tab_output .= "</div>";

/*
*/



//output finale

echo $tab_output;



 ?>
