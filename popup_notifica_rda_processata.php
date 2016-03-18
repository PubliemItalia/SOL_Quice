<?php
session_start();
$avviso = $_GET[avviso];
$ok_resp2 = 1;
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
$id_rda = $_GET[id_rda];
include "query.php";
include "traduzioni_interfaccia.php";
//legenda stati = 1 = da presentare - 2 = approvata resp - 4 = approvata buyer
$g = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$negozio = $rigag['negozio'];
$id_resp = $rigag['id_resp'];
$data_ultima_modifica = $rigag['data_inserimento'];
$note = $rigag['note'];
}
//cerco l'id del responsabile che invia l'RdA
$m = "SELECT * FROM qui_utenti WHERE user_id = '$id_resp'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$nome_resp = $rigam['nome'];
$mail_inviante = $rigam['posta'];
}
//cerco il buyer di riferimento del negozio
//introdotto campo precedenza_buyer per selezionare il buyer di default
//$h = "SELECT * FROM qui_utenti WHERE negozio_buyer = '$negozio' AND ruolo = 'buyer' AND precedenza_buyer = '1'";
$h = "SELECT * FROM qui_utenti WHERE negozio_buyer = '$negozio' AND ruolo = 'buyer' ORDER BY nome ASC LIMIT 1";
$risulth = mysql_query($h) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
$id_buyer = $rigah['user_id'];
$nome_buyer = stripslashes($rigah['nome']);
$mail_destinatario = $rigah['posta'];
}
//costruzione testatina tabella dettagli rda x email
$tx_html .= "<table width=640 border=0 align=center cellpadding=1 cellspacing=0>";
$tx_html .= "<tr valign=top bgcolor=#eaeaea>";
$tx_html .= "<td width=60 valign=top class=table_mail_test_codice>".$testata_codice."</td>";
$tx_html .= "<td width=370 valign=top class=table_mail_test_product>".$testata_prodotto."</td>";
$tx_html .= "<td width=60 valign=top class=table_mail_test_numeri>".$testata_quant."</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri>".$testata_prezzo."</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri_dx>".$testata_totale."</td>";
$tx_html .= "</tr>";

$f = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$risultf = mysql_query($f) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$negozio = $rigaf['negozio'];
$id_utente = $rigaf['id_utente'];
$id_resp = $rigaf['id_resp'];
$quant = $rigaf['quant'];
$id_prodotto = $rigaf['id_prodotto'];
$id_riga = $rigaf['id'];
//vado a prendere i dati freschi dal listino prodotti
switch ($negozio) {
case "assets":
$sqld = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$sqld = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$sqld = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
}

$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
switch($lingua) {
case "it":
$descrizione_art = addslashes($rigad[descrizione1_it]);
$categoria_art = $rigad[categoria1_it];
break;
case "en":
$descrizione_art = addslashes($rigad[descrizione1_en]);
$categoria_art = $rigad[categoria1_en];
break;
case "fr":
$descrizione_art = addslashes($rigad[descrizione1_fr]);
$categoria_art = $rigad[categoria1_fr];
break;
case "de":
$descrizione_art = addslashes($rigad[descrizione1_de]);
$categoria_art = $rigad[categoria1_de];
break;
case "es":
$descrizione_art = addslashes($rigad[descrizione1_es]);
$categoria_art = $rigad[categoria1_es];
break;
}
$codice_art = $rigad[codice_art];
$prezzo_art = $rigad[prezzo];
$confezione_art = $rigad[confezione];
}
$totale_art = $prezzo_art*$quant;
$totale_carrello = $totale_carrello + $totale_art;
//************************************
//costruzione righe tabellina dettagli rda x invio email
$tx_html .= "<tr valign=top>";
$tx_html .= "<td class=table_mail_codice>".$codice_art."</td>";
$tx_html .= "<td class=table_mail_product>".stripslashes($descrizione_art)."</td>";
$tx_html .= "<td class=table_mail_numeri>".$quant."</td>";
$tx_html .= "<td class=table_mail_numeri>".number_format($prezzo_art,2,",",".")."</td>";
$tx_html .= "<td class=table_mail_numeri_dx>".number_format($totale_art,2,",",".")."</td>";
$tx_html .= "</tr>";
//**********************************
                                            
//inserimento nel LOG
$riepilogo = "Approvazione RdA (".$id_rda.") da parte di ".addslashes($nome_resp);
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento3". mysql_error();
}
//fine while select righe carrelli
}

//************************************
//costruzione riga totale tabellina dettagli rda x invio email
$tx_html .= "<tr bgcolor=#e6f5fc>";
$tx_html .= "<td></td>";
$tx_html .= "<td></td>";
$tx_html .= "<td></td>";
$tx_html .= "<td class=table_mail_test_numeri>".$testata_totale." RdA</td>";
$tx_html .= "<td class=table_mail_test_numeri_dx>".number_format($totale_carrello,2,",",".")."</td>";
$tx_html .= "</tr>";
//**********************************
//costruzione righe tabellina dettagli rda x invio email
//chiusura tabellina dettaglio rda
$tx_html .= "</table>";
//costruzione righe tabellina dettagli rda x invio email


$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$mail_utente = $rigak['posta'];
$indirizzo_utente = $rigak['indirizzo'];
$cap_utente = $rigak['cap'];
$localita_utente = $rigak['localita'];
$nazione_utente = $rigak['nazione'];
$nomeunita_utente = $rigak['nomeunita'];
}
$unita_rda .= $nomeunita_utente."<br>";
$unita_rda .= $indirizzo_utente."<br>";
$unita_rda .= $cap_utente." ".$localita_utente." ".$nazione_utente."<br>";

/*echo "ok_resp2: ".$ok_resp2."<br>";
echo "mail_destinatario: ".$mail_destinatario."<br>";
echo "mail_inviante: ".$mail_inviante."<br>";
*/
//RIPRISTINARE
//include "spedizione_mail.php";





switch($avviso) {
case "ok_resp2":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'ok_resp'";
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
break;
}
/*
echo "lingua ".$lingua."<br>";
echo "avviso ".$avviso."<br>";
echo "query azione: ".$queryg."<br>";
echo "query dicitura: ".$sqleee."<br>";
echo "num_righe: ".$num_righe."<br>";
echo "dicitura: ".$dicitura."<br>";
*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<script> 
setTimeout("window.close();", 1500); 
</script>
<link href="tabelle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" height="70"><tr><td width="100%" align="center"  valign="middle" class="verde_grassettocx"><?php echo $dicitura; ?></td>
</tr></table>


</body>
</html>
