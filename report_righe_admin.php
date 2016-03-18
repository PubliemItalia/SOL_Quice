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


$pag_attuale = "report_righe_admin";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
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

if ($_GET['ricerca'] != "") {
$ricerca = $_GET['ricerca'];
} else {
$ricerca = $_POST['ricerca'];
} 
if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_POST['page'] != "") {
$page = $_POST['page'];
} else {
$page = $_GET['page'];
}
if ($_POST['limit'] != "") {
$limit = $_POST['limit'];
} else {
$limit = $_GET['limit'];
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
$campidate = "";
}
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$e = "azienda_prodotto = '$societaDaModulo'";
$clausole++;
}
if (isset($_GET['gruppo_merci_righe'])) {
$gruppo_merciDaModulo = $_GET['gruppo_merci_righe'];
} 
if ($gruppo_merciDaModulo != "") {
$f = "gruppo_merci = '$gruppo_merciDaModulo'";
$clausole++;
}

if (isset($_GET['codice_art'])) {
  $codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$g = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}

if (isset($_GET['stato_rda'])) {
$stato_rdaDaModulo = $_GET['stato_rda'];
} 
if ($stato_rdaDaModulo != "") {
$h = "stato_ordine = '$stato_rdaDaModulo'";
$clausole++;
}
//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole > 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4' AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '4' AND ";
$sumquery2 =   "SELECT SUM(quant) as somma2 FROM qui_righe_rda WHERE stato_ordine = '4' AND ";
$sumquery3 =   "SELECT SUM(totale2) as somma3 FROM qui_righe_rda WHERE stato_ordine = '4' AND ";

if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
$sumquery .= $a;
$sumquery2 .= $a;
$sumquery3 .= $a;
}
if ($b != "") {
$testoQuery .= $b;
$sumquery .= $b;
$sumquery2 .= $b;
$sumquery3 .= $b;
}
if ($c != "") {
$testoQuery .= $c;
$sumquery .= $c;
$sumquery2 .= $c;
$sumquery3 .= $c;
}
if ($d != "") {
$testoQuery .= $d;
$sumquery .= $d;
$sumquery2 .= $d;
$sumquery3 .= $d;
}
if ($e != "") {
$testoQuery .= $e;
$sumquery .= $e;
$sumquery2 .= $e;
$sumquery3 .= $e;
}
if ($f != "") {
$testoQuery .= $f;
$sumquery .= $f;
$sumquery2 .= $f;
$sumquery3 .= $f;
}
if ($g != "") {
$testoQuery .= $g;
$sumquery .= $g;
$sumquery2 .= $g;
$sumquery3 .= $g;
}
if ($h != "") {
$testoQuery .= $h;
$sumquery .= $h;
$sumquery2 .= $h;
$sumquery3 .= $h;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
$sumquery .= $a." AND ";
$sumquery2 .= $a." AND ";
$sumquery3 .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
$sumquery .= $b." AND ";
$sumquery2 .= $b." AND ";
$sumquery3 .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
$sumquery .= $c." AND ";
$sumquery2 .= $c." AND ";
$sumquery3 .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
$sumquery .= $d." AND ";
$sumquery2 .= $d." AND ";
$sumquery3 .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
$sumquery .= $e." AND ";
$sumquery2 .= $e." AND ";
$sumquery3 .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
$sumquery .= $f." AND ";
$sumquery2 .= $f." AND ";
$sumquery3 .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
$sumquery .= $g." AND ";
$sumquery2 .= $g." AND ";
$sumquery3 .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h;
$sumquery .= $h;
$sumquery2 .= $h;
$sumquery3 .= $h;
}
}
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4'";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '4'";
$sumquery2 =   "SELECT SUM(quant) as somma2 FROM qui_righe_rda WHERE stato_ordine = '4'";
$sumquery3 =   "SELECT SUM(totale2) as somma3 FROM qui_righe_rda WHERE stato_ordine = '4'";
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
$lungsum2 = strlen($sumquery2);
$finale_sum2 = substr($sumquery2,($lungsum2-5),5);
if ($finale_sum2 == " AND ") {
$sumquery2 = substr($sumquery2,0,($lungsum2-5));
}
$lungsum3 = strlen($sumquery3);
$finale_sum3 = substr($sumquery3,($lungsum3-5),5);
if ($finale_sum3 == " AND ") {
$sumquery3 = substr($sumquery3,0,($lungsum3-5));
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
$resultc = mysql_query($sumquery2);
list($somma2) = mysql_fetch_array($resultc);
$totale_quant_rda = $somma2;
$resultd = mysql_query($sumquery3);
list($somma3) = mysql_fetch_array($resultd);
$totale_storico_dispositivi = $somma3;
//}

//echo "testoQuery: ".$testoQuery."<br>";
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
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
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
	background-color:#06F;
	background-image:none !important;
	border-color:#06F;
}
a.ui-datepicker-next.ui-corner-all:hover {
	background-color:#06F;
	border-color:#06F;
}
-->
</style>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script type="text/javascript" src="tendine.js"></script>
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
<?php
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
?>
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
</div>
  <?php

//**********************
//tabella se ruolo = buyer
//************************
//riga del totale
echo "<div class=contenitore_riga>";
echo "<div class=box_120>";
echo "TOTALE";
echo "</div>";
echo '<div class="box_450" style="width:300px;">
</div>
<div class="box_100_20" style="float: right; width:200px; text-align: right;">
<strong>solo dispositivi</strong> euro '.number_format($totale_storico_dispositivi,2,",",".").
'</div>
<div class="box_130_dx" style="float: right;">
euro '.number_format($totale_storico_rda,2,",",".").
'</div>
<div class="box_130_dx" style="float: right;">
pz. '.intval($totale_quant_rda).
'</div>
';

echo "</div>";	
//if ($clausole > 0) {
$array_rda = array();
 $querya = $testoQuery;
 $sf = 1;
//$querya = $testoQuery;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	if ($row[id_rda] != $rif_rda) {
$sqls = "SELECT * FROM qui_rda WHERE id = '$row[id_rda]'";
$risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
$company_act = $rigas[id_company];
}
$sqlx = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_utente]'";
$risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigax = mysql_fetch_array($risultx)) {
$company_orig = $rigax[IDCompany];
}
	  $sqlw = "SELECT * FROM qui_company WHERE IDCompany = '$company_act'";
	  $risultw = mysql_query($sqlw) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaw = mysql_fetch_array($risultw)) {
		  if ($company_orig == $company_act) {
			$nome_company = stripslashes($rigaw[Company]);
		  } else {
			$nome_company = '<span style="color:red; font-weight:bold;">'.stripslashes($rigaw[Company]).'</span>';
		  }
	  }
		
echo "<div class=contenitore_rda>";
echo "<div class=box_450 style=\"width:650px;\">";
echo "RdA ".$row[id_rda]."<img src=immagini/spacer.gif width=15 height=4>| ".date("d/m/Y",$row[data_inserimento])."<img src=immagini/spacer.gif width=15 height=4>| Responsabile ";
$queryh = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
$resulth = mysql_query($queryh);
while ($rowh = mysql_fetch_array($resulth)) {
echo $rowh[nome];
}
echo "<img src=immagini/spacer.gif width=15 height=4>| Unit&agrave; ".$row[nome_unita]."<img src=immagini/spacer.gif width=15 height=4>| ".$nome_company;
echo "</div>";
echo "</div>";
	} else {
	}
echo "<div class=contenitore_riga>";
	if ($xx == 0) {
$xx = $xx+1;
	} else {
$xx = "0";
	}
$nome_company = '';	
$company_orig = '';
$company_act = '';
echo "<div class=box_120>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</div>";
echo "<div class=box_450>";
echo stripslashes($row[descrizione]);
echo "</div>";
echo "<div class=box_130_dx>";
echo intval($row[quant]);
echo "</div>";
echo "<div class=box_130_dx>";
if ($row[totale2] > 0) {
  echo number_format($row[totale2],2,",",".");
} else {
  echo number_format($row[totale],2,",",".");
}
echo "</div>";
echo '<div class="box_100_20" style="width:60px;">';
echo $row[output_mode];
echo "</div>";
echo '<div class="sel_all_riga" style="width:auto; padding:5px 0px 0px 10px;">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($row[azienda_prodotto]) {
  case "VIVISOL":
	echo '<img src="immagini/bottone-vivisol.png">';
  break;
  case "SOL":
	echo '<img src="immagini/bottone-sol.png">';
  break;
}
echo "</div>";
echo "</div>";	
$rif_rda = $row[id_rda];
}
//}
?>
<!--</form>--> 
    <table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">
    <?php

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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&societa=".$societaDaModulo."&categoria_righe=".$categ_DaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b>1</b></a>"; 
  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&societa=".$societaDaModulo."&categoria_righe=".$categ_DaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&societa=".$societaDaModulo."&categoria_righe=".$categ_DaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&societa=".$societaDaModulo."&categoria_righe=".$categ_DaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&societa=".$societaDaModulo."&categoria_righe=".$categ_DaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b>".$last_page."</b></a>"; 
?>
        </td>
      </tr>
    </table>


    </div>

<script type="text/javascript">
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
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
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
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		break;
		case "societa":
		  var socval = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "unita":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unitaval = valore;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "shop":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shopval = valore;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "categoria_righe":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var categval = valore;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
	}
	var codice_art = document.getElementById('codice_art').value;
	    if((data_inizio_val != "") && (data_fine_val == "")){
			var verifica = 10;
		}
	    if((data_inizio_val == "") && (data_fine_val != "")){
			var verifica = 10;
		}
	    if((data_inizio_val != "") && (data_fine_val != "")){
			var verifica = 11;
		}
	    if((data_inizio_val == "") && (data_fine_val == "")){
			var verifica = 11;
		}
    if(verifica == 11){
        data1str = data_inizio_val.substr(6)+data_inizio_val.substr(3, 2)+data_inizio_val.substr(0, 2);
		data2str = data_fine_val.substr(6)+data_fine_val.substr(3, 2)+data_fine_val.substr(0, 2);
		//controllo se la seconda data è successiva alla prima
	if (data2str-data1str<0) {
		alert("La data iniziale deve essere precedente quella finale");
		document.getElementById('data_fine').value = "";
	} else {
	  $.ajax({
		type: "POST",   
		url: "motore_ricerca_MSC.php",   
		data: "societa="+socval+"&shop="+shopval+"&unita="+unitaval+"&categoria="+categval+"&codice_art="+codice_art+"&data_inizio="+data_inizio_val+"&data_fine="+data_fine_val+"&file_presente=<?php echo $file_presente; ?>",
		success: function(output) {
		  $('#contenitore_msc').html(output).show();
		  $("#contenitore_int_msc").fadeIn(1000);
		}
	  })
	}
  } else {
	alert("Occorre inserire entrambe le date");
  }
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
		  var data1 = document.getElementById('data_inizio').value;
		  var data2 = document.getElementById('data_fine').value;
	    if((data1 != "") && (data2 == "")){
			var verifica = 10;
		}
	    if((data1 == "") && (data2 != "")){
			var verifica = 10;
		}
	    if((data1 != "") && (data2 != "")){
			var verifica = 11;
		}
	    if((data1 == "") && (data2 == "")){
			var verifica = 11;
		}
		
    if(verifica == 11){
	  // controllo validità formato data
	  //if(controllo_data(data1) &&controllo_data(data2)){
		//trasformo le date nel formato aaaammgg (es. 20081103)
        data1str = data1.substr(6)+data1.substr(3, 2)+data1.substr(0, 2);
		data2str = data2.substr(6)+data2.substr(3, 2)+data2.substr(0, 2);
		//controllo se la seconda data è successiva alla prima
        if (data2str-data1str<0) {
		  alert("La data iniziale deve essere precedente quella finale");
        }else{
		  document.form_filtri2.submit();
        }
    //}else{
        //alert("Il formato data deve essere gg/mm/aaaa");
    //}
    }else{
            alert("Occorre inserire entrambe le date");
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
	    if((data1 != "") && (data2 == "")){
			var verifica = 10;
		}
	    if((data1 == "") && (data2 != "")){
			var verifica = 10;
		}
	    if((data1 != "") && (data2 != "")){
			var verifica = 11;
		}
	    if((data1 == "") && (data2 == "")){
			var verifica = 11;
		}
		
    if(verifica == 11){
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
    }else{
		alert("Occorre inserire entrambe le date");
	}
}

</SCRIPT>
</body>
</html>
