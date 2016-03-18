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
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$_SESSION[pagina] = basename($_SERVER['PHP_SELF']);
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
//echo "lingua: ".$lingua."<br>";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
if ($_GET['renew'] == "1") {
$querya = "UPDATE qui_prodotti_".$negozio_prod." SET filepath = 'eliminare' WHERE id = '$id_prod'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento1: ".mysql_error();
}
}
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
$_SESSION[file_ritorno] = $file_presente;
//variabili di paginazione
if (isset($_GET['limit'])) {
$limit = $_GET['limit'];
} else {
$limit = $_POST['limit'];
}
$_SESSION[limit] = $limit;

if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}
$_SESSION[page] = $page;

$apertura_scheda = $_GET['apertura_scheda'];
if ($_GET['categoria1'] != "") {
$categoria1 = $_GET['categoria1'];
} 

if ($_GET['categoria2'] != "") {
$categoria2 = $_GET['categoria2'];
} 

if ($_GET['categoria3'] != "") {
$categoria3 = $_GET['categoria3'];
} 

if ($_GET['categoria4'] != "") {
$categoria4 = $_GET['categoria4'];
} 
if ($_GET['codice_art'] != "") {
$codice_ricerca = $_GET['codice_art'];
} 

if ($_GET['anchor'] != "") {
$anchor_processo = $_GET['anchor'];
} 

if ($_GET['paese'] != "") {
$_SESSION[paese] = $_GET['paese'];
$paese = $_GET['paese'];
} else {
$paese = $_SESSION[paese];
	
} 
$_SESSION[categoria1] = $_GET['categoria1'];
$_SESSION[categoria2] = $_GET['categoria2'];
$_SESSION[categoria3] = $_GET['categoria3'];
$_SESSION[categoria4] = $_GET['categoria4'];
/*echo "categoria1: ".$_SESSION[categoria1]."<br>";
echo "categoria2: ".$_SESSION[categoria2]."<br>";
echo "categoria3: ".$_SESSION[categoria3]."<br>";
echo "categoria4: ".$_SESSION[categoria4]."<br>";
*/
if ($_GET['ordinamento'] == "") {
$ordinamento = "codice_art";
$asc_desc = "ASC";
} else {
$ordinamento = $_GET['ordinamento'];
if ($_GET['asc_desc'] == "") {
$asc_desc = "ASC";
} else {
$asc_desc = $_GET['asc_desc'];
}
}
$_SESSION[ordinamento] = $ordinamento;
$_SESSION[asc_desc] = $asc_desc;

include "functions.php";
//include "testata.php";
if ($_GET['schedaVis'] == "") {
include "menu_quice3.php";
}
/*echo "num_categoria1: ".$num_categoria1."<br>";
echo "num_categoria2: ".$num_categoria2."<br>";
echo "num_categoria3: ".$num_categoria3."<br>";
echo "num_categoria4: ".$num_categoria4."<br>";

echo "<br>";
*/
if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[nazione_ric] = "";
$_SESSION[descrizione] = "";
$_SESSION[negozio] = "";
$_SESSION[categoria1] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";
//echo "sess negozio: ".$_SESSION[negozio]."<br>";
$_SESSION[percorso_modifica] = $_SESSION[file_ritorno]."?categoria1=".$categoria1."&paese=".$paese."&negozio=".$negozio."&lang=".$_SESSION[lang];
if ($categoria3 != "") {
	$_SESSION[percorso_modifica] .= "&categoria2=".$categoria2;
}
/*if ($categoria2 != "") {
	$_SESSION[percorso_modifica] .= "&categoria3=".$categoria3;
}
*/
if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
$avviso = $_GET['avviso'];

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query


$codiceDaModulo = $_GET['codice'];
$_SESSION[codice] = $_GET['codice'];
if (isset($_POST['codice'])) {
$codiceDaModulo = $_POST['codice'];
$_SESSION[codice] = $_POST['codice'];
}
if ($codiceDaModulo == "") {
$codiceDaModulo = $_SESSION[codice];
}
if ($codiceDaModulo != "") {
$a = "codice_art LIKE '%$codiceDaModulo%'";
$clausole++;
}

if (isset($_GET['nazione_ric'])) {
$nazioneDaModulo = $_GET['nazione_ric'];
$_SESSION[nazione_ric] = $_GET['nazione_ric'];
} 
if (isset($_POST['nazione_ric'])) {
$nazioneDaModulo = $_POST['nazione_ric'];
$_SESSION[nazione_ric] = $_POST['nazione_ric'];
}
//$_SESSION[cliente] = $clienteDaModulo;
if ($nazioneDaModulo == "") {
$nazioneDaModulo = $_SESSION[nazione_ric];
}
if ($nazioneDaModulo != "") {
$b = "nazione LIKE '%$nazioneDaModulo%'";
$clausole++;
}
switch($lingua) {
case "it":
$categoria1_lang = "categoria1_it";
$categoria2_lang = "categoria2_it";
$categoria3_lang = "categoria3_it";
$categoria4_lang = "categoria4_it";
break;
case "en":
$categoria1_lang = "categoria1_en";
$categoria2_lang = "categoria2_en";
$categoria3_lang = "categoria3_en";
$categoria4_lang = "categoria4_en";
break;
}

if ($categoria2 != "") {
if (($categoria1 == "Valvole")) {
$c = "descrizione4_it LIKE '%$categoria2%'";
	} else {
$c = "categoria2_it = '$categoria2'";
	}
	$_SESSION[categoria2] = $categoria2;
$clausole++;
}

if (isset($_GET['negozio'])) {
$negozio = $_GET['negozio'];
$_SESSION[negozio] = $_GET['negozio'];
} 
if (isset($_POST['negozio'])) {
$negozio = $_POST['negozio'];
$_SESSION[negozio] = $_POST['negozio'];
}
if ($negozio == "") {
$negozio = $_SESSION[negozio];
}
if ($negozio != "") {
$d = "negozio = '$negozio'";
$clausole++;
}

if ($categoria1 != "") {
$e = "categoria1_it = '$categoria1'";
$_SESSION[categoria1] = $categoria1;
$clausole++;
}
if ($categoria3 != "") {
$f = "categoria3_it = '$categoria3'";
$_SESSION[categoria3] = $categoria3;
$clausole++;
}
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$h = "(paese = '$paese' OR prodotto_multilingue LIKE '%$paese%')";
$clausole++;
}
if ($codice_ricerca != "") {
$l = "codice_art = '$codice_ricerca'";
$clausole++;
}


//costruzione query, query diversa a seconda del negozio prescelto e se è impostata solo la categoria 1 da menu o anche la 2 o anche la 3
if ($categoria3 != "") {
//switch ($negozio) {
//case "assets":
//vale solo per assets => bombole, pacchi_bombole
$testoQuery3 = "SELECT * FROM qui_prodotti_assets ";
/*break;
case "consumabili":
$testoQuery2 = "SELECT DISTINCT categoria3_it,foto_famiglia FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery2 = "SELECT DISTINCT categoria3_it,foto_famiglia FROM qui_prodotti_spare_parts ";
break;
case "vivistore":
$testoQuery2 = "SELECT DISTINCT categoria3_it,foto_famiglia FROM qui_prodotti_vivistore ";
break;
}
*/
} else {
if ($categoria2 != "") {
switch ($negozio) {
case "assets":
$testoQuery2 = "SELECT * FROM qui_prodotti_assets ";
break;
case "consumabili":
$testoQuery2 = "SELECT * FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery2 = "SELECT * FROM qui_prodotti_spare_parts ";
break;
case "labels":
$testoQuery2 = "SELECT * FROM qui_prodotti_labels ";
break;
case "vivistore":
$testoQuery2 = "SELECT * FROM qui_prodotti_vivistore ";
break;
}
} else {
switch ($negozio) {
case "assets":
$testoQuery = "SELECT * FROM qui_prodotti_assets ";
break;
case "consumabili":
$testoQuery = "SELECT * FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery = "SELECT * FROM qui_prodotti_spare_parts ";
break;
case "labels":
$testoQuery = "SELECT * FROM qui_prodotti_labels ";
break;
case "vivistore":
$testoQuery = "SELECT * FROM qui_prodotti_vivistore ";
break;
}
//fine categoria2
}
//fine categoria3
}
if ($clausole > 0) {
if ($categoria3 != "") {
//FROM qui_prodotti_assets categoria2_it = 'Industriale' AND categoria1_it = 'Bombole' AND categoria3_it = 'Acetilene_(C2H2)' AND
$testoQuery3 .= "WHERE obsoleto = '0' AND categoria2_it != '' AND ";
//categoria3
if ($clausole == 1) {
if ($a != "") {
$testoQuery3 .= $a;
}
if ($b != "") {
$testoQuery3 .= $b;
}
if ($c != "") {
$testoQuery3 .= $c;
}
if ($d != "") {
$testoQuery3 .= $d;
}
if ($e != "") {
$testoQuery3 .= $e;
}
if ($f != "") {
$testoQuery3 .= $f;
}
if ($g != "") {
$testoQuery3 .= $g;
}
if ($h != "") {
$testoQuery3 .= $h;
}
if ($l != "") {
$testoQuery3 .= $l;
}
} else {
if ($a != "") {
$testoQuery3 .= $a." AND ";
}
if ($b != "") {
$testoQuery3 .= $b." AND ";
}
if ($c != "") {
$testoQuery3 .= $c." AND ";
}
if ($d != "") {
$testoQuery3 .= $d." AND ";
}
if ($e != "") {
$testoQuery3 .= $e." AND ";
}
if ($f != "") {
$testoQuery3 .= $f." AND ";
}
if ($g != "") {
$testoQuery3 .= $g." AND ";
}
if ($h != "") {
$testoQuery3 .= $h." AND ";
}
if ($l != "") {
$testoQuery3 .= $l;
}
}
//categoria2
} else {
if ($categoria2 != "") {
	if (($categoria1 == "Valvole")) {
$testoQuery2 .= "WHERE obsoleto = '0' AND ";
	} else {
$testoQuery2 .= "WHERE obsoleto = '0' AND categoria2_it != '' AND ";
	}
if ($clausole == 1) {
if ($a != "") {
$testoQuery2 .= $a;
}
if ($b != "") {
$testoQuery2 .= $b;
}
if ($c != "") {
$testoQuery2 .= $c;
}
if ($d != "") {
$testoQuery2 .= $d;
}
if ($e != "") {
$testoQuery2 .= $e;
}
if ($f != "") {
$testoQuery2 .= $f;
}
if ($g != "") {
$testoQuery2 .= $g;
}
if ($h != "") {
$testoQuery2 .= $h;
}
if ($l != "") {
$testoQuery2 .= $l;
}
} else {
//categoria1
if ($a != "") {
$testoQuery2 .= $a." AND ";
}
if ($b != "") {
$testoQuery2 .= $b." AND ";
}
if ($c != "") {
$testoQuery2 .= $c." AND ";
}
if ($d != "") {
$testoQuery2 .= $d." AND ";
}
if ($e != "") {
$testoQuery2 .= $e." AND ";
}
if ($f != "") {
$testoQuery2 .= $f." AND ";
}
if ($g != "") {
$testoQuery2 .= $g." AND ";
}
if ($h != "") {
$testoQuery2 .= $h." AND ";
}
if ($l != "") {
$testoQuery2 .= $l;
}
}
} else {
$testoQuery .= "WHERE obsoleto = '0' AND categoria2_it != '' AND ";
if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
}
if ($b != "") {
$testoQuery .= $b;
}
if ($c != "") {
$testoQuery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
}
if ($g != "") {
$testoQuery .= $g;
}
if ($h != "") {
$testoQuery .= $h;
}
if ($l != "") {
$testoQuery .= $l;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h." AND ";
}
if ($l != "") {
$testoQuery .= $l;
}
//fine if categoria2
}
//fine if categoria3
}
//fine if clausole
}

//} else {
//$testoQuery .= "WHERE obsoleto = '' ";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
$finale2 = substr($testoQuery2,($lung-5),5);
$finale3 = substr($testoQuery3,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
if ($finale2 == " AND ") {
$testoQuery2 = substr($testoQuery2,0,($lung-5));
}
if ($finale3 == " AND ") {
$testoQuery3 = substr($testoQuery3,0,($lung-5));
}




//if ($clausole > 0) {
if ($categoria3 != "") {
  if (($negozio == "labels")) {
	$testoQuery3 .= " ORDER BY precedenza_int ASC";
  } else {
	switch($categoria3) {
	default:
	$testoQuery3 .= " ORDER BY categoria4_it ASC";
	break;
	case "Bombole":
	$testoQuery3 .= " ORDER BY id_valvola ASC";
	break;
	}
  }
} else {
if ($categoria2 != "") {
	if (($negozio == "labels")) {
$testoQuery2 .= " ORDER BY categoria3_it ASC, precedenza_int ASC";
	} else {
$testoQuery2 .= " ORDER BY categoria3_it ASC, precedenza_int ASC";
	}
} else {
if ($_GET['categoria1'] == "Erogatori") {
$testoQuery .= " ORDER BY diametro ASC";
} else {
$testoQuery .= " ORDER BY precedenza_int ASC, categoria2_it ASC";
}
}
}
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}

//echo "sess paese: ".$_SESSION[paese]."<br>";
//echo "paese: ".$paese."<br>";

/*
echo "<div>";
echo "<span style=\"color:rgb(0,0,0);\">";
echo "testoQuery: ".$testoQuery."<br>";
echo "testoQuery2: ".$testoQuery2."<br>";
echo "testoQuery3: ".$testoQuery3."<br>";
echo "</span>";
echo "</div>";
*/
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
$_SESSION[percorso_indietro] = $_SESSION[file_ritorno]."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua;

?>
<html>
<head>
<title>Quice - Prodotti</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/visual.css" />
<link href="css/lightbox3.css" rel="stylesheet" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<style type="text/css">
<!--
#main_container {
	width:980px;
	margin: auto;
	margin-top: 10px;
/*	background-color: #CCCCCC;*/
	height: 300px;
}
.pulsante_scheda {
	color:red;
}
#elenco {
	width:600px;
	height: auto;
	float: left;
	border: 1px solid #000000;
}
#riquadro_prodotto {
	width:182px;
	height:auto;
	float: left;
	border: 1px solid #999999;
	margin-left: 10px;
	margin-top: 10px;
}
.riquadro_prodotto_vis {
	width:958px;
	height:250px;
	/*	background-color: #FFFF00;
*/	float: left;
	border: 1px solid #999999;
	margin-top: 5px;
	margin-left: 10px;
	}
.riquadro_prodotto_vis_abbass {
	width:958px;
	height:250px;
	/*	background-color: #FFFF00;
*/	float: left;
	border: 1px solid #999999;
	margin-top: 5px;
	margin-left: 10px;
opacity:0.25;
filter:alpha(opacity=25);
	}
#raggruppamento_vis {
	width:250px;
	height:auto;
	/*background-color: #FF00FF;*/
	padding-top:10px;
	padding-left:10px;
	float: left;
}
.Titolo_famiglia_vis {
	width:270px;
	height:25px;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	text-align: left;
	color:#000000;
}
.componente_bottoni_vis {
	width:118px;
	height:228px;
	/*background-color: #CCCCCC;*/
	float: left;
	/*margin-left:20px;
	padding-left: 10px;*/
	padding-right: 10px;
}
#riquadri_famiglia:hover {
	/*background-image: url(immagini/sfondo_consumabili.jpg);*/
	/*background-color: #dcedf4;*/
	color:red;
}
#riquadri_famiglia {
	border: 1px solid #999999;
	width:162px;
	height:162px;
	float: left;
	text-align: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 17px;
	font-weight: bold;
	/*color: #003C80;*/
	color: #000;
	padding-left: 10px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	margin-left: 10px;
	margin-top: 10px;
	/*background-image: url(immagini/1sfondo_consumabili.jpg);
	background-repeat: no-repeat;*/
}

#riquadri_immagini_famiglia {
	width:182px;
	height:147px;
	float: left;
	text-align: center;
	padding-left: 5px;
	padding-top: 5px;
	padding-right: 5px;
}
#evidenziaTitolo {
	width:162px;
	height:25px;
	float: left;
	padding-left: 10px;
	padding-top: 10px;
	padding-right: 10px;
	text-align: left;
	vertical-align: middle;
	/*background-color: #0000FF;*/
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	/*color: #003C80;*/
	color: #000;
	font-weight: bold;
}
#caratteristiche {
	width:320px;
	height: auto;
	background-color: #00FF00;
	margin-left: 30px;
	float: left;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.btn{
	padding-top:10px;
}

.btnFreccia a {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 0 transparent;
    color: #fff;
    cursor: pointer;
    display: block;
    height: 19px;
    line-height: 19px;
    text-align: left;
    width: 117px;
    padding-left: 3px;
}
.btnFreccia a:hover {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 -29px transparent;
}
-->
</style>
	<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<SCRIPT type="text/javascript">
function aggiorna(){
document.form_lingua.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_lingua.submit();
}
</SCRIPT>
<SCRIPT type="text/javascript">
function aggiorna_filtri(){
document.form_filtri.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_filtri.submit();
}
</SCRIPT>
<SCRIPT type="text/javascript">
function closeJS(id_div){
  //window.location.href = window.location.href;
				$.ajax({
						type: "GET",   
						url: "aggiornamento_carrello.php",   
						data: "aggiungi=1&cat=",
						success: function(output) {
						$('#vis_carrello').html(output).show();
						//alert('closed')
						}
						});
				/*$.ajax({
						type: "GET",   
						url: "recupero_prodotti.php",   
						data: "aggiungi=1&cat=",
						success: function(output) {
						$('#'+id_div).html(output).show();
						//alert('closed')
						}
						});*/
}
</SCRIPT>
<script type="text/javascript" src="tinybox.js"></script>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox3.js"></script>
<SCRIPT type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</SCRIPT>
</head>
<body>

<div id="main_container">
<?php
$array_cat2_riquadri = array();
$array_cat1_riquadri = array();
switch ($_SESSION[lang]) {
  case "it":
  $code = "Codice";
  $price = "Prezzo";
  $package = "Confezione";
  $pcs = "Pezzi";
  $gallery = "Galleria immagini";
  break;
  case "en":
  $code = "Code";
  $price = "Price";
  $package = "Package";
  $pcs = "Pcs";
  $gallery = "Image gallery";
  break;
}
//div con pulsante BACK che compare solo quando si arriva a questa pagina da una ricerca di visualizzazione
//ovvero da RICERCA, CARRELLO, PROCESSO BUYER
if ($codice_ricerca != "") {
  echo "<div style=\"width: 958px; height: 25px; float: left;\">";
  $pos_report = stripos($_SESSION[percorso_ritorno],"unita");
  //echo "pos_report: ".$pos_report."<br>";
  //echo "ritorno: ".$_SESSION[percorso_ritorno]."<br>";
  
  if ($pos_report > 0) {
	  $percorso_back = $_SESSION[percorso_ritorno]."#".$anchor_processo;
  } else {
	  $percorso_back = $_SESSION[percorso_ritorno];
  }
	echo "<a href=\"".$percorso_back."\">";
	  echo "<div style=\"width: auto; height: 20px; float:right; font-size:14px; font-weight:bold; text-align:right; text-decoration:none; color:rgb(0,0,0);\">";
	  echo "BACK";
	  echo "</div>";
	echo "</a>";
  echo "</div>";
}
$array_unici = array();
if ($categoria3 != "") {
//categoria3
$risultf = mysql_query($testoQuery3) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
switch($categoria1) {
	case "Bombole":
$pagina = "scheda_visuale_bombole.php";
while ($rigaf = mysql_fetch_array($risultf)) {
if (!in_array($rigaf[id_valvola],$array_unici)) {
$add_unic = array_push($array_unici,$rigaf[id_valvola]);
switch ($_SESSION[lang]) {
	case "it":
$cat2_riquadri = str_replace("_"," ",$rigaf[categoria3_it]);
break;
	case "en":
	if ($rigaf[categoria3_en] == "") {
$cat2_riquadri = str_replace("_"," ",$rigaf[categoria3_it]);
	} else {
$cat2_riquadri = str_replace("_"," ",$rigaf[categoria3_en]);
	}
break;
}
if (!in_array($rigaf[categoria3_it],$array_cat2_riquadri)) {
$add_cat2 = array_push($array_cat2_riquadri,$rigaf[categoria3_it]);
}
//echo "<span style=\"color:black;\">111</span>";
echo "<a href=".$pagina."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&paese=".$paese."&id_valvola=".$rigaf[id_valvola]."&nazione_ric=".$nazioneDaModulo."&negozio=".$negozio."&lang=".$lingua.">";
echo "<div id=riquadro_prodotto>";
echo "<div id=evidenziaTitolo>";

if ($rigaf[id_valvola] == "Senza_valvola") {
switch ($_SESSION[lang]) {
	case "it":
	echo "Senza valvola";
break;
	case "en":
	echo "No valve";
break;
}
} else {
$sqlj = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigaf[id_valvola]'";
$risultj = mysql_query($sqlj) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaj = mysql_fetch_array($risultj)) {
switch ($_SESSION[lang]) {
	case "it":
echo $rigaj[descrizione1_it];
break;
	case "en":
echo $rigaj[descrizione1_en];
break;
}
}
}
echo "</div>"; 
echo "<div id=riquadri_immagini_famiglia>";
/*echo "<img src=../files/".$immagine." width=137 height=137 border=0>";*/
echo "</div>"; 
echo "</div>"; 
echo "</a>";
//fine if in array unici
}
//fine while
}
	break;
/*	case "Pacchi_bombole":
$pagina = "scheda_visuale.php";
while ($rigaf = mysql_fetch_array($risultf)) {
if (!in_array($rigaf[categoria4_it],$array_unici)) {
$add_unic = array_push($array_unici,$rigaf[categoria4_it]);
$cat2_riquadri = str_replace("_"," ",$rigaf[categoria3_it]);
//echo "<span style=\"color:black;\">222</span>";
echo "<a href=".$pagina."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$rigaf[categoria4_it]."&paese=".$paese."&nazione_ric=".$nazioneDaModulo."&negozio=".$negozio."&lang=".$lingua.">";
					if ($rigaf[foto] != "") {
					//echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
echo "<div id=riquadro_prodotto style=\"background-image:url(thumbs/".$rigaf[foto].");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$rigaf[foto]."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$rigaf[foto]."',sizingMethod='scale');\">";
					} else {
echo "<div id=riquadro_prodotto style=\"background-image:url(thumbs/".$rigaf[foto].");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$rigaf[foto]."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$rigaf[foto]."',sizingMethod='scale');\">";
					}

echo "<div id=evidenziaTitolo>";
switch ($_SESSION[lang]) {
	case "it":
echo str_replace("_"," ",$rigaf[categoria4_it]);
break;
	case "en":
echo str_replace("_"," ",$rigaf[categoria4_en]);
break;
}
echo "</div>"; 
echo "<div id=riquadri_immagini_famiglia>";
echo "</div>"; 
echo "</div>"; 
echo "</a>";
//fine if in array unici
}
//fine while
}
	break;*/
//fine switch
}
} else {
	//categoria2
if ($categoria2 != "") {
//$array_cat_dipendenze = array("Etichette_ADR");
//$array_cat_bombole = array("Bombole");
switch($categoria1) {
default:	
$pagina = "scheda_visuale.php";
break;
case "Bombole":	
$pagina = "ricerca_prodotti.php";
break;
case "Pacchi_bombole":	
$pagina = "scheda_visuale.php";
break;
case "Etichette_ADR":	
$pagina = "scheda_visuale_etich.php";
break;
}

$risultq = mysql_query($testoQuery2) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
$x = $x + 1;
//echo "query: ".$testoQuery2."<br>";
if ($rigaq[categoria3_it]== "") {
//***********************************
//***********************************
//SE NON ESISTE LA CATEGORIA 3 ALL'INTERNO DEL DB FACCIO VEDERE SUBITO I PRODOTTI COME SE FOSSIMO NELLA SCHEDA
//***********************************
//***********************************

//********************************************************
//inizio caso elementi famiglia senza riferimento famiglia, (tutti elementi diversi tra loro)
//***********************************************************
			//echo "<span style=\"color:black;\">PPP</span>";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=".$x." class=riquadro_prodotto_vis_abbass>";
			} else {
			echo "<div id=".$x." class=riquadro_prodotto_vis>";
			}
		//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
		echo "<div id=raggruppamento>";
		echo "<div class=Titolo_famiglia>";
		switch ($_SESSION[lang]) {
			case "it":
		echo str_replace("_"," ",$rigaq[categoria2_it]);
		break;
			case "en":
		echo str_replace("_"," ",$rigaq[categoria2_en]);
		break;
		}
		echo "</div>";
		echo "<div id=componente_descrizione>";
		echo "<div class=descr_famiglia>";
		switch ($_SESSION[lang]) {
			case "it":
		echo stripslashes($rigaq[descrizione2_it]);
		break;
			case "en":
		echo stripslashes($rigaq[descrizione2_en]);
		break;
		}
		echo "</div>";
		  echo "<div id=variante class=Titolo_famiglia>";
		  if ($rigaq[categoria4_it] != "0") {
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes(str_replace("_"," ",$rigaq[categoria4_it]));
			  break;
			  case "en":
			  //if ($rigaq[categoria3_it] != "110_Etichette_Adr") {
			  //echo stripslashes($rigaq[categoria4_it]);
			  //} else {
			  echo stripslashes(str_replace("_"," ",$rigaq[categoria4_en]));
			  //}
			  break;
			}					
		  }
		  echo "</div>";
			if ($rigag[id_valvola] != "") {
				$sqlj = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigaq[id_valvola]'";
				$risultj = mysql_query($sqlj) or die("Impossibile eseguire l'interrogazione" . mysql_error());
					while ($rigaj = mysql_fetch_array($risultj)) {
						switch ($_SESSION[lang]) {
							case "it":
						echo "VALVOLA ".$rigaj[descrizione1_it]."<br>";
						break;
							case "en":
						echo "VALVE ".$rigaj[descrizione1_en]."<br>";
						break;
		}
					}
			}
			if ($rigaq[id_cappellotto] != "") {
						switch ($_SESSION[lang]) {
							case "it":
				echo "CAPPELLOTTO ".$rigaq[cappellotto];
						break;
							case "en":
				echo "CAP ".$rigaq[cappellotto];
						break;
		}
			}
						switch ($_SESSION[lang]) {
							case "it":
				echo "<br>".$rigaq[descrizione3_it];
						break;
							case "en":
				echo "<br>".$rigaq[descrizione3_en];
						break;
		}
		echo "</div>";
		//echo "</div>";
		
		echo "<div id=componente_dati>";
		
		
		echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigaq[codice_art],0,1) != "*") {
				echo $rigaq[codice_art];
			  } else {
				echo substr($rigaq[codice_art],1);
			  }
			  echo "</div>";
		echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigaq[prezzo] > 0) {
			echo number_format($rigaq[prezzo],2,",",".");
		} else {
		  switch ($_SESSION[lang]) {
			case "it":
			  echo "da calcolare";
			break;
			case "en":
			  echo "to be quoted";
			break;
		  }
		}
		echo "</div>";
		echo "<div class=scritte_bottoncini>".$package."</div>"; 
		  echo "<div class=bottoncini>";
			  switch ($_SESSION[lang]) {
				case "it":
				  echo $rigaq[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigaq[confezione]);
				$conf = str_replace("blocchi da", "blocks of",$conf);
				$conf = str_replace("fogli da", "sheets of",$conf);
				$conf = str_replace("blister singoli", "one piece",$conf);
				$conf = str_replace("bustina singola", "one bag",$conf);
				$conf = str_replace("etichetta singola", "one label",$conf);
				$conf = str_replace("etichette", "labels",$conf);
				$conf = str_replace("fogli", "sheets",$conf);
				$conf = str_replace("bustine", "bags",$conf);
				  echo $conf;
				break;
			  }
		  echo "</div>";
			  if (($negozio = "labels") AND ($rigaq[ordine_stampa] == 1)) {
				$oggetto = "Ordine_etichette_Adr_codice_".$rigaq[codice_art];
				echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Articolo in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Item on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
				echo "</div></a>";
			  }
		echo "</div>";
			//echo "AAA";
		
		echo "</div>";
		
		echo "<div id=componente_immagine>";
					if ($rigaq[foto] != "") {
		echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
					} else {
					echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
					}
		echo "</div>";
		//componente bottoni
		echo "<div id=componente_bottoni>";
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		//operazioni di costruzione della gallery
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
		$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$num_img = mysql_num_rows($risultz);
		if ($num_img > 0) {
		$a = 1;
		while ($rigaz = mysql_fetch_array($risultz)) {
		if ($rigaq[codice_art] == "labels") {
		  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox".$rigaq[codice_art]."></a> ";
		} else {
		if ($a == 1) {
		   echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$x."]><span class=pulsante_galleria>".$gallery."</span></a> ";
		} else {
		  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$x."]></a> ";
		}
		}
		$a = $a + 1;
		}
		}
		//fine  costruzione gallery
		echo "</div>"; 
		echo "<div class=comandi>";
		if ($rigaq[percorso_pdf]) {
		echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank><span class=pulsante_scheda style=\"text-decoration:none;\">";
						switch ($_SESSION[lang]) {
					case "it":
					echo "Scheda tecnica";
					break;
					case "en":
					echo "Technical sheet";
					break;
					}
		echo "</span></a>";
		}
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		if ($rigaq[ordine_stampa] == 0) {
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$x.")}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Elimina dai preferiti";
					break;
					case "en":
					echo "Remove from favourites";
					break;
					}

				echo "</span>";
			} else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$x.")}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Aggiungi ai preferiti";
					break;
					case "en":
					echo "Add to favourites";
					break;
					}
				echo "</span>";
			}
		echo "</div>"; 
		echo "</a>";
		  echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$rigaq[negozio]."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		  echo "<div class=comandi>";
		  echo "<span class=pulsante_stampa>";
				  switch ($_SESSION[lang]) {
					  case "it":
					  echo "Stampa";
					  break;
					  case "en":
					  echo "Print";
					  break;
					  }
					  echo "</span>";
		  echo "</div>";
		  echo "</a>";
		}
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		echo "<div class=comandi>";
		$modulo = "popup_modifica_scheda.php";
		if ($rigaq[negozio] != "labels") {
		  if ($vis_admin == 1) {
			if ($rigaq[ordine_stampa] == 0) {
			  echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
			}
		  }
		}
		echo "</div>"; 

	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 


	//if ($rigaq[extra] != "") {
	switch ($_SESSION[lang]) {
	case "it":
	$scritta_puls = "Scegli quantit&agrave;";
	break;
	case "en":
	$scritta_puls = "Choose quantity";
	break;
	}
if ($rigaq[ordine_stampa] == 1) {
	echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
	} else {
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless3',width:640,height:520,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
	echo $scritta_puls;
	}
	echo "</div></a>";


//echo "id: ".$rigaq[id]."<br>";
		//fine div componente_bottoni
		echo "</div>"; 
		echo "</div>"; 
		//********************************************************
		//fine if elementi famiglia senza icone, (tutti elementi diversi tra loro)
		//***********************************************************
//********************************************************
//inizio etichetta simboli allegata
//***********************************************************
if (($negozio == "labels") AND ($rigaq[rif_simboli] != "")) {
	$pos_fam = stripos($rigaq[rif_simboli],"#");
	if ($pos_fam > 0) {
	  $array_famiglia = explode("#",$rigaq[rif_simboli]);
	} else {
	  $array_famiglia = array($rigaq[rif_simboli]);
	}
	//echo "array_famiglia: ";
	//print_r($array_famiglia);
	//echo "<br>: ";
	foreach ($array_famiglia as $sing_comp_fam) {
		$sqlk = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$sing_comp_fam' ORDER BY id ASC";
		$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigak = mysql_fetch_array($risultk)) {
//echo "<span style=\"color:black;\">QQQ</span>";
			if ($rigak[ordine_stampa] == 1) {
			echo "<div id=".$x." class=riquadro_prodotto_vis_abbass>";
			} else {
			echo "<div id=".$x." class=riquadro_prodotto_vis>";
			}
		//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
		echo "<div id=raggruppamento>";
		echo "<div class=Titolo_famiglia>";
		switch ($_SESSION[lang]) {
			case "it":
			if ($negozio == "labels") {
				echo str_replace("_"," ",substr($rigak[categoria3_it],4));
			} else {
		echo str_replace("_"," ",$rigak[categoria2_it]);
			}
		break;
			case "en":
			if ($negozio == "labels") {
				echo str_replace("_"," ",substr($rigak[categoria3_en],4));
			} else {
		echo str_replace("_"," ",$rigak[categoria2_en]);
			}
		break;
		}
		echo "</div>";
		echo "<div id=componente_descrizione>";
		echo "<div class=descr_famiglia>";
		switch ($_SESSION[lang]) {
			case "it":
		echo stripslashes($rigak[descrizione2_it]);
		break;
			case "en":
		echo stripslashes($rigak[descrizione2_en]);
		break;
		}
		echo "</div>";
		  echo "<div id=variante class=Titolo_famiglia>";
		  if ($rigak[categoria4_it] != "0") {
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes(str_replace("_"," ",$rigak[categoria4_it]));
			  break;
			  case "en":
			  echo stripslashes(str_replace("_"," ",$rigak[categoria4_en]));
			  break;
			}	
		  }
		  echo "</div>";
		switch ($_SESSION[lang]) {
		case "it":
		  echo "<br>".$rigak[descrizione3_it];
		break;
		case "en":
		  echo "<br>".$rigak[descrizione3_en];
		break;
		}
		echo "</div>";
		//echo "</div>";
		
		echo "<div id=componente_dati>";
		
		
		echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigak[codice_art],0,1) != "*") {
				echo $rigak[codice_art];
			  } else {
				echo substr($rigak[codice_art],1);
			  }
			  echo "</div>";
		echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigak[prezzo] > 0) {
			echo number_format($rigak[prezzo],2,",",".");
		} else {
		  switch ($_SESSION[lang]) {
			case "it":
			  echo "da calcolare";
			break;
			case "en":
			  echo "to be quoted";
			break;
		  }
		}
		echo "</div>";
		echo "<div class=scritte_bottoncini>".$package."</div>"; 
		  echo "<div class=bottoncini>";
			  switch ($_SESSION[lang]) {
				case "it":
				  echo $rigak[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigaq[confezione]);
				$conf = str_replace("blocchi da", "blocks of",$conf);
				$conf = str_replace("fogli da", "sheets of",$conf);
				$conf = str_replace("blister singoli", "one piece",$conf);
				$conf = str_replace("bustina singola", "one bag",$conf);
				$conf = str_replace("etichetta singola", "one label",$conf);
				$conf = str_replace("etichette", "labels",$conf);
				$conf = str_replace("fogli", "sheets",$conf);
				$conf = str_replace("bustine", "bags",$conf);
				  echo $conf;
				break;
			  }
		  echo "</div>";
			  if (($negozio = "labels") AND ($rigaq[ordine_stampa] == 1)) {
				$oggetto = "Ordine_etichette_Adr_codice_".$rigaq[codice_art];
				echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Articolo in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Item on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
				echo "</div></a>";
			  }
		echo "</div>";
			//echo "AAA";
		
		echo "</div>";
		
		echo "<div id=componente_immagine>";
					if ($rigak[foto] != "") {
		echo "<img src=files/".$rigak[foto]." width=248 height=248>";
					} else {
					echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
					}
		echo "</div>";
		//componente bottoni
		echo "<div id=componente_bottoni>";
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		//operazioni di costruzione della gallery
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigak[codice_art]' ORDER BY precedenza ASC";
		$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$num_img = mysql_num_rows($risultz);
		if ($num_img > 0) {
		$a = 1;
		while ($rigaz = mysql_fetch_array($risultz)) {
		if ($a == 1) {
		   echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$x."]><span class=pulsante_galleria>".$gallery."</span></a> ";
		} else {
		  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$x."]></a> ";
		}
		$a = $a + 1;
		}
		}
		//fine  costruzione gallery
		echo "</div>"; 
		echo "<div class=comandi>";
		if ($rigak[percorso_pdf]) {
		echo "<a href=documenti/".$rigak[percorso_pdf]." target=_blank><span class=pulsante_scheda style=\"text-decoration:none;\">";
		switch ($_SESSION[lang]) {
		  case "it":
		  echo "Scheda tecnica";
		  break;
		  case "en":
		  echo "Technical sheet";
		  break;
		}
		echo "</span></a>";
		}
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigak[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
		  if ($preferiti_presenti > 0) {
			echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigak[id]."&negozio_prod=".$rigak[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$x.")}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Elimina dai preferiti";
					break;
					case "en":
					echo "Remove from favourites";
					break;
					}

				echo "</span>";
			} else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$x.")}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Aggiungi ai preferiti";
					break;
					case "en":
					echo "Add to favourites";
					break;
					}
				echo "</span>";
			}
		echo "</div>"; 
		echo "</a>";
		echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$rigak[negozio]."&id=".$rigak[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		echo "<div class=comandi>";
		echo "<span class=pulsante_stampa>";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Stampa";
					break;
					case "en":
					echo "Print";
					break;
					}
					echo "</span>";
		echo "</div>";
		echo "</a>";
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		echo "<div class=comandi>";
		$modulo = "popup_modifica_scheda.php";
		if ($rigak[negozio] != "labels") {
		  if ($vis_admin == 1) {
		  echo "<a href=".$modulo."?action=edit&id=".$rigak[id]."&negozio=".$rigak[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
		  }
		}
		echo "</div>"; 

	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 


	//if ($rigaq[extra] != "") {
	switch ($_SESSION[lang]) {
	case "it":
	$scritta_puls = "Scegli quantit&agrave;";
	break;
	case "en":
	$scritta_puls = "Choose quantity";
	break;
	}
if ($rigak[ordine_stampa] == 1) {
	echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
	} else {
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless3',width:640,height:520,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
	echo $scritta_puls;
	}
	echo "</div></a>";
/*	} else {
if ($rigak[ordine_stampa] == 1) {
	echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
	} else {
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
	switch ($_SESSION[lang]) {
	case "it":
	echo "Inserisci nel carrello";
	break;
	case "en":
	echo "Add to cart";
	break;
	}
	echo "</div></a>";
	}
}
*/


		//fine div componente_bottoni
		echo "</div>"; 
		//********************************************************
		//fine etichette allegate
		//***********************************************************
		echo "</div>"; 
		//fine while 
		}
		//fine foreach famiglia
	}
	//fine if (($negozio == "labels") AND ($rigaq[rif_famiglia] != "")) 
}
		
		
	//***********************************
//***********************************
//FINE CASO SE NON ESISTE LA CATEGORIA 3 ALL'INTERNO DEL DB 
//***********************************
//***********************************	

} else {
	
if (!in_array($rigaq[categoria3_it],$array_unici)) {
$add_unic = array_push($array_unici,$rigaq[categoria3_it]);

switch ($_SESSION[lang]) {
	case "it":
	if ($negozio == "labels") {
	$capo_famiglia = str_replace("_"," ",substr($rigaq[categoria3_it],4));
	} else {
	$capo_famiglia = str_replace("_"," ",$rigaq[categoria3_it]);
	}
	break;
	case "en":
	if ($rigaq[categoria3_en] == "") {
	if ($negozio == "labels") {
	$capo_famiglia = str_replace("_"," ",substr($rigaq[categoria3_it],4));
	} else {
	$capo_famiglia = str_replace("_"," ",$rigaq[categoria3_it]);
	}
	} else {
	if ($negozio == "labels") {
	$capo_famiglia = str_replace("_"," ",substr($rigaq[categoria3_en],4));
	} else {
	$capo_famiglia = str_replace("_"," ",$rigaq[categoria3_en]);
	}
	}
	break;
}
if (!in_array($rigaq[categoria2_it],$array_cat1_riquadri)) {
$add_cat2 = array_push($array_cat2_riquadri,$rigaq[categori2_it]);
}
switch ($_SESSION[lang]) {
	case "it":
	$cat2_riquadri = str_replace("_"," ",$rigaq[categoria2_it]);
	break;
	case "en":
	$cat2_riquadri = str_replace("_"," ",$rigaq[categoria2_en]);
	break;
}
					if ($rigaq[foto] != "") {
$immagine = "thumbs/".$rigaq[foto];
					//echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
					} else {
$immagine = "thumbs/TO-BE-UPDATED.jpg";
					}

if ($categoria1 == "Bombole") {

// Read the image
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$rigaq[descrizione3_it]).".png");
$ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$rigaq[descrizione4_it]).".png");
if ($rigak[id_valvola] != "") {
  $sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigak[id_valvola]."'";
  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigad = mysql_fetch_array($risultd)) {
	  if ($rigad[descrizione3_it] == "riduttrice") {
		$valvola = new Imagick("componenti/valvola/valvola_viproxy.png");
	  } else {
		$valvola = new Imagick("componenti/valvola/valvola_new.png");
	  }
  }
}
//$valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$rigaq[id_valvola]).".png");
if ($rigak[id_cappellotto] != "") {
$cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$rigaq[id_cappellotto]).".png");
}

// Clone the image and flip it 
$bombola = $corpo->clone();

// Composite i pezzi successivi sopra il fondo in questo ordine 
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
if ($rigak[id_cappellotto] != "") {
$bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
}
$timecode= date("dmYHis",time());
$immagine = "temp_bombole/".$timecode."_".$rigaq[codice_art].".png";
$bombola->writeImage($immagine);
//************************************
//*************************************
$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
$bombola = "";
}
//echo "<span style=\"color:black;\">333</span>";
echo "<a href=".$pagina."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$rigaq[categoria3_it]."&paese=".$paese."&nazione_ric=".$nazioneDaModulo."&negozio=".$negozio."&lang=".$lingua.">";
echo "<div id=riquadro_prodotto style=\"background-image:url(".$immagine.");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$immagine."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$immagine."',sizingMethod='scale');\">";
echo "<div id=evidenziaTitolo>";
//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
echo $capo_famiglia;
//echo $cat2_riquadri;
echo "</div>"; 
echo "<div id=riquadri_immagini_famiglia>";
/*echo "<img src=../files/".$immagine." width=137 height=137 border=0>";*/
echo "</div>"; 
echo "</div>"; 
echo "</a>";
//fine if in array unici
}

//fine if categoria3_it == ""
}
//fine while
}
//echo "array_unici: ";
//print_r($array_unici);
//echo "<br>";
  $query_index = "SELECT * FROM qui_prodotti_labels_dupli WHERE obsoleto = '0' AND categoria1_it = '$categoria1' AND paese = '$paese' AND categoria2_it = '$categoria2' ORDER BY precedenza_int ASC";
  //echo "stampa query: ".$query_index."<br>";
  $risultz = mysql_query($query_index) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
  while ($rigaz = mysql_fetch_array($risultz)) {
	  $new_cat3 = str_replace("_"," ",substr($rigaz[categoria3_it],4));
	if (!in_array($rigaz[categoria3_it],$array_unici)) {
	$add_cat2 = array_push($array_unici,$rigaz[categoria3_it]);
	  if ($rigaz[foto] != "") {
		$foto_fam = $rigaz[foto];
	  }
	  echo "<a href=".$pagina."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$rigaz[categoria3_it]."&paese=".$paese."&nazione_ric=".$nazioneDaModulo."&negozio=".$negozio."&lang=".$lingua.">";
	  echo "<div id=riquadro_prodotto style=\"background-image:url(thumbs/".$foto_fam.");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$foto_fam."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$foto_fam."',sizingMethod='scale');\">";
	  echo "<div id=evidenziaTitolo>";
	  //echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
		echo $new_cat3; 
	  //echo $cat2_riquadri;
	  echo "</div>"; 
	  echo "<div id=riquadri_immagini_famiglia>";
	  /*echo "<img src=../files/".$immagine." width=137 height=137 border=0>";*/
	  echo "</div>"; 
	  echo "</div>"; 
	  echo "</a>";
	  $new_cat3 = "";
	}
  }
} else {
//categoria1
//risultato scelta categoria1_it
$risultq = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
if (!in_array($rigaq[categoria2_it],$array_unici)) {
$add_unic = array_push($array_unici,$rigaq[categoria2_it]);
switch ($_SESSION[lang]) {
	case "it":
	$capo_famiglia = str_replace("_"," ",$rigaq[categoria3_it]);
	break;
	case "en":
	if ($rigaq[categoria3_en] == "") {
	$capo_famiglia = str_replace("_"," ",$rigaq[categoria3_it]);
	} else {
	$capo_famiglia = str_replace("_"," ",$rigaq[categoria3_en]);
	}
	break;
}
if (!in_array($rigaq[categoria1_it],$array_cat1_riquadri)) {
$add_cat1 = array_push($array_cat1_riquadri,$rigaq[categori1_it]);
}
switch ($_SESSION[lang]) {
	case "it":
	$cat2_riquadri = str_replace("_"," ",$rigaq[categoria2_it]);
	break;
	case "en":
	$cat2_riquadri = str_replace("_"," ",$rigaq[categoria2_en]);
	break;
}
$cat2_riquadri = str_replace(", ",",<br>",$cat2_riquadri);
//echo "<div id=riquadro_prodotto>";
/*echo "<div id=evidenziaTitolo>";

//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
echo "</div>"; 
*///echo "<img src=immagini/spacer.gif width=10 height=170 border=0> ";
switch ($negozio) {
case "assets":
	switch ($categoria1) {
	default:
	$sqleee = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = '$categoria1' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY id ASC LIMIT 1";
	break;
	case "Valvole":
	$sqleee = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = 'Valvole' AND descrizione4_it LIKE '%$rigaq[categoria2_it]%' ORDER BY id ASC LIMIT 1";
	break;
	case "Pacchi_bombole":
	$sqleee = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = 'Pacchi_bombole' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY id ASC LIMIT 1";
	break;
	case "Bombole":
	//	$sqleee = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = 'Bombole' AND categoria2_it = '$rigaq[categoria2_it]' AND categoria3_it = 'ossigeno' ORDER BY id ASC LIMIT 1";
$sqleee = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = 'Bombole' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY id ASC LIMIT 1";
	break;
	case "Pescanti":
	$sqleee = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = 'Pescanti' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY id ASC LIMIT 1";
	break;
	}
break;
case "consumabili":
$sqleee = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto = '0' AND categoria1_it = '$rigaq[categoria1_it]' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY precedenza_int ASC LIMIT 1";
break;
case "spare_parts":
$sqleee = "SELECT * FROM qui_prodotti_spare_parts WHERE obsoleto = '0' AND categoria1_it = '$rigaq[categoria1_it]' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY id ASC LIMIT 1";
break;
case "labels":
$sqleee = "SELECT * FROM qui_prodotti_labels WHERE obsoleto = '0' AND categoria1_it = '$rigaq[categoria1_it]' AND paese = '$paese' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY precedenza_int ASC LIMIT 1";
break;
case "vivistore":
$sqleee = "SELECT * FROM qui_prodotti_vivistore WHERE obsoleto = '0' AND categoria1_it = '$rigaq[categoria1_it]' AND categoria2_it = '$rigaq[categoria2_it]' ORDER BY precedenza_int ASC LIMIT 1";
break;
}
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigae = mysql_fetch_array($risulteee)) {
	if ($rigae[foto] != "") {
	$foto_fam = $rigae[foto];
	//echo "foto_fam: ".$foto_fam."<br>";
					} else {
	$foto_fam = "TO-BE-UPDATED.jpg";
					}
	}

//echo "<span style=\"color:black;\">444</span>";
if ($categoria1 == "Bombole") {
echo "<a href=ricerca_settore_bombole.php?categoria1=".$categoria1."&categoria2=".$rigaq[categoria2_it]."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua.">";
} else {
echo "<a href=ricerca_prodotti.php?categoria1=".$categoria1."&categoria2=".$rigaq[categoria2_it]."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua.">";
}
//echo "<div id=riquadri_famiglia style=background-image: url(files/".$foto_fam.");background-repeat:no-repeat;background-attachment:fixed;background-position:right bottom;>";
//echo "<div id=riquadri_famiglia style=\"background-image: url(files/".$foto_fam.");background-repeat: no-repeat;\">";

//echo "****************************************************<br>fin qui bene<br>****************************************************";
switch ($categoria1) {
default:
echo "<div id=riquadri_famiglia style=\"background-image:url(thumbs/".$foto_fam.");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$foto_fam."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$foto_fam."',sizingMethod='scale');\">";

break;
case "Pacchi_bombole":
echo "<div id=riquadri_famiglia style=\"background-image:url(thumbs/".$foto_fam.");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$foto_fam."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='thumbs/".$foto_fam."',sizingMethod='scale');\">";
break;
case "Bombole":
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigae = mysql_fetch_array($risulteee)) {
// Read the image
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$rigae[descrizione3_it]).".png");
$ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$rigae[descrizione4_it]).".png");
$valvola = new Imagick("componenti/valvola/valvola_new.png");
//$valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$rigae[id_valvola]).".png");
if ($rigae[id_cappellotto] != "") {
$cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$rigae[id_cappellotto]).".png");
}

// Clone the image and flip it 
$bombola = $corpo->clone();

// Composite i pezzi successivi sopra il fondo in questo ordine 
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
if ($rigae[id_cappellotto] != "") {
$bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
}
$timecode= date("dmYHis",time());
//$immagine = "temp_bombole/".$timecode."_".$rigae[codice_art].".png";
$immagine = "temp_bombole/".$rigae[codice_art].".png";
$bombola->writeImage($immagine);
//creazione anteprima
$thumb = new Imagick($immagine);
$anteprima = "temp_bombole/t_".$rigae[codice_art].".png";
$thumb->resizeImage(140,140,Imagick::FILTER_LANCZOS,1);
$thumb->writeImage($anteprima);
$thumb->destroy(); 
$fondo = new Imagick("componenti/fondo_bianco.png");
$sogg = new Imagick($anteprima);
// Clone the image and flip it 
$canvas = $fondo->clone();

$canvas->compositeImage($sogg, imagick::COMPOSITE_OVER,47, 47);

$anteprima2 = "temp_bombole/a_".$rigae[codice_art].".png";
$canvas->writeImage($anteprima2);
$canvas->destroy();
chmod($anteprima2,0777);
unlink($anteprima); 
	}
$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
$bombola = "";
$foto_corpo = "";
$foto_ogiva = "";
$foto_valvola = "";
$foto_cappellotto = "";

//************************************
//*************************************
echo "<div id=riquadri_famiglia style=\"background-image:url(".$anteprima2.");\">";
break;
}

	
echo $cat2_riquadri;
echo "</div>"; 
echo "</a>";
$anteprima2 = "";
//echo "</div>"; 
//fine if in array unici
}
//fine while
}
if ($categoria1 == "Promozionali") {
echo "<a href=http://www.target-tn.it target=_blank>";
switch ($_SESSION[lang]) {
	case "it":
	$sfondo_target = "gadget_gastone_pulsanteIT.gif";
	break;
	case "en":
	$sfondo_target = "gadget_gastone_pulsanteEN.gif";
	break;
}
echo "<div id=riquadri_famiglia style=\"width:340px; border: none; background-image:url(immagini/".$sfondo_target.");-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='immagini/".$sfondo_target."',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='immagini/".$sfondo_target."',sizingMethod='scale');\">";
/*
switch ($_SESSION[lang]) {
	case "it":
echo "Se non hai trovato il gadget che cercavi, puoi provare direttamente sul sito del fornitore";
break;
	case "en":
echo "If you didn't found the gadget you were seeking, try on the manufacturer site";
break;
}
*/
echo "</div>"; 
echo "</a>";
}

 $query_index = "SELECT * FROM qui_prodotti_labels_dupli WHERE obsoleto = '0' AND categoria1_it = '$categoria1' AND paese = '$paese' AND categoria2_it != '' ORDER BY precedenza_int ASC";
 // echo "stampa query: ".$query_index."<br>";
  $risultz = mysql_query($query_index) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
  while ($rigaz = mysql_fetch_array($risultz)) {
	if (!in_array($rigaz[categoria2_it],$array_unici)) {
	$add_unic = array_push($array_unici,$rigaz[categoria2_it]);
	  if ($rigaz[foto] != "") {
	  $foto_fam = $rigaz[foto];
	  }
	  echo "<a href=ricerca_prodotti.php?categoria1=".$categoria1."&categoria2=".$rigaz[categoria2_it]."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua.">";
		echo "<div id=riquadri_famiglia style=\"background-image:url(".$foto_fam.");\">";
		  echo str_replace("_"," ",$rigaz[categoria2_it]); 
		echo "</div>"; 
	  echo "</a>"; 
	}
  }
  
//fine if categoria2
} 
//fine if categoria3
} 

	
	
//********************************
//********************************
//SCHEDE PRODOTTI VIRTUALI BILOCATI
//********************************
//********************************
		//echo "LLL";
		$query_virtual = "SELECT * FROM qui_prodotti_labels_dupli WHERE obsoleto = '0' AND categoria1_it = '$categoria1' AND paese = '$paese' AND categoria2_it = '$categoria2' ORDER BY categoria3_it ASC";
		$risultf = mysql_query($query_virtual) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
		while ($rigaf = mysql_fetch_array($risultf)) {
		  $queryddd = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$rigaf[codice_art]'";
		  $risultddd = mysql_query($queryddd) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
		  while ($rigaddd = mysql_fetch_array($risultddd)) {
			  $id_prod_virt = $rigaddd[id];
		  }
		  $foto_fam = $rigaf[foto];
		  //PROCEDURA DI INDIVIDUAZIONE PERCORSI AGGIUNTIVI A QUELLO STANDARD PER LA VISUALIZZAZIONE DELLE ETICHETTE
		  //ogni percorso è separato da virgola e si trova nel campo bilocazione (it) o bilocazione_en (en)
		  //prima di tutto individuare in che lingua ci troviamo per determinare qual è il campo da utilizzare
		  switch ($_SESSION[lang]) {
			case "it":
			$posvirg = stripos(",",$rigaf[bilocazione]);
			if ($posvirg > 0) {
			  $array_locazioni = explode ($rigaf[bilocazione],",");
			} else {
			  $array_locazioni = array($rigaf[bilocazione]);
			}
			break;
			case "en":
			$posvirg = stripos(",",$rigaf[bilocazione_en]);
			if ($posvirg > 0) {
			  $array_locazioni = explode (",",$rigaf[bilocazione_en]);
			} else {
			  $array_locazioni = array($rigaf[bilocazione_en]);
			}
			break;
		  }	
		  //echo "array_locazioni: ";
		  //print_r($array_locazioni);
		  //echo "<br>";
		  //ho l'array "array_locazioni" che mi contiene tutti i percorsi aggiuntivi in cui posso vedere le etichette
		  foreach ($array_locazioni as $sing_locazione) {
		  $array_percorso_interno = explode ("|",$sing_locazione);
		  switch (count($array_percorso_interno)) {
			  case 3:
				  if (($categoria1 == $array_percorso_interno[0]) && ($categoria2 == $array_percorso_interno[2]) && ($paese == $array_percorso_interno[1])) {
					if ($rigaf[ordine_stampa] == 1) {
					echo "<div id=riquadro_prodotto_abbass>";
					} else {
					echo "<div class=riquadro_prodotto_vis>";
					}
				  echo "<div id=raggruppamento>";
				  echo "<div id=componente_descrizione>";
				  echo "<div class=Titolo_famiglia>";
				  switch ($_SESSION[lang]) {
					case "it":
					echo str_replace("_"," ",$array_percorso_interno[2]);
					break;
					case "en":
					  if ($rigaf[categoria3_en] == "") {
						echo str_replace("_"," ",$array_percorso_interno[2]);
					  } else {
						echo str_replace("_"," ",$array_percorso_interno_en[2]);
					  }
					break;
				  }					
				  echo "</div>";
				  echo "<div class=descr_famiglia>";
				  switch ($_SESSION[lang]) {
					case "it":
					echo stripslashes($rigaf[descrizione2_it]);
					break;
					case "en":
					echo stripslashes($rigaf[descrizione2_en]);
					break;
				  }					
				  echo "</div>";
				  echo "<div id=variante class=Titolo_famiglia>";
				  if  ($rigaf[categoria4_en] == "") {
					echo stripslashes(str_replace("_"," ",$rigaf[categoria4_it]));
				  } else {
					switch ($_SESSION[lang]) {
					  case "it":
					  echo stripslashes(str_replace("_"," ",$rigaf[categoria4_it]));
					  break;
					  case "en":
					  echo stripslashes(str_replace("_"," ",$rigaf[categoria4_en]));
					  break;
					}					
				  }
				  echo "</div>";
				  echo "</div>";
				  echo "<div id=componente_dati>";
				  echo "<div class=Titolo_famiglia></div>"; 
				  echo "<div class=scritte_bottoncini>".$code."</div>"; 
					  echo "<div class=bottoncini>";
					  if (substr($rigaf[codice_art],0,1) != "*") {
						echo $rigaf[codice_art];
					  } else {
						echo substr($rigaf[codice_art],1);
					  }
					  echo "</div>";
				  echo "<div class=scritte_bottoncini>".$price."</div>"; 
				echo "<div class=bottoncini>";
				if ($rigaf[prezzo] > 0) {
					echo number_format($rigaf[prezzo],2,",",".");
				} else {
				  switch ($_SESSION[lang]) {
					case "it":
					  echo "da calcolare";
					break;
					case "en":
					  echo "to be quoted";
					break;
				  }
				}
				echo "</div>";
				  echo "<div class=scritte_bottoncini>".$package."</div>";
				  echo "<div class=bottoncini>";
					  switch ($_SESSION[lang]) {
						case "it":
						  echo $rigaf[confezione];
						break;
						case "en":
						$conf = str_replace("confezioni da", "package of",$rigaf[confezione]);
						$conf = str_replace("blocchi da", "blocks of",$conf);
						$conf = str_replace("fogli da", "sheets of",$conf);
						$conf = str_replace("blister singoli", "one piece",$conf);
						$conf = str_replace("bustina singola", "one bag",$conf);
						$conf = str_replace("etichetta singola", "one label",$conf);
						$conf = str_replace("etichette", "labels",$conf);
						$conf = str_replace("fogli", "sheets",$conf);
						$conf = str_replace("bustine", "bags",$conf);
						  echo $conf;
						break;
					  }
				  echo "</div>";
				  if ($rigaf[ordine_stampa] == 1) {
					$oggetto = "Ordine_etichette_Adr_codice_".$rigaq[codice_art];
					echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
				  switch ($_SESSION[lang]) {
					case "it":
						echo "Etichetta in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
					break;
					case "en":
						echo "Label on approval.<br>To request information<br>CLICK HERE";
					break;
				  }
					echo "</div></a>";
				  }
				  echo "</div>";
				  
				  echo "<div id=componente_iconcine>";
				  echo "</div>";
				  echo "</div>";
				  
				  echo "<div id=componente_immagine>";
				  if ($rigaf[foto] != "") {
					echo "<img src=files/".$rigaf[foto]." width=248 height=248>";
				  } else {
					echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
				  }
				  echo "</div>";
				  //componente bottoni
				  echo "<div id=componente_bottoni>";
				  echo "<div class=comandi>";
				  echo "</div>"; 
				  echo "<div class=comandi>";
				  $nome_gruppo = mt_rand(1000,9999);
				  //operazioni di costruzione della gallery
					if ($rigaf[negozio] == "labels") {
					  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaf[codice_art]' AND precedenza = '2'";
					  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
					  $num_img = mysql_num_rows($risultz);
						while ($rigaz = mysql_fetch_array($risultz)) {
							echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
						  }
						  } else {
				  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaf[codice_art]' ORDER BY precedenza ASC";
				  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
				  $num_img = mysql_num_rows($risultz);
				  if ($num_img > 0) {
					$a = 1;
					while ($rigaz = mysql_fetch_array($risultz)) {
					  if ($a == 1) {
						echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
					  } else {
						echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]></a> ";
					  }
					  $a = $a + 1;
					}
				  }
					}
				  //fine  costruzione gallery
				  echo "</div>";
				  if ($rigaf[percorso_pdf] != "") {
					echo "<a href=documenti/".$rigaf[percorso_pdf]." target=_blank>";
					echo "<div class=comandi>";
					echo "<span class=pulsante_scheda>";
					switch ($_SESSION[lang]) {
					  case "it":
					  echo "Scheda tecnica";
					  break;
					  case "en":
					  echo "Technical sheet";
					  break;
					}
					echo "</span>";
					echo "</div></a>"; 
				  }
				  if ($nofunz != "") {
				  } else {
					echo "<div class=comandi_spazio>";
					echo "</div>"; 
					$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$id_prod_virt' AND id_utente = '$_SESSION[user_id]'";
					$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
					$preferiti_presenti = mysql_num_rows($risulteee);
					if ($preferiti_presenti > 0) {
					  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$id_prod_virt."&negozio_prod=".$rigaf[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
					  echo "<div class=comandi>";
					  echo "<span class=pulsante_preferiti>";
					  switch ($_SESSION[lang]) {
						case "it":
						echo "Elimina dai preferiti";
						break;
						case "en":
						echo "Remove from favourites";
						break;
					  }
					  echo "</span>";
					} else {
					  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaf[negozio]."&id_prod=".$id_prod_virt."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
					  echo "<div class=comandi>";
					  echo "<span class=pulsante_preferiti>";
					  switch ($_SESSION[lang]) {
						case "it":
						echo "Aggiungi ai preferiti";
						break;
						case "en":
		
						echo "Add to favourites";
						break;
					  }
					  echo "</span>";
					}
				echo "</div>"; 
				echo "</a>";
				echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$id_prod_virt."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_stampa>";
				switch ($_SESSION[lang]) {
				  case "it":
				  echo "Stampa";
				  break;
				  case "en":
				  echo "Print";
				  break;
				}
				echo "</span>";
				echo "</div>"; 
				echo "</a>";
				echo "<div class=comandi_spazio>";
				echo "</div>"; 
				echo "<div class=comandi>";
				$modulo = "popup_modifica_scheda.php";
				if ($vis_admin == 1) {
				//echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
				}
				echo "</div>"; 	
				echo "<div class=spazio_puls_carrello>";
				echo "</div>"; 
		//		if ($rigaq[extra] != "") {
				  switch ($_SESSION[lang]) {
					case "it":
					$scritta_puls = "Scegli quantit&agrave;";
					break;
					case "en":
					$scritta_puls = "Choose quantity";
					break;
				  }
				  if ($rigaf[ordine_stampa] == 1) {
					echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
				  } else {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaf[negozio]."&id_prod=".$id_prod_virt."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
				  }
				  echo $scritta_puls;
				  echo "</div></a>";
				  }
				//fine div componente_bottoni
				echo "</div>"; 
				//fine div riquadro_prodotto
				echo "</div>"; 
				}
			  break;
		  }
					
	}
	  //********************************************************
	  //fine if prodotti bilocati
	  //***********************************************************
}
/*
*/
?>
</div>

</body>
</html>
