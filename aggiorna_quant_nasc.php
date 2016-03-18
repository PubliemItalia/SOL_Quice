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
$lingua = $_GET['lang'];
$negozio = $_GET['negozio'];
$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id_prod'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$ric_mag = $rigad[ric_mag];
$um = $rigad[um];
}
if ($ads != "") {
  $sqlm = "SELECT * FROM qui_messaggi_carrello WHERE ric_mag = '$ric_mag'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	switch ($lingua) {
	  case "it":
	  $messaggio_carrello = $rigam[testo_it];
	  break;
	  case "en":
	  $messaggio_carrello = $rigam[testo_en];
	  break;
	}
  }
$output .= $messaggio_carrello;//output finale
} else {
	if ($quant > 0) {
switch($mode) {
		case "1":
		  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE id = '$id'";
		  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  while ($rigag = mysql_fetch_array($risultg)) {
			$quant = $rigag[quant];
			$prezzo = $rigag[prezzo];
		  }
			$output .= "<input type=hidden name=blocco id=blocco value=0>";//output finale
		  $output .= "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=".$quant.">";//output finale
		break;
		case "0":
		  if ($quant > 150) {
			$output .= "<input type=hidden name=blocco id=blocco value=1>";//output finale
		  } else {
			$output .= "<input type=hidden name=blocco id=blocco value=0>";//output finale
		  }
		  $output .= "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";//output finale
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
			$output .= "<input type=hidden name=blocco id=blocco value=1>";//output finale
		  } else {
			$output .= "<input type=hidden name=blocco id=blocco value=0>";//output finale
		  }
		  $output.= "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";//output finale
		  
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
			$output .= "<input type=hidden name=blocco id=blocco value=1>";//output finale
		  } else {
			$output .= "<input type=hidden name=blocco id=blocco value=0>";//output finale
		  }
		  $output.= "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";//output finale
		  
		break;
		case "4":
		if ($negozio == "labels") {
			  $n_fogli = ceil($quant/$etich_x_foglio);
			  $quant_totale = ($n_fogli * $etich_x_foglio);
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		} else {
			  $quant_totale = $quant;
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		}
		  $output .= "<input type=hidden name=blocco id=blocco value=0>";//output finale
		  $output.= "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";//output finale
		  
		break;
	}
	} else {
		  $output .= "<input type=hidden name=blocco id=blocco value=1>";//output finale
		  $output.= "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";//output finale
	}
}
echo $output;
 ?>
