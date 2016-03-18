<?php
session_start();
//include "validation.php";
include "functions.php";
$id_carrello = $_GET['id_carrello'];
/*echo "id_carrello: ".$id_carrello."<br>";
echo "_SESSION[user_id]: ".$_SESSION[user_id]."<br>";
echo "_SESSION[IDResp]: ".$_SESSION[IDResp]."<br>";
echo "_SESSION[lang]: ".$_SESSION[lang]."<br>";
*/
include "query.php";
$g = "SELECT * FROM qui_carrelli WHERE id = '$id_carrello'";
$risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$negozio = $rigag['negozio'];
$id_utente = $rigag['id_utente'];
$id_resp = $rigag['id_resp'];
$note = $rigag['note'];
$data_ultima_modifica = $rigag['data_ultima_modifica'];
}
$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$mail_resp = $rigak['posta'];
}
$m = "SELECT * FROM qui_utenti WHERE user_id = '$id_resp'";
$risultm = mysql_query($m) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigam = mysql_fetch_array($risultm)) {
$mail_utente = $rigam['posta'];
$indirizzo_utente = $rigam['indirizzo'];
$cap_utente = $rigam['cap'];
$localita_utente = $rigam['localita'];
$nazione_utente = $rigam['nazione'];
$nomeunita_utente = $rigam['nomeunita'];
}
$unita_rda .= $nomeunita_utente."<br>";
$unita_rda .= $indirizzo_utente."<br>";
$unita_rda .= $cap_utente." ".$localita_utente." ".$nazione_utente."<br>";
if ($note != "") {
$k = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risultk = mysql_query($k) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$nome_utente_carrello = $rigak['nome'];
}
$note_rda = "Utente ".$nome_utente_carrello." ".$note;
}
$data_rda = mktime();
//legenda stati = 1 = da presentare - 2 = approvata resp - 4 = approvata buyer
mysql_query("INSERT INTO qui_rda (negozio, id_utente, id_resp, stato, data_inserimento, data_ultima_modifica, id_carrello, data_carrello, note_rda) VALUES ('$negozio', '$id_utente', '$id_resp', '1', '$sintesi2', '$data_rda', '$data_rda', '$id_carrello', '$data_ultima_modifica', '$note_rda')");
$id_rda = mysql_insert_id();

$query = "UPDATE qui_carrelli SET rda = '$id_rda', data_rda = '$data_rda' WHERE id = '$id_carrello'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//termine duplicazione rda
//inizio duplicazione righe rda
$f = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello'";
$risultf = mysql_query($f) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$prod_ordinati = mysql_num_rows($risultf);
while ($rigaf = mysql_fetch_array($risultf)) {
$negozio = $rigaf['negozio'];
$categoria = $rigaf['categoria'];
$id_utente = $rigaf['id_utente'];
$id_resp = $rigaf['id_resp'];
$quant = $rigaf['quant'];
$id_prodotto = $rigaf['id_prodotto'];

switch ($negozio) {
case "assets":
$sqld = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$sqld = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "labels":
$sqld = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$sqld = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
}

$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
switch($lingua) {
case "it":
$descrizione_art = $rigad[descrizione_it];
break;
case "en":
$descrizione_art = $rigad[descrizione_en];
break;
case "fr":
$descrizione_art = $rigad[descrizione_fr];
break;
case "de":
$descrizione_art = $rigad[descrizione_de];
break;
case "es":
$descrizione_art = $rigad[descrizione_es];
break;
}
$categoria_art = $rigad[categoria2];
$codice_art = $rigad[codice_art];
$prezzo_art = $rigad[prezzo];
$confezione_art = $rigad[confezione];
}

$totale_art = $prezzo_art*$quant;
//inserimento riga rda
mysql_query("INSERT INTO qui_righe_rda (id_carrello, negozio, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica,) VALUES ('$id_carrello', '$negozio', '$categoria_art', '$id_utente', '$id_resp', '$id_prodotto', '$codice_art', '$descrizione_art', '$confezione_art', '$quant', '$prezzo_art', '$totale_art', '$data_rda', '$data_rda')") or die("Impossibile eseguire l'inserimento" . mysql_error());
//inserimento nel LOG
$riepilogo = "Inserimento nuova rda (".$id_rda.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $_SESSION['nome'];
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//fine while select righe carrelli
}
//RIPRISTINARE
//Si spedisce la mail di generazione RdA solo se la genera un utente
if ($_SESSION[ruolo] == "utente") {
//include "spedizione_mail.php";
}

//termine duplicazione righe rda

?>
<html>
<head>
<title>Generazione RDA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
</body>
</html>