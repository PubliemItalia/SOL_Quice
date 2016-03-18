<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$ads = $_GET['ads'];
$rid = $_GET['rid'];
$id = $_GET['id'];
$id_prod = $_GET['id_prod'];
$quant = $_GET['quant'];
$mode = $_GET['mode'];
$tipologia = $_GET['tipologia'];
$lingua = $_SESSION['lang'];
$negozio = $_GET['negozio'];
$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id_prod'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$ric_mag = $rigad[ric_mag];
$um = $rigad[um];
}
				switch ($lingua) {
					case "it":
					$puls_carr = "Inserisci nel carrello";
					break;
					case "en":
					$puls_carr = "Add to cart";
					break;
					}
if ($quant > 0) {
switch($mode) {
		case "1":
		  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		break;
		case "0":
		  if ($quant > 150) {
		  $output .= "<input type=submit name=submit disabled style=\"float:right; height:25px;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		  } else {
		  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
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
		  if (($quant < $quant_inf) OR ($quant > $quant_sup)) {
		  $output .= "<input type=submit name=submit disabled style=\"float:right; height:25px;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		  } else {
		  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		  }
		  
		break;
		case "3":
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
		  if (($quant < $quant_inf) OR ($quant > $quant_sup)) {
		  $output .= "<input type=submit name=submit disabled style=\"float:right; height:25px;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		  } else {
		  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		  }		  
		break;
		case "4":
		  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		  
		break;
	}
	} else {
switch($mode) {
		case "1":
		  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		break;
		default:
		  $output .= "<input type=submit name=submit disabled style=\"float:right; height:25px;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
		break;
}
	}
echo $output;
 ?>
