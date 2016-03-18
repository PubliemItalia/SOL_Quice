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
	$sqlr = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'gestione_rda'";
    $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione02" . mysql_error());
    while ($rigar = mysql_fetch_array($risultr)) {
		switch ($rigar[posizione]) {
			case "lista_attesa_approvazione":
			  $lista_attesa_approvazione = $rigar[testo_it];
			  $colore_attesa_approvazione = $rigar[colore_scritta];
			break;
			case "lista_attesa_gestione":
			  $lista_attesa_gestione = $rigar[testo_it];
			  $colore_attesa_gestione = $rigar[colore_scritta];
			break;
			case "inoltrato_lab":
			  $inoltrato_lab = $rigar[testo_it];
			  $colore_inoltrato_lab = $rigar[colore_scritta];
			break;
			case "inoltrato_ord":
			  $inoltrato_ord = $rigar[testo_it];
			  $colore_inoltrato_ord = $rigar[colore_scritta];
			break;
			case "inoltrato_mag":
			  $inoltrato_mag = $rigar[testo_it];
			  $colore_inoltrato_mag = $rigar[colore_scritta];
			break;
			case "inoltrato_sap":
			  $inoltrato_sap = $rigar[testo_it];
			  $colore_inoltrato_sap = $rigar[colore_scritta];
			break;
			case "finito_ord":
			  $finito_ord = $rigar[testo_it];
			  $colore_finito_ord = $rigar[colore_scritta];
			break;
			case "finito_mag":
			  $finito_mag = $rigar[testo_it];
			  $colore_finito_mag = $rigar[colore_scritta];
			break;
			case "finito_lab":
			  $finito_lab = $rigar[testo_it];
			  $colore_finito_lab = $rigar[colore_scritta];
			break;
			case "finito_sap":
			  $finito_sap = $rigar[testo_it];
			  $colore_finito_sap = $rigar[colore_scritta];
			break;
		}
	}
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
if ($_GET['ricerca'] != "") {
$ricerca = $_GET['ricerca'];
} 
//echo "shopDaModulo: ".$shopDaModulo."<br>";
	//echo '<span style="color: #000;">ricerca: '.$ricerca.'</span><br>';

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

//echo "<span style=\"color:red;\">";
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
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'processo'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'note_sing_rda') {
		$blocco_note_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga_evasa') {
		$blocco_singola_riga_evasa = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_riepilogo_sing_rda = $rigav[codice_php];
	  }

  }
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
  $codice_php_riepilogo_sing_rda = $blocco_riepilogo_sing_rda;
  $codice_php_testatina_righe = $blocco_testatina_righe;
$sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
$sost_ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d.m.Y",$rigay[data_inserimento])."<img src=immagini/spacer.gif width=25 height=2>Utente ".stripslashes($rigay[nome_utente])."<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
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
	$data_inserimento = $rigay[data_inserimento];
	$data_output = $rigay[data_output];
	$data_approvazione = $rigay[data_approvazione];
	$data_chiusura = $rigay[data_chiusura];
	$data_ultima_modifica = $rigay[data_ultima_modifica];
	$stato_orig_rda = stripslashes($rigay[stato]);
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
if ($tipo_negozio != "assets") {
//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
$sost_ut_rda .=$tracciati_sap;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
$sost_ut_rda = $output_wbs.$sost_ut_rda;
}
$tracciati_sap = "";
//inizio contenitore esterno sing rda
echo '<div id="glob_'.$sing_rda.'">';
//inizio div riassunto rda
	$sost_id_rda = $sing_rda;
$codice_php_riepilogo_sing_rda = str_replace("*pulsante_con_id*",$pulsante_con_id,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_puls_piumeno*",$sost_puls_piumeno,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_chiudi*",$sost_chiudi,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_ut_rda*",$sost_ut_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_imm_status*",$imm_status,$codice_php_riepilogo_sing_rda);
echo $codice_php_riepilogo_sing_rda;
$bottone_immagine = '';
$immagine_print = '';
$codice_php_testatina_righe = str_replace("DETTAGLI","",$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*YY*",$immagine_print,$codice_php_testatina_righe);
  echo $codice_php_testatina_righe;
}


//inizio div rda
echo '<div id=blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda">';
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
$codice_php_singola_riga = $blocco_singola_riga;
$codice_php_note_singola_rda = $blocco_note_singola_rda;
//inizio contenitore riga, preso dal database, imposto le variabile da sostituire alla struttura di base
$sost_id_riga = $rigan[id];
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}
// descrizione riga
$sost_descrizione = $rigan[descrizione];
// nome unità riga
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
// totale riga
$sost_totale_riga = number_format($rigan[totale],2,",",".");
$totale_rda = $totale_rda + $rigan[totale];
$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
$colore_scritta = $colore_inoltrato_sap;
if ($rigan[ord_fornitore] != "") {
$dettaglio_stato = $finito_sap." ".$rigan[ord_fornitore]."<br>".$rigan[fornitore_tx];
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
$campo_ordsap = '';
} else {
$campo_ordsap = '';
$dettaglio_stato = $inoltrato_sap;
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
$casella_print = "";
//$sost_logo = '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($rigan[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $sost_logo = '<img src="immagini/bottone-vivisol.png" border="0" style="margin-bottom:5px;">';
	break;
	case "SOL":
	  $sost_logo = '<img src="immagini/bottone-sol.png" border="0" style="margin-bottom:5px;">';
	break;
}
//$sost_logo .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
//$sost_logo .= "</a>";
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	$codice_php_singola_riga = str_replace("*sost_id_riga*",$sost_id_rda,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_aggiornamento*",$colore_aggiornamento,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*aggiornamento_stato*",$aggiornamento_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
	/*$codice_php_singola_riga = str_replace("*casella_print*",$casella_print,$codice_php_singola_riga);*/
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  echo $codice_php_singola_riga;

//fine foreach
}


$totale_rda = "";
  if ($data_output == 0) {
	  $data_output = date("d.m.Y",$data_ultima_modifica);
  }
  if ($data_approvazione == 0) {
	$data_approvazione = date("d.m.Y",$data_inserimento);
  } else {
	$data_approvazione = date("d.m.Y",$data_approvazione);
  }
  if ($data_chiusura == 0) {
	$data_chiusura = date("d.m.Y",$data_ultima_modifica);
  } else {
	$data_chiusura = date("d.m.Y",$data_chiusura);
  }
$tracking = "Inserita il ".date("d.m.Y",$data_inserimento);
//$tracking .= "<br>Approvata il ".date("d.m.Y",$data_approvazione);
$tracking .= "<br>Approvata il ".$data_approvazione;
  switch ($stato_orig_rda) {
	  case 3:
		$tracking .= "<br>In processo dal ".date("d.m.Y",$data_output);
	  break;
	  case 4:
		$tracking .= "<br>Evasa completamente il ".$data_chiusura;
	  break;
  }
  switch ($_SESSION[ruolo]) {
		case "buyer":
		  if ($note_utente != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_utente_rda.'</strong> - '.$note_utente.'<br>';
		  } else {
			  $sost_note_immodificabili .= '';
		  }
		  if ($note_resp != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_resp_rda.'</strong> - '.$note_resp.'<br>';
		  }
		  if ($note_magazziniere != "") {
			  $sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere.'<br>';
		  }
		  $sost_autore = '<strong>Buyer</strong>';
		  if ($note_buyer != "") {
		   $sost_nota_modificabile = '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onfocus="azzera_nota('.$sing_rda.');" onblur="ripristina_nota('.$sing_rda.');" onClick="controllo('.$sing_rda.');" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">'.$note_buyer.'</textarea>';
		  } else {
		   $sost_nota_modificabile = '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onfocus="azzera_nota('.$sing_rda.');" onblur="ripristina_nota('.$sing_rda.');" onClick="controllo('.$sing_rda.');" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">Note</textarea>';
		  }
		break;
  }
//switch ($statusDaModulo) {
//	default:
		if ($contatore_righe_flag > 0) {
		  $sost_pulsante_processo = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:500,height:320,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=\"immagini/btn_processarda.png\" width=\"160\" height=\"25\" border=\"0\"></a>";
		}
//	break;
//	case "lab":
//	case "ord":
//	case "mag":
//	case "sap":
	  if ($righeSapProcessate == $Num_righe_sap_rda) {
		$sost_pulsante_sap = "";
	  } else {
		if ($Num_righe_rdasap_selezionate > 0) {
		  $altezza_finestra = ($Num_righe_rdasap_selezionate*37)+125+180;
		  if ($altezza_finestra > 800) {
			  $altezza_finestra = 800;
		  }
		  $sost_pulsante_sap = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda_ordsap.php?report=1&a=1&pers=&id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40',closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=\"immagini/btn_inserisciOrdSap.png\" width=\"160\" height=\"25\" border=\"0\"></a>";
		} else {
			$sost_pulsante_sap = "";
		}
	  }
	  if ($Num_righe_ord_rda > 0) {
		  $sost_pulsante_ord = '<a href="ordine_fornitore.php?id_ord='.$ordine_for.'&id_rda='.$sing_rda.'" target="_blank"><img src="immagini/btn_visOrd.jpg" width="160" height="25" border="0"></a>';
		} else {
			$sost_pulsante_ord = "";
	  }
	//break;
//}
$sost_pulsante_stampa = '<a href="stampa_rda.php?id_rda='.$sing_rda.'&mode=print&lang='.$lingua.'" target="_blank"><img src="immagini/btn_stampa.png" width="160" height="25" border="0"></a>';
//div per note e pulsanti processi
	$codice_php_note_singola_rda = str_replace("*sost_autore*",$sost_autore,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*tracking*",$tracking,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_note_immodificabili*",$sost_note_immodificabili,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_nota_modificabile*",$sost_nota_modificabile,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_stampa*",$sost_pulsante_stampa,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_sap*",$sost_pulsante_sap,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_ord*",$sost_pulsante_ord,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_processo*",$sost_pulsante_processo,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_id_riga*",$sing_rda,$codice_php_note_singola_rda);
	
  echo $codice_php_note_singola_rda;
  $sost_note_immodificabili = "";
  $sost_pulsante_processo = "";
$totale_rda = "";
$selezione_singola = "";
$selezione_multipla_app = "";
$sf = "";
$totale_rda_completa = "";
$somma = "";
$Num_righe_sap_rda = '';
$Num_righe_evadere = "";
$Num_righe_processate = ""; 
$righeSapDaProcessare = "";
$righeSapProcessate = "";
$Num_righe_rda = "";
$Num_righe_rdasap_selezionate = '';
$Num_righe_evadere_chiusura = '';
$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine blocco sing rda
//fine contenitore esterno sing rda
echo "</div>";
echo "</div>";
}




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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&lang=".$lingua."&societa=".$societaDaModulo."><b>1</b></a>"; 

  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&lang=".$lingua."&societa=".$societaDaModulo."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&lang=".$lingua."&societa=".$societaDaModulo."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&lang=".$lingua."&societa=".$societaDaModulo."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&lang=".$lingua."&societa=".$societaDaModulo."><b>".$last_page."</b></a>"; 
        echo "</td>";
     echo " </tr>";
    echo "</table>";


    echo "</div>";
	//}
?>
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
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "data_fine":
		  var data_fine_val = valore;
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		break;
		case "societa":
		  var socval = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "shop":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shopval = valore;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
	}
	var nr_rda = document.getElementById('nr_rda').value;
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
	/*alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);*/
		  $.ajax({
			type: "POST",   
			url: "motore_ricerca_MSC.php",   
			data: "societa="+socval+"&shop="+shopval+"&nr_rda="+nr_rda+"&data_inizio="+data_inizio_val+"&data_fine="+data_fine_val+"&file_presente=<?php echo $file_presente; ?>",
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
   // }else{
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
