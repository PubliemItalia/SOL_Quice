<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$singola = $_GET['singola'];
$multipla = $_GET['multipla'];
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

if ($singola == 1) {
$array_rda_exist = array();
$queryv = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '3' AND stato_ordine < '4'";
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
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_magazz = '$id_magazz' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
} else {
$avviso_no_selez = "ATTENZIONE: Le RdA possono essere processate una per volta. <br>Hai gi&agrave; selezionato uno o pi&ugrave; elementi della RdA ".$array_rda_exist[0].".";
}
}

if ($multipla == 1) {

$array_rda_exist = array();
$queryv = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '3' AND stato_ordine < '4'";
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
} else {
$avviso_no_selez = "ATTENZIONE: Le RdA possono essere processate una per volta. <br>Hai gi&agrave; selezionato uno o pi&ugrave; elementi della RdA ".$array_rda_exist[0].".";
}
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
if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$e = "id = '$nrRdaDaModulo'";
$clausole++;
}
//echo "shopDaModulo: ".$shopDaModulo."<br>";

/*if (isset($_GET['negozio'])) {
$negozioDaModulo = $_GET['negozio'];
$_SESSION[negozio] = $_GET['negozio'];
} 
if (isset($_POST['negozio'])) {
$negozioDaModulo = $_POST['negozio'];
$_SESSION[negozio] = $_POST['negozio'];
}
if ($negozioDaModulo == "") {
$negozioDaModulo = $_SESSION[negozio];
}
if ($negozioDaModulo != "") {
$d = "negozio = '$negozioDaModulo'";
$clausole++;
}
*/



//costruzione query
if ($clausole > 0) {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND ";

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
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' ";
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
//echo "limit in errore<br>";
     $limit = 25; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
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

//echo "testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//<!--inizio contenitore testata-->
$tab_output .= "<div id=columns_testata>";
//<!--div num rda testata-->
$tab_output .= "<div class=cod1>";
$tab_output .= "ID Ordine";
//<!--fine div num rda testata-->
$tab_output .= "</div>";
//<!--div data testata-->
$tab_output .= "<div class=cod1>";
$tab_output .=  "Data";
 //<!--fine div data testata-->
$tab_output .= "</div>";
//<!--div codice testata-->
$tab_output .= "<div id=confez5>";
$tab_output .=  "Codice";
//<!--fine div codice testata-->
$tab_output .= "</div>";
//<!--div descrizione testata-->
$tab_output .= "<div class=descr4>";
$tab_output .= "Prodotto";
// <!--fine div descrizione testata-->
$tab_output .= "</div>";
//<!--div unità testata-->
$tab_output .= "<div class=cod1>";
$tab_output .= "Unit&agrave;";
//<!--fine div unità testata-->
$tab_output .= "</div>";
//<!--div quant testata-->
$tab_output .= "<div class=price6_quant>";
$tab_output .= "Quantit&agrave;";
//<!--fine div quant testata-->
$tab_output .= "</div>";
//<!--div totale testata-->
$tab_output .= "<div class=price6>";
$tab_output .= "Totale &euro;";
//<!--fine div totale testata-->
$tab_output .= "</div>";

//<!--div vuoto testata (vuoto)-->
$tab_output .= "<div class=vuoto9>";
$tab_output .= "Stato RdA";
//<!--fine div vuoto testata-->
$tab_output .= "</div>";
$tab_output .= "</div>";

//fine testata

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
/*echo "array_rda: ";
print_r($array_rda);
echo "<br>";
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
$note_buyer = str_replace("<br>","\n",stripslashes($rigay[note_buyer]));
}
$tab_output .= "<div class=riassunto_rda>";
$tab_output .= "RDA ".$sing_rda.$ut_rda;
$tab_output .= "</div>";
$tab_output .= "<div class=stato_rda>";
$tab_output .= $imm_status;
$tab_output .= "</div>";
 $sf = 1;

//determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = 'mag'";
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
if ($Num_righe_processate < $Num_righe_rda) {
$tab_output .= $bottone_immagine;
}
$tab_output .= "</div>";
//$tab_output .= "righe totali: ".$Num_righe_rda."<br>";
//$tab_output .= "righe da evadere: ".$Num_righe_evadere."<br>";
$Num_righe_rda_selezionate = "";
$Num_righe_evadere = "";
$Num_righe_rda = "";
//inizio div rda
$tab_output .= "<div class=cont_rda id=rda_".$sing_rda.">";

$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = 'mag'";
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
$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc_mag(".$rigan[id].",'3',".$sing_rda.");\">";
break;
case "3":
$tab_output .= "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc_mag(".$rigan[id].",'2',".$sing_rda.");\">";
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
$tab_output .= "</div>";
$tab_output .= "<div class=messaggio id=mess_".$sing_rda.">";
if ($rda_selez == $sing_rda) {
$tab_output .= $avviso_no_selez;
}
$tab_output .= "</div>";
$tab_output .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?mode=vis&id=".$sing_rda."&lang=".$lingua."', 'myPop1',1000,400);\"><div class=puls_servizio>";
$tab_output .= "Stampa Packing list";
$tab_output .= "</div></a>";
$tab_output .= "<div class=puls_servizio>";
$tab_output .= "</div>";
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

$tab_output .= "<div id=puls_processa_".$sing_rda.">";
if ($contatore_righe_flag > 0) {
$tab_output .= "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"chiusura(".$sing_rda.");\"><strong>Concludi MAG</strong></a></div>";
}
$tab_output .= "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
/*			echo "<a href=# onClick=\"this.form.submit()\"><div class=btnFreccia>";
		echo "<strong>Processa RdA</strong>";
		echo "</div></a>";
*/
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

//fine contenitore totale

//output finale

//echo "pippo";
echo $tab_output;
 ?>
