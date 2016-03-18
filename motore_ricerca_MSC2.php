<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";


///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
if (isset($_POST['unita'])) {
$unitaDaModulo = $_POST['unita'];
}
if ($unitaDaModulo != "") {
$a = "id_unita = '$unitaDaModulo'";
$clausole++;
}
if (isset($_POST['categoria'])) {
$categ_DaModulo = $_POST['categoria'];
} 
if ($categ_DaModulo != "") {
$b = "categoria = '$categ_DaModulo'";
$clausole++;
}

if (isset($_POST['data_inizio'])) {
$data_inizio = $_POST['data_inizio'];
} 
if (isset($_POST['data_fine'])) {
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
$c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = "";
}

if (isset($_POST['shop'])) {
$shopDaModulo = $_POST['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
if (isset($_POST['nr_rda'])) {
$nrRdaDaModulo = $_POST['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$e = "id_rda = '$nrRdaDaModulo'";
$clausole++;
}
if (isset($_POST['societa'])) {
$societaDaModulo = $_POST['societa'];
} 
if ($societaDaModulo != "") {
$f = "azienda_prodotto = '$societaDaModulo'";
$clausole++;
}
if (isset($_POST['codice_art'])) {
$codice_artDaModulo = $_POST['codice_art'];
} 
if ($codice_artDaModulo != "") {
$g = "codice_art = '$codice_artDaModulo'";
$clausole++;
}
$file_presente = $_POST['file_presente'];



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
$queryaccessoria .= $g;
}
}
//tendina società
if ($clausole > 0) {
$tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
} else {
$tendSoc = "SELECT DISTINCT azienda_prodotto FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4')";
}

$lungSOC = strlen($tendSoc);
$finaleSOC = substr($tendSoc,($lungSOC-5),5);
if ($finaleSOC == " AND ") {
$tendSoc = substr($tendSoc,0,($lungSOC-5));
}
$tendSoc .= " ORDER BY azienda_prodotto ASC";

$tendina_societa = '<select name="societa" class="codice_lista_nopadding" id="societa" style="height:27px; width:90%;" onchange="msc(this.id,this.value)"><option selected value="">Scegli societ&agrave;</option>';
$resSOC = mysql_query($tendSoc) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigaSOC = mysql_fetch_array($resSOC)) {
  if ($rigaSOC[azienda_prodotto] != "") {
	if ($rigaSOC[azienda_prodotto] == $societaDaModulo) {
		$tendina_societa .= '<option selected value="'.$rigaSOC[azienda_prodotto].'">'.strtoupper($rigaSOC[azienda_prodotto]).'</option>';
	} else {
		$tendina_societa .= '<option value="'.$rigaSOC[azienda_prodotto].'">'.strtoupper($rigaSOC[azienda_prodotto]).'</option>';
	}
  }
}
$tendina_societa .= '</select>';
//fine tendina società

//tendina negozi
if ($clausole > 0) {
$tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
} else {
$tendSHOP = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE WHERE (stato_ordine BETWEEN '2' AND '4')";
}

$lungSHOP = strlen($tendSHOP);
$finaleSHOP = substr($tendSHOP,($lungSHOP-5),5);
if ($finaleSHOP == " AND ") {
$tendSHOP = substr($tendSHOP,0,($lungSHOP-5));
}
$tendSHOP .= " ORDER BY negozio ASC";

$tendina_negozio = '<select name="shop" class="codice_lista_nopadding" id="shop" style="height:27px; width:90%;" onchange="msc(this.id,this.value)"><option selected value="">Scegli negozio</option>';
$resSHOP = mysql_query($tendSHOP) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigaSHOP = mysql_fetch_array($resSHOP)) {
  if ($rigaSHOP[negozio] == $shopDaModulo) {
	  $tendina_negozio .= '<option selected value="'.$rigaSHOP[negozio].'">'.str_replace("_"," ",$rigaSHOP[negozio]).'</option>';
  } else {
	  $tendina_negozio .= '<option value="'.$rigaSHOP[negozio].'">'.str_replace("_"," ",$rigaSHOP[negozio]).'</option>';
  }
}
$tendina_negozio .= '</select>';
//fine tendina negozi

//tendina unità
if ($clausole > 0) {
$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '4') AND ".$queryaccessoria;
} else {
$tendUNI = "SELECT DISTINCT id_unita, nome_unita FROM qui_righe_rda WHERE WHERE (stato_ordine BETWEEN '2' AND '4')";
}

$lungUNI = strlen($tendUNI);
$finaleUNI = substr($tendUNI,($lungUNI-5),5);
if ($finaleUNI == " AND ") {
$tendUNI = substr($tendUNI,0,($lungUNI-5));
}
$tendUNI .= " ORDER BY nome_unita ASC";

$tendina_unita = '<select name="unita" class="codice_lista_nopadding" id="unita" style="height:27px; width: 90%;" onchange="msc(this.id,this.value)"><option selected value="">Scegli unit&agrave;</option>';
$resUNI = mysql_query($tendUNI) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigaUNI = mysql_fetch_array($resUNI)) {
  if ($rigaUNI[id_unita] == $unitaDaModulo) {
	  $tendina_unita .= '<option selected value="'.$rigaUNI[id_unita].'">'.strtoupper($rigaUNI[nome_unita]).'</option>';
  } else {
	  $tendina_unita .= '<option value="'.$rigaUNI[id_unita].'">'.strtoupper($rigaUNI[nome_unita]).'</option>';
  }
}
$tendina_unita .= '</select>';
//fine tendina unità
// tendina categoria

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

$tendina_categoria = '<select name="categoria_righe" class="codice_lista_nopadding" id="categoria_righe" style="height:27px; width: 90%;" onchange="msc(this.id,this.value)"><option selected value="">Scegli categoria </option>';
$resCATEG = mysql_query($tendCATEG) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigaCATEG = mysql_fetch_array($resCATEG)) {
  if ($rigaCATEG[categoria] == $categ_DaModulo) {
	  $tendina_categoria .= '<option selected value="'.$rigaCATEG[categoria].'">'.str_replace("_"," ",$rigaCATEG[categoria]).'</option>';
  } else {
	  $tendina_categoria .= '<option value="'.$rigaCATEG[categoria].'">'.str_replace("_"," ",$rigaCATEG[categoria]).'</option>';
  }
}
$tendina_categoria .= '</select>';
//fine tendina categoria


///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
//echo 'file_presente: '.$file_presente.'<br>';
	//colonna 1-->
	$tab_output .= '<div id="contenitore_msc" style="width: 100%; height: 170px; display:none;">
	 <form action="'.$file_presente.'" method="get" name="form_filtri2">
	<div style="margin-left: 15px; margin-top: 15px; float:left; width:153px;">';
	 
	  switch ($file_presente) {
		  default:
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Societ&agrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_societa.'</div>';
		  break;
		  case "report_rda.php":
			$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Unit&agrave;</strong>
			</div>
			<div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
		  break;
		  }
	  switch ($file_presente) {
		  default:
		  $tab_output .= '<div style="width: 100%; float: left; height: 20px;">
			<strong>Negozio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_negozio.'</div>';
			break;
			case "lista_pl.php":
			//solo la listapl.php non ha il negozio ma l'unità in posizione 2 di colonna 1
			  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
				<strong>Unit&agrave;</strong>
			  </div>
			  <div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
			break;
			case "report_scorte_magazzino.php":
		  $tab_output .= '<div style="width: 100%; float: left; height: 20px;">
			<strong>Negozio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_negozio.'</div>';
			break;
	  }
	//fine colonna 1-->
	$tab_output .= '</div>';
	//colonna 2-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;" >';
	  //la tendina delle unità presenta due varianti a seconda della pagina da cui viene visualizzata
	  //nel processo solo le rda attive (stato 2 e 3), nelle altre pagine tutte le rda (stato 4)
	  switch ($file_presente) {
		case "report_scorte_magazzino.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Nazione</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="paese" type="text" class="tabelle8" style="width:90%; height:27px; padding: 0px !important;" id="paese" size="10" value="'.$paeseDaModulo.'">
		  </div>';
		break;
		case "lista_pl.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>N. PL</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_pl" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_pl" size="10" value="'.$nrPlDaModulo.'">
		  </div>';
		break;
		case "ordini.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
		case "report_righe_nuovo.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
			$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Unit&agrave;</strong>
			</div>
			<div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
		  break;
		case "report_fatturazione.php":
		case "report_righe_nuovo_sap.php":
		case "report_righe_admin.php":
			$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Unit&agrave;</strong>
			</div>
			<div id="divuni" style="width: 100%; float: left; height: 39px;">'.$tendina_unita.'</div>';
		break;
		case "report_rda.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
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
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CATEGORIA</strong>
		  </div>
		  <div id="divcat" style="width: 100%; float: left; height: 39px;">'.$tendina_categoria.'</div>';
		break;
		case "report_righe_nuovo_sap.php":
		case "report_righe_admin.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CATEGORIA</strong>
		  </div>
		  <div id="divcat" style="width: 100%; float: left; height: 39px;">'.$tendina_categoria.'</div>';
		break;
		case "ordini_sap.php":
		case "report_rda.php":
		case "report_fatturazione.php":
		case "lista_pl.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>N. RdA</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_rda" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_rda" size="10" value="'.$nrRdaDaModulo.'">
		  </div>';
		break;
		case "ordini.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
	  }
	//fine colonna 2-->
	$tab_output .= '</div>';
	//colonna 3-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;">';
	  switch ($file_presente) {
		default:
		$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
		  </div>';
		break;
		case "report_scorte_magazzino.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Codice Qui C&acute;&egrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name=codice_art type=text style="width:90%; height:27px; padding: 0px !important;" id=codice_art value=';
			  if (substr($codice_artDaModulo,0,1) != "*") {
				$tab_output .= $codice_artDaModulo;
			  } else {
				$tab_output .= substr($codice_artDaModulo,1);
			  }
			$tab_output .= '>';
		  $tab_output .= '</div>';
		break;
		case "report_righe_nuovo.php":
		case "report_righe_nuovo_sap.php":
	  		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>N. RdA</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_rda" type="text" style="width:90%; height:27px; padding: 0px !important; font-size:12px;" id="nr_rda" size="10" value="'.$nrRdaDaModulo.'" onkeyup="sost_applica_filtri(this.value)">
		  </div>';
		break;
	  }
	  switch ($file_presente) {
		default:
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
		case "report_righe_admin.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CODICE ART.</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name=codice_art type=text style="width:90%; height:27px; padding: 0px !important;" id=codice_art value=';
			  if (substr($codice_artDaModulo,0,1) != "*") {
				$tab_output .= $codice_artDaModulo;
			  } else {
				$tab_output .= substr($codice_artDaModulo,1);
			  }
			$tab_output .= '>';
		  $tab_output .= '</div>';
		break;
		case "report_righe_nuovo.php":
		case "report_righe_nuovo_sap.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CODICE ART.</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name=codice_art type=text style="width:90%; height:27px; padding: 0px !important;" id=codice_art value=""';
			  if (substr($codice_artDaModulo,0,1) != "*") {
				$tab_output .= $codice_artDaModulo;
			  } else {
				$tab_output .= substr($codice_artDaModulo,1);
			  }
			$tab_output .= '>';
		  $tab_output .= '</div>';
		break;
		case "report_fatturazione.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Nr. SAP</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="nr_pl" type="text" class="tabelle8" id="nr_pl" style="width:90%; height:27px; padding: 0px !important;" value="'.$nr_plDaModulo.'">
		  </div>';
		break;
		case "report_rda.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>'.$testata_status.'</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<select name="stato_rda" class="codice_lista_nopadding" id="stato_rda" style="height:27px; width: 90%;">';
			  if ($_SESSION[ruolo] == "admin") {
				$tab_output .= "<option selected value=>".$scegli_stato."</option>";
				$sqlr = "SELECT * FROM uc_order_statuses WHERE attivo_admin = '1' ORDER BY status_php ASC";
			  }
			  if ($_SESSION[negozio_buyer] != "") {
				$sqlr = "SELECT * FROM uc_order_statuses WHERE attivo = '1' ORDER BY status_php ASC";
			  }
			  $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
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
				  $tab_output .= "<option selected value=".$rigar[status_php].">".$testoStatus."</option>";
				} else {
				  $tab_output .= "<option value=".$rigar[status_php].">".$testoStatus."</option>";
				}
			  }
			$tab_output .= '</select>';
		  $tab_output .= '</div>';
		break;
		case "report_scorte_magazzino.php":
		  	$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Codice Sol</strong>
			</div>
			<div style="width: 100%; float: left; height: 39px;">
				<input name="categoria4" type="text" style="width:90%; height:27px; padding: 0px !important;" id="categoria4" value="'.$categoria4DaModulo.'">';
			$tab_output .= "</div>";
		break;
	  }
	//fine colonna 3-->
	$tab_output .= '</div>';
	//colonna 4-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;">';
		$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
		  </div>';
	  switch ($file_presente) {
		default:
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			</div>
			<div style="width: 100%; float: left; height: 39px;">
			</div>';
		break;
		case "report_scorte_magazzino.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
		  <strong>Disponibilit&agrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">';
		  $tab_output .= '<select name="dispo" class="ecoform" id="dispo"  style="height:27px; width: 90%;">';
		  switch($dispoDaModulo) {
			  case "":
				$tab_output .= '<option selected value="">Tutti</option>';
				$tab_output .= '<option value="1">Disponibili</option>';
				$tab_output .= '<option value="0">Non disponibili</option>';
			  break;
			  case "1":
				$tab_output .= '<option value="">Tutti</option>';
				$tab_output .= '<option selected value="1">Disponibili</option>';
				$tab_output .= '<option value="0">Non disponibili</option>';
			  break;
			  case "0":
				$tab_output .= '<option value="">Tutti</option>';
				$tab_output .= '<option value="1">Disponibili</option>';
				$tab_output .= '<option selected value="0">Non disponibili</option>';
			  break;
		  }
		  $tab_output .= '</select>';
		  $tab_output .= '</div>';
		break;
		case "report_fatturazione.php":
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
		  <strong>';
		  switch ($_SESSION[lang]) {
			  case "it":
			  $tab_output .= "Archivio PL";
			  break;
			  case "en":
			  $tab_output .= "PL Archive";
			  break;
		  }
		  $tab_output .= '</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">';
		  $tab_output .= '<select name="archivio" class="ecoform" id="archivio"  style="height:27px; width: 90%;">';
		  switch($archivioDaModulo) {
			  case "":
				$tab_output .= "<option value=0>Tutti i PL</option>";
				$tab_output .= "<option selected value=1>PL Attivi</option>";
				$tab_output .= "<option value=2>PL Archiviati</option>";
			  break;
			  case "0":
				$tab_output .= "<option selected value=0>Tutti i PL</option>";
				$tab_output .= "<option value=1>PL Attivi</option>";
				$tab_output .= "<option value=2>PL Archiviati</option>";
			  break;
			  case "1":
				$tab_output .= "<option value=0>Tutti i PL</option>";
				$tab_output .= "<option selected value=1>PL Attivi</option>";
				$tab_output .= "<option value=2>PL Archiviati</option>";
			  break;
			  case "2":
				$tab_output .= "<option value=0>Tutti i PL</option>";
				$tab_output .= "<option value=1>PL Attivi</option>";
				$tab_output .= "<option selected value=2>PL Archiviati</option>";
			  break;
		  }
		  $tab_output .= '</select>';
		  $tab_output .= '</div>';
		  $tab_output .= '<input name="doc" type="hidden" value="'.$doc.'" />';
		break;
	  }
      //fine colonna 4-->
	$tab_output .= '</div>';
	//colonna 5-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:118px;">';
	switch ($file_presente) {
		default:
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Data inizio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="data_inizio" type="text" class="datepicker" id="data_inizio" style="width:98%; height:27px;" value="'.$data_inizio.'">
		  </div>
		  <div  style="width: 100%; float: left; height: 20px;">
			<strong>Data fine</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="data_fine" type="text" class="datepicker" id="data_fine" style="width:98%; height:27px;" value="'.$data_fine.'">
		  </div>';
		break;
		case "report_scorte_magazzino.php":
		break;
	}
	//fine colonna 5-->
	$tab_output .= '</div>';
	//colonna 6-->
	$tab_output .= '<div style="margin-top:15px; margin-bottom:15px; float:left; width:118px; margin-left:70px;">';
	  $tab_output .= '<div id="pulsante_applica" style="width: 118px; float: left; height: 32px; margin-bottom:10px;">';
	switch ($file_presente) {
		case "report_righe_nuovo.php":
		case "report_righe_nuovo_sap.php":
		case "report_scorte_magazzino.php":
		case "report_righe_admin.php":
		case "report_rda.php":
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		case "lista_pl.php":
		$tab_output .= '<div style="width: 100%; background-color:#06F; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="document.form_filtri2.submit();">
			Applica filtri
		  </div>';
		break;
		case "report_fatturazione.php":
		case "ordini_sap.php":
		case "ordini.php":
		  $tab_output .= '<div style="width: 100%; background-color:#F63; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="document.form_filtri2.submit();">
			Applica filtri
		  </div>';
		break;
	}
	  $tab_output .= '</div>';
	  $tab_output .= '<div style="width: 100%; float: left; height: auto; margin-bottom:15px;">
		<a href="'.$file_presente.'?a=1&doc='.$doc.'"><div style="background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Reset filtri</div></a>
	  </div>';
	  $tab_output .= '<div style="width: 100%; float: left; height: auto; margin-bottom:5px;">';
	switch ($file_presente) {
		case "report_righe_nuovo.php":
		case "report_righe_nuovo_sap.php":
		 $tab_output .= '<a href="xls2_righe_rda.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&nr_pl='.$nrPlDaModulo.'&archivio='.$archivioDaModulo.'&societa='.$societaDaModulo.'&doc='.$doc.'&status=3" target="_blank"><div style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		 break;
		case "report_fatturazione.php":
		case "ordini_sap.php":
		case "report_righe_admin.php":
		 $tab_output .= '<a href="xls2_righe_rda.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&nr_pl='.$nrPlDaModulo.'&archivio='.$archivioDaModulo.'&societa='.$societaDaModulo.'&doc='.$doc.'&output_mode='.$output_modulo.'&flag_chiusura='.$flag_chiusura.'&status=4" target="_blank"><div style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		 break;
		case "report_rda.php":
		 $tab_output .= '<a href="xls2.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&stato_rda='.$stato_rdaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'" target="_blank"><div style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		 break;
		case "report_righe_mag.php":
		case "report_righe_mag_publiem.php":
		 $tab_output .= '<a href="xls2_report_mag.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_ricerca='.$categ_DaModulo.'" target="_blank"><div style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		 break;
		 }

	 $tab_output .= '</div>
	 	</form>
	  </div>';
    //<!--fine colonna 6-->

//fine contenitore totale

//output finale

//echo "pippo";
echo $tab_output;
 ?>
