<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
if ($_GET[blocco_pl] != "") {
$blocco_pl = $_GET[blocco_pl];
} else {
$blocco_pl = $_POST[blocco_pl];
}
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}
if ($_GET[unit] != "") {
$unit = $_GET[unit];
} else {
$unit = $_POST[unit];
}

$pos = strpos($blocco_pl,";");
if ($pos > 0) {
	$array_pl = explode(";",$blocco_pl);
} else {
	$array_pl = array($blocco_pl);
}
$array_grm = array();
	
$array_lista_rda = array();
//ciclo foreach per recuperare l'elenco delle RdA coinvolte nei PL da fatturare per l'unità
//e l'elenco dei gruppi merce
//mentre l'unità (che deve essere la stessa - vedi l'if qui sopra) serve una volta sola, per cui utilizzo il contatore $a
foreach($array_pl as $sing_pl) {
  $sqlc = "SELECT * FROM qui_corrispondenze_pl_rda WHERE pl = '$sing_pl'";
  $risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigac = mysql_fetch_array($risultc)) {
	  if (!in_array($rigac[rda],$array_lista_rda)) {
		  $addRda = array_push($array_lista_rda,$rigac[rda]);
	  $sqlm = "SELECT * FROM qui_rda WHERE id = '$rigac[rda]'";
	  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigam = mysql_fetch_array($risultm)) {
		  $lista_rda .= $rigac[rda].' <span style="font-weight: normal;">('.date("d/m/Y",$rigam[data_inserimento]).')</span>, ';
	  }
	}
  }
  $sqlf = "SELECT logo, n_fatt_sap FROM qui_packing_list WHERE id = '$sing_pl'";
  $risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigaf = mysql_fetch_array($risultf)) {
	$logo_fatt = $rigaf[logo];
	$n_fatt_sap = $rigaf[n_fatt_sap];
  }
  $sqld = "SELECT DISTINCT gruppo_merci FROM qui_righe_rda WHERE pack_list = '$sing_pl'";
  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigad = mysql_fetch_array($risultd)) {
	$conteggio_righe_rda = $conteggio_righe_rda +1;
	if (!in_array($rigad[gruppo_merci],$array_grm)) {
	  $add_grm = array_push($array_grm,$rigad[gruppo_merci]);
	}
  }
}
$lista_rda = substr($lista_rda,0,(strlen($lista_rda)-2));
sort($array_grm);
//indirizzo fattura
	  $sqle = "SELECT * FROM qui_utenti WHERE idunita = '$unit' LIMIT 1";
	  $risulte = mysql_query($sqle) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigae = mysql_fetch_array($risulte)) {
		$unit_name = $rigae[nomeunita];
		$nome_unita .= "<strong>".addslashes($rigae[companyName])."<br>(";
		$nome_unita .= addslashes($rigae[nomeunita]).")</strong><br>";
		$nome_unita .= addslashes($rigae[indirizzo])."<br>";
		$nome_unita .= $rigae[cap]." ";
		$nome_unita .= addslashes($rigae[localita])."<br>";
		$nome_unita .= addslashes($rigae[nazione]);
		$id_unita = $rigae[idunita];
	  //fine while qui_utenti
	  }
//echo "n_fatt_sap: ".$n_fatt_sap."<br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/report.css" />
<link rel=”stylesheet” href=”css/video.css” type=”text/css” media=”screen” />
<link rel=”stylesheet” href=”css/printer.css” type=”text/css” media=”print” />
<title>Packing List</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#lingua_scheda {
	width:100%;
	margin: auto;
	background-color: #727272;
	margin-bottom: 10px;
	color: #FFFFFF;
	height: 40px;
	text-align: right;
	padding-topt: 5px;
	padding-right: 5px;
	vertical-align: middle;
	font-weight: bold;
}
#lingua_scheda a {
	color: #FFFFFF;
}
#main_container {
/*		background-size: cover;
		padding-top: 57px;
		padding-left: 119px;
		padding-right: 60px;
		padding-bottom: 138px;
		width: 577px;
		height: 874px;
*/
		page-break-after: avoid;
		page-break-before:avoid;
		page-break-inside: auto;
		width: 750px;
		height: 1069px;
}
.immpiede {
	width:100%; height:100px;
}
.superiore {
	width: 100%; height: 969px;
}
#order_container {
	width:637px;
	height:750px;
	margin: auto;
}
.testata_logo {
	width:310px;
	padding-left:25px;
	height: 90px;
	float:left;
	text-align: left;
}
.testata_testo {
	width:300px;
	height: 90px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.riga_divisoria {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-align:left;
	width:590px;
	min-height: 23px;
	overflow:hidden;
	height:auto;
	margin-left:119px;
	margin-right:60px;
	/*border-top:1px solid #CCC;*/
	border-bottom:1px solid #CCC;
	float:left;
	padding:7px 0px;
}
.cont_esterno {
	width:637px;
	height: auto;
	float:left;
}
.indirizzi {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:none;
}
.note_varie {
	width:200px;
	min-height:50px;
	overflow: hidden;
	height: auto;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.colonnine_form {
	width:170px;
	height: 35px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}

.colliPeso {
	width:100px;
	height: 60px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.scritta_bianca {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color:#FFFFFF;
}

.testata_tab {
	width:637px;
	height: 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	float:left;
	font-weight: bold;
}
.corpo_tab {
	width:637px;
	height: 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	float:left;
}
.tab57 {
	width:57px;
	height: 20px;
	float:left;
}
.tab69 {
	width:69px;
	height: 20px;
	float:left;
}
.tab335 {
	width:335px;
	height: 20px;
	float:left;
}
.tab48 {
	width:48px;
	height: 20px;
	float:left;
	font-weight: bold;
	text-align: right;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.Stile2 {
	font-size: 18px;
	font-weight: bold;
}
.Stile3 {font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
font-weight: bold;
}
.Stile4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Stile5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.Stile6 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align:right;
}
.Stile7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-align:left;
}
.riga_finale {
	width:622px;
	height: auto;
	margin-left:100px;
	padding-top:10px;
	padding-bottom:10px;
	float:left;
	
}
.box_60{
	width:60px;
	padding-top:5px;
	height: auto;
	float:left;
}
.box_90{
	width:95px;
	padding-top:5px;
	height: auto;
	float:left;
}
.box_350{
	width:390px;
	padding-top:5px;
	height: auto;
	float:left;
}
@media print{
	#main_container{
		page-break-after: avoid;
		page-break-before:avoid;
		page-break-inside: auto;
		width: 700px;
		height: 1069px;
	}
.immpiede {
	width:100%; height:100px;
}
.superiore {
	width: 100%; height: 969px;
}
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
</head>

<?php
	switch ($logo_fatt) { 
	  case "sol":
		$immagine_logo = '<img src="immagini/velina_logo_sol.png" width="185" height="74" />';
		$immagine_piede = '<img src="immagini/velina_piede_sol.png" width="744" height="85" />';
	  break;
	  case "vivisol":
		$immagine_logo = '<img src="immagini/velina_logo_vivisol.png" width="251" height="74" />';
		$immagine_piede = '<img src="immagini/velina_piede_vivisol.png" width="744" height="85" />';
	  break;
	}
/*	if ($mode != "print") {
	  echo "<div id=lingua_scheda>";
	  echo "<form id=form1 name=form1 method=get action=packing_list.php>";
		  switch ($mode) {
				//echo "Colli<br>";
			  default:
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 onfocus=\"svuotaColli();\" value=Colli>";
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=peso type=text id=peso size=10 onfocus=\"svuotaPeso();\" value=Peso>";
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=print>";
			  break;
			  case "cons":
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 value=".$colli.">";
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=peso type=text id=peso size=10 value=".$peso.">";
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=print>";
				echo "<input name=n_pl type=hidden id=n_pl value=".$n_pl.">";
				echo "<input name=aggiorna_visualizza type=hidden id=aggiorna_visualizza value=1>";
			  break;
			  case "nuovo":
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 value=".$colli.">";
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=peso type=text id=peso size=10 value=".$peso.">";
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=vis>";
				echo'<input name="temp_pl" type="hidden" id="temp_pl" value="'.$n_pl.'">';
			  break;
			  case "vis":
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 value=".$colli.">";
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=peso type=text id=peso size=10 value=".$peso.">";
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=print>";
				//echo'<input name="temp_pl" type="hidden" id="temp_pl" value="'.$n_pl.'">';
				echo "<input name=n_pl type=hidden id=n_pl value=".$n_pl.">";
				echo "<input name=aggiorna_dati_pack type=hidden id=aggiorna_dati_pack value=1>";
			  break;
		  }
	  echo "<div class=colonnine_form>";
		  //echo "Scelta vettore<br>";
			echo '<select name="vettore" style="margin-top:7px;" class="Stile1" id="vettore">';
			  echo $lista_vettori;
			echo "</select>";
	  echo "<input name=id type=hidden id=id value=".$id.">";
	  echo "<input name=output type=hidden id=output value=".$output.">";
		 // echo "<a href=packing_list.php?mode=print><img src=immagini/".$bottone_stampa." width=120 height=19 border=0 title=".$print_pkglist."></a>";
	  echo "</div>";
	  echo "<div class=colonnine_form style=\"padding-top:10px;\">";
		  //echo "<span class=scritta_bianca>Scelta vettore</span><br>";
  switch ($mode) {
	  case "nuovo":
	  echo "<a href=\"javascript:void(0);\" onclick=\"form1.submit()\"><span class=Stile1>Salva</span></a>";
	  break;
	  case "vis":
	  echo "<a href=\"javascript:void(0);\" onclick=\"form1.submit()\"><span class=Stile1>Salva e Stampa</span></a>";
	  break;
  }
	  //echo "<input name=submit class=tabellecentro style=\"margin-top:7px;\" type=image value=Invia src=immagini/".$bottone_stampa." width=120 height=19 border=0 title=".$print_pkglist.">";
	 echo "<br />";
  echo "</div>";
  echo "</div>";
  echo "</form>";
}
*/
  $conteggio_grm = count($array_grm);
$limite_max = 800;
  $spazio_intestazione_rda = 70;
  $spazio_totale_rda = 25;
  $spazio_grm = "20";
  $spazio_righe_rda = "32";
  $altezza_necessaria_stampa = ($spazio_intestazione_rda*$conteggio_rda)+($spazio_totale_rda*$conteggio_rda)+($conteggio_rda*$conteggio_grm)+($spazio_righe_rda*$conteggio_righe_rda);
  if ($altezza_necessaria_stampa > $limite_max) {
	  $pagine_PL = ceil($altezza_necessaria_stampa/$limite_max);
  } else {
	  $pagine_PL = 1;
  }
//*******************************
//generazione blocco righe
  //echo '<span style="color: #000;">'.$altezza_necessaria_stampa.'</span><br>';
	if (($altezza_reale + 70) <= $limite_max) {
	} else {
	  $altezza_reale = 0;
	  $blocco .= '(%)';
	}
	$altezza_reale = $altezza_reale + 70;
    
	foreach($array_pl as $cad_pl) {
	  $sum_fatt = "SELECT SUM(totale) as somma_fattura FROM qui_righe_rda WHERE pack_list = '$cad_pl'";
	  $resulth = mysql_query($sum_fatt);
	  list($somma_fattura) = mysql_fetch_array($resulth);
	  $totale_fatt = $totale_fatt + $somma_fattura;
	}
foreach($array_grm as $gruppo_merci_uff) {
	foreach($array_pl as $cad_pl) {
  $sum_parz_grm = "SELECT SUM(totale) as somma_parz_grm FROM qui_righe_rda WHERE pack_list = '$cad_pl' AND gruppo_merci = '$gruppo_merci_uff'";
  $resulth = mysql_query($sum_parz_grm);
  list($somma_parz_grm) = mysql_fetch_array($resulth);
  $totale_parz_grm = $totale_parz_grm + $somma_parz_grm;
	}
	$querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
	$results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
	  $descrizione_gruppo_merci = $rows[descrizione];
	  $codice_sap = $rows[codice_sap];
	}
	$blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
	  $blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; padding-left:0px;">';
		$blocco .= '<div class="box_60" style="text-align:right; width:50px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-right:20px; padding: 0px;">';
		  $blocco .= "euro";
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-right:10px; padding: 0px;">';
		  $blocco .= 'Q.tà';
		  $blocco .= "</div>";
	  $blocco .= "</div>";
		$altezza_reale = $altezza_reale + 20;
	  $blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; padding-left:0px;">';
		$blocco .= '<div class="box_60" style="padding: 0px;">';
		$blocco .= $gruppo_merci_uff;
		$blocco .= "</div>";
		$blocco .= '<div class="box_350" style="width:380px; border-left: 1px solid #000; padding: 0px 10px;">';
		$blocco .= $codice_sap." ".stripslashes($descrizione_gruppo_merci);
		$blocco .= "</div>";
		$blocco .= '<div class="box_60" style="text-align:right; width:50px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-right:20px; padding: 0px;">';
		  $blocco .= number_format($totale_parz_grm,2,",",".");
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-right:10px; padding: 0px;">';
		  $blocco .= "</div>";
	  $blocco .= "</div>";
		$altezza_reale = $altezza_reale + 20;
	  $totale_parz_grm = "";
	  $totale_grm = "";
	$blocco .= "</div>";
	foreach($array_pl as $ogni_pl) {
	  $queryg = "SELECT * FROM qui_righe_rda WHERE gruppo_merci = '$gruppo_merci_uff' AND pack_list = '$ogni_pl' ORDER BY pack_list ASC, id_rda ASC";
	  $resultg = mysql_query($queryg);
	  while ($rowg = mysql_fetch_array($resultg)) {
		if (($altezza_reale + 20) <= $limite_max) {
		} else {
		  $altezza_reale = 0;
		  $blocco .= '(%)';
		}
		$altezza_reale = $altezza_reale + 32;
		$blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
		  $blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:100%; min-height:15px; overflow:hidden; height:auto; padding-bottom:5px;">';
		  $blocco .= '<div class="box_60" style="min-height: 10px; overflow: hidden; height: auto; margin-top: 2px;">';
		  if (substr($rowg[codice_art],0,1) != "*") {
			$blocco .= $rowg[codice_art];
		  } else {
			$blocco .= substr($rowg[codice_art],1);
		  }
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_350" style="width:380px; min-height: 10px; overflow: hidden; height: auto; border-left: 1px solid #666; margin-top: 5px; padding: 2px 10px;">';
		  $blocco .= stripslashes($rowg[descrizione]);
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-top: 5px; margin-right:20px; padding: 2px 0px;">';
		  $blocco .= number_format($rowg[totale],2, ",",".");
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px; min-height: 10px; overflow: hidden; height: auto; margin-top: 5px; float:right; margin-right:20px; padding: 2px 0px;">';
		  $blocco .= intval($rowg[quant]);
		  $blocco .= "</div>";
		  $blocco .= "</div>";	
		$blocco .= "</div>";	
	  }
	}
	  if (($altezza_reale + 25) <= $limite_max) {
	  } else {
		$altezza_reale = 0;
		$blocco .= '(%)';
	  }
	  $altezza_reale = $altezza_reale + 25;
	  $blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px; margin-top: 10px;">';
		$blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; border-bottom:1px solid #CCC; padding-bottom:5px; padding-left:0px; margin-bottom:10px;">';
		$blocco .= "</div>";	
		//fine singola RdA
	$blocco .= '</div>';

  //fine foreach grm
}
/*	
		if (($altezza_reale + 32) <= $limite_max) {
		} else {
		  $altezza_reale = 0;
		  $blocco .= '(%)';
		}
		  $x = $x + 1;
			if ($x == "1") {
			  if ($rowg[n_ord_sap] != "") {
				$n_ord_sap = $rowg[n_ord_sap];
				if ($rowg[n_fatt_sap] != "") {
				  $n_fatt_sap = $rowg[n_fatt_sap];
				}
			  }
			}
      }
      
      $gruppo_merci_uff = "";
      
    $TOTALE_rda = "";
    $data_rda = "";
*/
  
  
$array_ordini_sap = array();
  
    if ($n_ord_sap != "") {
		if (!in_array($n_ord_sap,$array_ordini_sap)) {
		  $add_ord = array_push($array_ordini_sap,$n_ord_sap);
		  $blocco .= '<div class="colonnine_form" style="width:430px; margin-left: 119px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		  $blocco .= '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		  if ($n_fatt_sap != "") {
			  $blocco .= ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		  }
		  $blocco .= '</div>';
		}
    }
    if ($riepilogo_ord_for != "") {
      $blocco .= '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
      $blocco .= '<span style="font-weight:bold;">Ordine fornitore n.</span> '.$riepilogo_ord_for;
      $blocco .= '</div>';
    }
//fine generazione blocco righe
//*******************************
$array_blocchi = explode('(%)',$blocco);

$pagine_PL = count($array_blocchi);

for ($i = 0; $i < $pagine_PL; $i++) {
echo '<div id="main_container">
  <div id="parte_superiore" class="superiore">
  
  <div class="riga_divisoria" style="margin-left: 0px; margin-top:50px; min-height:23px; overflow:hidden; height: auto; border-bottom: 0px;">
    <div style="height:auto; width:390px; float:left;">'.$immagine_logo.'</div>
    <div class="indirizzi" style="height:100px; width:200px; float:left;">
    <span class="Stile4">Spett.le<br />'.$nome_unita.'</span>
    </div>
  </div>
  <div class="riga_divisoria" style="margin-top:30px; margin-bottom:10px;">';
	echo '<div style="width:360px; float:left;">Richiesta di Fatturazione '.$n_fatt_sap.'</div>';
	echo '<div style="margin-top:3px; width:auto; float:left; font-size:12px; font-family:Arial;">Pag. '.($i+1).' di '.$pagine_PL.'</div>';
  echo '<div style="width:590px; min-height:30px; overflow: hidden; height: auto;">
	<div class="riga_divisoria" style="margin-bottom:10px; margin-left: 0px; padding-bottom: 5px; border-bottom: 0px; font-size: 11px;">RdA '.$lista_rda.'</div>
  </div>';
	  echo '<div class="contenitore_gruppo_merci" style="width:100%; padding-left:0px;">
		<div class="box_60" style="text-align:right; width:50px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-right:20px; padding: 0px;">'.
		  number_format($totale_fatt,2,",",".").'
		  </div>
		  <div class="box_60" style="text-align:right; width:40px; min-height: 10px; overflow: hidden; height: auto; float:right; margin-right:10px; padding: 0px;">
		  Totale
		  </div>
		  </div>
  </div>';
  
  echo $array_blocchi[$i];

//PARTE TAGLIATA DA RIPRISTINARE-->
if ($i == ($pagine_PL - 1)) {
    if ($n_ord_sap != "") {
		if (!in_array($n_ord_sap,$array_ordini_sap)) {
		  $add_ord = array_push($array_ordini_sap,$n_ord_sap);
		  echo '<div class="colonnine_form" style="width:430px; margin-left: 119px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		  echo '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		  if ($n_fatt_sap != "") {
			  echo ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		  }
		  echo '</div>';
		}
    }
}

  echo '</div>';
  //contenitore piedino-->
  echo '<div class="immpiede">';
  echo $immagine_piede;
  echo '</div>
  
  </div>';
}
		$altezza_reale = 0;

//*********************
//ACCODAMENTO SINGOLI PL
//*********************
foreach($array_pl as $n_pl) {
$blocco = '';

  $queryv = "SELECT * FROM qui_packing_list WHERE id = '$n_pl'";
  $resultv = mysql_query($queryv);
  while ($rowv = mysql_fetch_array($resultv)) {
	$id_pack = stripslashes($rowv[id]);
	$indirizzo_spedizione = stripslashes($rowv[indirizzo_spedizione]);
	$utente = stripslashes($rowv[utente]);
	$colli = stripslashes($rowv[colli]);
	$peso = stripslashes($rowv[peso]);
	$data_spedizione = date("d/m/Y H:i",$rowv[data_spedizione]);
	$data_spedizionextestata = date("d/m/Y",$rowv[data_spedizione]);
	$indirizzo_vettore = stripslashes($rowv[vettore]);
	$id_vettore = $rowv[id_vettore];
	$pp = "SELECT * FROM qui_unita WHERE id_unita = '$rowv[id_unita]'";
	$risultpp = mysql_query($pp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rowp = mysql_fetch_array($risultpp)) {
	  $nome_unita = $rowp[nome_unita];
	}
	switch ($rowv[logo]) { 
	  case "sol":
		$immagine_logo = '<img src="immagini/velina_logo_sol.png" width="185" height="74" />';
		$immagine_piede = '<img src="immagini/velina_piede_sol.png" width="744" height="85" />';
	  break;
	  case "vivisol":
		$immagine_logo = '<img src="immagini/velina_logo_vivisol.png" width="251" height="74" />';
		$immagine_piede = '<img src="immagini/velina_piede_vivisol.png" width="744" height="85" />';
	  break;
	}
  
	$array_rdapl = array();
	$array_gruppo_merci = array();
	
	$queryt = "SELECT * FROM qui_righe_rda WHERE pack_list = '$n_pl' ORDER BY id_rda ASC";
    $resultt = mysql_query($queryt);
	$conteggio_righe_rda = mysql_num_rows($resultt);
    while ($rowt = mysql_fetch_array($resultt)) {
      if (!in_array($rowt[id_rda],$array_rdapl)) {
          $addRdapl = array_push($array_rdapl,$rowt[id_rda]);
      }
      if (!in_array($rowt[gruppo_merci],$array_gruppo_merci)) {
          $addgrm = array_push($array_gruppo_merci,$rowt[gruppo_merci]);
      }
	}
  $conteggio_rda = count($array_rdapl);
  $conteggio_grm = count($array_gruppo_merci);
$limite_max = 800;
  $spazio_intestazione_rda = 70;
  $spazio_totale_rda = 25;
  $spazio_grm = "20";
  $spazio_righe_rda = "32";
  $altezza_necessaria_stampa = ($spazio_intestazione_rda*$conteggio_rda)+($spazio_totale_rda*$conteggio_rda)+($conteggio_rda*$conteggio_grm)+($spazio_righe_rda*$conteggio_righe_rda);
  if ($altezza_necessaria_stampa > $limite_max) {
	  $pagine_PL = ceil($altezza_necessaria_stampa/$limite_max);
  } else {
	  $pagine_PL = 1;
  }
  //$array_righe_vis = explode(",",$_SESSION[lista_righe]);
//*******************************
//generazione blocco righe
  //echo '<span style="color: #000;">'.$altezza_necessaria_stampa.'</span><br>';
  foreach ($array_rdapl as $sing_rda_vis) {
    $sqlh = "SELECT * FROM qui_rda WHERE id = '$sing_rda_vis'";
    $risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
    while ($rigah = mysql_fetch_array($risulth)) {
      $data_rda = date("d/m/Y", $rigah[data_inserimento]);
      $utente_rda = $rigah[nome_utente];
      $sqls = "SELECT * FROM qui_ordini_for WHERE id_rda = '$sing_rda_vis'";
      $risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
      $quant_ord = mysql_num_rows($risults);
      //if ($quant_ord > 0) {
        //while ($rigas = mysql_fetch_array($risults)) {
         // $riepilogo_ord_for .= "Ordine ".$rigas[id]." del ".date("d/m/Y",$rigas[data_ordine]).", ";
        //}
      //}
    }
	if (($altezza_reale + 70) <= $limite_max) {
	} else {
	  $altezza_reale = 0;
	  $blocco .= '(%)';
	}
	$altezza_reale = $altezza_reale + 70;
  $blocco .= '<div style="width:590px; min-height:30px; overflow: hidden; height: auto; margin-left: 119px;">';
	$blocco .= '<div class="riga_divisoria" style="margin-bottom:10px; margin-left: 0px; padding-bottom: 5px; border-bottom: 0px;">RdA '.$sing_rda_vis.' del '.$data_rda.' ('.$utente_rda.')';
	  $queryp = "SELECT * FROM qui_rda WHERE id = '$sing_rda_vis'";
      $resultp = mysql_query($queryp);
      while ($rowp = mysql_fetch_array($resultp)) {
		  if ($rowp[note_utente] != "") {
			  $note .= '<strong>Note utente:</strong> '.$rowp[note_utente].' - ';
		  }
		  if ($rowp[note_resp] != "") {
			  $note .= '<strong>Note responsabile:</strong> '.$rowp[note_resp].' - ';
		  }
		  if ($rowp[note_buyer] != "") {
			  $note .= '<strong>Note buyer:</strong> '.$rowp[note_buyer].' - ';
		  }
		  if ($rowp[note_magazziniere] != "") {
			  $note .= '<strong>Note magazziniere:</strong> '.$rowp[note_magazziniere].' - ';
		  }
	  }
	if ($note != "") {
		$blocco .= '<br><span style="font-size:11px; font-weight:normal;">'.$note.'</span>';
	}
	$note = "";
	$blocco .= '</div>';
  $blocco .= '</div>';
    
		$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_vis' AND pack_list = '$n_pl' ORDER BY gruppo_merci ASC";
      $resultg = mysql_query($queryg);
      while ($rowg = mysql_fetch_array($resultg)) {
		if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
			if ($gruppo_merci_uff != "") {
			  //$blocco .= "<div class=riga_divisoria style=margin-bottom:10px; border-bottom:none; border-top:none;>";
			 // $blocco .= "</div>";
			}
			$gruppo_merci_uff = $rowg[gruppo_merci];
			$querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
			$results = mysql_query($querys);
			while ($rows = mysql_fetch_array($results)) {
				$descrizione_gruppo_merci = $rows[descrizione];
				$codice_sap = $rows[codice_sap];
			}
			$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$sing_rda_vis' AND pack_list = '$n_pl' AND gruppo_merci = '$gruppo_merci_uff'";
			$resultz = mysql_query($sum_grm);
			list($somma_grm) = mysql_fetch_array($resultz);
			$totale_grm = $somma_grm;
			$TOTALE_rda = $TOTALE_rda + $totale_grm;
			if (($altezza_reale + 20) <= $limite_max) {
			} else {
			  $altezza_reale = 0;
			  $blocco .= '(%)';
			}
			$altezza_reale = $altezza_reale + 20;
			$blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
			  $blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; padding-left:0px;">';
				$blocco .= '<div class="box_60">';
				$blocco .= $gruppo_merci_uff;
				$blocco .= "</div>";
				$blocco .= '<div class="box_350" style="width:400px;">';
				$blocco .= "| ".$codice_sap." ".stripslashes($descrizione_gruppo_merci);
				$blocco .= "</div>";
			  $blocco .= "</div>";
			  $totale_grm = "";
			$blocco .= "</div>";
          }
		if (($altezza_reale + 32) <= $limite_max) {
		} else {
		  $altezza_reale = 0;
		  $blocco .= '(%)';
		}
		$altezza_reale = $altezza_reale + 32;
		$blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
		  $blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:100%; min-height:15px; overflow:hidden; height:32px; padding-left:0px;">';
		  $blocco .= '<div class="box_60">';
		  if (substr($rowg[codice_art],0,1) != "*") {
			$blocco .= $rowg[codice_art];
		  } else {
			$blocco .= substr($rowg[codice_art],1);
		  }
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_350" style="width:440px;">';
		  $blocco .= "| ".stripslashes($rowg[descrizione]);
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px; float:right; margin-right:20px;">';
		  $blocco .= intval($rowg[quant]);
		  $blocco .= "</div>";
		  $x = $x + 1;
			if ($x == "1") {
			  if ($rowg[n_ord_sap] != "") {
				$n_ord_sap = $rowg[n_ord_sap];
				if ($rowg[n_fatt_sap] != "") {
				  $n_fatt_sap = $rowg[n_fatt_sap];
				}
			  }
			}
		  $blocco .= "</div>";	
		$blocco .= "</div>";	
      }
      
      $gruppo_merci_uff = "";
      
	  if (($altezza_reale + 25) <= $limite_max) {
	  } else {
		$altezza_reale = 0;
		$blocco .= '(%)';
	  }
	  $altezza_reale = $altezza_reale + 25;
	  $blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
		$blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; border-bottom:1px solid #CCC; padding-bottom:5px; padding-left:0px; margin-bottom:10px;">';
		$blocco .= "</div>";	
		//fine singola RdA
	$blocco .= '</div>';
    $TOTALE_rda = "";
    $data_rda = "";
		$altezza_reale = 0;
  //fine foreach
  }
  
  
$array_ordini_sap = array();
  
    if ($n_ord_sap != "") {
		if (!in_array($n_ord_sap,$array_ordini_sap)) {
		  $add_ord = array_push($array_ordini_sap,$n_ord_sap);
		  $blocco .= '<div class="colonnine_form" style="width:430px; margin-left: 119px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		  $blocco .= '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		  if ($n_fatt_sap != "") {
			  $blocco .= ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		  }
		  $blocco .= '</div>';
		}
    }
    if ($riepilogo_ord_for != "") {
      $blocco .= '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
      $blocco .= '<span style="font-weight:bold;">Ordine fornitore n.</span> '.$riepilogo_ord_for;
      $blocco .= '</div>';
    }
//fine generazione blocco righe
//*******************************
$array_blocchi = explode('(%)',$blocco);

$pagine_PL = count($array_blocchi);

for ($i = 0; $i < $pagine_PL; $i++) {
echo '<div id="main_container">
  <div id="parte_superiore" class="superiore">
  
  <div class="riga_divisoria" style="margin-left: 0px; margin-top:50px; min-height:23px; overflow:hidden; height: auto; border-bottom: 0px;">
    <div style="height:auto; width:390px; float:left;">'.$immagine_logo.'</div>
    <div class="indirizzi" style="height:100px; width:165px; float:left;">
    <span class="Stile4">Destinatario<br />'.$indirizzo_spedizione.'</span>
    </div>
  </div>
  <div class="riga_divisoria" style="margin-top:30px; margin-bottom:10px;">';
    if ($mode == "nuovo") {
		echo '<div style="width:360px; float:left;">Packing List del '.$data_spedizionextestata.'</div>';
	} else {
		echo '<div style="width:360px; float:left;">Packing List '.$id_pack.' del '.$data_spedizionextestata.'</div>';
	}

	echo '<div style="margin-top:3px; width:auto; float:left; font-size:12px; font-family:Arial;">Pag. '.($i+1).' di '.$pagine_PL.'</div>
  </div>';
  echo $array_blocchi[$i];

//PARTE TAGLIATA DA RIPRISTINARE-->
if ($i == ($pagine_PL - 1)) {
    if ($n_ord_sap != "") {
		if (!in_array($n_ord_sap,$array_ordini_sap)) {
		  $add_ord = array_push($array_ordini_sap,$n_ord_sap);
		  echo '<div class="colonnine_form" style="width:430px; margin-left: 119px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		  echo '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		  if ($n_fatt_sap != "") {
			  echo ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		  }
		  echo '</div>';
		}
    }
    if ($riepilogo_ord_for != "") {
      echo '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
      echo '<span style="font-weight:bold;">Ordine fornitore n.</span> '.$riepilogo_ord_for;
      echo '</div>';
    }
    echo '<div class="colonnine_form" style="width:230px; height:70px; margin-left: 119px;">
      <span class="Stile4"><strong> Inizio trasporto</strong>';
        if ($data_spedizione > 0) {
            echo $data_spedizione;
        }
      echo '</span><br>
      <span class="Stile4"><strong>Colli</strong>';
        if ($colli != "Colli") {
            echo $colli;
        }
      echo '</span><br>
      <span class="Stile4"><strong>Peso kg </strong>';
          if ($peso != "Peso") {
              echo $peso;
          }
      echo '</span>
    </div>
    <div class="note_varie" style="width:192px;">
      <span class="Stile4"><strong>Vettore</strong><br />'.$indirizzo_vettore.'<br></span>
    </div>
    <div class="note_varie" style="width:192px;">
      <span class="Stile4"><strong>Firma</strong><br /></span>
      <img src="immagini/spacer.gif" width="192" height="40" />
    </div>';
}

  echo '</div>';
  //contenitore piedino-->
  echo '<div class="immpiede">';
  echo $immagine_piede;
  echo '</div>
  
  </div>';
}
//fine while PL
  }

}
/*
*/

?>
</body>
<script type="text/javascript">
function aggiorna_nota(id_pl) {
var tx_testo = nota.value.replace(/\r?\n/g, '<br>');
  /*alert(tx_testo);*/
  $.ajax({
		  type: "GET",   
		  url: "aggiorna_pl.php",   
		  data: "testo="+tx_testo+"&id_pl="+id_pl,
		  success: function(output) {
		  $('#aaa').html(output).show();
		  }
		  });
}
</SCRIPT>
</html>
