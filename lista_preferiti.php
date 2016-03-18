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
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'preferiti'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
  }
		$codice_php_testatina_righe = $blocco_testatina_righe;
    switch ($lingua) {
	  case "":
	  case "it":
		$testata_id_ordine = "ID CARRELLO";
		$testata_data = "DATA";
		$unita = "UNIT&Agrave;";
		$testata_utente = "NOME UTENTE";
		$testata_responsabile = "RESPONSABILE";
		$testata_totale = "TOTALE";
		$testata_status = "";
		$dicitura_codice = "Codice";
		$dicitura_nazione = "Nazione";
		$dicitura_descrizione = "Descrizione";
		$dicitura_confezione = "Confezione";
		$dicitura_prezzo = "Prezzo";
		$dicitura_quantita = "";
		$dicitura_totale = "";
		$dicitura_stato = "";
	  break;
	  case "en":
		$testata_id_ordine = "CART ID";
		$testata_data = "DATE";
		$unita = "UNIT";
		$testata_utente = "USER NAME";
		$testata_responsabile = "MANAGER";
		$testata_totale = "TOTAL";
		$testata_status = "";
		$dicitura_codice = "Code";
		$dicitura_nazione = "Country";
		$dicitura_descrizione = "Description";
		$dicitura_confezione = "Packing";
		$dicitura_prezzo = "Price";
		$dicitura_quantita = "";
		$dicitura_totale = "";
		$dicitura_stato = "";
	  break;
  }
  $codice_php_testatina_righe = str_replace("*codice_riga*",$dicitura_codice,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*nazione_riga*",$dicitura_nazione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*descrizione_riga*",$dicitura_descrizione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*confezione_riga*",$dicitura_confezione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*prezzo_riga*",$dicitura_prezzo,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*quant_riga*",$dicitura_quantita,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*totale_riga*",$dicitura_totale,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*stato_prodotto*",$dicitura_stato,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*bottone_select_all*",$bottone_select_all,$codice_php_testatina_righe);
echo $codice_php_testatina_righe;
?>

  <?php
 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
//echo "risultati: ".mysql_num_rows($result);
while ($row = mysql_fetch_array($result)) {
	$codice_php_singola_riga = $blocco_singola_riga;
  $sql = "SELECT * FROM qui_prodotti_".$row[negozio]." WHERE id = '".$row[id_prod]."'";
  $resultb = mysql_query($sql);
  while ($rowx = mysql_fetch_array($resultb)) {
	switch($lingua) {
	  case "it":
	  $sost_descrizione = stripslashes($rowx[descrizione1_it]);
	  break;
	  case "en":
	  $sost_descrizione = stripslashes($rowx[descrizione1_en]);
	  break;
	  case "fr":
	  $sost_descrizione = stripslashes($rowx[descrizione_fr]);
	  break;
	  case "de":
	  $sost_descrizione = stripslashes($rowx[descrizione_de]);
	  break;
	  case "es":
	  $sost_descrizione = stripslashes($rowx[descrizione_es]);
	  break;
	}
	$categoria1_it = $rowx[categoria1_it];
	$categoria2_it = $rowx[categoria2_it];
	$categoria3_it = $rowx[categoria3_it];
	$rif_famiglia = $rowx[rif_famiglia];
	$codice_art = stripslashes($rowx[codice_art]);
	$sost_nazione = $rowx[paese];
	$negozio = $rowx[negozio];
	$foto = $rowx[foto];
	$sost_confezione = $rowx[confezione];
	$sost_prezzo = number_format($rowx[prezzo],2,",",".");
	switch ($rowx[azienda_prodotto]) {
		case "":
		case "SOL":
		  $sost_logo = '<img src="immagini/bottone-sol.png">';
		break;
		case "VIVISOL":
		  $sost_logo = '<img src="immagini/bottone-vivisol.png">';
		break;
	}
  }
	
  if (substr($codice_art,0,1) != "*") {
	$sost_codice_art = $codice_art;
  } else {
	$sost_codice_art = substr($codice_art,1);
  }

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
	  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'ricerca_prodotti.php?schedaVis=1&categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=".$paese."&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  } else {
	  $bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
  }
  
  $bottone_stella = "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id_prod]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
  
  if ($categoria3_it == "") {
  $bottone_carrello = "<a href=ricerca_prodotti.php?categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$paese."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
  } else {
	$bottone_carrello = "<a href=scheda_visuale.php?categoria1=".$categoria1_it."&categoria2=".$categoria2_it."&categoria3=".$categoria3_it."&paese=&nazione_ric=&negozio=".$negozio."&codice_art=".$cod_ricerca."&lang=".$lingua."&paese=".$paese."><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
  }
  $cod_ricerca = "";
  $sfondo = "";
  $id_prod = "";
	$data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_nazione*",$sost_nazione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_confezione*",$sost_confezione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_prezzo*",$sost_prezzo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_carrello*",$bottone_carrello,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_stella*",$bottone_stella,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$sost_logo = '';
  echo $codice_php_singola_riga;
$codice_php_singola_riga = '';
}
?>
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
