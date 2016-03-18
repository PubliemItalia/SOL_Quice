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
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
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
include "menu_quice3.php";
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
$clausole++;
}

if ($categoria1 != "") {
$_SESSION[categoria1] = $categoria1;
$clausole++;
}
if ($categoria3 != "") {
$_SESSION[categoria3] = $categoria3;
$clausole++;
}
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$clausole++;
}





//$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND paese = '$paese' AND id_cappellotto != '' ORDER BY categoria3_it";
$testoQuery = "SELECT DISTINCT categoria3_it FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND paese = '$paese' ORDER BY categoria3_it ASC";


//echo "<br>testoQuery: ".$testoQuery."<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
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
	margin-bottom:20px;
/*	background-color: #CCCCCC;*/
	min-height: 300px;
	overflow:hidden;
	height:auto;
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
	background-color: #dcedf4;
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
</head>
<body>

<div id="main_container">
<?php
$array_unici = array();
$risultf = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	$addcat = array_push($array_unici,$rigaf[categoria3_it]);
}
/*
$cat2_riquadri = str_replace("_"," ",$rigaf[categoria2_it]);
// Read the image
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$rigaf[descrizione3_it]).".png");
$ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$rigaf[descrizione4_it]).".png");
if ($rigaf[id_valvola] != "") {
$sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigaf[id_valvola]."'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
switch($rigad[descrizione3_it]) {
		case "valvola_riduttrice":
		  $valvola = new Imagick("componenti/valvola/valvola_viproxy.png");
		break;
		case "valvola_parziale_ottone":
		  $valvola = new Imagick("componenti/valvola/valvola_parziale_ottone.png");
		break;
		case "valvola_parziale_cromata":
		  $valvola = new Imagick("componenti/valvola/valvola_parziale_cromata.png");
		break;
		case "valvola_completa_ottone":
		  $valvola = new Imagick("componenti/valvola/valvola_completa_ottone.png");
		break;
		case "valvola_completa_cromata":
		  $valvola = new Imagick("componenti/valvola/valvola_completa_cromata.png");
		break;
		case "valvola5-8":
		  $valvola = new Imagick("componenti/valvola/valvola5-8.png");
		break;
		case "valvola_integrata_parziale":
		  $valvola = new Imagick("componenti/valvola/valvola_integrata_parziale.png");
		break;
	  }
}
}
if ($rigaf[id_cappellotto] != "") {
$cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$rigaf[id_cappellotto]).".png");
}

// Clone the image and flip it 
$bombola = $corpo->clone();

// Composite i pezzi successivi sopra il fondo in questo ordine 
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
if ($rigaf[id_valvola] != "") {
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
}
if ($rigaf[id_cappellotto] != "") {
$bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
}
$timecode= date("dmYHis",time());
//$immagine = "temp_bombole/".$timecode."_".$rigaf[codice_art].".png";
$immagine = "temp_bombole/".$rigaf[codice_art].".png";
$bombola->writeImage($immagine);
//************************************
//*************************************
$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
$bombola = "";
//creazione anteprima
$thumb = new Imagick($immagine);
$anteprima = "temp_bombole/t_".$rigaf[codice_art].".png";
$thumb->resizeImage(140,140,Imagick::FILTER_LANCZOS,1);
$thumb->writeImage($anteprima);
$thumb->destroy(); 
$fondo = new Imagick("componenti/fondo_bianco.png");
$sogg = new Imagick($anteprima);
// Clone the image and flip it 
$canvas = $fondo->clone();

$canvas->compositeImage($sogg, imagick::COMPOSITE_OVER,47, 47);

//$anteprima2 = "temp_bombole/a".$_SESSION[user_id]."-".$timecode."_".$rigaf[codice_art].".png";
$anteprima2 = "temp_bombole/a_".$rigaf[codice_art].".png";
$canvas->writeImage($anteprima2);
$canvas->destroy();
chmod($anteprima2,0777);
unlink($anteprima); 
*/

foreach ($array_unici as $sing_cat) {
	//echo "ok<br>";
  $queryq = "SELECT * FROM qui_prodotti_assets WHERE categoria1_it = '$categoria1' AND paese = '$paese' AND categoria2_it = '$categoria2' AND categoria3_it = '$sing_cat' ORDER BY precedenza_int DESC LIMIT 1";
  $risultq = mysql_query($queryq) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
  while ($rigaq = mysql_fetch_array($risultq)) {
	  //echo $rigaq[categoria3_it]."<br>";
  $corpo = str_replace(" ","_",$rigaq[descrizione3_it]);
  $ogiva = str_replace(" ","_",$rigaq[descrizione4_it]);
  if ($rigaq[id_valvola] != "") {
	$sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigaq[id_valvola]."'";
	$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
	while ($rigad = mysql_fetch_array($risultd)) {
		switch($rigad[descrizione3_it]) {
		  case "valvola_riduttrice":
			$valvola = "vr";
		  break;
		  case "valvola_parziale_ottone":
			$valvola = "vpo";
		  break;
		  case "valvola_parziale_cromata":
			$valvola = "vpc";
		  break;
		  case "valvola_completa_ottone":
			$valvola = "vco";
		  break;
		  case "valvola_completa_cromata":
			$valvola = "vcc";
		  break;
		  case "valvola5-8":
			$valvola = "v5-8";
		  break;
		  case "valvola_integrata_parziale":
			$valvola = "vip";
		  break;
		}
	}
  } else {
	  $valvola = "v0";
  }
  if ($rigaq[id_cappellotto] != "") {
	$cappellotto = str_replace(" ","_",$rigaq[id_cappellotto]);
  } else {
	$cappellotto = "CAP000";
  }
	  $immagine = "temp_bombole/miniature/a_".$corpo."-".$ogiva."-".$valvola."-".$cappellotto.".jpg";

echo "<a href=scheda_visuale_bombole.php?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$rigaq[categoria3_it]."&paese=".$paese."&nazione_ric=".$nazioneDaModulo."&negozio=".$negozio."&lang=".$lingua.">";
echo "<div id=riquadro_prodotto style=\"background-image:url(".$immagine.");\">";
echo "<div id=evidenziaTitolo>";
switch ($lingua) {
  case "it":
	echo str_replace("_"," ",$rigaq[categoria3_it]);
  break;
  case "en":
	echo str_replace("_"," ",$rigaq[categoria3_en]);
  break;
}
/*
*/
echo "</div>"; 
echo "<div id=riquadri_immagini_famiglia style=\"height:137px;\">";
echo "</div>"; 
echo "</div>"; 
echo "</a>";
//fine while
}
  //fine foreach
}
?>
</div>

</body>
</html>
