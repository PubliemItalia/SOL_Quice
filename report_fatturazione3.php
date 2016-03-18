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
$ordinamento = "pack_list DESC";

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
$c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = 1;
$inizio_range = mktime(12,30,0,1,1,2013);
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
/*
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
*/
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

if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$g = "azienda_prodotto = '".$societaDaModulo."'";
$clausole++;
}



$h = "pack_list != '0'";
//$h = "evaso_magazzino = '1'";
$clausole++;

$j = "(output_mode = 'mag' OR output_mode = 'lab')";
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
     $limit = 15; //default
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

//echo "<span style=\"color:red;\">testoQuery: ".$testoQuery."</span><br>";
//echo "sumquery: ".$sumquery."<br>";
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
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
//include "menu_amministrazione.php";
//div ricerca righe fatturazione
//if ($clausole > 0) {
 $querya = $testoQuery;
 $sf = 1;
//$querya = $testoQuery;
//inizia il corpo della tabella
$array_pl = array();
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	if (!in_array($row[pack_list],$array_pl)) {
		$add_pl = array_push($array_pl,$row[pack_list]);
	}
}
//echo "<span style=\"color:black;\">array_pl: ";
//print_r($array_pl);
//echo "</span><br>";
foreach ($array_pl as $sing_pl) {
	$queryx = "SELECT * FROM qui_packing_list WHERE id = '$sing_pl'";
	$resultx = mysql_query($queryx);
	while ($rowx = mysql_fetch_array($resultx)) {
	  $n_ord_sap = $rowx[n_ord_sap];
	  $n_fatt_sap = $rowx[n_fatt_sap];
	}

  $array_rda_pl = array();
  $array_resp = array();
  echo "<div id=test".$sing_pl." class=contenitore_rda_testfatt>";
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
	echo "<div id=rif_ord_".$sing_pl." style =\"width:100px; height:20px; margin-top:5px; float:left;\">";
	if ($n_ord_sap != "") {
	  echo "ODV ".$n_ord_sap;
	}
	echo "</div>";
	echo "<div id=rif_fatt_".$sing_pl." style =\"width:100px; height:20px; margin-top:5px; float:left;\">";
	if ($n_fatt_sap != "") {
	  echo "FT ".$n_fatt_sap;
	}
	echo "</div>";
	//tasto pdf
	//echo "<a href=\"javascript:void(0);\">";
	echo "<div style =\"width:50px; height:20px; margin-top:5px; float:left; text-decoration:none; color:white; cursor:pointer;\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$sing_pl."&lang=".$lingua."', 'myPop1',800,800);\">";
	echo "PDF";
	echo "</div>";
	//echo "</a>";
  echo "</div>";
  //singolo contenitore
  if ($pl_gest == $sing_pl) {
  echo "<div id=pl".$sing_pl." class=contenitore_rda_fattura style=\"display:block;\">";
  } else {
  echo "<div id=pl".$sing_pl." class=contenitore_rda_fattura style=\"display:none;\">";
  }
	foreach ($array_rda_pl as $sing_rdapl) {
	  echo "<div class=contenitore_gruppo_merci style=\"margin-top:5px; width:815px; float:left;\">";
	  echo "RdA ".$sing_rdapl;
	  echo "</div>";
	  if ($clausole <= 5) {
		$sum_parz_rda = "SELECT SUM(totale) as somma_parz_rda FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND dest_contab LIKE '%".$doc."%' ";
	  } else {
		$sum_parz_rda = "SELECT SUM(totale) as somma_parz_rda FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND dest_contab = '$dest_contab' ";
	  }
		  $resultf = mysql_query($sum_parz_rda);
		  list($somma_parz_rda) = mysql_fetch_array($resultf);
	  echo "<div class=box_130_dx style=\"font-weight:bold;\">";
	  echo number_format($somma_parz_rda,2,",",".");
	  echo "</div>";
	  $somma_parz_rda = "";
	  //if ($clausole <= 5) {
		$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND dest_contab LIKE '%".$doc."%' ORDER BY gruppo_merci ASC";
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
		  //if ($clausole < 5) {
			$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND gruppo_merci = '$gruppo_merci_uff' AND dest_contab LIKE '%".$doc."%' ";
		  //} else {
			//$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND gruppo_merci = '$gruppo_merci_uff' AND dest_contab = '$dest_contab' ";
		  //}
		  $resultz = mysql_query($sum_grm);
		  list($somma_grm) = mysql_fetch_array($resultz);
		  $totale_grm = $somma_grm;
		  //$TOTALE_pl = $TOTALE_pl + $totale_grm;
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
			echo intval($rowg[quant]);
		  echo "</div>";
		  echo "<div class=box_130_dx>";
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
  echo "<div class=contenitore_gruppo_merci style=\"padding-left:0px; margin-bottom:20px;\">";
  if ($visualizza_pulsanti == "1") {
	echo "<div style =\"width:154px; height:22px; margin-top:10px; padding-left:3px; float:left;\">";
	if ($n_fatt_sap != "") {
	  echo "<input type=text name=ord".$sing_pl." id=ord".$sing_pl." disabled style =\"width:150px; height:18px; background-color:#d6efff; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campoord(this.id,".$sing_pl.")\"";
	} else {
	  if ($n_ord_sap != "") {
		echo "<input type=text name=ord".$sing_pl." id=ord".$sing_pl." disabled style =\"width:150px; height:18px; background-color:#d6efff; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campoord(this.id,".$sing_pl.")\"";
	  } else {
		echo "<input type=text name=ord".$sing_pl." id=ord".$sing_pl." style =\"width:150px; height:18px; background-color:#d6efff; padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campoord(this.id,".$sing_pl.")\"";
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
		echo "<input type=text name=fatt".$sing_pl." id=fatt".$sing_pl." disabled style =\"width:150px; height:18px; background-color:rgb(255,247,178); padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campofatt(this.id,".$sing_pl.")\"";
		if ($n_fatt_sap != "") {
		  echo " value=".$n_fatt_sap.">";
		} else {
		  echo " value=\"Fattura SAP\">";
		}
	  } else {
		  
		echo "<input type=text name=fatt".$sing_pl." id=fatt".$sing_pl." style =\"width:150px; height:18px; background-color:rgb(255,247,178); padding-left:3px; padding-top:3px;\" onFocus=\"azzera_campofatt(this.id,".$sing_pl.")\"";
		if ($n_fatt_sap != "") {
		  echo " value=".$n_fatt_sap.">";
		} else {
		  echo " value=\"Fattura SAP\">";
		}
	  }
	} else {
		//altrimenti il campo n fatt sap è disabilitato
	  echo "<input type=text name=fatt".$sing_pl." id=fatt".$sing_pl." disabled style =\"width:150px; height:18px; background-color:rgb(255,247,178); padding-left:3px; padding-top:3px;\"";
	  if ($n_fatt_sap != "") {
		echo " value=".$n_fatt_sap.">";
	  } else {
		echo " value=\"Fattura SAP\">";
	  }
	}
	echo "</div>";	
	if (($n_ord_sap == "") OR ($n_fatt_sap == "")) {
	  echo "<a href=\"javascript:void(0);\"><div style =\"width:150px; height:20px; background-color:#0079ca; margin-top:10px; margin-left:20px; color:white; float:left; padding-left:3px; padding-top:3px;\" onClick=\"salvataggio_ordine(".$sing_pl."); notifica_salvataggio(".$sing_pl.");\">";
	  echo "Salva";
	  echo "</div></a>";
	}
	if ($n_fatt_sap != "") {
	  echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?mode=print&n_pl=".$sing_pl."&lang=".$lingua."', 'myPop1',800,800);\">";
	  echo "<div style =\"width:150px; height:20px; background-color:#00a42a; margin-top:10px; margin-left:20px; color:white; float:left; padding-left:3px; padding-top:3px;\">";
	  echo "PDF Packing List";
	  echo "</div>";	
	  echo "</a>";
	}
  } else {
	echo "<div style =\"width:503px; height:20px; margin-top:10px; float:left; padding-top:3px;\">.</div>";
  }
  echo "<div style =\"width:105px; height:20px; margin-right:10px; margin-top:10px; float:right; padding-top:3px; text-align:right;\">";
  echo '&euro; '.number_format($TOTALE_pl,2,",",".");
  echo "</div>";	
  echo "<div style =\"width:60px; height:20px; margin-top:10px; float:right; padding-top:3px;\">";
  echo "Totale";
  echo "</div>";	
  echo "</div>";	
  //echo "</div>";	
  //fine singolo contenitore
  echo "</div>";	
  $n_ord_sap = "";
  $TOTALE_pl = "";
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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&archivio=".$archivioDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b>1</b></a>"; 

  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&archivio=".$archivioDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&archivio=".$archivioDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&archivio=".$archivioDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&societa=".$societaDaModulo."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&nr_pl=".$nr_plDaModulo."&archivio=".$archivioDaModulo."&doc=".$doc."&data_inizio=".$data_inizio."&data_fine=".$data_fine."><b>".$last_page."</b></a>"; 
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
 
function mostra_nascondi(id) {
	/*alert(id);*/
	//$("#test"+id).click(function () {
   $('#pl'+id).slideToggle(1000);
//});
}

function azzera_campoord(id,pl) {
var campo_ord = document.getElementById('ord'+pl).value;
var id_ord = document.getElementById('ord'+pl).id;
	/*alert(id_fatt);*/
if(campo_ord == "Ordine SAP") {
document.getElementById('ord'+pl).value = '';
}
}

function azzera_campofatt(id,pl) {
var campo_fatt = document.getElementById('fatt'+pl).value;
var id_fatt = document.getElementById('fatt'+pl).id;
	/*alert(id_fatt);*/
if(campo_fatt == "Fattura SAP") {
document.getElementById('fatt'+pl).value = '';
}
}

function salvataggio_ordine(sing_pl){
var n_ord = document.getElementById('ord'+sing_pl).value;
var n_fatt = document.getElementById('fatt'+sing_pl).value;
if(document.getElementById('ord'+sing_pl).disabled==false) {
/*alert('campo ordine abilitato '+sing_rda);*/
if((n_ord == "") || n_ord == "Ordine SAP") {
alert("Errore: Valore del numero ordine SAP non valido");
n_ord.focus();
return false;
} else {
/*alert('rda'+sing_pl);*/
		$.ajax({
			type: "POST",   
				url: "aggiorna_ordine_sap.php",   
				data: "n_ord="+n_ord+"&n_pl="+sing_pl,
				  success: function(output) {
				  $('#rif_ord_'+sing_pl).html(output).show();
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
/*alert('rda'+sing_pl);*/
		$.ajax({
			type: "POST",   
				url: "aggiorna_ordine_sap.php",   
				data: "n_fatt="+n_fatt+"&n_pl="+sing_pl,
				  success: function(output) {
				  $('#rif_fatt_'+sing_pl).html(output).show();
				  }
				  });
	//}
return true
}
}
}
function vis_invis(id_riga)  {
	/*alert(id_riga);*/
                if ($('#pl'+id_riga).css('display')=='none'){
                    $('#pl'+id_riga).css('display', 'block');
                } else {
                    $('#pl'+id_riga).css('display', 'none');
                }
 }
 function msc(mode,valore){
	switch (mode) {
		case "societa":
		  var socval = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		break;
		case "unita":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unitaval = valore;
		break;
		case "shop":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shopval = valore;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		break;
	}
	var nr_rda = document.getElementById('nr_rda').value;
	var nr_pl = document.getElementById('nr_pl').value;
	var data_inizio = document.getElementById('data_inizio').value;
	var data_fine = document.getElementById('data_fine').value;
	/*var check = document.getElementsByName("archivio");
	if(check.length != 0) {
	  var archivio = document.forms['form_filtri2'].elements['archivio'];
	  var archivioval = archivio.options[archivio.selectedIndex].value;
	  $.ajax({
		type: "POST",   
		url: "motore_ricerca_MSC.php",   
		data: "societa="+socval+"&nr_pl="+nr_pl+"&shop="+shopval+"&unita="+unitaval+"&nr_rda="+nr_rda+"&archivio="+archivioval+"&data_inizio="+data_inizio+"&data_fine="+data_fine+"&file_presente=<?php echo $file_presente; ?>"+"&doc=<?php echo $doc; ?>",
		success: function(output) {
		$('#formRicerca').html(output).show();
		$("#contenitore_msc").fadeIn(1000);
		}
	  })
	} else {*/
	  $.ajax({
		type: "POST",   
		url: "motore_ricerca_MSC.php",   
		data: "societa="+socval+"&nr_pl="+nr_pl+"&shop="+shopval+"&unita="+unitaval+"&nr_rda="+nr_rda+"&data_inizio="+data_inizio+"&data_fine="+data_fine+"&file_presente=<?php echo $file_presente; ?>"+"&doc=<?php echo $doc; ?>",
		success: function(output) {
		$('#formRicerca').html(output).show();
		$("#contenitore_msc").fadeIn(1000);
		}
	  })
	/*}*/
	/*
	alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);
	alert("ok");
	*/
}
</script>
</body>
</html>
