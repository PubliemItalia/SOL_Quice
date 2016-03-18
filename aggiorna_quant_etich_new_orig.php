<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$rid = $_GET['rid'];
$ads = $_GET['ads'];
$id = $_GET['id'];
$id_prod = $_GET['id_prod'];
$quant = $_GET['quant'];
$mode = $_GET['mode'];
$tipologia = $_GET['tipologia'];
$negozio = $_GET['negozio'];
$prezzo_pescante = $_GET['prezzo_pescante'];
$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id_prod'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$etich_x_foglio = $rigad[art_x_conf];
$etich_x_laser = $rigad[art_x_conf_ric];
if (($rigad[negozio] = "assets") AND ($rigad[categoria1_it] = "Bombole")) {
	if ($prezzo_pescante > 0) {
		$descrizione_art .= " - ".$dic_pescante;
	}
//recupero informazioni valvola
if ($rigad[id_valvola] != "") {
  $sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigad[id_valvola]'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$prezzo_valvola = $rigam[prezzo];
  }
}
//recupero informazioni cappellotto
if ($rigad[id_cappellotto] != "") {
  $sqln = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigad[id_cappellotto]'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
  while ($rigan = mysql_fetch_array($risultn)) {
	$prezzo_cappellotto = $rigan[prezzo];
  }
}
$prezzo_un_prodotto = $rigad[prezzo] + $prezzo_valvola + $prezzo_cappellotto + $prezzo_pescante;
} else {
$prezzo_un_prodotto = $rigad[prezzo];
}
$ric_mag = $rigad[ric_mag];
$um = $rigad[um];
$posx = stripos($um,"-");
switch ($_SESSION[lang]) {
	case "it":
$confezione = $rigad[confezione];
	$dic_da = "da";
	$dic_prezzo = "Prezzo euro";
	$dic_quant = "Quantit&agrave;";
	$dic_fogli = "fogli da";
	$dic_etichette = "etichette";
	$quant_bassa = "Quantit&agrave; non consentita";
	$quant_alta = "<a href=\"mailto:d.cassini@sol.it?subject=Richiesta preventivo etichette cod. ".$rigad[codice_art]."&bcc=mara.girardi@publiem.it;diego.sala@publiem.it\">Clicca qui per richiedere preventivo</a>";
	break;
	case "en":
	$dic_da = "of";
	$dic_prezzo = "Price euro";
	$dic_quant = "Quantity";
	$dic_fogli = "sheets with";
	$dic_etichette = "labels";
	$quant_bassa = "Wrong quantity";
	$quant_alta = "<a href=\"mailto:d.cassini@sol.it?subject=Quotation request for labels code ".$rigad[codice_art]."&bcc=mara.girardi@publiem.it;diego.sala@publiem.it\">Ask for a quotation</a>";
$confezione = str_replace("confezioni da", "package of",$rigad[confezione]);
$confezione = str_replace("blocchi da", "blocks of",$confezione);
$confezione = str_replace("fogli da", "sheets of",$confezione);
$confezione = str_replace("blister singoli", "one piece",$confezione);
$confezione = str_replace("bustina singola", "one bag",$confezione);
$confezione = str_replace("etichetta singola", "one label",$confezione);
$confezione = str_replace("etichette", "labels",$confezione);
$confezione = str_replace("fogli", "sheets",$confezione);
$confezione = str_replace("bustine", "bags",$confezione);
	break;
}
}
if ($posx > 0) {
	$array_um = explode("-",$um);
	$unit = $array_um[0];
	$conf = $array_um[1];
} else {
$unit = $um;
}
switch ($_SESSION[lang]) {
  case "it":
	$unit = $unit;
	$conf = $conf;
  break;
  case "en":
  $unit = str_replace("confezioni", "packages",$unit);
  $unit = str_replace("blocchi", "blocks",$unit);
  $unit = str_replace("fogli", "sheets",$unit);
  $unit = str_replace("bustine", "bags",$unit);
  $unit = str_replace("etichette", "labels",$unit);
  $unit = str_replace("fogli", "sheets",$unit);
  $unit = str_replace("pezzi", "pieces",$unit);
  $conf = str_replace("confezioni", "packages",$conf);
  $conf = str_replace("blocchi", "blocks",$conf);
  $conf = str_replace("fogli", "sheets",$conf);
  $conf = str_replace("bustine", "bags",$conf);
  $conf = str_replace("etichette", "labels",$conf);
  $conf = str_replace("fogli", "sheets",$conf);
  $conf = str_replace("pezzi", "pieces",$conf);
  break;
}
if ($negozio == "labels") {


	  $sqlf = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' ORDER BY quant ASC LIMIT 1";
	  $risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaf = mysql_fetch_array($risultf)) {
		$quant_min = $rigaf[quant];
	  }
	  $sqlb = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' ORDER BY quant DESC LIMIT 1";
	  $risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigab = mysql_fetch_array($risultb)) {
		$quant_max = $rigab[quant];
	  }
}

switch ($mode) {
	case "0":
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia'";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
		$prezzo_unitario = $rigag[prezzo_unitario];
	  }
	  if ($etich_x_foglio > 0) {
	  $n_fogli = ceil($quant/$etich_x_foglio);
	  }
	  $prezzo = $n_fogli * $prezzo_unitario;
	break;
	case "1":
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE id = '$id'";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
		$quant = $rigag[quant];
		$prezzo = $rigag[prezzo];
	  }
	  if ($etich_x_foglio > 0) {
	  $n_fogli = ceil($quant/$etich_x_foglio);
	  }
	break;
	case "2":
	  $array_min = array();
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant ASC";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
		if ($rigag[quant] <= $quant) {
		  $quant_inf = $rigag[quant];
		  $prezzo_min = $rigag[prezzo];
		} else {
		  $quant_sup = $rigag[quant];
		  $prezzo_max = $rigag[prezzo];
		}
	  }
	  $diff_quant = $quant_sup - $quant_inf;
	  $distanza = $quant - $quant_inf;
	  $diff_prezzo = $prezzo_max - $prezzo_min;
	  if ($diff_quant > 0) {
		$rapp_incr = $diff_prezzo/$diff_quant;
		$prezzo = $prezzo_min+($rapp_incr*$distanza);	  
	  } else {
		$prezzo = $prezzo_min;	  
	  }
	break;
	case "3":
	$array_quant_precostituite = array();
	  $sqli = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant < '$quant' ORDER BY quant DESC LIMIT 1";
	  $risulti = mysql_query($sqli) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigai = mysql_fetch_array($risulti)) {
		  if (!in_array($rigai[quant],$array_quant_precostituite)) {
			$add_quant_prec = array_push($array_quant_precostituite,$rigai[quant]);
		  }
	  }
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant < '$quant' ORDER BY quant DESC LIMIT 1";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
		$quant_inf = $rigag[quant];
		$prezzo_min = $rigag[prezzo];
	  }
	  $sqlh = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant > '$quant' ORDER BY quant ASC LIMIT 1";
	  $risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigah = mysql_fetch_array($risulth)) {
		$quant_sup = $rigah[quant];	  
		$prezzo_max = $rigah[prezzo];
	  }
	  $diff_quant = $quant_sup - $quant_inf;
	  $diff_prezzo = $prezzo_max - $prezzo_min;
	  $n_fogli = ceil($quant/$etich_x_foglio);
	  $quant_totale = $n_fogli*$etich_x_foglio;
	  $distanza = $quant_totale - $quant_inf;
	  if ($diff_quant > 0) {
		$rapp_incr = $diff_prezzo/$diff_quant;
		$prezzo = $prezzo_min+($rapp_incr*$distanza);	  
	  } else {
		$prezzo = $prezzo_min;	  
	  }
	break;
	case "4":
		//$output .= " MODE 4";
		if ($negozio == "labels") {
			  $n_fogli = ceil($quant/$etich_x_foglio);
			  $quant_totale = ($n_fogli * $etich_x_foglio);
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		} else {
			  $quant_totale = $quant;
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		}
	break;
}
$array_modes = array("0","1","2","3");
if ($rid != "") {
	if (in_array($mode,$array_modes)) {
	  if (($quant < $quant_inf) OR ($quant > $quant_sup)) {
		$output .= "";
	  } else {
		$output .= number_format($prezzo,2,",",".");
	  }
	} else {
	  if ($quant_totale == 0) {
	  $output .= number_format($prezzo_un_prodotto,2,",",".");
	  } else {
	$output .= number_format($prezzo,2,",",".");
	  }
	}
} else {
  if ($mode == 2) {
	if (($quant < $quant_inf) OR ($quant > $quant_sup)) {
	  $output .= "";
	} else {
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left; margin-left:2px;\">";
	  $output .= $dic_quant." ".$unit;
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left;text-align:right;\">";
	  $output .= $quant;
	  $output .= "</div>";
		//if ($n_fogli != "") {
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
//		$output .= " (".$n_fogli." ".$dic_fogli." ".$etich_x_foglio." ".$dic_etichette.")";
		if (trim($conf) == "") {
			$output .= " (".$n_fogli." ".$unit.")";
		} else {
			$output .= " (".$n_fogli." ".$conf." ".$dic_da." ".$etich_x_foglio." ".$unit.")";
		}
			
		$output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
	  $output .= "</div>";
		//}
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left;\">";
	  $output .= $dic_prezzo;
	  $output .= "<input type=hidden name=quant_totale id=quant_totale value=".$quant.">";
	  $output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo.">";
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; text-align:right; font-size:16px;\">";
	  $output .= number_format($prezzo,2,",",".");
	  $output .= "</div>";
	}
  }
  if ($mode == 3) {
	if (!in_array($quant,$array_quant_precostituite)) {
	  $output .= "<span style=\"text-decoration:none; color:red;\">".$quant_alta."</span>";
	} else {
	  $sqln = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant = '$quant'";
	  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigan = mysql_fetch_array($risultn)) {
		$prezzo = $rigan[prezzo];
	  }
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left; margin-left:2px;\">";
	  $output .= $dic_quant." ".$unit;
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left;text-align:right;\">";
	  $output .= $quant_totale;
	  $output .= "</div>";
		//if ($n_fogli != "") {
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
	  if (trim($conf) == "") {
		  $output .= " (".$n_fogli." ".$unit.")";
	  } else {
		  $output .= " (".$n_fogli." ".$conf." ".$dic_da." ".$etich_x_foglio." ".$unit.")";
	  }
	  $output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
	  $output .= "</div>";
		//}
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left; margin-left:2px;\">";
	  $output .= $dic_prezzo;
	  $output .= "<input type=hidden name=quant_totale id=quant_totale value=".$quant_totale.">";
	  if ($quant_totale == 0) {
	  $output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo_un_prodotto.">";
	  } else {
	  $output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo.">";
	  }
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; font-size:16px;text-align:right;\">";
	  $output .= number_format($prezzo,2,",",".");
	  $output .= "</div>";
	}
  }
  if (($mode == 0) OR ($mode == 1)) {
  
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left; margin-left:2px;\">";
	  $output .= $dic_quant." ".$unit;
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left;text-align:right;\">";
	  $output .= $quant;
	  $output .= "</div>";
		//if ($n_fogli != "") {
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
		if (trim($conf) == "") {
			$output .= " (".$n_fogli." ".$unit.")";
		} else {
			$output .= " (".$n_fogli." ".$conf." ".$dic_da." ".$etich_x_foglio." ".$unit.")";
		}
		$output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
	  $output .= "</div>";
		//}
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left;\">";
	  $output .= $dic_prezzo;
	  $output .= "<input type=hidden name=quant_totale id=quant_totale value=".$quant.">";
	  $output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo.">";
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; margin-left:2px; font-size:16px;text-align:right;\">";
	  $output .= number_format($prezzo,2,",",".");
	  $output .= "</div>";
  }
  if ($mode == 4) {
  
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left; margin-left:2px;\">";
	  $output .= $dic_quant;
	  if ($negozio == "labels") {
		$output .= " ".$unit;
	  }
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; text-align:right;\">";
	  $output .= $quant_totale;
	  $output .= "</div>";
		//if ($n_fogli != "") {
	  if ($negozio == "labels") {
		$output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
			if (trim($conf) == "") {
				$output .= " (".$n_fogli." ".$unit.")";
			} else {
				$output .= " (".$n_fogli." ".$conf." ".$dic_da." ".$etich_x_foglio." ".$unit.")";
			}
		  $output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
		$output .= "</div>";
	  }
		//}
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left; margin-left:2px;\">";
	  $output .= $dic_prezzo;
	  $output .= "<input type=hidden name=quant_totale id=quant_totale value=".$quant_totale.">";
	  if ($quant < 1) {
	  $output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo_un_prodotto.">";
	  $output .= "<input type=hidden name=prezzo_unitario id=prezzo_unitario value=".$prezzo_un_prodotto.">";
	  } else {
	  $output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo.">";
	  $output .= "<input type=hidden name=prezzo_unitario id=prezzo_unitario value=".$prezzo_un_prodotto.">";
	  }
	  $output .= "</div>";
	  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; font-size:16px;text-align:right;\">";
	  $output .= number_format($prezzo,2,",",".");
	  $output .= "</div>";
  }
}
//output finale
echo $output;
//echo "n_fogli: ".$n_fogli."<br>quant: ".$quant."<br>da ".$etich_x_foglio;
 ?>
