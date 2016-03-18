<?php
session_start();
//echo "fin qui ok<br>";
$company_scelta = $_GET[company_scelta];
$avviso = $_GET[avviso];
$negozio_preferito = $_GET[negozio];
$negozio_prod = $_GET[negozio_prod];
$negozio_carrello = $_GET[negozio_carrello];
$canc_anche_rda = $_GET[canc_anche_rda];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
$wbs = $_GET[wbs];
$id_riga_carrello = $_GET[id_riga_carrello];
$id_carrello = $_GET[id_carrello];
$id_riga_rda = $_GET[id_riga_rda];
$id_rda = $_GET[id_rda];
$ok_resp = $_GET[ok_resp];
$addr_spedizione = $_GET[addr_spedizione];
$array_flussi = array("bmc","htc");
//echo "lingua: ".$lingua."<br>";
//echo "negozio: ".$negozio_carrello."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "file giusto<br>";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
//recupero nome company
//inserimento nuova rda


//recupero info indirizzo spedizione bmc
	  $sqlp = "SELECT * FROM qui_tBMC_Clienti WHERE id = '$addr_spedizione'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		//indirizzo_diverso = addslashes($rigap[DescrInd]);
		$indirizzo_diverso .= addslashes($rigap[NAME1]).'<br>'.addslashes($rigap[STRAS]).'<br>'.addslashes($rigap[PSTLZ]).' '.addslashes($rigap[ORT01]).' ('.addslashes($rigap[LAND1]).')<br>'.addslashes($rigap[KUNNR]);
	  }

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//ATTENZIONE
//SE SI MODIFICA QUESTA ROUTINE CONTROLLARE ANCHE QUELLA SIMILE IL "popup notifica rda processata.php"
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
if ($negozio_carrello == "assets") {
if ($wbs == "") {
$mex = $avvert_wbs_vuoto;
$criterio_blocco = 1;
} else {
$lung_wbs = strlen($wbs);
if (($lung_wbs < 8) OR ($lung_wbs > 10)) {
$mex = "E' richiesto un NUMERO con min 8 max 10 cifre";
$criterio_blocco = 1;
}
}
if ($criterio_blocco == 1) {
echo "<table width=360 border=0 align=center cellpadding=0 cellspacing=0>";
  echo "<tr>";
    echo "<td colspan=3>";
	echo "<img src=immagini/spacer.gif width=360 height=10></td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td width=10><img src=immagini/spacer.gif width=10 height=100></td>";
    echo "<td width=340 valign=middle><img src=immagini/spacer.gif width=340 height=40><br>";
echo "<form name=form1 method=get action=popup_modal_gen_rda.php>";
    echo "<br><span class=Stile5>".$mex."</span><br><br>";
echo "<input type=submit name=button id=button value=".$back.">";
echo "<input name=negozio_carrello type=hidden id=negozio_carrello value=".$negozio_carrello.">";
echo "<input name=avviso type=hidden id=avviso value=".$avviso.">";
echo "<input name=id_carrello type=hidden id=id_carrello value=".$id_carrello.">";
echo "<input name=lang type=hidden id=lang value=".$lingua.">";
echo "</form>";
    
   echo "</td>";
    echo "<td width=10><img src=immagini/spacer.gif width=10 height=100></td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td colspan=3><img src=immagini/spacer.gif width=360 height=10></td>";
  echo "</tr>";
echo "</table>";
exit;
}
}

$data_ordine = mktime();
$data_ordine_leggibile = date("d.m.Y H:i",$data_ordine);
$query = "UPDATE qui_carrelli SET attivo = '0', ordine = '1', data_ultima_modifica = '$data_ordine' WHERE id = '$id_carrello'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

$g = "SELECT * FROM qui_carrelli WHERE id = '$id_carrello'";
$risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$negozio_rda = $rigag['negozio'];
$id_utente = $rigag['id_utente'];
$id_resp = $rigag['id_resp'];
$data_ultima_modifica = $rigag['data_ultima_modifica'];
$note = addslashes($rigag['note']);
}
$data_rda = mktime();
switch ($_SESSION[ruolo]) {
case "utente":
$stato_rda = 1;
break;
case "responsabile":
$stato_rda = 2;
break;
case "buyer":
$stato_rda = 2;
break;
}
$f = "SELECT * FROM qui_company WHERE IDCompany = '$company_scelta'";
$risultf = mysql_query($f) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$nome_company = $rigaf['Company'];
}
$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$nazione_rda = $rigak['nazione'];
$nome_sessione = addslashes($rigak[nome]);
$unita_scelta = $rigak[idunita];
$company_originale = $rigak[IDCompany];
}
if ($company_originale != $company_scelta) {
	$note = 'Per conto di '.$nome_company.'<br>'.$note;
}
$s = "SELECT * FROM qui_unita WHERE id_unita = '$unita_scelta'";
$risults = mysql_query($s) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
$nome_unita = $rigas[nome_unita];
}
//echo "stato_rda: ".$stato_rda."<br>";
//legenda stati = 1 = da presentare - 2 = approvata resp - 4 = approvata buyer
mysql_query("INSERT INTO qui_rda (negozio, id_unita, nome_unita, id_utente, id_resp, stato, data_inserimento, data_approvazione, data_ultima_modifica, id_carrello, data_carrello, note_utente, nome_utente, wbs, nazione, id_company, nome_company, indirizzo_spedizione) VALUES ('$negozio_rda', '$unita_scelta', '$nome_unita', '$id_utente', '$_SESSION[IDResp]', '$stato_rda', '$data_rda', '$data_rda', '$data_rda', '$id_carrello', '$data_ultima_modifica', '$note', '$nome_sessione', '$wbs', '$nazione_rda', '$company_scelta', '$nome_company', '$indirizzo_diverso')") or die("Impossibile eseguire l'inserimento 1" . mysql_error());
$id_rda = mysql_insert_id();

$query = "UPDATE qui_carrelli SET rda = '$id_rda', data_rda = '$data_rda' WHERE id = '$id_carrello'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//termine duplicazione rda

//costruzione testatina tabella dettagli rda x email
$tx_html .= "<table width=640 border=0 align=center cellpadding=1 cellspacing=0>";
$tx_html .= "<tr valign=top bgcolor=#eaeaea>";
$tx_html .= "<td width=60 valign=top class=table_mail_test_codice>".$testata_codice."</td>";
$tx_html .= "<td width=370 valign=top class=table_mail_test_product>".$testata_prodotto."</td>";
$tx_html .= "<td width=60 valign=top class=table_mail_test_numeri>".$testata_quant."</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri>".$testata_prezzo."</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri_dx>".$testata_totale."</td>";
$tx_html .= "</tr>";

//inizio duplicazione righe rda
$f = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' AND cancellato = '0'";
$risultf = mysql_query($f) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
	//se una quantità è accidentalmente a zero, la riga non viene trasformata da carrello a RdA
	if ($rigaf['quant'] > 0) {
$negozio_rda = $rigaf['negozio'];
$id_utente = $rigaf['id_utente'];
$id_resp = $rigaf['id_resp'];
$quant = $rigaf['quant'];
$id_prodotto = $rigaf['id_prodotto'];
$id_riga = $rigaf['id'];
$azienda_prodotto = $rigaf['azienda_prodotto'];
$azienda_utente = $company_scelta;
if (($rigaf[azienda_prodotto] == "SOL") && ($company_scelta == "1")) {
  if ($nazione_rda == "Italy") {
	  $dest_contab = "GSOLSPA";
  } else {
	  $dest_contab = "FSOLSPA";
  }
}
if (($rigaf[azienda_prodotto] == "SOL") && ($company_scelta != "1")) {
	$dest_contab = "FSOLSPA";
}
if (($rigaf[azienda_prodotto] == "VIVISOL") && ($company_scelta == "2")) {
	$dest_contab = "GVIVISOL";
}
if (($rigaf[azienda_prodotto] == "VIVISOL") && ($company_scelta != "2")) {
	$dest_contab = "FVIVISOL";
}
//vado a prendere i dati freschi dal listino prodotti
//dipende dal tipo di prodotto
switch ($negozio_rda) {
case "assets":
$sqld = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$sqld = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$sqld = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
case "labels":
$sqld = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prodotto'";
break;
case "vivistore":
$sqld = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto'";
break;
}

$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
switch($lingua) {
case "it":
$descrizione_art = addslashes($rigad[descrizione1_it]);
$categoria_art = $rigad[categoria1_it];
$cespite = "cespite";
break;
case "en":
$descrizione_art = addslashes($rigad[descrizione1_en]);
$categoria_art = $rigad[categoria1_en];
$cespite = "asset";
break;
case "fr":
$descrizione_art = addslashes($rigad[descrizione1_fr]);
$categoria_art = $rigad[categoria1_fr];
$cespite = "asset";
break;
case "de":
$descrizione_art = addslashes($rigad[descrizione1_de]);
$categoria_art = $rigad[categoria1_de];
$cespite = "asset";
break;
case "es":
$descrizione_art = addslashes($rigad[descrizione1_es]);
$categoria_art = $rigad[categoria1_es];
$cespite = "asset";
break;
}
if ($rigaf[negozio] == "labels") {
$descrizione_art .= " - ".$rigad[categoria4_it];
}
if (($rigaf[negozio] == "assets") AND ($rigaf[categoria] == "Bombole")) {
$descrizione_art .= str_replace("_"," ",$rigaf[descrizione]);
}
  if (($rigaf[negozio] == "vivistore") AND (in_array($rigaf[flusso],$array_flussi))) {
	$descrizione_art .= "<br><strong>";
	$descrizione_art .= $rigad[categoria4_it];
	$descrizione_art .= '</strong>';
  }
$ric_mag = $rigad[ric_mag];
$gruppo_merci = $rigad[gruppo_merci];
$stampare = $rigad[ric_mag];
if ($rigad[ric_mag] != "mag") {
$ord_stamp = $ord_stamp + 1;
}
//if (($rigad[negozio] == "labels") OR ($rigaf[categoria] == "Bombole")) {
if (($rigad[ric_mag] == "RIC") OR ($rigaf[categoria] == "Bombole")) {
  $confezione_art = $rigaf[confezione];
  $codice_art = $rigaf[codice_art];
  $prezzo_art = $rigaf[prezzo];
  //echo "ord stamp: ".$ord_stamp."<br>";
  $totale_art = $rigaf[totale];
  $totale_carrello = $totale_carrello + $totale_art;
} else {
  //echo "ord stamp: ".$ord_stamp."<br>";
  $confezione_art = $rigad[confezione];
  $codice_art = $rigad[codice_art];
  $prezzo_art = $rigad[prezzo];
  $totale_art = $prezzo_art*$quant;
  $totale_carrello = $totale_carrello + $totale_art;
}
}
  $flusso = $rigaf[flusso];
  $costi_aggiuntivi = $rigaf[costi_aggiuntivi];
  $totale_art  = $totale_art + $costi_aggiuntivi;
  $urgente = $rigaf[urgente];
  $lingua_impostata = $rigaf[lingua_impostata];
  if ((in_array($rigaf[flusso],$array_flussi)) && ($lingua_impostata != "")) {
	$n = "SELECT * FROM qui_bmc_lingue WHERE cod = '$lingua_impostata'";
	$risultn = mysql_query($n) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigan = mysql_fetch_array($risultn)) {
		$lingua_impostata_descr = $rigan['descrizione'];
	}
  }
	if ($lingua_impostata_descr != "") {
	  $descrizione_art .= "<strong>";
	  $descrizione_art .= " - ".$lingua_impostata_descr;
	  $descrizione_art .= '</strong>';
	}
	if ($rigaf[flusso] == "htc") {
	  $descrizione_art .= "<strong>";
	  $descrizione_art .= " - ".$cespite;
	  $descrizione_art .= '</strong>';
	}
	$cavo = $rigaf[cavo];
/*echo '<span style="color: #000;">lingua_impostata: '.$lingua_impostata.'<br>
lingua_impostata_descr: '.$lingua_impostata_descr.'<br>
descrizione_art: '.$descrizione_art.'</span><br>';*/
//echo "fin qui ok<br>";
//se si tratta di etichette pharma, o di una bombola (assets), il prezzo giusto è quello inserito nel carrello
//non posso andare a prenderlo dalla tabella
//per cui faccio uno switch a questo livello
//inserimento riga rda
switch ($_SESSION[ruolo]) {
  case "utente":
  $queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, wbs, ordine_stampa, gruppo_merci, nazione, azienda_prodotto, azienda_utente, dest_contab, lingua_impostata, flusso, costi_aggiuntivi, urgente) VALUES ('$id_carrello', '$negozio_rda', '$unita_scelta', '$nome_unita', '$categoria_art', '$id_utente', '$_SESSION[IDResp]', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda', '$id_rda', '1', '$wbs', '$stampare', '$gruppo_merci', '$nazione_rda', '$azienda_prodotto', '$azienda_utente', '$dest_contab', '$lingua_impostata', '$flusso', '$costi_aggiuntivi', '$urgente')";
  break;
  case "responsabile":
  $queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, wbs, ordine_stampa, gruppo_merci, nazione, azienda_prodotto, azienda_utente, dest_contab, lingua_impostata, flusso, costi_aggiuntivi, urgente) VALUES ('$id_carrello', '$negozio_rda', '$unita_scelta', '$nome_unita', '$categoria_art', '$id_utente', '$_SESSION[IDResp]', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda', '$id_rda', '2', '$wbs', '$stampare', '$gruppo_merci', '$nazione_rda', '$azienda_prodotto', '$azienda_utente', '$dest_contab', '$lingua_impostata', '$flusso', '$costi_aggiuntivi', '$urgente')";
  break;
  case "buyer":
  $queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, wbs, ordine_stampa, gruppo_merci, nazione, azienda_prodotto, azienda_utente, dest_contab, lingua_impostata, flusso, costi_aggiuntivi, urgente) VALUES ('$id_carrello', '$negozio_rda', '$unita_scelta', '$nome_unita', '$categoria_art', '$id_utente', '$_SESSION[IDResp]', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda', '$id_rda', '2', '$wbs', '$stampare', '$gruppo_merci', '$nazione_rda', '$azienda_prodotto', '$azienda_utente', '$dest_contab', '$lingua_impostata', '$flusso', '$costi_aggiuntivi', '$urgente')";
  break;
}
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento2". mysql_error();
}
//costruzione righe tabellina dettagli rda x invio email
$tx_html .= "<tr valign=top>";
$tx_html .= "<td class=table_mail_codice>";
if (substr($codice_art,0,1) != "*") {
  $tx_html .= $codice_art;
} else {
  $tx_html .= substr($codice_art,1);
}
$tx_html .= "</td>";
$tx_html .= "<td class=table_mail_product>".stripslashes($descrizione_art);
//if ($ric_mag != "mag") {
//$tx_html .= strtoupper($ric_mag);
//}
$tx_html .= "</td>";
$tx_html .= "<td class=table_mail_numeri>".$quant."</td>";
$tx_html .= "<td class=table_mail_numeri>".number_format($prezzo_art,2,",",".")."</td>";
$tx_html .= "<td class=table_mail_numeri_dx>".number_format($totale_art,2,",",".")."</td>";
$tx_html .= "</tr>";
                                            
$query = "UPDATE qui_righe_carrelli SET id_rda = '$id_rda', data_rda = '$data_rda' WHERE id = '$id_riga'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

//inserimento nel LOG
$riepilogo = "Inserimento nuova rda (".$id_rda.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento3". mysql_error();
}
//fine if quant = 0
}
//fine while select righe carrelli
}
//aggiornamento totale rda
$querys = "UPDATE qui_rda SET totale_rda = '$totale_carrello' WHERE id = '$id_rda'"; 
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

//costruzione riga totale tabellina dettagli rda x invio email
$tx_html .= "<tr bgcolor=#e6f5fc>";
$tx_html .= "<td></td>";
$tx_html .= "<td></td>";
$tx_html .= "<td></td>";
$tx_html .= "<td class=table_mail_test_numeri>".$testata_totale." RdA</td>";
$tx_html .= "<td class=table_mail_test_numeri_dx>".number_format($totale_carrello,2,",",".")."</td>";
$tx_html .= "</tr>";
//costruzione righe tabellina dettagli rda x invio email
//chiusura tabellina dettaglio rda
$tx_html .= "</table>";
//costruzione righe tabellina dettagli rda x invio email


//termine duplicazione righe rda
$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$mail_inviante = $rigak['posta'];
$indirizzo_utente = $rigak['indirizzo'];
$cap_utente = $rigak['cap'];
$localita_utente = $rigak['localita'];
$nazione_utente = $rigak['nazione'];
$nomeunita_utente = $rigak['nomeunita'];
$idunita = $rigak['idunita'];
}
$array_mail = array();
$m = "SELECT * FROM qui_unita WHERE id_unita = '$unita_scelta'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$add_mail = array_push($array_mail,$rigam[posta]);
$mail_destinatario = $rigam['posta'];
}
$unita_rda .= $nomeunita_utente."<br>";
$unita_rda .= $indirizzo_utente."<br>";
$unita_rda .= $cap_utente." ".$localita_utente." ".$nazione_utente."<br>";
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'rda_ins'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {

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
//RIPRISTINARE
switch ($_SESSION[ruolo]) {
case "utente":
include "spedizione_mail.php";
break;
case "responsabile":
$array_mail_buyer = array();
$m = "SELECT * FROM qui_buyer_funzioni WHERE negozio = '$negozio_rda' AND riceve_email_rda = '1'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$n_mail_buyer = mysql_num_rows($risultm);
if ($n_mail_buyer > 0) {
while ($rigam = mysql_fetch_array($risultm)) {
$add_mail_buyer = array_push($array_mail_buyer,$rigam[mail]);
}
//termine duplicazione righe rda
}
include "spedizione_mail_resp.php";
break;
case "buyer":
$array_mail_buyer = array("diego.sala@publiem.it");
//include "spedizione_mail_resp.php";
break;
}
/*
*/
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
}
function chiudi() {
    setTimeout(function(){window.parent.TINY.box.hide()}, 2000);
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

<body onLoad="chiudi()" onUnload="refreshParent()">
<!--<body>-->
<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width="340" valign="middle"><img src=immagini/spacer.gif width=340 height=40><br>
    
    <?php echo '<span class="Stile1">'.$dicitura.'</span>'; ?></td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>

</body>
</html>
