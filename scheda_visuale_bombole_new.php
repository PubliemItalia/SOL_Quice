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
//funzione x l'elenco della directory
/*function elencafiles($dirname){
$arrayfiles=Array();
if(file_exists($dirname)){
$handle = opendir($dirname);
while (false !== ($file = readdir($handle))) {
if(is_file($dirname.$file)){
array_push($arrayfiles,$file);
}
}
$handle = closedir($handle);
}
sort($arrayfiles);
return $arrayfiles;
}
*/
//fine funzione
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
include "traduzioni_interfaccia.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
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

$nofunz = $_GET['nofunz'];
if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}
$_SESSION[page] = $page;

if ($_GET[id] != "") {
$id = $_GET[id];
} else {
$id = $_POST[id];
}
if ($_GET[negozio] != "") {
$negozio = $_GET[negozio];
} else {
$negozio = $_POST[negozio];
}
$mode = $_GET[mode];
$descrizione1_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione1_it]));
$descrizione2_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione2_it]));
$descrizione3_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione3_it]));
$descrizione4_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione4_it]));
$descrizione1_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione1_en]));
$descrizione2_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione2_en]));
$descrizione3_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione3_en]));
$descrizione4_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione4_en]));
$immagine1_mod = $_POST[immagine1];
$immagine2_mod = $_POST[immagine2];
$immagine3_mod = $_POST[immagine3];
$immagine4_mod = $_POST[immagine4];
$immagine5_mod = $_POST[immagine5];
$modifica_prodotto = $_POST[modifica_prodotto];
$consenso = $_POST[consenso];
$confezione_mod = $_POST[confezione];
$codice = $_POST[codice];
$prezzo_mod = str_replace(",",".",$_POST[prezzo]);
$gruppo_merci_mod = $_POST[gruppo_merci];
$wbs_mod = $_POST[wbs];
$immagine1_mod = $_POST[immagine1];
$img_gallery1_rem = $_POST[img_gallery1_rem];
$img_gallery2_rem = $_POST[img_gallery2_rem];
$img_gallery3_rem = $_POST[img_gallery3_rem];
$img_gallery4_rem = $_POST[img_gallery4_rem];
//funzione x l'elenco della directory
function elencafiles($dirname){
$arrayfiles=Array();
if(file_exists($dirname)){
$handle = opendir($dirname);
while (false !== ($file = readdir($handle))) {
if(is_file($dirname.$file)){
array_push($arrayfiles,$file);
}
}
$handle = closedir($handle);
}
sort($arrayfiles);
return $arrayfiles;
}
//fine funzione
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

if ($_GET['id_valvola'] != "") {
$id_valvola = $_GET['id_valvola'];
} 

if ($_GET['paese'] != "") {
$paese = $_GET['paese'];
} 

$_SESSION[categoria1] = $_GET['categoria1'];
$_SESSION[categoria2] = $_GET['categoria2'];
$_SESSION[categoria3] = $_GET['categoria3'];
$_SESSION[categoria4] = $_GET['categoria4'];
$_SESSION[id_valvola] = $_GET['id_valvola'];
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
if ($_GET['schedaVis'] == "") {
include "menu_quice3.php";
}
if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
$_SESSION[percorso_modifica] = $_SESSION[file_ritorno]."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&paese=".$paese."&negozio=".$negozio."&lang=".$_SESSION[lang];
/*
echo "<br>var sessione negozio: ".$_SESSION[negozio]."<br>";
echo "var sessione lingua: ".$_SESSION[lang]."<br>";
echo "var sessione cat1: ".$_SESSION[categoria1]."<br>";
echo "var sessione cat2: ".$_SESSION[categoria2]."<br>";
echo "var sessione cat3: ".$_SESSION[categoria3]."<br>";
echo "var sessione id_valvola: ".$_SESSION[id_valvola]."<br>";
echo "var sessione materiale: ".$_SESSION[materiale]."<br>";
echo "var sessione capacita: ".$_SESSION[capacita]."<br>";
echo "var sessione pressione: ".$_SESSION[pressione]."<br>";
*/
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
$c = "categoria2_it = '$categoria2'";
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
$clausole++;
}
if ($categoria3 != "") {
$f = "categoria3_it = '$categoria3'";
$clausole++;
}
if ($id_valvola != "") {
	//if  ($id_valvola == "Senza_valvola") {
	//} else {
$g = "id_valvola = '$id_valvola'";
$clausole++;
	//}
}
if ($paese != "") {
$h = "paese = '$paese'";
$clausole++;
}
if (isset($_GET['materiale'])) {
$materiale = $_GET['materiale'];
} 
if ($materiale != "") {
$j = "materiale = '$materiale'";
$clausole++;
}
if (isset($_GET['pressione'])) {
$pressione = $_GET['pressione'];
} 
if ($pressione != "") {
$k = "pressione = '$pressione'";
$clausole++;
}
if (isset($_GET['capacita'])) {
$capacita = $_GET['capacita'];
} 
if ($capacita != "") {
$m = "categoria4_it = '$capacita'";
$clausole++;
}

if ($_GET['mode'] != "") {
$mode = $_GET['mode'];
$id_back = $_GET['id'];
} else {
$sqlq = "SELECT * FROM qui_prodotti_".$negozio." WHERE id_valvola = '$id_valvola'";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_prodotti_trovati = mysql_num_rows($risultq);
if ($num_prodotti_trovati == 1) {
$mode = "back";
while ($rigaq = mysql_fetch_array($risultq)) {
$id_back = $rigaq[id];
}
}
}
//echo "id_back: ".$id_back."<br>";
//costruzione query,
//switch ($negozio) {
//case "assets":
$testoQuery = "SELECT * FROM qui_prodotti_assets ";
/*break;
case "consumabili":
$testoQuery = "SELECT * FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery = "SELECT * FROM qui_prodotti_spare_parts ";
break;
case "vivistore":
$testoQuery = "SELECT * FROM qui_prodotti_vivistore ";
break;
}
*/
if ($clausole > 0) {
$testoQuery .= "WHERE obsoleto = '0' AND ";
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
if ($j != "") {
$testoQuery .= $j;
}
if ($k != "") {
$testoQuery .= $k;
}
if ($m != "") {
$testoQuery .= $m;
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
if ($j != "") {
$testoQuery .= $j." AND ";
}
if ($k != "") {
$testoQuery .= $k." AND ";
}
if ($m != "") {
$testoQuery .= $m;
}
}

}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 5; //default
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


//$testoQuery .= " ORDER BY ".$ordinamento." ".$asc_desc." LIMIT $set_limit, $limit";
$testoQuery .= " ORDER BY precedenza_int ASC";

//echo "<span style=\"color:rgb(0,0,0);\">testoQuery: ".$testoQuery."</span><br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
$_SESSION[percorso_indietro] = "scheda_visuale_bombole.php?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Quice - Prodotti</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/visual.css" />
<link href="css/lightbox3.css" rel="stylesheet" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
	margin-bottom:20px;
/*	background-color: #CCCCCC;*/
	min-height: 300px;
	overflow:hidden;
	height:auto;
}
#pulsante_invio {
	width:120px;
	padding: 10px;
	margin-left: 10px;
	height: 10px;
	background-color: #666;
	color:white;
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox3.js"></script>
<SCRIPT type="text/javascript">
function aggiorna(){
document.cercabombole.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.cercabombole.submit();
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</SCRIPT>

</head>
<?php
//if ($mode != "") {
//echo "<body onLoad=compilazione()>";
//} else {
echo "<body>";
//}
?><body onLoad="MM_preloadImages('immagini/05l_neg.png')">
<div id="main_container">

<?php
//********************************************************
//visualizzazione articolo unico con varianti a icona
//********************************************************
switch ($_SESSION[lang]) {
  case "it":
  $code = "Codice";
  $price = "Prezzo";
  $inserisci_carrello = "Inserisci nel carrello";
  $scheda_tecnica = "Scheda tecnica";
  $voce_stampa = "Stampa";
  $add_favoriti = "Aggiungi ai preferiti";
  $elim_favoriti = "Elimina dai preferiti";
  $gallery = "Galleria immagini";
  $dic_pressione = "Press. collaudo/esercizio";
  $dic_punz = "Tipo bombola";
  $dic_ricollaudo = "Revisione prima/succ.";
  $dic_col_corpo = "Colore corpo";
  $dic_col_ogiva = "Colore ogiva";
  $dic_termoretr = "Termoretraibile rosso";
  $dic_disc_med = "Disco medicale";
  $dic_bar_code = "Barcode";
  $dic_solvente = "Solvente";
  $dic_note = "Note";
  $dic_anni = "anni";
  $risp_aff = "Si";
  $risp_neg = "No";
  $bomb_compl = "Bombola completa";
break;
  case "en":
  $code = "Code";
  $price = "Price";
  $inserisci_carrello = "Add to cart";
  $scheda_tecnica = "Technical sheet";
  $voce_stampa = "Print";
  $add_favoriti = "Add to favourites";
  $elim_favoriti = "Remove from favourites";
  $gallery = "Image gallery";
  $dic_pressione = "Test/Working pressure";
  $dic_punz = "Marking";
  $dic_ricollaudo = "Test first/following";
  $dic_col_corpo = "Body colour";
  $dic_col_ogiva = "Groin colour";
  $dic_termoretr = "Red film";
  $dic_disc_med = "Med. Disc";
  $dic_bar_code = "Barcode";
  $dic_solvente = "Solvent";
  $dic_note = "Notes";
  $dic_anni = "years";
  $risp_aff = "Yes";
  $risp_neg = "No";
  $bomb_compl = "Whole cylinder";
  break;
}
//div con pulsante BACK che compare solo quando si arriva a questa pagina da una ricerca di visualizzazione
//ovvero da RICERCA, CARRELLO, PROCESSO BUYER
/*
if ($_GET['codice_art'] != "") {
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
*/
//partenza delle operazioni di query
//print_r($_SESSION);

if ($nofunz == "") {
//costruisco un array con i diversi tipi di bombola (se esistono più valvole per quel gas, potrebbero essere più di una (al di là, quindi, delle capacità)
$array_capifamiglia = array();  
$risults = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione6b" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
  if ($rigas[rif_famiglia] == $rigas[id]) {
	$add_capo = array_push($array_capifamiglia,$rigas[id]);
  }
}
/*echo "<span style=\"color:rgb(0,0,0);\">array_capifamiglia";
print_r($array_capifamiglia);
echo "</span><br>";*/

echo "<div id=risultati_bombole>";
foreach ($array_capifamiglia as $sing_capo) {
	$sqlk = "SELECT * FROM qui_prodotti_assets WHERE id = '$sing_capo'";
	$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione7" . mysql_error());
	while ($rigak = mysql_fetch_array($risultk)) {
	//per ogni tipologia di bombole costruisco il blocco delle icone dei litraggi
	$sqlm = "SELECT * FROM qui_prodotti_assets WHERE rif_famiglia = '$sing_capo' AND obsoleto = '0' ORDER BY categoria4_it ASC";
	$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigam = mysql_fetch_array($risultm)) {
		if ($rigam[id] == $sing_capo) {
	  $blocco_cat4 .= "<div class=icona_singola><img src=\"immagini/".$rigam[categoria4_it]."l_neg.png\"></div>";
		} else {
	  $blocco_cat4 .= "<div class=icona_singola style=\"cursor:pointer;\"><img src=\"immagini/".$rigam[categoria4_it]."l.png\" name=\"imm_".$rigam[categoria4_it]."l\" id=\"imm_".$rigam[categoria4_it]."l\" border=0 onMouseOver=\"MM_swapImage('/immagini/".$rigam[categoria4_it]."l','','/immagini/".$rigam[categoria4_it]."l_neg.png',1)\" onMouseOut=\"MM_swapImgRestore()\" onClick=\"compilazione(".$rigam[id].",".$rigam[rif_famiglia].")\"></div>";
	  }
	}
$punzonatura = $rigak[punz_ogiva];
$prezzo_corpo = $rigak[prezzo];
if ($rigak[categoria4_it] == 0) {
  $capacit = "0,5";
} else {
  $capacit = $rigak[categoria4_it];
}
//recupero informazioni valvola
if ($rigak[id_valvola] != "") {
  $sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_valvola]'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$prezzo_valvola = $rigam[prezzo];
	if ($rigak[id_valvola] == "Val104") {
	  $descr_valvola .= '<span style="color:#0079ca;">';
	} else {
	  $descr_valvola .= '<span style="color:#000;">';
	}
//echo "id: ".$rigak[id]."<br>";
	switch ($_SESSION[lang]) {
	  case "it":
		//$descr_valvola = $rigak[id_valvola]." ".$rigam[descrizione1_it];
		$descr_valvola .= $rigam[descrizione1_it];
	  break;
	  case "en":
		if ($rigam[descrizione1_en] != "") {
		  $descr_valvola .= $rigam[descrizione1_en];
		} else {
		  $descr_valvola .= $rigam[descrizione1_it];
		}
	  break;
	}
	$descr_valvola .= "</span>";
  if ($rigak[id_valvola] != "Val104") {
	$descr_valvola .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=Valvole&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&negozio=assets&codice_art=".$rigam[codice_art]."&lang=".$_SESSION[lang]."&id_utente=".$_SESSION[user_id]."',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});\">";
	$descr_valvola .= '<span style="color:#666; text-decoration:none; font-weight:normal; font-size:12px;">';
	  switch ($_SESSION[lang]) {
		case "it":
		  $descr_valvola .= " Scheda";
		break;
		case "en":
		  $descr_valvola .= " Sheet";
		break;
	  }
	  $descr_valvola .= "</span>";
	  $descr_valvola .= "</a>";
	}
  }
}
//recupero informazioni cappellotto
if ($rigak[id_cappellotto] != "") {
  $sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_cappellotto]'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
  while ($rigan = mysql_fetch_array($risultn)) {
	$prezzo_cappellotto = $rigan[prezzo];
	switch ($_SESSION[lang]) {
	  case "it":
		stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
	  break;
	  case "en":
		if ($rigan[descrizione1_en] != "") {
		  stripslashes($descr_cappellotto = $rigan[descrizione1_en]);
		} else {
		  stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
		}
	  break;
	}
  }
}
switch ($rigak[id_pescante]) {
	  case "":
		$prezzo_pescante = "";
	  break;
	  case "NO":
		$prezzo_pescante = "0";
	  break;
	  case "SI":
		$prezzo_pescante = "4";
	  break;
}
$prezzo_totale = $rigak[prezzo]+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante;
  switch ($_SESSION[lang]) {
	case "it":
	  $desc_bomb = $rigak[descrizione1_it];
	break;
	case "en":
	  if ($rigak[descrizione1_en] != "") {
		$desc_bomb = $rigak[descrizione1_en];
	  } else {
		$desc_bomb = $rigak[descrizione1_it];
	  }
	break;
	
  }







echo "CCC";
echo "<div class=riquadro_bombole>";
  echo "<div id=blocco_sup style=\"width:940px; height:100px; border-bottom:1px solid rgb(200,200,200);\">";
	echo "<div id=solo_descrizioni style=\"width:550px; height:auto;; float:left;\">";
	  echo "<div id=\"componente_titolo_".$rigak[rif_famiglia]."\" style=\"width:550px; height:auto;; float:left;\">";
		//descrizioni
		echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:490px; height:71px; margin-bottom:2px;\">";
		  echo $desc_bomb."<br>".$descr_valvola."<br>".$descr_cappellotto."<br>";
		  //***********************************************************
		  echo "<input type=hidden name=id".$rigak[rif_famiglia]." id=id".$rigak[rif_famiglia]." value=".$rigak[id].">";
		  //***********************************************************
		echo "</div>";
		//prezzi
		echo "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:40px; height:auto; text-align:right; font-size:12px; font-weight:normal; line-height:140%;\">";
		  echo number_format($prezzo_corpo,2,",",".")."<br>";
		  if ($rigak[id_valvola] != "") {
			  echo number_format($prezzo_valvola,2,",",".");
		  }
		  echo "<br>";
		  if ($rigak[id_cappellotto] != "") {
			echo number_format($prezzo_cappellotto,2,",",".");
		  }
	  echo "</div>"; 
	echo "</div>"; 
	  switch ($_SESSION[lang]) {
		case "it":
		  $dic_pesc_con = "Con pescante";
		  $dic_pesc_senza = "Senza pescante";
		break;
		case "en":
		  $dic_pesc_con = "With pescante";
		  $dic_pesc_senza = "Without pescante";
		break;
	  }
	  echo "<div id=\"pescante_".$rigak[rif_famiglia]."\" style=\"width:auto; height:auto; float:left;\">";
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; font-weight:normal; font-size:12px; color:rgb(0,0,0);\">";
	  		  switch ($rigak[id_pescante]) {
				  case "":
					echo $dic_pesc_senza."<input type=radio name=pescante".$rigak[id]." id=no_pesc".$rigak[id]." onClick=\"prezzo_senza_pescante(".$rigak[rif_famiglia].")\">";
					echo $dic_pesc_con."<input type=radio name=pescante".$rigak[id]." id=ok_pesc".$rigak[id]." onClick=\"prezzo_con_pescante(".$rigak[rif_famiglia].")\">";
				  break;
				  case "SI":
					echo $dic_pesc_con."<input name=pescante".$rigak[id]." type=radio id=ok_pesc".$rigak[id]." checked>";
				  break;
				  case "NO":
					echo $dic_pesc_senza."<input name=pescante".$rigak[id]." type=radio id=no_pesc".$rigak[id]." checked>";
				  break;
			  }

		echo "</div>"; 
		echo "<div id=\"componente_pescante_".$rigak[rif_famiglia]."\" class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:rgb(0,0,0); font-size:12px; font-weight:normal; line-height:140%;\">";
	if ($prezzo_pescante == "") {
		echo "0,00";
		  echo "<input name=prezzo_pescante_hidden".$rigak[rif_famiglia]." type=hidden id=prezzo_pescante_hidden".$rigak[rif_famiglia]." value=0>";
} else {
		  echo number_format($prezzo_pescante,2,",",".");
		  echo "<input name=prezzo_pescante_hidden".$rigak[rif_famiglia]." type=hidden id=prezzo_pescante_hidden".$rigak[rif_famiglia]." value=".$prezzo_pescante.">";
	}
		 
		echo "</div>";
	echo "</div>";
	//fine pescante
	echo "</div>";
	//fine componente titolo

	echo "<div id=\"componente_codice_".$rigak[rif_famiglia]."\" style=\"width:380px; height:100px; float:right;\">";
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; float:right; font-size:12px; text-align:right;\">";
		echo "<span style=\"font-weight:normal;\">".$code."</span> ";
		echo $rigak[codice_art];
	  echo "</div>"; 
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:#0079ca; float:right\">";
		echo "<span style=\"font-weight:normal;\">".$price." ".$bomb_compl."</span> ".number_format($prezzo_totale,2,",",".");
	  echo "</div>";
	  echo "<div id=componente_dati class=componente_dati_bombola style=\"margin-left:5px; width:280px; height:auto; text-align:right; float:right; margin-top:25px;\">";
		//echo "<div class=\"scritte_bottoncini_bomb\" style=\"width:130px;\">";
		  switch ($_SESSION[lang]) {
			case "it":
			$Scritta_capacity = "Capacit&agrave;";
			  echo "<strong>Costi orientativi.<br>Contattare i buyer per i prezzi aggiornati!</strong>";
			break;
			case "en":
			$Scritta_capacity = "Capacity";
			  echo "<strong>Costs may not be real.<br>Please contact buyers for updated prices!</strong>";
			break;
		  }
		//echo "</div>"; 
	  //fine div componente_dati_bombola
	  echo "</div>";
	echo "</div>";
	  //fine div componente_codice
  echo "</div>";
//fine div blocco_sup
	
  echo "<div style=\"width:530px; height:auto; float:left; margin-top:30px;\">";
	echo "<div id=\"componente_descrizione_".$rigak[rif_famiglia]."\" class=\"componente_descrizione_bombola\">";
	  echo "<div class=\"descr_famiglia_bombole\" style=\"width:340px; height:100px;\">";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_pressione;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
		  if ($rigak[pressione] == 0) {
			  echo "-";
		  } else {
			echo $rigak[pressione]." bar";
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_punz;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo $rigak[punz_ogiva];
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_ricollaudo;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo $rigak[anni_anello_scadenza]." ".$dic_anni;
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_col_corpo;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo str_replace("bidoni","",$rigak[descrizione3_it]);
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_col_ogiva;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo str_replace("bidoni","",$rigak[descrizione4_it]);
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	  echo "<div class=\"descr_famiglia_bombole\" style=\"margin-left:10px; width:185px; height:100px;\">";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_termoretr;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigak[termoretr_rosso]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_disc_med;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigak[disc_medicale]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_bar_code;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigak[barcode]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_solvente;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
			echo $rigak[solvente];
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	//fine div componente_descrizione_bombola
	echo "</div>";
	echo "<div id=componente_iconcine_".$rigak[rif_famiglia]." style=\"float:left; width:530px; margin-top:35px;\">";
	  echo "<div class=\"descr_famiglia\" style=\"width:525px;\">";
		echo "<strong>".$Scritta_capacity." ".$capacit." l";
		if ($rigak[capac_kg] > 0) {
			echo " (".$rigak[capac_kg]." kg)</strong>";
		}
	  echo "</div>";
	  echo $blocco_cat4;
	echo "</div>";
  //fine div raggruppamento
  echo "</div>";
  $blocco_cat4 = "";	
  $desc_bomb = ""; 
  $descr_valvola = "";
  $descr_cappellotto = "";
  //$prezzo_pescante = "";
  $prezzo_valvola = "";
  $prezzo_cappellotto = "";
  $prezzo_corpo = "";
  $punzonatura = "";
  
// preparazione dei componenti dell'immagine
$immagine_corpo = 'componenti/bombole/'.str_replace(" ","_",$rigak[descrizione3_it]).'.png';
$immagine_ogiva = 'componenti/ogiva/'.str_replace(" ","_",$rigak[descrizione4_it]).'.png';
if ($rigak[id_valvola] != "") {
  $sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigak[id_valvola]."'";
  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigad = mysql_fetch_array($risultd)) {
	  switch($rigad[descrizione3_it]) {
		case "valvola_riduttrice":
		  $immagine_valvola = 'componenti/valvola/valvola_viproxy.png';
		break;
		case "valvola_parziale_ottone":
		  $immagine_valvola = 'componenti/valvola/valvola_parziale_ottone.png';
		break;
		case "valvola_parziale_cromata":
		  $immagine_valvola = 'componenti/valvola/valvola_parziale_cromata.png';
		break;
		case "valvola_completa_ottone":
		  $immagine_valvola = 'componenti/valvola/valvola_completa_ottone.png';
		break;
		case "valvola_completa_cromata":
		  $immagine_valvola = 'componenti/valvola/valvola_completa_cromata.png';
		break;
		case "valvola5-8":
		  $immagine_valvola = 'componenti/valvola/valvola5-8.png';
		break;
		case "valvola_integrata_parziale":
		  $immagine_valvola = 'componenti/valvola/valvola_integrata_parziale.png';
		break;
	  }
  	$sost_img_valv = '<img src='.$immagine_valvola.' width=248 height=248>';
  }
} else {
  	$sost_img_valv = '';
}
//$valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$rigak[id_valvola]).".png");
if ($rigak[id_cappellotto] != "") {
$immagine_cappellotto = 'componenti/cappellotto/'.str_replace(" ","_",$rigak[id_cappellotto]).'.png';
}


/*
*/
$corpo = str_replace(" ","_",$rigak[descrizione3_it]);
$ogiva = str_replace(" ","_",$rigak[descrizione4_it]);
if ($rigak[id_valvola] != "") {
  $sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigak[id_valvola]."'";
  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
if ($rigak[id_cappellotto] != "") {
  $cappellotto = str_replace(" ","_",$rigak[id_cappellotto]);
  	$sost_img_capp = '<img src='.$immagine_cappellotto.' width=248 height=248>';
} else {
  $cappellotto = "CAP000";
  $sost_img_capp = '';
}
	//echo "<img src=componenti/bombole/RAL_5021.png width=248 height=248>";
//echo "<img src=temp_bombole/".$img_bombola." width=248 height=248>";
//	echo "<img src=componenti/ogiva/RAL_6018.png width=248 height=248>";
//	echo "<img src=componenti/valvola/Val020.png width=248 height=248>";
//	echo "<img src=componenti/cappellotto/CAP005.png width=248 height=248>";
echo '
<div id="componente_immagine_'.$rigak[rif_famiglia].'" class="componente_immagine_bombola" style="margin-top:10px; position: absolute; margin-left: 539px;">
  <div id="layer_corpo_'.$rigak[rif_famiglia].'" style="position: absolute; width:248px; height:248px; z-index:5;">
	<img src='.$immagine_corpo.' width=248 height=248>
  </div>
  <div id="layer_ogiva_'.$rigak[rif_famiglia].'" style="position: absolute; width:248px; height:248px; z-index:7;">
	<img src='.$immagine_ogiva.' width=248 height=248>
  </div>
  <div id="layer_valvola_'.$rigak[rif_famiglia].'" style="position: absolute; width:248px; height:248px; z-index:9; margin-top: 0px;">
	'.$sost_img_valv.'
  </div>
  <div id="layer_cap_'.$rigak[rif_famiglia].'" style="position: absolute; width:248px; height:248px; z-index:9;">
	'.$sost_img_capp.'
  </div>
</div>
';
$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
$img_bombola = "";
		//componente bottoni
		echo '<div id="componente_bottoni_'.$rigak[rif_famiglia].'" class="componente_bottoni_bombole" style="float: right; margin-right: 33px;">';
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		$nome_gruppo = mt_rand(1000,9999);
		//operazioni di costruzione della gallery
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigak[codice_art]' ORDER BY precedenza ASC";
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
		//fine  costruzione gallery
		echo "</div>"; 
		echo "<div class=comandi>";

		if ($rigak[percorso_pdf] != "") {
			echo "<a href=documenti/".$rigak[percorso_pdf]." target=_blank>";
		  echo "<span class=pulsante_scheda style=\"text-decoration:none;\">".$scheda_tecnica."</span>";
		  echo "</a>";
		}
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigak[id]."&negozio_prod=".$rigak[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>".$elim_favoriti."</span>";
			} else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>".$add_favoriti."</span>";
			}
		echo "</div>"; 
		echo "</a>";
		echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$rigak[negozio]."&id=".$rigak[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		echo "<div class=comandi>";
		echo "<span class=pulsante_stampa>".$voce_stampa."</span>";
		echo "</div>"; 
		echo "</a>";
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		echo "<div class=comandi>";
		echo "</div>"; 
	
	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 
//echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";


				switch ($_SESSION[lang]) {
				  case "it":
				  $scritta_puls = "Scegli quantit&agrave;";
				  break;
				  case "en":
				  $scritta_puls = "Choose quantity";
				  break;
				}

echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigak[negozio]."&prezzo_pescante=".$prezzo_pescante."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless3',width:540,height:500,fixed:false,maskid:'bluemask',maskopacity:40});\"><div class=pulsante_carrello title=\"$scritta_puls\">";
//echo "id: ".$rigak[id]."<br>";
		  echo $scritta_puls;
		  echo "</div></a>";
		//fine div componente_bottoni
		echo "</div>"; 
		//fine div riquadro_prodotto
		echo "</div>"; 
//fine while generale
		}
}
echo "</div>"; 

} else {
	
	
	
	
	
	
	
//layout x visualizzazione in tinybox
$queryk = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$_GET[codice_art]'";
$risultk = mysql_query($queryk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
 //recupero informazioni valvola
if ($rigak[id_valvola] != "") {
  $sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_valvola]'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$prezzo_valvola = $rigam[prezzo];
//echo "id: ".$rigak[id]."<br>";
	switch ($_SESSION[lang]) {
	  case "it":
		//$descr_valvola = $rigak[id_valvola]." ".$rigam[descrizione1_it];
		$descr_valvola .= $rigam[descrizione1_it];
	  break;
	  case "en":
		if ($rigam[descrizione1_en] != "") {
		  $descr_valvola .= $rigam[descrizione1_en];
		} else {
		  $descr_valvola .= $rigam[descrizione1_it];
		}
	  break;
	}
	
  }
}
//recupero informazioni cappellotto
if ($rigak[id_cappellotto] != "") {
  $sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_cappellotto]'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
  while ($rigan = mysql_fetch_array($risultn)) {
	$prezzo_cappellotto = $rigan[prezzo];
	switch ($_SESSION[lang]) {
	  case "it":
		stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
	  break;
	  case "en":
		if ($rigan[descrizione1_en] != "") {
		  stripslashes($descr_cappellotto = $rigan[descrizione1_en]);
		} else {
		  stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
		}
	  break;
	}
  }
}
$prezzo_totale = $rigak[prezzo]+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante;
  switch ($_SESSION[lang]) {
	case "it":
	  $desc_bomb = $rigak[descrizione1_it];
	break;
	case "en":
	  if ($rigak[descrizione1_en] != "") {
		$desc_bomb = $rigak[descrizione1_en];
	  } else {
		$desc_bomb = $rigak[descrizione1_it];
	  }
	break;
	
  }
//echo "HHH";
echo "<div class=riquadro_bombole>";
  echo "<div id=blocco_sup style=\"width:940px; height:100px; border-bottom:1px solid rgb(200,200,200);\">";
	echo "<div id=solo_descrizioni style=\"width:550px; height:auto;; float:left;\">";
	  echo "<div id=\"componente_titolo_".$rigak[rif_famiglia]."\" style=\"width:550px; height:auto;; float:left;\">";
		//descrizioni
		echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:490px; height:71px; margin-bottom:2px;\">";
		  echo $desc_bomb."<br>".$descr_valvola."<br>".$descr_cappellotto."<br>";
		  //***********************************************************
		  echo "<input type=hidden name=id".$rigak[rif_famiglia]." id=id".$rigak[rif_famiglia]." value=".$rigak[id].">";
		  //***********************************************************
		echo "</div>";
		//prezzi
		echo "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:40px; height:auto; text-align:right; font-size:12px; font-weight:normal; line-height:140%;\">";
		  echo number_format($rigak[prezzo],2,",",".")."<br>";
		  if ($rigak[id_valvola] != "") {
			  echo number_format($prezzo_valvola,2,",",".");
		  }
		  echo "<br>";
		  if ($rigak[id_cappellotto] != "") {
			echo number_format($prezzo_cappellotto,2,",",".");
		  }
	  echo "</div>"; 
	echo "</div>"; 
	  switch ($_SESSION[lang]) {
		case "it":
		  $dic_pesc_con = "Con pescante";
		  $dic_pesc_senza = "Senza pescante";
		break;
		case "en":
		  $dic_pesc_con = "With pescante";
		  $dic_pesc_senza = "Without pescante";
		break;
	  }
	  echo "<div id=\"pescante_".$rigak[rif_famiglia]."\" style=\"width:auto; height:auto; float:left;\">";
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; font-weight:normal; font-size:12px; color:rgb(0,0,0);\">";
		  echo $dic_pesc_senza."<input type=radio name=pescante".$rigak[id]." id=no_pesc".$rigak[id]." onClick=\"prezzo_senza_pescante(".$rigak[rif_famiglia].")\">";
		  echo $dic_pesc_con."<input type=radio name=pescante".$rigak[id]." id=ok_pesc".$rigak[id]." onClick=\"prezzo_con_pescante(".$rigak[rif_famiglia].")\">";
		echo "</div>"; 
		echo "<div id=\"componente_pescante_".$rigak[rif_famiglia]."\" class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:rgb(0,0,0); font-size:12px; font-weight:normal; line-height:140%;\">";
		  echo number_format($prezzo_pescante,2,",",".");
		  echo "<input name=prezzo_pescante_hidden".$rigak[rif_famiglia]." type=hidden id=prezzo_pescante_hidden".$rigak[rif_famiglia]." value=0>";
		echo "</div>";
	echo "</div>";
	//fine pescante
	echo "</div>";
	//fine componente titolo

	echo "<div id=\"componente_codice_".$rigak[rif_famiglia]."\" style=\"width:380px; height:100px; float:right;\">";
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; float:right; font-size:12px; text-align:right;\">";
		echo "<span style=\"font-weight:normal;\">".$code."</span> ";
		echo $rigak[codice_art];
	  echo "</div>"; 
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:#0079ca; float:right\">";
		echo "<span style=\"font-weight:normal;\">".$price." ".$bomb_compl."</span> ".number_format($prezzo_totale,2,",",".");
	  echo "</div>";
	  echo "<div id=componente_dati class=componente_dati_bombola style=\"margin-left:5px; width:340px; height:auto; text-align:right; float:right; margin-top:25px; font-family:Arial;\">";
		//echo "<div class=\"scritte_bottoncini_bomb\" style=\"width:130px;\">";
		  switch ($_SESSION[lang]) {
			case "it":
			  echo "<strong>Costi orientativi.<br>Contattare i buyer per i prezzi aggiornati!</strong>";
			break;
			case "en":
			  echo "<strong>Costs may not be real.<br>Please contact buyers for updated prices!</strong>";
			break;
		  }
		//echo "</div>"; 
	  //fine div componente_dati_bombola
	  echo "</div>";
	echo "</div>";
	  //fine div componente_codice
  echo "</div>";
//fine div blocco_sup
	
  echo "<div style=\"width:530px; height:auto; float:left; margin-top:30px;\">";
	echo "<div id=\"componente_descrizione_".$rigak[rif_famiglia]."\" class=\"componente_descrizione_bombola\">";
	  echo "<div class=\"descr_famiglia_bombole\" style=\"width:340px; height:100px;\">";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_pressione;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
		  if ($rigak[pressione] == 0) {
			  echo "-";
		  } else {
			echo $rigak[pressione]." bar";
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_punz;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo $rigak[punz_ogiva];
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_ricollaudo;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo $rigak[anni_anello_scadenza]." ".$dic_anni;
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_col_corpo;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo str_replace("bidoni","",$rigak[descrizione3_it]);
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_col_ogiva;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo str_replace("bidoni","",$rigak[descrizione4_it]);
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	  echo "<div class=\"descr_famiglia_bombole\" style=\"margin-left:10px; width:185px; height:100px;\">";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_termoretr;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigak[termoretr_rosso]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_disc_med;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigak[disc_medicale]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_bar_code;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigak[barcode]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_solvente;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
			echo $rigak[solvente];
		  echo "</div>";
		echo "</div>";
		//if ($rigak[note] != "") {
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_note;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
			echo stripslashes($rigak[note]);
		  echo "</div>";
		echo "</div>";
		//  }
	  echo "</div>";
	//fine div componente_descrizione_bombola
	echo "</div>";
	echo "<div id=componente_iconcine_".$rigak[rif_famiglia]." style=\"float:left; width:530px; margin-top:35px;\">";
	  echo "<div class=\"descr_famiglia\" style=\"width:525px;\">";
	  echo "</div>";
	echo "</div>";
  //fine div raggruppamento
  echo "</div>";
  $blocco_cat4 = "";	
  $desc_bomb = ""; 
  $descr_valvola = "";
  $descr_cappellotto = "";
  //$prezzo_pescante = "";
  $prezzo_valvola = "";
  $prezzo_cappellotto = "";
  $prezzo_corpo = "";
  $punzonatura = "";
  
/*
// Read the image
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$rigak[descrizione3_it]).".png");
$ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$rigak[descrizione4_it]).".png");
if ($rigak[id_valvola] != "") {
  $sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigak[id_valvola]."'";
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
//$valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$rigak[id_valvola]).".png");
if ($rigak[id_cappellotto] != "") {
$cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$rigak[id_cappellotto]).".png");
}

// Clone the image and flip it 
$bombola = $corpo->clone();

// Composite i pezzi successivi sopra il fondo in questo ordine 
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
if ($rigak[id_valvola] != "") {
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
}
if ($rigak[id_cappellotto] != "") {
$bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
}
$timecode= date("dmYHis",time());
$nomefile = "temp_bombole/".$timecode."_".$rigak[codice_art].".png";
$bombola->writeImage($nomefile);

$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
*/
$corpo = str_replace(" ","_",$rigak[descrizione3_it]);
$ogiva = str_replace(" ","_",$rigak[descrizione4_it]);
if ($rigak[id_valvola] != "") {
  $sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigak[id_valvola]."'";
  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
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
if ($rigak[id_cappellotto] != "") {
  $cappellotto = str_replace(" ","_",$rigak[id_cappellotto]);
} else {
  $cappellotto = "CAP000";
}
$img_bombola = $corpo."-".$ogiva."-".$valvola."-".$cappellotto.".png";
echo "<div id=componente_immagine_".$rigak[rif_famiglia]." class=\"componente_immagine_bombola\" style=\"margin-top:10px;\">";
echo "<img src=temp_bombole/".$img_bombola." width=248 height=248>";
echo "</div>";
$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
$img_bombola = "";
//componente bottoni
		echo "<div class=\"componente_bottoni_bombole\">";
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		echo "<div class=comandi>";
		echo "</div>"; 
	
	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 



		//fine div componente_bottoni
		echo "</div>"; 
		//fine div riquadro_prodotto
		echo "</div>"; 
		//fine while
}
		//fine if nofunz
}


?>
<script type="text/javascript">
function compilazione(id,famiglia){
var prezzo_pescante = document.getElementById('prezzo_pescante_hidden'+famiglia).value;
						/*alert(id+","+famiglia);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_codice_'+famiglia).html(output).show();
						}
						});
/*				$.ajax({
						type: "GET",   
						url: "aggiorna_descr_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_descrizione_'+famiglia).html(output).show();
						}
						});
*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_titolo_bomb.php",   
						data: "id="+id+"&famiglia="+famiglia+"&negozio=assets"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_titolo_'+famiglia).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&prezzo_pescante="+prezzo_pescante+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni_'+famiglia).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_icone_bomb.php",   
						data: "famiglia="+famiglia+"&id="+id+"&negozio=assets"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_iconcine_'+famiglia).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_pescante_bomb.php",   
						data: "id="+id+"&famiglia="+famiglia+"&negozio=assets"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#pescante_'+famiglia).html(output).show();
						}
						});
}
function controllo_pescante(id){
var ok_pescante = document.getElementById('ok_pesc'+id);
var no_pescante = document.getElementById('no_pesc'+id);
		/*	alert('pescante'+id);*/
	if ((ok_pescante.checked) || (no_pescante.checked)) {
		return true;
	} else {
	  alert("Attenzione! Scegliere se corredare la bombola di pescante!");
		return false;
	}
		return true;
			

}
function prezzo_con_pescante(rif_famiglia){
$("#componente_pescante_"+rif_famiglia).html("4,00<input name=prezzo_pescante_hidden"+rif_famiglia+" type=hidden id=prezzo_pescante_hidden"+rif_famiglia+" value=4>");
	var id = document.getElementById('id'+rif_famiglia).value;
	var prezzo_pescante = "4";
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&prezzo_pescante="+prezzo_pescante+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_codice_'+rif_famiglia).html(output).show();
						}
						});
						/*alert(id);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&prezzo_pescante="+prezzo_pescante+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni_'+rif_famiglia).html(output).show();
						}
						});
}
function prezzo_senza_pescante(rif_famiglia){
$("#componente_pescante_"+rif_famiglia).html("0,00<input name=prezzo_pescante_hidden"+rif_famiglia+" type=hidden id=prezzo_pescante_hidden"+rif_famiglia+" value=0>");
	var id = document.getElementById('id'+rif_famiglia).value;
	var prezzo_pescante = "0";
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&prezzo_pescante="+prezzo_pescante+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_codice_'+rif_famiglia).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni_bomb.php",   
						data: "id="+id+"&negozio=assets"+"&prezzo_pescante="+prezzo_pescante+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni_'+rif_famiglia).html(output).show();
						}
						});
}

 function processa_bombola(percorso) {
	 alert (percorso);
window.parent.TINY.box.hide();
window.parent.location.href = percorso;
}
function selezione_bombole(){
	var mat = document.getElementById('materiale').value;
	var cap = document.getElementById('capacita').value;
	var dia = document.getElementById('pressione').value;
						/*alert(mat);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_lista_bombole.php",   
						data: "pressione="+dia+"&capacita="+cap+"&materiale="+mat,
						success: function(output) {
						$('#risultati_bombole').html(output).show();
						}
						});
}
function closeJS(){
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
}
</SCRIPT>

<script type="text/javascript" src="tinybox.js"></script>

</div>
</body>
</html>
