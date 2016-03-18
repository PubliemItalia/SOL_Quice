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
$id_utente = $_SESSION[user_id];
//echo "lingua: ".$lingua."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";

$pag_attuale = "report_rda";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db


$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
//variabili di paginazione
if ($_GET['ricerca'] != "") {
$ricerca = $_GET['ricerca'];
} else {
$ricerca = $_POST['ricerca'];
} 
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
if (isset($_GET['stato_rda'])) {
$stato_rdaDaModulo = $_GET['stato_rda'];
} 
if ($stato_rdaDaModulo != "") {
$b = "stato = '$stato_rdaDaModulo'";
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
if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$e = "id = '$nrRdaDaModulo'";
$clausole++;
}

//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole == 0) {
$testoQuery = "SELECT * FROM qui_rda WHERE stato = '4' ";
$sumquery =   "SELECT SUM(totale_rda) as somma FROM qui_rda WHERE stato = '4' ";
} else {

$testoQuery = "SELECT * FROM qui_rda WHERE ";
$sumquery =   "SELECT SUM(totale_rda) as somma FROM qui_rda WHERE ";

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
     $limit = 20; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 

//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito più sotto
//if ($clausole > 0) {
$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);
//}

$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
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
include "traduzioni_interfaccia.php";
?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<style type="text/css">
<!--
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
.Stile3 {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
th {
	color:#000;
	font-weight:bold;
}
.ui-widget-header {
	background-color:#06F;
	background-image:none !important;
	border-color:#06F;
}
-->
</style>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>

</head>
<?php

//if ($add_pref != "") {
//echo "<body onLoad=window.open('popup_notifica.php?avviso=bookmark&id_prod=".$id."','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//echo "<body onLoad=window.open('popup_notifica.php?avviso=config','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//} else {
echo "<body>";
//}

?>
<div id="main_container">
<?php
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
/*
include "menu_reportistica.php";
//div ricerca rda
echo "<div id=ricerca class=submenureport style=\"color:rgb(0,0,0);\">";
echo "<div id=formRicerca>";
echo "<form action=".$azione_form." method=get name=form_filtri2>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$shop."</strong><br>";
echo "<select name=shop class=codice_lista_nopadding id=shop>";
switch ($shopDaModulo) {
case "":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
//echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "assets":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option selected value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
//echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "consumabili":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option selected value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
//echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "spare_parts":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option selected value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
//echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "labels":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option selected value=labels>".$tasto_labels."</option>";
//echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;


}
echo "</select><br>";
echo "<img src=immagini/spacer.gif width=100 height=5><br>";
echo "<strong>".$unita."</strong><br>";
echo "<select name=unita class=codice_lista_nopadding id=unita>";
echo "<option selected value=>".$scegli_unita."</option>";
$sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_rda ORDER BY nome_unita ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
if ($rigag[id_unita] == $unitaDaModulo) {
echo "<option selected value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
} else {
echo "<option value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
}
}
echo "</select>";
echo "</div>";



echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$stato."</strong><br>";
echo "<select name=stato_rda class=codice_lista_nopadding id=stato_rda>";
if ($_SESSION[ruolo] == "admin") {
echo "<option selected value=>".$scegli_stato."</option>";
$sqlr = "SELECT * FROM uc_order_statuses WHERE attivo_admin = '1' ORDER BY status_php ASC";
}
if ($_SESSION[negozio_buyer] != "") {
$sqlr = "SELECT * FROM uc_order_statuses WHERE attivo = '1' ORDER BY status_php ASC";
}
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
switch($lingua) {
case "it":
$testoStatus = $rigar[title_it];
break;
case "en":
$testoStatus = $rigar[title];
break;
}


if ($rigar[status_php] == $stato_rdaDaModulo) {
echo "<option selected value=".$rigar[status_php].">".$testoStatus."</option>";
} else {
echo "<option value=".$rigar[status_php].">".$testoStatus."</option>";
}
}
echo "</select><br>";

echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$testo_nr_rda."</strong><br>";
echo "<input name=nr_rda type=text class=tabelle8 id=nr_rda size=10 value=".$nr_rda.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testo_data_inizio."</strong><br>";
echo "<input name=data_inizio type=text class=tabelle8 id=data_inizio size=10 onclick=\"Calendar.show(this, '%d/%m/%Y', false)\"
onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\" value=".$data_inizio.">";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$testo_data_fine."</strong><br>";
echo "<input name=data_fine type=text class=tabelle8 id=data_fine size=10 onclick=\"Calendar.show(this, '%d/%m/%Y', false)\"
onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\" value=".$data_fine.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<br><input type=submit name=button id=button value=".$filtra.">";
echo "<br><br><a href=xls2.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&stato_rda=".$stato_rdaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine." target=_blank><span class=Stile3>".$esporta."</span></a>";
echo "</div>";
echo "</form>";
echo "</div>";//fine formRicerca

echo "</div>";//fine div id=ricerca class=submenuRicerca
*/
?>

  <?php
//**********************
//tabella può essere visualizzata solo da buyer ed admin perchè il menu compare solo se l'utente è buyer o admin
//************************
//riga del totale
echo "<div class=contenitore_riga>";
echo "<div class=box_100>";
echo "TOTALE";
echo "</div>";
echo "<div class=box_100>";
echo "</div>";
echo "<div class=box_200>";
echo "</div>";
echo "<div class=box_200>";
echo "</div>";
echo "<div class=box_100>";
echo "</div>";
echo "<div class=box_100>";
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($totale_storico_rda,2,",",".");
echo "</div>";

echo "</div>";	
?>
<div id="contenitore_testata" style="float:left;">
<div class="box_100">
<?php echo $testata_id_ordine; ?>
</div>
<div class="box_100">
<?php echo $testata_data; ?>
</div>

<div class="box_200">
<?php echo $testata_utente; ?>
</div>
<div class="box_200">
<?php echo $testata_responsabile; ?>
</div>
<div class="box_100">
<?php echo $unita; ?>
</div>
<div class="box_100">
<?php echo $testata_status; ?>
</div>
<div class="box_130_dx">
<?php echo $testata_totale; ?>
</div>
</div>
<?php
 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
//if ($clausole > 0) {
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {

echo "<div class=contenitore_riga>";
echo "<div class=box_100>";
echo $row[id];
$querys = "SELECT * FROM qui_files_sap WHERE id_rda = '$row[id]'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
$nome_file_sap = $rows[nome_file];
if ($nome_file_sap != "") {
$pos = strrpos($nome_file_sap,"_");
$nome_vis = substr($nome_file_sap,($pos+1),5);
echo " (".$nome_vis.")";
}
}
echo "</div>";
echo "<div class=box_100>";
echo date("d.m.Y",$row[data_inserimento]);
echo "</div>";
echo "<div class=box_200>";
echo stripslashes($row[nome_utente]);
echo "</div>";
echo "<div class=box_200>";
$sqly = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
echo stripslashes($rigay[nome]);
}
echo "</div>";
echo "<div class=box_100>";
echo $row[nome_unita];
echo "</div>";
echo "<div class=box_80>";
switch ($row[stato]) {
case "1":
echo "<img src=immagini/stato1.png width=62 height=17 title=\"$status1\">";
break;
case "2":
echo "<img src=immagini/stato2.png width=62 height=17 title=\"$status2\">";
break;
case "3":
echo "<img src=immagini/stato3.png width=62 height=17 title=\"$status3\">";
break;
case "4":
echo "<img src=immagini/stato4.png width=62 height=17 title=\"$status4\">";
break;
}
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($row[totale_rda],2,",",".");
echo "</div>";
echo "<div class=box_40>";
  $sqlm = "SELECT * FROM qui_righe_rda WHERE id_rda = '$row[id]'";
  $resultm = mysql_query($sqlm);
  $num_righeXDim = mysql_num_rows($resultm);
  $altezza_finestra = ($num_righeXDim*37)+125+180;
  if ($altezza_finestra > 800) {
	  $altezza_finestra = 800;
  }
	  echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_vis_rda.php?id=".$row[id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:".$altezza_finestra.",fixed:false,maskid:'bluemask',maskopacity:'40'})\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_vis_rda.php?id=".$row[id]."&lang=".$lingua."', 'myPop1',1000,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$visualizza_rda\"></a>";
echo "</div>";

echo "</div>";	
/*
*/
}
//}
$totale_rda = "";

?>
<div class=contenitore_riga>
    <table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">
    <?php

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

   if($page > 1) {
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b>1</b></a>"; 
  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b>".$last_page."</b></a>"; 
?>
        </td>
      </tr>
    </table>
  </div>
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

function agg_tendine(shop){
	/*alert("ok tendine");*/
	var soloshop = 1;
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_tendina_categ_uni.php",   
	  data: "soloshop="+soloshop+"&shop="+shop,
	  success: function(output) {
	  $('#divcat').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_tendina_uni_categ.php",   
	  data: "soloshop="+soloshop+"&shop="+shop,
	  success: function(output) {
	  $('#divuni').html(output).show();
	  }
	})
}
function msc(mode,valore){
	switch (mode) {
		case "data_inizio":
		  var data_inizio_val = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "data_fine":
		  var data_fine_val = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		break;
		case "unita":
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var unitaval = valore;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
		case "shop":
		  var shopval = valore;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		  var data_inizio_val = document.getElementById('data_inizio').value;
		  var data_fine_val = document.getElementById('data_fine').value;
		break;
	}
	var nr_rda = document.getElementById('nr_rda').value;
	/*alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);*/
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
	$.ajax({
	  type: "POST",   
	  url: "motore_ricerca_MSC.php",   
	  data: "shop="+shopval+"&unita="+unitaval+"&nr_rda="+nr_rda+"&data_inizio="+data_inizio_val+"&data_fine="+data_fine_val+"&file_presente=<?php echo $file_presente; ?>",
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
    //}else{
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
    }else{
		alert("Occorre inserire entrambe le date");
	}
}
</SCRIPT>
</body>
</html>
