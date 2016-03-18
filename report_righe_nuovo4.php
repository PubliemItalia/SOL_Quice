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
$file_presente = basename($azione_form);
$_SESSION[file_presente] = $file_presente;
$array_rda_sel = array();
//$sqla = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '1'";
$sqla = "SELECT * FROM qui_rda WHERE stato = '3'";
$risulta = mysql_query($sqla) or die("Impossibile eseguire l'interrogazione01" . mysql_error());
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

if ($_GET['nr_rda'] != "") {
$nr_rdaDaModulo = $_GET['nr_rda'];
} 
if ($nr_rdaDaModulo != "") {
$m = "id_rda = '$nr_rdaDaModulo'";
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
		/*case "mag":
		  $g = "output_mode = 'mag' AND evaso_magazzino = '0'";
		break;
		case "mag_evaso":
		  $g = "output_mode = 'mag' AND evaso_magazzino = '1'";
		break;*/
		case "mag":
		  $g = "output_mode = 'mag'";
		break;
		case "lab":
		  $g = "output_mode = 'lab'";
		break;
		case "ord":
		  $g = "output_mode = 'ord'";
		break;
	}
$clausole++;
}
/*
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 
*/
if ($_GET['societa'] != "") {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
$h = "azienda_prodotto = '$societaDaModulo'";
$clausole++;
}
//echo "shopDaModulo: ".$shopDaModulo."<br>";

//costruzione query
//ogni buyer ha alcuni negozi da gestire e sono indicati nella tabella "qui_buyer_negozi"
//ATTENZIONE: lo switch qui sotto serve perchè se nei filtri viene specificato il negozio, la ricerca va fatta solo su quello, e la tabella deve essere esclusa
//variante per flusso dispositivi di rivendita e BMC
$array_cat_flusso = array();
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione02" . mysql_error());
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
		if ($rigat[flusso] != "") {
		  $add_cat_flusso = array_push($array_cat_flusso,$rigat[flusso]);
		}
	  }
	}
	  if (count($array_cat_flusso) > 0) {
		  $blocco_negozi_buyer .= " AND (";
			foreach ($array_cat_flusso as $sing_cat_flusso) {
			  if (key($array_cat_flusso) == 0) {
				$blocco_negozi_buyer .= "flusso = '".$sing_cat_flusso."'";
			  } else {
				$blocco_negozi_buyer .= " OR flusso = '".$sing_cat_flusso."'";
			  }
			}
		  $blocco_negozi_buyer .= ")";
			  } else {
		  $blocco_negozi_buyer .= " AND flusso = '' ";
	  }
	//echo 'array_cat_flusso: ';
	//print_r($array_cat_flusso);
	//echo "<br>";
if ($clausole > 0) {
  if ($shopDaModulo != "") {
	  $testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND flag_chiusura = '0' AND ";
	  //$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND flag_chiusura = '0' AND ";
  } else {
	  $testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '4') AND flag_chiusura = '0' AND ";
	  //$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '4') AND flag_chiusura = '0' AND ";
  }
} else {
	switch ($statusDaModulo) {
		default:
		  $testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '3') AND output_mode = ''";
		  //$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND (stato_ordine BETWEEN '2' AND '3') AND output_mode = ''";
		break;
		case "":
	  $testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND flag_chiusura = '0' AND ";
	  //$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND flag_chiusura = '0' AND ";
		break;
	}
}
	/*if ($m != "") {
	  $a == "";
	  $b == "";
	  $c == "";
	  $e == "";
	  $f == "";
	  $g == "";
	  $h == "";
	}*/

if ($clausole > 0) {
  if ($clausole == 1) {
	if ($a != "") {
	  $testoQuery .= $a;
	  //$sumquery .= $a;
	}
	if ($b != "") {
	  $testoQuery .= $b;
	  //$sumquery .= $b;
	}
	if ($c != "") {
	  $testoQuery .= $c;
	  //$sumquery .= $c;
	}
	if ($d != "") {
	  $testoQuery .= $d;
	  //$sumquery .= $d;
	}
	if ($e != "") {
	  $testoQuery .= $e;
	  //$sumquery .= $e;
	}
	if ($f != "") {
	  $testoQuery .= $f;
	  //$sumquery .= $f;
	}
	if ($g != "") {
	  $testoQuery .= $g;
	  //$sumquery .= $g;
	}
	if ($h != "") {
	  $testoQuery .= $h;
	  //$sumquery .= $h;
	}
	if ($m != "") {
	  $testoQuery .= $m;
	  //$sumquery .= $m;
	}
  } else {
	if ($a != "") {
	  $testoQuery .= $a." AND ";
	  //$sumquery .= $a." AND ";
	}
	if ($b != "") {
	  $testoQuery .= $b." AND ";
	  //$sumquery .= $b." AND ";
	}
	if ($c != "") {
	  $testoQuery .= $c." AND ";
	  //$sumquery .= $c." AND ";
	}
	if ($d != "") {
	  $testoQuery .= $d." AND ";
	  //$sumquery .= $d." AND ";
	}
	if ($e != "") {
	  $testoQuery .= $e." AND ";
	  //$sumquery .= $e." AND ";
	}
	if ($f != "") {
	  $testoQuery .= $f." AND ";
	  //$sumquery .= $f." AND ";
	}
	if ($g != "") {
	  $testoQuery .= $g." AND ";
	  //$sumquery .= $g." AND ";
	}
	if ($h != "") {
	  $testoQuery .= $h." AND ";
	  //$sumquery .= $h;
	}
	if ($m != "") {
	  $testoQuery .= $m;
	  //$sumquery .= $l;
	}
  }
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
/*
$lungsum = strlen($sumquery);
$finale_sum = substr($sumquery,($lungsum-5),5);
if ($finale_sum == " AND ") {
$sumquery = substr($sumquery,0,($lungsum-5));
}
*/
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
$querym = $testoQuery;

//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento;
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;

//echo '<span style="color:#000">Clausole: '.$clausole.'</span><br>';
//echo '<span style="color:#000">M: '.$m.'</span><br>';
//echo '<span style="color:#000">testoQuery: '.$testoQuery.'</span><br>';
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
$_SESSION[percorso_ritorno] ="report_righe_nuovo.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&button=Filtra";

$array_rda_attive = array();
$t = 0;
$sqlx = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '2' AND flag_buyer = '1'";
$resultx = mysql_query($sqlx);
while ($rowx = mysql_fetch_array($resultx)) {
	if (!in_array($rowx[id_rda],$array_rda_attive)) {
		$add_rda_attiva = array_push($array_rda_attive,$rowx[id_rda]);
		if ($t == 0) {
		  $stringa_rda .= $rowx[id_rda];
		} else {
		  $stringa_rda .= ",".$rowx[id_rda];
		}
		$t = $t+1;
	}
	
}

?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/report_balconi.css" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align:center;
	
	<?php
	/*switch ($statusDaModulo) {
		default:
		  echo "background-color:#fff;";
		break;
		case "no_process":
		  echo "background-color:#eaeaea;";
		break;
		case "mag":
		  echo "background-color:#fffdeb;";
		break;
		case "ord":
		  echo "background-color:#d6ffe1;";
		break;
	}*/
	?>
}
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
    height: auto;
	margin: auto;
	margin-top: 10px;
	text-align:left;
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
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script src="http://modernizr.com/downloads/modernizr-latest.js"></script>
<script type="text/javascript" src="js/viewportSize.js"></script>
<script type="text/javascript" src="tendine.js"></script>
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
<script type="text/javascript">
$(document).ready(function() {
 
    //per ciascun input e textarea esegui il codice sotto
    $('input,textarea').each(function () {
        // se placeholder è vuoto o non esiste (caso ie)
        if ($(this).attr('placeholder') != "" && this.value == "") {
            //Setta il value dell'input recuperando il testo dal placeholder
            $(this).val($(this).attr('placeholder'))
                   //imposta il colore grigio tipico del placeholder
                   .css('color', 'grey')
                   //Inizio azioni da eseguire al click
                   .on({
                       //un utente ha cliccato dentro l'input
                       focus: function () {
                         //Recupero il value dell'elemento cliccato, se corrisponde al placeholder
                         if (this.value == $(this).attr('placeholder')) {
                           // Faccio sparire il finto placeholder e setto di nuovo colore nero all'input
                           $(this).val("").css('color', '#000');
                         }
                       },
                       //Se l'utente clicca fuori dall'input dopo averci cliccato
                       blur: function () {
                         //Routine per ripristinare il fake placeholder
                         if (this.value == "") {
                           $(this).val($(this).attr('placeholder'))
                                  .css('color', 'grey');
                         }
                       }
                   });
            }//If placeholder non presente (ie)
    });//EACH
 
 }); //DOM
 </script>
</head>
<body>
<div id="outerWrap">
  <div id="layer2">
    <div style="margin:20%; width:60%; height:60%; color: #999; text-align:center; font-size:24px;">
      Sto caricando i dati/<br>Loading data<br><br><img src="images/preloader_image.gif">
    </div>
  </div>
  <div id="layer1">

<?php
include "menu_quice3.php";
?>
	<div id="main_container">
<!--div ricerca report righe nuovo per balconi-->
    <?php include "modulo_filtri.php";
/*switch($statusDaModulo) {
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
*/
?>
    <div id="contenitore_array_rda"><input name="js_array_rda" id="js_array_rda" type="hidden" value="<?php echo $stringa_rda; ?>"></div>
<!--<div id="tendina_stato">
<?php
/*
switch ($statusDaModulo) {
	case "sap":
	$new_class = ' stato_rda-cyano';
	break;
	case "mag":
	$new_class = ' stato_rda-arancio';
	break;
	case "lab":
	$new_class = ' stato_rda-grey';
	break;
	case "ord":
	$new_class = ' stato_rda-green';
	break;
	default:
	$new_class = '';
	break;
}
		  echo '<div class="tendina_stati_rda" style="width: 100%; float: right; height: 39px;">';
		  echo '<select name="status" class="ecoform '.$new_class.'" id="status"  style="height:27px; width: 90%;" onchange="ricarica_con_stato(this.value)">';
		  switch($statusDaModulo) {
			  case "":
				echo '<option class="stato_rda-bianco" selected value="">Tutte</option>';
				echo '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				echo '<option class="stato_rda-cyano" value="sap">SAP</option>';
				echo '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				//echo '<option value="mag_evaso">MAG evaso</option>';
				echo '<option class="stato_rda-grey" value" value="lab">LABELS</option>';
				echo '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "no_process":
				echo '<option class="stato_rda-bianco" value="">Tutte</option>';
				echo '<option class="stato_rda-bianco" selected value="no_process">In attesa di gestione</option>';
				echo '<option class="stato_rda-cyano" value="sap">SAP</option>';
				echo '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				//echo '<option value="mag_evaso">MAG evaso</option>';
				echo '<option class="stato_rda-grey" value="lab">LABELS</option>';
				echo '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "sap":
				echo '<option class="stato_rda-bianco" value="">Tutte</option>';
				echo '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				echo '<option class="stato_rda-cyano" selected value="sap">SAP</option>';
				echo '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				//echo '<option value="mag_evaso">MAG evaso</option>';
				echo '<option class="stato_rda-grey" value="lab">LABELS</option>';
				echo '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "mag":
				echo '<option class="stato_rda-bianco" value="">Tutte</option>';
				echo '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				echo '<option class="stato_rda-cyano" value="sap">SAP</option>';
				echo '<option class="stato_rda-arancio" selected value="mag">MAGAZZINO</option>';
				//echo '<option value="mag_evaso">MAG evaso</option>';
				echo '<option class="stato_rda-grey" value="lab">LABELS</option>';
				echo '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "lab":
				echo '<option class="stato_rda-bianco" value="">Tutte</option>';
				echo '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				echo '<option class="stato_rda-cyano" value="sap">SAP</option>';
				echo '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				//echo '<option value="mag_evaso">MAG evaso</option>';
				echo '<option class="stato_rda-grey" selected value="lab">LABELS</option>';
				echo '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "ord":
				echo '<option class="stato_rda-bianco" value="">Tutte</option>';
				echo '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				echo '<option class="stato_rda-cyano" value="sap">SAP</option>';
				echo '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				//echo '<option value="mag_evaso">MAG evaso</option>';
				echo '<option class="stato_rda-grey" value="lab">LABELS</option>';
				echo '<option selected class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
		  }
		  echo '</select>';
		  echo '</div>
		  <div class="stato_rda" style="width: 100%; float: right; height: 20px;">
		  <strong>Stato RdA</strong>
		  </div>';
*/
?>
</div>-->


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
	if (!in_array($row[id_rda],$array_rda)) {
	$add_rda = array_push($array_rda,$row[id_rda]);
	}
}
$rdaTrovate = count($array_rda);
if ($rdaTrovate > 0) {
  echo '<span class="sommari_euro">';
  echo "RdA trovate: ".$rdaTrovate."</span><br>";
} else {
  $sqlk = "SELECT * FROM qui_rda WHERE id = '$nr_rdaDaModulo'";
  $risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione09" . mysql_error());
  $ricercate = mysql_num_rows($risultk);
  if ($ricercate > 0) {
	while ($rowk = mysql_fetch_array($risultk)) {
	  $statoRdaCercata = $rowk[stato];
	}
	echo '<span style="color:#ccc; font-size: 16px; font-weight: bold;">';
	//	echo 'La RdA che stai cercando &egrave; gi&agrave; stata archiviata. Puoi visualizzarla <a href="stampa_rda.php?id_rda='.$nr_rdaDaModulo.'&mode=print" target="_blank"></span><span style="color:#225e99; font-size: 16px; font-weight: bold;">qui</span></a><br>';
	switch ($statoRdaCercata) {
		case "1":
		  echo 'La RdA che stai cercando non &egrave; ancora stata approvata.</span><br>';
		break;
		case "2":
		  echo 'La RdA che stai cercando &egrave; in attesa di essere processata.</span><br>';
		break;
		case "3":
		  echo 'La RdA che stai cercando &egrave; in processo.</span><br>';
		break;
		case "4":
		  echo 'La RdA che stai cercando &egrave; gi&agrave; stata archiviata.</span><br>';
		break;
	}
$array_rda = array($nr_rdaDaModulo);
  } else {
	echo '<span style="color:#ccc; font-size: 16px; font-weight: bold;">';
	echo "La RdA che stai cercando non esiste</span><br>";
}
}

echo '<div class="cont_rda" id=contenitore_generale>';

foreach ($array_rda as $sing_rda) {
 if ($sing_rda != $num_rda_titolo) {
  $codice_php_riepilogo_sing_rda = $blocco_riepilogo_sing_rda;
  $codice_php_testatina_righe = $blocco_testatina_righe;
  $sqly = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione09" . mysql_error());
  while ($rigay = mysql_fetch_array($risulty)) {
	$codice_php_note_singola_rda = $blocco_note_singola_rda;
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
	$data_output = $rigay[data_output];
	$data_approvazione = $rigay[data_approvazione];
	$data_chiusura = $rigay[data_chiusura];
	$data_ultima_modifica = $rigay[data_ultima_modifica];
	$flusso_rda = $rigay[flusso];
	$stato_orig_rda = stripslashes($rigay[stato]);
	$sost_id_rda = $sing_rda;
	$ut_rda = "<img src=immagini/spacer.gif width=15 height=2>".date("d.m.Y",$data_inserimento)."<img src=immagini/spacer.gif width=25 height=2>";
	if ($rigay[id_utente] == $rigay[id_resp]) {
	  $ut_rda .= "Ut./Resp. ".stripslashes($rigay[nome_utente]);
	} else {
	  $ut_rda .= "Ut. ".stripslashes($rigay[nome_utente])." - Resp. ".stripslashes($rigay[nome_resp]);
	}
	$ut_rda .= "<img src=immagini/spacer.gif width=25 height=2>Unit&agrave; ".$rigay[nome_unita]."</strong>";
	$ut_rda .= "<img src=immagini/spacer.gif width=25 height=2>".$rigay[nazione]."</strong>";
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
  echo '<div class="cont_rda" id="glob_'.$sing_rda.'">';
  //inizio div riassunto rda
  $sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
  $resultm = mysql_query($sqlm);
  $num_righeXDim = mysql_num_rows($resultm);
  $altezza_finestra = ($num_righeXDim*37)+125+180;
  if ($altezza_finestra > 800) {
	  $altezza_finestra = 800;
  }

  if ($tipo_negozio != "assets") {
	//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
	$sost_ut_rda = $ut_rda.$tracciati_sap;
  } else {
	$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
	$output_wbs .= " (".$wbs_visualizzato.")";
	//echo "RDA ".$sing_rda.$indicazione_negozio_rda.$output_wbs.$ut_rda;
	$sost_ut_rda = $output_wbs.$ut_rda;
  }
  $wbs_visualizzato = "";
  $output_wbs = "";
  $ut_rda = "";
  $tracciati_sap = "";

  //determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
  //echo '<span style="color:#000;">sqlk: '.$sqlk.'<br>';
  $risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione11" . mysql_error());
  $Num_righe_rda = mysql_num_rows($risultk);
  while ($rigak = mysql_fetch_array($risultk)) {
	if ($rigak[stato_ordine] != 4) {
	  if (($rigak[flag_buyer] == 4) && ($rigak[output_mode] == "sap")) {
		$Num_righe_rdasap_selezionate = $Num_righe_rdasap_selezionate + 1;
	  }
	  if ($rigak[flag_buyer] == 1) {
		$Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
	  }
	  if ($rigak[output_mode] == "sap") {
		$Num_righe_sap_rda = $Num_righe_sap_rda + 1;
		if ($rigak[ord_fornitore] == "") {
		  $righeSapDaProcessare = $righeSapDaProcessare + 1;
		} else {
		  $righeSapProcessate = $righeSapProcessate + 1;
		}
	  }
	  if (($rigak[output_mode] == "ord") && ($rigak[flag_buyer] == "6")) {
	  $t = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda = '$rigak[id]'";
	  $esit_t = mysql_query($t) or die("Impossibile eseguire l'interrogazione07" . mysql_error());
	  while ($rowt = mysql_fetch_array($esit_t)) {
		$ordine_for = $rowt[id_ordine_for];
	  }
		$Num_righe_ord_rda = $Num_righe_ord_rda + 1;
	  }
	  if ($rigak[output_mode] != "") {
		if ($rigak[flag_buyer] >= 2) {
		  $Num_righe_processate = $Num_righe_processate + 1;
		}
		if (($rigak[output_mode] != "mag") && ($rigak[output_mode] != "lab")) {
		  $Num_righe_evadere = $Num_righe_evadere + 1;
		} else {
		  if ($rigak[evaso_magazzino] == 1) {
			$Num_righe_evadere = $Num_righe_evadere + 1;
		  }
		}
	  }
	} else {
	  if ($rigak[flag_chiusura] == 0) {
		$Num_righe_evadere_chiusura = $Num_righe_evadere_chiusura + 1;
	  }
	}
  }
/* echo '<span style="color: #000;">Num_righe_evadere_chiusura: '.$Num_righe_evadere_chiusura.'<br>';
  echo 'righeSapDaProcessare: '.$righeSapDaProcessare.'<br>
  righeSapProcessate: '.$righeSapProcessate.'<br></span>'; */
if (($stato_orig_rda > 1) && ($stato_orig_rda < 4)){
switch ($statusDaModulo) {
  case "sap":
	if ($righeSapDaProcessare > 0) {
	  if ($Num_righe_rdasap_selezionate < $righeSapDaProcessare) {
		$tooltip_select = "Seleziona tutto";
		$bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,4,'.$sing_rda.',4);"><img src="immagini/select-all.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	  } else {
	  $tooltip_select = "Deseleziona tutto";
	  $bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,2,'.$sing_rda.',4);"><img src="immagini/select-none.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	  }
	} else {
	  $bottone_immagine = '';
	}
  break;
  case "":
  case "no_process":
	if ($Num_righe_rda_selezionate == ($Num_righe_rda-$Num_righe_processate)) {
	  $tooltip_select = "Deseleziona tutto";
	  $bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,0,'.$sing_rda.',2);"><img src="immagini/select-none.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	} else {
	  $tooltip_select = "Seleziona tutto";
	  $bottone_immagine = '<a href="javascript:void(0);" onclick="axc(0,1,'.$sing_rda.',2);"><img src="immagini/select-all.png" width="14" height="14" border="0" title="'.$tooltip_select.'"></a>';
	}
  break;
}
} else {
$bottone_immagine = '';
}
/*  
switch ($statusDaModulo) {
  case "":
  case "no_process":
	  $sost_chiudi = "";
  break;
  case "mag":
  case "lab":
  case "ord":
  case "sap":
*/	
	if ($Num_righe_evadere_chiusura == $Num_righe_rda) {
	  $sost_chiudi = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_modal_chiusura_rda.php?id=".$sing_rda."&id_utente=".$_SESSION[user_id]."',boxid:'frameless',width:500,height:200,fixed:false,maskid:'bluemask',maskopacity:'40',closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><div>ARCHIVIA</div></a>";
	} else {
	  $sost_chiudi = "";
	}

/*
  break;
}
*/
}
switch ($statusDaModulo) {
  default:
/*	$div_bloccoRdA = '<div id="blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda" style="display:block;">';
	  $sost_puls_piumeno = 'immagini/a-meno.png';
  break;
  case "sap":
*/
	if ($righeSapDaProcessare > 0) {
	$div_bloccoRdA = '<div id="blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda" style="display:block;">';
	  $sost_puls_piumeno = 'immagini/a-meno.png';
	} else {
	$div_bloccoRdA = '<div id="blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda" style="display:none;">';
	  $sost_puls_piumeno = 'immagini/a-piu.png';
	}
  break;
  case "":
  case "no_process":
	if ($Num_righe_evadere == $Num_righe_rda) {
	$div_bloccoRdA = '<div id="blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda" style="display:none;">';
	  $sost_puls_piumeno = 'immagini/a-piu.png';
	} else {
	$div_bloccoRdA = '<div id="blocco_rda_'.$sing_rda.'" class="cont_rda blocco_rda" style="display:block;">';
	  $sost_puls_piumeno = 'immagini/a-meno.png';
	}
  break;
}
$pulsante_con_id = 'pulsante_'.$sost_id_rda;
$codice_php_riepilogo_sing_rda = str_replace("*pulsante_con_id*",$pulsante_con_id,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_puls_piumeno*",$sost_puls_piumeno,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_chiudi*",$sost_chiudi,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_ut_rda*",$sost_ut_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_riepilogo_sing_rda);
$codice_php_riepilogo_sing_rda = str_replace("*sost_imm_status*",$imm_status,$codice_php_riepilogo_sing_rda);
echo $codice_php_riepilogo_sing_rda;
//fine div riassunto rda
/*echo '<span style="color:#000; font-size:9px;">selezionate: '.$Num_righe_rda_selezionate.'<br>.
Num_righe_processate: '.$Num_righe_processate.'<br>
Num_righe_rda: '.$Num_righe_rda.'</span><br>';*/
//inizio div testatina nuova
//fine div testatina nuova


//inizio div rda
echo $div_bloccoRdA;
$div_bloccoRdA = '';
$immagine_print = '<img src="immagini/btn_multi_stampa.jpg" border="0"></a>';
$codice_php_testatina_righe = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
$codice_php_testatina_righe = str_replace("*YY*",$immagine_print,$codice_php_testatina_righe);
  echo $codice_php_testatina_righe;
		$righeSapDaProcessare = "0";
//echo "<div id=blocco_rda_".$sing_rda." class=cont_rda style=\"display:none;\">";
$queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$sing_rda'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_rda_completa = $somma;
//*********************************************************
//INIZIO WHILE RIGHE DELLA RDA ANCORA IN PROCESSO 
	$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine != '4'";
//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//echo "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
$codice_php_singola_riga = $blocco_singola_riga;
$codice_php_note_singola_rda = $blocco_note_singola_rda;
//inizio contenitore riga, preso dal database, imposto le variabile da sostituire alla struttura di base
$sost_id_riga = $rigan[id];
/*
//div num rda riga
echo "<div class=cod1_riga style=\"width:50px;\">";
echo $rigan[id_rda];
//fine div num rda riga
echo "</div>";
//div data riga
echo "<div class=cod1_riga>";
echo date("d.m.Y",$rigan[data_inserimento]);
//fine div data riga
echo "</div>";
*/
// codice riga
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art = '<a href="riepilogo_bombola.php?cod='.$rigan[codice_art].'" target="_blank"><span style="color:#000;">';
}
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art .= "</span></a>";
}

// descrizione riga
$sost_descrizione = $rigan[descrizione];
if ($rigan[urgente] == 1) {
	$sost_descrizione.= '<span style="color:red; font-weight: bold;"> - Urgente</span>';
}
// nome unità riga
$sost_unita = $rigan[nome_unita];
// quant riga
$sost_quant = intval($rigan[quant]);
// pulsante per evasione parziale riga
if (($rigan[output_mode] == "") AND ($rigan[flag_buyer] == "1")) {
  if (($rigan[negozio] == "labels") AND ($label_ric_mag != "mag")) {
  } else {
	if ($sost_quant > 1) {
	  $bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rigan[id]."&id_rda=".$rigan[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:980,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,0,".$sing_rda.",0)}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	$bottone_edit = "";
	}
  }
} else {
	$bottone_edit = "";
}
// pulsante per visualizzare scheda
$sqlm = "SELECT * FROM qui_prodotti_".$rigan[negozio]." WHERE codice_art='".$rigan[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	$giacenza = $rigam[giacenza];
	if ($rigam[categoria1_it] == "Bombole") {
  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese".$rigam[paese]."=&nazione_ric=&negozio=".$rigam[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
// totale riga
$sost_totale_riga = number_format($rigan[totale],2,",",".");
$totale_rda = $totale_rda + $rigan[totale];

$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "":
$colore_scritta = $colore_attesa_gestione;
$dettaglio_stato = $lista_attesa_gestione;
if ($rigan[data_approvazione] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_approvazione]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_inserimento]);
}
break;
case "mag":
$colore_scritta = $colore_inoltrato_mag;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_mag.' '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_mag;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
case "sap":
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
break;
case "ord":
$colore_scritta = $colore_inoltrato_ord;
$sqlz = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda='".$rigan[id]."'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$dettaglio_stato = '<a href="ordine_fornitore.php?id_ord='.$rigaz[id_ordine_for].'&id_rda='.$rigan[id_rda].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$inoltrato_ord.' '.$rigaz[id_ordine_for].'</span></a>';
}
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
break;
case "lab":
$colore_scritta = $colore_inoltrato_lab;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_lab.' '.$rigan[pack_list].'</span></a>';
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
} else {
$dettaglio_stato = $inoltrato_lab;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
case "bmc":
$colore_scritta = $colore_inoltrato_bmc;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_bmc.' '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_bmc;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
case "htc":
$colore_scritta = $colore_inoltrato_htc;
if ($rigan[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigan[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_htc.' '.$rigan[pack_list].'</span></a>';
if ($rigan[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigan[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigan[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_htc;
$aggiornamento_stato = date("d/m/Y",$rigan[data_output]);
}
break;
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
//div checkbox (vuoto)
if ($rigan[stato_ordine] > 1) {
switch ($rigan[output_mode]) {
	default:
		$casella_check = "";
	break;
	case "":
	  switch ($rigan[flag_buyer]) {
	  case "0":
		$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.",1);\">";
	  break;
	  case "1":
		$casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$sing_rda.",1);\">";
		$contatore_righe_flag = $contatore_righe_flag + 1;
	  break;
	  }
	break;
	case "sap":
	//if ($statusDaModulo == "sap") {
		  //IL MODE 3 serve a far capire al file di jquery che sono in modalità "gestione SAP"
		  if ($rigan[ord_fornitore] == "") {
			switch ($rigan[flag_buyer]) {
			case "2":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'4',".$sing_rda.",3);\">";
			break;
			case "4":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.",3);\">";
			  $contatore_righe_flag_sap = $contatore_righe_flag_sap + 1;
			break;
			}
		  } else {
			$casella_check = '';
		  }
	  //} else {
		//$casella_check = "";
	 // }
	break;
	case "ord":
		  //IL MODE 5 serve a far capire al file di jquery che sono in modalità "visualizzazione ordine fornitore"
			switch ($rigan[flag_buyer]) {
			case "2":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'6',".$sing_rda.",5);\">";
			break;
			case "6":
			  $casella_check = "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'2',".$sing_rda.",5);\">";
			  $contatore_righe_flag_ord = $contatore_righe_flag_ord + 1;
			break;
			}
	break;
}
} else {
  $casella_check = "";
}
//IL MODE 10 serve a far capire al file di jquery che sono in modalità "stampa selettiva delle righe"
$casella_print = "<input name=id_riga_print[] type=checkbox id=id_riga_print[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$sing_rda.",10);\">";
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
$giacenza = "";
$rda_exist = "";
//fine contenitore riga tabella

}
//FINE WHILE RIGHE DELLA RDA ANCORA IN PROCESSO 
//*********************************************************
//*********************************************************
//INIZIO WHILE RIGHE GIA' COMPLETATE DELLA RDA 
	$sqlw = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' AND stato_ordine = '4'";
$risultw = mysql_query($sqlw) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
while ($rigaw = mysql_fetch_array($risultw)) {
$codice_php_singola_riga_evasa = $blocco_singola_riga_evasa;
//inizio contenitore riga, preso dal database, imposto le variabile da sostituire alla struttura di base
$sost_id_riga = $rigaw[id];
//if ($rigaw[categoria] == "Bombole") {
	//$sost_codice_art = '<a href="riepilogo_bombola.php?cod='.$rigaw[codice_art].'" target="_blank">';
//}
if (substr($rigaw[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigaw[codice_art];
} else {
  $sost_codice_art .= substr($rigaw[codice_art],1);
}
//if ($rigaw[categoria] == "Bombole") {
	//$sost_codice_art .= "</a>";
//}

// descrizione riga
$sost_descrizione = $rigaw[descrizione];
// nome unità riga
$sost_unita = $rigaw[nome_unita];
// quant riga
$sost_quant = intval($rigaw[quant]);
// pulsante per evasione parziale riga
	  $bottone_edit = "";
// pulsante per visualizzare scheda
$sqlm = "SELECT * FROM qui_prodotti_".$rigaw[negozio]." WHERE codice_art='".$rigaw[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	$giacenza = $rigam[giacenza];
	if ($rigam[categoria1_it] == "Bombole") {
  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigaw[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rigaw[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
// totale riga
$sost_totale_riga = number_format($rigaw[totale],2,",",".");
$totale_rda = $totale_rda + $rigaw[totale];

$colore_aggiornamento = "style_aggiornamento";
//div output mode riga (vuoto)
switch ($rigaw[output_mode]) {
case "":
$dettaglio_stato = "In attesa di gestione";
if ($rigaw[data_approvazione] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_approvazione]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_inserimento]);
}
break;
case "mag":
$colore_scritta = "style_mag";
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigaw[pack_list].'</span></a>';
if ($rigaw[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
} else {
$dettaglio_stato = "Inoltrato al Magazzino ";
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
case "sap":
$colore_scritta = "style_sap";
if ($rigaw[ord_fornitore] != "") {
  $dettaglio_stato = "Ordine Sap ".$rigaw[ord_fornitore]."<br>".$rigaw[fornitore_tx];
  if ($rigaw[data_chiusura] > 0) {
  $aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
  } else {
  $aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
  }
  $campo_ordsap = '';
} else {
  $campo_ordsap = '';
  $dettaglio_stato = "Inoltrato a Sap";
  $aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
break;
case "ord":
$colore_scritta = "style_ord";
$sqlz = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda='".$rigaw[id]."'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$dettaglio_stato = '<a href="ordine_fornitore.php?id_ord='.$rigaz[id_ordine_for].'&id_rda='.$rigaw[id_rda].'" target="_blank"><span class="'.$colore_scritta.'">Ordine fornitore '.$rigaz[id_ordine_for].'</span></a>';
}
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
break;
case "lab":
$colore_scritta = "style_lab";
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span class="'.$colore_scritta.'">Spedito con Packing List '.$rigaw[pack_list].'</span></a>';
if ($rigaw[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
} else {
$dettaglio_stato = "Inoltrato al Magazzino Labels";
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
case "bmc":
$colore_scritta = $colore_inoltrato_bmc;
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_bmc.' '.$rigaw[pack_list].'</span></a>';
if ($rigaw[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_bmc;
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
case "htc":
$colore_scritta = $colore_inoltrato_htc;
if ($rigaw[pack_list] > 0) {
$dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rigaw[pack_list].'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_htc.' '.$rigaw[pack_list].'</span></a>';
if ($rigaw[data_chiusura] > 0) {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_chiusura]);
} else {
$aggiornamento_stato = date("d/m/Y",$rigaw[data_ultima_modifica]);
}
} else {
$dettaglio_stato = $inoltrato_htc;
$aggiornamento_stato = date("d/m/Y",$rigaw[data_output]);
}
break;
}
$aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
//div checkbox (vuoto)
  $casella_check = "";
$sost_logo = '<a href="report_prodotti.php?shop='.$rigaw[negozio].'&categoria_ricerca=&paese=&codice_art='.$rigaw[codice_art].'&categoria4=&ricerca=1" target="_blank">';
//echo 'neg: '.$rigan[negozio].'<br>';
switch ($rigaw[azienda_prodotto]) {
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
//IL MODE 10 serve a far capire al file di jquery che sono in modalità "stampa selettiva delle righe"
$casella_print_evasa = "<input name=id_riga_print[] type=checkbox id=id_riga_print[] value=".$rigaw[id]." onClick=\"axc(".$rigaw[id].",'1',".$sing_rda.",10);\">";
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
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
$giacenza = "";
$rda_exist = "";
//fine contenitore riga tabella

}
//FINE WHILE RIGHE GIA' COMPLETATE DELLA RDA 
//*********************************************************

//div riga bianca con totali
echo '<div id="totale_rda" class="columns_righe2" style="font-weight:bold; border-bottom:1px solid;">';
echo '<div class="dicitura_totale_rda">';
echo 'Totale';
echo "</div>";
//div totale riga
echo '<div class="cifra_totale_rda">';
echo '<strong>&euro; '.number_format($totale_rda,2,",",".").'</strong>';
echo "</div>";
echo "</div>";


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
  if ($stato_orig_rda > 1) {
$tracking .= "<br>Approvata il ".$data_approvazione;
  }
  switch ($stato_orig_rda) {
	  case 3:
		$tracking .= "<br>In processo dal ".$data_approvazione;
		//$tracking .= "<br>In processo dal ".date("d.m.Y",$data_output);
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
$codice_php_indir_singola_rda = $blocco_indir_sing_rda;
$codice_php_indir_singola_rda = str_replace("*testo_indirizzo*",$indirizzo_spedizione,$codice_php_indir_singola_rda);
echo $codice_php_indir_singola_rda;




//fine blocco sing rda
echo "</div>";
//fine contenitore esterno sing rda
echo "</div>";
//fine foreach
}



/*
//riga del totale generale
echo '<div id="totale_storico" class="columns_righe2">';
echo '<div class="dicitura_totale_storico">';
echo 'Totale &euro';
echo "</div>";
//div totale riga
echo '<div class="cifra_totale_storico">';
echo number_format($totale_storico_rda,2,",",".");
//fine div totale riga
echo "</div>";
*/
//fine contenitore totale
echo "</div>";
//fine contenitore generale rda
echo "</div>";
?>
</div>

<!--fine outer wrap-->
</div>



<script type="text/javascript">
$(document).ready(function() {
 
    //per ciascun input e textarea esegui il codice sotto
    $('input,textarea').each(function () {
        // se placeholder è vuoto o non esiste (caso ie)
        if ($(this).attr('placeholder') != "" && this.value == "") {
            //Setta il value dell'input recuperando il testo dal placeholder
            $(this).val($(this).attr('placeholder'))
                   //imposta il colore grigio tipico del placeholder
                   .css('color', 'grey')
                   //Inizio azioni da eseguire al click
                   .on({
                       //un utente ha cliccato dentro l'input
                       focus: function () {
                         //Recupero il value dell'elemento cliccato, se corrisponde al placeholder
                         if (this.value == $(this).attr('placeholder')) {
                           // Faccio sparire il finto placeholder e setto di nuovo colore nero all'input
                           $(this).val("").css('color', '#000');
                         }
                       },
                       //Se l'utente clicca fuori dall'input dopo averci cliccato
                       blur: function () {
                         //Routine per ripristinare il fake placeholder
                         if (this.value == "") {
                           $(this).val($(this).attr('placeholder'))
                                  .css('color', 'grey');
                         }
                       }
                   });
            }//If placeholder non presente (ie)
    });//EACH
 
 }); //DOM
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

function ricarica_con_stato(statusval){
	/*var statusval = document.getElementById('status').value;*/
	if (statusval == "") {
	  location.href ="http://10.171.1.176/<?php echo $dir_lavoro; ?>/report_righe_nuovo.php";
	} else {
	  location.href ="http://10.171.1.176/<?php echo $dir_lavoro; ?>/report_righe_nuovo.php?status="+statusval;
	}
}
function axc(id_riga,valoreCheck,id_rda,mode){
  $.ajax({
	type: "GET",   
	url: "imposta_selezione_blocco_sing_rda.php",   
	data: "mode="+mode+"&status=<?php echo $statusDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
	success: function(output) {
	$('#glob_'+id_rda).html(output).show();
	}
  })
/*
alert(id_rda+","+mode);
	var str_rda = document.getElementById('js_array_rda').value;
				$.ajax({
						type: "GET",   
						url: "modifica_array_rda.php",   
						data: "array_rda="+str_rda+"&id_rda="+id_rda+"&check="+valoreCheck,
						success: function(output) {
						$('#contenitore_array_rda').html(output).show();
						}
						})
			  
*/
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
function refresh_rda(id_rda){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "refresh_blocco_sing_rda.php",   
						data: "unita=<?php echo $unitaDaModulo; ?>"+"&categoria_ricerca=<?php echo $categoria_ricerca_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&codice_art=<?php echo $codice_artDaModulo; ?>"+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&ricerca=<?php echo $flag_ricerca; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
function refresh_multiplo2() {
window.location.href=window.location.href;
/*
var index;
var str_rda = document.getElementById('js_array_rda').value;
var js_array_rda = str_rda.split(",");
//for	(index = 0; index < js_array_rda.length; index++) {
	//if (js_array_rda[index] != "") {
	//var id_rda = js_array_rda[index];
	  alert("#blocco_rda_"+objValue);
		$.each(
		  js_array_rda,
		  function(intIndex, objValue){
			$.ajax({
			  type: "GET",   
			  url: "refresh_glob_sing_rda.php",   
			  data: "id_rda="+objValue,
			  success: function(output) {
			  $('#glob_'+objValue).html(output).show();
			  }
			})
		  }
		)
	  */
	/*}*/
}
function iterarray() {
	var index;
	var str_rda = document.getElementById('js_array_rda').value;
/*alert(str_rda);*/
var js_array_rda = str_rda.split(",");
/*var fruits = ["Banana", "Orange", "Apple", "Mango"];
	;*/
	/*alert(js_array_rda.length);*/
for	(index = 0; index < js_array_rda.length; index++) {
	/*alert(js_array_rda[index]);*/
}
}

function refresh_multiplo(lista_rda) {
	/*alert(lista_rda);*/
	var array_rda = lista_rda.split(",");
	for (i in array_rda) {
      refresh_rda(array_rda[i]);
	}

}
function axc_parz(id_riga,valoreCheck,id_rda){
						/*alert(id_riga);*/
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda_parz.php",   
						data: "singola=1"+"&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_righe=<?php echo $categ_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&nr_rda=<?php echo $nrRdaDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&codice_art=<?php echo $codice_artDaModulo; ?>&categoria_ricerca=<?php echo $categoria_ricercaDaModulo; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "modifica_contestuale_pulsante_multi.php",   
						data: "id_rda="+id_rda,
						success: function(output) {
						$('#bott_multi_'+id_rda).html(output).show();
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
						$('#glob_'+id_rda).html("").show();
						/*alert(id_rda);
				$.ajax({
						type: "GET",   
						url: "imposta_chiusura_new.php",   
						data: "id_rda="+id_rda+"&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#glob_'+id_rda).html(output).show();
						}
						})*/

}

function ricerca_rda(id_rda){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "ricerca_singola_rda.php",   
						data: "id_rda="+id_rda+"&lang=<?php echo $lingua; ?>",
						success: function(output) {
						$('#contenitore_generale').html(output).show();
						}
						})

}
function sost_applica_filtri(val_rda){
						/*alert(id_rda);*/
				$.ajax({
						type: "GET",   
						url: "sostituzione_pulsante_applica.php",   
						data: "val_rda="+val_rda,
						success: function(output) {
						$('#pulsante_applica').html(output).show();
						}
						})

}
function azzera_nota(id_rda) {
var nota = document.getElementById('nota_'+id_rda).value;
	/*alert(id_rda);*/
if(nota == "Note") {
document.getElementById('nota_'+id_rda).value = '';
}
}
function ripristina_nota(id_rda) {
var nota = document.getElementById('nota_'+id_rda).value;
	/*alert(id_rda);*/
if(nota == "") {
document.getElementById('nota_'+id_rda).value = 'Note';
}
}
function controllo(id_rda){
var valore = document.getElementById('nota_'+id_rda).value;
/*alert("ok");*/
if(valore=="Note") {
   document.getElementById('nota_'+id_rda).value = "";
}
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
                    $('#pulsante_'+id_riga).html('<img src="immagini/a-meno.png" border="0">');
                } else {
                    $('#blocco_rda_'+id_riga).css('display', 'none');
                    $('#pulsante_'+id_riga).html('<img src="immagini/a-piu.png" border="0">');
                }
 }
function ripristino_riga(id_rda){
	/*alert(id_rda);*/
						
				$.ajax({
						type: "GET",   
						url: "ripristino_riga.php",  
						data: "id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#glob_'+id_rda).html(output).show();
						}
						})

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
	var status = document.forms['form_filtri2'].elements['status'];
	var statusval = status.options[status.selectedIndex].value;
	var nr_rda = document.getElementById('nr_rda').value;
	var codice_art = document.getElementById('codice_art').value;
	var data_inizio = document.getElementById('data_inizio').value;
	var data_fine = document.getElementById('data_fine').value;
	/*alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);*/
	if(((data_inizio != "") && (data_fine != "")) || ((data_inizio == "") && (data_fine == ""))){
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
			data: "societa="+socval+"&status="+statusval+"&shop="+shopval+"&unita="+unitaval+"&categoria="+categval+"&nr_rda="+nr_rda+"&codice_art="+codice_art+"&data_inizio="+data_inizio+"&data_fine="+data_fine+"&file_presente=<?php echo $file_presente; ?>",
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

</SCRIPT>
</body>
</html>
