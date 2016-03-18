<div id="ricerca" style="width:100%; min-height:100px; overflow:hidden; height:auto; background-color: #ddd; margin-bottom: 20px; color:#000; float:left;">
  <div id=formRicerca>
  <?php
// CAMPO SOCIETA'
if (isset($_GET['societa'])) {
  $societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
  $f = "azienda = '$societaDaModulo'";
$clausole++;
}
// CAMPO CATEGORIA 
if (isset($_GET['categoria_righe'])) {
  $categ_DaModulo = $_GET['categoria_righe'];
} 
if ($categ_DaModulo != "") {
  $b = "categoria1_it = '$categ_DaModulo'";
$clausole++;
}
// CAMPO NEGOZIO 
if (isset($_GET['shop'])) {
  $shopDaModulo = $_GET['shop'];
} 
// CAMPO codice art 
if (isset($_GET['codice_art'])) {
  $codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
  $g = "codice_art = '$codice_artDaModulo'";
$clausole++;
}
// CAMPO codice sol 
if (isset($_GET['categoria4'])) {
  $categoria4DaModulo = $_GET['categoria4'];
}
//nazione
if ($_GET['paese'] != "") {
$paeseDaModulo = $_GET['paese'];
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
$queryaccessoria .= $n;
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
		case "report_scorte_magazzino.php":
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
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>Nazione</strong>
		  </div>
		  <div style="width: 100%; float: left; height: 39px;">
			<input name="paese" type="text" class="tabelle8" style="width:90%; height:27px; padding: 0px !important;" id="paese" size="10" value="'.$paeseDaModulo.'">
		  </div>';
		  echo '<div  style="width: 100%; float: left; height: 20px;">
			<strong>CATEGORIA</strong>
		  </div>
		  <div id="divcat" style="width: 100%; float: left; height: 39px;">'.$tendina_categoria.'</div>';
	//fine colonna 2-->
	echo '</div>';
	//colonna 3-->
	echo '<div style="margin-top: 15px; float:left; width:153px;">';
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
		  	echo '<div  style="width: 100%; float: left; height: 20px;">
			  <strong>Codice Sol</strong>
			</div>
			  <div style="width: 100%; float: left; height: 39px;">
				<input name="categoria4" type="text" style="width:90%; height:27px; padding: 0px !important;" id="categoria4" value="'.$categoria4DaModulo.'">';
			  echo '</div>';
	//fine colonna 3-->
	echo '</div>';
	//colonna 4-->
	echo '<div style="margin-top: 15px; float:left; width:153px;">';
		  /*echo '<div  style="width: 100%; float: left; height: 20px;">
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
		  echo '</div>';*/
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
		echo '<a href="report_righe_nuovo.php?status=no_process"><div class="pulsantiricerca" style="width: 100%; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Reset filtri</div></a>';
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
		 echo '<a href="xls3_fatturazione.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&nr_rda='.$nrRdaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_righe='.$categ_DaModulo.'&nr_pl='.$nrPlDaModulo.'&archivio='.$archivioDaModulo.'&societa='.$societaDaModulo.'&doc='.$doc.'&flag_chiusura=1&status=4" target="_blank"><div class="pulsantiricerca" style="width: 100%; float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
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
		 echo '<a href="xls2_report_mag.php?shop='.$shopDaModulo.'&unita='.$unitaDaModulo.'&data_inizio='.$data_inizio.'&data_fine='.$data_fine.'&codice_art='.$codice_artDaModulo.'&categoria_ricerca='.$categ_DaModulo.'" target="_blank"><div class="pulsantiricerca" style="float:left; background-color:#8d8d8d; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer;">Esporta dati</div></a>';
		 break;
		 }

	 echo '</div>';
	 //CONTENITORE CON CAMPI NASCOSTI ACCESSORI PER FUNZIONAMENTO SCRIPT MSC
	  if ($arc == "1") {
		  $doc = "R";
	  }
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
