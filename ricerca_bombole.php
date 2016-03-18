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
/*echo "num_categoria3: ".$num_categoria3."<br>";
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

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query


$codiceDaModulo = $_GET['codice'];
$_SESSION[codice] = $_GET['codice'];
switch($lingua) {
case "it":
$categoria1_lang = "categoria1_it";
break;
case "en":
$categoria1_lang = "categoria1_en";
break;
}





//costruzione query
$testoQuery = "SELECT DISTINCT paese, foto_paese FROM qui_prodotti_assets WHERE categoria1_it = 'Bombole' ORDER BY paese ASC";

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
/*	background-color: #CCCCCC;*/
	height: 300px;
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
.riquadri_famiglia:hover {
	/*background-image: url(immagini/sfondo_consumabili.jpg);*/
	background-color: #dcedf4;
}
.riquadri_famiglia {
	border: 1px solid #999999;
	width:162px;
	height:162px;
	float: left;
	text-align: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 17px;
	font-weight: bold;
	color: #000;
	padding-left: 10px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	margin-left: 10px;
	margin-top: 10px;
}

.riquadri_famiglia_abbass {
	border: 1px solid #999999;
	width:162px;
	height:162px;
	float: left;
	text-align: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 17px;
	font-weight: bold;
	color: #000;
	padding-left: 10px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	margin-left: 10px;
	margin-top: 10px;
	opacity:0.5;
	filter:alpha(opacity=50); /* For IE8 and earlier */
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
$risultq = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
//$num_trovati = mysql_num_rows($risultq);
//echo "paesi trovati: ".$num_trovati."<br>";
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[paese] == "Italy") {
echo "<a href=ricerca_prodotti.php?categoria1=".$categoria1."&paese=".$rigaq[paese]."&negozio=".$negozio."&lang=".$lingua.">";
//echo "<div class=riquadri_famiglia style=\"background-image:url(immagini/".$rigaq[foto_paese].");background-position: bottom right;background-repeat: no-repeat;background-size:90px 90px;\">";
echo "<div class=riquadri_famiglia style=\"background-image:url(immagini/".strtolower($rigaq[paese]).".png);-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='immagini/".strtolower($rigaq[paese]).".png',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=immagini/".strtolower($rigaq[paese]).".png,sizingMethod='scale');\">";

} else {
//echo "<div class=riquadri_famiglia style=\"background-image:url(immagini/".$rigaq[foto_paese].");background-position: bottom right;background-repeat: no-repeat;background-size:90px 90px;opacity:0.5;filter:alpha(opacity=50);\">";
echo "<div class=riquadri_famiglia style=\"background-image:url(immagini/".strtolower($rigaq[paese]).".png);-ms-filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='immagini/".strtolower($rigaq[paese]).".png',sizingMethod='scale');filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=immagini/".strtolower($rigaq[paese]).".png,sizingMethod='scale');\">";
}
echo $rigaq[paese];
echo "</div>"; 
echo "</a>";
//echo "</div>"; 
//fine while
}
?>
</div>

</body>
</html>
