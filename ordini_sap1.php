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
$curdir = getcwd();
$arr_dir = explode("/",$curdir);
$dir_lavoro = array_pop($arr_dir);
$id_utente = $_SESSION[user_id];
//echo "dir_lavoro: ".$dir_lavoro."<br>";
//echo "lingua: ".$lingua."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
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
//echo "negozio buyer: ".$_SESSION[negozio_buyer]."<br>";
//echo "negozio2 buyer: ".$_SESSION[negozio2_buyer]."<br>";

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
//$gginizio = $pieces_inizio[0]; 
//$mminizio = $pieces_inizio[1];
//$aaaainizio = $pieces_inizio[2];
$gginizio = $pieces_inizio[1]; 
$mminizio = $pieces_inizio[0];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
//$ggfine = $pieces_fine[0]; 
//$mmfine = $pieces_fine[1];
//$aaaafine = $pieces_fine[2];
$ggfine = $pieces_fine[1]; 
$mmfine = $pieces_fine[0];
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
$output_modulo = "sap";
$flag_chiusura = "1";
if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$f = "azienda_prodotto = '$societaDaModulo'";
$clausole++;
}
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 
//echo "shopDaModulo: ".$shopDaModulo."<br>";

//costruzione query
//ogni buyer ha alcuni negozi da gestire e sono indicati nella tabella "qui_buyer_negozi"
//ATTENZIONE: lo switch qui sotto serve perchè se nei filtri viene specificato il negozio, la ricerca va fatta solo su quello, e la tabella deve essere esclusa
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
	$num_negozi_buyer = mysql_num_rows($risultt);
	$z = 1;
    while ($rigat = mysql_fetch_array($risultt)) {
	  if ($z == 1) {
		$blocco_negozi_buyer .= "(negozio = '".$rigat[negozio]."'";
	  } else {
		$blocco_negozi_buyer .= " OR negozio = '".$rigat[negozio]."'";
	  }
	  $z = $z+1;
	  if ($z > $num_negozi_buyer) {
		$blocco_negozi_buyer .= ")";
	  }
	}
if ($clausole > 0) {
  if ($shopDaModulo != "") {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = 4  AND output_mode = 'sap' AND flag_chiusura = '1' AND ";
	$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' AND ";
  } else {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' AND ";
	$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' AND ";
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
	if ($g != "") {
	  $testoQuery .= $g;
	  $sumquery .= $g;
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
	  $testoQuery .= $g;
	  $sumquery .= $g;
	}
  }
} else {
  $testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' ";
  $sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' ";
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
$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;

//echo "<span style=\"color:rgb(0,0,0);\">";
//echo "testoQuery: ".$testoQuery."</span><br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";

?>
<html>
<head>
  <title>Quice - Lista Ordini sap</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report_balconi.css" />
<link rel="stylesheet" href="css/report.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<style type="text/css">
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
th {
	color:#000;
	font-weight:bold;
}
.ui-widget-header {
	background-color:#F63;
	background-image:none !important;
	border-color:#F63;
}
</style>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
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
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>

</head>
<body>
<div id="main_container">
<?php
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
?>

  <?php
  $array_rda = array();
  $array_rda_completate = array();
	$num_rda_titolo = "";
//**********************
//solo per buyer
//************************
 $querya = $testoQuery;

//inizia il corpo della tabella
$result = mysql_query($querya);
//inizio while RDA
while ($row = mysql_fetch_array($result)) {
  //echo "RdA ".$row[id_rda]." - discrim:".$discrim."<br>";
	if (!in_array($row[id_rda],$array_rda)) {
	$add_rda = array_push($array_rda,$row[id_rda]);
	}
	if ($row[nazione] == "italy") {
		$flag_sap = "ok";
	} else {
		$flag_sap = "";
	}
}
//echo "<span style=\"color:rgb(0,0,0);\">array_rda: ";
//print_r($array_rda);
//echo "<br>";
foreach ($array_rda_completate as $sing_rda_completa) {
  $m = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	if ($rigam[nazione] == "italy") {
		$flag_sap = "ok";
	} else {
		$flag_sap = "";
	}
  }
$g = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_completa'";
  $risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tot_righe_rda = mysql_num_rows($risultg);
  //echo "RdA ".$sing_rda." - Righe in tutto:".$tot_righe_rda."<br>";
  $d = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_completa' AND stato_ordine = '4'";
  $risultd = mysql_query($d) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tot_righe_rda_evase = mysql_num_rows($risultd);
  //echo "RdA ".$sing_rda." - Righe evase:".$tot_righe_rda_evase."<br>";
}
//echo "</span><br>";
echo "<div class=cont_rda id=contenitore_generale>";

foreach ($array_rda as $sing_rda) {
 if ($sing_rda != $num_rda_titolo) {
$sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
$ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d.m.Y",$rigay[data_inserimento])."<img src=immagini/spacer.gif width=25 height=2>Utente ".stripslashes($rigay[nome_utente])."<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
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
$tracciati_sap .= "<img src=immagini/spacer.gif width=25 height=2>sap ";
while ($rows = mysql_fetch_array($results)) {
$nome_file_sap = $rows[nome_file];
if ($nome_file_sap != "") {
$pos = strrpos($nome_file_sap,"_");
$nome_vis = substr($nome_file_sap,($pos+1),5);
$tracciati_sap .= " (".$nome_vis.")";
}
}
}

//inizio contenitore esterno sing rda
echo "<div class=cont_rda id=glob_".$sing_rda." >";
//inizio div riassunto rda
echo "<div class=riassunto_rda>";
$sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
$resultm = mysql_query($sqlm);
$num_righeXDim = mysql_num_rows($resultm);
$altezza_finestra = ($num_righeXDim*37)+125+180;
if ($altezza_finestra > 800) {
	$altezza_finestra = 800;
}

	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda.php?report=1&a=1&pers=&id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40'})\">";
echo "<div class=ind_num_rda style=\"cursor:pointer;\">";
echo "RDA ".$sing_rda;
echo "</div>";
echo "</a>";
echo "<div class=riepilogo_rda onClick=\"vis_invis(".$sing_rda.")\">";
if ($tipo_negozio != "assets") {
//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
echo $ut_rda.$tracciati_sap;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
echo $output_wbs.$ut_rda;
}
$wbs_visualizzato = "";
$output_wbs = "";
$ut_rda = "";
echo "</div>";
echo "<div class=stato_rda>";
echo $imm_status;
echo "</div>";
$tracciati_sap = "";
 $sf = 1;



}
echo "</div>";


//inizio div rda
//echo "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = 'sap' AND flag_chiusura = '1'";
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
if ($g != "") {
$sqln .= " AND ".$g;
}
}
//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//echo "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
if ($sf == 1) {
//inizio contenitore riga
echo "<div class=columns_righe2>";
} else {
echo "<div class=columns_righe1>";
}
//div codice riga
echo "<div id=confez5_riga style=\"padding-left:10px;\">";
if (substr($rigan[codice_art],0,1) != "*") {
  echo $rigan[codice_art];
} else {
  echo substr($rigan[codice_art],1);
}
//fine div codice riga
echo "</div>";

//div descrizione riga
echo "<div class=descr4_riga style=\"width:370px;\">";
echo $rigan[descrizione];
if ($rigan[negozio] == "labels") {
  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigap = mysql_fetch_array($risultp)) {
	if ($rigap[ric_mag] != "mag") {
		  echo "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
	}
  }
}
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
echo "<div class=price6_riga style=\"width:90px;\">";
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

//div ordine sap
echo "<div class=vuoto9_riga style=\"width:170px; height:20px;\">";
if ($rigan[ord_fornitore] != "") {
echo "Ord ".stripslashes($rigan[fornitore_tx])." ".$rigan[ord_fornitore];
}
//fine div ordine sap
echo "</div>";
echo '<div class="sel_all_riga" style="width:auto; padding:5px 0px 0px 10px;">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($rigan[azienda_prodotto]) {
  case "VIVISOL":
	echo '<img src="immagini/bottone-vivisol.png">';
  break;
  case "SOL":
	echo '<img src="immagini/bottone-sol.png">';
  break;
}
echo "</div>";
//fine contenitore riga tabella
echo "</div>";

//fine foreach
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}
//div riga grigia separatrice
echo "<div class=riga_divisoria>";
echo "</div>";


$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";

//div per note e pulsanti processi
echo "<div class=servizio>";
echo "<div class=note_pregresse>";
  echo "<div class=note>";
	if ($note_buyer != "") {
	 echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">".$note_buyer."</textarea>";
	} else {
	 echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(nota_".$sing_rda.",".$sing_rda.");\">Note</textarea>";
	}
  echo "</div>";
  echo "<div class=messaggio id=mess_".$sing_rda." title=mess_".$sing_rda.">";
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
$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine blocco sing rda
echo "</div>";
echo "</div>";
//fine contenitore esterno sing rda
echo "</div>";
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
echo "<div class=price6_riga style=\"width:75px;\">";
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
echo "<div class=vuoto9_riga style=\"width:32px;\">";
//fine div checkbox
echo "</div>";

//fine contenitore totale
echo "</div>";
//fine contenitore generale rda
echo "</div>";
	//if ($ricerca != "") {
echo "<div class=contenitore_rda_fattura style=\"margin:10px auto 10px auto;\">";
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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nr_rdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&ricerca=1&lang=".$lingua."&SOL_x=".$_GET['SOL_x']."&VIVISOL_x=".$_GET['VIVISOL_x']."><b>1</b></a>"; 

  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nr_rdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&ricerca=1&lang=".$lingua."&SOL_x=".$_GET['SOL_x']."&VIVISOL_x=".$_GET['VIVISOL_x']."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nr_rdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&ricerca=1&lang=".$lingua."&SOL_x=".$_GET['SOL_x']."&VIVISOL_x=".$_GET['VIVISOL_x']."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nr_rdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&ricerca=1&lang=".$lingua."&SOL_x=".$_GET['SOL_x']."&VIVISOL_x=".$_GET['VIVISOL_x']."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nr_rdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&ricerca=1&lang=".$lingua."&SOL_x=".$_GET['SOL_x']."&VIVISOL_x=".$_GET['VIVISOL_x']."><b>".$last_page."</b></a>"; 
        echo "</td>";
     echo " </tr>";
    echo "</table>";


    echo "</div>";
	//}
?>
</div>

<script type="text/javascript">
$(function(){
$(".datepicker").datepicker();
});
</script>

</body>
</html>
