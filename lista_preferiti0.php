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
$_SESSION[percorso_ritorno] ="lista_preferiti.php?a=1&Preferiti=1&negozio=Preferiti";

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
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
$archive = $_GET['archive'];
include "functions.php";
//include "testata.php";

include "menu_quice3.php";

echo "<br>";
if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[nazione_ric] = "";
$_SESSION[descrizione] = "";
$_SESSION[negozio] = "";
$_SESSION[categoria] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";

$ordinamento = "descrizione ASC";

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query

//costruzione query
$testoQuery = "SELECT * FROM qui_preferiti WHERE id_utente = '$id_utente'";


//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 10; //default
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
  <title>Quice - Lista preferiti</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<link rel="stylesheet" href="css/report_balconi.css" />
<link rel="stylesheet" href="css/css_release_4.css" />
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
-->
</style>
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
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
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
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'rda'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testata_generale_lista_rda') {
		$blocco_testata_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'note_sing_rda') {
		$blocco_note_singola_rda = $rigav[codice_php];
	  }
  }
    switch ($lingua) {
	  case "":
	  case "it":
		$attesa_approvazione = "In attesa di approvazione";
		$attesa_gestione = "In attesa di gestione";
		$gestione = "In gestione";
		$spedito_pl = "Spedito con Packing List n. ";
		$spedito_ord = "Inoltrato al fornitore - ord. n. ";
		$spedito_sap = "Inoltrato ordine SAP n. ";
		$dicitura_aggiornata = "Aggiornato al ";
		$dicitura_codice = "Codice";
		$dicitura_nazione = "Nazione";
		$dicitura_descrizione = "Descrizione";
		$dicitura_confezione = "Confezione";
		$dicitura_prezzo = "Prezzo &euro;";
		$dicitura_quantita = "Quantit&agrave;";
		$dicitura_totale = "Totale &euro;";
		$dicitura_stato = "Stato singolo prodotto";
		$testata_totale = "TOTALE &euro;";
	  break;
	  case "en":
		$attesa_approvazione = "Awaiting approval";
		$attesa_gestione = "Awaiting process";
		$gestione = "Processing";
		$spedito_pl = "Delivered with Packing List n. ";
		$spedito_ord = "Placed Order n. ";
		$spedito_sap = "Placed SAP Order n. ";
		$dicitura_aggiornata = "Updated ";
		$dicitura_codice = "Code";
		$dicitura_nazione = "Country";
		$dicitura_descrizione = "Description";
		$dicitura_confezione = "Packing";
		$dicitura_prezzo = "Price &euro;";
		$dicitura_quantita = "Quantity";
		$dicitura_totale = "Total &euro;";
		$dicitura_stato = "Single product condition";
		$testata_totale = "TOTAL &euro;";
	  break;
  }

//echo "<!-- TESTATA colonna codice-->";
		$codice_php_testata_rda = $blocco_testata_rda;
//echo '<span style="color:#000;">fin qui ok</span><br>';
//echo '<span style="color:#000;">righe: '.mysql_num_rows($risultv).'</span><br>';

$codice_php_testata_rda = str_replace("*testata_id_ordine*",$testata_id_ordine,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_data*",$testata_data,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*unita*",$unita,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_utente*",$testata_utente,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_responsabile*",$testata_responsabile,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_totale*",$testata_totale,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_status*",$testata_status,$codice_php_testata_rda);
/**/
//testata generale di pagina
echo $codice_php_testata_rda;
?>
<table width=960 border="0" cellpadding="0" cellspacing="0">

  <tr bgcolor="#8e8e8e"> 
<!-- TESTATA colonna codice-->
<td width="10" valign="middle"><img src="immagini/spacer.gif" width="10" height="25" /></td>
<td width="80" valign="middle" class="codeTitle">
<span class="format_testata">
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
    </span></td>
<!-- TESTATA colonna nazione-->
    <td widtd="90" valign="middle" class="codeTitle_nopadding">
	<span class="format_testata">
	<?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&ordinamento=paese&";
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
	echo "<img src=immagini/arrow-asc.png widtd=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png widtd=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
    </span></td>
    <td widtd="485" valign="middle" class="codeTitle_nopadding">
    <span class="format_testata">
	<?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&ordinamento=descrizione1_it&";
	if ($ordinamento == "descrizione1_it") {
	if ($asc_desc == "ASC") {
	echo "asc_desc=DESC>";
	} else {
	echo "asc_desc=ASC>";
	}
	} else {
	echo "asc_desc=ASC>";
	}
	echo $testata_prodotto;
	if ($ordinamento == "descrizione1_it") {
	if ($asc_desc == "ASC") {
	echo "<img src=immagini/arrow-asc.png widtd=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png widtd=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
    </span></td>
    <td widtd="80" valign="middle" class="codeTitle_nopadding">
	<span class="format_testata">
	<?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio=".$negozio."&ordinamento=confezione";
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
	echo "<img src=immagini/arrow-asc.png widtd=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png widtd=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
    </span></td>
    <td widtd="80" valign="middle" class="codeTitle_dx">
	<span class="format_testata">
	<?php
    echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$page."&negozio=".$negozio."&ordinamento=prezzo&";
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
	echo "<img src=immagini/arrow-asc.png widtd=13 height=13 border=0>";
	} else {
	echo "<img src=immagini/arrow-desc.png widtd=13 height=13 border=0>";
	}
	}
	echo "</a>";
    ?>
    </span></td>
<!--    <td widtd="100" class=tabellecentro><?php //echo $testata_quant; ?></td>
-->    
    <td widtd="45" class="open">&nbsp;</td>
    <td widtd="45" class="bookmark"><?php //echo $testata_preferito; ?></td>
    <td widtd="45" class="cart"><?php //echo $testata_carrello; ?></td>
    </tr>
  <?php
 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
if ($sf == 1) {
echo '<tr style="background-color:#F0F0F0; color:#000;">';
} else {
echo '<tr style="background-color:#FFF; color:#000;">';
}
$id_prod = $row[id_prod];
switch ($row[negozio]) {
case "assets":
$sql = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prod'";
break;
case "consumabili":
$sql = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod'";
break;
case "spare_parts":
$sql = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prod'";
break;
case "labels":
$sql = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prod'";
break;
case "vivistore":
$sql = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prod'";
break;
}
$resultb = mysql_query($sql);
while ($rowx = mysql_fetch_array($resultb)) {
switch($lingua) {
case "it":
$descrizione = stripslashes($rowx[descrizione1_it]);
break;
case "en":
$descrizione = stripslashes($rowx[descrizione1_en]);
break;
case "fr":
$descrizione = stripslashes($rowx[descrizione_fr]);
break;
case "de":
$descrizione = stripslashes($rowx[descrizione_de]);
break;
case "es":
$descrizione = stripslashes($rowx[descrizione_es]);
break;
}
$categoria1_it = $rowx[categoria1_it];
$categoria2_it = $rowx[categoria2_it];
$categoria3_it = $rowx[categoria3_it];
$rif_famiglia = $rowx[rif_famiglia];
$codice_art = $rowx[codice_art];
$paese = $rowx[paese];
$negozio = $rowx[negozio];
$foto = $rowx[foto];
$confezione = $rowx[confezione];
$prezzo = $rowx[prezzo];
}
echo "<td><img src=immagini/spacer.gif width=10 height=30/>";
echo "</td>";
echo "<td class=code>";
if (substr($codice_art,0,1) != "*") {
  echo $codice_art;
} else {
  echo substr($codice_art,1);
}
echo "</td>";
echo "<td class=country>".stripslashes($paese)."</td>";
echo "<td class=vessel>";
//echo $row[id_prod]." - ".$descrizione;
echo $descrizione;
echo "</td>";
echo "<td class=gas>";
/*if ($foto != "") {
echo "<img src=files/".$foto." width=19 height=19><img src=immagini/spacer.gif width=10 height=10/>";
}
*/echo $confezione;
echo "</td>";
echo "<td class=price>";
echo number_format($prezzo,2,",",".");
echo "</td>";
/*echo "<td valign=top class=tabelledestra>";
echo "<input name=quant type=hidden class=tabelle8 id=quant value=1>";
echo "</td>";
*/
echo "<td class=open>";

//RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
if ($negozio == "consumabili") {
  if ($rif_famiglia != "") {
	$queryj = "SELECT * FROM qui_prodotti_consumabili WHERE id = '".$rif_famiglia."'";
	$resultj = mysql_query($queryj);
	while ($rowj = mysql_fetch_array($resultj)) {
	  $cod_ricerca = $rowj[codice_art];
	}
  } else {
	$cod_ricerca = $codice_art;
  }
} else {
  $cod_ricerca = $codice_art;
}
//FINE RICERCA CODICE CAPO FAMIGLIA SE PRODOTTO APPARTENENTE A FAMIGLIA
if ($categoria3_it == "") {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'ricerca_prodotti.php?schedaVis=1&categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=".$paese."&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
} else {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
echo "</td>";
echo "<td class=bookmark>";
//echo "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";

echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id_prod]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";

echo "</td>";
echo "<td class=cart>";
if ($categoria3_it == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$paese."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
} else {
  echo "<a href=scheda_visuale.php?categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$paese."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
}
//echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id_prod]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";

echo "</td>";
$cod_ricerca = "";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
$id_prod = "";
}
//echo "<tr><td colspan=8><img src=immagini/riga_prev.jpg width=960 height=1></td></tr>";
?>
</table><br>
<table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">
    <?php
//posizione per paginazione
$prev_page = $page - 1;

if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?a=1&Preferiti=1&negozio=Preferiti&limit=".$limit."&page=".$prev_page."&lang=".$lingua."><b><<</b></a>"; 
} 
for($a = 1; $a <= $total_pages; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("  <a href=".$_SERVER['PHP_SELF']."?a=1&Preferiti=1&negozio=Preferiti&limit=".$limit."&page=".$a."&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?a=1&Preferiti=1&negozio=Preferiti&limit=".$limit."&page=".$next_page."&lang=".$lingua."><b>>></b></a>"; 
} 
?>
        </td>
      </tr>
    </table> 
<img src="immagini/spacer.gif" width="25" height="25">
    </div>
</body>
</html>
