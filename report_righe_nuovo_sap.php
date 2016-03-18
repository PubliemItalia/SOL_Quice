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
if ($_GET['codice_art'] != "") {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$f = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}
if ($_GET['status'] != "") {
$statusDaModulo = $_GET['status'];
} 
if ($statusDaModulo != "") {
	switch ($statusDaModulo) {
		case "no_process":
		  $g = "output_mode = ''";
		break;
		case "sap":
		  $g = "output_mode = 'sap'";
		break;
		case "mag":
		  $g = "output_mode = 'mag' AND evaso_magazzino = '0'";
		break;
		case "mag_evaso":
		  $g = "output_mode = 'mag' AND evaso_magazzino = '1'";
		break;
		case "ordine":
		  $g = "output_mode = 'ord'";
		break;
	}
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
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4' AND flag_chiusura = '0' AND ";
	$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '4' AND flag_chiusura = '0' AND ";
  } else {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = '4' AND flag_chiusura = '0' AND ";
	$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = '4' AND flag_chiusura = '0' AND ";
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
  $testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = '4' AND flag_chiusura = '0'";
  $sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = '4' AND flag_chiusura = '0'";
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
$_SESSION[percorso_ritorno] ="report_righe_nuovo.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&button=Filtra";

include "menu_quice3.php";
?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report_balconi.css" />
<style type="text/css">
#main_container {
	width:960px;
    height: auto;
	margin: auto;
	margin-top: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align:center;
	background-color:#e5f6ff;
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
//if ($flag_ricerca != "") {
//echo "<body style=\"background-color:rgb(214,232,246);\">";
//} else {
echo "<body>";
//}
}

?>
	<div id="main_container" style="text-align:left;">
<!--div ricerca report righe nuovo per balconi-->
    <?php include "modulo_filtri.php";
switch($statusDaModulo) {
	case "":
	$fondo_stato = "#a09e9a";
	$scritta_stato = "";
	break;
	case "no_process":
	$fondo_stato = "#bdbdbd";
	$scritta_stato = "NON PROCESSATO";
	break;
	case "ordine":
	$fondo_stato = "#33b655";
	$scritta_stato = "ORDINE";
	break;
	case "sap":
	$fondo_stato = "#11bfe4";
	$scritta_stato = "SAP";
	break;
	case "mag":
	$fondo_stato = "#e9a441";
	$scritta_stato = "MAG";
	break;
	case "mag_evaso":
	$fondo_stato = "#ac670e";
	$scritta_stato = "MAG EVASO";
	break;
}
?>
<!--<div id="filtro_rda" class="submenureport" style="float:left; width:100%; margin-bottom:10px; background-image:none; height:auto; color:rgb(255,255,255); padding-top:0px; font-size:12px; font-weight:bold; background-color:<?php echo $fondo_stato; ?>;">
  <div style="width:200px; height:auto; text-align:left; float:left; padding:3px 0px 3px 10px; background-color:transparent; color:#ffde43;">
    <select name="status" id="status"  style="height:27px; width: auto;" onChange="ricarica_con_stato(this.value);">
	<?php 
/*		  switch($statusDaModulo) {
			  default:
				echo '<option selected value="">Filtrazione RdA</option>
				<option value="sap">SAP</option>
				<option value="mag">MAG</option>
				<option value="ord">ORDINE</option>
				<option value="no_process">NON PROCESSATO</option>
				<option value="">RIMUOVI FILTRI</option>';
			  break;
			  case "sap":
				echo '<option value="">Filtrazione RdA</option>
				<option selected value="sap">SAP</option>
				<option value="mag">MAG</option>
				<option value="ord">ORDINE</option>
				<option value="no_process">NON PROCESSATO</option>
				<option value="">RIMUOVI FILTRI</option>';
			  break;
			  case "ord":
				echo '<option value="">Filtrazione RdA</option>
				<option value="sap">SAP</option>
				<option value="mag">MAG</option>
				<option selected value="ord">ORDINE</option>
				<option value="no_process">NON PROCESSATO</option>
				<option value="">RIMUOVI FILTRI</option>';
			  break;
			  case "mag":
				echo '<option value="">Filtrazione RdA</option>
				<option value="sap">SAP</option>
				<option selected value="mag">MAG</option>
				<option value="ord">ORDINE</option>
				<option value="no_process">NON PROCESSATO</option>
				<option value="">RIMUOVI FILTRI</option>';
			  break;
			  case "no_process":
				echo '<option value="">Filtrazione RdA</option>
				<option value="sap">SAP</option>
				<option value="mag">MAG</option>
				<option value="ord">ORDINE</option>
				<option selected value="no_process">NON PROCESSATO</option>
				<option value="">RIMUOVI FILTRI</option>';
			  break;
		  }
*/	?>
    </select>

  </div>
</div>
    -->
-->

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
	$discrim = "0";
  if (($row[output_mode] == "sap") AND ($row[flag_chiusura] == "0")) {
	$discrim = "1";
  }
  //echo "RdA ".$row[id_rda]." - discrim:".$discrim."<br>";
  
if ($discrim == "1") {
	if (!in_array($row[id_rda],$array_rda)) {
	$add_rda = array_push($array_rda,$row[id_rda]);
	}
  } else {
  }
}

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
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione06" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
$ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d.m.Y",$rigay[data_inserimento])."<img src=immagini/spacer.gif width=25 height=2>";
if ($rigay[id_utente] == $rigay[id_resp]) {
$ut_rda .= "Ut./Resp. ".stripslashes($rigay[nome_utente]);
} else {
$ut_rda .= "Ut. ".stripslashes($rigay[nome_utente])." - Resp. ".stripslashes($rigay[nome_resp]);
}
/*
	$sqlx = "SELECT * FROM qui_utenti WHERE user_id = '$rigay[id_utente]'";
$risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
while ($rigax = mysql_fetch_array($risultx)) {
$ut_rda .= "Utente ".$rigay[id_utente]." - ".stripslashes($rigax[nome]);
}
*/
	$sqlh = "SELECT * FROM qui_unita WHERE id_unita = '$rigay[id_unita]'";
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione07" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
$nome_resp_rda = stripslashes($rigah[nome_resp]);
$id_resp_rda = stripslashes($rigah[id_resp]);
}
$ut_rda .= "<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
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

//inizio contenitore esterno sing rda
echo "<div class=cont_rda id=glob_".$sing_rda." >";
//inizio div riassunto rda
echo "<div id=riassunto_rda_".$sing_rda." class=riassunto_rda>";
$sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
$resultm = mysql_query($sqlm);
$Num_righe_rda = mysql_num_rows($resultm);
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
echo "<div class=riepilogo_rda>";
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
echo '<div class="stato_rda" style="margin-left:30px;">';
echo $imm_status;
echo "</div>";
$tracciati_sap = "";
 $sf = 1;

//determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine = '4' AND output_mode = 'sap'  AND flag_chiusura = '0'";
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
if ($g != "") {
$sqlk .= " AND ".$g;
}
}
$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[flag_buyer] == 4) {
$Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
}

//if ($flag_ricerca != "") {
  //} else {
	if ($Num_righe_rda_selezionate != $Num_righe_rda) {
	$tooltip_select = "Seleziona tutto";
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$sing_rda.",4);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	} else {
	$tooltip_select = "Deseleziona tutto";
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$sing_rda.",2);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	}
  //}
}

echo "<div id=bott_".$sing_rda." class=sel_all style=\"width:50px; text-align:right; margin-right:15px;\">";
echo $bottone_immagine;
echo "</div>";
//}
echo "</div>";


//inizio div rda
//if ($Num_righe_evadere == $Num_righe_rda) {
//echo "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
//} else {
echo "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:block;\">";
//}
//echo "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine = '4' AND output_mode = 'sap' AND flag_chiusura = '0'";
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
echo "<div class=descr4_riga style=\"width:400px;\">";
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
//div pulsante per evasione parziale riga
echo "<div class=lente_prodotto>";
//fine div pulsante per evasione parziale riga
echo "</div>";
//div pulsante per visualizzare scheda
echo "<div class=lente_prodotto>";
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	$giacenza = $rigam[giacenza];
	if ($rigam[categoria1_it] == "Bombole") {
  echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigam[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
//fine div pulsante per visualizzare scheda
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

$sqlc = "SELECT * FROM qui_rda WHERE id='".$rigan[id_rda]."'";
$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$rda_exist = mysql_num_rows($risultc);	
//div evaso (vuoto)
echo "<div class=vuoto9_riga style=\"width:32px;\">";
//fine div evaso
echo "</div>";
//div checkbox (vuoto)
echo '<div class="sel_all_riga" id="'.$rigan[id].'" style="padding-top:3px;">';
//if ($rigan[output_mode] == "") {
if ($rda_exist > 0) {
switch ($rigan[flag_buyer]) {
case "2":
  echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'4',".$sing_rda.");\">";
break;
case "4":
echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.");\">";
$contatore_righe_flag = $contatore_righe_flag + 1;
  break;
}
}
//fine div checkbox
echo "</div>";

echo '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
echo '<div class="sel_all_riga" style="padding-top: 2px; width:20px; padding-left:10px;">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($rigan[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  echo '<img src="immagini/bottone-vivisol.png" style="margin-bottom:2px;">';
	break;
	case "SOL":
	  echo '<img src="immagini/bottone-sol.png" style="margin-bottom:2px;">';
	break;
}
echo '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
$giacenza = "";
echo "</div>";
echo "</a>";
echo "</div>";
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}
$rda_exist = "";

//fine foreach
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
echo "<div style=\"width:350px; height:auto; float:left;\">";
  echo "<div class=note>";
	if ($note_buyer != "") {
	 echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(".$sing_rda.");\">".$note_buyer."</textarea>";
	} else {
	 echo "<textarea name=nota_".$sing_rda." class=campo_note id=nota_".$sing_rda." onKeyUp=\"aggiorna_nota(".$sing_rda.");\">Note</textarea>";
	}
  echo "</div>";
  echo "<div style=\"width:100%; height:15px; padding:5px; float:left;\" id=salva_".$sing_rda.">";
  //qui viene inserito il pulsante salva tramite jquery quando si modifica la nota
  echo "</div>";
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
//if ($flag_ricerca == "") {
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id_rda=".$sing_rda."&mode=print&lang=".$lingua."', 'myPop1',800,800);\">";
echo '<div class="puls_servizio" style="padding-left:0px;">';
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('stampa_rda.php?id=".$sing_rda."&lang=".$lingua."', 'myPop1',800,800);\"><div class=puls_servizio>";
echo "Stampa RdA";
echo "</div></a>";
//echo "Num_righe_rda_selezionate: ".$Num_righe_rda_selezionate."<br>";
//echo "Num_righe_rda: ".$Num_righe_rda."<br>";
if ($Num_righe_rda_selezionate > 0) {
//echo "<a href=\"javascript:void(0);\" onclick=\"chiusura(".$sing_rda.")\">";
echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda_ordsap.php?report=1&a=1&pers=&id=".$sing_rda."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40',closejs:function(){refresh_rda(".$sing_rda.")}})\">";
	echo '<div class="puls_servizio" style="padding-left:0px;">';
	  echo "<div class=btnFrecciaRedLunga>Inserisci Ordine SAP</div>";
	echo "</div>";
echo "</a>";
}
//}
$Num_righe_rda_selezionate = "";
$Num_righe_rda = "";

echo "<div id=puls_processa_".$sing_rda.">";
//if ($flag_ricerca == "") {
//}
echo "</div>";
//fine blocco pulsantini a destra
echo "</div>";

$contatore_righe_flag = "";
$contatore_x_chiusura = "";
//fine blocco sing rda
echo "</div>";
echo "</div>";
//echo "</div>";
//fine contenitore esterno sing rda
echo "</div>";
//fine foreach
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

?>
<div id = "access" style="display:none;">
</div>
</div>





<script type="text/javascript">

function axc_multi(id_rda,valoreCheck){
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_SAP.php",   
						data: "multi=1&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_ricerca=<?php echo $categoria_ricerca_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&codice_art=<?php echo $codice_artDaModulo; ?>"+"&check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&ricerca=<?php echo $flag_ricerca; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "aggiorna_testata_rda_SAP.php",   
						data: "check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#bott_'+id_rda).html(output).show();
						}
						})

}
function refresh_rda(id_rda){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_SAP.php",   
						data: "id_rda="+id_rda+"&chiudere=1&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function ricarica_con_stato(statusval){
	/*var statusval = document.getElementById('status').value;*/
						//alert("<?php echo $_SERVER['PHP_SELF']; ?>");
	if (statusval == "sap") {
	  location.href ="http://10.171.1.176/<?php echo $dir_lavoro; ?>/report_righe_nuovo_sap.php?status="+statusval;
	} else {
	  location.href ="http://10.171.1.176/<?php echo $dir_lavoro; ?>/report_righe_nuovo.php?status="+statusval;
	}
}
function axc(id_riga,valoreCheck,id_rda){
						/*alert(valoreCheck);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_SAP.php",   
						data: "unita=<?php echo $unitaDaModulo; ?>"+"&categoria_ricerca=<?php echo $categoria_ricerca_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&codice_art=<?php echo $codice_artDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&ricerca=<?php echo $flag_ricerca; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

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
						/*alert("ok");*/
				$.ajax({
						type: "GET",   
						url: "imposta_chiusura_sap.php",   
						data: "id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#glob_'+id_rda).html(output).show();
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

function vis_invis(id_riga)  {
	/*alert(id_riga);*/
                if ($('#blocco_rda_'+id_riga).css('display')=='none'){
                    $('#blocco_rda_'+id_riga).css('display', 'block');
                } else {
                    $('#blocco_rda_'+id_riga).css('display', 'none');
                }
 }

</SCRIPT>
</body>
</html>
