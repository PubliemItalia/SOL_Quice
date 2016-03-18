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
	width:960px;
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
	width:723px;
	margin-bottom: 10px;
	height: 832px;
	padding-right: 5px;
}
#order_container {
	width:637px;
	height:750px;
	margin: auto;
}
.testata_logo {
	width:335px;
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
	margin-left:100px;
	width:622px;
	height: auto;
	float:left;
}
.cont_esterno {
	width:637px;
	height: auto;
	float:left;
}
.indirizzi {
	width:280px;
	height: 90px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.note_varie {
	width:315px;
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
-->
</style>
<script type="text/javascript">
function refreshParent() {
  /*window.parent.location.href=window.location.href;*/
  window.opener.chiusura(<?php echo $id_rda; ?>);
}
</script>
</head>

<?php
if ($mode == "print") {
echo "<body onLoad=javascript:window.print()>";
} else {
echo "<body onUnload=\"refreshParent()\">";
}
?>
        
<div id="main_container">


<?php
	$sqlc = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigac = mysql_fetch_array($risultc)) {
$utente = stripslashes($rigac[nome_utente]);
$responsabile = stripslashes($rigac[nome_resp]);
$wbs_rda = stripslashes($rigac[wbs]);
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

$sqld = "SELECT * FROM qui_utenti WHERE user_id = '$rigac[id_utente]'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$indirizzo_spedizione .= "<strong>".$rigad[companyName]."<br>";
$indirizzo_spedizione .= $rigad[nomeunita]."</strong><br>";
$indirizzo_spedizione .= $rigad[indirizzo]."<br>";
$indirizzo_spedizione .= $rigad[cap]." ";
$indirizzo_spedizione .= $rigad[localita]."<br>";
$indirizzo_spedizione .= $rigad[nazione];
}

}

?>

<div class="testata_logo">
<img src="immagini/Marchio-SOL_new.jpg"/>
</div>
<div class="indirizzi">
<span class="Stile4">Destinatario<br /><?php echo $indirizzo_spedizione; ?></span>
</div>

<div class="riga_divisoria" style="margin:50px 0px 10px 100px;">Packing List<br /><img src=immagini/spacer.gif width=622 height=10><img src="immagini/riga_prev_GREY.jpg" width="622" height="1" /></div>
<div class="indirizzi" style="margin-left:100px; width:260px;">
<span class="Stile4"><strong>Utente</strong> <?php echo $utente; ?><br />
        <strong>Responsabile</strong> <?php echo $responsabile; ?>
        <?php
		if ($wbs_rda != "") {
		echo "<br /><strong>WBS: </strong>".$wbs_rda;
		}
		?></span>
  </div>
    <div class="note_varie">
	<?php echo $note; ?>
</div>
<div class="riga_divisoria" style="margin-bottom:10px;">RdA <?php echo $id_rda; ?><br /><img src=immagini/spacer.gif width=622 height=10><img src="immagini/riga_prev_GREY.jpg" width="622" height="1" /></div>

        <?php
echo "<div class=riga_divisoria style=\"margin-bottom:10px; height:650px; margin-left:0px; padding:0px;\">";

$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' ORDER BY id ASC";
$resultg = mysql_query($queryg);
while ($rowg = mysql_fetch_array($resultg)) {
	if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
		if ($gruppo_merci_uff != "") {
echo "<div class=riga_divisoria style=margin-bottom:10px;><img src=immagini/spacer.gif width=622 height=10><img src=immagini/riga_prev_GREY.jpg width=622 height=1>";
echo "</div>";
		}
		$gruppo_merci_uff = $rowg[gruppo_merci];
$querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
	$descrizione_gruppo_merci = $rows[descrizione];
	}
echo "<div class=contenitore_gruppo_merci style=\"margin-left:100px;width:622px;\">";
echo "<div class=box_60>";
echo $gruppo_merci_uff;
echo "</div>";
echo "<div class=box_350>";
echo "| ".stripslashes($descrizione_gruppo_merci);
echo "</div>";
echo "<div class=box_60 style=\"text-align:right; width:40px;\">";
echo "-";
//echo number_format($rowg[quant],2,",",".");
echo "</div>";
echo "<div class=box_90 style=\"text-align:right; width:70px;\">";
echo number_format($totale_grm,2,",",".");
echo "</div>";
echo "</div>";
$totale_grm = "";
	}
echo "<div class=contenitore_riga_fattura style=\"margin-left:100px;width:622px;\">";
echo "<div class=box_60>";
if (substr($rowg[codice_art],0,1) != "*") {
  echo $rowg[codice_art];
} else {
  echo substr($rowg[codice_art],1);
}
echo "</div>";
echo "<div class=box_350>";
echo "| ".stripslashes($rowg[descrizione]);
echo "</div>";
echo "<div class=box_60 style=\"text-align:right; width:40px;\">";
echo number_format($rowg[quant],2,",",".");
echo "</div>";
echo "<div class=box_90 style=\"text-align:right; width:70px;\">";
echo number_format($rowg[totale],2,",",".");
$TOTALE_rda = $TOTALE_rda + $rowg[totale];
echo "</div>";
echo "<div class=box_40 style=\"text-align:center;\">";
echo $rowg[output_mode];
echo "</div>";
echo "</div>";	
}

echo "<div class=riga_divisoria style=margin-bottom:10px;><img src=immagini/spacer.gif width=622 height=10><img src=immagini/riga_prev_GREY.jpg width=622 height=1>";
echo "</div>";
$gruppo_merci_uff = "";


echo "<div class=contenitore_gruppo_merci style=\"margin-left:100px;width:622px;\">";
echo "<div class=box_60>";
echo "Totale";
echo "</div>";	
	
echo "<div class=box_350>";
echo "</div>";
echo "<div class=box_60 style=\"text-align:right; width:40px;\">";
echo "</div>";
echo "<div class=box_90 style=\"text-align:right; width:70px;\">";
echo number_format($TOTALE_rda,2,",",".");
echo "</div>";
//fine singolo contenitore
echo "</div>";	
$n_fatt_sap = "";
$TOTALE_rda = "";
?>
<div class="riga_divisoria" style="margin-bottom:40px; float:none;">
  <img src="immagini/riga_prev_GREY.jpg" width="622" height="1" />
  </div>


<div class="riga_divisoria" style="margin-bottom:10px; float:none;">
  <img src="immagini/riga_prev_GREY.jpg" width="622" height="1" /></div>
  </div>
  
  
<div class="riga_finale">
<div class="box_90" style="width:240px; font-family: Arial, Helvetica, sans-serif; font-size: 9px;">SOL SPA<br>Via Borgazzi, 27<br />20090 Monza - Italy<br />t +39 039 23 96 1<br />f +39 039 23 96 265<br />e SOL@pec.SOL.it<br />
  www.solworld.com
</div>
<div class="box_90"  style="width:240px; font-family: Arial, Helvetica, sans-serif; font-size: 9px;">
Sede Legale Monza<br />N. Registro Imprese Monza e Brianza<br />e C.F. 04127270157<br />Capitale Sociale Euro 47.164.000,00 i. v.<br />P.IVA 00771260965<br /> R.E.A. 991655 Monza e Brianza
</div>
<div class="box_90" style="width:140px; text-align:right; margin-top:50px;">
<img src="immagini/solgroup_RGB.png"/>
</div>
</div>

</div>
</body>
</html>
