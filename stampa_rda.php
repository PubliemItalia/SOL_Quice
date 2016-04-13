<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
}
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}

$id_rda = $_GET['id_rda'];

switch($lingua) {
case "it":
$bottone_stampa = "btn_green_freccia_stampa_ita.png";
$bottone_chiudi = "btn_green_freccia_chiudi_ita.png";
break;
case "en":
$bottone_stampa = "btn_green_freccia_stampa_eng.png";
$bottone_chiudi = "btn_green_freccia_chiudi_eng.png";
break;
}




$timestamp_attuale = time();
$dataora_attuali = date("d.m.Y H:i",$timestamp_attuale);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/report.css" />
<link rel=”stylesheet” href=”css/video.css” type=”text/css” media=”screen” />
<link rel=”stylesheet” href=”css/printer.css” type=”text/css” media=”print” />
<title>Stampa RdA</title>
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
		height: 1090px;
}
.immpiede {
	width:100%; height:100px;
}
.superiore {
	width: 100%; height: 990px;
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
	width:593px;
	height: 23px;
	margin-left:119px;
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
	padding-top:2px;
	height: auto;
	float:left;
}
@media print{
	#main_container{
		page-break-after: avoid;
		page-break-before:avoid;
		page-break-inside: auto;
		width: 750px;
		height: 1090px;
	}
.immpiede {
	width:100%; height:100px;
}
.superiore {
	width: 100%; height: 990px;
}
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function refreshParent() {
  window.opener.axc(<?php echo "0,0,".$id_rda.",11"; ?>);
}
</script>

</head>

<?php
if ($mode == "print") {
echo '<body onLoad="javascript:window.print();" onunload="refreshParent();">';
} else {
echo "<body>";
}
/*if ($mode == "") {
echo "<div id=lingua_scheda>";
  echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td width=810 class=testo_chiudi><img src=immagini/spacer.gif width=810 height=15></td>";
        echo "<td class=Stile1 width=120>";
          echo "<div align=right>";
			switch($lingua) {
case "it":
echo "<a href=\"javascript: submitform()\"><span class=Stile1>Stampa</span></a>";
break;
case "en":
echo "<a href=\"javascript: submitform()\"><span class=Stile1>Print</span></a>";
break;
}

          echo "</div>";
        echo "</td>";
        echo "<td width=30><img src=immagini/spacer.gif width=30 height=15></td>";
    echo "</tr>";
    echo "</table>  ";  
echo "</div>";
	}
*/
	$sqlc = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigac = mysql_fetch_array($risultc)) {
  $utente = stripslashes($rigac[nome_utente]);
  $responsabile = stripslashes($rigac[nome_resp]);
  $wbs_rda = stripslashes($rigac[wbs]);
  $idcompany_scelta = $rigac[id_company];
  $nomecompany_scelta = $rigac[nome_company];
  $indirizzo_spedizione = $rigac[indirizzo_spedizione];
  if ($indirizzo_spedizione == "") {
	$sqld = "SELECT * FROM qui_utenti WHERE user_id = '$rigac[id_utente]'";
	$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigad = mysql_fetch_array($risultd)) {
	  if ($rigad[IDCompany] == $idcompany_scelta) {
		$indirizzo_spedizione .= "<strong>".$rigad[companyName]."<br>";
		$indirizzo_spedizione .= $rigad[nomeunita]."</strong><br>";
		$indirizzo_spedizione .= $rigad[indirizzo]."<br>";
		$indirizzo_spedizione .= $rigad[cap]." ";
		$indirizzo_spedizione .= $rigad[localita]."<br>";
		$indirizzo_spedizione .= $rigad[nazione];
		$indirizzo_spedizione .= $aggiunta_company;
	  } else {
		$indirizzo_spedizione .= "<strong>".$nomecompany_scelta."</strong><br>";
	  }
	}
  }
}
/*
if ($rigac[note_utente] != "") {
$note .= "<strong>Note utente</strong> ".$rigac[note_utente]."<br>";
}
if ($rigac[note_resp] != "") {
$note .= "<strong>Note responsabile</strong> ".$rigac[note_resp]."<br>";
}
if ($rigac[note_buyer] != "") {
$note .= "<strong>Note buyer</strong> ".$rigac[note_buyer]."<br>";
}
if ($rigac[note_magazziniere] != "") {
$note .= "<strong>Note magazziniere</strong> ".$rigac[note_magazziniere]."<br>";
}
*/
	if ($mode != "print") {
	  echo "<form id=form1 name=form1 method=get action=stampa_rda.php>";
	  echo "<div id=lingua_scheda>";
	  echo "<div class=colonnine_form>";
		  //echo "Colli<br>";
		  if ($mode == "cons") {
	  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 value=".$colli.">";
		  } else {
	  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 onfocus=\"svuotaColli();\" value=Colli>";
		  }
	  echo "</div>";
	  echo "<div class=colonnine_form>";
		  //echo "Peso<br>";
		  if ($mode == "cons") {
	  echo "<input class=Stile1 style=\"margin-top:7px;\" name=peso type=text id=peso size=10 value=".$peso.">";
		  } else {
	  echo "<input class=Stile1 style=\"margin-top:7px;\" name=peso type=text id=peso size=10 onfocus=\"svuotaPeso();\" value=Peso>";
		  }
		  echo "</div>";
	  echo "<div class=colonnine_form>";
		  //echo "Scelta vettore<br>";
			echo "<select name=vettore style=\"margin-top:7px;\" class=Stile1 id=vettore>";
			  echo $lista_vettori;
			echo "</select>";
	  echo "<input name=id type=hidden id=id value=".$id.">";
	  echo "<input name=mode type=hidden id=mode value=print>";
	  echo "<input name=output type=hidden id=output value=".$output.">";
	  echo "</div>";
	  echo "<div class=colonnine_form style=\"padding-top:10px;\">";
		  //echo "<span class=scritta_bianca>Scelta vettore</span><br>";
	  echo "<a href=\"javascript:void(0);\" onclick=\"form1.submit()\"><span class=Stile1>Salva</span></a>";
	  //echo "<input name=submit class=tabellecentro style=\"margin-top:7px;\" type=image value=Invia src=immagini/".$bottone_stampa." width=120 height=19 border=0 title=".$print_pkglist.">";
		 echo "<br />";
	  echo "<input name=mode type=hidden id=mode value=print>";
		  if ($mode == "cons") {
		  echo "<input name=aggiorna_visualizza type=hidden id=aggiorna_visualizza value=1>";
		  } else {
		  echo "<input name=aggiorna_dati_pack type=hidden id=aggiorna_dati_pack value=1>";
		  }
	  echo "<input name=n_pl type=hidden id=n_pl value=".$n_pl.">";
	  echo "</div>";
	  echo "</div>";
	  echo "</form>";
	}

  $array_rdapl = array();
  $array_gruppo_merci = array();
     $queryy = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND printable ='1'";
    $resulty = mysql_query($queryy);
	$righe_da_stamp = mysql_num_rows($resulty);
	if ($righe_da_stamp > 0) {
	  $queryt = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND printable ='1' ORDER BY id ASC";
	} else{
	  $queryt = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' ORDER BY id ASC";
	}
 
    $resultt = mysql_query($queryt);
	$conteggio_righe_rda = mysql_num_rows($resultt);
    while ($rowt = mysql_fetch_array($resultt)) {
		if ($rowt[azienda_prodotto] == "") {
			$prodotti_sol = $prodotti_sol+1;
		}
		if ($rowt[azienda_prodotto] == "SOL") {
			$prodotti_sol = $prodotti_sol+1;
		}
		if ($rowt[azienda_prodotto] == "VIVISOL") {
			$prodotti_vivisol = $prodotti_vivisol+1;
		}
      if (!in_array($rowt[id_rda],$array_rdapl)) {
          $addRdapl = array_push($array_rdapl,$rowt[id_rda]);
      }
      if (!in_array($rowt[gruppo_merci],$array_gruppo_merci)) {
          $addgrm = array_push($array_gruppo_merci,$rowt[gruppo_merci]);
      }
	}
	if ($prodotti_vivisol == 0) {
		$immagine_logo = '<img src="immagini/velina_logo_sol.png" width="188" height="75" />';
		$immagine_piede = '<img src="immagini/velina_piede_sol.png" width="750" height="86" />';
	} else {
		$immagine_logo = '<img src="immagini/velina_logo_vivisol.png" style="width: 68%;" />';
		$immagine_piede = '<img src="immagini/velina_piede_vivisol.png" width="263" height="77" />';
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
  if ($mode == "print") {
	$riepilogo = "stampa rda (".$id_rda.")".$id_utente;
	$datalog = mktime();
	$datalogtx = date("d.m.Y H:i",$datalog);
	$operatore = addslashes($_SESSION['nome']);
	$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '$array_rda[0]', '$riepilogo')";
	if (mysql_query($queryb)) {
	} else {
	echo "Errore durante l'inserimento". mysql_error();
	}
  }
?>       
<!--<div id="aaa">
</div>-->
<?php
//*******************************
//generazione blocco righe
  //echo '<span style="color: #000;">'.$altezza_necessaria_stampa.'</span><br>';
    $sqlh = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
    $risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
    while ($rigah = mysql_fetch_array($risulth)) {
      $data_rda = date("d/m/Y", $rigah[data_inserimento]);
      $utente_rda = $rigah[nome_utente];
      $sqls = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id_rda'";
      $risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
      $quant_ord = mysql_num_rows($risults);
      if ($quant_ord > 0) {
        while ($rigas = mysql_fetch_array($risults)) {
          $riepilogo_ord_for .= "Ordine ".$rigas[id]." del ".date("d/m/Y",$rigas[data_ordine]).", ";
        }
      }
    }
	if (($altezza_reale + 70) <= $limite_max) {
	} else {
	  $altezza_reale = 0;
	  $blocco .= '(%)';
	}
	$altezza_reale = $altezza_reale + 70;
  //$blocco .= '<div style="width:100%; min-height:30px; overflow: hidden; height: auto; margin-left: 119px;">';
	$blocco .= '<div class="riga_divisoria" style="margin-bottom:10px; margin-left: 0px; padding-bottom: 5px; padding-left: 10px; border-bottom: 0px;margin-left: 119px; width: 583px; min-height:15px; overflow:hidden; height:auto; ">';
	  $queryp = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
      $resultp = mysql_query($queryp);
      while ($rowp = mysql_fetch_array($resultp)) {
		  if ($rowp[note_utente] != "") {
			  $note = '<strong>Note utente:</strong> '.$rowp[note_utente].' - ';
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
  //$blocco .= '</div>';
    
	$blocco .= '<div style="width:593px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
	  $blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:100%; min-height:15px; overflow:hidden; height:32px; padding-left:0px;padding-right:0px;">';
		$blocco .= '<div class="box_60" style="margin-right: 10px;text-align:right; width:60px; float:right; font-size: 8px; border-bottom: 2px solid #efefef; padding-bottom: 5px; padding-right: 5px; background-color: #ededed;">';
		  $blocco .= 'TOTALE &euro;';
		$blocco .= "</div>";
		$blocco .= '<div class="box_60" style="text-align:center; width:60px; float:right; font-size: 8px; border-bottom: 2px solid #efefef; padding-bottom: 5px;">';
		  $blocco .= 'QUANTIT&Agrave;';
		$blocco .= "</div>";
		$blocco .= '<div class="box_60" style="text-align:center; width:60px; float:right; font-size: 8px; border-bottom: 2px solid #efefef; padding-bottom: 5px;">';
		  $blocco .= 'CONFEZIONE';
		$blocco .= "</div>";
	  $blocco .= '</div>';
	$blocco .= '</div>';
	if ($righe_da_stamp > 0) {
     $queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND printable ='1' ORDER BY gruppo_merci ASC";
	} else{
     $queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' ORDER BY gruppo_merci ASC";
	}
      $resultg = mysql_query($queryg);
      while ($rowg = mysql_fetch_array($resultg)) {
			$TOTALE_rda = $TOTALE_rda + $rowg[totale];
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
			if ($righe_da_stamp > 0) {
			  $sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$id_rda' AND printable ='1' AND gruppo_merci = '$gruppo_merci_uff'";
			} else{
			  $sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$id_rda' AND gruppo_merci = '$gruppo_merci_uff'";
			}
			$resultz = mysql_query($sum_grm);
			list($somma_grm) = mysql_fetch_array($resultz);
			$totale_grm = $somma_grm;
			if (($altezza_reale + 20) <= $limite_max) {
			} else {
			  $altezza_reale = 0;
			  $blocco .= '(%)';
			}
			$altezza_reale = $altezza_reale + 20;
			$blocco .= '<div style="width:593px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
			  $blocco .= '<div class="contenitore_gruppo_merci" style="width:98%; padding-left:0px;">';
				$blocco .= '<div class="box_60">';
				$blocco .= $gruppo_merci_uff;
				$blocco .= "</div>";
				$blocco .= '<div class="box_350" style="width:400px;">';
				$blocco .= "| ".$codice_sap." ".stripslashes($descrizione_gruppo_merci);
				$blocco .= "</div>";
				/*$blocco .= '<div class=box_60 style="text-align:right; width:40px;">';
				$blocco .= "-";
				//$blocco .= number_format($rowg[quant],2,",",".");
				$blocco .= "</div>";
				$blocco .= '<div class="box_90" style="text-align:right; width:70px; float:right;">';
				$blocco .= number_format($totale_grm,2,",",".");
				$blocco .= "</div>";*/
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
		$blocco .= '<div style="width:593px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
		if ($rowg[stato_ordine] < 4) {
		  $blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:583px; min-height:15px; overflow:hidden; height:32px; padding-left:0px; border-bottom: 1px solid #bbb;">';
		} else {
		  $blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:583px; min-height:15px; overflow:hidden; height:32px; padding-left:0px; background-color: #eee; border-bottom: 1px solid #bbb;">';
		}
		  $blocco .= '<div class="box_60">';
		  if (substr($rowg[codice_art],0,1) != "*") {
			$blocco .= $rowg[codice_art];
		  } else {
			$blocco .= substr($rowg[codice_art],1);
		  }
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_350" style="width:295px; border-left: 1px solid #666; padding-left: 5px; padding-bottom:2px; padding-top: 2px; ">';
		  $blocco .= stripslashes($rowg[descrizione]);
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:60px; float:right; padding-right: 5px; padding-top: 2px; padding-bottom:2px;">';
		  $blocco .= number_format($rowg[totale],2,",",".");
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:center; width:60px; float:right; padding-top: 2px; padding-bottom:2px;">';
		  $blocco .= intval($rowg[quant]);
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:center; width:60px; float:right; padding-top: 2px; padding-bottom:2px;">';
		  $blocco .= intval($rowg[confezione]);
		  $blocco .= "</div>";
		if ($rowg[stato_ordine] == 4) {
		  $blocco .= '<div class="box_90" style="text-align:right; width:150px; padding-right: 2px; padding-top: 2px; float:right; color: #000; font-size: 10px;">';
		  switch ($rowg[output_mode]) {
			  case 'mag':
			  case 'lab':
			  case 'htc':
			  case 'bmc':
				$blocco .= 'PL '.$rowg[pack_list];
			  break;
			  case 'sap':
				$blocco .= 'ord '.$rowg[fornitore_tx].' '.$rowg[ord_fornitore];
			  break;
			  case 'ord':
				$queryp = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda = '$rowg[id]'";
				$resultp = mysql_query($queryp);
				while ($rowp = mysql_fetch_array($resultp)) {
					$blocco .= 'Ord. fornitore '.$rowp[id_ordine_for];
				}
			  break;
		  }
		  $blocco .= "</div>";
		}
		  /*$blocco .= '<div class="box_40" style="text-align:center; display:none;">';
		  $blocco .= $rowg[output_mode];
		  $blocco .= "</div>";*/
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
	  $blocco .= '<div style="width:593px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px; margin-top: 20px;">';
		$blocco .= '<div class="contenitore_gruppo_merci" style="width:98%; border-bottom:1px solid #CCC; padding-bottom:5px; padding-left:0px; margin-bottom:10px;">';
		  /*$blocco .= "<div class=box_60>";
		  $blocco .= "Totale";
		  $blocco .= "</div>";	
			  
		  $blocco .= '<div class="box_350" style="width:400px;">';
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px;">';
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_90" style="text-align:right; width:70px; float:right;">';
		  $blocco .= number_format($TOTALE_rda,2,",",".");
		  $blocco .= "</div>";*/
		$blocco .= "</div>";	
		//fine singola RdA
	$blocco .= '</div>';
	$blocco .= '<div style="width:593px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px; font-family: Arial; font-size:12px;">';
	  //$blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:100%; min-height:15px; overflow:hidden; height:32px; padding-left:0px;padding-right:0px;">';
		  $blocco .= '<div class="box_60" style="height: 13px; text-align:right; width:60px; float:right;font-weight: bold; border-bottom: 1px solid #efefef; padding-bottom: 5px; padding-right: 5px; background-color: #e2e2e2;">';
		  $blocco .= number_format($TOTALE_rda,2,",",".");
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="height: 13px; text-align:left; width:105px; float:right; font-size: 8px; font-weight: bold; border-bottom: 1px solid #efefef; padding-left: 5px; padding-bottom: 2px; padding-top: 8px; background-color: #e2e2e2;">';
		  $blocco .= 'TOTALE RdA &euro;';
		  $blocco .= "</div>";
 // $blocco .= '</div>';
  $blocco .= '</div>';
  
  
  
    if ($n_ord_sap != "") {
      $blocco .= '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px; margin-left: 119px;">';
      $blocco .= '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
      if ($n_fatt_sap != "") {
          $blocco .= ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
      }
      $blocco .= '</div>';
    }
    if ($riepilogo_ord_for != "") {
      $blocco .= '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px; margin-left: 119px;">';
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
  
  <div class="riga_divisoria" style="width: 100%; margin-left: 0px; margin-top:50px; min-height:23px; overflow:hidden; height: auto; border-bottom: 0px;">
    <div style="height:auto; width:400px; float:left;">'.$immagine_logo.'</div>
    <div class="indirizzi" style="height:100px; width:297px; float:right;">
    <span class="Stile4">Destinatario<br />'.$indirizzo_spedizione.'</span>
    </div>
  </div>
  <div class="riga_divisoria" style="margin-top:30px; margin-bottom:10px; background-color: #bbb; border-bottom: none; width: 573; height: 19px; color: #fff; padding: 7px 0px">
	<div style="width:500px; margin-left: 10px; float:left;">RdA '.$id_rda.' del '.$data_rda.' ('.$utente_rda.')</div>
	<div style="margin-top:3px; margin-right: 10px; width:auto; float:right; font-size:12px; font-family:Arial;">Pag. '.($i+1).' di '.$pagine_PL.'</div>
  </div>';
/*
  if ($i == 0) {
	echo '<div class="indirizzi" style="width:100%; height:60px;">
		<div style="width:360px; height:50px; float:left; margin-left: 119px;">
		  <span class="Stile4"><strong>Responsabile</strong> '.$resp_rda.'</span>
		</div>
		<div class="note_varie">';
		if ($mode == "print") {
			echo $note;
		} else {
			echo '<textarea name="nota" class="campo_note" style="width:180px; height:60px;" id="nota" onKeyUp="aggiorna_nota('.$id_pack.')">'.strip_tags($note).'</textarea>';
		}
		echo '</div>
	</div>';
  }
*/  
  echo $array_blocchi[$i];

//PARTE TAGLIATA DA RIPRISTINARE-->
  /*if ($i == ($pagine_PL - 1)) {
	  if ($n_ord_sap != "") {
		echo '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		echo '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		if ($n_fatt_sap != "") {
			echo ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		}
		echo '</div>';
	  }
	  if ($riepilogo_ord_for != "") {
		echo '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		echo '<span style="font-weight:bold;">Ordine fornitore n.</span> '.$riepilogo_ord_for;
		echo '</div>';
	  }
  }
*/
  echo '</div>';
  //contenitore piedino-->
  echo '<div class="immpiede">';
  echo $immagine_piede;
  echo '</div>
  
  </div>';
}
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
