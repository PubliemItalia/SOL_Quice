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

$pag_attuale = "report_fatturazione";
$rda_gest = $_GET[rda_gest];
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
$campidate = 1;
$inizio_range = mktime(12,30,0,10,1,2013);
$fine_range = mktime();
$c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
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
if (isset($_GET['nazione'])) {
$nazioneDaModulo = $_GET['nazione'];
} 
//if ($nazioneDaModulo != "") {
	switch ($nazioneDaModulo) {
		case "":
		$f = "nazione != 'Italy'";
		$clausole++;
		break;
		case "tutte":
		break;
		case "eu":
		$f = "nazione != 'Italy'";
		$clausole++;
		break;
		case "it":
		$f = "nazione = 'Italy'";
		$clausole++;
		break;
	}
//}

if (isset($_GET['archivio'])) {
$archivioDaModulo = $_GET['archivio'];
} 
//if ($archivioDaModulo != "") {
	switch ($archivioDaModulo) {
		case "":
		$m = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "0":
		break;
		case "1":
		$m = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "2":
		$m = "n_fatt_sap != ''";
		$clausole++;
		break;
	}
//	}

if (isset($_GET['nr_rda'])) {
$nr_rdaDaModulo = $_GET['nr_rda'];
} 
if ($nr_rda != "") {
$g = "id_rda = '$nr_rdaDaModulo'";
$clausole++;
}

$h = "stato_ordine = '4'";
//$h = "evaso_magazzino = '1'";
$clausole++;

$j = "output_mode = 'mag'";
$clausole++;

//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole == 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_righe_rda ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda ";
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE  ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ";
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
$testoQuery .= $m;
$sumquery .= $m;
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

//condizioni per evitare errori
if(($limit == "") OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 40; //default
 } 

if(($page == "") OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 

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
$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}
//if ($clausole > 0) {
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;
//}

//echo "testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
include "menu_reportistica.php";
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
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  //window.location.reload();
  location.replace('report_righe.php?selezione_singola=&selezione_multipla=');
}
</SCRIPT>

	<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
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
//div ricerca righe fatturazione
echo "<div id=ricerca class=submenureport>";
echo "<div id=formRicerca>";
echo "<form action=".$azione_form." method=get name=form_filtri2>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$shop."</strong><br>";
echo "<select name=shop class=codice_lista_nopadding id=shop>";
switch ($shopDaModulo) {
case "":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
//echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "assets":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option selected value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "consumabili":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option selected value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "spare_parts":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option selected value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "labels":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option selected value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "vivistore":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option selected value=vivistore>".$tasto_vivistore."</option>";
break;
/**/
}
echo "</select>";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$unita."</strong><br>";
echo "<select name=unita class=ecoform id=unita>";
echo "<option selected value=>".$scegli_unita."</option>";
$sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda ORDER BY nome_unita ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
if ($rigag[id_unita] == $unitaDaModulo) {
echo "<option selected value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
} else {
echo "<option value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
}
}
echo "</select>";
echo "</div>";
//div con la ricerca x categoria e x gruppo merce
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>";
switch ($_SESSION[lang]) {
	case "it":
	echo "Italia/Europa";
	break;
	case "en":
	echo "Italy/Europe";
	break;
}

echo "</strong><br>";
echo "<select name=nazione class=ecoform id=nazione>";
switch($nazioneDaModulo) {
	case "":
	  echo "<option value=tutte>Tutte</option>";
	  echo "<option selected value=eu>Europa</option>";
	  echo "<option value=it>Italia</option>";
	break;
	case "tutte":
	  echo "<option selected value=tutte>Tutte</option>";
	  echo "<option value=eu>Europa</option>";
	  echo "<option value=it>Italia</option>";
	break;
	case "eu":
	  echo "<option value=tutte>Tutte</option>";
	  echo "<option selected value=eu>Europa</option>";
	  echo "<option value=it>Italia</option>";
	break;
	case "it":
	  echo "<option value=tutte>Tutte</option>";
	  echo "<option value=eu>Europa</option>";
	  echo "<option selected value=it>Italia</option>";
	break;
}
echo "</select>";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>";
switch ($_SESSION[lang]) {
	case "it":
	echo "Archivio PL";
	break;
	case "en":
	echo "PL Archive";
	break;
}
echo "</strong><br>";
echo "<select name=archivio class=ecoform id=archivio>";
switch($archivioDaModulo) {
	case "":
	  echo "<option value=0>Tutti i PL</option>";
	  echo "<option selected value=1>PL Attivi</option>";
	  echo "<option value=2>PL Archiviati</option>";
	break;
	case "0":
	  echo "<option selected value=0>Tutti i PL</option>";
	  echo "<option value=1>PL Attivi</option>";
	  echo "<option value=2>PL Archiviati</option>";
	break;
	case "1":
	  echo "<option value=0>Tutti i PL</option>";
	  echo "<option selected value=1>PL Attivi</option>";
	  echo "<option value=2>PL Archiviati</option>";
	break;
	case "2":
	  echo "<option value=0>Tutti i PL</option>";
	  echo "<option value=1>PL Attivi</option>";
	  echo "<option selected value=2>PL Archiviati</option>";
	break;
}
echo "</select>";
echo "</div>";
//div con la ricerca x num rda
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>Nr. RdA</strong><br>";
echo "<input name=nr_rda type=text class=tabelle8 id=nr_rda size=10 value=".$nrRdaDaModulo.">";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>Nr SAP</strong><br>";
echo "<input name=nr_pl type=text class=tabelle8 id=nr_pl size=10 value=".$nr_plDaModulo.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testo_data_inizio."</strong><br>";
echo "<input name=data_inizio type=text class=tabelle8 id=data_inizio size=10 onclick=\"Calendar.show(this, '%d/%m/%Y', false)\"
onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\" value=".$data_inizio.">";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$testo_data_fine."</strong><br>";
echo "<input name=data_fine type=text class=tabelle8 id=data_fine size=10 onclick=\"Calendar.show(this, '%d/%m/%Y', false)\"
onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\" value=".$data_fine.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<br><input type=submit name=button id=button value=".$filtra.">";

echo "<input name=stato_rda type=hidden id=stato_rda value=4>";
echo "<input name=output_mode type=hidden id=output_mode value=MAG>";
echo "<input name=ricerca type=hidden id=ricerca value=1>";
echo "<br><br><a href=xls2_pl.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nr_rdaDaModulo."&nr_pl=".$nr_plDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&archivio=".$archivioDaModulo."&nazione=".$nazioneDaModulo."&output=mag&stato_rda=4 target=_blank><span class=Stile3>".$esporta."</span></a>";
echo "</div>";
/*
echo "<div class=col_excel>";
echo "<br><a href=xls2.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&stato_rda=".$stato_rdaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine." target=_blank><span class=Stile3>".$esporta."</span></a>";
echo "</div>";
*/
echo "</form>";
echo "</div>";//fine formRicerca
echo "</div>";//fine div ricerca fatturazione

//if ($clausole > 0) {
$array_rda = array();
 $querya = $testoQuery;
 $sf = 1;
//$querya = $testoQuery;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	if (!in_array($row[id_rda],$array_rda)) {
		$add_rda = array_push($array_rda,$row[id_rda]);
	}
}
foreach ($array_rda as $sing_rda) {
//	echo "<div id=test".$sing_rda." class=contenitore_rda onClick=\"mostra_nascondi(".$sing_rda.")\">";
	echo "<div id=test".$sing_rda." class=contenitore_rda_testfatt onClick=\"vis_invis(".$sing_rda.")\">";
$queryh = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
$resulth = mysql_query($queryh);
while ($row = mysql_fetch_array($resulth)) {
$queryk = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
$resultk = mysql_query($queryk);
while ($rowk = mysql_fetch_array($resultk)) {
$nome_resp = $rowk[nome];
}
$n_ord_sap = $row[n_ord_sap];
$n_fatt_sap = $row[n_fatt_sap];
	echo "<a name=".$sing_rda." href=\"javascript:void(0);\">";
echo "<div class=box_450 style=\"width:680px; color:white; text-decoration:none;\">";
echo "RdA ".$sing_rda."<img src=immagini/spacer.gif width=15 height=4 border=0>| ".date("d/m/Y",$row[data_inserimento])."<img src=immagini/spacer.gif width=15 height=4 border=0>| Responsabile ".$nome_resp;
echo "<img src=immagini/spacer.gif width=15 height=4 border=0>| Unit&agrave; ".$row[nome_unita];
echo "</div>";
	echo "</a>";
echo "<div id=rif_ord_".$sing_rda." style =\"width:100px; height:20px; margin-top:5px; float:left;\">";
if ($n_ord_sap != "") {
echo "ODV ".$n_ord_sap;
}
echo "</div>";
echo "<div id=rif_fatt_".$sing_rda." style =\"width:100px; height:20px; margin-top:5px; float:left;\">";
if ($n_fatt_sap != "") {
echo "FT ".$n_fatt_sap;
}
echo "</div>";
//tasto pdf
$queryj = "SELECT * FROM qui_packing_list WHERE rda = '$sing_rda'";
$resultj = mysql_query($queryj);
$presenza_pck = mysql_num_rows($resultj);
while ($rowj = mysql_fetch_array($resultj)) {
	$n_pl = $rowj[id];
}
if ($presenza_pck > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$n_pl."&lang=".$lingua."', 'myPop1',800,800);\">";
echo "<div style =\"width:50px; height:20px; margin-top:5px; float:left; text-decoration:none; color:white;\">";
	echo "PDF";
echo "</div>";
	echo "</a>";
	$n_pl = "";
}
}
echo "</div>";
//singolo contenitore
if ($rda_gest == $sing_rda) {
echo "<div id=rda".$sing_rda." class=contenitore_rda_fattura style=\"display:block;\">";
} else {
echo "<div id=rda".$sing_rda." class=contenitore_rda_fattura style=\"display:none;\">";
}
$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' ORDER BY gruppo_merci ASC";
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
	$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND gruppo_merci = '$gruppo_merci_uff'";
$resultz = mysql_query($sum_grm);
list($somma_grm) = mysql_fetch_array($resultz);
$totale_grm = $somma_grm;
//$TOTALE_rda = $TOTALE_rda + $totale_grm;
echo "<div class=contenitore_gruppo_merci>";
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
echo "<div class=box_130_dx>";
echo number_format($totale_grm,2,",",".");
echo "</div>";
echo "</div>";
$totale_grm = "";
	}
echo "<div class=contenitore_riga_fattura>";
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
echo number_format($rowg[quant],2,",",".");
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($rowg[totale],2,",",".");
$TOTALE_rda = $TOTALE_rda + $rowg[totale];
echo "</div>";
echo "</div>";	
}

echo "<div class=riga_separazione>";
echo "</div>";	
$gruppo_merci_uff = "";
//echo "<div class=contenitore_gruppo_merci>";
echo "<div class=contenitore_gruppo_merci style=\"padding-left:0px; margin-bottom:20px;\">";
if ($visualizza_pulsanti == "1") {
echo "<div style =\"width:154px; height:22px; margin-top:10px; padding-left:3px; float:left;\">";
if ($n_fatt_sap != "") {
echo "<input type=text name=ord".$sing_rda." id=ord".$sing_rda." disabled style =\"width:150px; height:18px; background-color:#d6efff; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campoord(this.id,".$sing_rda.")\"";
} else {
if ($n_ord_sap != "") {
echo "<input type=text name=ord".$sing_rda." id=ord".$sing_rda." disabled style =\"width:150px; height:18px; background-color:#d6efff; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campoord(this.id,".$sing_rda.")\"";
} else {
echo "<input type=text name=ord".$sing_rda." id=ord".$sing_rda." style =\"width:150px; height:18px; background-color:#d6efff; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campoord(this.id,".$sing_rda.")\"";
}
}
if ($n_ord_sap != "") {
echo " value=".$n_ord_sap.">";
} else {
echo " value=\"Ordine SAP\">";
}
echo "</div>";	

echo "<div style =\"width:154px; height:22px; margin-top:10px; padding-left:3px; margin-left:20px; float:left;\">";
if ($n_ord_sap != "") {
	//se il numero ordine sap è inserito,
if ($n_fatt_sap != "") {
	//se il numero fattura sap è inserito,  il campo non è editabile
echo "<input type=text name=fatt".$sing_rda." id=fatt".$sing_rda." disabled style =\"width:150px; height:18px; background-color:rgb(255,247,178); padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campofatt(this.id,".$sing_rda.")\"";
if ($n_fatt_sap != "") {
echo " value=".$n_fatt_sap.">";
} else {
echo " value=\"Fattura SAP\">";
}
} else {
	
echo "<input type=text name=fatt".$sing_rda." id=fatt".$sing_rda." style =\"width:150px; height:18px; background-color:rgb(255,247,178); padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campofatt(this.id,".$sing_rda.")\"";
if ($n_fatt_sap != "") {
echo " value=".$n_fatt_sap.">";
} else {
echo " value=\"Fattura SAP\">";
}

}
} else {
	//altrimenti il campo n fatt sap è disabilitato
echo "<input type=text name=fatt".$sing_rda." id=fatt".$sing_rda." disabled style =\"width:150px; height:18px; background-color:rgb(255,247,178); padding-left:3px; padding-top:3px;\"";
if ($n_fatt_sap != "") {
echo " value=".$n_fatt_sap.">";
} else {
echo " value=\"Fattura SAP\">";
}
}
echo "</div>";	

if (($n_ord_sap == "") OR ($n_fatt_sap == "")) {
	
echo "<a href=\"javascript:void(0);\"><div style =\"width:150px; height:20px; background-color:#0079ca; margin-top:10px; margin-left:20px; color:white; float:left; padding-left:3px; padding-top:3px;\" onClick=\"salvataggio_ordine(".$sing_rda."); notifica_salvataggio(".$sing_rda.");\">";
echo "Salva";
echo "</div></a>";
}
if ($n_fatt_sap != "") {
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('dettaglio_fattura.php?id_rda=".$sing_rda."', 'myPop1',800,800);\">";
echo "<div style =\"width:150px; height:20px; background-color:#00a42a; margin-top:10px; margin-left:20px; color:white; float:left; padding-left:3px; padding-top:3px;\">";
echo "PDF Packing List";
echo "</div>";	
echo "</a>";
}
} else {
echo "<div style =\"width:503px; height:20px; margin-top:10px; float:left; padding-top:3px;\">.</div>";
}
echo "<div style =\"width:105px; height:20px; margin-right:10px; margin-top:10px; float:right; padding-top:3px; text-align:right;\">";
echo number_format($TOTALE_rda,2,",",".");
echo "</div>";	
echo "<div style =\"width:60px; height:20px; margin-top:10px; float:right; padding-top:3px;\">";
echo "Totale";
echo "</div>";	
	
echo "</div>";	
//echo "</div>";	
//fine singolo contenitore
echo "</div>";	
$n_ord_sap = "";
$TOTALE_rda = "";
}
//}
?>
<!--</form>--> 
    <?php
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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nazione=".$nazioneDaModulo."&archivio=".$archivioDaModulo."&nr_rda=".$nr_rdaDaModulo."&nr_pl=".$nr_plDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&output_mode=MAG&stato_rda=4&ricerca=1&lang=".$lingua."><b>1</b></a>"; 

  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nazione=".$nazioneDaModulo."&archivio=".$archivioDaModulo."&nr_rda=".$nr_rdaDaModulo."&nr_pl=".$nr_plDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&output_mode=MAG&stato_rda=4&ricerca=1&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nazione=".$nazioneDaModulo."&archivio=".$archivioDaModulo."&nr_rda=".$nr_rdaDaModulo."&nr_pl=".$nr_plDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&output_mode=MAG&stato_rda=4&ricerca=1&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nazione=".$nazioneDaModulo."&archivio=".$archivioDaModulo."&nr_rda=".$nr_rdaDaModulo."&nr_pl=".$nr_plDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&output_mode=MAG&stato_rda=4&ricerca=1&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nazione=".$nazioneDaModulo."&archivio=".$archivioDaModulo."&nr_rda=".$nr_rdaDaModulo."&nr_pl=".$nr_plDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&output_mode=MAG&stato_rda=4&ricerca=1&lang=".$lingua."><b>".$last_page."</b></a>"; 
        echo "</td>";
     echo " </tr>";
    echo "</table>";


    echo "</div>";
	//}
?>



<script type="text/javascript">
 
$(".slideDownbox").click(function () {
   $(this).hide().slideDown('slow');
});
 
$(".slideUpbox").click(function () {
   $(this).slideUp(2000);
});
 
function mostra_nascondi(id) {
	/*alert(id);*/
	//$("#test"+id).click(function () {
   $('#rda'+id).slideToggle(1000);
//});
}

function azzera_campoord(id,rda) {
var campo_ord = document.getElementById('ord'+rda).value;
var id_ord = document.getElementById('ord'+rda).id;
	/*alert(id_fatt);*/
if(campo_ord == "Ordine SAP") {
document.getElementById('ord'+rda).value = '';
}
}

function azzera_campofatt(id,rda) {
var campo_fatt = document.getElementById('fatt'+rda).value;
var id_fatt = document.getElementById('fatt'+rda).id;
	/*alert(id_fatt);*/
if(campo_fatt == "Fattura SAP") {
document.getElementById('fatt'+rda).value = '';
}
}



function salvataggio_ordine(sing_rda){
var n_ord = document.getElementById('ord'+sing_rda).value;
var n_fatt = document.getElementById('fatt'+sing_rda).value;
if(document.getElementById('ord'+sing_rda).disabled==false) {
/*alert('campo ordine abilitato '+sing_rda);*/
if((n_ord == "") || n_ord == "Ordine SAP") {
alert("Errore: Valore del numero ordine SAP non valido");
n_ord.focus();
return false;
} else {
/*alert('rda'+sing_rda);*/
		$.ajax({
			type: "POST",   
				url: "aggiorna_ordine_sap.php",   
				data: "n_ord="+n_ord+"&n_rda="+sing_rda,
				  success: function(output) {
				  $('#rif_ord_'+sing_rda).html(output).show();
				  }
				  });
	//}
return true
}
} else {
/*alert('campo ordine disabilitato '+sing_rda);*/
if((n_fatt == "") || n_fatt == "Fattura SAP") {
alert("Errore: Valore del numero fattura SAP non valido");
n_fatt.focus();
return false;
} else {
/*alert('rda'+sing_rda);*/
		$.ajax({
			type: "POST",   
				url: "aggiorna_ordine_sap.php",   
				data: "n_fatt="+n_fatt+"&n_rda="+sing_rda,
				  success: function(output) {
				  $('#rif_fatt_'+sing_rda).html(output).show();
				  }
				  });
	//}
return true
}
}
}
function vis_invis(id_riga)  {
	/*alert(id_riga);*/
                if ($('#rda'+id_riga).css('display')=='none'){
                    $('#rda'+id_riga).css('display', 'block');
                } else {
                    $('#rda'+id_riga).css('display', 'none');
                }
 }
</script>
</body>
</html>
