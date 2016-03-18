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
//echo 'Max Life = ' . ini_get('session.gc_maxlifetime') . "<br>";
//echo 'user_id = ' . $_SESSION[user_id] . "<br>";
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
if ($_GET[conferma] != "") {
$_SESSION[carrello] = "";
}
if (isset($_GET[id_cart])) {
$_SESSION[carrello] = $_GET[id_cart];
}
$lingua = $_SESSION[lang];
$carrello = $_SESSION[carrello];
if (isset($_GET['negozio'])) {
$negozio = $_GET['negozio'];
//$_SESSION[negozio] = $_GET['negozio'];
} 
//echo "lingua: ".$lingua."<br>";
$a = $_GET[a];
include "query.php";
include "functions.php";
$azione_form = $_SERVER['PHP_SELF'];
$_SESSION[percorso_ritorno] ="carrello.php?a=1&negozio=carrello&id_cart=".$carrello;

//se arrivo dal pulsante del menu
if ($a == 1) {
$query = "UPDATE qui_righe_carrelli SET quant_modifica = '' WHERE id_carrello = '$carrello'";
if (mysql_query($query)) {
	//output finale
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
//variabili di paginazione
if (isset($_GET['limit'])) {
$limit = $_GET['limit'];
} else {
$limit = $_POST['limit'];
}
if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}
$modifica_quant = $_GET['modifica_quant'];
$quant = str_replace(",",".",$_GET['quant']);
$id_riga = $_GET['id_riga'];
$id_prodotto = $_GET['id_prodotto'];

$apertura_scheda = $_GET['apertura_scheda'];
$textarea = levapar6($_GET['textarea']);
$conferma = $_GET['conferma'];
$conferma_nota = $_GET['conferma_nota'];

if ($conferma_nota != "") {
$query = "UPDATE qui_carrelli SET note = '$textarea' WHERE id = '$carrello'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
mysql_set_charset("utf8"); //settare la codifica della connessione al db

//include "testata.php";
include "menu_quice3.php";
echo "<br>";
if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[nazione_ric] = "";
$_SESSION[descrizione] = "";
//$_SESSION[negozio] = "";
$_SESSION[categoria] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";

if ($_GET['modifica_quant'] != "") {
switch ($_SESSION[tipo_carrello]) {
case "assets":
$queryb = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$queryb = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
case "labels":
$queryb = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prodotto'";
break;
case "vivistore":
$queryb = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto'";
break;
}
$resultb = mysql_query($queryb) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowb = mysql_fetch_array($resultb)) {
$prezzo_aggiornato = $rowb[prezzo];
}
$totale_aggiornato = $prezzo_aggiornato *$quant;
$query = "UPDATE qui_righe_carrelli SET quant = '$quant', totale = '$totale_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
//echo "aggiornato prezzo<br>";
$ok_modifica = 1;
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_GET['ordinamento'] != "") {
$ordinamento = $_GET['ordinamento'];
} else {
$ordinamento = "data_inserimento ASC";
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
$queryb = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
$total_items = mysql_num_rows($resultb);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);

/*echo "user id: ".$_SESSION[user_id]."<br>";
echo "total_items: ".$total_items."<br>";
echo "total_pages: ".$total_pages."<br>";
echo "set_limit: ".$set_limit."<br>";
*/

$queryc = "SELECT * FROM qui_carrelli WHERE id = '$carrello'";
$resultc = mysql_query($queryc) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rowc = mysql_fetch_array($resultc)) {
$carrello_attivo = $rowc[attivo];
$carrello_ordinato = $rowc[ordine];
$note = stripslashes($rowc[note]);
$note = str_replace("<br>","\n",$note);
$data_ordine = date("d.m.Y H:i",$rowc[data_ultima_modifica]);
}
?>
<html>
<head>
<title>Quice - Carrello</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
<!--
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
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.btn{
	padding-top:10px;
}
.btn1{
	padding-top:0px;
}
.casella_input {
	font-size: 10px;
	font-family: Arial, Helvetica, sans-serif;
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
#columns_totale {
	width: 960px;
	background: #FFFFCC;
	height:25px;
}
.libero {
	width: 960px;
	height:auto;
	float: left;
}
#columns_testata {
	color: #FFFFFF;
	width: 960px;
	height: 25px;
	background-color: #8e8e8e;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
#riga_totale {
	color: black;
	width: 960px;
	height: 25px;
	background-color: #CCC;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	margin-top: 10px;
	float:left;
}
.columns_righe1 {
	color: black;
	width: 960px;
	height: auto;
	float:left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #F0F0F0;
}
.columns_righe2 {
	color: black;
	width: 960px;
	height: auto;
	float:left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background: #fff;
}
.columns_righe1:hover {
	background: #b8e3f6;
}
.columns_righe2:hover {
	background: #b8e3f6;
}
#columns0 {
	width: 960px;
	background: #fff;
	height:25px;
}
#columns1 {
	width: 960px;
	background:#F0F0F0;
	height:25px;
}
.cod1 {
	padding-left: 10px;
	color: #FFFFFF;
	width: 85px;
	height: 20px;
	float: left;
	padding-top: 4px;
}
.cod1 a {
	color: #FFFFFF;
}
.cod1_riga {
	padding-left: 10px;
	color: black;
	width: 85px;
	height: 20px;
	float: left;
	padding-top: 3px;
}
.cod1_riga_quant {
	padding-left: 10px;
	color: black;
	width: 85px;
	height: 20px;
	float: left;
	padding-top: 2px;
}
.descr4 {
	float: left;
	width: 290px;
	height:20px;
	padding-left: 10px;
	padding-top: 4px;
}
.descr4 a {
	color: #FFFFFF;
}
.descr4_riga {
	float: left;
	width: 290px;
	height:auto;
	padding-left: 10px;
	padding-top: 2px;
	margin-bottom:2px;
}
#confez5 {
	float: left;
	width: 70px;
	height:20px;
	padding-left: 10px;
	padding-top: 4px;
}
#confez5_riga {
	float: left;
	width: 70px;
	height:20px;
	padding-left: 10px;
	padding-top: 7px;
}
#confez5 a {
	color: #FFFFFF;
}
.price6 {
	color: #FFFFFF;
	width: 70px;
	height: 20px;
	float: left;
	padding-top: 4px;
	padding-right: 25px;
	text-align: right;
}
.price6_riga {
	color: black;
	width: 70px;
	height: 20px;
	float: left;
	padding-top: 7px;
	padding-right: 25px;
	text-align: right;
}
.price6_riga_quant {
	color: black;
	width: 70px;
	height: 20px;
	float: left;
	padding-top: 4px;
	padding-right: 25px;
	text-align: right;
}
.tx_totale {
	color: black;
	width: 720px;
	height: 20px;
	float: left;
	padding-top: 7px;
	padding-right: 45px;
	text-align: right;
}
.vuoto9 {
	float: left;
	width: 52px;
	height:20px;
	padding-top: 4px;
}
.vuoto9_riga {
	float: left;
	width: 52px;
	height:20px;
	padding-top: 4px;
}

-->
</style>

	<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<?php include "funzioni.js"; ?>
<script type="text/javascript">
function aggiorna(){
document.form_lingua.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_lingua.submit();
}
</script>
<script type="text/javascript">
function addDB(){
document.forms["login"].submit();
}
</script>
<script type="text/javascript">
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
location.href = "carrello.php?negozio=carrello&id_cart=<?php echo $carrello; ?>";
}
</SCRIPT>
</head>
<?php
  $queryb = "SELECT SUM(totale) as somma FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_carrello = $somma;
echo 'totale_carrello: '.intval($totale_carrello).'<br>';
if ((intval($totale_carrello) > 0) && (intval($totale_carrello) <= 30)) {
echo '<body onLoad="TINY.box.show({iframe:\'avviso.php?avviso=troppo_poco\',boxid:\'frameless\',width:400,height:180,fixed:false,maskid:\'bluemask\',maskopacity:40})">';
  //echo '<body onLoad="window.open(\'avviso.php?avviso=troppo_poco\',\'Avviso\', \'height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350\')">';
  //echo '<body onLoad="attention()">';
} else {
  if ($_GET['modifica_quant']!= "") {
	echo "<body onLoad=window.open('popup_notifica.php?avviso=mod_carrello','Conferma modifica carrello', 'height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
  } else {
	echo "<body onLoad=aggiornaTotale()>";
  }
}

?>
<!--inizio contenitore generale-->
<div id="main_container">
<!--inizio contenitore testata-->
<div id="columns_testata">
<!--div codice testata-->
<div class="cod1">
<?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&ordinamento=codice_art&";
	if ($ordinamento == "codice_art") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_codice;
	if ($ordinamento == "codice_art") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
 <!--fine div codice testata-->
</div>
<!--div nazione testata-->
<div class="cod1">
<?php echo $testata_nazione; ?>
 <!--fine div nazione testata-->
</div>
<!--div descrizione testata-->
<div class="descr4">
    <?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&ordinamento=descrizione_it&";
	if ($ordinamento == "descrizione_it") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_descrizione;
	if ($ordinamento == "descrizione_it") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
 <!--fine div descrizione testata-->
</div>
<!--div confezione testata-->
<div id="confez5" style="width:50px;">
     <?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&ordinamento=confezione&";
	if ($ordinamento == "tipo") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_imballo;
	if ($ordinamento == "tipo") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
 <!--fine div confezione testata-->
</div>
<!--div prezzo testata-->
<div class="price6" style="width:60px;">
    <?php echo $testata_prezzo; ?> &euro;
 <!--fine div prezzo testata-->
</div>
<!--div quant testata-->
<div class="price6" style="width:50px;">
    <?php echo $testata_quant; ?>
 <!--fine div quant testata-->
</div>
<!--div avvisi testata-->
<div class="price6" style="width:50px; padding-right:5px;">
 <!--fine div avvisi testata-->
 
</div>
<!--div totale testata-->
<div class="price6">
    <?php echo $testata_totale; ?> &euro;
 <!--fine div totale testata-->
</div>

<!--div elimina testata (vuoto)-->
<div class="vuoto9">
 <!--fine div elimina testata-->
</div>
<!--fine contenitore testata-->
</div>



  <?php
  if ($carrello != "") {
	  $array_negozi_update = array("labels","assets");
 if ($carrello_attivo == 1) {
 $tot = 1;
  //script di aggiornamento
 $queryc = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0' ORDER BY ".$ordinamento;
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$id_riga = $rowc[id];
$id_prod_riga = $rowc[id_prodotto];
$quant_riga = $rowc[quant];
$negozio_riga = $rowc[negozio];
switch ($negozio_riga) {
case "assets":
$queryv = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prod_riga'";
break;
case "consumabili":
$queryv = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod_riga'";
break;
case "spare_parts":
$queryv = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prod_riga'";
break;
case "labels":
$queryv = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prod_riga'";
break;
case "vivistore":
$queryv = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prod_riga'";
break;
}

$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
$prezzo_riga = $rowv[prezzo];
}
$totale_prodotto_riga_aggiornato = $quant_riga*$prezzo_riga;
if (($rowc[negozio] == "labels") OR ($rowc[categoria] == "Bombole")) {
} else {
$query = "UPDATE qui_righe_carrelli SET prezzo = '$prezzo_riga', totale = '$totale_prodotto_riga_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
} 
//}
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0' ORDER BY ".$ordinamento;
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
$id_prodotto_attuale = $row[id_prodotto];
switch ($negozio_riga) {
case "assets":
$queryh = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto_attuale'";
break;
case "consumabili":
$queryh = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto_attuale'";
break;
case "spare_parts":
$queryh = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto_attuale'";
break;
case "labels":
$queryh = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prodotto_attuale'";
break;
case "vivistore":
$queryh = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto_attuale'";
break;
}
$resulth = mysql_query($queryh) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowh = mysql_fetch_array($resulth)) {
$codice_art = $rowh[codice_art];
switch($lingua) {
case "it":
$descr_prod = $rowh[descrizione1_it];
break;
case "en":
$descr_prod = $rowh[descrizione1_en];
$descr_ita = $rowh[descrizione1_it];
break;
case "fr":
$descr_prod = $rowh[descrizione_fr];
break;
case "de":
$descr_prod = $rowh[descrizione_de];
break;
case "es":
$descr_prod = $rowh[descrizione_es];
break;
}
$array_negozi = array("labels", "assets");
if (in_array($negozio_riga, $array_negozi)) {
  if ($negozio_riga == "labels") {
	switch($lingua) {
	  case "it":
		$descr_prod .= " - ".str_replace("_"," ",$rowh[categoria4_it]);
	  break;
	  case "en":
		$descr_prod .= " - ".str_replace("_"," ",$rowh[categoria4_en]);
	  break;
	}
	$descr_ita .= " - ".str_replace("_"," ",$rowh[categoria4_it]);
   }
  if ($negozio_riga == "assets") {
	$descr_prod .= str_replace("_"," ",$row[descrizione]);
	$descr_ita .= str_replace("_"," ",$row[descrizione]);
   }
}
$paese = $rowh[paese];
$confezione = $rowh[confezione];
$um = $rowh[um];
$tipo = $rowh[tipo];
$prezzo = $rowh[prezzo];
}
//echo "<form name=carrello method=get action=carrello.php#".$row[id].">";
echo "<form name=carrello method=get action=carrello.php>";


if ($sf == 1) {
//inizio contenitore riga
echo "<div class=columns_righe1>";
} else {
echo "<div class=columns_righe2>";
}



//div codice riga
echo "<div class=cod1_riga>";
if (substr($codice_art,0,1) != "*") {
  echo $codice_art;
} else {
  echo substr($codice_art,1);
}
//fine div codice riga
echo "</div>";
//div nazione riga
echo "<div class=cod1_riga>";
echo str_replace("_"," ",$paese);
//fine div nazione riga
echo "</div>";
//div descrizione riga
echo "<div class=descr4_riga>";
if (strlen($descr_prod) < 3) {
echo $descr_ita." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
$descr_ita = "";
//fine div descrizione riga
echo "</div>";
//div confezione riga
echo "<div id=confez5_riga style=\"width:50px;\">";
if ($negozio_riga != "labels") {
echo $confezione;
echo '<input type="hidden" name="conf_'.$row[id].'" id="conf_'.$row[id].'" value="'.$confezione.'">';
echo '<input type="hidden" name="um_'.$row[id].'" id="um_'.$row[id].'" value="'.$um.'">';
}
//fine div confezione riga
echo "</div>";
//div prezzo riga
echo "<div class=price6_riga style=\"width:60px;\">";
if ($row[negozio] != "labels") {
	if (($row[negozio] == "assets") AND ($row[categoria] == "Bombole")) {
	  echo number_format($row[prezzo],2,",","");
	} else {
	  echo number_format($prezzo,2,",","");
	}
}
//fine div prezzo riga
echo "</div>";
$array_esclusioni = array("Bombole");
if ($conferma != "") {
//div quant riga
echo "<div class=price6_riga style=\"width:50px;\">";
echo number_format($row[quant],0,",","");
} else {
//echo "<input name=quant type=text class=tabelle8 id=quant size=5 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" onBlur=\"this.form.submit()\" value=".number_format($row[quant],0,",","").">";
if ($row[negozio] == "labels") {
echo "<div class=price6_riga_quant style=\"width:50px; text-align:right; padding-right:5px; padding-top:7px;\" id=q_".$tot.">";
} else {
echo "<div class=price6_riga_quant style=\"width:50px; text-align:right; padding-right:5px;\" id=q_".$tot.">";
}
//se si tratta del negozio labels visualizzo la quantità senza farla modificare
  if ($row[negozio] == "labels") {
	echo number_format($row[quant],0,",","");
  } else {
  //per tutti gli altri negozi ulteriore distinzione in base alla categoria di appartenenza del prodotto
  //se la categoria del prodotto non è presente nell'array_esclusioni impostato sopra, do la possibilità di modificare la quantità
	if (!in_array($row[categoria],$array_esclusioni)) {
	  echo "<input name=".$tot." type=text class=casella_input id=c_".$tot." size=4 maxlength=4 onkeypress = \"return ctrl_solo_num(event);\" onKeyUp=\"axc(".$row[id].",this.value,".$tot.");\" onBlur=\"ripristinaquantriga(".$row[id].",".$tot.")\"";
	  if ($row[quant_modifica] != "") {
		echo " value=".number_format($row[quant_modifica],0,",","");
	  } else {
		echo " value=".number_format($row[quant],0,",","");
	  }
	  echo ">";
	} else {
  //se invece la categoria del prodotto è presente nell'array_esclusioni impostato sopra, la quantità è solo visualizzata
  //esempio tipico: bombole; non posso modificare la quantità in quanto il calcolo del prezzo dipende da molti fattori 
  //che non sono recuperabili facilmente quando si è già all'interno del carrello
	  echo number_format($row[quant],0,",","");
  }
  }
//fine div quant riga
echo "</div>";
}
/*
echo "<input name=lang type=hidden id=lang value=".$lingua.">";
echo "<input name=id_cart type=hidden id=id_cart value=".$row[id_carrello].">";
echo "<input name=id_prodotto type=hidden id=id_prodotto value=".$row[id_prodotto].">";
echo "<input name=id_riga type=hidden id=id_riga value=".$row[id].">";
echo "<input name=modifica_quant type=hidden id=modifica_quant value=1>";
echo "<input name=negozio type=hidden id=negozio value=carrello>";
echo "<input name=limit type=hidden id=limit value=".$limit.">";
echo "<input name=page type=hidden id=page value=".$page.">";
*/
//div avvisi riga-->
echo "<div id=avvisi_".$tot." class=price6 style=\"width:50px;\">";
if ($row[quant_modifica] != "") {
if ($row[quant_modifica] == 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><span title=\"$elimina_articolo\" style=\"color:red; font-weight:bold;\">Rimuovere</span></a>";
} else {
  if ($um != 'Articolo_singolo') {
	$quoziente = ceil($row[quant_modifica]/$confezione);
	if ($quoziente == '0') {
	  $quoziente = "1";
	}
	$calcolo_art_variati = $quoziente*$confezione;
	$query = "UPDATE qui_righe_carrelli SET quant_modifica = '$calcolo_art_variati' WHERE id = '$row[id]'";
	if (mysql_query($query)) {
	} else {
	echo "Errore durante l'inserimento: ".mysql_error();
	}
	$quoziente = "";
	$calcolo_art_variati = "";
  }
echo "<a href=\"javascript:void(0);\" onClick=\"total_general(".$row[id].",".$tot.")\"><span style=\"color:green;text-decoration:none; font-weight:bold;\">Aggiorna</span></a>";
}
}

//fine div avvisi riga-->
echo "</div>";
//div totale riga
echo "<div id=tot_".$tot." class=price6_riga>";
echo number_format($row[totale],2,",","");

//fine div totale riga
echo "</div>";

//div scheda riga (vuoto)
echo "<div class=vuoto9_riga style=\"width:40px;\">";
$sqlm = "SELECT * FROM qui_prodotti_".$row[negozio]." WHERE codice_art='".$row[codice_art]."'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
	if ($rigam[categoria1_it] == "Bombole") {
  echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	} else {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&anchor=blocco_rda_".$sing_rda."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
}
//fine div scheda riga
echo "</div>";
//div elimina riga (vuoto)
echo "<div class=vuoto9_riga style=\"width:40px;\">";
if ($conferma == "") {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
}
//fine div elimina riga
echo "</div>";





//fine contenitore riga tabella
echo "</div>";


$codice = "";
$tipo = "";
$um = "";
$materiale = "";
$colore = "";
$prezzo = "0";
$descrizione_art = "";

$tot = $tot + 1;

if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
//fine while
}
//inizio riga totale
echo "<div id=riga_totale>";
//div testo totale
echo "<div class=tx_totale>";
switch ($_SESSION[lang]) {
  case "it":
echo "Totale carrello &euro;";
  break;
  case "en":
echo "Total cart";
  break;
}
 //fine div testo totale
echo "</div>";
//div importo totale
echo "<div id=tot_gen class=price6_riga>";
echo $totale_carrello;
 //fine div totale totale
echo "</div>";

//fine riga totale
echo "</div>";


//fine if carrello attivo
}
//fine if carrello
}
echo "<div class=libero>";
 if ($carrello_attivo == 1) {
include "form_carrello.php";
} else {
//   echo "<form name=form1 method=get action=genera_rda.php>";
  if ($conferma != "") {
    echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td class=grande_18rossochiaro>Note</td>";
      echo "</tr>";
      echo "<tr>";
        echo "<td class=tabelle8>".$note."</td>";
      echo "</tr>";
      echo "<tr>";
        echo "<td class=tabelle8><br><strong>Il tuo carrello &egrave; stato trasformato in ordine in data ".$data_ordine_leggibile."</strong></td>";
      echo "</tr>";
      echo "<tr>";
        echo "<td>";
		//<div class="btn btnFreccia"><a href="#" onClick="MM_openBrWindow('','','')">Crea RdA</a></div>
		if ($totale_carrello >= 30) {
		  echo "<div class=btn btnFreccia><a href=# onClick=\"this.form.submit()\">";
			echo "<div align=right><strong>Crea RdA</strong></div></a>";
			echo "</div>";
          echo "<div align=right>";
		} else {
		  echo '<div style="width: 200px; height: 30px; color: red; float: right;">';
			echo '<strong>Non &egrave; consentito fare richieste di importo inferiore a 30 &euro;</strong>';
		  echo '</div>';
		}
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_rda.php?avviso=genera_rda&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/crea_rda.png width=137 height=23 border=0></a>";


            echo "<input type=hidden name=id_carrello id=id_carrello value=".$carrello.">";
            echo "<input type=hidden name=id_utente id=id_utente value=".$_SESSION[user_id].">";
            echo "<input name=lang type=hidden id=lang value=".$lingua.">";
            echo "<input name=avviso type=hidden id=avviso value=genera_rda>";
          echo "</div></td>";
      echo "</tr>";
    echo "</table>";
    } else {
    echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td class=tabelle8><br><strong>".$carrello_vuoto."</strong></td>";
      echo "</tr>";
    echo "</table>";
}
   }
echo "</div>";
switch ($_SESSION[lang]) {
	case "it":
	$testo_alert = "Il valore della quantità non può essere zero. In alternativa cancellare la riga!";
	break;
	case "en":
	$testo_alert = "The quantity cannot be zero. Alternatively delete this row!";
	break;
}

?>

<!--fine contenitore generale-->
</div>
<script type="text/javascript">
function attention(){
						alert("ciao");
}
function aggiornaCarrello(id_riga,valoreQuant,id){
						/*alert(id);*/
				$.ajax({
						type: "GET",   
						url: "recupero_carrello.php",   
						data: "modifica_quant=1&id_riga="+id_riga+"&quant="+valoreQuant,
						success: function(output) {
						$('#princ_container').html(output).show();
						}
						})
}
function axc(id_riga,valoreQuant,id){
  var conf = document.getElementById('conf_'+id_riga).value;
  var um = document.getElementById('um_'+id_riga).value;
	  $.ajax({
			  type: "GET",   
			  url: "aggiorna_avvisi_carrello.php",
			  cache: "false",   
			  data: "id_riga="+id_riga+"&id="+id+"&quant="+valoreQuant+"&um="+um+"&conf="+conf,
			  success: function(output) {
			  $('#avvisi_'+id).html(output).show();
	  }
	  })
	}
	
	
	
	

function ripristinaquantriga(id_riga,ord){
	var id_campo = document.getElementById('c_'+ord).value;
		

	if (id_campo == '') {
		/*alert(id_campo);*/
		//alert("<?php //echo $testo_alert; ?>");
						$.ajax({
								type: "GET",   
								url: "aggiorna_ripristinaquant_carrello.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&ord="+ord,
								success: function(output) {
								$('#q_'+ord).html(output).show();
						}
						})
	}
	}
function total_general(id_riga,id){
  var quant = document.getElementById('c_'+id).value;
  var conf = document.getElementById('conf_'+id_riga).value;
  var um = document.getElementById('um_'+id_riga).value;
	if (um != 'Articolo_singolo') {
		  var quoziente = Math.ceil(quant/conf);
		  if (quoziente == '0') {
			var quoziente = "1";
		  }
		  var calcolo_art_variati = quoziente*conf;
		  if (quant != calcolo_art_variati) {
			$.ajax({
			type: "GET",   
			url: "aggiorna_quant_modifica.php",   
			data: "id_riga="+id_riga+"&id="+id+"&quant="+calcolo_art_variati,
			async: "false",
			cache: "false",
			success: function(output) {
			$('#zzz').html(output).show();
			}
			})
			$('#c_'+id).val(calcolo_art_variati);
			alert("L'articolo viene venduto in confezioni da "+conf+" pezzi");
		  } else {
			/*alert("la quantità è "+quant);*/
			$.ajax({
			type: "GET",   
			url: "calcolo_totale.php",   
			data: "id_riga="+id_riga+"&id="+id+"&quant="+quant,
			async: "false",
			cache: "false",
			success: function(output) {
			$('#tot_'+id).html(output).show();
			/*alert(div_agg+","+id_riga+","+valoreQuant);*/
			}
			})
			$.ajax({
			type: "GET",   
			url: "aggiorna_totale_carrello.php",
			cache: "false",   
			data: "carrello="+<?php echo $carrello; ?>,
			success: function(output) {
			$('#tot_gen').html(output).show();
			}
			})
	
			$.ajax({
			type: "GET",   
			url: "aggiorna_avvisi_carrello.php",
			cache: "false",   
			data: "id_riga="+id_riga+"&id="+id+"&salvataggio=1",
			success: function(output) {
			$('#avvisi_'+id).html(output).show();
			}
			})
		  }
	} else {
		$.ajax({
				type: "GET",   
				url: "calcolo_totale.php",   
				data: "id_riga="+id_riga+"&id="+id+"&quant="+quant,
				async: "false",
				cache: "false",
				success: function(output) {
				$('#tot_'+id).html(output).show();
		/*alert(div_agg+","+id_riga+","+valoreQuant);*/
		}
		})
		$.ajax({
				type: "GET",   
				url: "aggiorna_totale_carrello.php",
				cache: "false",   
				data: "carrello="+<?php echo $carrello; ?>,
				success: function(output) {
				$('#tot_gen').html(output).show();
		}
		})
  
		$.ajax({
				type: "GET",   
				url: "aggiorna_avvisi_carrello.php",
				cache: "false",   
				data: "id_riga="+id_riga+"&id="+id+"&salvataggio=1",
				success: function(output) {
				$('#avvisi_'+id).html(output).show();
		}
		})
	}
}
setInterval("setTot()", 1000);
function setTot(){
						/*alert('tot carrello');*/
						$.ajax({
								type: "GET",
								url: "aggiorna_totale_carrello.php",   
								cache: false,   
								data: "carrello="+<?php echo $carrello; ?>,
								success: function(output) {
								$('#tot_gen').html(output).show();
								}
								})
}
</SCRIPT>
</body>
</html>
