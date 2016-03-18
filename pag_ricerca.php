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
//echo "user id: ...".$_SESSION[user_id]."<br>";
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
//echo "lingua: ".$lingua."<br>";
$negozio_ricerca = intval($_GET['negozio_ricerca']);
//echo "negozio_ricerca: ".$negozio_ricerca."<br>";
$criterio = $_GET['criterio'];
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
if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}
$apertura_scheda = $_GET['apertura_scheda'];
if (isset($_GET['codice'])) {
$codiceDaModulo = $_GET['codice'];
} 
if ($codiceDaModulo != "") {
$a = "codice_art LIKE '%$codiceDaModulo%'";
$clausole++;
}

if (isset($_GET['descrizione'])) {
$descrizioneDaModulo = $_GET['descrizione'];
} 
if ($descrizioneDaModulo != "") {
$clausole++;
}
//echo "clausole: ".$clausole."<br>";
if ($_GET['criterio'] != "") {
$_SESSION[percorso_ritorno] ="pag_ricerca.php?codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&negozio_ricerca=".$negozio_ricerca."&button=Filtra&posizione=Ricerca&criterio=1";
}


include "functions.php";
//include "testata.php";
include "menu_quice3.php";

if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[descrizione] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";
//echo "negozio: ".$_GET['negozio']."<br>";

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
$avviso = $_GET['avviso'];
$ordinamento = "codice_art ASC";

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query

//costruzione query
switch ($negozio_ricerca) {
case "1":
$testoQuery = "SELECT descrizione1_it,descrizione2_it,descrizione1_en,descrizione2_en FROM qui_prodotti_assets WHERE obsoleto != '1' AND MATCH(descrizione1_it) AGAINST($descrizioneDaModulo) ";
$nome_negozio = "assets";
break;
case "2":
$testoQuery = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto != '1' ";
$nome_negozio = "consumabili";
break;
case "3":
$testoQuery = "SELECT * FROM qui_prodotti_spare_parts WHERE obsoleto != '1' ";
$nome_negozio = "spare_parts";
break;
case "4":
$testoQuery = "SELECT * FROM qui_prodotti_vivistore WHERE obsoleto != '1' ";
$nome_negozio = "vivistore";
break;
case "5":
$testoQuery = "SELECT * FROM qui_prodotti_labels WHERE obsoleto != '1' ";
$nome_negozio = "labels";
break;
}

//$testoQuery .= "WHERE obsoleto = '0' AND ";
if ($clausole > 0) {
if ($clausole == 1) {
if ($a != "") {
$testoQuery .= " AND ".$a;
}
if ($b != "") {
$testoQuery .= " AND ".$b;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
}
}

//} else {
//$testoQuery .= "WHERE obsoleto = '' ";
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
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

if ($negozio_ricerca > 0) {
$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);
}

//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}

//echo "testoQuery: ".$testoQuery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
?>
<html>
<head>
  <title>Quice - Ricerca</title>
<link href="tabelle.css" rel="stylesheet" type="text/css">
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
	.ricerca{
	background:#fff7d9;
	margin-top: auto;
	height: 100px;
	width: 960px;
	margin-right: auto;
	margin-bottom: auto;
	margin-left: auto;
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
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  window.location.href = window.location.href;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</SCRIPT>
<script type="text/javascript" src="tinybox.js"></script>
</head>
<body>

<div id="main_container">
<?php
/*echo "<div id=ricerca class=submenuRicerca style=\"float:left; width:100%; height:105px; margin-bottom:20px; padding-top:0px;\">";
echo "<div id=formRicerca>";
//echo "PIPPO";
echo "<form action=".$azione_form." method=get name=form_filtri>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testata_codice.":</strong><br>";
echo "<input name=codice type=text class=tabelle8 id=codice size=10 value=".$codiceDaModulo.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testata_descrizione.":</strong><br>";
echo "<input name=descrizione type=text class=tabelle8 id=descrizione size=20 value=".$descrizioneDaModulo.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testo_mail_negozio.":</strong><br>";
echo "<select name=negozio_ricerca class=codice_lista_nopadding id=negozio_ricerca>";
switch ($negozio_ricerca) {
case "":
//echo "<option selected value=0>Tutti i negozi</option>";
echo "<option selected value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
//echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "0":
echo "<option selected value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
//echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "1":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option selected value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
//echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "2":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option selected value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
//echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "3":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option selected value=3>".$tasto_spare_parts."</option>";
//echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "4":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option selected value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "5":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
//echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option selected value=5>".$tasto_labels."</option>";
break;
}
echo "</select>";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<td class=nero_grassettosx12><br><input type=submit name=button id=button value=Filtra>";
echo "</div>";
echo "<input name=posizione type=hidden id=posizione value=".$posizione."> ";
echo "<input name=criterio type=hidden id=criterio value=1> ";

echo "<form>";
echo "</div>";//fine formRicerca

echo "</div>";//fine div id=ricerca class=submenuRicerca
*/
if ($negozio_ricerca > 0) {
$questa_pag = $_SERVER['PHP_SELF'];
/*
echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
  echo "<tr>";
    echo "<td width=661 class=ecoformdestra>";
	//echo $elementi_pagina;
	echo "</td>";
    echo "<td width=339 class=ecoformdestra> <div align=right>".$lista1." | ".$griglia." | <a href=".$questa_pag."?limit=10&page=1&criterio=".$criterio."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&asc_desc=".$asc_desc."&posizione=Ricerca&ordinamento=".$ordinamento.">10</a> | <a href=".$questa_pag."?limit=25&page=1&negozio_ricerca=".$negozio_ricerca."&criterio=".$criterio."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&asc_desc=".$asc_desc."&posizione=Ricerca&ordinamento=".$ordinamento.">25</a> | <a href=".$questa_pag."?limit=50&page=1&criterio=".$criterio."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&asc_desc=".$asc_desc."&descrizione=".$descrizioneDaModulo."&posizione=Ricerca&ordinamento=".$ordinamento.">50</a>";
    echo "</div></td>";
  echo "</tr>";
echo "</table>";
*/
}
?>
<div id="cont_ricerche">
<table width=960 border="0" cellpadding="0" cellspacing="0">
  <tr class="rowHead"> 
<!-- TESTATA colonna codice-->
<th width="90" class="codeTitle"><?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=".$posizione."&criterio=1&ordinamento=codice_art&";
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
    ?></th>
<!-- TESTATA colonna nazione-->
    <th width="90" class="country"><?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=".$posizione."&criterio=1&ordinamento=paese&";
	if ($ordinamento == "paese") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_nazione;
	if ($ordinamento == "paese") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?></th>
    <th width="400" class="vessel"><?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=".$posizione."&criterio=1&ordinamento=descrizione_it&";
	if ($ordinamento == "descrizione_it") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_prodotto;
	if ($ordinamento == "descrizione_it") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?></th>
    <th width="80" class="capacity"><?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=".$posizione."&criterio=1&ordinamento=confezione&";
	if ($ordinamento == "confezione") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_imballo;
	if ($ordinamento == "confezione") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?></th>
    <th width="100" class="price"><?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=".$posizione."&criterio=1&ordinamento=prezzo&";
	if ($ordinamento == "prezzo") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_prezzo." &euro;";
	if ($ordinamento == "prezzo") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?></th>
<!--    <th width="100" class=tabellecentro><?php //echo $testata_quant; ?></th>
-->    
    <th width="45" class="open">&nbsp;</th>
    <th width="45" class="bookmark"><?php //echo $testata_preferito; ?></th>
    <th width="45" class="cart"><?php //echo $testata_carrello; ?></th>
    </tr>
  <?php
 $sfondo_righe_tab = "searchColor";
 //echo "sfondo_righe_tab: ".$sfondo_righe_tab."<br>";
if ($criterio != "") {
if ($negozio_ricerca > 0) {
//RICERCA SULLA SINGOLA TABELLA
 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
$risultati_trovati = mysql_num_rows($resultc);

while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
$righe_trovate = $righe_trovate +1;
echo "<td class=code>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</td>";
echo "<td class=country>".stripslashes($row[paese])."</td>";
echo "<td class=vessel>";
switch($lingua) {
case "it":
$descr_prod = $row[descrizione1_it];
break;
case "en":
$descr_prod = $row[descrizione1_en];
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($descr_prod == "") {
echo $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
echo "</td>";
echo "<td class=gas>";
echo $row[confezione];
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
//RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
  if ($row[rif_famiglia] != "") {
	$queryj = "SELECT * FROM qui_prodotti_".$nome_negozio." WHERE id = '".$row[rif_famiglia]."'";
	$resultj = mysql_query($queryj);
	while ($rowj = mysql_fetch_array($resultj)) {
	  $cod_ricerca = $rowj[codice_art];
	}
  } else {
	$cod_ricerca = $row[codice_art];
  }
//FINE RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
echo "<td class=open>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	switch ($row[categoria1_it]) {
		default:
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
//		case "Etichette_ADR":
//  echo "<a href=scheda_visuale_etich.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
//		break;
		case "bombole":
		echo "";
//  echo "<a href=scheda_visuale_bombole.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
	}
}
/*	switch ($row[categoria1_it]) {
		default:
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&codice_art=".$row[codice_art]."&paese=&nazione_ric=&negozio=".$row[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
		case "bombole":
  //echo "<a href=scheda_visuale_bombole.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
	}
*/
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
}
	//echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
echo "</td>";
echo "</tr>"; 
$cod_ricerca = "";
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
//}
} else {
//RICERCA SULLe TRE TABELLE

//*************************
//ASSET
//*************************
$a = "codice_art LIKE '%$codiceDaModulo%'";
switch($lingua) {
case "it":
$b = "(categoria1_it LIKE '%$descrizioneDaModulo%' OR categoria2_it LIKE '%$descrizioneDaModulo%' OR categoria3_it LIKE '%$descrizioneDaModulo%' OR categoria4_it LIKE '%$descrizioneDaModulo%' OR descrizione1_it LIKE '%$descrizioneDaModulo%' OR descrizione2_it LIKE '%$descrizioneDaModulo%' OR descrizione3_it LIKE '%$descrizioneDaModulo%' OR descrizione4_it LIKE '%$descrizioneDaModulo%') ";
break;
case "en":
$b = "(categoria1_en LIKE '%$descrizioneDaModulo%' OR categoria2_en LIKE '%$descrizioneDaModulo%' OR categoria3_en LIKE '%$descrizioneDaModulo%' OR categoria4_en LIKE '%$descrizioneDaModulo%' OR descrizione1_en LIKE '%$descrizioneDaModulo%' OR descrizione2_en LIKE '%$descrizioneDaModulo%' OR descrizione3_en LIKE '%$descrizioneDaModulo%' OR descrizione4_en LIKE '%$descrizioneDaModulo%')";
break;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo == "") {
//echo "caso 0<br>";
$queryb = "SELECT * FROM qui_prodotti_assets WHERE obsoleto != '1' ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo == "") {
//echo "caso 1<br>";
$queryb = "SELECT * FROM qui_prodotti_assets WHERE obsoleto != '1' AND ".$a." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo != "") {
//echo "caso 2<br>";
$queryb = "SELECT * FROM qui_prodotti_assets WHERE obsoleto != '1' AND ".$b." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo != "") {
//echo "caso 1 e 2<br>";
$queryb = "SELECT * FROM qui_prodotti_assets WHERE obsoleto != '1' AND ".$a." AND ".$b." ORDER BY ".$ordinamento;
}
//echo "query: ".$queryb."<br>";
 //$sf = 1;
//inizia il corpo della tabella
$resultb = mysql_query($queryb);
$trovati_asset = mysql_num_rows($resultb);
while ($row = mysql_fetch_array($resultb)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
$righe_trovate = $righe_trovate +1;
echo "<td class=code>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</td>";
echo "<td class=country>".stripslashes($row[paese])."</td>";
echo "<td class=vessel>";
switch($lingua) {
case "it":
$descr_prod = $row[descrizione1_it];
break;
case "en":
$descr_prod = $row[descrizione1_en];
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($descr_prod == "") {
echo $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
echo "</td>";
echo "<td class=gas>";
echo $row[confezione];
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
echo "<td class=open>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	switch ($row[categoria1_it]) {
		default:
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
//		case "Etichette_ADR":
//  echo "<a href=scheda_visuale_etich.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
//		break;
		case "bombole":
		echo "";
//  echo "<a href=scheda_visuale_bombole.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
	}
}
/*	switch ($row[categoria1_it]) {
		default:
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&codice_art=".$row[codice_art]."&paese=&nazione_ric=&negozio=".$row[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
		case "Bombole":
  //echo "<a href=scheda_visuale_bombole.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
		break;
	}
*/
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
}

//echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
echo "</td>";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
//*************************
//CONSUMABILI
//*************************
$a = "codice_art LIKE '%$codiceDaModulo%'";
switch($lingua) {
case "it":
$b = "(categoria1_it LIKE '%$descrizioneDaModulo%' OR categoria2_it LIKE '%$descrizioneDaModulo%' OR categoria3_it LIKE '%$descrizioneDaModulo%' OR categoria4_it LIKE '%$descrizioneDaModulo%' OR descrizione1_it LIKE '%$descrizioneDaModulo%' OR descrizione2_it LIKE '%$descrizioneDaModulo%' OR descrizione3_it LIKE '%$descrizioneDaModulo%' OR descrizione4_it LIKE '%$descrizioneDaModulo%') ";
break;
case "en":
$b = "(categoria1_en LIKE '%$descrizioneDaModulo%' OR categoria2_en LIKE '%$descrizioneDaModulo%' OR categoria3_en LIKE '%$descrizioneDaModulo%' OR categoria4_en LIKE '%$descrizioneDaModulo%' OR descrizione1_en LIKE '%$descrizioneDaModulo%' OR descrizione2_en LIKE '%$descrizioneDaModulo%' OR descrizione3_en LIKE '%$descrizioneDaModulo%' OR descrizione4_en LIKE '%$descrizioneDaModulo%')";
break;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo == "") {
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto != '1' ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo == "") {
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto != '1' AND ".$a." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo != "") {
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto != '1' AND ".$b." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo != "") {
$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE obsoleto != '1' AND ".$a." AND ".$b." ORDER BY ".$ordinamento;
}
//echo "query: ".$queryc."<br>";
// $sf = 1;
//inizia il corpo della tabella
$resultc = mysql_query($queryc);
$trovati_consumabili = mysql_num_rows($resultc);
while ($row = mysql_fetch_array($resultc)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
$righe_trovate = $righe_trovate +1;
echo "<td class=code>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</td>";
echo "<td class=country>".stripslashes($row[paese])."</td>";
echo "<td class=vessel>";
switch($lingua) {
case "it":
$descr_prod = $row[descrizione1_it];
break;
case "en":
$descr_prod = $row[descrizione1_en];
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($descr_prod == "") {
echo $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
echo "</td>";
echo "<td class=gas>";
echo $row[confezione];
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
//RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
  if ($row[rif_famiglia] != "") {
	$queryj = "SELECT * FROM qui_prodotti_consumabili WHERE id = '".$row[rif_famiglia]."'";
	$resultj = mysql_query($queryj);
	while ($rowj = mysql_fetch_array($resultj)) {
	  $cod_ricerca = $rowj[codice_art];
	}
  } else {
	$cod_ricerca = $row[codice_art];
  }
//FINE RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
echo "<td class=open>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
}
$cod_ricerca = "";

echo "</td>";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}

//*************************
//vivistore
//*************************
$a = "codice_art LIKE '%$codiceDaModulo%'";
switch($lingua) {
case "it":
$b = "(categoria1_it LIKE '%$descrizioneDaModulo%' OR categoria2_it LIKE '%$descrizioneDaModulo%' OR categoria3_it LIKE '%$descrizioneDaModulo%' OR categoria4_it LIKE '%$descrizioneDaModulo%' OR descrizione1_it LIKE '%$descrizioneDaModulo%' OR descrizione2_it LIKE '%$descrizioneDaModulo%' OR descrizione3_it LIKE '%$descrizioneDaModulo%' OR descrizione4_it LIKE '%$descrizioneDaModulo%') ";
break;
case "en":
$b = "(categoria1_en LIKE '%$descrizioneDaModulo%' OR categoria2_en LIKE '%$descrizioneDaModulo%' OR categoria3_en LIKE '%$descrizioneDaModulo%' OR categoria4_en LIKE '%$descrizioneDaModulo%' OR descrizione1_en LIKE '%$descrizioneDaModulo%' OR descrizione2_en LIKE '%$descrizioneDaModulo%' OR descrizione3_en LIKE '%$descrizioneDaModulo%' OR descrizione4_en LIKE '%$descrizioneDaModulo%')";
break;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo == "") {
$queryc = "SELECT * FROM qui_prodotti_vivistore WHERE obsoleto != '1' ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo == "") {
$queryc = "SELECT * FROM qui_prodotti_vivistore WHERE obsoleto != '1' AND ".$a." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo != "") {
$queryc = "SELECT * FROM qui_prodotti_vivistore WHERE obsoleto != '1' AND ".$b." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo != "") {
$queryc = "SELECT * FROM qui_prodotti_vivistore WHERE obsoleto != '1' AND ".$a." AND ".$b." ORDER BY ".$ordinamento;
}
//echo "query: ".$queryc."<br>";
 //$sf = 1;
//inizia il corpo della tabella
$resultc = mysql_query($queryc);
$trovati_vivistore = mysql_num_rows($resultc);
while ($row = mysql_fetch_array($resultc)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
$righe_trovate = $righe_trovate +1;
echo "<td class=code>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</td>";
echo "<td class=country>".stripslashes($row[paese])."</td>";
echo "<td class=vessel>";
switch($lingua) {
case "it":
$descr_prod = $row[descrizione1_it];
break;
case "en":
$descr_prod = $row[descrizione1_en];
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($descr_prod == "") {
echo $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
echo "</td>";
echo "<td class=gas>";
echo $row[confezione];
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
//RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
  if ($row[rif_famiglia] != "") {
	$queryj = "SELECT * FROM qui_prodotti_vivistore WHERE id = '".$row[rif_famiglia]."'";
	$resultj = mysql_query($queryj);
	while ($rowj = mysql_fetch_array($resultj)) {
	  $cod_ricerca = $rowj[codice_art];
	}
  } else {
	$cod_ricerca = $row[codice_art];
  }
//FINE RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
echo "<td class=open>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
}
$cod_ricerca = "";

echo "</td>";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}








//*************************
//SPARE
//*************************
$a = "codice_art LIKE '%$codiceDaModulo%'";
switch($lingua) {
case "it":
$b = "(categoria1_it LIKE '%$descrizioneDaModulo%' OR categoria2_it LIKE '%$descrizioneDaModulo%' OR categoria3_it LIKE '%$descrizioneDaModulo%' OR categoria4_it LIKE '%$descrizioneDaModulo%' OR descrizione1_it LIKE '%$descrizioneDaModulo%' OR descrizione2_it LIKE '%$descrizioneDaModulo%' OR descrizione3_it LIKE '%$descrizioneDaModulo%' OR descrizione4_it LIKE '%$descrizioneDaModulo%') ";
break;
case "en":
$b = "(categoria1_en LIKE '%$descrizioneDaModulo%' OR categoria2_en LIKE '%$descrizioneDaModulo%' OR categoria3_en LIKE '%$descrizioneDaModulo%' OR categoria4_en LIKE '%$descrizioneDaModulo%' OR descrizione1_en LIKE '%$descrizioneDaModulo%' OR descrizione2_en LIKE '%$descrizioneDaModulo%' OR descrizione3_en LIKE '%$descrizioneDaModulo%' OR descrizione4_en LIKE '%$descrizioneDaModulo%')";
break;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo == "") {
$queryd = "SELECT * FROM qui_prodotti_spare_parts WHERE obsoleto != '1' ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo == "") {
$queryd = "SELECT * FROM qui_prodotti_spare_parts WHERE obsoleto != '1' AND ".$a." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo != "") {
$queryd = "SELECT * FROM qui_prodotti_spare_parts WHERE obsoleto != '1' AND ".$b." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo != "") {
$queryd = "SELECT * FROM qui_prodotti_spare_parts WHERE obsoleto != '1' AND ".$a." AND ".$b." ORDER BY ".$ordinamento;
}
//$queryd = "SELECT * FROM qui_prodotti_spare_parts WHERE ".$a." AND (".$b.") ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//echo "query: ".$queryd."<br>";
 //$sf = 1;
//inizia il corpo della tabella
$resultd = mysql_query($queryd);
$trovati_spare = mysql_num_rows($resultd);
while ($row = mysql_fetch_array($resultd)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
$righe_trovate = $righe_trovate +1;
echo "<td class=code>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</td>";
echo "<td class=country>".stripslashes($row[paese])."</td>";
echo "<td class=vessel>";
switch($lingua) {
case "it":
$descr_prod = $row[descrizione1_it];
break;
case "en":
$descr_prod = $row[descrizione1_en];
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($descr_prod == "") {
echo $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
echo "</td>";
echo "<td class=gas>";
echo $row[confezione];
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
echo "<td class=open>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}

echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
}

//echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";

echo "</td>";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}

//*************************
//LABELS
//*************************
$a = "codice_art LIKE '%$codiceDaModulo%'";
switch($lingua) {
case "it":
$b = "(categoria1_it LIKE '%$descrizioneDaModulo%' OR categoria2_it LIKE '%$descrizioneDaModulo%' OR categoria3_it LIKE '%$descrizioneDaModulo%' OR categoria4_it LIKE '%$descrizioneDaModulo%' OR descrizione1_it LIKE '%$descrizioneDaModulo%' OR descrizione2_it LIKE '%$descrizioneDaModulo%' OR descrizione3_it LIKE '%$descrizioneDaModulo%' OR descrizione4_it LIKE '%$descrizioneDaModulo%') ";
break;
case "en":
$b = "(categoria1_en LIKE '%$descrizioneDaModulo%' OR categoria2_en LIKE '%$descrizioneDaModulo%' OR categoria3_en LIKE '%$descrizioneDaModulo%' OR categoria4_en LIKE '%$descrizioneDaModulo%' OR descrizione1_en LIKE '%$descrizioneDaModulo%' OR descrizione2_en LIKE '%$descrizioneDaModulo%' OR descrizione3_en LIKE '%$descrizioneDaModulo%' OR descrizione4_en LIKE '%$descrizioneDaModulo%')";
break;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo == "") {
$queryc = "SELECT * FROM qui_prodotti_labels WHERE obsoleto != '1' ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo == "") {
$queryc = "SELECT * FROM qui_prodotti_labels WHERE obsoleto != '1' AND ".$a." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo == "" AND $descrizioneDaModulo != "") {
$queryc = "SELECT * FROM qui_prodotti_labels WHERE obsoleto != '1' AND ".$b." ORDER BY ".$ordinamento;
}
if ($codiceDaModulo != "" AND $descrizioneDaModulo != "") {
$queryc = "SELECT * FROM qui_prodotti_labels WHERE obsoleto != '1' AND ".$a." AND ".$b." ORDER BY ".$ordinamento;
}
//echo "query: ".$queryc."<br>";
 //$sf = 1;
//inizia il corpo della tabella
$resultc = mysql_query($queryc);
$trovati_labels = mysql_num_rows($resultc);
while ($row = mysql_fetch_array($resultc)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
$righe_trovate = $righe_trovate +1;
echo "<td class=code>";
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo "</td>";
echo "<td class=country>".stripslashes($row[paese])."</td>";
echo "<td class=vessel>";
switch($lingua) {
case "it":
$descr_prod = $row[descrizione1_it];
break;
case "en":
$descr_prod = $row[descrizione1_en];
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($descr_prod == "") {
echo $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
echo "</td>";
echo "<td class=gas>";
echo $row[confezione];
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
//RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
  if ($row[rif_famiglia] != "") {
	$queryj = "SELECT * FROM qui_prodotti_labels WHERE id = '".$row[rif_famiglia]."'";
	$resultj = mysql_query($queryj);
	while ($rowj = mysql_fetch_array($resultj)) {
	  $cod_ricerca = $rowj[codice_art];
	}
  } else {
	$cod_ricerca = $row[codice_art];
  }
//FINE RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
echo "<td class=open>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
if ($row[categoria3_it] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
echo "<a href=scheda_visuale.php?categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$row[negozio]."&codice_art=".$row[codice_art]."&lang=".$lingua."&paese=".$row[paese]."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
	}
echo "</td>";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
//*************************
//fine if negozio ricerca
}
  /*
echo '<span style="color:#000;">
<br>risultati_asset = '.$risultati_asset.'
<br>risultati_consumabili = '.$risultati_consumabili.'
<br>risultati_vivistore = '.$risultati_vivistore.'
<br>risultati_spare = '.$risultati_spare.'
<br>risultati_labels = '.$risultati_labels.'
</span>';
*/
//if (($risultati_asset+$risultati_consumabili+$risultati_vivistore+$risultati_spare+$risultati_labels) < 1) {
?>
</table><br>
<!--<table width="960" border="0" cellspacing="0" cellpadding="0">
  echo '<tr><td>';-->
<?php
  if (($righe_trovate) < 1) {
  echo '<div class="fine-ricerca">';
  switch($lingua) {
  case "it":
  echo "Nessun risultato corrisponde alla ricerca effettuata";
  break;
  case "en":
  echo "No match";
  break;
  case "fr":
  echo "No match";
  break;
  case "de":
  echo "No match";
  break;
  case "es":
  echo "No match";
  break;
  }
  echo "</div>";
  }
//fine if criterio
}
?>
<!--  echo "</td></tr>";
</table><br>-->
<table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">
    <?php
//posizione per paginazione
$prev_page = $page - 1;

if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?negozio_ricerca=".$negozio_ricerca."&criterio=".$criterio."&asc_desc=".$asc_desc."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=Ricerca&limit=".$limit."&page=".$prev_page."&lang=".$lingua."&ordinamento=".$ordinamento."><b><<</b></a>"; 
} 
for($a = 1; $a <= $total_pages; $a++) {
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("  <a href=".$_SERVER['PHP_SELF']."?negozio_ricerca=".$negozio_ricerca."&criterio=".$criterio."&asc_desc=".$asc_desc."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=Ricerca&limit=".$limit."&page=".$a."&lang=".$lingua."&ordinamento=".$ordinamento."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?negozio_ricerca=".$negozio_ricerca."&criterio=".$criterio."&asc_desc=".$asc_desc."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&posizione=Ricerca&limit=".$limit."&page=".$next_page."&lang=".$lingua."&ordinamento=".$ordinamento."><b>>></b></a>"; 
}
}

?>
        </td>
      </tr>
    </table> 
    </div>
</div>
</body>
</html>
