<?php
$avviso = $_GET[avviso];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
$id_riga_carrello = $_GET[id_riga_carrello];
$id_carrello = $_GET[id_carrello];
include "query.php";

//generazione rda
if ($avviso == "genera_rda") {
$g = "SELECT * FROM qui_carrelli WHERE id = '$id_carrello'";
$risultg = mysql_query($g) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$negozio = $rigag['negozio'];
$id_utente = $rigag['id_utente'];
$id_resp = $rigag['id_resp'];
$data_ultima_modifica = $rigag['data_ultima_modifica'];
}
$data_rda = mktime();
//legenda stati = 1 = da presentare - 2 = approvata resp - 4 = approvata buyer
mysql_query("INSERT INTO qui_rda (negozio, id_utente, id_resp, stato, data_inserimento, data_ultima_modifica, id_carrello, data_carrello) VALUES ('$negozio', '$id_utente', '$id_resp', '1', '$data_rda', '$data_rda', '$id_carrello', '$data_ultima_modifica')") or die("Impossibile eseguire l'inserimento 1" . mysql_error());
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
while ($rigaf = mysql_fetch_array($risultf)) {
$negozio = $rigaf['negozio'];
$categoria = $rigaf['categoria'];
$id_utente = $rigaf['id_utente'];
$id_resp = $rigaf['id_resp'];
$id_prodotto = $rigaf['id_prodotto'];
$codice_art = $rigaf['codice_art'];
$descrizione = $rigaf['descrizione'];
$confezione = $rigaf['confezione'];
$quant = $rigaf['quant'];
$prezzo = $rigaf['prezzo'];
$totale = $rigaf['totale'];
$id_riga = $rigaf['id'];
$totale_carrello = $totale_carrello + $totale;
//inserimento riga rda
$queryd = "INSERT INTO qui_righe_rda (id_carrello, negozio, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda) VALUES ('$id_carrello', '$negozio', '$categoria', '$id_utente', '$id_resp', '$id_prodotto', '$codice_art', '$descrizione', '$confezione', '$quant', '$prezzo', '$totale', '$data_rda', '$data_rda', '$id_rda')";
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento2". mysql_error();
}
$query = "UPDATE qui_righe_carrelli SET id_rda = '$id_rda', data_rda = '$data_rda' WHERE id = '$id_riga'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

//inserimento nel LOG
$riepilogo = "Inserimento nuova rda (".$id_rda.") utente ".$id_utente;
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
//aggiornamento totale rda
$querys = "UPDATE qui_rda SET totale_rda = '$totale_carrello' WHERE id = '$id_rda'"; 
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

//termine duplicazione righe rda

}

switch($avviso) {
case "genera_rda":
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
break;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = 'index.php';

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
window.close();
}
</script>
<script> 
setTimeout("window.close();", 1500); 
</script>
<link href="tabelle.css" rel="stylesheet" type="text/css" />
</head>

<body onUnload="refreshParent()">
<table width="100%" height="70"><tr><td width="100%" align="center"  valign="middle" class="verde_grassettocx"><?php echo $dicitura; ?></td>
</tr></table>


</body>
</html>
