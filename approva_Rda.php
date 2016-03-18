<?php
session_start();
$avviso = $_GET[avviso];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
$wbs = $_GET[wbs];
$id_riga_carrello = $_GET[id_riga_carrello];
$id_carrello = $_GET[id_carrello];
$id_riga_rda = $_GET[id_riga_rda];
$id_rda = $_GET[id_rda];
$ok_resp = $_GET[ok_resp];
$nome_sessione = addslashes($_SESSION[nome]);
$data_attuale = mktime();
//echo "lingua: ".$lingua."<br>";
//echo "negozio: ".$negozio_preferito."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";

include "query.php";
include "traduzioni_interfaccia.php";
$query = "UPDATE qui_rda SET stato = '2', data_approvazione = '$data_attuale', data_ultima_modifica = '$data_attuale', nome_resp = '$nome_sessione' WHERE id = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$query = "UPDATE qui_righe_rda SET stato_ordine = '2', data_ultima_modifica = '$data_attuale' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//inserimento nel LOG
$riepilogo = "Approvazione rda (".$id_rda.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'ok_resp'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = $rigaeee[testo_it];
break;
case "en":
$dicitura = $rigaeee[testo_en];
break;
case "fr":
$dicitura = $rigaeee[testo_fr];
break;
case "de":
$dicitura = $rigaeee[testo_de];
break;
case "es":
$dicitura = $rigaeee[testo_es];
break;
}
}
$q = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$risultq = mysql_query($q) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
  $negozio_rda = $rigaq['negozio'];
  $negozioXMail = $rigaq['negozio'];
  $utente_iniziale_rda = $rigaq['id_utente'];
  $nota = "Note<br>".$rigaq['nome_utente'].": ".$rigaq['note_utente'];
  if ($rigaq['note_resp'] != "") {
	$nota .= "<br>".$rigaq['nome_resp'].": ".$rigaq['note_resp'];
  }
}
$array_mail_buyer = array();
$m = "SELECT * FROM qui_buyer_funzioni WHERE negozio = '$negozio_rda' AND riceve_email_rda = '1'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$n_mail_buyer = mysql_num_rows($risultm);
if ($n_mail_buyer > 0) {
while ($rigam = mysql_fetch_array($risultm)) {
$add_mail_buyer = array_push($array_mail_buyer,$rigam[mail]);
}
} else {
//$array_mail_buyer = array("diego.sala@publiem.it");
$array_mail_buyer = array("diego.sala@publiem.it");
}
//************************************
//costruzione testatina tabella dettagli rda x email
$tx_html .= "<table width=640 border=0 align=center cellpadding=1 cellspacing=0>";
$tx_html .= "<tr valign=top bgcolor=#eaeaea>";
$tx_html .= "<td width=60 valign=top class=table_mail_test_codice>".$testata_codice."</td>";
$tx_html .= "<td width=370 valign=top class=table_mail_test_product>".$testata_prodotto."</td>";
$tx_html .= "<td width=60 valign=top class=table_mail_test_numeri>".$testata_quant."</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri>".$testata_prezzo."</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri_dx>".$testata_totale."</td>";
$tx_html .= "</tr>";
//************************************
//costruzione righe tabellina dettagli rda x invio email
$queryc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' ORDER BY id ASC";
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$tx_html .= "<tr valign=top>";
$tx_html .= "<td class=table_mail_codice>";
if (substr($rowc[codice_art],0,1) != "*") {
  $tx_html .= $rowc[codice_art];
} else {
  $tx_html .= substr($rowc[codice_art],1);
}
$tx_html .= "</td>";
$tx_html .= "<td class=table_mail_product>".stripslashes($rowc[descrizione]);
if ($rowc[ric_mag] != "mag") {
$tx_html .= " - ".strtoupper($ric_mag);
}
$tx_html .= "</td>";
$tx_html .= "<td class=table_mail_numeri>".$rowc[quant]."</td>";
$tx_html .= "<td class=table_mail_numeri>".number_format($rowc[prezzo],2,",",".")."</td>";
$tx_html .= "<td class=table_mail_numeri_dx>".number_format($rowc[totale],2,",",".")."</td>";
$tx_html .= "</tr>";
$totale_rda_buyer = $totale_rda_buyer + $rowc[totale];
  if ($rowc[ric_mag] != "mag") {
  $ord_stamp = $ord_stamp + 1;
  }
}
//**********************************
//costruzione riga totale tabellina dettagli rda x invio email
$tx_html .= "<tr bgcolor=#e6f5fc>";
$tx_html .= "<td></td>";
$tx_html .= "<td></td>";
$tx_html .= "<td></td>";
$tx_html .= "<td class=table_mail_test_numeri>".$testata_totale." RdA</td>";
$tx_html .= "<td class=table_mail_test_numeri_dx>".number_format($totale_rda_buyer,2,",",".")."</td>";
$tx_html .= "</tr>";
//**********************************
//costruzione righe tabellina dettagli rda x invio email
//chiusura tabellina dettaglio rda
$tx_html .= "</table>";
$tx_html .= "</br>".$nota;
//costruzione righe tabellina dettagli rda x invio email


$k = "SELECT * FROM qui_utenti WHERE user_id = '$utente_iniziale_rda'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$mail_inviante = $rigak['posta'];
$indirizzo_utente = $rigak['indirizzo'];
$cap_utente = $rigak['cap'];
$localita_utente = $rigak['localita'];
$nazione_utente = $rigak['nazione'];
$nomeunita_utente = $rigak['nomeunita'];
}
$unita_rda .= $nomeunita_utente."<br>";
$unita_rda .= $indirizzo_utente."<br>";
$unita_rda .= $cap_utente." ".$localita_utente." ".$nazione_utente."<br>";

//RIPRISTINARE
if ($ord_stamp > 0) {
//echo "articoli da stampare presenti<br>";
//********************************************
//se uno degli articoli ha il valore pub nel campo ric/mag, manda una mail a Mara solo con la riga in questione
//********************************************

//************************************
//costruzione testatina tabella dettagli rda x email  a Mara
$tx_mara .= "<table width=640 border=0 align=center cellpadding=1 cellspacing=0>";
$tx_mara .= "<tr valign=top bgcolor=#eaeaea>";
$tx_mara .= "<td width=60 valign=top class=table_mail_test_codice>".$testata_codice."</td>";
$tx_mara .= "<td width=370 valign=top class=table_mail_test_product>".$testata_prodotto."</td>";
$tx_mara .= "<td width=60 valign=top class=table_mail_test_numeri>".$testata_quant."</td>";
$tx_mara .= "<td width=70 valign=top class=table_mail_test_numeri>".$testata_prezzo."</td>";
$tx_mara .= "<td width=70 valign=top class=table_mail_test_numeri_dx>".$testata_totale."</td>";
$tx_mara .= "</tr>";
//************************************
//costruzione righe tabellina dettagli rda x invio email a Mara
$queryc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND ordine_stampa = '1' ORDER BY id ASC";
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$tx_mara .= "<tr valign=top>";
$tx_mara .= "<td class=table_mail_codice>".$rowc[codice_art]."</td>";
$tx_mara .= "<td class=table_mail_product>".stripslashes($rowc[descrizione])." (";
$queryz = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art = '$rowc[codice_art]'";
$resultz = mysql_query($queryz);
while ($rowz = mysql_fetch_array($resultz)) {
$tx_mara .= $rowz[categoria4_it];
}
$tx_mara .= ")</td>";
$tx_mara .= "<td class=table_mail_numeri>".$rowc[quant]."</td>";
$tx_mara .= "<td class=table_mail_numeri>".number_format($rowc[prezzo],2,",",".")."</td>";
$tx_mara .= "<td class=table_mail_numeri_dx>".number_format($rowc[totale],2,",",".")."</td>";
$tx_mara .= "</tr>";
$totale_rda_mara = $totale_rda_mara + $rowc[totale];
}
//**********************************
//costruzione riga totale tabellina dettagli rda x invio email a Mara
$tx_mara .= "<tr bgcolor=#e6f5fc>";
$tx_mara .= "<td></td>";
$tx_mara .= "<td></td>";
$tx_mara .= "<td></td>";
$tx_mara .= "<td class=table_mail_test_numeri>".$testata_totale." RdA</td>";
$tx_mara .= "<td class=table_mail_test_numeri_dx>".number_format($totale_rda_mara,2,",",".")."</td>";
$tx_mara .= "</tr>";
//**********************************
//costruzione righe tabellina dettagli rda x invio email
//chiusura tabellina dettaglio rda
$tx_mara .= "</table>";
//costruzione righe tabellina dettagli rda x invio email


//termine duplicazione righe rda
}

include "spedizione_mail_resp.php";

$timeout = 3000;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
		<!--[if IE ]> <script type="text/javascript" src="ie-set_timeout.js"></script> <![endif]-->
<script type="text/javascript">
function remote2(url){
window.opener.location=url
}
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
      setTimeout(function(){window.parent.TINY.box.hide()}, 1500);

}
function chiudi() {
    setTimeout(function(){window.parent.TINY.box.hide()}, 1500);
}
</script>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Stile1 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
.Stile2 {
	color: #000000;
	text-align: center;
}
.Stile4 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
.Stile5 {
	font-family: Arial;
	color: red;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
-->
</style></head>

<body>
<!--<body onLoad="chiudi()" onUnload="refreshParent()">-->
<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width="340" valign="middle" class="Stile1"><img src=immagini/spacer.gif width=340 height=40><br>
    
    <?php echo $dicitura; ?></td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>

</body>
</html>
