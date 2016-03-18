<?php
session_start();
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
$nome_sessione = addslashes($_SESSION[nome]);
//echo "lingua: ".$lingua."<br>";
//echo "negozio: ".$negozio_preferito."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";

include "query.php";
include "traduzioni_interfaccia.php";
//inserimento nuova rda

//********************************************
//********************************************
//ATTENZIONE
//SE SI MODIFICA QUESTA ROUTINE CONTROLLARE ANCHE QUELLA SIMILE IL "popup notifica rda processata.php"
//********************************************
//********************************************

if ($avviso == "genera_rda") {
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

//if (($negozio_carrello == "assets") AND ($criterio_blocco != "")) {
/*if ($negozio_carrello == "assets") {
echo "<table width=360 border=0 align=center cellpadding=0 cellspacing=0>";
  echo "<tr>";
    echo "<td colspan=3><img src=immagini/spacer.gif width=360 height=10></td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td width=10><img src=immagini/spacer.gif width=10 height=100></td>";
    echo "<td width=340 valign=middle class=Stile1><div align=center><img src=immagini/spacer.gif width=340 height=40><br>".$mex."<br><br>";
echo "<form name=form1 method=get action=popup_modal_gen_rda.php>";
echo "<input type=submit name=button id=button value=".$back.">";
echo "<input name=negozio_carrello type=hidden id=negozio_carrello value=".$negozio_carrello.">";
echo "<input name=avviso type=hidden id=avviso value=".$avviso.">";
echo "<input name=id_carrello type=hidden id=id_carrello value=".$id_carrello.">";
echo "<input name=lang type=hidden id=lang value=".$lingua.">";
echo "</form>";
	echo "</div></td>";
   echo "<td width=10><img src=immagini/spacer.gif width=10 height=100></td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td colspan=3><img src=immagini/spacer.gif width=360 height=10></td>";
  echo "</tr>";
echo "</table>";
exit;
} else {
*/
$data_ordine = mktime();
$data_ordine_leggibile = date("d.m.Y H:i",$data_ordine);
$query = "UPDATE qui_carrelli SET attivo = '0', ordine = '1', data_ultima_modifica = '$data_ordine' WHERE id = '$id_carrello'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

$g = "SELECT * FROM qui_carrelli WHERE id = '$id_carrello'";
$risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$negozio = $rigag['negozio'];
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
$stato_rda = 2;break;
case "buyer":
$stato_rda = 2;break;
}
$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$nazione_rda = $rigak['nazione'];
}
//echo "stato_rda: ".$stato_rda."<br>";
//legenda stati = 1 = da presentare - 2 = approvata resp - 4 = approvata buyer
mysql_query("INSERT INTO qui_rda (negozio, id_unita, nome_unita, id_utente, id_resp, stato, data_inserimento, data_ultima_modifica, id_carrello, data_carrello, note_utente, nome_utente, wbs, nazione) VALUES ('$negozio', '$_SESSION[idunita]', '$_SESSION[nomeunita]', '$id_utente', '$id_resp', '$stato_rda', '$data_rda', '$data_rda', '$id_carrello', '$data_ultima_modifica', '$note', '$nome_sessione', '$wbs', '$nazione_rda')") or die("Impossibile eseguire l'inserimento 1" . mysql_error());
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
$risultf = mysql_query($f) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$negozio = $rigaf['negozio'];
$negozioXMail = $rigaf['negozio'];
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
case "vivistore":
$sqld = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto'";
break;
}

$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
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
$gruppo_merci = $rigad[gruppo_merci];
$ord_stamp = $rigad[ordine_stampa];
}
$totale_art = $prezzo_art*$quant;
$totale_carrello = $totale_carrello + $totale_art;
//inserimento riga rda
switch ($_SESSION[ruolo]) {
case "utente":
$queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, wbs, ordine_stampa, gruppo_merci, nazione) VALUES ('$id_carrello', '$negozio', '$_SESSION[idunita]', '$_SESSION[nomeunita]', '$categoria_art', '$id_utente', '$id_resp', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda', '$id_rda', '1', '$wbs', '$ord_stamp', '$gruppo_merci', '$nazione_rda')";
break;
case "responsabile":
$queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, wbs, ordine_stampa, gruppo_merci) VALUES ('$id_carrello', '$negozio', '$_SESSION[idunita]', '$_SESSION[nomeunita]', '$categoria_art', '$id_utente', '$id_resp', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda', '$id_rda', '2', '$wbs', '$ord_stamp', '$gruppo_merci')";
break;
case "buyer":
$queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, wbs, ordine_stampa, gruppo_merci) VALUES ('$id_carrello', '$negozio', '$_SESSION[idunita]', '$_SESSION[nomeunita]', '$categoria_art', '$id_utente', '$id_resp', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda', '$id_rda', '2', '$wbs', '$ord_stamp', '$gruppo_merci')";
break;
}
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento2". mysql_error();
}
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
//fine while select righe carrelli
}
//aggiornamento totale rda
$querys = "UPDATE qui_rda SET totale_rda = '$totale_carrello' WHERE id = '$id_rda'"; 
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
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


//termine duplicazione righe rda
$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$mail_inviante = $rigak['posta'];
$indirizzo_utente = $rigak['indirizzo'];
$cap_utente = $rigak['cap'];
$localita_utente = $rigak['localita'];
$nazione_utente = $rigak['nazione'];
$nomeunita_utente = $rigak['nomeunita'];
}
$array_mail = array();
$m = "SELECT * FROM qui_utenti WHERE user_id = '$id_resp'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$add_mail = array_push($array_mail,$rigam[posta]);
}
/*$m = "SELECT * FROM qui_utenti WHERE user_id = '$id_resp'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione7" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$mail_destinatario = $rigam['posta'];
}
*/
$unita_rda .= $nomeunita_utente."<br>";
$unita_rda .= $indirizzo_utente."<br>";
$unita_rda .= $cap_utente." ".$localita_utente." ".$nazione_utente."<br>";

//RIPRISTINARE
include "spedizione_mail.php";


//fine if negozio_carrello == "assets
//}
//fine if avviso genera rda
}

//svuotamento carrello
if ($avviso == "svuota_carrello") {
$data_attuale = mktime();
$query = "UPDATE qui_carrelli SET cancellato = '1', attivo = '0' WHERE id = '$id_carrello'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//inserimento nel LOG
$riepilogo = "Cancellazione carrello ".$id_carrello;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
$queryj = "UPDATE qui_righe_carrelli SET cancellato = '1' WHERE id_carrello = '$id_carrello'"; 
if (mysql_query($queryj)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}

//avvertimento responsabile inesistente
if ($avviso == "noresp") {
$data_attuale = mktime();
//inserimento nel LOG
$riepilogo = "Login utente ".$id_utente." responsabile mancante";
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'utenti', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}


//inserimento nuovo bookmark utente
if ($avviso == "bookmark") {
switch ($negozio_preferito) {
case "assets":
$sqld = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prod'";
break;
case "consumabili":
$sqld = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod'";
break;
case "spare_parts":
$sqld = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prod'";
break;
case "labels":
$sqld = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prod'";
break;
case "vivistore":
$sqld = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prod'";
break;
}
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
switch($lingua) {
case "it":
$descrizione_art = addslashes($rigad[descrizione1_it]);
break;
case "en":
$descrizione_art = addslashes($rigad[descrizione1_en]);
break;
case "fr":
$descrizione_art = addslashes($rigad[descrizione1_fr]);
break;
case "de":
$descrizione_art = addslashes($rigad[descrizione1_de]);
break;
case "es":
$descrizione_art = addslashes($rigad[descrizione1_es]);
break;
}
}
$data_attuale = mktime();
$queryg = "INSERT INTO qui_preferiti (id_prod, descrizione, negozio, id_utente, attivo, data_inserimento) VALUES ('$id_prod', '$descrizione_art', '$negozio_preferito', '$id_utente', '1', '$data_attuale')";
if (mysql_query($queryg)) {
//inserimento nel LOG
$riepilogo = "Inserimento preferito utente ".$id_prod." prodotto: ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'preferiti', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}
//cancellazione  bookmark utente
if ($avviso == "del_bookmark") {
$data_attuale = mktime();
$queryg = "DELETE FROM qui_preferiti WHERE id_prod = '$id_prod' AND id_utente = '$id_utente'";
if (mysql_query($queryg)) {
//inserimento nel LOG
$riepilogo = "Cancellazione preferito utente ".$id_prod." prodotto: ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'preferiti', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}

//cancellazione riga carrello
if ($avviso == "canc_riga_carr") {
$data_attuale = mktime();
$queryg = "UPDATE qui_righe_carrelli SET cancellato = '1' WHERE id = '$id_riga_carrello'"; 
if (mysql_query($queryg)) {
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' AND cancellato = '0'";
$result = mysql_query($querya);
$elementi_in_carrello = mysql_num_rows($result);
if ($elementi_in_carrello == 0) {
$query = "UPDATE qui_carrelli SET cancellato = '1', attivo = '0' WHERE id = '$id_carrello'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}

//inserimento nel LOG
$riepilogo = "Cancellazione riga carrello ".$id_riga_carrello." carrello: ".$id_carrello;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}

}

//cancellazione riga rda
if ($avviso == "del_riga_rda") {
$data_attuale = mktime();
$queryg = "DELETE FROM qui_righe_rda WHERE id = '$id_riga_rda'";
if (mysql_query($queryg)) {
//inserimento nel LOG
$riepilogo = "Cancellazione riga rda ".$id_riga_rda." rda: ".$id_rda;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
//recupero gli importi delle righe della rda e aggiorno il totale nella tabella rda
$queryd = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$resultd = mysql_query($queryd) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
$num_righe = mysql_num_rows($resultd);
while ($rowd = mysql_fetch_array($resultd)) {
$importo_rda = $importo_rda + $rowd[totale];
}
$tot_rda_aggiornato = $importo_rda + $totale_aggiornato;
//if ($num_righe > 0) {
$querys = "UPDATE qui_rda SET totale_rda = '$tot_rda_aggiornato' WHERE id = '$id_rda'";
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

//se è l'ultima riga presente nella RdA, cancello anche la RdA stessa
if ($num_righe < 1) {
//echo "canc_anche_rda: <br>";
$queryg = "DELETE FROM qui_rda WHERE id = '$id_rda'";
if (mysql_query($queryg)) {
//inserimento nel LOG
$riepilogo = "Cancellazione rda: ".$id_rda." in seguito a cancellazione della ultima riga rda ".$id_riga_rda;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}



//} else {
/*$querys = "UPDATE qui_rda SET totale_rda = '$tot_rda_aggiornato', stato = '4' WHERE id = '$id_rda'";
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
*/
//}

//se è l'ultima riga presente nella RdA, cancello anche la RdA stessa
if ($flag_ultima_riga != "") {
$queryg = "DELETE FROM qui_rda WHERE id = '$id_rda'";
if (mysql_query($queryg)) {
//inserimento nel LOG
$riepilogo = "Cancellazione rda: ".$id_rda." in seguito a cancellazione della ultima riga rda ".$id_riga_rda;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}

}

//cancellazione prodotto (in realtà si rende obsoleto)
if ($avviso == "canc_prodotto") {
$data_attuale = mktime();
$queryg = "UPDATE qui_prodotti_".$negozio_preferito." SET obsoleto = '1' WHERE id = '$id_prod'"; 
if (mysql_query($queryg)) {
//inserimento nel LOG
$riepilogo = "Reso obsoleto prodotto ".$id_prod." negozio: ".$negozio_preferito;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'qui_prodotti_".$negozio."', '$id_prod', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
$queryg = "DELETE FROM qui_preferiti WHERE id_prod = '$id_prod' AND negozio = '$negozio_preferito'";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}


//approvazione rda da parte del responsabile
if ($avviso == "approva_rda_resp") {
  $data_attuale = mktime();
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
	$tx_html .= "<td class=table_mail_codice>".$rowc[codice_art]."</td>";
	$tx_html .= "<td class=table_mail_product>".stripslashes($rowc[descrizione])."</td>";
	if ($rowc[ric_mag] != "mag") {
	  $tx_html .= $rowc[ric_mag];
	}
	$tx_html .= "<td class=table_mail_numeri>".$rowc[quant]."</td>";
	$tx_html .= "<td class=table_mail_numeri>".number_format($rowc[prezzo],2,",",".")."</td>";
	$tx_html .= "<td class=table_mail_numeri_dx>".number_format($rowc[totale],2,",",".")."</td>";
	$tx_html .= "</tr>";
	$totale_rda_buyer = $totale_rda_buyer + $rowc[totale];
	//$stringa_ord_stamp .= $rowc[ordine_stampa];
	$stringa_pub .= $rowc[ric_mag];
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
  //costruzione righe tabellina dettagli rda x invio email
  
  
  //termine duplicazione righe rda
  $k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
  $risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
  while ($rigak = mysql_fetch_array($risultk)) {
	$mail_inviante = $rigak['posta'];
	$indirizzo_utente = $rigak['indirizzo'];
	$cap_utente = $rigak['cap'];
	$localita_utente = $rigak['localita'];
	$nazione_utente = $rigak['nazione'];
	$nomeunita_utente = $rigak['nomeunita'];
  }
  $q = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
  $risultq = mysql_query($q) or die("Impossibile eseguire l'interrogazione11" . mysql_error());
  while ($rigaq = mysql_fetch_array($risultq)) {
	$negozio_rda = $rigaq['negozio'];
	$negozioXMail = $rigaq['negozio'];
  }
  if ($negozio_rda == "assets") {
	$array_mail = array();
	$m = "SELECT * FROM qui_utenti WHERE ruolo = 'buyer' AND negozio_buyer = 'assets'";
	$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
	while ($rigam = mysql_fetch_array($risultm)) {
	  $add_mail = array_push($array_mail,$rigam[posta]);
	}
	$unita_rda .= $nomeunita_utente."<br>";
	$unita_rda .= $indirizzo_utente."<br>";
	$unita_rda .= $cap_utente." ".$localita_utente." ".$nazione_utente."<br>";
	
	//RIPRISTINARE
	if (is_file("produzione.php")) {
	  include "spedizione_mail_buyer.php";
	}
  } else {
	//echo "stringa_pub: ".$stringa_pub."<br>";
	//$pos1 = strpos($stringa_ord_stamp,"1");
	//if ($pos1 === false) {
	//if ($negozio_rda == "assets") {
	//	if ($stringa_pub == "pub") {
	if ($negozio_rda == "labels") {
	  //********************************************
	  //(OBSOLETO - NON USARE PIU') se uno degli articoli ha il valore 1 nel campo ordine stampa, manda una mail a Mara solo con la riga in questione
	  //se uno degli articoli ha il valore PUB nel campo ric_mag, manda una mail a Mara solo con la riga in questione
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
		$tx_mara .= "<td class=table_mail_product>".stripslashes($rowc[descrizione])."</td>";
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
	  $k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
	  $risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione13" . mysql_error());
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
	  $array_mail = array("mara.girardi@publiem.it");
	  include "spedizione_mail_mara.php";
	}
  }
  
}

//chiusura manuale rda
if ($avviso == "chiusura_rda") {
$data_chiusura = mktime();
$m = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$nazione_rda = $rigam[nazione];
}
if ($nazione_rda == "italy") {
	$flag_sap = "ok";
} else {
	$flag_sap = "";
}
$query = "UPDATE qui_righe_rda SET id_buyer = '$id_buyer', flag_chiusura = '1', stato_ordine = '4', flag_buyer = '2', n_ord_sap = '$flag_sap', n_fatt_sap = '$flag_sap', data_chiusura = '$data_chiusura', data_ultima_modifica = '$data_chiusura' WHERE id_rda = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$d = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$risultd = mysql_query($d) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$righe_totali_rda = mysql_num_rows($risultd);
while ($rigad = mysql_fetch_array($risultd)) {
	if ($rigad[stato_ordine] == 4) {
		$righe_fatte = $righe_fatte + 1;
	}
}
if ($righe_fatte == $righe_totali_rda) {
$query = "UPDATE qui_rda SET buyer_output = '$id_buyer', id_buyer = '$id_buyer', nome_buyer = '$nome_buyer', data_chiusura = '$data_chiusura', data_ultima_modifica = '$data_chiusura', stato = '4', n_ord_sap = '$flag_sap', n_fatt_sap = '$flag_sap' WHERE id = '$id_rda'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}	
}

//inserimento nel LOG
$riepilogo = "Chiusura manuale rda ".$id_rda." da parte del buyer: ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $nome_sessione;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}

//svuotamento carrello
//Come da tua richiesta<br>il carrello &egrave; stato svuotato
switch($avviso) {
case "salva_ordine":
$dicitura = '<span class="Stile1">I dati sono stati salvati correttamente</span>';
break;
case "svuota_carrello":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'svuota_carrello'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

//La RdA &egrave; stata approvata
case "approva_rda_resp":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'ok_resp'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione15" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

//La RdA &egrave; stata inserita correttamente
case "genera_rda":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'rda_ins'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione16" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

//Il prodotto selezionato &egrave; stato inserito<br>nei tuoi preferiti
case "bookmark":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'bookmark'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione17" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

//La tua preferenza &egrave; stata cancellata
case "del_bookmark":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'del_bookmark'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione18" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

//La quantit&agrave; del prodotto selezionato<br>&egrave; stata variata correttamente.
case "mod_carrello":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'mod_carrello'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione19" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

//Per ottimizzare i costi di gestione<br>si consigliano ordini superiori ai 30 euro. <br>Tienilo presente per i prossimi ordini.
case "troppo_poco":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'troppo_poco'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione19" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

case "op_annullata":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'op_annullata'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione20" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

case "canc_riga_carr":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'canc_riga_carr'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione21" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

case "canc_prodotto":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'canc_prodotto'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione22" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

case "noresp":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'noresp'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione23" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
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
$timeout = 3000;
break;
case "del_riga_rda":
if ($flag_ultima_riga != "") {
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'cancellazione_ultima_riga_rda'";
} else {
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'cancellazione_riga_rda'";
}
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione24" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
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
$timeout = 3000;
break;
case "chiusura_rda":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'conferma_chiusura_rda'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione25" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
break;

case "rda_sbagliata":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'rda_sbagliata'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione26" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_it].'</span>';
break;
case "en":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_en].'</span>';
break;
case "fr":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_fr].'</span>';
break;
case "de":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_de].'</span>';
break;
case "es":
$dicitura = '<span class="Stile1">'.$rigaeee[testo_es].'</span>';
break;
}
}
$timeout = 3000;
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
		<!--[if IE ]> <script type="text/javascript" src="ie-set_timeout.js"></script> <![endif]-->
<script type="text/javascript">
function remote2(url){
window.opener.location=url
}
/*
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
    setTimeout(function(){window.parent.TINY.box.hide()}, 1500);
}
*/
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

<body onLoad="chiudi()">
<!--<body onLoad="chiudi()" onUnload="refreshParent()">-->
<div style="width: 360px; text-align:center !important; margin: 50px auto;">
    <?php echo $dicitura;
	//echo "<br>nazione_rda: ".$nazione_rda ?></td>
</div>

</body>
</html>
