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
include "query.php";
include "functions.php";
$azione_form = $_SERVER['PHP_SELF'];
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
<script type="text/javascript" src="tinybox.js"></script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  window.location.href = window.location.href;
}
</SCRIPT>
</head>
<?php
if ($_GET['modifica_quant']!= "") {
echo "<body onLoad=window.open('popup_notifica.php?avviso=mod_carrello','Conferma modifica carrello', 'height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
} else {
echo "<body>";
}

?>
<div id="main_container">
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="661" class="ecoformdestra"></td>
    <td width="339" class="Stile_griglia"> <div align="right"><?php echo $lista1; ?> | <?php echo $griglia; ?> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=10&page=1">10</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=25&page=1">25</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=50&page=1">50</a>
          <!-- | <a href="<?php //echo $_SERVER['PHP_SELF']; ?>?limit=20&page=1">20</a> | <a href="<?php //echo $_SERVER['PHP_SELF']; ?>?limit=50&page=1">50</a>-->
    </div></td>
  </tr>
</table>
    <table width=960 border="0" cellpadding="0" cellspacing="0">
  <tr class="rowHead"> 
<!-- TESTATA colonna codice-->
<th width="90" class="codeTitle"><?php
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
    ?></th>
<th width="70" class="capacity"><?php echo $testata_nazione; ?></th>
    <th width="300" class="vessel"><?php
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
    ?></th>
     <th width="80" class="capacity"><?php
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
    ?></th>
    <th width="90" class="capacity"><?php echo $testata_prezzo; ?> &euro;</th>
    <th width="150" class="capacity"><?php echo $testata_quant; ?></th>
    <th width="90" class="capacity"><?php echo $testata_totale; ?></th>
    <th width="45" class="capacity"></th>
    <th width="45" class="capacity"></th>
    </tr>
  <?php
  if ($carrello != "") {
 if ($carrello_attivo == 1) {
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
$query = "UPDATE qui_righe_carrelli SET prezzo = '$prezzo_riga', totale = '$totale_prodotto_riga_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

} 
  $queryb = "SELECT SUM(totale) as somma FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_carrello = $somma;
//}
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0' ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
//*******************************************
//RIFERIMENTO PER RITORNO A LISTA
//*******************************************
/*$queryc = "SELECT * FROM qui_prodotti WHERE id = '$row[id_prodotto]'";
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$codice = $rowc[codice_art];
$tipo = $rowc[tipo];
$materiale = $rowc[materiale];
$colore = $rowc[colore];
$prezzo = $rowc[prezzo];
switch($lingua) {
case "it":
$descrizione_art = $rowc[descrizione_it];
break;
case "en":
$descrizione_art = $rowc[descrizione_en];
break;
case "fr":
$descrizione_art = $rowc[descrizione_fr];
break;
case "de":
$descrizione_art = $rowc[descrizione_de];
break;
case "es":
$descrizione_art = $rowc[descrizione_es];
break;
}
}
*/
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
$paese = $rowh[paese];
$confezione = $rowh[confezione];
$tipo = $rowh[tipo];
$prezzo = $rowh[prezzo];
}
//echo "<form name=carrello method=get action=carrello.php#".$row[id].">";
echo "<form name=carrello method=get action=carrello.php>";


if ($sf == 1) {
echo "<tr class=\"row carrelloColor\">";
//echo "<tr class=\"row ".$sfondo_righe_tab."\">";
//$sfondo = $sfondo_righe_tab;
//echo "<tr class=\"btnav\" onmouseover=\"style.backgroundColor='#84C1DF';\"";
//echo "onmouseout=\"style.backgroundColor='#d9e6ff'\">";
} else {
//$sfondo = "#FFFFFF";
echo "<tr class=\"row bianco\">";
//echo "<tr class=\"btnav2\" onmouseover=\"style.backgroundColor='#84C1DF';\"";
//echo "onmouseout=\"style.backgroundColor='#FFFFFF'\">";
}
//echo "<tr valign=middle class=".$sfondo.">";



echo "<td class=code>";
echo $codice_art;
echo "</td>";
echo "<td class=vessel>";
echo $paese;
echo "</td>";
echo "<td class=vessel>";
if (strlen($descr_prod) < 3) {
echo $descr_ita." <strong>(da tradurre)</strong>";
} else {
echo $descr_prod;
}
$descr_prod = "";
$descr_ita = "";
echo "</td>";
echo "<td class=gas>";
echo $confezione;
echo "</td>";
echo "<td class=price>";
echo number_format($prezzo,2,",","");
echo "</td>";
echo "<td class=price>";
if ($conferma != "") {
echo number_format($row[quant],0,",","");
} else {
//echo "<input name=quant type=text class=tabelle8 id=quant size=5 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" onBlur=\"this.form.submit()\" value=".number_format($row[quant],0,",","").">";
echo "<input name=quant type=text class=tabelle8 id=quant size=5 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" value=".number_format($row[quant],0,",","").">";
echo "<input type=submit name=button id=button value=OK>";
}
echo "<input name=lang type=hidden id=lang value=".$lingua.">";
echo "<input name=id_cart type=hidden id=id_cart value=".$row[id_carrello].">";
echo "<input name=id_prodotto type=hidden id=id_prodotto value=".$row[id_prodotto].">";
echo "<input name=id_riga type=hidden id=id_riga value=".$row[id].">";
echo "<input name=modifica_quant type=hidden id=modifica_quant value=1>";
echo "<input name=negozio type=hidden id=negozio value=carrello>";
echo "<input name=limit type=hidden id=limit value=".$limit.">";
echo "<input name=page type=hidden id=page value=".$page.">";
echo "</td>";
echo "<td class=price>";
echo number_format($row[totale],2,",","");
echo "</td>";

echo "<td class=open>";
echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$negozio_riga."&id=".$row[id_prodotto]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
echo "</td>";
/*echo "<td class=open>";
if ($conferma == "") {
echo "<input name=submit class=tabellecentro type=image value=Invia src=immagini/button_mod.gif>";
}
echo "</td>";
*/
echo "<td class=open>";
if ($conferma == "") {
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";

echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
}
echo "</td>";
echo "</tr>"; 
echo "</form>"; 
$codice = "";
$tipo = "";
$materiale = "";
$colore = "";
$prezzo = "0";
$descrizione_art = "";


if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
echo "<tr><td colspan=11><img src=immagini/spacer.gif width=960 height=10></td></tr>";
  if ($carrello != "") {
echo "<tr valign=top bgcolor=#FFFFCC>";
echo "<td colspan=2 class=tot_carrello>";
echo "<strong>".$testo_totale_carrello."<strong>";
echo "</td>";
echo "<td class=tabellecentro>";
echo "</td>";
echo "<td class=tabellecentro>";
echo "</td>";
echo "<td class=tabellecentro>";
echo "</td>";
echo "<td valign=top class=tabelledestra>";
echo "</td>";
echo "<td valign=top class=price>";
echo "<strong>".number_format($totale_carrello,2,",","")."</strong>";
echo "</td>";

echo "<td valign=top class=tabellecentro>";
echo "</td>";
echo "<td valign=top class=tabellecentro>";
echo "</td>";
echo "<td valign=top class=tabellecentro>";
echo "</td>";
echo "</tr>"; 
echo "<tr><td colspan=11><img src=immagini/spacer.gif width=960 height=10></td></tr>";
}
}
}
?>
</table>
<table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">

    <?php
//posizione per paginazione
$prev_page = $page - 1;

if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?cat=$cat&limit=$limit&page=$prev_page&lang=$lingua><b><<</b></a>"; 
} 
for($a = 1; $a <= $total_pages; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span> | "); //no link
	 } else {
  echo("  <a href=".$_SERVER['PHP_SELF']."?cat=$cat&limit=$limit&page=$a&lang=$lingua> $a </a> | ");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?cat=$cat&limit=$limit&page=$next_page&lang=$lingua><b>>></b></a>"; 
} 
?>
        </td>
      </tr>
    </table>
 <?php 
// if (($carrello_attivo == 1) AND ($carrello_ordinato == 0)) {
 if ($carrello_attivo == 1) {
/*  echo "<form name=form1 method=get action=carrello.php>";
    echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td class=grande_18rossochiaro>Note (usa quest&acute;area per annotazioni riguardanti il tuo ordine)<br>";
        echo "<textarea name=textarea style=width:960px; rows=5 class=tabelle8 id=textarea></textarea></td>";
      echo "</tr>";
      echo "<tr>";
        echo "<td>";
          echo "<div align=right>";
//echo "<input name=submit class=tabellecentro type=image value=Invia src=immagini/crea_rda.png>";
			echo "<div class=btn btnFreccia onClick=\"this.form.submit()\">";
		echo "<div align=right><strong>Crea RdA</strong></div>";
		echo "</div>";
            echo "<input type=hidden name=id_cart id=id_cart value=".$carrello.">";
            echo "<input type=hidden name=id_utente id=id_utente value=".$_SESSION[user_id].">";
            echo "<input name=lang type=hidden id=lang value=".$lingua.">";
            echo "<input name=conferma type=hidden id=conferma value=1>";
          echo "</div></td>";

      echo "</tr>";
    echo "</table>";
    echo "</form>";
*/
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
			echo "<div class=btn btnFreccia><a href=# onClick=\"this.form.submit()\">";
		echo "<div align=right><strong>Crea RdA</strong></div></a>";
		echo "</div>";
          echo "<div align=right>";
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
 ?>

</div>
</body>
</html>
