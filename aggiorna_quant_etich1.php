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
$categoria = $rigad[categoria1_it];
$etich_x_foglio = $rigad[art_x_conf];
$etich_x_laser = $rigad[art_x_conf_ric];
$art_confezione = $rigad[confezione];
if (($rigad[negozio] == "assets") AND ($rigad[categoria1_it] == "Bombole")) {
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
	//$quant_bassa = "Quantit&agrave; non consentita";
	$quant_bassa = "<a href=\"mailto:d.cassini@sol.it?subject=Richiesta preventivo etichette cod. ".$rigad[codice_art]."&bcc=mara.girardi@publiem.it;diego.sala@publiem.it\">Clicca qui per richiedere preventivo</a>";
	$quant_alta = "<a href=\"mailto:d.cassini@sol.it?subject=Richiesta preventivo etichette cod. ".$rigad[codice_art]."&bcc=mara.girardi@publiem.it;diego.sala@publiem.it\">Clicca qui per richiedere preventivo</a>";
	break;
	case "en":
	$dic_da = "of";
	$dic_prezzo = "Price euro";
	$dic_quant = "Quantity";
	$dic_fogli = "sheets with";
	$dic_etichette = "labels";
	//$quant_bassa = "Wrong quantity";
	$quant_bassa = "<a href=\"mailto:d.cassini@sol.it?subject=Quotation request for labels code ".$rigad[codice_art]."&bcc=mara.girardi@publiem.it;diego.sala@publiem.it\">Ask for a quotation</a>";
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
  if ($id != "") {
	  $sqln = "SELECT * FROM qui_pharma_quant_prezzi WHERE id = '$id'";
	  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigan = mysql_fetch_array($risultn)) {
		$quant = $rigan[quant];
		$tipologia = $rigan[tipologia];
	  }
  }
$array_quant_predeterm = array();
	  $sqlf = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' ORDER BY quant ASC";
	  $risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaf = mysql_fetch_array($risultf)) {
		  $add_quant_pred = array_push($array_quant_predeterm,$rigaf[quant]);
	  }
	  $num_quant = count($array_quant_predeterm);
	  $quant_min = $array_quant_predeterm[0];
	  $quant_max = $array_quant_predeterm[($num_quant-1)];
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
	//recupero il parametro iniziale della serie
	  $sqlj = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant = '$quant_min'";
	  $risultj = mysql_query($sqlj) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaj = mysql_fetch_array($risultj)) {
		$valore_iniziale_serie = round($rigaj[prezzo]);
		$coeff_quant_iniziale = $rigaj[coefficiente];
	  }
	  //assegno alla variabile $a il valore 1, così quando faccio il foreach sull'array comincia a fare il calcolo direttamente dal secondo elemento, 
	  //in quanto il primo è il limite inferiore e prima di quella quantità non è contemplato alcun prezzo, ma va richiesto il preventivo
	  //$a = 1;
	  foreach ($array_quant_predeterm as $sing_quant) {
		$a = $a+1;
		if ($a == 1) {
		  $quant_prec = $sing_quant;
		  $prezzo = ($valore_iniziale_serie);
		} else {
		  if ($sing_quant <= $quant) {
			$sqlh = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant = '$quant_prec'";
			$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			while ($rigah = mysql_fetch_array($risulth)) {
			  $coeff_in_uso = $rigah[coefficiente];
			}
			$prezzo = $prezzo + ((($sing_quant-$quant_prec)/100)*$coeff_in_uso);
			$quant_prec = $sing_quant;
			//F3+((($sing_quant-$quant_prec)/100)*$coeff_in_uso)+(((D11-D6)/100)*C5)+(((D21-D11)/100)*C6)+(((D51-D21)/100)*C7)
		  }
		  if ($quant <= $sing_quant) {
			$prezzo = $prezzo + ((($quant-$quant_prec)/100)*$coeff_in_uso);
		  }
		}
		//$output .= "quant_prec: ".$quant_prec."<br>";
	  }
		//$output .= "prezzo: ".$prezzo."<br>";
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
	//calcolo per approssimare il numero delle etichette alle confezioni, quando le confezioni contengono più di in pezzo
	if ($negozio == "labels") {
		$confez_tot = ceil($quant/$etich_x_foglio);
		$quant = $etich_x_foglio*$confez_tot;
	}
	//recupero il parametro iniziale della serie
	  $sqlj = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant = '$quant_min'";
	  $risultj = mysql_query($sqlj) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaj = mysql_fetch_array($risultj)) {
		$valore_iniziale_serie = round($rigaj[prezzo]);
		$coeff_quant_iniziale = $rigaj[coefficiente];
	  }
		//$output .= "valore_iniziale_serie: ".$valore_iniziale_serie."<br>";
	  //assegno alla variabile $a il valore 1, così quando faccio il foreach sull'array comincia a fare il calcolo direttamente dal secondo elemento, 
	  //in quanto il primo è il limite inferiore e prima di quella quantità non è contemplato alcun prezzo, ma va richiesto il preventivo
	  //$a = 1;
	  foreach ($array_quant_predeterm as $sing_quant) {
		$a = $a+1;
		if ($a == 1) {
		  $quant_prec = $sing_quant;
		  $prezzo = ($valore_iniziale_serie);
		} else {
			$sqlh = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND quant = '$quant_prec'";
			$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			while ($rigah = mysql_fetch_array($risulth)) {
			  $coeff_in_uso = $rigah[coefficiente];
			}
			if ($sing_quant <= $quant) {
			  $prezzo = $prezzo + ((($sing_quant-$quant_prec)/100)*$coeff_in_uso);
			  $quant_prec = $sing_quant;
			  //F3+((($sing_quant-$quant_prec)/100)*$coeff_in_uso)+(((D11-D6)/100)*C5)+(((D21-D11)/100)*C6)+(((D51-D21)/100)*C7)
			} else {
			  $n = $n+1;
			  if ($n == 1) {
				$prezzo = $prezzo + ((($quant-$quant_prec)/100)*$coeff_in_uso);
			  }
			}
		}
		//$output .= "coeff_in_uso: ".$coeff_in_uso."<br>";
		//$output .= "quant_prec: ".$quant_prec."<br>";
		//$output .= "prezzo: ".$prezzo."<br>";
	  }
		
	  if ($etich_x_foglio > 0) {
	  $n_fogli = ceil($quant/$etich_x_foglio);
	  }
	break;
	case "4":
		//$output .= " MODE 4";
		switch ($negozio) {
		  case "labels":
			  $n_fogli = ceil($quant/$etich_x_foglio);
			  $quant_totale = ($n_fogli * $etich_x_foglio);
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		  break;
		  case "consumabili":
		  $posx = stripos($um,"singolo");
		  if ($posx > 0) {
			  $quant_totale = $quant;
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		  } else {
			  $n_confezioni = ceil($quant/$art_confezione);
			  $quant_totale = ($n_confezioni * $art_confezione);
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		  }
		  break;
		  default:
			  $quant_totale = $quant;
			  $prezzo = $quant_totale * $prezzo_un_prodotto;
		  break;
		}
	break;
}
$array_modes = array("0","1","2","3");
if ($rid != "") {
	switch($mode) {
		case "0":
		case "1":
		case "2":
		  $output .= number_format($prezzo,2,",",".");
		break;
		case "3":
		  switch ($categoria) {
			  case "Bombole":
			  $prezzo_Bombole = $quant * $prezzo_un_prodotto;
			  $output .= number_format($prezzo_Bombole,2,",",".");
			  break;
			  case "Pacchi_bombole":
			  $prezzo_Bombole = $quant * $prezzo_un_prodotto;
			  $output .= number_format($prezzo_Bombole,2,",",".");
			  break;
			  default:
			  if (($quant < $quant_inf) OR ($quant > $quant_sup)) {
				$output .= "";
			  } else {
				$output .= number_format($prezzo,2,",",".");
			  }
			  break;
		  }
		break;
		case "4":
		  if ($quant_totale == 0) {
			$output .= number_format($prezzo_un_prodotto,2,",",".");
		  } else {
			$output .= number_format($prezzo,2,",",".");
		  }
		break;
	}
} else {
	switch($mode) {
		case "2":
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
		break;
case "0":
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
		break;
		case "3":
		  switch ($categoria) {
			  case "Bombole":
				$prezzo = $quant * $prezzo_un_prodotto;
				$output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left;\">";
				$output .= $dic_prezzo;
				$output .= "<input type=hidden name=quant_totale id=quant_totale value=".$quant.">";
				$output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo.">";
				$output .= "</div>";
				$output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; margin-left:2px; font-size:16px;text-align:right;\">";
				$output .= number_format($prezzo,2,",",".");
				$output .= "</div>";
			break;
			case "Pacchi_bombole":
				$prezzo = $quant * $prezzo_un_prodotto;
				$output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:200px; float:left;\">";
				$output .= $dic_prezzo;
				$output .= "<input type=hidden name=quant_totale id=quant_totale value=".$quant.">";
				$output .= "<input type=hidden name=prezzo id=prezzo value=".$prezzo.">";
				$output .= "</div>";
				$output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:90px; float:left; margin-left:2px; font-size:16px;text-align:right;\">";
				$output .= number_format($prezzo,2,",",".");
				$output .= "</div>";
			break;
			default:
			  if (($quant < $quant_min) OR ($quant > $quant_max)) {
			  if ($quant < $quant_min) {
				$output .= "<span style=\"text-decoration:none; color:red;\">".$quant_bassa."</span>";
			  }
			  if ($quant > $quant_max) {
				$output .= "<span style=\"text-decoration:none; color:red;\">".$quant_alta."</span>";
			  }
			  } else {
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
			  break;
		  }
		break;
		case "1":
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
		break;
		case "4":
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
	  switch ($negozio) {
		case "labels":
		  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
			  if (trim($conf) == "") {
				  $output .= " (".$n_fogli." ".$unit.")";
			  } else {
				  $output .= " (".$n_fogli." ".$conf." ".$dic_da." ".$etich_x_foglio." ".$unit.")";
			  }
			$output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
		  $output .= "</div>";
		break;
		default:
		  switch ($_SESSION[lang]) {
			  case "it":
				$conf = "confezioni";
				$unit = "articoli";
				$dic_da = "da";
			  break;
			  case "en":
				$conf = "packages";
				$unit = "items";
				$dic_da = "of";
			  break;
		  }
		  if ($um == "Articolo_singolo") {
			if ($art_confezione > 1) {
			  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
					  $output .= " (".$quant." ".$conf." ".$dic_da." ".$art_confezione." ".$unit.")";
				//$output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
			  $output .= "</div>";
			} else {
			  $output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
					  $output .= " (".$quant." ".$unit.")";
				//$output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
			  $output .= "</div>";
			}
		  } else {
			$output .= "<div class=\"colonnino_interno_riga_dispari\" style=\"width:300px; float:left;\">";
					$output .= " (".$n_confezioni." ".$conf." ".$dic_da." ".$art_confezione." ".$unit.")";
			  //$output .= "<input type=hidden name=fogli id=fogli value=".$n_fogli.">";
			$output .= "</div>";
		  }
		break;
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
		break;
  }
}
//output finale
echo $output;
//echo "n_fogli: ".$n_fogli."<br>quant: ".$quant."<br>da ".$etich_x_foglio;
 ?>
