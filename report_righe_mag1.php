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
	//echo'<span style="color: #000;">array: ';
	//print_r ($_GET);
	//echo '</span><br>';
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
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
$id_rda = $_GET[id_rda];
//echo "selezione_singola: ".$selezione_singola."<br>";
//echo "selezione_multipla_app: ".$selezione_multipla_app."<br>";
$stampa = $_GET[stampa];


include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$azione_form = $_SERVER['PHP_SELF'];
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

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
$avviso = $_GET['avviso'];
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
/*
if (isset($_GET['categoria_righe'])) {
$categ_DaModulo = $_GET['categoria_righe'];
} 
if ($categ_DaModulo != "") {
$b = "categoria = '$categ_DaModulo'";
$clausole++;
}
*/
if ($_GET['SOL_x'] != "") {
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$b = "azienda_prodotto = 'SOL'";
$clausole++;
}
if ($_GET['VIVISOL_x'] != "") {
	//echo '<span style="color: #000;">azienda: VIVISOL</span><br>';
$b = "azienda_prodotto = 'VIVISOL'";
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

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
if ($stampa != "1") {
include "menu_quice3.php";
}
?>
<html>
<head>
  <title>Quice - Processo magazzino</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<style type="text/css">
<!--
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
	float:right;
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
	float:left;
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
	width: 795px;
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
	width: 295px;
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
	padding-left: 10px;
	padding-top: 4px;
}
.lente_prodotto {
	float: left;
	width: 30px;
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
	width: 310px;
	height: 60px;
	color: black;
	background-color: #FFFFCC;
	border:0px solid #FFFFFF;
}
.note {
	float: left;
	width: 310px;
	height: auto;
	/*padding-left:10px;*/
	margin-bottom:10px;
	/*background-color: #393;*/
}

.note_pregresse {
	float: left;
	width: 630px;
	height: auto;
	padding-left:10px;
	padding-top:5px;
	padding-bottom:5px;
}
.messaggio {
	float: left;
	width: 290px;
	height: 60px;
	padding-left:20px;
	font-weight: bold;
	color: black;
	/*background-color: #99FFFF;*/
}
.puls_servizio {
	color: black;
	float: left;
	width: 57px;
	height: 20px;
	padding-left:1px;
	font-weight: bold;
	/*background-color: #FFFF00;*/
}
.puls_servizio a {
	color: black;
}
.bott_pl {
	font-size:9px;
	float: right;
	width: auto;
	height: auto;
	margin-left:12px;
	padding:1px;
	border-style:solid;
	border-width: 1px;
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
   -->
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
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  window.location.href = window.location.href;
}
</SCRIPT>

</head>

<?php
if ($stampa != "1") {
  if ($flag_ricerca != "") {
  echo "<body style=\"background-color:rgb(214,232,246);\">";
  } else {
  echo "<body>";
  }
} else {
  echo "<body onLoad=javascript:window.print()>";
}
?>
<div id="main_container">
<?php include "modulo_filtri.php"; ?>

?>
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

<div id="blocco_generale" style="float:left;">
	<?php
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
  $ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d/m/Y",$rigay[data_inserimento])."<img src=immagini/spacer.gif width=15 height=2>Utente ".stripslashes($rigay[nome_utente])."<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
  switch ($rigay[stato]) {
  case "1":
  $imm_status = '<img src="immagini/stato1.png" width=62 height=17 title="'.$status1.'">';
  break;
  case "2":
  $imm_status = '<img src="immagini/stato2.png" width=62 height=17 title="'.$status2.'">';
  break;
  case "3":
  $imm_status = '<img src="immagini/stato3.png" width=62 height=17 title="'.$status3.'">';
  break;
  case "4":
  $imm_status = '<img src="immagini/stato4.png" width=62 height=17 title="'.$status4.'">';
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
  echo "<div id=generale_".$sing_rda." class=cont_rda>";
  echo '<div style="width: 100%; min-height: 30px; overflow: hidden; height: auto; background-color: #97b4b5;">';
  echo "<div class=riassunto_rda>";
  echo "RDA ".$sing_rda.$ut_rda;
  echo "</div>";
  echo "<div class=stato_rda>";
  echo $imm_status;
  echo "</div>";
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
	$bottone_immagine = '<a href="javascript:void(0);" onclick="axc_multi_mag('.$sing_rda.',3);"><img src="immagini/select-all.png" width="17" height="17" border="0" title="'.$tooltip_select.'"></a>';
  } else {
	$tooltip_select = $tooltip_deseleziona_tutto;
	$bottone_immagine = '<a href="javascript:void(0);" onclick="axc_multi_mag('.$sing_rda.',2);"><img src="immagini/select-none.png" width="17" height="17" border="0" title="'.$tooltip_select.'"></a>';
  }
  
  
  echo '<div class="sel_all" id="sel_all_'.$sing_rda.'">';
  if ($flag_ricerca == "") {
	if ($stampa != "1") {
	  if ($Num_righe_processate < $Num_righe_rda) {
	  echo $bottone_immagine;
	  }
	}
  }
  echo '</div>';
  echo '<div class="stato_rda" style="width:35px; height:21px; padding-top:7px;">';
  echo '</div>';
  echo '</div>';
  //echo "selezionate: ".$Num_righe_rda_selezionate."<br>";
  //echo "processate: ".$Num_righe_processate."<br>";
  //echo "righe totali: ".$Num_righe_rda."<br>";
  //echo "righe da evadere: ".$Num_righe_evadere."<br>";
  $Num_righe_rda_selezionate = "";
  $Num_righe_evadere = "";
  $Num_righe_rda = "";
  //inizio div rda
  echo "<div class=cont_rda id=blocco_rda_".$sing_rda.">";
  
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
  echo '<div class="columns_righe2">';
  } else {
  echo '<div class="columns_righe1">';
  }
  //div codice riga
  echo '<div id="confez5_riga" style="padding-left:10px;">';
  if (substr($rigan[codice_art],0,1) != "*") {
    echo $rigan[codice_art];
  } else {
    echo substr($rigan[codice_art],1);
  }
  //fine div codice riga
  echo '</div>';
  //div descrizione riga
  echo '<div class="descr4_riga" style="width:400px;">';
  echo $rigan[descrizione];
if ($rigan[negozio] == "labels") {
  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigap = mysql_fetch_array($risultp)) {
	  $label_ric_mag = $rigap[ric_mag];
	if ($rigap[ric_mag] != "mag") {
		  echo "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
	}
  }
}
  //fine div descrizione riga
  echo '</div>';
  //div nome unità riga
  echo '<div class="cod1_riga">';
  echo $rigan[nome_unita];
  //fine div nome unità riga
  echo '</div>';
  //div quant riga
  echo '<div class="price6_riga_quant">';
  echo $rigan[quant];
  echo "</div>";
//div pulsante per evasione parziale riga
echo '<div class="lente_prodotto">';
if ($stampa != "1") {
  if (($rigan[negozio] == "labels") AND ($label_ric_mag != "mag")) {
  } else {
if (($rigan[output_mode] == "mag") AND ($rigan[flag_buyer] == "3")) {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_magazz.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rigan[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
  }
}
//fine div pulsante per evasione parziale riga
echo "</div>";
//div pulsante per visualizzare scheda
  echo '<div class="lente_prodotto">';
if ($stampa != "1") {
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
}
  //fine div pulsante per visualizzare scheda
  echo "</div>";
  //div totale riga
  echo '<div class="price6_riga">';
  echo number_format($rigan[totale],2,",",".");
  //fine div totale riga
  echo "</div>";
  
  //div output mode riga (vuoto)
  echo '<div class="vuoto9_riga" style="width:65px;">';
  echo $rigan[output_mode];
  //fine div output mode riga
  echo "</div>";

  //div checkbox (vuoto)
  echo '<div class="sel_all_riga" id='.$rigan[id].'>';
  if ($rigan[evaso_magazzino] == 0) {
if ($stampa != "1") {
    /*if ($flag_ricerca != "") {
      switch ($rigan[flag_buyer]) {
        case "2":
          echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'3',".$sing_rda.");\">";
        break;
        case "3":
          echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"raccolta(".$rigan[id].",'2',".$sing_rda.");\">";
        break;
      }
    } else {*/
      switch ($rigan[flag_buyer]) {
        case "2":
          echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc_mag(".$rigan[id].",'3',".$sing_rda.");\">";
        break;
        case "3":
          echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc_mag(".$rigan[id].",'2',".$sing_rda.");\">";
          $contatore_righe_flag = $contatore_righe_flag + 1;
        break;
      }
    //}
}
  }
  //fine div checkbox
  echo "</div>";
  	echo '<div class="sel_all_riga" style="width:auto; padding:12px 5px 0px 0px;">';
	//echo 'neg: '.$rigan[negozio].'<br>';
	if ($rigan[azienda_prodotto] == "VIVISOL") {
	  echo '<img src="immagini/bottone-vivisol.png">';
	}
	if ($rigan[azienda_prodotto] == "SOL") {
	  echo '<img src="immagini/bottone-sol.png">';
	}
	echo "</div>";

  //fine contenitore riga tabella
  echo "</div>";
  
  if ($sf == 1) {
  $sf = 0;
  } else {
  $sf = 1;
  }
  //fine foreach
  }
  //div riga grigia separatrice
  echo "<div class=riga_divisoria>";
  echo "</div>";
  
  
  $totale_rda = "";
  $selezione_singola = "";
  $selezione_multipla_app = "";
  $sf = "";
  
if ($stampa != "1") {
  //div per note e pulsanti processi
  echo '<div class="servizio">';
  echo '<div class="note_pregresse">';
  echo '<div class="note">';
     echo '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">';
          if ($note_magazziniere != "") {
     echo $note_magazziniere;
          } else {
     echo 'Note';
          }
     echo '</textarea>';
  echo '</div>';
  echo '<div class="messaggio" id="mess_'.$sing_rda.'" title="mess_'.$sing_rda.'">';
  if ($note_utente != "") {
  echo 'Utente '.stripslashes($nome_utente_rda).'<br><strong>'.$note_utente.'</strong><br>';
  }
  if ($note_resp != "") {
  echo 'Responsabile '.stripslashes($nome_resp_rda).'<br><strong>'.$note_resp.'</strong><br>';
  }
  if ($note_buyer != "") {
  echo 'Buyer '.stripslashes($nome_buyer_rda).'<br><strong>'.$note_buyer.'</strong><br>';
  }
  echo '</div>';
  echo '</div>';
  
  
  echo '<div style="height:auto; width:320px; float:left;">';
  $sqlp = "SELECT * FROM qui_corrispondenze_pl_rda WHERE rda = '$sing_rda'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_pack = mysql_num_rows($risultp);
  if ($num_pack > 0) {
  echo '<div id="pack_'.$sing_rda.'" style="width:320px; float:left; height:auto; border-bottom:1px solid #CCC; margin-bottom:10px;">';
  while ($rigap = mysql_fetch_array($risultp)) {
	$sqlb = "SELECT * FROM qui_packing_list WHERE id = '".$rigap[pl]."'";
  $risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigab = mysql_fetch_array($risultb)) {
  if ($rigab[n_ord_sap] == "") {
  echo '<div class="puls_servizio">';
  echo 'PL '.$rigap[pl];
  echo '</div>';
  echo '<a href="javascript:void(0);" onclick="elimina_pl('.$rigap[pl].','.$sing_rda.');">';
  echo '<div class="bott_pl" style="color:red;">';
  echo 'Elimina PL';
  //echo '<img src=immagini/button_elimina.gif width=19 height=19 border=0 title="Elimina PL">';
  echo '</div>';
  echo '</a>';
  echo '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=print&n_pl='.$rigap[pl].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
  echo '<div class="bott_pl" style="color:blue;">';
  echo 'Stampa PL';
  //echo '<img src=immagini/bottone_stamp.png width=19 height=19 border=0 title="Stampa PL">';
  echo '</div>';
  echo '</a>';
  echo '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=cons&n_pl='.$rigap[pl].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
  echo '<div class="bott_pl" style="color:orange;">';
  echo 'Modifica PL';
  //echo '<img src=immagini/bottone-edit.png width=19 height=19 border=0 title="Modifica PL">';
  echo '</div>';
  echo '</a>';
  } else {
  echo '<div class="puls_servizio">';
  echo '<span style="color:rgb(130,130,130);">PL '.$rigap[pl].'</span>';
  echo '<br>';
  echo '</div>';
  }
  
  }
  }
  echo "</div>";
  }
  
  
  $Num_righe_evadere = "";
  $Num_righe_processate = ""; 
  $Num_righe_rda = "";
  
  echo "<div id=puls_processa_".$sing_rda.">";
  if ($contatore_righe_flag > 0) {
  echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?id_rda=".$sing_rda."&lang=".$lingua."&id_utente=".$id_utente."&mode=vis', 'myPop1',800,800);\">";
  echo "<div class=btnFreccia><strong>Crea PL</strong></div></a>";
  }
  echo "</div>";
  echo "</div>";
  
  $contatore_righe_flag = "";
  $contatore_x_chiusura = "";
  /*			echo "<a href=# onClick=\"this.form.submit()\"><div class=btnFreccia>";
          echo "<strong>Processa RdA</strong>";
          echo "</div></a>";
  */
  //fine contenitore pulsantini destra
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
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
  
  //fine div cont rda
  echo "</div>";
  //fine contenitore totale
  echo "</div>";
  //fine contenitore totale
  echo "</div>";
  ?>
  <!--fine blocco generale-->
  </div>
  <!--fine main container-->
</div>





<script type="text/javascript">
$(function(){
$.datepicker.regional['it'] = {
    closeText: 'Chiudi', // set a close button text
    currentText: 'Oggi', // set today text
    monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',   'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'], // set month names
    monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'], // set short month names
    dayNames: ['Domenica','Luned&#236','Marted&#236','Mercoled&#236','Gioved&#236','Venerd&#236','Sabato'], // set days names
    dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'], // set short day names
    dayNamesMin: ['Do','Lu','Ma','Me','Gio','Ve','Sa'], // set more short days names
    dateFormat: 'd/m/Y' // set format date
};

$.datepicker.setDefaults($.datepicker.regional['it']);

$(".datepicker").datepicker();
});
function axc_mag(id_riga,valoreCheck,id_rda){
						/*alert(valoreCheck);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_mag.php",   
						data: "singola=1"+"&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_righe=<?php echo $categ_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&nr_rda=<?php echo $nrRdaDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&lang=<?php echo $lingua; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function raccolta(id_riga,valoreCheck,id_rda){
						/*alert(valoreCheck);*/
				$.ajax({
						type: "GET",   
						url: "imposta_raccolta_mag.php",   
						data: "singola=1"+"&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_ricerca=<?php echo $categoria_ricerca_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&codice_art=<?php echo $codice_artDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&lang=<?php echo $lingua; ?>"+"&lang=<?php echo $lingua; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function axc_multi_mag(id_rda,valoreCheck){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_mag.php",   
						data: "multipla=1"+"&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_righe=<?php echo $categ_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&nr_rda=<?php echo $nrRdaDaModulo; ?>"+"&check="+valoreCheck+"&id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&lang=<?php echo $lingua; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "pulsante_selez.php",   
						data: "check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>",
						success: function(output) {
						$('#sel_all_'+id_rda).html(output).show();
						}
						})

}
function chiusura(pl){
				$.ajax({
						type: "GET",   
						url: "imposta_chiusura_mag.php",   
						data: "unita=<?php echo $unitaDaModulo; ?>"+"&categoria_ricerca=<?php echo $categoria_ricercaDaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&codice_art=<?php echo $codice_artDaModulo; ?>"+"&pl="+pl+"&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&lang=<?php echo $lingua; ?>",
						success: function(output) {
						$('#blocco_generale').html(output).show();
						}
						})

						/*alert(pl);*/
}
function trasf_pl() {
window.open("lista_pl.php");
}
function agg_tendina_unita(categoria){
	var unita = document.getElementById('unita').value;
	var shop = document.getElementById('shop').value;
						/*alert(categoria);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_tendina_unita.php",   
						data: "unita="+unita+"&categoria="+categoria+"&shop="+shop,
						success: function(output) {
						$('#scelta_unita').html(output).show();
						}
						})

}

function agg_tendina_categ(unita){
	var categoria = document.getElementById('categoria_ricerca').value;
	var shop = document.getElementById('shop').value;
	/*alert(unita);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_tendina_categ.php",   
						data: "unita="+unita+"&categoria="+categoria+"&shop="+shop,
						success: function(output) {
						$('#scelta_categoria').html(output).show();
						}
						})

}

function agg_tendina_unita_neg(shop){
	var unita = document.getElementById('unita').value;
	var categoria = document.getElementById('categoria_ricerca').value;
						/*alert(categoria);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_tendina_unita_neg.php",   
						data: "unita="+unita+"&categoria="+categoria+"&shop="+shop,
						success: function(output) {
						$('#scelta_unita').html(output).show();
						}
						})

}

function agg_tendina_categ_neg(shop){
	var unita = document.getElementById('unita').value;
	var categoria = document.getElementById('categoria_ricerca').value;
	/*alert(unita);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_tendina_categ_neg.php",   
						data: "unita="+unita+"&categoria="+categoria+"&shop="+shop,
						success: function(output) {
						$('#scelta_categoria').html(output).show();
						}
						})

}
function aggiorna_nota(id_nota,id_rda) {
var tx_testo = id_nota.value;
				/*alert(tx_argomento);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_nota_mag.php",   
						data: "testo="+tx_testo+"&id_rda="+id_rda+"&tipo_utente=magazziniere",
						success: function(output) {
						$('#aaa').html(output).show();
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
function refresh_rda(id_rda){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "refresh_blocco_sing_rda_mag.php",   
						data: "id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function elimina_pl(id_pl,id_rda){
						/*
						alert(id_pl+","+id_rda);
						*/
	  if (confirm("Sei proprio sicuro di eliminare il PL selezionato?<br>Fai un refresh della pagina dopo aver terminato l'operazione") == true) {
		  /*x = "La modifica è stata registrata!";*/
		$.ajax({
		  type: "GET",   
		  url: "eliminazione_pl.php",   
		  data: "id_pl="+id_pl+"id_rda="+id_rda,
		  success: function(output) {
		$('#blocco_rda_'+id_rda).html(output).show();
		  }
		  })
	  }
}
</SCRIPT>
</body>
</html>
