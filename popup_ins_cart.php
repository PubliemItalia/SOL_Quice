<?php
@session_start();
$IDResp = $_SESSION[IDResp];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
$quant = $_GET[quant];
$negozio= $_GET[negozio];
//echo "lingua: ".$lingua."<br>";
if ($quant == "") {
$quant = 1;
}
include "query.php";
$data_attuale = mktime();
//inserimento/modifica carrello
$sqld = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND attivo = '1'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_carrelli = mysql_num_rows($risultd);
//echo "num_carrelli: ".$num_carrelli."<br>";
//c'è un carello attivo
if ($num_carrelli > 0) {
while ($rigad = mysql_fetch_array($risultd)) {
$id_carrello = $rigad[id];
$negozio_carrello = $rigad[negozio];
}
if ($negozio_carrello == $negozio) {
//echo "carrello va bene<br>";
$queryccc = "UPDATE qui_carrelli SET data_ultima_modifica = '$data_attuale' WHERE id = '$id_carrello'";
if (mysql_query($queryccc)) {
} else {
echo "Errore 3 durante l'inserimento1: ".mysql_error();
}
} else {
//echo "carrello non va bene<br>";
}
} else {
//non ci sono carrelli attivi
mysql_query("INSERT INTO qui_carrelli (id_utente, id_resp, negozio, attivo, data_inserimento, data_ultima_modifica) VALUES ('$id_utente', '$IDResp', '$negozio', '1', '$data_attuale', '$data_attuale')");
$id_carrello = mysql_insert_id();
//inserimento nel LOG
$riepilogo = "Inserimento nuovo carrello (".$id_carrello.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento2". mysql_error();
}
}
$_SESSION[carrello] = $id_carrello;
//inserimento prodotto
//$sqlg = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND negozio = '$negozio' AND attivo = '1'";
$sqlg = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND attivo = '1'";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_carrelli_attivi = mysql_num_rows($risultg);
while ($rigag = mysql_fetch_array($risultg)) {
$id_carrello = $rigag[id];
$negozio_carrello = $rigag[negozio];
}
if ($num_carrelli_attivi > 0) {
if ($negozio_carrello == $negozio) {
/*echo "negozio_carrello: ".$negozio_carrello."<br>";
echo "negozio: ".$negozio."<br>";
*/
switch ($negozio) {
case "assets":
$sqld = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prod'";
break;
case "consumabili":
$sqld = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod'";
break;
case "spare_parts":
$sqld = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prod'";
break;
case "vivistore":
$sqld = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prod'";
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
$categoria_art = $rigad[categoria1_it];
$codice_art = $rigad[codice_art];
$prezzo_art = $rigad[prezzo];
$confezione_art = $rigad[confezione];
$id_valvola = $rigad[id_valvola];
$id_cappellotto = $rigad[id_cappellotto];
$id_pescante = $rigad[id_cappellotto];
}
if (($id_valvola != "") AND ($id_valvola != "Senza_valvola")) {
$sqlh = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_valvola'";
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
$prezzo_valvola = $rigah[prezzo];
}
}
if ($id_cappellotto != "") {
$sqlg = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_cappellotto'";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
$prezzo_cappellotto = $rigag[prezzo];
}
}
if ($id_pescante == "SI") {
$prezzo_pescante = "5.00";
}
$prezzo_art = $prezzo_art + $prezzo_cappellotto + $prezzo_valvola +$prezzo_pescante;
$totale_art = $prezzo_art*$quant;


/*
echo "prezzo_art: ".$prezzo_art."<br>";
echo "prezzo_valvola: ".$prezzo_valvola."<br>";
echo "prezzo_cappellotto: ".$prezzo_cappellotto."<br>";
echo "prezzo_pescante: ".$prezzo_pescante."<br>";
echo "id_prod: ".$id_prod."<br>";
echo $sqld."<br>";
echo "categoria_art: ".$categoria_art."<br>";
echo "codice_art: ".$codice_art."<br>";
echo "descrizione_art: ".$descrizione_art."<br>";
echo "prezzo_art: ".$prezzo_art."<br>";
echo "confezione_art: ".$confezione_art."<br>";
echo "totale_art: ".$totale_art."<br>";
*/
/*$queryh = "INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_art', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale_art')";
if (mysql_query($queryh)) {
echo "ok<br>";
} else {
echo "Errore durante l'inserimento". mysql_error();
}
*/
mysql_query("INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_art', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale_art')") or die("Impossibile eseguire l'inserimento" . mysql_error());
$id_carrello = mysql_insert_id();
//inserimento nel LOG
$riepilogo = "Inserimento nuovo carrello (".$id_carrello.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento3". mysql_error();
}
$_SESSION[tipo_carrello] = $negozio;
//messaggio di output
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'carrello_ins'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
//echo "query carrello: ".$sqleee."<br>";
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "it":
$dicitura = "<span class=stile_verde>".$rigaeee[testo_it]."</span>";
break;
case "en":
$dicitura = "<span class=stile_verde>".$rigaeee[testo_en]."</span>";
break;
case "fr":
$dicitura = "<span class=stile_verde>".$rigaeee[testo_fr]."</span>";
break;
case "de":
$dicitura = "<span class=stile_verde>".$rigaeee[testo_de]."</span>";
break;
case "es":
$dicitura = "<span class=stile_verde>".$rigaeee[testo_es]."</span>";
break;
}
}
} else {
//messaggio di output
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'carrello_div'";
//echo "query carrello: ".$sqleee."<br>";
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
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
window.close();
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
}
-->
</style></head>

<body onUnload="refreshParent()">
<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width="340" valign="middle" class="Stile1"><div align="center">
    <img src=immagini/spacer.gif width=340 height=40><br><?php echo $dicitura; ?></div></td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>
</body>
</html>
