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
			case "inoltrato_bmc":
			  $inoltrato_bmc = $rigar[testo_it];
			  $colore_inoltrato_bmc = $rigar[colore_scritta];
			break;
			case "inoltrato_htc":
			  $inoltrato_htc = $rigar[testo_it];
			  $colore_inoltrato_htc = $rigar[colore_scritta];
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
			case "finito_bmc":
			  $finito_bmc = $rigar[testo_it];
			  $colore_finito_bmc = $rigar[colore_scritta];
			break;
			case "finito_htc":
			  $finito_htc = $rigar[testo_it];
			  $colore_finito_htc = $rigar[colore_scritta];
			break;
		}
	}
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
if ($stampa != "1") {
include "menu_quice3.php";
}
$flusso_mag = $_SESSION[flusso];

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
/*
*/

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
if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
$e = "azienda_prodotto = '$societaDaModulo'";
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
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0' AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0' AND ";

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
$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
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

//echo '<br><span style="color: #000;">testoQuery: '.$testoQuery.'</span><br>';
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
  <title>Quice - Processo magazzino</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/report_balconi.css" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
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
.ui-datepicker th {
	color:#000 !important;
}
/* This only works with JavaScript, 
		   if it's not present, don't show loader */
		#loader { 
		display: none;
		}
		#loader { display: block; 
		position: absolute; 
		left:0; top: 0; 
		width:100%; 
		height:100%; 
		background-color:rgb(255,255,255); 
		/*opacity: 0.6;
		filter: alpha(opacity=60); *//* For IE8 and earlier */
		z-index:99995; 
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
	<script>
    /*var width = viewportSize.getWidth();
    var height = viewportSize.getHeight();
	alert(height);*/
		// Wait for window load
		$(window).load(function() {
			// Animate loader off screen
			$("#layer2").animate({
				left: -4000
			}, 1500);
		});
	</script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  window.location.href = window.location.href;
}
</SCRIPT>

</head>

<?php
//echo 'flusso_mag: '.$flusso_mag.'<br>';
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
<div id="outerWrap">
  <div id="layer2">
    <div style="margin:20%; width:60%; height:60%; color: #999; text-align:center; font-size:24px;">
      Sto caricando i dati/<br>Loading data<br><br><img src="images/preloader_image.gif">
    </div>
  </div>
  <div id="layer1">
<div id="main_container">
<?php include "modulo_filtri.php"; ?>


<div id="blocco_generale" style="float:left;">
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
	  if ($rigav[rif_blocco] == 'indir_rda') {
		$blocco_indir_sing_rda = $rigav[codice_php];
	  }
  }
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
  $codice_php_riepilogo_sing_rda = $blocco_riepilogo_sing_rda;
  $codice_php_testatina_righe = $blocco_testatina_righe;
  $sost_id_rda = $sing_rda;
  $sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigay = mysql_fetch_array($risulty)) {
	$indirizzo_spedizione = $rigay[indirizzo_spedizione];
	if ($indirizzo_spedizione == "") {
	  $sqld = "SELECT * FROM qui_utenti WHERE user_id = '$rigay[id_utente]'";
	  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigad = mysql_fetch_array($risultd)) {
		  if ($rigad[companyName] != "") {
		  $indirizzo_spedizione .= "<strong>".$rigad[companyName]."</strong><br>";
		  }
		  $indirizzo_spedizione .= "<strong>".$rigad[nomeunita]."</strong><br>";
		  $indirizzo_spedizione .= $rigad[indirizzo]."<br>";
		  $indirizzo_spedizione .= $rigad[cap]." ";
		  $indirizzo_spedizione .= $rigad[localita]."<br>";
		  $indirizzo_spedizione .= $rigad[nazione];
	  }
	}
	  $data_inserimento = $rigay[data_inserimento];
	  $data_approvazione = $rigay[data_approvazione];
	  $data_chiusura = $rigay[data_chiusura];
	  $data_ultima_modifica = $rigay[data_ultima_modifica];
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
  $sost_ut_rda = $ut_rda;

  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
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
	$bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,3,'.$sing_rda.',2);"><img src="immagini/select-all.png" width="17" height="17" border="0" title="'.$tooltip_select.'"></a>';
  } else {
	$tooltip_select = $tooltip_deseleziona_tutto;
	$bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,2,'.$sing_rda.',2);"><img src="immagini/select-none.png" width="17" height="17" border="0" title="'.$tooltip_select.'"></a>';
  }
  
  
  if ($flag_ricerca == "") {
	if ($stampa != "1") {
	  if ($Num_righe_processate < $Num_righe_rda) {
  } else {
	  $bottone_immagine == '';
	  }
	}
  }
$sost_puls_piumeno = 'immagini/a-meno.png';
$pulsante_con_id = 'pulsante_'.$sost_id_rda;
$sost_chiudi = '<input name="open_status_'.$sost_id_rda.'" type="hidden" id="open_status_'.$sost_id_rda.'" value="1">';
$codice_php_riepilogo_sing_rda = str_replace("*pulsante_con_id*",$pulsante_con_id,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_puls_piumeno*",$sost_puls_piumeno,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_chiudi*",$sost_chiudi,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_ut_rda*",$sost_ut_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_riepilogo_sing_rda);

$codice_php_riepilogo_sing_rda = str_replace("*sost_imm_status*",$imm_status,$codice_php_riepilogo_sing_rda);
echo $codice_php_riepilogo_sing_rda;
  //echo "selezionate: ".$Num_righe_rda_selezionate."<br>";
  //echo "processate: ".$Num_righe_processate."<br>";
  //echo "righe totali: ".$Num_righe_rda."<br>";
  //echo "righe da evadere: ".$Num_righe_evadere."<br>";
  echo '<div class="cont_rda blocco_rda" id="blocco_rda_'.$sing_rda.'">';
  $Num_righe_evadere = "";
  $Num_righe_rda = "";
	$immagine_print = '<img src="immagini/btn_multi_stampa.jpg" border="0"></a>';
	$codice_php_testatina_righe = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace('id="col09c" style="width: 55px;','id="col09c" style="width: 95px !important;',$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace('id="col10c" style="width: 60px;','id="col10c" style="width: 52px !important;',$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace("width: 19px; padding-left: 13px;","width: 19px; padding-left: 20px !important;",$codice_php_testatina_righe);
	
	//$codice_php_testatina_righe = str_replace("*YY*",$immagine_print,$codice_php_testatina_righe);
  echo $codice_php_testatina_righe;
  //inizio div rda
  
  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
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
	$codice_php_singola_riga = $blocco_singola_riga;
	if (substr($rigan[codice_art],0,1) != "*") {
	  $sost_codice_art .= $rigan[codice_art];
	} else {
	  $sost_codice_art .= substr($rigan[codice_art],1);
	}
	$sost_descrizione = $rigan[descrizione];
if ($rigan[urgente] == 1) {
	$sost_descrizione.= '<span style="color:red; font-weight: bold;"> - Urgente</span>';
}
	if ($rigan[negozio] == "labels") {
	  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		  $label_ric_mag = $rigap[ric_mag];
		/*if ($rigap[ric_mag] != "mag") {
			  echo "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
		}*/
	  }
	}
 
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
if ($stampa != "1") {
  if (($rigan[negozio] == "labels") AND ($label_ric_mag != "mag")) {
  } else {
	if ($sost_quant > 1) {
	  $bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:980,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	$bottone_edit = "";
	}
	  $bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_magazz.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:980,height:340,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc('0','0',".$rigan[id_rda].",'0')}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
} else {
	$bottone_edit = "";
}
  if ($stampa != "1") {
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	  $giacenza = $rigam[giacenza];
	  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  }
  // totale riga
  $sost_totale_riga = number_format($rigan[totale],2,",",".");
  $totale_rda = $totale_rda + $rigan[totale];
	if ($rigan[evaso_magazzino] == 0) {
	  if ($stampa != "1") {
		switch ($rigan[flag_buyer]) {
		  case "2":
			$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'3',".$sing_rda.",1);\">";
		  break;
		  case "3":
			$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.",1);\">";
			$contatore_righe_flag = $contatore_righe_flag + 1;
		  break;
		}
	  }
	}
$indicatore_fatturazione = substr($rigan[dest_contab],0,1);
switch ($indicatore_fatturazione) {
	case "":
	break;
	case "F":
	  $sost_logo .= '<img src="immagini/bottone-F.png" border="0" style="margin-bottom:5px; margin-right:3px;">';
	break;
	case "G":
	  $sost_logo .= '<img src="immagini/bottone-G.png" border="0" style="margin-bottom:5px; margin-right:3px;">';
	break;
}
$indicatore_fatturazione = "";
	$sost_logo .= '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
	//echo 'neg: '.$rigan[negozio].'<br>';
	switch ($rigan[azienda_prodotto]) {
		case "":
		break;
		case "VIVISOL":
		  $sost_logo .= '<img src="immagini/bottone-vivisol.png" border="0" style="margin-bottom:5px;">';
		break;
		case "SOL":
		  $sost_logo .= '<img src="immagini/bottone-sol.png" border="0" style="margin-bottom:5px;">';
		break;
	}
	$sost_logo .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
	$sost_logo .= "</a>";
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	
	$codice_php_singola_riga = str_replace('id="col01d" class="confez5_riga" style="width: 63px;','id="col01d" class="confez5_riga" style="width: 54px !important;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col02d" style="width: 55px;','id="col02d" style="width: 40px !important;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col03d" class="descr4_riga" style="width: 40px;','id="col03d" class="descr4_riga" style="width: 290px !important; padding-left: 10px; padding-top: 0px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col04d" class="cod1_riga" style="width: 200px;','id="col04d" class="cod1_riga" style="width: 70px !important; padding-top: 0px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col07d" class="lente_prodotto" style="width: 25px; float: left; height: 19px;','id="col07d" class="lente_prodotto" style="width: 30px; float: left; height: 19px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col08d" class="modifica_prodotto" style="width: 55px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: right; margin-right: 15px;','id="col08d" class="modifica_prodotto" style="width: 25px; float: left; min-height: 19px; overflow: hidden; height: auto; text-align: right; margin-right: 7px;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace('id="col09d" style="width: 60px;','id="col09d" style="width: 167px !important;',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_id_riga*",$sost_id_rda,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_scritta*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_aggiornamento*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*aggiornamento_stato*",'',$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
	/*$codice_php_singola_riga = str_replace("*casella_print*",$casella_print,$codice_php_singola_riga);*/
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  echo $codice_php_singola_riga;
$giacenza = "";
$rda_exist = "";

  //fine contenitore riga tabella
  
  //fine foreach
  }
  //RIGHE EVASE MAGAZZINO
    $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '1'";
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
$codice_php_singola_riga_evasa = $blocco_singola_riga_evasa;
	if (substr($rigan[codice_art],0,1) != "*") {
	  $sost_codice_art .= $rigan[codice_art];
	} else {
	  $sost_codice_art .= substr($rigan[codice_art],1);
	}
	$sost_descrizione = $rigan[descrizione];
	if ($rigan[negozio] == "labels") {
	  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		  $label_ric_mag = $rigap[ric_mag];
		/*if ($rigap[ric_mag] != "mag") {
			  echo "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
		}*/
	  }
	}
 
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
	$bottone_edit = "";
  if ($stampa != "1") {
  $sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	  $giacenza = $rigam[giacenza];
	  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigan[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  }
  // totale riga
  $sost_totale_riga = number_format($rigan[totale],2,",",".");
  $totale_rda = $totale_rda + $rigan[totale];
	$casella_check = "";
	$sost_logo = '<a href="report_prodotti.php?shop='.$rigan[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigan[codice_art].'&categoria4=&ricerca=1" target="_blank">';
	//echo 'neg: '.$rigan[negozio].'<br>';
	switch ($rigan[azienda_prodotto]) {
		case "":
		break;
		case "VIVISOL":
		  $sost_logo .= '<img src="immagini/bottone-vivisol.png" border="0" style="margin-bottom:5px;">';
		break;
		case "SOL":
		  $sost_logo .= '<img src="immagini/bottone-sol.png" border="0" style="margin-bottom:5px;">';
		break;
	}
	$sost_logo .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
	$sost_logo .= "</a>";
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "mag":
$colore_scritta = "style_mag";
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
}
break;
case "lab":
$colore_scritta = "style_lab";
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
}
break;
case "bmc":
case "htc":
$colore_scritta = "style_lab";
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
}
break;
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
	$codice_php_singola_riga_evasa = str_replace('id="col01d" class="confez5_riga" style="width: 63px;','id="col01d" class="confez5_riga" style="width: 54px !important;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col02d" style="width: 55px;','id="col02d" style="width: 40px !important;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col03d" class="descr4_riga" style="width: 40px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: center;','id="col03d" class="descr4_riga" style="width: 290px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: left; padding-left: 10px; padding-top: 0px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col04d" class="cod1_riga" style="width: 200px;','id="col04d" class="cod1_riga" style="width: 70px !important; padding-top: 0px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col07d" class="lente_prodotto" style="width: 25px; float: left; height: 19px;','id="col07d" class="lente_prodotto" style="width: 30px; float: left; height: 19px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace('id="col08d" class="modifica_prodotto" style="width: 55px; float: left; min-height: 10px; overflow: hidden; height: auto; text-align: right; margin-right: 15px;','id="col08d" class="modifica_prodotto" style="width: 25px; float: left; min-height: 19px; overflow: hidden; height: auto; text-align: right; margin-right: 7px;',$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*colore_aggiornamento*",$colore_aggiornamento,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*aggiornamento_stato*",$aggiornamento_stato,$codice_php_singola_riga_evasa);
	$codice_php_singola_riga_evasa = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga_evasa);
	/*$codice_php_singola_riga_evasa = str_replace("*casella_print_evasa*",$casella_print_evasa,$codice_php_singola_riga_evasa);*/
	$sost_codice_art = '';
	$colore_scritta = '';
	$sost_logo = '';
  echo $codice_php_singola_riga_evasa;
$dettaglio_stato = "";
$giacenza = "";
$rda_exist = "";

  //fine contenitore riga tabella
  
  //fine while
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
$tracking .= "<br>Approvata il ".$data_approvazione;
		$tracking .= "<br>In processo dal ".$data_approvazione;
		  if ($note_utente != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_utente_rda.'</strong> - '.$note_utente.'<br>';
		  } else {
			  $sost_note_immodificabili .= '';
		  }
		  if ($note_resp != "") {
			  $sost_note_immodificabili .= '<strong>'.$nome_resp_rda.'</strong> - '.$note_resp.'<br>';
		  }
		  if ($note_buyer != "") {
			  $sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer.'<br>';
		  }
		  $sost_autore = '<strong>Magazziniere</strong>';
		  if ($note_magazziniere != "") {
		   $sost_nota_modificabile = '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onfocus="azzera_nota('.$sing_rda.');" onblur="ripristina_nota('.$sing_rda.');" onClick="controllo('.$sing_rda.');" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">'.$note_magazziniere.'</textarea>';
		  } else {
		   $sost_nota_modificabile = '<textarea name="nota_'.$sing_rda.'" class="campo_note" id="nota_'.$sing_rda.'" onfocus="azzera_nota('.$sing_rda.');" onblur="ripristina_nota('.$sing_rda.');" onClick="controllo('.$sing_rda.');" onKeyUp="aggiorna_nota(nota_'.$sing_rda.','.$sing_rda.');">Note</textarea>';
		  }
		$sost_pulsante_sap = "";
		$sost_pulsante_ord = "";
  if ($contatore_righe_flag > 0) {
  $sost_pulsante_processo = "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('packing_list.php?id_rda=".$sing_rda."&lang=".$lingua."&id_utente=".$id_utente."&mode=nuovo', 'myPop1',800,800);\">";
  $sost_pulsante_processo .= '<img src="immagini/btn_creaPL.png" width="160" height="25" border="0"></a>';
  }
		if ($Num_righe_rdasap_selezionate > 0) {
		  $altezza_finestra = ($Num_righe_rdasap_selezionate*37)+125+180;
		  if ($altezza_finestra > 800) {
			  $altezza_finestra = 800;
		  }
		}

	$codice_php_note_singola_rda = $blocco_note_singola_rda;
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
$Num_righe_evadere_chiusura = '';
$contatore_righe_flag = "";
$contatore_x_chiusura = "";
  $Num_righe_rda_selezionate = "";
  $totale_rda = "";
  $selezione_singola = "";
  $selezione_multipla_app = "";
  $sf = "";
 $codice_php_indir_singola_rda = $blocco_indir_sing_rda;
$codice_php_indir_singola_rda = str_replace("*testo_indirizzo*",$indirizzo_spedizione,$codice_php_indir_singola_rda);
echo $codice_php_indir_singola_rda;
 
  echo "</div>";
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
  echo '<div class="price6_riga_quant" style="width: 100px; float: left;">';
  echo "<strong>TOTALE</strong>";
  echo "</div>";
  //div totale riga
  echo '<div class="price6_riga" style="float:right; margin-right: 180px; width: 150px;">';
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
<!--fine layer1-->
</div>

<!--fine outer wrap-->
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
function axc(id_riga,valoreCheck,id_rda,mode){
						/*alert(valoreCheck);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_mag.php",   
						data: "mode="+mode+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&lang=<?php echo $lingua; ?>",
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
function chiusura(){
  window.location.href = "report_righe_mag.php?societa=<?php echo $societaDaModulo; ?>&shop=<?php echo $shopDaModulo; ?>&unita=<?php echo $unitaDaModulo; ?>&categoria_righe=<?php echo $categ_DaModulo; ?>&codice_art=<?php echo $codice_artDaModulo; ?>&data_inizio=<?php echo $data_inizio; ?>&data_fine=<?php echo $data_fine; ?>";
				/*
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_mag.php",   
						data: "mode="+mode+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda,
						success: function(output) {
						$('#blocco_generale').html(output).show();
						}
						})

						alert(pl);*/
}
function trasf_pl() {
window.open("lista_pl.php");
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
function msc(mode,valore){
	switch (mode) {
		case "societa":
		  var socval = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		break;
		case "unita":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unitaval = valore;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		break;
		case "shop":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shopval = valore;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		break;
		case "categoria_righe":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var categval = valore;
		break;
	}
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
	var codice_art = document.getElementById('codice_art').value;
	/*
	alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+codice_art+","+data_inizio_val+","+data_fine_val);
	alert("OK");
	*/
	if(((data_inizio_val != "") && (data_fine_val != "")) || ((data_inizio_val == "") && (data_fine_val == ""))){
        data1str = data_inizio.substr(6)+data_inizio.substr(3, 2)+data_inizio.substr(0, 2);
		data2str = data_fine.substr(6)+data_fine.substr(3, 2)+data_fine.substr(0, 2);
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
		alert("Compila entrambre le date!");
	}
}
function invioform() {
	var data_inizio = document.getElementById('data_inizio').value;
	var data_fine = document.getElementById('data_fine').value;
	if(((data_inizio != "") && (data_fine != "")) || ((data_inizio == "") && (data_fine == ""))){
		document.form_filtri2.submit();
	} else {
		alert("Compila entrambre le date!");
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
function vis_invis(id_riga)  {
	var status = document.getElementById('open_status_'+id_riga).value;
   $('#blocco_rda_'+id_riga).slideToggle(500);
   if (status == 0) {
	  document.getElementById('open_status_'+id_riga).value = "1";
	  $('#pulsante_'+id_riga).html('<img src="immagini/a-meno.png" border="0">')
   } else {
	  document.getElementById('open_status_'+id_riga).value = "0";
	  $('#pulsante_'+id_riga).html('<img src="immagini/a-piu.png" border="0">')
   }
	/*alert(id_riga);
                if ($('#blocco_rda_'+id_riga).css('display')=='none'){
                    $('#blocco_rda_'+id_riga).css('display', 'block');
                    $('#pulsante_'+id_riga).html('<img src="immagini/a-meno.png" border="0">');
                } else {
                    $('#blocco_rda_'+id_riga).css('display', 'none');
                    $('#pulsante_'+id_riga).html('<img src="immagini/a-piu.png" border="0">');
                }
	*/
 }
</SCRIPT>
</body>
</html>
