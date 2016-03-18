<div id="ricerca" style="width:100%; min-height:100px; overflow:hidden; height:auto; background-color: #ddd; margin-bottom: 20px; color:#000; float:left;">
  <div id=formRicerca>
  <?php
	  if ($arc == "1") {
		  $doc = "R";
	  }
//echo 'doc: '.$doc.'<br>';
//IL CAMPO UNITA' SI CHIAMA COSì DAPPERTUTTO
if ($_POST['unita'] != "") {
$unitaDaModulo = $_POST['unita'];
}
if ($unitaDaModulo != "") {
  $a = "id_unita = '$unitaDaModulo'";
$clausole++;
}
//PER IL CAMPO CATEGORIA BISOGNA DISTINGUERE A SECONDA DELLA TABELLA
if ($_POST['categoria_righe'] != "") {
$categ_DaModulo = $_POST['categoria_righe'];
} 
if ($categ_DaModulo != "") {
	switch ($file_presente) {
		default:
		  $b = "categoria = '$categ_DaModulo'";
		break;
		case "report_scorte_magazzino.php":
		  $b = "categoria1_it = '$categ_DaModulo'";
		break;
	}
$clausole++;
}
//IL CAMPO DATA SI CHIAMA COSì DAPPERTUTTO
if ($_POST['data_inizio'] != "") {
$data_inizio = $_POST['data_inizio'];
} 
if ($_POST['data_fine'] != "") {
$data_fine = $_POST['data_fine'];
} 
if ($data_inizio != "") {
if ($data_fine == "") {
$data_fine = date("d/m/Y",mktime());
}
}
if ($data_fine != "") {
if ($data_inizio == "") {
$pezzi_data_fine = explode("/",$data_fine);
$data_inizio = "01/".$pezzi_data_fine[1]."/".$pezzi_data_fine[2];
}
}
if ($data_inizio != "") {
$pieces_inizio = explode("/", $data_inizio);
$gginizio = $pieces_inizio[0]; 
$mminizio = $pieces_inizio[1];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
$ggfine = $pieces_fine[0]; 
$mmfine = $pieces_fine[1];
$aaaafine = $pieces_fine[2];
$fine_range = mktime(23,59,59,intval($mmfine), intval($ggfine), intval($aaaafine));
}
if (($inizio_range != "") AND ($fine_range != "")) {
if ($inizio_range > $fine_range) {
$campidate = "";
} else {
$campidate = 1;
	switch ($file_presente) {
		default:
		  $c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
		break;
		case "report_fatturazione.php":
		  $c = "(data_chiusura BETWEEN '$inizio_range' AND '$fine_range')";
		break;
		case "lista_pl.php":
		  $c = "(data_spedizione BETWEEN '$inizio_range' AND '$fine_range')";
		break;
		case "ordini.php":
		  $c = "(data_ordine BETWEEN '$inizio_range' AND '$fine_range')";
		break;
	}
$clausole++;
}
} else {
$campidate = "";
}
//PER IL CAMPO NEGOZIO BISOGNA ESCLUDERE IL FILE DELLE SCORTE DALLA RICERCA, IN QUANTO è IL NOME DELLA TABELLA
if ($_POST['shop'] != "") {
$shopDaModulo = $_POST['shop'];
} 
if ($shopDaModulo != "") {
	switch ($file_presente) {
		default:
		  $d = "negozio = '$shopDaModulo'";
		  $clausole++;
		break;
		case "report_scorte_magazzino.php":
		break;
	}
}
//PER IL CAMPO NR RDA BISOGNA DISTINGUERE A SECONDA DELLA TABELLA
if ($_POST['nr_rda'] != "") {
$nrRdaDaModulo = $_POST['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
	switch ($file_presente) {
		default:
		  $e = "id_rda = '$nrRdaDaModulo'";
		break;
		case "report_rda.php":
		  $e = "id = '$nrRdaDaModulo'";
		break;
		case "lista_pl.php":
		  $e = "rda LIKE '%$nrRdaDaModulo%'";
		break;
	}
$clausole++;
}
//PER IL CAMPO SOCIETA' BISOGNA DISTINGUERE A SECONDA DELLA TABELLA
if ($_POST['societa'] != "") {
$societaDaModulo = $_POST['societa'];
} 
if ($societaDaModulo != "") {
	switch ($file_presente) {
		default:
		  $f = "azienda_prodotto = '$societaDaModulo'";
		break;
		case "ordini.php":
		case "lista_pl.php":
		  $f = "logo = '$societaDaModulo'";
		break;
		case "report_scorte_magazzino.php":
		  $f = "azienda = '$societaDaModulo'";
		break;
	}
$clausole++;
}
//IL CAMPO codice art SI CHIAMA COSì DAPPERTUTTO
if ($_POST['codice_art'] != "") {
$codice_artDaModulo = $_POST['codice_art'];
} 
if ($codice_artDaModulo != "") {
$g = "codice_art = '$codice_artDaModulo'";
$clausole++;
}
//PER IL CAMPO NR PL BISOGNA DISTINGUERE A SECONDA DELLA TABELLA
if ($_POST['nr_pl'] != "") {
$nrPlDaModulo = $_POST['nr_pl'];
} 
if ($nrPlDaModulo != "") {
	switch ($file_presente) {
		case "lista_pl.php":
		  $h = "id = '$nrPlDaModulo'";
		break;
		case "report_fatturazione.php":
		  $h = "n_ord_sap LIKE '%$nrPlDaModulo%'";
		break;
	}
$clausole++;
}

switch ($file_presente) {
	case "report_fatturazione.php":
	  $j = "pack_list > '0'";
	  $clausole++;
	  switch ($doc) {
		  case "G":
		  case "F":
			$m = "n_ord_sap = ''";
			$clausole++;
			//$ordinamento = "pack_list DESC";
		  break;
		  case "R":
			$m = "n_ord_sap != ''";
			$doc = "F";
			$arc = "1";
			$clausole++;
			//$ordinamento = "pack_list DESC";
		  break;
	  }
	  $l = "flag_chiusura = '1'";
	  $clausole++;
	break;
}

if ($_GET['archivio'] != "") {
$archivioDaModulo = $_GET['archivio'];
} 
//if ($archivioDaModulo != "") {
	switch ($archivioDaModulo) {
		/*case "":
		$n = "n_fatt_sap = ''";
		$clausole++;
		break;*/
		case "0":
		break;
		case "1":
		$n = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "2":
		$n = "n_fatt_sap != ''";
		$clausole++;
		break;
	}
if ($_POST['nr_fatt'] != "") {
$nr_fattDaModulo = $_POST['nr_fatt'];
} 
if ($nr_fattDaModulo != "") {
	switch ($file_presente) {
		case "report_fatturazione.php":
		  $p = "n_fatt_sap LIKE '%$nr_fattDaModulo%'";
		break;
	}
$clausole++;
}
//	}


//costruzione query

if ($clausole == 1) {
if ($a != "") {
$queryaccessoria .= $a;
}
if ($b != "") {
$queryaccessoria .= $b;
}
if ($c != "") {
$queryaccessoria .= $c;
}
if ($d != "") {
$queryaccessoria .= $d;
}
if ($e != "") {
$queryaccessoria .= $e;
}
if ($f != "") {
$queryaccessoria .= $f;
}
if ($g != "") {
$queryaccessoria .= $g;
}
if ($h != "") {
$queryaccessoria .= $h;
}
if ($j != "") {
$queryaccessoria .= $j;
}
if ($l != "") {
$queryaccessoria .= $l;
}
if ($m != "") {
$queryaccessoria .= $m;
}
if ($n != "") {
$queryaccessoria .= $n;
}
if ($p != "") {
$queryaccessoria .= $p;
}
} else {
if ($a != "") {
$queryaccessoria .= $a." AND ";
}
if ($b != "") {
$queryaccessoria .= $b." AND ";
}
if ($c != "") {
$queryaccessoria .= $c." AND ";
}
if ($d != "") {
$queryaccessoria .= $d." AND ";
}
if ($e != "") {
$queryaccessoria .= $e." AND ";
}
if ($f != "") {
$queryaccessoria .= $f." AND ";
}
if ($g != "") {
$queryaccessoria .= $g." AND ";
}
if ($h != "") {
$queryaccessoria .= $h." AND ";
}
if ($j != "") {
$queryaccessoria .= $j." AND ";
}
if ($l != "") {
$queryaccessoria .= $l." AND ";
}
if ($m != "") {
$queryaccessoria .= $m." AND ";
}
if ($n != "") {
$queryaccessoria .= $n." AND ";
}
if ($p != "") {
$queryaccessoria .= $p;
}
}
//ARRAYS CONDIZIONALI PER QUERY TENDINE
$array_societa = array("report_righe_admin.php", "lista_pl.php", "report_fatturazione.php", "ordini_sap.php", "ordini.php", "report_righe_nuovo.php", "report_righe_mag.php", "report_righe_mag_publiem.php");
$array_negozi = array("report_righe_admin.php", "report_rda.php", "report_fatturazione.php", "ordini_sap.php", "ordini.php", "report_righe_nuovo.php", "report_righe_mag.php", "report_righe_mag_publiem.php");
$array_unita = array("report_righe_admin.php", "report_rda.php", "lista_pl.php", "report_fatturazione.php", "report_righe_nuovo.php", "report_righe_mag.php", "report_righe_mag_publiem.php");
$array_categorie = array("report_righe_admin.php", "report_righe_nuovo.php", "report_righe_mag.php", "report_righe_mag_publiem.php");
//tendina società
if (in_array($file_presente,$array_societa)) {
	  switch ($file_presente) {
		  case "ordini.php":
			if ($clausole > 0) {
			  $tendSoc = "SELECT DISTINCT logo FROM qui_ordini_for WHERE ".$queryaccessoria;
			} else {
			  $tendSoc = "SELECT DISTINCT logo FROM qui_ordini_for";
			}
		  break;
		  case "lista_pl.php":
			if ($clausole > 0) {
			  $tendSoc = "SELECT DISTINCT logo FROM qui_packing_list WHERE ".$queryaccessoria;
			} else {
			  $tendSoc = "SELECT DISTINCT logo FROM qui_packing_list";
			}
		  break;
		  case "report_fatturazione.php":
			if ($clausole > 0) {
			  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ".$queryaccessoria;
			} else {
			  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%'";
			}
		  break;
		  case "ordini_sap.php":
		  case "report_righe_admin.php":
		  case "report_righe_nuovo.php":
		  case "report_righe_mag_publiem.php":
			if ($clausole > 0) {
			  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
			} else {
			  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4')";
			}
		  break;
		  case "report_righe_mag.php":
			if ($clausole > 0) {
			  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0' AND ".$queryaccessoria;
			} else {
			  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
			}
		  break;
		  case "report_scorte_magazzino.php":
			if ($clausole > 0) {
			  $tendSoc = "(SELECT azienda FROM qui_prodotti_consumabili WHERE ".$queryaccessoria.") UNION (SELECT azienda FROM qui_prodotti_assets WHERE ".$queryaccessoria.") UNION (SELECT azienda FROM qui_prodotti_labels WHERE ".$queryaccessoria.") UNION (SELECT azienda FROM qui_prodotti_spare_parts WHERE ".$queryaccessoria.") UNION (SELECT azienda FROM qui_prodotti_vivistore WHERE ".$queryaccessoria.")";
			} else {
			  $tendSoc = "(SELECT azienda FROM qui_prodotti_consumabili) UNION (SELECT azienda FROM qui_prodotti_assets) UNION (SELECT azienda FROM qui_prodotti_labels) UNION (SELECT azienda FROM qui_prodotti_spare_parts) UNION (SELECT azienda FROM qui_prodotti_vivistore)";
			}
		  break;
	  }
  /*
  
  if ($clausole > 0) {
  //$tendSoc = "SELECT DsISTINCT azienda_prodotto FROM qui_righe_rda WHERE stato_ordine = '3' AND ".$queryaccessoria;
  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
  } else {
  $tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4')";
  }
  */
  $lungSOC = strlen($tendSoc);
  $finaleSOC = substr($tendSoc,($lungSOC-5),5);
  if ($finaleSOC == " AND ") {
  $tendSoc = substr($tendSoc,0,($lungSOC-5));
  }
  switch ($file_presente) {
	default:
	  $tendSoc .= " ORDER BY azienda_prodotto ASC";
	break;
	case "ordini.php":
	case "lista_pl.php":
	  $tendSoc .= " ORDER BY logo ASC";
	break;
	case "report_scorte_magazzino.php":
	  $tendSoc .= " ORDER BY azienda ASC";
	break;
  }
  //echo 'tendSoc: '.$tendSoc.'<br>';
  if ($societaDaModulo == "") {
	  $classe_societa = "amministrazione_grigio";
  } else {
	 switch ($file_presente) {
	  case "ordini.php":
	  case "ordini_sap.php":
	  case "report_fatturazione.php":
		$classe_societa = "amministrazione_arancio";
	  break;
	  case "report_scorte_magazzino.php":
	  case "report_righe_admin.php":
	  case "report_rda.php":
	  case "lista_pl.php":
		$classe_societa = "amministrazione_blu";
	  break;
	}
 }
  $tendina_societa = '<select name="societa" class="'.$classe_societa.'" id="societa" style="height:27px; width:90%;" onchange="msc(this.id,this.value)"><option selected value="">Tutte le societ&agrave;</option>';
  $resSOC = mysql_query($tendSoc) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
  while ($rigaSOC = mysql_fetch_array($resSOC)) {
  switch ($file_presente) {
	default:
	if ($rigaSOC[azienda_prodotto] != "") {
	  if ($rigaSOC[azienda_prodotto] == $societaDaModulo) {
		  $tendina_societa .= '<option selected value="'.$rigaSOC[azienda_prodotto].'">'.strtoupper($rigaSOC[azienda_prodotto]).'</option>';
	  } else {
		  $tendina_societa .= '<option value="'.$rigaSOC[azienda_prodotto].'">'.strtoupper($rigaSOC[azienda_prodotto]).'</option>';
	  }
	}
	break;
	case "ordini.php":
	case "lista_pl.php":
	if ($rigaSOC[logo] != "") {
	  if ($rigaSOC[logo] == $societaDaModulo) {
		  $tendina_societa .= '<option selected value="'.$rigaSOC[logo].'">'.strtoupper($rigaSOC[logo]).'</option>';
	  } else {
		  $tendina_societa .= '<option value="'.$rigaSOC[logo].'">'.strtoupper($rigaSOC[logo]).'</option>';
	  }
	}
	break;
	case "report_scorte_magazzino.php":
	if ($rigaSOC[azienda] != "") {
	  if ($rigaSOC[azienda] == $societaDaModulo) {
		  $tendina_societa .= '<option selected value="'.$rigaSOC[azienda].'">'.strtoupper($rigaSOC[azienda]).'</option>';
	  } else {
		  $tendina_societa .= '<option value="'.$rigaSOC[azienda].'">'.strtoupper($rigaSOC[azienda]).'</option>';
	  }
	}
	break;
  }
  }
  $tendina_societa .= '</select>';
}
//fine tendina società

//tendina negozi
if (in_array($file_presente,$array_negozi)) {
	switch ($file_presente) {
		case "ordini.php":
		  if ($clausole > 0) {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_ordini_for WHERE ".$queryaccessoria;
		  } else {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_ordini_for";
		  }
		break;
		case "report_rda.php":
		  if ($clausole > 0) {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_rda WHERE (stato BETWEEN '2' AND '4') AND ".$queryaccessoria;
		  } else {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_rda WHERE (stato BETWEEN '2' AND '4')";
		  }
		break;
		case "report_fatturazione.php":
			if ($clausole > 0) {
			  $tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ".$queryaccessoria;
			} else {
			  $tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%'";
			}
		break;
		case "report_righe_mag.php":
		  if ($clausole > 0) {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0' AND ".$queryaccessoria;
		  } else {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
		  }
		break;
		case "ordini_sap.php":
		case "report_righe_admin.php":
		case "report_righe_nuovo.php":
		case "report_righe_mag_publiem.php":
		  if ($clausole > 0) {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
		  } else {
			$tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4')";
		  }
		break;
		  case "report_scorte_magazzino.php":
			if ($clausole > 0) {
			  $tendSHOP = "(SELECT negozio FROM qui_prodotti_consumabili WHERE ".$queryaccessoria.") UNION (SELECT negozio FROM qui_prodotti_assets WHERE ".$queryaccessoria.") UNION (SELECT negozio FROM qui_prodotti_labels WHERE ".$queryaccessoria.") UNION (SELECT negozio FROM qui_prodotti_spare_parts WHERE ".$queryaccessoria.") UNION (SELECT negozio FROM qui_prodotti_vivistore WHERE ".$queryaccessoria.")";
			} else {
			  $tendSHOP = "(SELECT negozio FROM qui_prodotti_consumabili) UNION (SELECT negozio FROM qui_prodotti_assets) UNION (SELECT negozio FROM qui_prodotti_labels) UNION (SELECT negozio FROM qui_prodotti_spare_parts) UNION (SELECT negozio FROM qui_prodotti_vivistore)";
			}
		  break;
	}

$lungSHOP = strlen($tendSHOP);
$finaleSHOP = substr($tendSHOP,($lungSHOP-5),5);
if ($finaleSHOP == " AND ") {
$tendSHOP = substr($tendSHOP,0,($lungSHOP-5));
}
$tendSHOP .= " ORDER BY negozio ASC";

  if ($shopDaModulo == "") {
	  $classe_negozio = "amministrazione_grigio";
  } else {
	 switch ($file_presente) {
	  case "ordini.php":
	  case "ordini_sap.php":
	  case "report_fatturazione.php":
		$classe_negozio = "amministrazione_arancio";
	  break;
	  case "report_scorte_magazzino.php":
	  case "report_righe_admin.php":
	  case "report_rda.php":
	  case "lista_pl.php":
		$classe_negozio = "amministrazione_blu";
	  break;
	}
 }
$tendina_negozio = '<select name="shop" class="'.$classe_negozio.'" id="shop" style="height:27px; width:90%;" onchange="msc(this.id,this.value)"><option selected value="">Tutti i negozi</option>';
$resSHOP = mysql_query($tendSHOP) or die("Impossibile eseguire l'interrogazione11" . mysql_error());
while ($rigaSHOP = mysql_fetch_array($resSHOP)) {
  if ($rigaSHOP[negozio] == $shopDaModulo) {
	  $tendina_negozio .= '<option selected value="'.$rigaSHOP[negozio].'">'.str_replace("_"," ",$rigaSHOP[negozio]).'</option>';
  } else {
	  $tendina_negozio .= '<option value="'.$rigaSHOP[negozio].'">'.str_replace("_"," ",$rigaSHOP[negozio]).'</option>';
  }
}
$tendina_negozio .= '</select>';
}
//fine tendina negozi

//tendina unità
if (in_array($file_presente,$array_unita)) {
	switch ($file_presente) {
		case "report_rda.php":
		  if ($clausole > 0) {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_rda WHERE (stato BETWEEN '2' AND '4') AND ".$queryaccessoria;
			} else {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_rda WHERE (stato BETWEEN '2' AND '4')";
		  }
		break;
		case "lista_pl.php":
		  if ($clausole > 0) {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_packing_list WHERE ".$queryaccessoria;
			} else {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_packing_list";
		  }
		break;
		case "report_fatturazione.php":
			if ($clausole > 0) {
			  $tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ".$queryaccessoria;
			} else {
			  $tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%'";
			}
		break;
		case "report_righe_mag.php":
		  if ($clausole > 0) {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0' AND ".$queryaccessoria;
		  } else {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
		  }
		break;
		case "report_righe_nuovo.php":
		case "report_righe_admin.php":
		case "report_righe_mag_publiem.php":
		  if ($clausole > 0) {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
			} else {
			$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4')";
		  }
		break;
	}

$lungUNI = strlen($tendUNI);
$finaleUNI = substr($tendUNI,($lungUNI-5),5);
if ($finaleUNI == " AND ") {
$tendUNI = substr($tendUNI,0,($lungUNI-5));
}
		  $tendUNI .= " ORDER BY nome_unita ASC";

  if ($unitaDaModulo == "") {
	  $classe_unita = "amministrazione_grigio";
  } else {
	 switch ($file_presente) {
	  case "ordini.php":
	  case "ordini_sap.php":
	  case "report_fatturazione.php":
		$classe_unita = "amministrazione_arancio";
	  break;
	  case "report_scorte_magazzino.php":
	  case "report_righe_admin.php":
	  case "report_rda.php":
	  case "lista_pl.php":
		$classe_unita = "amministrazione_blu";
	  break;
	}
 }
  $tendina_unita = '<select name="unita" class="'.$classe_unita.'" id="unita" style="height:27px; width: 90%;" onchange="msc(this.id,this.value)"><option selected value="">Tutte le unit&agrave;</option>';
$resUNI = mysql_query($tendUNI) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
while ($rigaUNI = mysql_fetch_array($resUNI)) {
  if ($rigaUNI[id_unita] == $unitaDaModulo) {
	  $tendina_unita .= '<option selected value="'.$rigaUNI[id_unita].'">'.strtoupper($rigaUNI[nome_unita]).'</option>';
  } else {
	  $tendina_unita .= '<option value="'.$rigaUNI[id_unita].'">'.strtoupper($rigaUNI[nome_unita]).'</option>';
  }
}
$tendina_unita .= '</select>';
}
   //echo 'tendUNI: '.$tendUNI.'<br>';
//fine tendina unità
// tendina categoria
if (in_array($file_presente,$array_categorie)) {
	switch ($file_presente) {
		default:
		  if ($clausole > 0) {
			$tendCATEG = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
			} else {
			$tendCATEG = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4')";
		  }
		  $lungCATEG = strlen($tendCATEG);
		  $finaleCATEG = substr($tendCATEG,($lungCATEG-5),5);
		  if ($finaleCATEG == " AND ") {
		  $tendCATEG = substr($tendCATEG,0,($lungCATEG-5));
		  }
			$tendCATEG .= " ORDER BY categoria ASC";
		  $resCATEG = mysql_query($tendCATEG) or die("Impossibile eseguire l'interrogazione13" . mysql_error());
		  while ($rigaCATEG = mysql_fetch_array($resCATEG)) {
			if ($rigaCATEG[categoria] != "") {
			  if ($rigaCATEG[categoria] == $categ_DaModulo) {
				  $opzioni_categoria .= '<option selected value="'.$rigaCATEG[categoria].'">'.str_replace("_"," ",$rigaCATEG[categoria]).'</option>';
			  } else {
				  $opzioni_categoria .= '<option value="'.$rigaCATEG[categoria].'">'.str_replace("_"," ",$rigaCATEG[categoria]).'</option>';
			  }
			}
		  }
		break;
		case "report_righe_mag.php":
		  if ($clausole > 0) {
			$tendCATEG = "SELECT categoria FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0' AND ".$queryaccessoria;
		  } else {
			$tendCATEG = "SELECT categoria FROM qui_righe_rda WHERE stato_ordine = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
		  }
		break;
		  case "report_scorte_magazzino.php":
			if ($clausole > 0) {
			  $tendCATEG = "(SELECT categoria1_it FROM qui_prodotti_consumabili WHERE ".$queryaccessoria.") UNION (SELECT categoria1_it FROM qui_prodotti_assets WHERE ".$queryaccessoria.") UNION (SELECT categoria1_it FROM qui_prodotti_labels WHERE ".$queryaccessoria.") UNION (SELECT categoria1_it FROM qui_prodotti_spare_parts WHERE ".$queryaccessoria.") UNION (SELECT categoria1_it FROM qui_prodotti_vivistore WHERE ".$queryaccessoria.")";
			} else {
			  $tendCATEG = "(SELECT `categoria1_it` FROM qui_prodotti_consumabili) UNION (SELECT `categoria1_it` FROM qui_prodotti_assets) UNION (SELECT `categoria1_it` FROM qui_prodotti_labels) UNION (SELECT `categoria1_it` FROM qui_prodotti_spare_parts) UNION (SELECT `categoria1_it` FROM qui_prodotti_vivistore)";
			}
 			$tendCATEG .= " ORDER BY categoria1_it ASC";
		  $resCATEG = mysql_query($tendCATEG) or die("Impossibile eseguire l'interrogazione13" . mysql_error());
		  while ($rigaCATEG = mysql_fetch_array($resCATEG)) {
			if ($rigaCATEG[categoria1_it] != "") {
			  if ($rigaCATEG[categoria1_it] == $categ_DaModulo) {
				  $opzioni_categoria .= '<option selected value="'.$rigaCATEG[categoria1_it].'">'.str_replace("_"," ",$rigaCATEG[categoria1_it]).'</option>';
			  } else {
				  $opzioni_categoria .= '<option value="'.$rigaCATEG[categoria1_it].'">'.str_replace("_"," ",$rigaCATEG[categoria1_it]).'</option>';
			  }
			}
		  }
		  break;
	}

  if ($categ_DaModulo == "") {
	  $classe_categ = "amministrazione_grigio";
  } else {
	 switch ($file_presente) {
	  case "ordini.php":
	  case "ordini_sap.php":
	  case "report_fatturazione.php":
		$classe_categ = "amministrazione_arancio";
	  break;
	  case "report_scorte_magazzino.php":
	  case "report_righe_admin.php":
	  case "report_rda.php":
	  case "lista_pl.php":
		$classe_categ = "amministrazione_blu";
	  break;
	}
 }
$tendina_categoria = '<select name="categoria_righe" class="'.$classe_categ.'" id="categoria_righe" style="height:27px; width: 90%;" onchange="msc(this.id,this.value)"><option selected value="">Tutte le categorie </option>'.$opzioni_categoria;
$tendina_categoria .= '</select>';
}
//fine tendina categoria

//tendina status

switch ($statusDaModulo) {
	case "sap":
	$new_class = ' stato_rda-cyano';
	break;
	case "mag":
	$new_class = ' stato_rda-arancio';
	break;
	case "lab":
	$new_class = ' stato_rda-grey';
	break;
	case "ord":
	$new_class = ' stato_rda-green';
	break;
	default:
	$new_class = '';
	break;
}
		  //$tendina_stato .= '<select name="status" class="ecoform '.$new_class.'" id="status"  style="height:27px; width: 90%;" onchange="ricarica_con_stato(this.value)">';
		  $tendina_stato .= '<select name="status" class="ecoform '.$new_class.'" id="status"  style="height:27px; width: 90%;">';
		  switch($statusDaModulo) {
			  case "":
				$tendina_stato .= '<option class="stato_rda-bianco" selected value="">Tutte</option>';
				$tendina_stato .= '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				$tendina_stato .= '<option class="stato_rda-cyano" value="sap">SAP</option>';
				$tendina_stato .= '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				$tendina_stato .= '<option class="stato_rda-grey" value" value="lab">LABELS</option>';
				$tendina_stato .= '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "no_process":
				$tendina_stato .= '<option class="stato_rda-bianco" value="">Tutte</option>';
				$tendina_stato .= '<option class="stato_rda-bianco" selected value="no_process">In attesa di gestione</option>';
				$tendina_stato .= '<option class="stato_rda-cyano" value="sap">SAP</option>';
				$tendina_stato .= '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				$tendina_stato .= '<option class="stato_rda-grey" value="lab">LABELS</option>';
				$tendina_stato .= '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "sap":
				$tendina_stato .= '<option class="stato_rda-bianco" value="">Tutte</option>';
				$tendina_stato .= '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				$tendina_stato .= '<option class="stato_rda-cyano" selected value="sap">SAP</option>';
				$tendina_stato .= '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				$tendina_stato .= '<option class="stato_rda-grey" value="lab">LABELS</option>';
				$tendina_stato .= '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "mag":
				$tendina_stato .= '<option class="stato_rda-bianco" value="">Tutte</option>';
				$tendina_stato .= '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				$tendina_stato .= '<option class="stato_rda-cyano" value="sap">SAP</option>';
				$tendina_stato .= '<option class="stato_rda-arancio" selected value="mag">MAGAZZINO</option>';
				$tendina_stato .= '<option class="stato_rda-grey" value="lab">LABELS</option>';
				$tendina_stato .= '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "lab":
				$tendina_stato .= '<option class="stato_rda-bianco" value="">Tutte</option>';
				$tendina_stato .= '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				$tendina_stato .= '<option class="stato_rda-cyano" value="sap">SAP</option>';
				$tendina_stato .= '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				$tendina_stato .= '<option class="stato_rda-grey" selected value="lab">LABELS</option>';
				$tendina_stato .= '<option class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
			  case "ord":
				$tendina_stato .= '<option class="stato_rda-bianco" value="">Tutte</option>';
				$tendina_stato .= '<option class="stato_rda-bianco" value="no_process">In attesa di gestione</option>';
				$tendina_stato .= '<option class="stato_rda-cyano" value="sap">SAP</option>';
				$tendina_stato .= '<option class="stato_rda-arancio" value="mag">MAGAZZINO</option>';
				$tendina_stato .= '<option class="stato_rda-grey" value="lab">LABELS</option>';
				$tendina_stato .= '<option selected class="stato_rda-green" value="ord">ORDINI</option>';
			  break;
		  }
		  $tendina_stato .= '</select>';
//fine tendina status

///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
//echo 'file_presente: '.$file_presente.'<br>';
	echo '<div id="motore_ricerca" style="width: 100%; min-height: 100px; overflow: hidden; height: auto; display:block;">
	<form action="'.$file_presente.'" method="get" name="form_filtri2" style="margin-bottom: 0em !important;">';
	//colonna 5-->
	echo '<div style="padding: 15px; float:left; min-height:128px; overflow:hidden; height:auto; width:118px; background-color: #ededed; margin-right:15px;">';
	switch ($file_presente) {
		default:
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Data inizio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="data_inizio" type="text" class="datepicker" id="data_inizio" style="width:98%; height:27px;" value="'.$data_inizio.'" onclick="calend(this.id)" onchange="controllo_data(this.value); msc_data_inizio(this.id,this.value)">
		  </div>
		  <div  style="width: 100%; float: left; height: 20px;">
			<strong>Data fine</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 25px;">
			<input name="data_fine" type="text" class="datepicker" id="data_fine" style="width:98%; height:27px;" value="'.$data_fine.'" onclick="calend(this.id)" onchange="msc(this.id,this.value)">
		  </div>';
		break;
		case "report_righe_mag.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Data inizio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="data_inizio" type="text" class="datepicker" id="data_inizio" style="width:98%; height:27px;" value="'.$data_inizio.'" onclick="calend(this.id)" onchange="controllo_data(this.value)">
		  </div>
		  <div  style="width: 100%; float: left; height: 20px;">
			<strong>Data fine</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 25px;">
			<input name="data_fine" type="text" class="datepicker" id="data_fine" style="width:98%; height:27px;" value="'.$data_fine.'" onclick="calend(this.id)">
		  </div>';
		break;
		case "report_scorte_magazzino.php":
		break;
	}
	switch ($file_presente) {
		case "report_fatturazione.php":
	 echo '<div style="margin-top: 10px; width: 100%; float: left; height: 15px; font-weight: 800 !important; color: red !important; font-size: 10px !important;">
			DATE OBBLIGATORIE
		  </div>';
		break;
	}
	//fine colonna 5-->
	echo '</div>';
	//contenitore per variazione contestuale tendine
	echo '<div id="contenitore_msc" style="width: 795px; min-height:100px; overflow:hidden; height:auto; display:block; float:left;">';
	//colonna 1-->
	echo '<div style="margin-top: 15px; float:left; width:153px;">';
	 
	  switch ($file_presente) {
		  default:
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Societ&agrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_societa.'</div>';
		  break;
		  case "report_rda.php":
			echo '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Unit&agrave;</strong>
			</div>
			<div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
		  break;
		  }
	  switch ($file_presente) {
		  default:
		  echo '<div style="width: 100%; float: left; height: 20px;">
			<strong>Negozio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_negozio.'</div>';
			break;
			case "lista_pl.php":
			//solo la listapl.php non ha il negozio ma l'unità in posizione 2 di colonna 1
			  echo '<div  style="width: 100%; float: left; height: 20px;">
				<strong>Unit&agrave;</strong>
			  </div>
			  <div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
			break;
			case "report_scorte_magazzino.php":
		  echo '<div style="width: 100%; float: left; height: 20px;">
			<strong>Negozio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_negozio.'</div>';
			break;
	  }
	//fine colonna 1-->
	echo '</div>';
	//colonna 2-->
	echo '<div style="margin-top: 15px; float:left; width:153px;" >';
	  //la tendina delle unità presenta due varianti a seconda della pagina da cui viene visualizzata
	  //nel processo solo le rda attive (stato 2 e 3), nelle altre pagine tutte le rda (stato 4)
	  switch ($file_presente) {
		case "report_scorte_magazzino.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Nazione</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="paese" type="text" class="tabelle8" style="width:90%; height:27px; padding: 0px !important;" id="paese" size="10" value="'.$paeseDaModulo.'">
		  </div>';
		break;
		case "lista_pl.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>N. PL</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_pl" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_pl" size="10" value="'.$nrPlDaModulo.'">
		  </div>';
		break;
		case "ordini.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
		case "report_righe_nuovo.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
			echo '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Unit&agrave;</strong>
			</div>
			<div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
		  break;
		case "report_fatturazione.php":
		case "report_righe_nuovo_sap.php":
		case "report_righe_admin.php":
			echo '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Unit&agrave;</strong>
			</div>
			<div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
		break;
		case "report_rda.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
	  }
	  switch ($file_presente) {
		case "report_scorte_magazzino.php":
		case "report_righe_nuovo.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CATEGORIA</strong>
		  </div>
		  <div id="divcat" style="width: 100%; float: left; height: 39px;">'.$tendina_categoria.'</div>';
		break;
		case "report_righe_nuovo_sap.php":
		case "report_righe_admin.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CATEGORIA</strong>
		  </div>
		  <div id="divcat" style="width: 100%; float: left; height: 39px;">'.$tendina_categoria.'</div>';
		break;
		case "ordini_sap.php":
		case "report_rda.php":
		case "report_fatturazione.php":
		case "lista_pl.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>N. RdA</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_rda" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_rda" size="10" value="'.$nrRdaDaModulo.'">
		  </div>';
		break;
		case "ordini.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
	  }
	//fine colonna 2-->
	echo '</div>';
	//colonna 3-->
	echo '<div style="margin-top: 15px; float:left; width:153px;">';
	  switch ($file_presente) {
		default:
		echo '<div  style="width: 100%; float: left; height: 20px;">
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
		  </div>';
		break;
		case "report_fatturazione.php":
		if ($arc == "1") {
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Fatt. SAP</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_fatt" type="text" class="tabelle8" id="nr_fatt" style="width:90%; height:27px; padding: 0px !important;" value="'.$nr_fattDaModulo.'">
		  </div>';
		} else {
		  echo '<div  style="width: 100%; float: left; height: 20px; display: none;">
			<strong>Fatt. SAP</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px; display: none;">
			<input name="nr_fatt" type="text" class="tabelle8" id="nr_fatt" style="width:90%; height:27px; padding: 0px !important;" value="'.$nr_fattDaModulo.'">
		  </div>';
		}
		break;
		case "report_scorte_magazzino.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Codice Qui C&acute;&egrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name=codice_art type=text style="width:90%; height:27px; padding: 0px !important;" id=codice_art value=';
			  if (substr($codice_artDaModulo,0,1) != "*") {
				echo $codice_artDaModulo;
			  } else {
				echo substr($codice_artDaModulo,1);
			  }
			echo '>';
		  echo '</div>';
		break;
	  }
	  switch ($file_presente) {
		default:
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
		case "report_righe_admin.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CODICE ART.</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name=codice_art type=text style="width:90%; height:27px; padding: 0px !important;" id=codice_art value=';
			  if (substr($codice_artDaModulo,0,1) != "*") {
				echo $codice_artDaModulo;
			  } else {
				echo substr($codice_artDaModulo,1);
			  }
			echo '>';
		  echo '</div>';
		break;
		case "report_righe_nuovo.php":
		case "report_righe_nuovo_sap.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>STATO RDA</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_stato.'</div>';
		break;
		case "report_fatturazione.php":
		  if ($arc == "1") {
			echo '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Ord. SAP</strong>
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			  <input name="nr_pl" type="text" class="tabelle8" id="nr_pl" style="width:90%; height:27px; padding: 0px !important;" value="'.$nr_plDaModulo.'">
			</div>';
		  } else {
			echo '<div  style="width: 100%; float: left; height: 20px; display: none;">
			  <strong>Ord. SAP</strong>
			</div>
			<div style="width: 100%; float: left; height: 39px; display: none;">
			  <input name="nr_pl" type="text" class="tabelle8" id="nr_pl" style="width:90%; height:27px; padding: 0px !important;" value="'.$nr_plDaModulo.'">
			</div>';
		  }
		break;
		case "report_rda.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>STATO ORDINE</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<select name="stato_rda" class="codice_lista_nopadding" id="stato_rda" style="height:27px; width: 90%;">';
			  if ($_SESSION[ruolo] == "admin") {
				echo "<option selected value=>".$scegli_stato."</option>";
				$sqlr = "SELECT * FROM uc_order_statuses WHERE attivo_admin = '1' ORDER BY status_php ASC";
			  }
			  /*
			  if ($_SESSION[negozio_buyer] != "") {
				$sqlr = "SELECT * FROM uc_order_statuses WHERE attivo = '1' ORDER BY status_php ASC";
			  }
			  $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
			  while ($rigar = mysql_fetch_array($risultr)) {
				switch($lingua) {
				  case "it":
					$testoStatus = $rigar[title_it];
				  break;
				  case "en":
					$testoStatus = $rigar[title];
				  break;
				}
				if ($rigar[status_php] == $stato_rdaDaModulo) {
				  echo "<option selected value=".$rigar[status_php].">".$testoStatus."</option>";
				} else {
				  echo "<option value=".$rigar[status_php].">".$testoStatus."</option>";
				}
			  }
			  */
				  echo "<option selected value=4>Completata</option>";
			echo '</select>';
		  echo '</div>';
		break;
		case "report_scorte_magazzino.php":
		  	echo '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Codice Sol</strong>
			</div>
			  <div style="width: 100%; float: left; height: 39px;">
				<input name="categoria4" type="text" style="width:90%; height:27px; padding: 0px !important;" id="categoria4" value="'.$categoria4DaModulo.'">';
			  echo '</div>';
		break;
	  }
	//fine colonna 3-->
	echo '</div>';
	//colonna 4-->
	echo '<div style="margin-top: 15px; float:left; width:153px;">';
	  switch ($file_presente) {
		default:
		echo '<div  style="width: 100%; float: left; height: 20px;">
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
		  </div>';
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
		case "report_righe_nuovo.php":
	  		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>N. RdA</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_rda" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_rda" size="10" value="'.$nr_rdaDaModulo.'">
		  </div>';
		  //<input name="nr_rda" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_rda" size="10" value="'.$nrRdaDaModulo.'" onkeyup="sost_applica_filtri(this.value)">
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CODICE ART.</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name=codice_art type=text style="width:90%; height:27px; padding: 0px !important;" id=codice_art value=""';
			  if (substr($codice_artDaModulo,0,1) != "*") {
				echo $codice_artDaModulo;
			  } else {
				echo substr($codice_artDaModulo,1);
			  }
			echo '>';
		  echo '</div>';

		break;
		case "report_scorte_magazzino.php":
		  echo '<div  style="width: 100%; float: left; height: 20px;">
		  <strong>Disponibilit&agrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">';
		  echo '<select name="dispo" class="ecoform" id="dispo"  style="height:27px; width: 90%;">';
		  switch($dispoDaModulo) {
			  case "":
				echo '<option selected value="">Tutti</option>';
				echo '<option value="1">Disponibili</option>';
				echo '<option value="0">Non disponibili</option>';
			  break;
			  case "1":
				echo '<option value="">Tutti</option>';
				echo '<option selected value="1">Disponibili</option>';
				echo '<option value="0">Non disponibili</option>';
			  break;
			  case "0":
				echo '<option value="">Tutti</option>';
				echo '<option value="1">Disponibili</option>';
				echo '<option selected value="0">Non disponibili</option>';
			  break;
		  }
		  echo '</select>';
		  echo '</div>';
		break;
		/*case "report_fatturazione.php":
		  if ($doc == "F") {
			echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>';
			switch ($_SESSION[lang]) {
				case "it":
				echo "Archivio PL";
				break;
				case "en":
				echo "PL Archive";
				break;
			}
			echo '</strong>
			</div>
			<div style="width: 100%; float: left; height: 39px;">';
			echo '<select name="archivio" class="ecoform" id="archivio"  style="height:27px; width: 90%;">';
			switch($archivioDaModulo) {
				case "":
				  echo "<option value=0>Tutti i PL</option>";
				  echo "<option selected value=1>PL Attivi</option>";
				  echo "<option value=2>PL Archiviati</option>";
				break;
				case "0":
				  echo "<option selected value=0>Tutti i PL</option>";
				  echo "<option value=1>PL Attivi</option>";
				  echo "<option value=2>PL Archiviati</option>";
				break;
				case "1":
				  echo "<option value=0>Tutti i PL</option>";
				  echo "<option selected value=1>PL Attivi</option>";
				  echo "<option value=2>PL Archiviati</option>";
				break;
				case "2":
				  echo "<option value=0>Tutti i PL</option>";
				  echo "<option value=1>PL Attivi</option>";
				  echo "<option selected value=2>PL Archiviati</option>";
				break;
			}
			echo '</select>';
			echo '</div>';
		}
			echo '<input name="doc" type="hidden" value="'.$doc.'" />';
		  break;*/
	  }
      //fine colonna 4-->
	echo '</div>';
	//colonna 5-->
/*	
	echo '<div style="margin-top: 15px; float:left; width:118px;">';
	switch ($file_presente) {
		default:
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Data inizio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="data_inizio" type="text" class="datepicker" id="data_inizio" style="width:98%; height:27px;" value="'.$data_inizio.'" onclick="calend(this.id)">
		  </div>
		  <div  style="width: 100%; float: left; height: 20px;">
			<strong>Data fine</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="data_fine" type="text" class="datepicker" id="data_fine" style="width:98%; height:27px;" value="'.$data_fine.'" onclick="calend(this.id)">
		  </div>';
		break;
		case "report_scorte_magazzino.php":
		break;
	}
	//fine colonna 5-->
	echo '</div>';
*/	
	//colonna 6-->
	  if ($arc == "1") {
		  $doc = "R";
	  }
	echo '<div style="margin-top:15px; margin-bottom:15px; float:right; width:118px; margin-right:15px;">';
	  echo '<div id="pulsante_applica" style="width: 118px; float: left; height: 32px; margin-bottom:10px;">';
	switch ($file_presente) {
		case "report_righe_nuovo.php":
		case "report_righe_nuovo_sap.php":
		case "report_scorte_magazzino.php":
		case "report_righe_admin.php":
		case "report_rda.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		case "lista_pl.php":
		echo '<div style="width: 100%; background-color:#06F; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="invioform()">
			Applica filtri
		  </div>';
		break;
		case "report_fatturazione.php":
		case "ordini_sap.php":
		case "ordini.php":
		  echo '<div style="width: 100%; background-color:#F63; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="invioform()">
			Applica filtri
		  </div>';
		break;
	}
	  echo '</div>';
	  echo '<div style="width: 100%; float: left; height: auto; margin-bottom:15px;">';
	switch ($file_presente) {
		default:
		echo '<a href="'.$file_presente.'?a=1&doc='.$doc.'"><div class="pulsantiricerca" style="width: 100%; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Reset filtri</div></a>';
		break;
		case "report_righe_nuovo.php":
		echo '<a href="report_righe_nuovo.php?status=no_process"><div class="pulsantiricerca" style="width: 100%; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; border: 2px solid #aaa;">Reset filtri</div></a>';
		 break;
	}
	  echo '</div>';
	  echo '<div style="width: 100%; float: left; height: auto; margin-bottom:5px;">';
	switch ($file_presente) {
		case "report_righe_nuovo.php":
		 echo '<a href="xls4_processo_buyer.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&societa='.$societaDaModulo.'&status='.$statusDaModulo.'" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		 break;
		case "report_fatturazione.php":
		if ($ricerca == 1) {
		 echo '<a href="xls3_fatturazione.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&nr_fatt='.$nr_fattDaModulo.'&nr_pl='.$nrPlDaModulo.'&archivio='.$archivioDaModulo.'&societa='.$societaDaModulo.'&doc='.$doc.'&flag_chiusura=1&status=4" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		} else {
		 echo '<div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold;">Esporta dati</div>';
		}
		 break;
		case "ordini_sap.php":
		if ($ricerca == 1) {
		 echo '<a href="xls5_ordini_sap.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&nr_pl='.$nrPlDaModulo.'&archivio='.$archivioDaModulo.'&societa='.$societaDaModulo.'&doc='.$doc.'&output_mode='.$output_modulo.'&flag_chiusura='.$flag_chiusura.'&status=4" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		} else {
		 echo '<div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold;">Esporta dati</div>';
		}
		 break;
		case "report_righe_admin.php":
		if ($ricerca == 1) {
		 echo '<a href="xls2_righe_rda.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&nr_pl='.$nrPlDaModulo.'&archivio='.$archivioDaModulo.'&societa='.$societaDaModulo.'&doc='.$doc.'&output_mode='.$output_modulo.'&flag_chiusura='.$flag_chiusura.'&status=4" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		} else {
		 echo '<div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold;">Esporta dati</div>';
		}
		 break;
		case "report_rda.php":
		if ($ricerca == 1) {
		 echo '<a href="xls2.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&stato_rda='.$stato_rdaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		} else {
		 echo '<div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold;">Esporta dati</div>';
		}
	 break;
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		if ($ricerca == 1) {
		 echo '<a href="xls2_report_mag.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_ricerca='.$categ_DaModulo.'" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		} else {
		 echo '<div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold;">Esporta dati</div>';
		}
		 break;
		 }

	 echo '</div>';
	 //CONTENITORE CON CAMPI NASCOSTI ACCESSORI PER FUNZIONAMENTO SCRIPT MSC
	  echo '<div style="width: 100%; float: left; height: 2px;">
	  <input name="ricerca" id="ricerca" type="hidden" value="1" />
	  <input id="doc" name="doc" type="hidden" value="'.$doc.'" />
	 </div>
	 	</form>
	  </div>';
?>  <!--fine div id=ricerca class=submenuRicerca-->
</div>
</div>
</div>
</div>
