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


$pag_attuale = "ordini";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
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

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_POST['page'] != "") {
$page = $_POST['page'];
} else {
$page = $_GET['page'];
}
if ($_POST['limit'] != "") {
$limit = $_POST['limit'];
} else {
$limit = $_GET['limit'];
}
$avviso = $_GET['avviso'];
$ordinamento = "data_ordine DESC";

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
if (isset($_GET['nr_ordine'])) {
$nrOrdDaModulo = $_GET['nr_ordine'];
} 
if ($nrOrdDaModulo != "") {
$b = "id = '$nrOrdDaModulo'";
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
$c = "(data_ordine BETWEEN '$inizio_range' AND '$fine_range')";
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
$e = "id_rda = '$nrRdaDaModulo'";
$clausole++;
}
if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$f = "logo = '$societaDaModulo'";
$clausole++;
}
//costruzione query
if ($clausole > 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_ordini_for WHERE stato != '4' AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$sumquery = "SELECT SUM(totale) as somma FROM qui_ordini_for WHERE stato != '4' AND ";

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
if ($h != "") {
$testoQuery .= $h;
$sumquery .= $h;
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
$testoQuery .= $g." AND ";
$sumquery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h;
$sumquery .= $h;
}
}
} else {
$testoQuery = "SELECT * FROM qui_ordini_for WHERE stato != '4' ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_ordini_for WHERE stato != '4' ";
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
if(($limit == "") OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 50; //default
 } 

if(($page == "") OR (is_numeric($page) == false)) {
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

//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}
if ($clausole > 0) {
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;
}

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
  <title>Quice - Lista Ordini fornitore</title>
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
th {
	color:#000;
	font-weight:bold;
}
.ui-widget-header {
	background-color:#F63;
	background-image:none !important;
	border-color:#F63;
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
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
location.href = "ordini.php?nr_rda=<?php echo $nrRdaDaModulo; ?>&shop=<?php echo $shopDaModulo; ?>&unita=<?php echo $unitaDaModulo; ?>&data_inizio=<?php echo $data_inizio; ?>&data_fine=<?php echo $data_fine; ?>&nr_ordine=<?php echo $nrOrdDaModulo; ?>";
}
</SCRIPT>


</head>
<body>
<div id="main_container">
<?php
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
/*
echo "<div id=ricerca class=submenureport>";
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
echo "</select>";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$unita."</strong><br>";
echo "<select name=unita class=ecoform id=unita>";
echo "<option selected value=>".$scegli_unita."</option>";
$sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda ORDER BY nome_unita ASC";
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
//div con la ricerca x num rda
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

echo "<input name=stato_rda type=hidden id=stato_rda value=4>";
echo "<input name=ricerca type=hidden id=ricerca value=1>";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=10><br>";
echo "<input type=\"reset\" name=\"button\" id=\"button\" value=\"Rimuovi filtri\" onClick=\"self.location='".$_SERVER['PHP_SELF']."'\">";
echo "</div>";
echo "</form>";
echo "</div>";//fine formRicerca
echo "</div>";//fine div id=ricerca class=submenuRicerca
*/
?>
<div id="contenitore_testata">
<div class="box_80">
Ordine
</div>
<div class="box_450">
Data
</div>
<div class="box_120" style="margin-left:205px;">
Gestione ordini
</div>
</div>
<?php
/*
//riga del totale
echo "<div class=contenitore_riga>";
echo "<div class=box_120>";
echo "TOTALE";
echo "</div>";
echo "<div class=box_450>";
echo "</div>";
echo "<div class=box_130_dx>";
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($totale_storico_rda,2,",",".");
echo "</div>";
echo "<div class=box_100_20>";
echo "</div>";

echo "</div>";	
*/
//if ($clausole > 0) {
 $querya = $testoQuery;
 $sf = 1;
//$querya = $testoQuery;
//inizia il corpo della tabella
$result = mysql_query($querya);
	$list_righe = mysql_num_rows($result);
	$div_alt = $list_righe * 20;
while ($row = mysql_fetch_array($result)) {
//	echo "<a href=\"javascript:void(0);\">";
//	echo "<div class=contenitore_rda onClick=\"vis_invis(".$row[id_ordine_for].")\">";
	echo "<div class=contenitore_rda>";
	echo "<div class=box_450 style=\"width:650px;\">";
	echo "Ordine ".$row[id]."<img src=immagini/spacer.gif width=15 height=4>| ".date("d/m/Y",$row[data_ordine])."<img src=immagini/spacer.gif width=15 height=4>| Responsabile ";
	$queryh = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
	$resulth = mysql_query($queryh);
	while ($rowh = mysql_fetch_array($resulth)) {
	  echo $rowh[nome];
	}
	echo "<img src=immagini/spacer.gif width=15 height=4>| Unit&agrave; ".$row[nome_unita];
	echo "</div>";
	echo "<div class=box_100_20 style=\"margin-left:20px;\">";
	echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('ordine_fornitore.php?id_ord=".$row[id]."&id_rda=".$row[id_rda]."&lang=".$lingua."', 'myPop1',800,800);\">";
	echo "<span style=\"color:rgb(2,207,84); text-decoration:none;\">Apri ordine</span>";
	echo "</a>";
	echo "</div>";
	echo "<div class=box_100_20>";
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_archivia_ordine.php?id_ordine=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><span style=\"color:rgb(50,50,50); text-decoration:none;\">Archivia ordine</span></a>";
	echo "</div>";
	echo '<div class="sel_all_riga" style="width:auto; padding:5px 0px 0px 10px;">';
//echo 'neg: '.$rigan[negozio].'<br>';
	switch ($row[logo]) {
	  case "vivisol":
		echo '<img src="immagini/bottone-vivisol.png">';
	  break;
	  case "sol":
		echo '<img src="immagini/bottone-sol.png">';
	  break;
	}
	echo "</div>";

	echo "</div>";
	//echo "</a>";
/*	echo "<div class=contenitore_riga id=ord".$row[id_ordine_for]." style=\"display:none; heigth:auto;\">";
echo "<div style=\"display:none; heigth:auto;\">";
echo "<div class=box_120>";
echo $row[codice_art];
echo "</div>";
echo "<div class=box_450>";
echo "aaa";
echo stripslashes($row[descrizione]);
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($row[quant],2,",",".");
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($row[totale],2,",",".");
echo "</div>";
echo "<div class=box_100_20>";
echo "<img src=immagini/spacer.gif width=15 height=20>";
echo "</div>";
echo "</div>";
//  if ($row[id_ordine_for] != $rif_ord) {
echo "</div>";	
//  }
$rif_ord = $row[id_ordine_for];
*/
}
//}
?>
<!--</form>--> 
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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&societa=".$societaDaModulo."&nr_ord=".$nrOrdDaModulo."&lang=".$lingua."><b>1</b></a>"; 
  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&societa=".$societaDaModulo."&nr_ord=".$nrOrdDaModulo."&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&societa=".$societaDaModulo."&nr_ord=".$nrOrdDaModulo."&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&societa=".$societaDaModulo."&nr_ord=".$nrOrdDaModulo."&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&societa=".$societaDaModulo."&nr_ord=".$nrOrdDaModulo."&lang=".$lingua."><b>".$last_page."</b></a>"; 
?>
        </td>
      </tr>
    </table>


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
function vis_invis(id_riga)  {
	/*alert(id_riga);*/
                if ($('#ord'+id_riga).css('display')=='none'){
                    $('#ord'+id_riga).css('display', 'block');
                } else {
                    $('#ord'+id_riga).css('display', 'none');
                }
 }
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
        data1str = data_inizio_val.substr(6)+data_inizio_val.substr(3, 2)+data_inizio_val.substr(0, 2);
		data2str = data_fine_val.substr(6)+data_fine_val.substr(3, 2)+data_fine_val.substr(0, 2);
	if((data_inizio_val != "") && (data_fine_val == "")) {
            alert("Occorre inserire entrambe le date");
	}
	if((data_inizio_val == "") && (data_fine_val != "")) {
            alert("Occorre inserire entrambe le date");
	}
		//controllo se la seconda data è successiva alla prima
        if (data2str-data1str<0) {
            alert("La data iniziale deve essere precedente quella finale");
			document.getElementById('data_fine').value = "";
        } else {
	/*alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);*/
	$.ajax({
	  type: "POST",   
	  url: "motore_ricerca_MSC.php",   
	  data: "societa="+socval+"&shop="+shopval+"&data_inizio="+data_inizio_val+"&data_fine="+data_fine_val+"&file_presente=<?php echo $file_presente; ?>",
	  success: function(output) {
	  $('#contenitore_msc').html(output).show();
	  $("#contenitore_int_msc").fadeIn(1000);
	  }
	})
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
	/*var data_inizio = document.getElementById('data_inizio').value;
	var data_fine = document.getElementById('data_fine').value;
	if((data_inizio != "") && (data_fine != "")) {*/
		document.form_filtri2.submit();
	/*} else {
		alert("Le date sono obbligatorie!");
	}*/
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
