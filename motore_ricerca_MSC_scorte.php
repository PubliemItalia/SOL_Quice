<?php
session_start();

if (isset($_POST['file_presente'])) {
$file_presente = $_POST['file_presente'];
} 
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";


///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
// CAMPO SOCIETA'
if (isset($_POST['societa'])) {
  $societaDaModulo = $_POST['societa'];
} 
if ($societaDaModulo != "") {
  $f = "azienda = '$societaDaModulo'";
$clausole++;
}
// CAMPO CATEGORIA 
if (isset($_POST['categoria_righe'])) {
  $categ_DaModulo = $_POST['categoria_righe'];
} 
if ($categ_DaModulo != "") {
  $b = "categoria1_it = '$categ_DaModulo'";
$clausole++;
}
// CAMPO NEGOZIO 
if (isset($_POST['shop'])) {
  $shopDaModulo = $_POST['shop'];
} 
// CAMPO codice art 
if (isset($_POST['codice_art'])) {
  $codice_artDaModulo = $_POST['codice_art'];
} 
if ($codice_artDaModulo != "") {
  $g = "codice_art = '$codice_artDaModulo'";
$clausole++;
}
// CAMPO codice sol 
if (isset($_POST['categoria4'])) {
  $categoria4DaModulo = $_POST['categoria4'];
} 
if ($_POST['paese'] != "") {
$paeseDaModulo = $_POST['paese'];
} 




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
$queryaccessoria .= $h;
}
}
//tendina società
  $tendina_societa = '<select name="societa" class="codice_lista_nopadding" id="societa" style="height:27px; width:90%;">';
  switch ($societaDaModulo) {
	case "":
	  $tendina_societa .= '<option selected value="">Scegli societ&agrave;</option>';
	  $tendina_societa .= '<option value="sol">SOL</option>';
	  $tendina_societa .= '<option value="vivisol">VIVISOL</option>';
	break;
	case "sol":
	  $tendina_societa .= '<option value="">Scegli societ&agrave;</option>';
	  $tendina_societa .= '<option selected value="sol">SOL</option>';
	  $tendina_societa .= '<option value="vivisol">VIVISOL</option>';
	break;
	case "vivisol":
	  $tendina_societa .= '<option value="">Scegli societ&agrave;</option>';
	  $tendina_societa .= '<option value="sol">SOL</option>';
	  $tendina_societa .= '<option selected value="vivisol">VIVISOL</option>';
	break;
  }
  $tendina_societa .= '</select>';
//fine tendina società

//tendina negozi
$tendina_negozio = '<select name="shop" class="codice_lista_nopadding" id="shop" style="height:27px; width:90%;" onchange="msc(this.value)">';
	switch ($shopDaModulo) {
		case "":
		  $tendina_negozio .= '<option selected value="">Scegli negozio</option>';
		  $tendina_negozio .= '<option value="assets">Assets</option>';
		  $tendina_negozio .= '<option value="consumabili">Consumabili</option>';
		  $tendina_negozio .= '<option value="spare_parts">Spare parts</option>';
		  $tendina_negozio .= '<option value="labels">Etichette</option>';
		  $tendina_negozio .= '<option value="vivistore">Vivistore</option>';
		break;
		case "assets":
		  $tendina_negozio .= '<option value="">Scegli negozio</option>';
		  $tendina_negozio .= '<option selected value="assets">Assets</option>';
		  $tendina_negozio .= '<option value="consumabili">Consumabili</option>';
		  $tendina_negozio .= '<option value="spare_parts">Spare parts</option>';
		  $tendina_negozio .= '<option value="labels">Etichette</option>';
		  $tendina_negozio .= '<option value="vivistore">Vivistore</option>';
		break;
		case "consumabili":
		  $tendina_negozio .= '<option value="">Scegli negozio</option>';
		  $tendina_negozio .= '<option value="assets">Assets</option>';
		  $tendina_negozio .= '<option selected value="consumabili">Consumabili</option>';
		  $tendina_negozio .= '<option value="spare_parts">Spare parts</option>';
		  $tendina_negozio .= '<option value="labels">Etichette</option>';
		  $tendina_negozio .= '<option value="vivistore">Vivistore</option>';
		break;
		case "spare_parts":
		  $tendina_negozio .= '<option value="">Scegli negozio</option>';
		  $tendina_negozio .= '<option value="assets">Assets</option>';
		  $tendina_negozio .= '<option value="consumabili">Consumabili</option>';
		  $tendina_negozio .= '<option selected value="spare_parts">Spare parts</option>';
		  $tendina_negozio .= '<option value="labels">Etichette</option>';
		  $tendina_negozio .= '<option value="vivistore">Vivistore</option>';
		break;
		case "labels":
		  $tendina_negozio .= '<option value="">Scegli negozio</option>';
		  $tendina_negozio .= '<option value="assets">Assets</option>';
		  $tendina_negozio .= '<option value="consumabili">Consumabili</option>';
		  $tendina_negozio .= '<option value="spare_parts">Spare parts</option>';
		  $tendina_negozio .= '<option selected value="labels">Etichette</option>';
		  $tendina_negozio .= '<option value="vivistore">Vivistore</option>';
		break;
		case "vivistore":
		  $tendina_negozio .= '<option value="">Scegli negozio</option>';
		  $tendina_negozio .= '<option value="assets">Assets</option>';
		  $tendina_negozio .= '<option value="consumabili">Consumabili</option>';
		  $tendina_negozio .= '<option value="spare_parts">Spare parts</option>';
		  $tendina_negozio .= '<option value="labels">Etichette</option>';
		  $tendina_negozio .= '<option selected value="vivistore">Vivistore</option>';
		break;
	}
$tendina_negozio .= '</select>';
//fine tendina negozi

// tendina categoria
if ($shopDaModulo != "") {
			$tendCATEG = "(SELECT DISTINCT categoria1_it FROM qui_prodotti_".$shopDaModulo." ORDER BY categoria1_it ASC)";
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
} 

$tendina_categoria = '<select name="categoria_righe" class="codice_lista_nopadding" id="categoria_righe" style="height:27px; width: 90%;">';
$tendina_categoria .= '<option selected value="">Scegli categoria </option>'.$opzioni_categoria;
$tendina_categoria .= '</select>';
//fine tendina categoria


///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
//$tab_output .= 'categ_DaModulo: '.$categ_DaModulo.'<br>';
	 /*$tab_output .= '<form action="'.$file_presente.'" method="get" name="form_filtri2">';
	//colonna 5-->
	$tab_output .= '<div style="margin: 15px 15px 0px 15px; float:left; width:118px;">';
	switch ($file_presente) {
		default:
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
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
	$tab_output .= '</div>';*/
	//contenitore per variazione contestuale tendine
	//colonna 1-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;">';
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Societ&agrave;</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_societa.'</div>';
		  $tab_output .= '<div style="width: 100%; float: left; height: 20px;">
			<strong>Negozio</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">'.$tendina_negozio.'</div>';
	//fine colonna 1-->
	$tab_output .= '</div>';
	//colonna 2-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;" >';
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Nazione</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="paese" type="text" class="tabelle8" style="width:90%; height:27px; padding: 0px !important;" id="paese" size="10" value="'.$paeseDaModulo.'">
		  </div>';
		  $tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CATEGORIA</strong>
		  </div>
		  <div id="divcat" style="width: 100%; float: left; height: 39px;">'.$tendina_categoria.'</div>';
	//fine colonna 2-->
	$tab_output .= '</div>';
	//colonna 3-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;">';
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
		  	$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Codice Sol</strong>
			</div>
			  <div style="width: 100%; float: left; height: 39px;">
				<input name="categoria4" type="text" style="width:90%; height:27px; padding: 0px !important;" id="categoria4" value="'.$categoria4DaModulo.'">';
			  $tab_output .= '</div>';
	//fine colonna 3-->
	$tab_output .= '</div>';
	//colonna 4-->
	$tab_output .= '<div style="margin-top: 15px; float:left; width:153px;">';
		  /*$tab_output .= '<div  style="width: 100%; float: left; height: 20px;">
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
		  $tab_output .= '</div>';*/
      //fine colonna 4-->
	$tab_output .= '</div>';
	//colonna 6-->
	$tab_output .= '<div style="margin-top:15px; margin-bottom:15px; float:right; width:118px; margin-right:15px;">';
	  $tab_output .= '<div id="pulsante_applica" style="width: 118px; float: left; height: 32px; margin-bottom:10px;">';
		$tab_output .= '<div style="width: 100%; background-color:#06F; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="document.form_filtri2.submit();">
			Applica filtri
		  </div>';
	  $tab_output .= '</div>';
	  $tab_output .= '<div style="width: 100%; float: left; height: auto; margin-bottom:15px;">';
		$tab_output .= '<a href="'.$file_presente.'?a=1&doc='.$doc.'"><div class="pulsantiricerca" style="width: 100%; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Reset filtri</div></a>';
	  $tab_output .= '</div>';
	  $tab_output .= '<div style="width: 100%; float: left; height: auto; margin-bottom:5px;">';
	 $tab_output .= '</div>';
	 //CONTENITORE CON CAMPI NASCOSTI ACCESSORI PER FUNZIONAMENTO SCRIPT MSC
	  $tab_output .= '<div style="width: 100%; float: left; height: 2px;">
	 </div>';
	 	//</form>';
	  //</div>';
    //<!--fine colonna 6-->

//fine contenitore totale

//output finale

//echo .= "pippo";
//$tab_output .= 'tendUNI: '.$tendUNI.'<br>';
echo $tab_output;
 ?>
