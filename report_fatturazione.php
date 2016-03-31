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

$doc = $_GET[doc];
switch ($doc) {
	case "G":
	  $tipo_documento = "Giroconto";
	break;
	case "F":
	  $tipo_documento = "Fatture";
	break;
}
$pag_attuale = "report_fatturazione";
$pl_gest = $_GET[pl_gest];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
$archive = $_GET['archive'];
include "functions.php";
//include "funzioni.js";

$querym = "SELECT * FROM qui_buyer_funzioni WHERE user_id = '$id_utente'";
$resultm = mysql_query($querym);
while ($rowm = mysql_fetch_array($resultm)) {
	$visualizza_pulsanti = $rowm[F_fatt_visual];
	}

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
if ($_POST['limit'] != "") {
$limit = $_POST['limit'];
} else {
$limit = $_GET['limit'];
}
if ($_POST['page'] != "") {
$page = $_POST['page'];
} else {
$page = $_GET['page'];
}
if ($_POST['ricerca'] != "") {
$ricerca = $_POST['ricerca'];
} else {
$ricerca = $_GET['ricerca'];
}
$avviso = $_GET['avviso'];

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
$ricerca = $_GET['ricerca'];
if (isset($_GET['unita'])) {
$unitaDaModulo = $_GET['unita'];
} 
if ($unitaDaModulo != "") {
$a = "id_unita = '$unitaDaModulo'";
$clausole++;
}
  if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$b = "id_rda = '$nrRdaDaModulo'";
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
//$gginizio = $pieces_inizio[0]; 
//$mminizio = $pieces_inizio[1];
//$aaaainizio = $pieces_inizio[2];
$gginizio = $pieces_inizio[0]; 
$mminizio = $pieces_inizio[1];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
//$ggfine = $pieces_fine[0]; 
//$mmfine = $pieces_fine[1];
//$aaaafine = $pieces_fine[2];
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
$c = "(data_chiusura BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = 1;
$inizio_range = mktime(12,30,0,1,1,2013);
$fine_range = mktime();
$c = "(data_chiusura BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
if (isset($_GET['nr_pl'])) {
$nr_plDaModulo = $_GET['nr_pl'];
} 
if ($nr_plDaModulo != "") {
$e = "n_ord_sap LIKE '%$nr_plDaModulo%'";
$clausole++;
}
$f = "flag_chiusura = '1'";
//$h = "evaso_magazzino = '1'";
$clausole++;

if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
$g = "azienda_utente = '".$societaDaModulo."'";
$clausole++;
}

switch ($doc) {
	case "G":
	case "F":
	  $m = "n_ord_sap = ''";
	  $clausole++;
	  $ordinamento = "azienda_utente ASC";
	break;
	case "R":
	  $m = "n_ord_sap != ''";
	  $doc = "F";
	  $arc = "1";
	  $clausole++;
	  $ordinamento = "azienda_utente ASC";
	break;
}

$h = "pack_list > '0'";
$clausole++;
if ($_GET['nr_fatt'] != "") {
$nr_fattDaModulo = $_GET['nr_fatt'];
} 
if ($nr_fattDaModulo != "") {
	switch ($file_presente) {
		case "report_fatturazione.php":
		  $p = "n_fatt_sap LIKE '%$nr_fattDaModulo%'";
		break;
	}
$clausole++;
}
$r = "((output_mode = 'mag') OR (output_mode = 'lab'))";
$clausole++;


//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole == 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' ";
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ";
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
if ($g != "") {
$testoQuery .= $g;
$sumquery .= $g;
}
if ($h != "") {
$testoQuery .= $h;
$sumquery .= $h;
}
if ($j != "") {
$testoQuery .= $j;
$sumquery .= $j;
}
if ($m != "") {
$testoQuery .= $m;
$sumquery .= $m;
}
if ($p != "") {
$testoQuery .= $p;
$sumquery .= $p;
}
if ($r != "") {
$testoQuery .= $r;
$sumquery .= $r;
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
$testoQuery .= $f." AND ";
$sumquery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
$sumquery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h." AND ";
$sumquery .= $h." AND ";
}
if ($j != "") {
$testoQuery .= $j." AND ";
$sumquery .= $j." AND ";
}
if ($m != "") {
$testoQuery .= $m." AND ";
$sumquery .= $m." AND ";
}
if ($p != "") {
$testoQuery .= $p." AND ";
$sumquery .= $p." AND ";
}
if ($r != "") {
$testoQuery .= $r;
$sumquery .= $r;
}
}
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4'";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '4'";
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
/*
//condizioni per evitare errori
if(($limit == "") OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 500; //default
 } 

if(($page == "") OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 
*/
//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito più sotto
//if ($clausole > 0) {
$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);
//}

//if ($clausole > 0) {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
$testoQuery .= " ORDER BY ".$ordinamento;
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}
//if ($clausole > 0) {
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;
//}

//echo "<span style=\"color:red;\">testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."</span><br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
include "traduzioni_interfaccia.php";
?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<!--<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">-->
<style type="text/css">
<!--
#outerWrap {
position: relative;
z-index: 0;
/*min-height: 400px;
overflow:hidden;
*/height: auto;
width: 960px;
margin:auto;
}
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
	text-align:left;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align:center;
}
.container_righe {
	width:958px;
	height:auto;
	/*background-color:red;*/
	float:left;
	/*display:none;*/
	border:1px solid lightgrey;
	/*display:block;*/
}
.Stile3 {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
th {
	color:#000;
	font-weight:bold;
}
.ui-widget-header {
	background-color:#F63;
	background-image:none !important;
	border-color:#F63;
}
#layer1 {
position: absolute;
z-index: 1;
height: auto;
width: 960px;
top: 0px;
left: 0px; 
	text-align:left;
}
 
#layer2 {
position: absolute;
z-index: 2;
background-color:rgb(255,255,255);
height: 6000px;
width: 960px;
top: 0px;
left: 0px;
opacity:0.9;
}
-->
</style>

<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<!--<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>-->
<script type="text/javascript" src="tinybox.js"></script>
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
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  //window.location.reload();
  location.replace('report_righe.php?selezione_singola=&selezione_multipla=');
}
</SCRIPT>
	<script>
    /*var width = viewportSize.getWidth();
    var height = viewportSize.getHeight();
	alert(height);*/
		// Wait for window load
		$(window).load(function() {
			// Animate loader off screen
			$("#layer2").fadeOut(2000);
			/*$("#layer2").animate({
				left: -4000
			}, 1500);*/
		});
	</script>

<script type="text/javascript">
function notifica_salvataggio(sing_rda){
var n_ord = document.getElementById('ord'+sing_rda).value;
var n_fatt = document.getElementById('fatt'+sing_rda).value;

var status_n_ord = document.getElementById('ord'+sing_rda).disabled;
var status_n_fatt = document.getElementById('fatt'+sing_rda).disabled;
/*alert(sing_rda);*/	
if((n_ord != "") && (status_n_ord==false)) {
window.open('messaggio_notifica.php?avviso=ordine_sap&rda="+sing_rda+"','Conferma','height=150,width=500,status=no,toolbar=no,menubar=no,location=no,left=500,top=350');
}
if((n_fatt != "") && (status_n_fatt==false)) {
window.open('messaggio_notifica.php?avviso=fattura_sap&rda="+sing_rda+"','Conferma','height=150,width=500,status=no,toolbar=no,menubar=no,location=no,left=500,top=350');
}
}
</script>

</head>
<?php

if ($attiva_alert != "") {
echo "<body onLoad=\"TINY.box.show({url:'popup_notifica.php?avviso=rda_sbagliata&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:100,fixed:false,maskid:'bluemask',maskopacity:40,})\">";
//echo "<body onLoad=window.open('popup_notifica.php?avviso=config','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
} else {
echo "<body>";
}

?>
<div id="outerWrap">
  <div id="layer2">
    <div style="margin:20%; width:60%; height:60%; color: #999; text-align:center; font-size:24px;">
      Sto caricando i dati/<br>Loading data<br><br><img src="images/preloader_image.gif">
    </div>
  </div>
  <div id="layer1">

<div id="main_container">
<!--<div id = vvv class=contenitore_riga>
</div>
<div id="contenitore_testata">
<div class="box_120">
Codice
</div>
<div class="box_450">
Prodotto
</div>

<div class="box_130_dx">
Quantit&agrave;
</div>
<div class="box_130_dx">
Totale
</div>
<div class="box_100_20">
Stato
</div>
</div>-->
  <?php
include "testata_amministrazione.php";
include "modulo_filtri_fatt.php"; 
//include "menu_amministrazione.php";
//div ricerca righe fatturazione
//if ($clausole > 0) {
	//echo '<span style="color: red;">doc: '.$doc.'</span><br>';
	//echo '<span style="color: red;">arc: '.$arc.'</span><br>';
if ($ricerca == 1) {
  echo '<div class="sommari_euro">';
  echo "Totale</div>";
  echo '<div class="sommari_euro">euro '.number_format($totale_storico_rda,2,",",".").'</div>';
if ($nrRdaDaModulo != "") {
  echo '<div style="float: left; color: #000; font-weight: bold;">Attenzione! Il risultato ottenuto potrebbe essere parziale.</div>';
}
 $querya = $testoQuery;
 $sf = 1;
//$querya = $testoQuery;
//inizia il corpo della tabella
$array_company_ids = array();
$array_units = array();
$array_pl = array();
$array_ord_sap = array();
$array_fatt_sap = array();
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	if (!in_array($row[pack_list].'-'.$row[azienda_prodotto],$array_pl)) {
		$add_pl = array_push($array_pl,$row[pack_list].'-'.$row[azienda_prodotto]);
	}
	if (!in_array($row[azienda_utente].'-'.$row[azienda_prodotto],$array_company_ids)) {
		$add_company = array_push($array_company_ids,$row[azienda_utente].'-'.$row[azienda_prodotto]);
	}
	if ($row[n_ord_sap] != "0") {
	  if (!in_array($row[n_ord_sap],$array_ord_sap)) {
		  $add_ord = array_push($array_ord_sap,$row[n_ord_sap]);
	  }
	}
	if ($row[n_fatt_sap] != "0") {
	  if (!in_array($row[n_fatt_sap],$array_fatt_sap)) {
		  $add_fatt = array_push($array_fatt_sap,$row[n_fatt_sap]);
	  }
	}
}
sort($array_fatt_sap);
sort($array_ord_sap);
/*
echo "<span style=\"color:black;\">array_pl: ";
print_r($array_pl);
echo "</span><br>";
echo "<span style=\"color:black;\">array_company_ids: ";
print_r($array_company_ids);
echo "</span><br>";
*/
switch ($doc) {
//BLOCCO PER PAGINA RICHIESTA FATTURA
case "F":
case "G":
foreach ($array_company_ids as $sing_company) {
  $array_pl_comp = array();
	$progressivo = $progressivo + 1;
	$postrat = stripos($sing_company,"-");
	$venditore = substr($sing_company,($postrat+1));
	$idcomp = substr($sing_company,0,$postrat);
	$queryw = "SELECT DISTINCT pack_list FROM qui_righe_rda WHERE azienda_utente = '$idcomp' ORDER BY pack_list ASC";
	$resultw = mysql_query($queryw);
	while ($roww = mysql_fetch_array($resultw)) {
	  if (in_array($roww[pack_list].'-'.$venditore,$array_pl)) {
		$add_pl_comp = array_push($array_pl_comp,$roww[pack_list]);
		$blocco_pl .= $roww[pack_list].';';
	  }
	}
	
$blocco_pl = substr($blocco_pl,0,(strlen($blocco_pl)-1));
foreach ($array_pl_comp as $pl_singolo) {
  $sommapl =  "SELECT SUM(totale) as totale_pl FROM qui_righe_rda WHERE pack_list = '".$pl_singolo."' AND azienda_prodotto = '$venditore'";
  $resulth = mysql_query($sommapl);
  list($totale_pl) = mysql_fetch_array($resulth);
  $totale_fattura = $totale_fattura + $totale_pl;
}
	  echo '<div id= "glob_'.$progressivo.'" style="width: 100%; min-height: 30px; overflow: hidden; height: auto;">';
	echo "<a name=".$progressivo.">";
	  echo '<div class="contenitore_rda_testfatt" style="padding-top: 10px; background-color: #888; color:white; text-decoration:none;">';
	$queryz = "SELECT * FROM qui_company WHERE IDCompany = '$idcomp'";
	$resultz = mysql_query($queryz);
	while ($rowz = mysql_fetch_array($resultz)) {
	  $nome_sing_company = $rowz[Company];
	}
	  echo '<div style="width: 150px; height: 20px; float: left;">'.$nome_sing_company.'</div>
	  <div style="text-align: right; width: 130px; height: 20px; float: left; margin: 0px 50px 0px 10px;">Totale euro '.number_format($totale_fattura,2,",",".").'</div>';
	  if (($doc == "F") || ($doc == "R")) {
	  echo '<div style="width: 400px; height: 20px; float: left; margin-top: -3px;">';
		if ($visualizza_pulsanti == "1") {
		  echo '<div style ="width:154px; height:22px; float:left;">';
			  echo '<input type="hidden" name="venditore'.$progressivo.'" id="venditore'.$progressivo.'" value="'.$venditore.'">';
		  if ($n_fatt_sap != "") {
			echo '<input type="text" name="ord'.$progressivo.'" id="ord'.$progressivo.'" disabled style ="width:150px; height:22px; background-color:#fff; border: 1px solid #E4E4E4; color: #686868; padding-left:3px; padding-top:3px;" onFocus="azzera_campoord(this.id,'.$progressivo.')" onBlur="ripristina_campoord(this.id,'.$progressivo.')"';
		  } else {
			if ($n_ord_sap != "") {
			  echo '<input type="text" name="ord'.$progressivo.'" id="ord'.$progressivo.'" disabled style ="width:150px; height:22px; background-color:#fff; border: 1px solid #E4E4E4; color: #686868; padding-left:3px; padding-top:3px;" onFocus="azzera_campoord(this.id,'.$progressivo.')" onBlur="ripristina_campoord(this.id,'.$progressivo.')"';
			} else {
			  echo '<input type="text" name="ord'.$progressivo.'" id="ord'.$progressivo.'" style ="width:150px; height:22px; background-color:#fff; border: 1px solid #E4E4E4; color: #686868; padding-left:3px; padding-top:3px;" onFocus="azzera_campoord(this.id,'.$progressivo.')" onBlur="ripristina_campoord(this.id,'.$progressivo.')"';
			}
		  }
		  if ($n_ord_sap != "") {
			echo " value=".$n_ord_sap.">";
		  } else {
			echo " value=\"Ordine SAP\">";
		  }
		  echo "</div>";
/*		  	
	echo '<div style="width:154px; height:22px; margin-left:10px; float:left;">';
	if ($n_ord_sap != "") {
		//se il numero ordine sap è inserito,
	  if ($n_fatt_sap != "") {
		  //se il numero fattura sap è inserito,  niente campo, solo valore
		echo $n_fatt_sap;
	  } else {
		echo "<input type=text name=fatt".$sing_company." id=fatt".$sing_company." style =\"width:150px; height:22px; background-color:#E4E4E4; color: #686868; border: none; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campofatt(this.id,".$sing_company.")\"";
		  echo ' value="Fattura SAP">';
	  }
	} else {
		//altrimenti il campo n fatt sap è disabilitato
	  echo "<input type=text name=fatt".$sing_company." id=fatt".$sing_company." disabled style =\"width:150px; height:22px; background-color:#E4E4E4; color: #686868; border: none; padding-left:3px; padding-top:3px;\"";
	  if ($n_fatt_sap != "") {
		echo " value=".$sing_company.">";
	  } else {
		echo ' value="Fattura SAP">';
	  }
	}
	echo "</div>";	
echo 'blocco_pl: '.$blocco_pl.'<br>';
*/	
	$blocco_pl = str_replace("|",";",$blocco_pl);
	switch ($doc) {
		case "F":
		  if ($n_ord_sap == "") {
			echo '<a href="javascript:void(0);"><div style ="width:auto; height:14px; font-size: 13px; background-color:#F63; margin-left:10px; color:white; float:left; padding:4px;" onClick="salvataggio_ordine(\''.$blocco_pl.'\','.$idcomp.','.$progressivo.'); notifica_salvataggio('.$sing_pl.');">';
			echo "Inserisci";
			echo "</div></a>";
		  }
		break;
	}
  }
	  echo '</div>';
}
	  echo '<div id="pulsante_'.$progressivo.'" style="width: 30px; height: 20px; float: right; margin-right: 20px; margin-top: -3px; cursor:pointer; text-align: right;" onclick="vis_invis_unit('.$progressivo.')"><img src="immagini/a-piu.png"></div>';
	  if ($nrRdaDaModulo == "") {
	  echo "<div style=\"width: 50px; height: 20px; float: right; margin-right: 20px; cursor:pointer;\" onclick=\"PopupCenter('vista_fattura.php?mode=print&blocco_pl=".$blocco_pl."&company=".$idcomp."&venditore=".$venditore."', 'myPop1',800,800);\">PDF</div>";
	  }
	  echo '<div style="width: 50px; height: 20px; float: right; margin-right: 20px;">';
	switch($venditore) {
		case "SOL":
		  echo '<img src="immagini/bottone-sol.png" border="0">';
		break;
		case "VIVISOL":
		  echo '<img src="immagini/bottone-vivisol.png" border="0">';
		break;
	}/**/
	echo '</div>';
/*  
foreach ($array_pl as $cad_pl) {
	$queryw = "SELECT * FROM qui_packing_list WHERE id = '$cad_pl' AND id_unita = '$sing_company'";
	$resultw = mysql_query($queryw);
	while ($roww = mysql_fetch_array($resultw)) {
	  $logo_pl = $roww[logo];
	}
}
	echo "<div id=logo_".$cad_pl." style =\"width:30px; height:20px; margin-right:25px; float:right;\">";
	switch($logo_pl) {
		case "sol":
		  echo '<img src="immagini/bottone-sol.png" border="0">';
		break;
		case "vivisol":
		  echo '<img src="immagini/bottone-vivisol.png" border="0">';
		break;
	}
	echo "</div>";
*/	
	  echo "</div>";
  echo "<div id=unit".$progressivo." class=contenitore_pl_unit>";
foreach ($array_pl_comp as $sing_pl) {
	$queryx = "SELECT * FROM qui_packing_list WHERE id = '$sing_pl'";
	$resultx = mysql_query($queryx);
	$presenza_pl = mysql_num_rows($resultx);
	while ($rowx = mysql_fetch_array($resultx)) {
	  $n_ord_sap = $rowx[n_ord_sap];
	  $n_fatt_sap = $rowx[n_fatt_sap];
	  $logo_pl = $rowx[logo];
	}
	if ($presenza_pl > 0) {
  $array_rda_pl = array();
  $array_resp = array();
  echo '<div id="test'.$sing_pl.'" class="contenitore_rda_testfatt" style="width:943px;">';
	$querys = "SELECT * FROM qui_corrispondenze_pl_rda WHERE pl = '$sing_pl'";
	$results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
	  if (!in_array($rows[rda],$array_rda_pl)) {
		$add_rdapl = array_push($array_rda_pl,$rows[rda]);
	  }
	}
	foreach ($array_rda_pl as $sing_rdapl) {
	  $lista_rdapl .= $sing_rdapl." ";
	  $queryh = "SELECT * FROM qui_rda WHERE id = '$sing_rdapl'";
	  $resulth = mysql_query($queryh);
	  while ($row = mysql_fetch_array($resulth)) {
		  $lista_unita = $row[nome_unita]." ";
		$queryk = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
		$resultk = mysql_query($queryk);
		while ($rowk = mysql_fetch_array($resultk)) {
		  $lista_resp = $rowk[nome]." ";
		}
	  }
	}
	echo "<a name=".$sing_pl.">";
	  echo "<div class=box_450 style=\"width:680px; color:white; text-decoration:none; cursor:pointer;\" onClick=\"vis_invis(".$sing_pl.")\">";
		echo "RdA ".$lista_rdapl."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		echo "Resp. ".$lista_resp."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		echo "Unit&agrave; ".$lista_unita."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		echo "PL ".$sing_pl;
	  echo "</div>";
	echo "</a>";
	$lista_rdapl = "";
	$lista_resp = "";
	$lista_unita = "";
	echo "<div id=rif_ord_".$sing_pl." style =\"width:90px; height:20px; margin-top:5px; float:left;\">";
	if ($n_ord_sap != "") {
	  echo "ODV ".$n_ord_sap;
	}
	echo "</div>";
	echo "<div id=rif_fatt_".$sing_pl." style =\"width:90px; height:20px; margin-top:5px; float:left;\">";
	if ($n_fatt_sap != "") {
	  echo "FT ".$n_fatt_sap;
	}
	echo "</div>";
	//tasto pdf
	//echo "<a href=\"javascript:void(0);\">";
	echo "<div style =\"width:30px; height:20px; margin-top:5px; float:left; text-decoration:none; color:white; cursor:pointer; text-align: right;\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$sing_pl."&lang=".$lingua."', 'myPop1',800,800);\">";
	echo "PDF";
	echo "</div>";
	//echo "</a>";
  echo "</div>";
  //singolo contenitore
  if ($pl_gest == $sing_pl) {
  echo '<div id="pl'.$sing_pl.'" class="contenitore_rda_fattura" style="display:block; padding-left: 0px !important; width: 947px;">';
  } else {
  echo '<div id="pl'.$sing_pl.'" class="contenitore_rda_fattura" style="display:none; padding-left: 0px !important; width: 947px;">';
  }
	foreach ($array_rda_pl as $sing_rdapl) {
	  echo "<div class=contenitore_gruppo_merci style=\"margin-top:5px; width:800px; float:left;\">";
	  echo "RdA ".$sing_rdapl;
	  echo "</div>";
		$sum_parz_rda = "SELECT SUM(totale) as somma_parz_rda FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND azienda_prodotto = '$venditore'";
		  $resultf = mysql_query($sum_parz_rda);
		  list($somma_parz_rda) = mysql_fetch_array($resultf);
	  echo '<div class="box_130_dx" style="font-weight:bold; width: 100px; float: right; padding-right:0px;">';
	  echo number_format($somma_parz_rda,2,",",".");
	  echo "</div>";
	  $somma_parz_rda = "";
	  //if ($clausole <= 5) {
		$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND azienda_prodotto = '$venditore' ORDER BY gruppo_merci ASC";
	  //} else {
		//$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND dest_contab = '$dest_contab' ORDER BY gruppo_merci ASC";
	  //}
	 //echo '<span style="color:red;">clausole: '.$clausole.'<br>';
	 //echo $queryg.'</span><br>';
	  $resultg = mysql_query($queryg);
	  while ($rowg = mysql_fetch_array($resultg)) {
		if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
		  if ($gruppo_merci_uff != "") {
			echo "<div class=riga_separazione>";
			echo "</div>";
		  }
		  $gruppo_merci_uff = $rowg[gruppo_merci];
		  $querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
		  $results = mysql_query($querys);
		  while ($rows = mysql_fetch_array($results)) {
			$descrizione_gruppo_merci = $rows[descrizione];
			$codice_sap = $rows[codice_sap];
		  }
			$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE pack_list = '$sing_pl' AND gruppo_merci = '$gruppo_merci_uff' AND azienda_prodotto = '$venditore'";
		  $resultz = mysql_query($sum_grm);
		  list($somma_grm) = mysql_fetch_array($resultz);
		  $totale_grm = $somma_grm;
		  //$TOTALE_pl = $TOTALE_pl + $totale_grm;
		  echo '<div class="contenitore_gruppo_merci" style="width: 938px;">';
			echo "<div class=box_120>";
			  echo $gruppo_merci_uff;
			echo "</div>";
			echo "<div class=box_570>";
			  echo $codice_sap." ".stripslashes($descrizione_gruppo_merci);
			echo "</div>";
			echo "<div class=box_130_dx>";
			  echo "-";
			  //echo number_format($rowg[quant],2,",",".");
			echo "</div>";
			echo '<div class="box_130_dx" style="width: 100px; float: right; padding-right:0px;">';
			  echo number_format($totale_grm,2,",",".");
			echo "</div>";
		  echo "</div>";
		  $totale_grm = "";
		}
		echo '<div class="contenitore_riga_fattura" style="width: 938px;">';
		  echo "<div class=box_120>";
			if (substr($rowg[codice_art],0,1) != "*") {
			  echo $rowg[codice_art];
			} else {
			  echo substr($rowg[codice_art],1);
			}
		  echo "</div>";
		  echo "<div class=box_570>";
			echo stripslashes($rowg[descrizione]);
			//echo " - ".$rowg[output_mode];
		  echo "</div>";
		  echo "<div class=box_130_dx>";
			echo intval($rowg[quant]);
		  echo "</div>";
		  echo '<div class="box_130_dx" style="width: 100px; float: right; padding-right:0px;">';
			echo number_format($rowg[totale],2,",",".");
			$TOTALE_pl = $TOTALE_pl + $rowg[totale];
		  echo "</div>";
		echo "</div>";	
	  //fine while $sing_rdapl
	  }
	//fine foreach ($array_rda_pl as $sing_rdapl) {
	}

	echo "<div class=riga_separazione>";
	echo "</div>";	
  $gruppo_merci_uff = "";
  echo '<div class="contenitore_gruppo_merci" style="padding-left:0px; width:938px;">';
  echo '<div style ="width:105px; height:20px; margin-top:10px; float:right; padding-top:3px; text-align:right;">';
  echo 'euro '.number_format($TOTALE_pl,2,",",".");
  echo "</div>";	
  echo "<div style =\"width:60px; height:20px; margin-top:10px; float:right; padding-top:3px;\">";
  echo "Totale";
  echo "</div>";	
  echo "</div>";	
  //echo "</div>";	
  //fine singolo contenitore
  echo "</div>";	
  $TOTALE_pl = "";
  //fine if pl appartiene all'unità
	}
	$presenza_pl = "";
  //FINE FOREACH PL
}
$totale_fattura = "";

  $n_ord_sap = "";
  echo "</div>";	
  //fine div glob_
  echo "</div>";	
$blocco_pl = '';
  //FINE FOREACH COMPANY
}
break;
//BLOCCO PER PAGINA REGISTRAZIONE FATTURA
case "R":
/*
echo '<span style="color: red;">array_fatt_sap: ';
print_r($array_fatt_sap);
echo '<br>';
echo '<br>';
echo 'array_ord_sap: ';
print_r($array_ord_sap);
echo '</span><br>';
*/
foreach ($array_ord_sap as $sing_ord) {
	$queryx = "SELECT * FROM qui_RdF WHERE n_ord_sap = '$sing_ord'";
	$resultx = mysql_query($queryx);
	while ($rowx = mysql_fetch_array($resultx)) {
	  $n_fatt_sap = $rowx[n_fatt_sap];
	 $id_fatt = $rowx[id];
	$sing_company = $rowx[id_company];
	$nome_sing_company = $rowx[nome_company];
	$logo_fatt = $rowx[logo];
	}
$array_pl_ord = array();
	$queryw = "SELECT * FROM qui_packing_list WHERE n_ord_sap = '$sing_ord'";
	$resultw = mysql_query($queryw);
	while ($roww = mysql_fetch_array($resultw)) {
		  $add_pl_ord = array_push($array_pl_ord,$roww[id]);
		  $blocco_pl .= $roww[id].';';
	}
$blocco_pl = substr($blocco_pl,0,(strlen($blocco_pl)-1));
  $sommapl =  "SELECT SUM(totale) as totale_fatt FROM qui_righe_rda WHERE n_ord_sap = '".$sing_ord."'";
  $resulth = mysql_query($sommapl);
  list($totale_fatt) = mysql_fetch_array($resulth);
  $importo_fatt = $totale_fatt;
	  echo '<div id= "glob_'.$id_fatt.'" style="width: 100%; min-height: 30px; overflow: hidden; height: auto;">';
	echo "<a name=".$id_fatt.">";
	  echo '<div class="contenitore_rda_testfatt" style="padding-top: 10px; background-color: #888; color:white; text-decoration:none;">';
	  echo '<div style="width: 150px; height: 20px; float: left;">'.$nome_sing_company.'</div>
	  <div style="text-align: right; width: 130px; height: 20px; float: left; margin: 0px 50px 0px 10px;">Totale euro '.number_format($importo_fatt,2,",",".").'</div>';
	  echo '<div style="width: 400px; height: 20px; float: left; margin-top: -3px;">';
		if ($visualizza_pulsanti == "1") {
		  echo '<div style ="width:154px; height:22px; float:left;">';
			echo "<span style=\"margin:1px 5px 0px 0px; color: #dedede;\">Ord. n. </span><input type=text name=ord".$id_fatt." id=ord".$id_fatt." disabled style =\"width:100px; height:22px; background-color: transparent !important; border: none; color: #dedede; font-weight: normal !important; padding-left:0px; margin-top: -1px;\" onFocus=\"azzera_campoord(this.id,".$id_fatt.")\"";
			echo " value=".$sing_ord.">";
		  echo "</div>";	
	echo '<div style="width:154px; height:22px; margin-left:10px; float:left;">';
echo '<input type="hidden" name="venditore'.$id_fatt.'" id="venditore'.$id_fatt.'" value="'.$logo_fatt.'">';
if ($n_fatt_sap != "") {
		  //se il numero fattura sap è inserito,  niente campo, solo valore
		echo '<div style="margin:3px 5px 0px 0px; color: #dedede; font-weight: normal !important;">Fatt. n '.$n_fatt_sap.'</div>';
	  } else {
		echo '<input type="text" name="fatt'.$id_fatt.'" id="fatt'.$id_fatt.'" style="width:150px; height:22px; color: #686868; border: none; padding-left:3px; padding-top:3px;" onFocus="azzera_campofatt(this.id,'.$id_fatt.')" onBlur="ripristina_campofatt(this.id,'.$id_fatt.')"';
		  echo ' value="Fattura SAP">';
	  }
	echo "</div>";	
		  if ($n_fatt_sap == "") {
			  $blocco_pl = str_replace("|",";",$blocco_pl);
			  $blocco_pl = str_replace(""," ",$blocco_pl);
			echo '<a href=javascript:void(0);"><div style ="width:auto; height:14px; font-size: 13px; background-color:#F63; margin-left:10px; color:white; float:left; padding:4px;" onClick="salvataggio_fattura(\''.$blocco_pl.'\','.$id_fatt.')">';
			echo "Inserisci";
			echo "</div></a>";
		  }
  }
	  echo '</div>';




	  echo '<div id="pulsante_'.$id_fatt.'" style="width: 30px; height: 20px; float: right; margin-right: 20px; margin-top: -3px; cursor:pointer; text-align: right;" onclick="vis_invis_unit('.$id_fatt.')"><img src="immagini/a-piu.png"></div>';
	  if ($nrRdaDaModulo == "") {
	  echo "<div style=\"width: 30px; height: 20px; float: right; margin-right: 20px; cursor:pointer;\" onclick=\"PopupCenter('vista_fattura.php?mode=print&blocco_pl=".$blocco_pl."&company=".$sing_company."&venditore=".$logo_fatt."', 'myPop1',800,800);\">PDF</div>";
	  }
/*	  
*/
	echo "<div id=logo_".$cad_pl." style =\"width:30px; height:20px; margin-right:25px; float:right;\">";
	switch($logo_fatt) {
		case "sol":
		case "SOL":
		  echo '<img src="immagini/bottone-sol.png" border="0">';
		break;
		case "vivisol":
		case "VIVISOL":
		  echo '<img src="immagini/bottone-vivisol.png" border="0">';
		break;
	}
	/*
*/	
	echo "</div>";
	  echo "</div>";
	echo "</a>";
  echo "<div id=unit".$id_fatt." class=contenitore_pl_unit>";
foreach ($array_pl_ord as $sing_pl) {
  $array_rda_pl = array();
  $array_resp = array();
  echo '<div id="test'.$sing_pl.'" class="contenitore_rda_testfatt" style="width:943px;">';
	$querys = "SELECT * FROM qui_corrispondenze_pl_rda WHERE pl = '$sing_pl'";
	$results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
	  if (!in_array($rows[rda],$array_rda_pl)) {
		$add_rdapl = array_push($array_rda_pl,$rows[rda]);
	  }
	}
	foreach ($array_rda_pl as $sing_rdapl) {
	  $lista_rdapl .= $sing_rdapl." ";
	  $queryh = "SELECT * FROM qui_rda WHERE id = '$sing_rdapl'";
	  $resulth = mysql_query($queryh);
	  while ($row = mysql_fetch_array($resulth)) {
		  $lista_unita = $row[nome_unita]." ";
		$queryk = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
		$resultk = mysql_query($queryk);
		while ($rowk = mysql_fetch_array($resultk)) {
		  $lista_resp = $rowk[nome]." ";
		}
	  }
	}
	echo "<a name=".$sing_pl.">";
	  echo "<div class=box_450 style=\"width:680px; color:white; text-decoration:none; cursor:pointer;\" onClick=\"vis_invis(".$sing_pl.")\">";
		echo "RdA ".$lista_rdapl."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		echo "Resp. ".$lista_resp."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		echo "Unit&agrave; ".$lista_unita."<img src=immagini/spacer.gif width=15 height=4 border=0>| ";
		echo "PL ".$sing_pl;
	  echo "</div>";
	echo "</a>";
	$lista_rdapl = "";
	$lista_resp = "";
	$lista_unita = "";
	echo "<div id=rif_ord_".$sing_pl." style =\"width:90px; height:20px; margin-top:5px; float:left;\">";
	if ($n_ord_sap != "") {
	  echo "ODV ".$n_ord_sap;
	}
	echo "</div>";
	echo "<div id=rif_fatt_".$sing_pl." style =\"width:90px; height:20px; margin-top:5px; float:left;\">";
	if ($n_fatt_sap != "") {
	  echo "FT ".$n_fatt_sap;
	}
	echo "</div>";
	//tasto pdf
	//echo "<a href=\"javascript:void(0);\">";
	echo "<div style =\"width:30px; height:20px; margin-top:5px; float:left; text-decoration:none; color:white; cursor:pointer; text-align: right;\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$sing_pl."&lang=".$lingua."', 'myPop1',800,800);\">";
	echo "PDF";
	echo "</div>";
	//echo "</a>";
  echo "</div>";
  //singolo contenitore
  if ($pl_gest == $sing_pl) {
  echo '<div id="pl'.$sing_pl.'" class="contenitore_rda_fattura" style="display:block; padding-left: 0px !important; width: 947px;">';
  } else {
  echo '<div id="pl'.$sing_pl.'" class="contenitore_rda_fattura" style="display:none; padding-left: 0px !important; width: 947px;">';
  }
	foreach ($array_rda_pl as $sing_rdapl) {
	  echo "<div class=contenitore_gruppo_merci style=\"margin-top:5px; width:800px; float:left;\">";
	  echo "RdA ".$sing_rdapl;
	  echo "</div>";
		$sum_parz_rda = "SELECT SUM(totale) as somma_parz_rda FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND n_ord_sap = '$sing_ord'";
		  $resultf = mysql_query($sum_parz_rda);
		  list($somma_parz_rda) = mysql_fetch_array($resultf);
	  echo '<div class="box_130_dx" style="font-weight:bold; width: 100px; float: right; padding-right:0px;">';
	  echo number_format($somma_parz_rda,2,",",".");
	  echo "</div>";
	  $somma_parz_rda = "";
	  //if ($clausole <= 5) {
		$queryg = "SELECT * FROM qui_righe_rda WHERE pack_list = '$sing_pl' AND n_ord_sap = '$sing_ord' ORDER BY gruppo_merci ASC";
	  //} else {
		//$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND n_ord_sap = '$n_ord_sap' ORDER BY gruppo_merci ASC";
	  //}
	 //echo '<span style="color:red;">clausole: '.$clausole.'<br>';
	// echo '<span style="color:red;">'.$queryg.'</span><br>';
	  $resultg = mysql_query($queryg);
	  while ($rowg = mysql_fetch_array($resultg)) {
		if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
		  if ($gruppo_merci_uff != "") {
			echo "<div class=riga_separazione>";
			echo "</div>";
		  }
		  $gruppo_merci_uff = $rowg[gruppo_merci];
		  $querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
		  $results = mysql_query($querys);
		  while ($rows = mysql_fetch_array($results)) {
			$descrizione_gruppo_merci = $rows[descrizione];
			$codice_sap = $rows[codice_sap];
		  }
			$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE pack_list = '$sing_pl' AND gruppo_merci = '$gruppo_merci_uff' AND n_ord_sap = '$sing_ord'";
		  $resultz = mysql_query($sum_grm);
		  list($somma_grm) = mysql_fetch_array($resultz);
		  $totale_grm = $somma_grm;
		  //$TOTALE_pl = $TOTALE_pl + $totale_grm;
		  echo '<div class="contenitore_gruppo_merci" style="width: 938px;">';
			echo "<div class=box_120>";
			  echo $gruppo_merci_uff;
			echo "</div>";
			echo "<div class=box_570>";
			  echo $codice_sap." ".stripslashes($descrizione_gruppo_merci);
			echo "</div>";
			echo "<div class=box_130_dx>";
			  echo "-";
			  //echo number_format($rowg[quant],2,",",".");
			echo "</div>";
			echo '<div class="box_130_dx" style="width: 100px; float: right; padding-right:0px;">';
			  echo number_format($totale_grm,2,",",".");
			echo "</div>";
		  echo "</div>";
		  $totale_grm = "";
		}
		echo '<div class="contenitore_riga_fattura" style="width: 938px;">';
		  echo "<div class=box_120>";
			if (substr($rowg[codice_art],0,1) != "*") {
			  echo $rowg[codice_art];
			} else {
			  echo substr($rowg[codice_art],1);
			}
		  echo "</div>";
		  echo "<div class=box_570>";
			echo stripslashes($rowg[descrizione]);
			//echo " - ".$rowg[output_mode];
		  echo "</div>";
		  echo "<div class=box_130_dx>";
			echo intval($rowg[quant]);
		  echo "</div>";
		  echo '<div class="box_130_dx" style="width: 100px; float: right; padding-right:0px;">';
			echo number_format($rowg[totale],2,",",".");
			$TOTALE_pl = $TOTALE_pl + $rowg[totale];
		  echo "</div>";
		echo "</div>";	
	  //fine while $sing_rdapl
	  }
	//fine foreach ($array_rda_pl as $sing_rdapl) {
	}

	echo "<div class=riga_separazione>";
	echo "</div>";	
  $gruppo_merci_uff = "";
  echo '<div class="contenitore_gruppo_merci" style="padding-left:0px; width:938px;">';
  echo '<div style ="width:105px; height:20px; margin-top:10px; float:right; padding-top:3px; text-align:right;">';
  echo 'euro '.number_format($TOTALE_pl,2,",",".");
  echo "</div>";	
  echo "<div style =\"width:60px; height:20px; margin-top:10px; float:right; padding-top:3px;\">";
  echo "Totale";
  echo "</div>";	
  echo "</div>";	
  //echo "</div>";	
  //fine singolo contenitore
  echo "</div>";	
  $TOTALE_pl = "";
  //FINE FOREACH PL
}
$totale_fattura = "";

  $n_ord_sap = "";
  echo "</div>";	
  //fine div glob_
  echo "</div>";	
$blocco_pl = '';
  //FINE FOREACH ORDINI SAP'
}

break;
}
	//if ($ricerca != "") {
echo "<div class=contenitore_rda_fattura style=\"margin-top:10px; margin-bottom:10px;\">";
    echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td class=num_pag>";

//posizione per paginazione
$last_page = $total_pages;
   if ($total_pages <= 10) {
  	 	$pag_iniz = 1;
  	 	$pag_fin = $total_pages -1;
   } else {
	   if ($page < ($total_pages - 10)) {
			$pag_iniz = $page;
			$pag_fin = $page + 9;
	   } else {
			$pag_iniz = $total_pages - 10;
			$pag_fin = $total_pages -1;
	   }
   }
$prev_page = $page - 1;
/*
//variabili da aggiungere ai numeri della paginazione per la ricerca corretta
$categ_DaModulo = $_GET['categoria_righe'];
$unitaDaModulo = $_GET['unita'];
$data_inizio = $_GET['data_inizio'];
$data_fine = $_GET['data_fine'];
$shopDaModulo = $_GET['shop'];
$nrRdaDaModulo = $_GET['nr_rda'];
$gruppo_merciDaModulo = $_GET['gruppo_merci_righe'];
$codice_artDaModulo = $_GET['codice_art'];
*/
   if($page > 1) {
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b>1</b></a>"; 

  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b>".$last_page."</b></a>"; 
        echo "</td>";
     echo " </tr>";
    echo "</table>";


    echo "</div>";
}
?>

</div>

<!--fine outer wrap-->
</div>


<script type="text/javascript">

$(".slideDownbox").click(function () {
   $(this).hide().slideDown('slow');
});
 
$(".slideUpbox").click(function () {
   $(this).slideUp(2000);
});

$.datepicker.regional['it'] = {
    closeText: 'Chiudi', // set a close button text
    currentText: 'Oggi', // set today text
    monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',   'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'], // set month names
    monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'], // set short month names
    dayNames: ['Domenica','Luned&#236','Marted&#236','Mercoled&#236','Gioved&#236','Venerd&#236','Sabato'], // set days names
    dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'], // set short day names
    dayNamesMin: ['Do','Lu','Ma','Me','Gio','Ve','Sa'], // set more short days names
    dateFormat: 'dd/mm/yy' // set format date
};

$.datepicker.setDefaults($.datepicker.regional['it']);
$(function(){
$(".datepicker").datepicker();
/*$('.datepicker').datepicker("option", "dateFormat", "dd/mm/yy" ) ;*/
});
function calend(id){
$("#"+id).datepicker();
/*$(".datepicker").datepicker();
$('.datepicker').datepicker("option", "dateFormat", "dd/mm/yy" ) ;*/
};
 
function mostra_nascondi(id) {
	/*alert(id);*/
	//$("#test"+id).click(function () {
   $('#pl'+id).slideToggle(1000);
//});
}

function azzera_campoord(id,pl) {
var campo_ord = document.getElementById('ord'+pl).value;
var id_ord = document.getElementById('ord'+pl).id;
	/*alert(id);*/
if(campo_ord == "Ordine SAP") {
document.getElementById('ord'+pl).value = '';
}
}
function ripristina_campoord(id,pl) {
var campo_ord = document.getElementById('ord'+pl).value;
var id_ord = document.getElementById('ord'+pl).id;
	/*alert(id);*/
if(campo_ord == "") {
document.getElementById('ord'+pl).value = 'Ordine SAP';
}
}

function azzera_campofatt(id,contatore) {
var campo_fatt = document.getElementById('fatt'+contatore).value;
var id_fatt = document.getElementById('fatt'+contatore).id;
	/*alert(id_fatt);*/
if(campo_fatt == "Fattura SAP") {
document.getElementById('fatt'+contatore).value = '';
}
}
function ripristina_campofatt(id,contatore) {
var campo_fatt = document.getElementById('fatt'+contatore).value;
var id_fatt = document.getElementById('fatt'+contatore).id;
	/*alert(id_fatt);*/
if(campo_fatt == "") {
document.getElementById('fatt'+contatore).value = 'Fattura SAP';
}
}

function salvataggio_ordine(blocco_pl,company,progr){
  var venditore = document.getElementById('venditore'+progr).value;
  var n_ord = document.getElementById('ord'+progr).value;
	  /*alert("venditore: "+venditore);*/
  if(document.getElementById('ord'+progr).disabled==false) {
	if((n_ord == "") || n_ord == "Ordine SAP") {
	  alert("Errore: Valore del numero ordine SAP non valido");
	  n_ord.focus();
	  return false;
	} else {
	  if (confirm("Confermi di voler inserire l'ordine "+n_ord+"?") == true) {
		$.ajax({
		  type: "POST",   
		  url: "aggiorna_ordine_sap.php",   
		  data: "n_ord="+n_ord+"&blocco_pl="+blocco_pl+"&company="+company+"&venditore="+venditore+"&check_ord=1",
		  success: function(output) {
		  $('#glob_'+progr).html(output).show();
		  }
		});
		return true
	  }
	}
  }
}
function salvataggio_fattura(blocco_pl,id){
  var n_ord = document.getElementById('ord'+id).value;
  var n_fatt = document.getElementById('fatt'+id).value;
	  /*
	  alert("ordine SAP "+n_ord);
	  alert("n_fatt "+n_fatt);
	  */
  if(document.getElementById('fatt'+id).disabled==false) {
	if((n_fatt == "") || n_fatt == "Fattura SAP") {
	  alert("Errore: Valore del numero fattura SAP non valido");
	  n_fatt.focus();
	  return false;
	} else {
	  if (confirm("Confermi di voler inserire il numero fattura "+n_fatt+"?") == true) {
		$.ajax({
		  type: "POST",   
		  url: "aggiorna_ordine_sap.php",   
		  data: "n_ord="+n_ord+"&blocco_pl="+blocco_pl+"&n_fatt="+n_fatt+"&id="+id+"&check_fatt=1",
		  success: function(output) {
		  $('#glob_'+id).html(output).show();
		  }
		});
		return true
	  }
	}
  }
}

function vis_invis(id_riga)  {
	/*alert(id_riga);*/
                if ($('#pl'+id_riga).css('display')=='none'){
                    $('#pl'+id_riga).css('display', 'block');
                    $('#test'+id_riga).css('background-color', '#FF835A');
                } else {
                    $('#pl'+id_riga).css('display', 'none');
                    $('#test'+id_riga).css('background-color', '#B4B4B4');
                }
 }
function vis_invis_unit(contatore)  {
	/*alert(id_riga);*/
                if ($('#unit'+contatore).css('display')=='none'){
                    $('#unit'+contatore).css('display', 'block');
                    $('#pulsante_'+contatore).html('<img src="immagini/a-meno.png" border="0">');
                } else {
                    $('#unit'+contatore).css('display', 'none');
                    $('#pulsante_'+contatore).html('<img src="immagini/a-piu.png" border="0">');
                }
 }
 function msc(mode,valore){
	switch (mode) {
		case "data_inizio":
		  var data_inizio_val = valore;
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "data_fine":
		  var data_fine_val = valore;
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		break;
		case "societa":
		  var socval = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "unita":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unitaval = valore;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "shop":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shopval = valore;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
	}
	var nr_rda = document.getElementById('nr_rda').value;
	var nr_pl = document.getElementById('nr_pl').value;
	if((data_inizio_val != "") && (data_fine_val != "")) {
        data1str = data_inizio_val.substr(6)+data_inizio_val.substr(3, 2)+data_inizio_val.substr(0, 2);
		data2str = data_fine_val.substr(6)+data_fine_val.substr(3, 2)+data_fine_val.substr(0, 2);
		//controllo se la seconda data è successiva alla prima
        if (data2str-data1str<0) {
            alert("La data iniziale deve essere precedente quella finale");
			document.getElementById('data_fine').value = "";
        }else{
		  $.ajax({
			type: "POST",   
			url: "motore_ricerca_MSC_fatt.php",   
			data: "societa="+socval+"&nr_pl="+nr_pl+"&shop="+shopval+"&unita="+unitaval+"&nr_rda="+nr_rda+"&data_inizio="+data_inizio_val+"&data_fine="+data_fine_val+"&file_presente=<?php echo $file_presente; ?>"+"&doc=<?php echo $doc; ?>",
			success: function(output) {
			$('#contenitore_msc').html(output).show();
			$("#contenitore_int_msc").fadeIn(1000);
			}
		  })
        }
	} else {
		alert("Entrambre le date sono obbligatorie!");
	}
	/*
	alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);
	*/
}
function msc_data_inizio(mode,valore) {
	var data_fine_val = document.getElementById('data_fine').value;
	if(data_fine_val != "") {
	  msc(mode,valore);
	} else {
	/*alert(mode+" "+valore);*/
	}
}
function invioform() {
	var nr_fatt = document.getElementById('nr_fatt').value;
	var nr_pl = document.getElementById('nr_pl').value;
	var nr_rda = document.getElementById('nr_rda').value;
	var data_inizio = document.getElementById('data_inizio').value;
	var data_fine = document.getElementById('data_fine').value;
	if((nr_pl != "") || (nr_rda != "")  || (nr_fatt != "")) {
		  document.form_filtri2.submit();
	} else {
	  if((data_inizio != "") && (data_fine != "")) {
		  document.form_filtri2.submit();
	  } else {
		  alert("Entrambre le date sono obbligatorie!");
	  }
	}
}
function controllo_data(stringa){
    var espressione = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
    if (!espressione.test(stringa))
    {
        return false;
    }else{
        anno = parseInt(stringa.substr(6),10);
        mese = parseInt(stringa.substr(3, 2),10);
        giorno = parseInt(stringa.substr(0, 2),10);
        
        var data=new Date(anno, mese-1, giorno);
        if(data.getFullYear()==anno && data.getMonth()+1==mese && data.getDate()==giorno){
            return true;
        }else{
            return false;
        }
    }
}

function confronta_data(data1, data2){
	// controllo validità formato data
    if(controllo_data(data1) &&controllo_data(data2)){
		//trasformo le date nel formato aaaammgg (es. 20081103)
        data1str = data1.substr(6)+data1.substr(3, 2)+data1.substr(0, 2);
		data2str = data2.substr(6)+data2.substr(3, 2)+data2.substr(0, 2);
		//controllo se la seconda data è successiva alla prima
        if (data2str-data1str<0) {
            alert("La data iniziale deve essere precedente quella finale");
        }else{
			alert("ok");
        }
    }else{
        alert("Il formato data deve essere gg/mm/aaaa");
    }
}

</script>
</body>
</html>