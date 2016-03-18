<?php
session_start();
switch ($_SESSION[lang]) {
	case "it":
	$dic_prezzo = "Prezzo";
	$dic_quant = "Quantit&agrave;";
	$dic_fogli = "fogli da";
	$dic_etichette = "etichette";
	break;
	case "en":
	$dic_prezzo = "Price";
	$dic_quant = "Quantity";
	$dic_fogli = "sheets with";
	$dic_etichette = "labels";
	break;
}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$rid = $_GET['rid'];
$id = $_GET['id'];
$id_prod = $_GET['id_prod'];
$quant = $_GET['quant'];
$mode = $_GET['mode'];
$tipologia = $_GET['tipologia'];
switch($mode) {
case "3":
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' ORDER BY quant ASC LIMIT 1";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
		$quant_inf = $rigag[quant];	  
	  }
	  $sqlh = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' ORDER BY quant DESC LIMIT 1";
	  $risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigah = mysql_fetch_array($risulth)) {
		$quant_sup = $rigah[quant];	  
	  }
 if ($quant < $quant_inf) {
switch ($_SESSION[lang]) {
	case "it":
	  $output = "La quantit&agrave; minima di prodotto acquistabile &egrave; ".$quant_inf." pezzi";
	  break;
	case "en":
	  $output = "The minimum buyable product amount is ".$quant_inf." pieces";
	  break;
}
  }
  
if ($quant > $quant_sup) {
switch ($_SESSION[lang]) {
case "it":
$output = "Per i quantitativi superiori al massimo proposto (".$quant_sup.") contattare il buyer di riferimento:<br><a href=mailto:p.naccini@sol.it>p.naccini@sol.it</a>";
break;
case "en":
$output = "For amounts greater than the fixed maximum quantity (".$quant_sup.") please contact the buyer:<br><a href=mailto:p.naccini@sol.it>p.naccini@sol.it</a>";
break;
}
}
break;
case "2":
$array_min = array();
  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant ASC LIMIT 1";
  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigag = mysql_fetch_array($risultg)) {
	  $quant_inf = $rigag[quant];
  }
  $sqlH = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant DESC LIMIT 1";
  $risultH = mysql_query($sqlH) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigaH = mysql_fetch_array($risultH)) {
	  $quant_sup = $rigaH[quant];
  }
  if ($quant < $quant_inf) {
switch ($_SESSION[lang]) {
	case "it":
	  $output = "La quantit&agrave; minima di prodotto stampabile in tipografia &egrave; ".$quant_inf." pezzi";
	  break;
	case "en":
	  $output = "The minimum product amount printable by typography is ".$quant_inf." pieces";
	  break;
}
  }
  
if ($quant > $quant_sup) {
switch ($_SESSION[lang]) {
case "it":
$output = "Per i quantitativi superiori al massimo proposto (".$quant_sup.") contattare il buyer di riferimento:<br><a href=mailto:p.naccini@sol.it>p.naccini@sol.it</a>";
break;
case "en":
$output = "For amounts greater than the fixed maximum quantity (".$quant_sup.") please contact the buyer:<br><a href=mailto:p.naccini@sol.it>p.naccini@sol.it</a>";
break;
}
}
break;
case "0":
if ($quant > 150) {
switch ($_SESSION[lang]) {
	case "it":
	  $output = "La quantità massima possibile per la stampa laser è di 150 pezzi";
	  break;
	case "en":
	  $output = "The max product amount printable in laser technology is 150 pieces";
	  break;
}
} else {
$output = "";
  }

break;
}
//output finale
echo $output;
 ?>
