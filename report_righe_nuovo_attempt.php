<?php 
/*include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione","operatore","agente");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
*/
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
$lingua = $_SESSION[lang];

$id_utente = $_SESSION[user_id];
//echo "lingua: ".$lingua."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
$id_riga = $_GET[id_riga];
$selezione_singola = $_GET[selezione_singola];
$id_rda = $_GET[id_rda];
$selezione_multipla_app = $_GET[selezione_multipla];
//echo "selezione_singola: ".$selezione_singola."<br>";
//echo "selezione_multipla_app: ".$selezione_multipla_app."<br>";


include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
$array_rda_sel = array();
//$sqla = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '1'";
$sqla = "SELECT * FROM qui_rda WHERE stato = '3'";
$risulta = mysql_query($sqla) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaa = mysql_fetch_array($risulta)) {
if (!in_array($rigaa[id_rda],$array_rda_sel)) {
$add_rda = array_push($array_rda_sel,$rigaa[id_rda]);
}
}
$rda_sel = count($array_rda_sel);
/*echo "array rda: ";
print_r($array_rda_sel);
echo "<br>";
*/
if ($selezione_singola != "") {
$sqlb = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigab = mysql_fetch_array($risultb)) {
if (($rda_sel == 0) OR (in_array($rigab[id_rda],$array_rda_sel))) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$selezione_singola' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}
} else {
$attiva_alert = "1";
}
}
}
if ($selezione_multipla_app != "") {
if (($rda_sel == 0) OR (in_array($rigab[id_rda],$array_rda_sel))) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$selezione_multipla_app' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}
} else {
$attiva_alert = "1";
}
}
$archive = $_GET['archive'];
include "functions.php";
//include "funzioni.js";

if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[nazione_ric] = "";
$_SESSION[descrizione] = "";
$_SESSION[negozio] = "";
$_SESSION[categoria] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";
//echo "negozio buyer: ".$_SESSION[negozio_buyer]."<br>";
//echo "negozio2 buyer: ".$_SESSION[negozio2_buyer]."<br>";

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
$avviso = $_GET['avviso'];
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
if (isset($_GET['codice_art'])) {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$f = "codice_art = '$codice_artDaModulo'";
$clausole++;
}
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
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
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3') AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3') AND ";
if ($_SESSION[negozio2_buyer] != "") {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE (negozio = '$_SESSION[negozio_buyer]' OR negozio = '$_SESSION[negozio2_buyer]') AND (stato_ordine BETWEEN '2' AND '3') AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (negozio = '$_SESSION[negozio_buyer]' OR negozio = '$_SESSION[negozio2_buyer]') AND (stato_ordine BETWEEN '2' AND '3') AND ";
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3') AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3') AND ";
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
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3')";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3')";
if ($_SESSION[negozio2_buyer] != "") {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE (negozio = '$_SESSION[negozio_buyer]' OR negozio = '$_SESSION[negozio2_buyer]') AND (stato_ordine BETWEEN '2' AND '3')";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (negozio = '$_SESSION[negozio_buyer]' OR negozio = '$_SESSION[negozio2_buyer]') AND (stato_ordine BETWEEN '2' AND '3')";
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3')";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE negozio = '$_SESSION[negozio_buyer]' AND (stato_ordine BETWEEN '2' AND '3')";
}	
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

echo "<span style=\"color:rgb(0,0,0);\">testoQuery: ".$testoQuery."</span><br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
$_SESSION[percorso_ritorno] ="report_righe_nuovo.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&button=Filtra";

include "menu_quice3.php";
?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.btnFreccia {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 0 transparent;
    color: #fff;
    cursor: pointer;
    display: block;
    height: 19px;
    line-height: 19px;
    text-align: left;
    width: 117px;
    margin-left: 40px;
	padding-left: 3px;
	float:left;
}
.btnFreccia a:hover {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 -29px transparent;
}
#columns_totale {
	width: 960px;
	background: #FFFFCC;
	height:25px;
}
#columns_totale {
	width: 960px;
	background: #FFFFCC;
	height:25px;
}
.libero {
	width: 960px;
	height:auto;
	float: left;
}
#columns_testata {
	font-weight: bold;
	color: #FFFFFF;
	width: 960px;
	height: 25px;
	background-color: #8e8e8e;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
#spia_cambio {
	float: left;
	color: #FFFFFF;
	width: 10px;
	height: 25px;
	background-color: #8e8e8e;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
}
#riga_totale {
	color: black;
	width: 960px;
	height: 25px;
	background-color: #CCC;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	margin-top: 10px;
}

.riassunto_rda {
	float: left;
	font-weight: bold;
	color: white;
	width: 830px;
	height: 21px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color: #97b4b5;
	padding-left: 10px;
	padding-top: 7px;
}
.stato_rda {
	float: left;
	font-weight: bold;
	color: black;
	width: 75px;
	height: 23px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #97b4b5;
	padding-top: 5px;
}

.cont_rda {
	float: left;
	width: 960px;
	height: auto;
	/*background-color: #330000;*/
}
.columns_righe1 {
	float: left;
	color: black;
	width: 960px;
	height: 32px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #F0F0F0;
}
.riga_divisoria {
	float: left;
	width: 960px;
	height: 2px;
	background-color: #F0F0F0;
}
.columns_righe2 {
	float: left;
	color: black;
	width: 960px;
	height: 32px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background: #fff;
}
.columns_righe1:hover {
	background: #D6ECED;
}
.columns_righe2:hover {
	background: #D6ECED;
}
#columns0 {
	width: 960px;
	background: #fff;
	height:25px;
}
#columns1 {
	width: 960px;
	background:#F0F0F0;
	height:25px;
}
.cod1 {
	padding-left: 10px;
	color: #FFFFFF;
	width: 70px;
	height: 20px;
	float: left;
	padding-top: 5px;
}
.cod1 a {
	color: #FFFFFF;
}
.cod1_riga {
	padding-left: 10px;
	color: black;
	width: 70px;
	height: 24px;
	float: left;
	padding-top: 4px;
}
.cod1_riga_quant {
	padding-left: 10px;
	color: black;
	width: 85px;
	height: 24px;
	float: left;
	padding-top: 4px;
}
.descr4 {
	float: left;
	width: 300px;
	height:20px;
	padding-left: 10px;
	padding-top: 5px;
}
.descr4 a {
	color: #FFFFFF;
}
.descr4_riga {
	float: left;
	width: 300px;
	height:24px;
	padding-left: 10px;
	padding-top: 4px;
}
#confez5 {
	float: left;
	width: 70px;
	height:20px;
	padding-left: 10px;
	padding-top: 5px;
}
#confez5_riga {
	float: left;
	width: 55px;
	height:24px;
	padding-left: 5px;
	padding-top: 4px;
}
.lente_prodotto {
	float: left;
	width: 20px;
	height:24px;
	padding-top: 4px;
}
#confez5 a {
	color: #FFFFFF;
}
.price6 {
	color: #FFFFFF;
	width: 80px;
	height: 20px;
	float: left;
	padding-top: 5px;
	padding-right: 15px;
	text-align: right;
}
.price6_quant {
	color: #FFFFFF;
	width: 85px;
	height: 20px;
	float: left;
	padding-top: 5px;
	padding-right: 25px;
	text-align: right;
}
.price6_riga {
	color: black;
	width: 95px;
	height: 24px;
	float: left;
	padding-top: 4px;
	padding-right: 15px;
	text-align: right;
}
.price6_riga_quant {
	color: black;
	width: 70px;
	height: 23px;
	float: left;
	padding-top: 4px;
	padding-right: 24px;
	text-align: right;
}
.tx_totale {
	color: black;
	width: 735px;
	height: 20px;
	float: left;
	padding-top: 7px;
	padding-right: 25px;
	text-align: right;
}
.vuoto9 {
	float: left;
	width: 62px;
	height:20px;
	padding-top: 5px;
	text-align: center;
}
.vuoto9_riga {
	float: left;
	width: 42px;
	height:24px;
	padding-top: 4px;
}
.style_mag {
	float: left;
	width: 42px;
	height:24px;
	color:#e9a441;
	padding-top: 4px;
	font-weight: bold;
}
.style_sap {
	float: left;
	width: 42px;
	height:24px;
	color:#11bfe4;
	padding-top: 4px;
	font-weight: bold;
}
.style_ord {
	float: left;
	width: 42px;
	height:24px;
	color:#33b655;
	padding-top: 4px;
	font-weight: bold;
}
.sel_all {
	float: left;
	font-weight: bold;
	color: black;
	text-align:center;
	width: 45px;
	height: 23px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #97b4b5;
	padding-top: 5px;
}
.sel_all_riga {
	float: left;
	text-align:center;
	width: 40px;
	height: 13px;
	padding-top: 9px;
}
.servizio {
	float: left;
	color: black;
	width: 960px;
	height: auto;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	padding-top:10px;
	padding-bottom:10px;
display:inline;
	/*background: #393;*/
}
.campo_note {
	width: 350px;
	height: 60px;
	color: black;
	background-color: #FFFFCC;
	border:0px solid #FFFFFF;
}
.note {
	float: left;
	width: 390px;
	height: auto;
	padding-left:10px;
	padding-top:5px;
	margin-bottom:10px;
	/*background-color: #393;*/
}

.note_pregresse {
	float: left;
	width: 830px;
	height: auto;
	padding-left:10px;
	padding-top:5px;
	padding-bottom:5px;
}
.messaggio {
	float: left;
	width: 380px;
	height: 60px;
	padding-left:20px;
	padding-top:5px;
	font-weight: bold;
	color: red;
	/*background-color: #99FFFF;*/
}
#ordini {
	color: black;
	float: left;
	width: 120px;
	height: auto;
	font-weight: bold;
	text-align:center;
}
.puls_servizio {
	color: black;
	float: left;
	width: 117px;
	height: 20px;
	padding-left:43px;
	font-weight: bold;
	/*background-color: #FFFF00;*/
}
.puls_servizio a {
	color: black;
}
#puls_processa {
	float: left;
	width: 160px;
	height: auto;
}
.label{
   font-family:Verdana, sans-serif;
   font-size:12px;
   color:#369;
   font-weight:bold;
   }
   
.filtri_report {
	float: none;
	width: auto;
	height: auto;
	color:#000;
}
</style>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>
<script type="text/javascript" src="tinybox.js"></script>

</head>
<?php

if ($attiva_alert != "") {
echo "<body onLoad=\"TINY.box.show({url:'popup_notifica.php?avviso=rda_sbagliata&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,})\">";
//echo "<body onLoad=window.open('popup_notifica.php?avviso=config','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
} else {
echo "<body>";
}

?>
<div id="main_container">
<!--div ricerca report righe nuovo per balconi-->
<div id="ricerca" class="submenureport" style="margin-bottom:20px; background-image:none;">
<div id=formRicerca>
<form action="<?php echo $azione_form; ?>" method="get" name="form_filtri2">
<div class=col>
  <div class="filtri_report" id=="scelta_negozio">
    <strong>Negozio</strong><br>
    <select name="shop" class="codice_lista_nopadding" id="shop" style="height:20px; font-size:12px;" onChange="avviso_filtri_on('1')">
    <option selected value="">Tutti</option>";
    <?php
    $sqlf = "SELECT * FROM qui_utenti WHERE user_id = '$_SESSION[user_id]'";
    $risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigaf = mysql_fetch_array($risultf)) {
        $negozio1_buyer = $rigaf[negozio_buyer];
    if ($rigaf[negozio_buyer] == $shopDaModulo) {
    echo "<option selected value=".$rigaf[negozio_buyer].">".ucfirst($rigaf[negozio_buyer])."</option>";
    } else {
    echo "<option value=".$rigaf[negozio_buyer].">".ucfirst($rigaf[negozio_buyer])."</option>";
    }
    if ($rigaf[negozio2_buyer] != "") {
        $negozio2_buyer = $rigaf[negozio2_buyer];
    if ($rigaf[negozio2_buyer] == $shopDaModulo) {
    echo "<option selected value=".$rigaf[negozio2_buyer].">".ucfirst(str_replace("_"," ",$rigaf[negozio2_buyer]))."</option>";
    } else {
    echo "<option value=".$rigaf[negozio2_buyer].">".ucfirst(str_replace("_"," ",$rigaf[negozio2_buyer]))."</option>";
    }
    }
    }
    ?>
    </select>
  </div>
  <div class="filtri_report" id="scelta_categoria" style="margin-top:5px;">
    <strong>Categoria</strong><br>
    <select name="categoria_ricerca" class="codice_lista_nopadding" id="categoria_ricerca" style="height:20px; font-size:12px;" onChange="avviso_filtri_on('1')">
    <option selected value="">Tutte</option>";
    <?php
	$array_negozi = array();
    $sqlf = "SELECT * FROM qui_utenti WHERE user_id = '$_SESSION[user_id]'";
    $risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigaf = mysql_fetch_array($risultf)) {
		$add_neg = array_push($array_negozi,$rigaf[negozio_buyer]);
    if ($rigaf[negozio2_buyer] != "") {
		$add_neg2 = array_push($array_negozi,$rigaf[negozio2_buyer]);
    }
    }
	foreach ($array_negozi as $sing_negoz) {
	$sqlt = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine != '4' OR stato_ordine != '0') AND categoria != '' AND negozio = '$sing_negoz' ORDER BY categoria ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigat = mysql_fetch_array($risultt)) {
    if ($rigat[categoria] == $categoria_ricercaDaModulo) {
	  echo "<option selected value=".$rigat[categoria].">".ucfirst(str_replace("_"," ",$rigat[categoria]))."</option>";
	} else {
	  echo "<option value=".$rigat[categoria].">".ucfirst(str_replace("_"," ",$rigat[categoria]))."</option>";
	}
	}
	}
    ?>
    </select>
  </div>
</div>
<div class=col>
  <div class="filtri_report" id="scelta_unita">
    <strong>Unit&agrave;</strong><br>
    <select name="unita" class="codice_lista_nopadding" id="unita" style="height:20px; font-size:12px;" onChange="avviso_filtri_on('1')">
    <option selected value="">Scegli unita</option>
    <?php
    if ($negozio2_buyer != "") {
    $sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE (stato_ordine = '2' OR stato_ordine = '3') AND (negozio = '".$negozio1_buyer."' OR negozio = '".$negozio2_buyer."') ORDER BY nome_unita ASC";
    } else {
    $sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE (stato_ordine = '2' OR stato_ordine = '3') AND negozio = '".$negozio1_buyer."' ORDER BY nome_unita ASC";
    }
    $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigag = mysql_fetch_array($risultg)) {
    if ($rigag[id_unita] == $unitaDaModulo) {
    echo "<option selected value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
    } else {
    echo "<option value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
    }
    }
    ?>
    </select>
  </div>
  <div class="filtri_report" id="scelta_codice" style="margin-top:5px;">
    <strong>Codice</strong><br>
    <input name="codice_art" type="text" class="tabelle8" style="height:15px; font-size:12px;" id="codice_art" size="10" value="<?php echo $codice_artDaModulo; ?>" onChange="avviso_filtri_on('1')">
  </div>
</div>
<div class=col>
  <div class="filtri_report" id="data1">
    <strong>Data inizio</strong><br>
    <input name="data_inizio" type="text" class="tabelle8" style="height:15px; font-size:12px;" id="data_inizio" size="10" onClick="Calendar.show(this, '%d/%m/%Y', false)"
    onfocus="Calendar.show(this, '%d/%m/%Y', false)" onBlur="Calendar.hide()" onChange="avviso_filtri_on('1')" value="<?php echo $data_inizio; ?>">
  </div>
  <div class="filtri_report" id="butt_filter" style="margin-top:15px;">
    <input type="submit" name="button" id="button" value="Filtra">
  </div>
  <input name="ricerca" type="hidden" id="ricerca" value="1">
</div>
<div class=col>
  <div class="filtri_report" id="data2">
    <strong>Data fine</strong><br>
    <input name=data_fine type=text class=tabelle8 style="height:15px; font-size:12px;" id=data_fine size=10 onClick="Calendar.show(this, '%d/%m/%Y', false)"
    onfocus="Calendar.show(this, '%d/%m/%Y', false)" onBlur="Calendar.hide()" onChange="avviso_filtri_on('1')" value="<?php echo $data_fine; ?>">
  </div>
  <div class="filtri_report" id="butt_filter" style="margin-top:15px;">
    <input type="reset" name="button" id="button" value="Rimuovi filtri"  onClick="avviso_filtri_on('2')">
  </div>
</div>
<div class="col" id="avviso_filtri" style="color:rgb(255,0,0); font-size:14px; font-weight:bold;">
<?php
if (($_GET[button] != "") AND (($_GET[shop]!="") OR ($_GET[categoria]!="") OR ($_GET[unita]!="") OR ($_GET[codice_art]!="") OR ($_GET[data_inizio]!="") OR ($_GET[data_fine]!=""))) {
	echo "Filtri di ricerca attivi";
}
?>
</div>
</form>
</div><!--fine formRicerca-->

</div><!--fine div id=ricerca class=submenuRicerca-->

<!--inizio contenitore testata-->
<div id="columns_testata">
<!--div num rda testata-->
<div class="cod1">
<?php echo $testata_id_ordine; ?>
 <!--fine div num rda testata-->
</div>
<!--div data testata-->
<div class="cod1">
<?php echo $testata_data; ?>
 <!--fine div data testata-->
</div>
<!--div codice testata-->
<div id="confez5">
    <?php
	echo $testata_codice;
    ?>
 <!--fine div codice testata-->
</div>
<!--div descrizione testata-->
<div class="descr4">
     <?php
	echo $testata_prodotto;
    ?>
 <!--fine div descrizione testata-->
</div>
<!--div unità testata-->
<div class="cod1">
    <?php echo $unita; ?>
 <!--fine div unità testata-->
</div>
<!--div quant testata-->
<div class="price6_quant">
    <?php echo $testata_quant; ?>
 <!--fine div quant testata-->
</div>
<!--div totale testata-->
<div class="price6">
    <?php echo $testata_totale; ?> &euro;
 <!--fine div totale testata-->
</div>

<!--div vuoto testata (vuoto)-->
<div class="vuoto9">
Stato RdA
 <!--fine div vuoto testata-->
</div>
</div>

  <?php
  $array_righe_rda = array();
  $array_rda = array();
	$num_rda_titolo = "";
//**********************
//solo per buyer
//introdotta una variante per la ricerca. In modalità "visualizzazione filtrata", faccio vedere solo le righe interessate dalla ricerca, quindi si fa una procedura diversa dall'individuazione della rda totale, che nella modalità classica è la normalità
//************************
 $querya = $testoQuery;

//inizia il corpo della tabella
$result = mysql_query($querya);
//inizio while RDA
while ($row = mysql_fetch_array($result)) {
$add_righe_rda = array_push($array_righe_rda,$row[id]);
if (!in_array($row[id_rda],$array_rda)) {
$add_rda = array_push($array_rda,$row[id_rda]);
}
}
/*echo "array_rda: ";
print_r($array_rda);
echo "<br>";
*/
if ($flag_ricerca != "") {
	//visualizzazione ricerca
  foreach ($array_righe_rda as $sing_riga) {
//echo "<span style=\"color:rgb(0,0,0);\">riga".$sing_riga."</span><br>";	  
	    $sqlv = "SELECT * FROM qui_righe_rda WHERE id = '$sing_riga'";
  $risultv = mysql_query($sqlv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
   if ($rigav[id_rda] != $num_rda_titolo) {
	  $num_rda_titolo = $rigav[id_rda];
//echo "<span style=\"color:rgb(0,0,0);\">rda".$num_rda_titolo."</span><br>";	  
	  $sqly = "SELECT * FROM qui_rda WHERE id = '$rigav[id_rda]'";
	  $risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigay = mysql_fetch_array($risulty)) {
		$ut_rda = "<img src=immagini/spacer.gif width=25 height=2>Utente ".stripslashes($rigay[id_utente])."<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
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
	  $querys = "SELECT * FROM qui_files_sap WHERE id_rda = '$rigav[id_rda]'";
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
  echo "<div id=blocco_rda_".$num_rda_titolo." class=cont_rda>";
  echo "<div class=riassunto_rda>";
  if ($tipo_negozio != "assets") {
  echo "RDA ".$num_rda_titolo.$tipo_negozio.$tracciati_sap.$ut_rda;
  } else {
  $output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
  $output_wbs .= " (".$wbs_visualizzato.")";
  echo "RDA ".$num_rda_titolo.$tipo_negozio.$output_wbs.$ut_rda;
  }
  $wbs_visualizzato = "";
  $output_wbs = "";
  echo "</div>";
  echo "<div class=stato_rda>";
  echo $imm_status;
  echo "</div>";
  $tracciati_sap = "";
   $sf = 1;
  
  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$num_rda_titolo'";
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
  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$num_rda_titolo.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
  } else {
  $tooltip_select = $tooltip_deseleziona_tutto;
  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$num_rda_titolo.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
  }
  }
  
  $Num_righe_rda_selezionate = "";
  
  echo "<div class=sel_all>";
  if ($Num_righe_processate < $Num_righe_rda) {
  echo $bottone_immagine;
  }
  echo "</div>";
  }

//   fine if ($num_rda_titolo != $num_rda_titolo) {
}
  
  $sqln = "SELECT * FROM qui_righe_rda WHERE id = '$sing_riga'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_totale_righe = mysql_num_rows($risultn);
  while ($rigan = mysql_fetch_array($risultn)) {
  if ($sf == 1) {
  //inizio contenitore riga
  echo "<div class=columns_righe2>";
  } else {
  echo "<div class=columns_righe1>";
  }
  //div num rda riga
  echo "<div class=cod1_riga>";
  echo $rigan[id_rda];
  //fine div num rda riga
  echo "</div>";
  //div data riga
  echo "<div class=cod1_riga>";
  echo date("d.m.Y",$rigan[data_inserimento]);
  //fine div data riga
  echo "</div>";
  //div codice riga
  echo "<div id=confez5_riga>";
  echo $rigan[codice_art];
  //fine div codice riga
  echo "</div>";
  //div pulsante per visualizzare scheda
  echo "<div class=lente_prodotto>";
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
  if ($rigam[categoria3_it] == "") {
  echo "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  } else {
  echo "<a href=scheda_visuale.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  }
  //fine div pulsante per visualizzare scheda
  echo "</div>";
/*
*/
  
  //div descrizione riga
  echo "<div class=descr4_riga>";
  echo $rigan[descrizione];
  //fine div descrizione riga
  echo "</div>";
  
  
  //div nome unità riga
  echo "<div class=cod1_riga>";
  echo $rigan[nome_unita];
  //fine div nome unità riga
  echo "</div>";
  //div quant riga
  echo "<div class=price6_riga_quant>";
  echo $rigan[quant];
  echo "</div>";
  //div totale riga
  echo "<div class=price6_riga>";
  echo number_format($rigan[totale],2,",",".");
  //fine div totale riga
  echo "</div>";
  
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
  echo "<div class=".$button_style.">";
  echo strtoupper($rigan[output_mode]);
  //fine div output mode riga
  echo "</div>";
  
  //div evaso (vuoto)
  echo "<div class=vuoto9_riga>";
  if ($rigan[evaso_magazzino] == 1) {
  echo " evaso";
  }
  //fine div evaso
  echo "</div>";
  //div checkbox (vuoto)
  echo "<div class=sel_all_riga id=".$rigan[id].">";
  if ($rigan[output_mode] == "") {
  switch ($rigan[flag_buyer]) {
  case "0":
  echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.");\">";
  break;
  case "1":
  echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.");\">";
  $contatore_righe_flag = $contatore_righe_flag + 1;
  break;
  }
  } else {
  if ($rigan[flag_buyer] > 1) {
  $contatore_x_chiusura = $contatore_x_chiusura + 1;
  }
  
  }
  //fine div checkbox
  echo "</div>";
	if ($sf == 1) {
	$sf = 0;
	} else {
	$sf = 1;
	}
  
  
  //fine riga singola
  echo "</div>";
  // fine while $rigan 
  }
  //fine foreach
  }
  // fine blocco rda 
  echo "</div>";
$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";

//div per note e pulsanti processi
echo "<div class=servizio>";
echo "<div class=note_pregresse>";
if ($note_utente != "") {
echo "Utente ".stripslashes($nome_utente_rda).": <strong>".$note_utente."</strong><br>";
}
if ($note_resp != "") {
echo "Responsabile ".stripslashes($nome_resp_rda).": <strong>".$note_resp."</strong><br>";
}
if ($note_magazziniere != "") {
echo "Magazziniere: <strong>".$note_magazziniere."</strong><br>";
}
echo "</div>";
echo "<div class=note>";
		if ($note_buyer != "") {
   echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">".$note_buyer."</textarea>";
		} else {
   echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">Note</textarea>";
		}
echo "</div>";
echo "<div class=messaggio id=mess_".$sing_rda." title=mess_".$sing_rda.">";
echo "</div>";

echo "<div style=\"height:auto; width:150px; float:left;\">";
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$sing_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_ordini = mysql_num_rows($risultp);
if ($num_ordini > 0) {
echo "<div id=ordini_".$sing_rda." class=puls_servizio style=\"height:auto; border-bottom:1px solid #CCC;\">";
while ($rigap = mysql_fetch_array($risultp)) {
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('ordine_fornitore.php?id_ord=".$rigap[id]."&id_rda=".$rigap[id_rda]."&lang=".$lingua."', 'myPop1',800,800);\">";
if ($rigap[ordine_interno] != "") {
echo "Ordine ".$rigap[ordine_interno];
} else {
echo "Ordine ".$rigap[id];
}
echo "</a><br>";

}
echo "</div>";
}
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$sing_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$sing_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
echo "Stampa RdA";
echo "</div></a>";
if ($Num_righe_evadere == $Num_righe_rda) {
echo "<a href=\"javascript:void(0);\" onclick=\"chiusura('".$sing_rda."')\"><div class=puls_servizio>";
//echo "<a href=ordini.php><div class=puls_servizio>";
echo "Chiudi RdA";
echo "</div></a>";
}
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

echo "<div id=puls_processa_".$sing_rda.">";
if ($contatore_righe_flag > 0) {
echo "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$sing_rda.")}})\"><strong>Processa RdA</strong></a></div>";
}
echo "</div>";
//fine blocco pulsantini a destra
echo "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine contenitore riga tabella
  echo "</div>";
//fine contenitore righe
  echo "</div>";
} else {
//visualizzazione normale
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
  
  //inizio div rda
  echo "<div id=blocco_rda_".$sing_rda." class=cont_rda>";
  echo "<div class=riassunto_rda>";
  if ($tipo_negozio != "assets") {
  echo "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
  } else {
  $output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
  $output_wbs .= " (".$wbs_visualizzato.")";
  echo "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
  }
  $wbs_visualizzato = "";
  $output_wbs = "";
  echo "</div>";
  echo "<div class=stato_rda>";
  echo $imm_status;
  echo "</div>";
  $tracciati_sap = "";
   $sf = 1;
  
  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
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
  /*} else {
  if ($rigak[flag_buyer] >= 2) {
  $Num_righe_processate = $Num_righe_processate + 1;
  }
  */
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
  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$sing_rda.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
  } else {
  $tooltip_select = $tooltip_deseleziona_tutto;
  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$sing_rda.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
  }
  }
  
  $Num_righe_rda_selezionate = "";
  
  echo "<div class=sel_all>";
  if ($Num_righe_processate < $Num_righe_rda) {
  /*if ($Num_righe_processate == $Num_righe_rda) {
  } else {
  */echo $bottone_immagine;
  }
  echo "</div>";
  }
  
  
  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_totale_righe = mysql_num_rows($risultn);
  while ($rigan = mysql_fetch_array($risultn)) {
  if ($sf == 1) {
  //inizio contenitore riga
  echo "<div class=columns_righe2>";
  } else {
  echo "<div class=columns_righe1>";
  }
  //div num rda riga
  echo "<div class=cod1_riga>";
  echo $rigan[id_rda];
  //fine div num rda riga
  echo "</div>";
  //div data riga
  echo "<div class=cod1_riga>";
  echo date("d.m.Y",$rigan[data_inserimento]);
  //fine div data riga
  echo "</div>";
  //div codice riga
  echo "<div id=confez5_riga>";
  echo $rigan[codice_art];
  //fine div codice riga
  echo "</div>";
  //div pulsante per visualizzare scheda
  echo "<div class=lente_prodotto>";
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
  if ($rigam[categoria3_it] == "") {
  echo "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  } else {
  echo "<a href=scheda_visuale.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  }
  //fine div pulsante per visualizzare scheda
  echo "</div>";
  
  //div descrizione riga
  echo "<div class=descr4_riga>";
  echo $rigan[descrizione];
  //fine div descrizione riga
  echo "</div>";
  
  
  //div nome unità riga
  echo "<div class=cod1_riga>";
  echo $rigan[nome_unita];
  //fine div nome unità riga
  echo "</div>";
  //div quant riga
  echo "<div class=price6_riga_quant>";
  echo $rigan[quant];
  echo "</div>";
  //div totale riga
  echo "<div class=price6_riga>";
  echo number_format($rigan[totale],2,",",".");
  //fine div totale riga
  echo "</div>";
  
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
  echo "<div class=".$button_style.">";
  echo strtoupper($rigan[output_mode]);
  //fine div output mode riga
  echo "</div>";
  
  //div evaso (vuoto)
  echo "<div class=vuoto9_riga>";
  if ($rigan[evaso_magazzino] == 1) {
  echo " evaso";
  }
  //fine div evaso
  echo "</div>";
  //div checkbox (vuoto)
  echo "<div class=sel_all_riga id=".$rigan[id].">";
  if ($rigan[output_mode] == "") {
  switch ($rigan[flag_buyer]) {
  case "0":
  echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.");\">";
  break;
  case "1":
  echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.");\">";
  $contatore_righe_flag = $contatore_righe_flag + 1;
  break;
  }
  } else {
  if ($rigan[flag_buyer] > 1) {
  $contatore_x_chiusura = $contatore_x_chiusura + 1;
  }
  
  }
  //fine div checkbox
  echo $sf."</div>";
  
  //fine riga singola
  echo "</div>";

  
	if ($sf == 1) {
	$sf = 0;
	} else {
	$sf = 1;
	}
  //fine foreach
  }
//div riga grigia separatrice
//echo "<div class=riga_divisoria>";
//echo "</div>";


$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";

//div per note e pulsanti processi
echo "<div class=servizio>";
echo "<div class=note_pregresse>";
if ($note_utente != "") {
echo "Utente ".stripslashes($nome_utente_rda).": <strong>".$note_utente."</strong><br>";
}
if ($note_resp != "") {
echo "Responsabile ".stripslashes($nome_resp_rda).": <strong>".$note_resp."</strong><br>";
}
if ($note_magazziniere != "") {
echo "Magazziniere: <strong>".$note_magazziniere."</strong><br>";
}
echo "</div>";
echo "<div class=note>";
		if ($note_buyer != "") {
   echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">".$note_buyer."</textarea>";
		} else {
   echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">Note</textarea>";
		}
echo "</div>";
echo "<div class=messaggio id=mess_".$sing_rda." title=mess_".$sing_rda.">";
echo "</div>";

echo "<div style=\"height:auto; width:150px; float:left;\">";
$sqlp = "SELECT * FROM qui_ordini_for WHERE id_rda = '$sing_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_ordini = mysql_num_rows($risultp);
if ($num_ordini > 0) {
echo "<div id=ordini_".$sing_rda." class=puls_servizio style=\"height:auto; border-bottom:1px solid #CCC;\">";
while ($rigap = mysql_fetch_array($risultp)) {
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('ordine_fornitore.php?id_ord=".$rigap[id]."&id_rda=".$rigap[id_rda]."&lang=".$lingua."', 'myPop1',800,800);\">";
if ($rigap[ordine_interno] != "") {
echo "Ordine ".$rigap[ordine_interno];
} else {
echo "Ordine ".$rigap[id];
}
echo "</a><br>";

}
echo "</div>";
}
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$sing_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$sing_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
echo "Stampa RdA";
echo "</div></a>";
if ($Num_righe_evadere == $Num_righe_rda) {
echo "<a href=\"javascript:void(0);\" onclick=\"chiusura('".$sing_rda."')\"><div class=puls_servizio>";
//echo "<a href=ordini.php><div class=puls_servizio>";
echo "Chiudi RdA";
echo "</div></a>";
}
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$Num_righe_rda = "";

echo "<div id=puls_processa_".$sing_rda.">";
if ($contatore_righe_flag > 0) {
echo "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$sing_rda.")}})\"><strong>Processa RdA</strong></a></div>";
}
echo "</div>";
//fine blocco pulsantini a destra
echo "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine contenitore riga tabella
  echo "</div>";
//fine contenitore righe
  echo "</div>";
}
//fine if ricerca
}





//riga del totale generale
echo "<div class=columns_righe2>";
//div num rda riga
echo "<div class=cod1_riga>";
//fine div num rda riga
echo "</div>";
//div data riga
echo "<div class=cod1_riga>";
//fine div data riga
echo "</div>";
//div codice riga
echo "<div id=confez5_riga>";
//fine div codice riga
echo "</div>";
//div descrizione riga
echo "<div class=descr4_riga>";
//fine div descrizione riga
echo "</div>";
//div nome unità riga
echo "<div class=cod1_riga>";
//fine div nome unità riga
echo "</div>";
//div quant riga
echo "<div class=price6_riga_quant>";
echo "<strong>TOTALE</strong>";
echo "</div>";
//div totale riga
echo "<div class=price6_riga>";
echo number_format($totale_storico_rda,2,",",".");
//fine div totale riga
echo "</div>";
//div output mode riga (vuoto)
echo "<div class=vuoto9_riga>";
//fine div output mode riga
echo "</div>";
//div evaso (vuoto)
echo "<div class=vuoto9_riga>";
//fine div evaso
echo "</div>";
//div checkbox (vuoto)
echo "<div class=vuoto9_riga>";
//fine div checkbox
echo "</div>";

//fine contenitore totale
echo "</div>";
?>
</div>





<script type="text/javascript">
function axc(id_riga,valoreCheck,id_rda){
						/*alert(id_riga);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda.php",   
						data: "singola=1"+"&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_righe=<?php echo $categ_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&nr_rda=<?php echo $nrRdaDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function axc_multi(id_rda,valoreCheck){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda.php",   
						data: "multipla=1"+"&lang=<?php echo $lingua; ?>&check="+valoreCheck+"&id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}

function closeJS(id_rda){
						
				$.ajax({
						type: "GET",   
						url: "aggiorna_riga_rda_chiusura.php",  
						data: "id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function chiusura(id_rda){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "imposta_chiusura_new.php",   
						data: "multipla=1"+"&id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function aggiorna_nota(id_nota,id_rda) {
var tx_testo = id_nota.value.replace(/\r?\n/g, '<br>');
				/*alert(tx_testo);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_nota.php",   
						data: "testo="+tx_testo+"&id_rda="+id_rda,
						success: function(output) {
						$('#aaa').html(output).show();
						}
						});
}
function svuota_nota(id_nota) {
var div_agg = "#"+id_nota;
				alert(div_agg);
				$.ajax({
						type: "GET",   
						url: "svuota_nota.php",   
						/*data: "id_rda="+id_rda,*/
						success: function(output) {
						$(div_agg).html(output).show();
						}
						});
}
function avviso_filtri_on(discr) {
	if (discr == "2") {
$("#avviso_filtri").html(" ");
	} else {
$("#avviso_filtri").html("Filtri di ricerca attivi");
	}
}

</SCRIPT>
</body>
</html>
