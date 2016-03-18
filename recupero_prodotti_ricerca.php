<?php
session_start();
///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
$lingua = $_SESSION[lang];
$limit = $_SESSION[limit];
$page = $_SESSION[page];
$categoria1 = $_SESSION[categoria1];
$categoria2 = $_SESSION[categoria2];
$categoria3 = $_SESSION[categoria3];
$categoria4 = $_SESSION[categoria4];
$ordinamento = $_SESSION[ordinamento];
$asc_desc = $_SESSION[asc_desc];
$codiceDaModulo = $_SESSION[codice];
$nazioneDaModulo = $_SESSION[nazione_ric];
$descrizioneDaModulo = $_SESSION[descrizione];
$negozio = $_SESSION[negozio];


if ($codiceDaModulo != "") {
$a = "codice_art LIKE '%$codiceDaModulo%'";
$clausole++;
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
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$h = "paese = '$paese'";
$clausole++;
}



//costruzione query, query diversa a seconda del negozio prescelto
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
}
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
$testoQuery .= $h;
}
}

//} else {
//$testoQuery .= "WHERE obsoleto = '' ";
}
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
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);


$testoQuery .= " ORDER BY ".$ordinamento." ".$asc_desc." LIMIT $set_limit, $limit";

//echo "testoQuery: ".$testoQuery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
?>
<?php
if ($negozio_ricerca > 0) {
$questa_pag = $_SERVER['PHP_SELF'];
echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
  echo "<tr>";
    echo "<td width=661 class=ecoformdestra>";
	//echo $elementi_pagina;
	echo "</td>";
    echo "<td width=339 class=ecoformdestra> <div align=right>".$lista1." | ".$griglia." | <a href=".$questa_pag."?limit=10&page=1&criterio=".$criterio."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&asc_desc=".$asc_desc."&posizione=Ricerca&ordinamento=".$ordinamento.">10</a> | <a href=".$questa_pag."?limit=25&page=1&negozio_ricerca=".$negozio_ricerca."&criterio=".$criterio."&codice=".$codiceDaModulo."&descrizione=".$descrizioneDaModulo."&asc_desc=".$asc_desc."&posizione=Ricerca&ordinamento=".$ordinamento.">25</a> | <a href=".$questa_pag."?limit=50&page=1&criterio=".$criterio."&negozio_ricerca=".$negozio_ricerca."&codice=".$codiceDaModulo."&asc_desc=".$asc_desc."&descrizione=".$descrizioneDaModulo."&posizione=Ricerca&ordinamento=".$ordinamento.">50</a>";
    echo "</div></td>";
  echo "</tr>";
echo "</table>";
}
?>
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
    <th width="485" class="vessel"><?php
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
    <th width="80" class="price"><?php
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
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
echo "<td class=code>";
echo $row[codice_art];
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
if ($row[foto] != "") {

echo "<img src=files/".$row[foto]." width=19 height=19>";
}
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
echo "<td class=open>";
echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=600')\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<div title=\"$tooltip_visualizza_scheda\" class=\"btn btnLente\"><a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"></a></div>";
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";

//echo "<div title=\"".$tooltip_inserisci_carrello."\" class=\"btn btnCarrello19x19\"><a href=\"javascript:void(0);\" onMouseOver=\"window.opener.closeAllchildren()\" onclick=\"PopupCenter('popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"></a>";
echo "</td>";
echo "</tr>"; 
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
 $sf = 1;
//inizia il corpo della tabella
$resultb = mysql_query($queryb);
while ($row = mysql_fetch_array($resultb)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
echo "<td class=code>";
echo $row[codice_art];
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
if ($row[foto] != "") {

echo "<img src=files/".$row[foto]." width=19 height=19>";
}
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
echo "<td class=open>";
echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<div title=\"$tooltip_visualizza_scheda\" class=\"btn btnLente\"><a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"></a></div>";
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";


//echo "<div title=\"".$tooltip_inserisci_carrello."\" class=\"btn btnCarrello19x19\"><a href=\"javascript:void(0);\" onMouseOver=\"window.opener.closeAllchildren()\" onclick=\"PopupCenter('popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"></a>";
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
 $sf = 1;
//inizia il corpo della tabella
$resultc = mysql_query($queryc);
while ($row = mysql_fetch_array($resultc)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
echo "<td class=code>";
echo $row[codice_art];
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
if ($row[foto] != "") {

echo "<img src=files/".$row[foto]." width=19 height=19>";
}
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
echo "<td class=open>";
echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<div title=\"$tooltip_visualizza_scheda\" class=\"btn btnLente\"><a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"></a></div>";
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";

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
 $sf = 1;
//inizia il corpo della tabella
$resultd = mysql_query($queryd);
while ($row = mysql_fetch_array($resultd)) {
$data_leggibile = date("d.m.Y",$row[data]);
if ($sf == 1) {
echo "<tr class=\"row ".$sfondo_righe_tab."\">";
} else {
echo "<tr class=\"row bianco\">";
}
echo "<td class=code>";
echo $row[codice_art];
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
if ($row[foto] != "") {

echo "<img src=files/".$row[foto]." width=19 height=19>";
}
echo "</td>";
echo "<td class=price>";
echo number_format($row[prezzo],2,",",".");
echo "</td>";
echo "<td class=open>";
echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";

//echo "<div title=\"$tooltip_visualizza_scheda\" class=\"btn btnLente\"><a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"></a></div>";
echo "</td>";
echo "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
echo "</td>";
echo "<td class=cart>";
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({url:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";

//echo "<div title=\"".$tooltip_inserisci_carrello."\" class=\"btn btnCarrello19x19\"><a href=\"javascript:void(0);\" onMouseOver=\"window.opener.closeAllchildren()\" onclick=\"PopupCenter('popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"></a>";
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

//fine if criterio
}
?>
</table><br>
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
    <?php //echo "sessione carrello: ".$_SESSION[carrello]."<br>"; ?>
<img src="immagini/spacer.gif" width="25" height="25">
    </div>
