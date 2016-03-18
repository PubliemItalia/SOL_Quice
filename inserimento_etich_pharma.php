<?php
@session_start();
$IDResp = $_SESSION[IDResp];
$id_prod = $_GET[id_prod];
$id_utente = $_SESSION[user_id];
$lingua = $_SESSION[lang];
$quant = $_GET[quant_std_nasc];
$quant_publiem = $_GET[quant_publiem];
$custom_qty = $_GET[custom_qty];
$quant = $_GET[quant_totale];
$prezzo_unitario = $_GET[prezzo_unitario];
$prezzo_OK = $_GET[prezzo];
$totale = $prezzo_OK;
$negozio= $_GET[negozio];
$tipologia= $_GET[tipologia];
$fogli= $_GET[fogli];
$prezzo_pescante= $_GET[prezzo_pescante];
$conf= $_GET[conf];
$note_bombole= $_GET[note];
$spedizione= $_GET[spedizione];
$lingua_impostata= $_GET[lingua_impostata];
$cavo= $_GET[cavo];
//echo "note_bombole: ".$note_bombole."<br>";

$array_negozi_blocco = array("consumabili", "labels", "vivistore");

//****************************
//VARIANTE INSERIMENTO PREZZI BOMBOLE NEL CARRELLO
if (($negozio == "assets") AND ($rigad[categoria1_it] == "Bombole")) {
  $prezzo_OK = $prezzo_unitario;
  $totale = $prezzo_unitario * $quant;
}

//****************************

//echo "prezzo_OK: ".$prezzo_OK."<br>";
//echo "lingua: ".$lingua."<br>";
include "query.php";
include "traduzioni_interfaccia.php";
$data_attuale = mktime();
//echo "questa pagina inserimento etichetta nel carrello.<br>";
//recupero dato costo aggiuntivo spedizione (per il momento solo bmc)
if ($spedizione != "") { 
  $sqlq = "SELECT * FROM qui_spedizioni WHERE id = '$spedizione'";
  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigaq = mysql_fetch_array($risultq)) {
	  $costo_aggiuntivo = $rigaq[prezzo];
	  $urgente = $rigaq[urgenza];
  }
$totale_costo_aggiuntivo = $quant * $costo_aggiuntivo;
}

//ricerca azienda utente
$sqls = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
$risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
  $sqlt = "SELECT * FROM qui_unita WHERE id_unita = '$rigas[idunita]'";
  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigat = mysql_fetch_array($risultt)) {
	$azienda_utente = $rigat[IDCompany];
  }
}
$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id_prod'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
switch($lingua) {
case "it":
$descrizione_art = $rigad[descrizione_it];
$dic_pescante = "con pescante";
break;
case "en":
$descrizione_art = $rigad[descrizione_en];
$dic_pescante = "with deep tube";
break;
case "fr":
$descrizione_art = $rigad[descrizione_fr];
$dic_pescante = "with deep tube";
break;
case "de":
$descrizione_art = $rigad[descrizione_de];
$dic_pescante = "with deep tube";
break;
case "es":
$descrizione_art = $rigad[descrizione_es];
$dic_pescante = "with deep tube";
break;
}
if ($negozio == "labels") {
  $descrizione_art .= " - ".$rigad[part_number];
}
if (($negozio == "assets") AND ($rigad[categoria1_it] == "Bombole")) {
	if ($prezzo_pescante > 0) {
		$descrizione_art .= " - ".$dic_pescante;
	}
switch($conf) {
case "pacco":
$descrizione_art .= " - Confezionata in pacchi";
$percorso_ritorno = "ricerca_prodotti.php?categoria1=Pacchi_bombole&paese=".$_SESSION[paese]."&negozio=assets&lang=".$_SESSION[lang];
break;
case "cestello":
$descrizione_art .= " - Confezionata in cestello";
$percorso_ritorno = "ricerca_prodotti.php?limit=&page=1&negozio=assets&categoria1=Cestelli&lang=".$_SESSION[lang];
break;
case "pallet":
$descrizione_art .= " - Confezionata in pallet";
break;
case "nessuno":
$descrizione_art .= " - Nessun confezionamento";
break;
}
}
if (($negozio == "assets") AND ($rigad[categoria1_it] == "Pacchi_bombole")) {
switch($conf) {
case "con_bombole":
$descrizione_art .= " - con relative bombole";
$percorso_ritorno = "ricerca_assets.php?limit=&page=1&negozio=assets&categoria1=Bombole&lang=".$_SESSION[lang];
break;
case "senza_bombole":
$descrizione_art .= "";
$percorso_ritorno = "ricerca_prodotti.php?limit=&page=1&negozio=assets&categoria1=Cestelli&lang=".$_SESSION[lang];
break;
}
}
$categoria_art = $rigad[categoria1_it];
$codice_art = $rigad[codice_art];
$cat_attuale = $rigad[categoria1_it];
$confezione_art = $rigad[art_x_conf];
$azienda_prodotto = $rigad[azienda];
$flusso = $rigad[flusso];
}
//echo "cat_attuale: ".$cat_attuale."<br>";

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
$note_carrello = $rigad[note];
}
//echo "id_carrello: ".$id_carrello."<br>";
if ($note_bombole != "") {
$note_carrello = $note_carrello.addslashes("<br>".$note_bombole);
}
//echo "note_carrello: ".$note_carrello."<br>";
//echo "negozio_carrello: ".$negozio_carrello."<br>";



/*$gruppo_negozi = array("consumabili","labels","vivistore");
if ($negozio_carrello != $negozio) {
//********************************
//il negozio del carrello è diverso da quello in cui sto comprando
//********************************
switch ($negozio) {
	case "consumabili":
	case "labels":
	case "vivistore":
	if (!in_array($negozio_carrello,$array_negozi_blocco)) {
		//se il negozio del carrello non fa parte del gruppo di negozi e se il negozio dell'articolo che sto comprando invece ne fa parte, non posso inserire nel carrello 
	  //$dicitura = "carrello negozio diverso";
	  switch($lingua) {
	  case "it":
		$dicitura = '<span class="Stile2">Il prodotto che vuoi inserire<br>non fa parte del negozio<br>a cui appartiene il carrello corrente</span>';
	  break;
	  case "en":
		$dicitura = '<span class="Stile2">The product you&acute;re ordering<br>doesn&acute;t belong to the shop<br>of your current cart</span>';
	  break;
	  }
	  //echo "dicitura: ".$dicitura."<br>";
	} else {
		//se invece il negozio del carrello fa parte del gruppo di negozi e se il negozio dell'articolo che sto comprando ne fa parte, allora posso inserire nel carrello 
	  switch($lingua) {
	  case "it":
		$dicitura = '<span class="Stile1">Il prodotto &egrave; stato <br>correttamente inserito nel carrello</span>';
	  break;
	  case "en":
		$dicitura = '<span class="Stile1">The product was correctly <br>inserted in your cart</span>';
	  break;
	  }
	  mysql_query("INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale, azienda_prodotto, azienda_utente) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_OK', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale', '$azienda_prodotto', '$azienda_utente')") or die("Impossibile eseguire l'inserimento" . mysql_error());
	  $id_riga = mysql_insert_id();
	  //inserimento nel LOG
	  $riepilogo = "Inserimento nuova riga su carrello esistente (".$id_riga.") utente ".$id_utente;
	  $datalog = mktime();
	  $datalogtx = date("d.m.Y H:i",$datalog);
	  $operatore = addslashes($_SESSION['nome']);
	  $queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'carrelli', '$id_riga', '$riepilogo')";
	  if (mysql_query($queryb)) {
	  } else {
	  echo "Errore durante l'inserimento3". mysql_error();
	  }
	  switch($lingua) {
		case "it":
		  $dicitura = '<span class="Stile1">Il prodotto &egrave; stato <br>correttamente inserito nel carrello</span>';
		break;
		case "en":
		  $dicitura = '<span class="Stile1">The product was correctly <br>inserted in your cart</span>';
		break;
	  }
	  $queryccc = "UPDATE qui_carrelli SET data_ultima_modifica = '$data_attuale', note = '$note_carrello' WHERE id = '$id_carrello'";
	  if (mysql_query($queryccc)) {
	  //echo "carrello aggiornato; ".mysql_error();
	  } else {
		echo "Errore 3 durante l'inserimento1: ".mysql_error();
	  }
	}
	break;
	case "assets":
	case "spare_parts":
	  switch($lingua) {
	  case "it":
	  $dicitura = '<span class="Stile2">Il prodotto che vuoi inserire<br>non fa parte del negozio<br>a cui appartiene il carrello corrente</span>';
	  break;
	  case "en":
	  $dicitura = '<span class="Stile2">The product you&acute;re ordering<br>doesn&acute;t belong to the shop<br>of your current cart</span>';
	  break;
	  }
	break;
}
//echo "negozio_carrello: ".$negozio_carrello."<br>";
//echo "negozio: ".$negozio."<br>";

} else {
*/



if ($negozio_carrello != $negozio) {
//$dicitura = "carrello negozio diverso";
switch($lingua) {
case "it":
$dicitura = '<span class="Stile2">Il prodotto che vuoi inserire<br>non fa parte del negozio<br>a cui appartiene il carrello corrente</span>';
break;
case "en":
$dicitura = '<span class="Stile2">The product you&acute;re ordering<br>doesn&acute;t belong to the shop<br>of your current cart</span>';
break;
}
//echo "dicitura: ".$dicitura."<br>";

} else {
//********************************
//il negozio del carrello è uguale a quello in cui sto comprando
//********************************
//mysql_query("INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale, azienda_prodotto, azienda_utente, lingua_impostata, cavo, flusso, costi_aggiuntivi, urgente) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_OK', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale', '$azienda_prodotto', '$azienda_utente', '$lingua_impostata', '$cavo', '$flusso', '$totale_costo_aggiuntivo', '$urgente')") or die("Impossibile eseguire l'inserimento" . mysql_error());
mysql_query("INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale, azienda_prodotto, azienda_utente, lingua_impostata, cavo, flusso, costi_aggiuntivi) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_OK', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale', '$azienda_prodotto', '$azienda_utente', '$lingua_impostata', '$cavo', '$flusso', '$totale_costo_aggiuntivo')") or die("Impossibile eseguire l'inserimento" . mysql_error());
$id_riga = mysql_insert_id();
//inserimento nel LOG
$riepilogo = "Inserimento nuova riga su carrello esistente (".$id_riga.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'carrelli', '$id_riga', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento3". mysql_error();
}
switch($lingua) {
case "it":
	$dicitura = '<span class="Stile1">Il prodotto &egrave; stato <br>correttamente inserito nel carrello</span>';
break;
case "en":
$dicitura = '<span class="Stile1">The product was correctly <br>inserted in your cart</span>';
break;
}
$queryccc = "UPDATE qui_carrelli SET data_ultima_modifica = '$data_attuale', note = '$note_carrello' WHERE id = '$id_carrello'";
if (mysql_query($queryccc)) {
//echo "carrello aggiornato; ".mysql_error();
} else {
echo "Errore 3 durante l'inserimento1: ".mysql_error();
}
}
//fine caso carrello esistente
//********************************
} else {
//********************************
//non ci sono carrelli attivi
//********************************
mysql_query("INSERT INTO qui_carrelli (id_utente, id_resp, negozio, attivo, data_inserimento, data_ultima_modifica, note, flusso) VALUES ('$id_utente', '$IDResp', '$negozio', '1', '$data_attuale', '$data_attuale', '$note_carrello', '$flusso')");
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
//mysql_query("INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale, azienda_prodotto, azienda_utente, lingua_impostata, cavo, flusso, costi_aggiuntivi, urgente) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_OK', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale', '$azienda_prodotto', '$azienda_utente', '$lingua_impostata', '$cavo', '$flusso', '$totale_costo_aggiuntivo', '$urgente')") or die("Impossibile eseguire l'inserimento" . mysql_error());
mysql_query("INSERT INTO qui_righe_carrelli (id_carrello, id_utente, id_resp, id_prodotto, codice_art, quant, negozio, data_inserimento, data_ultima_modifica, prezzo, confezione, categoria, descrizione, totale, azienda_prodotto, azienda_utente, lingua_impostata, cavo, flusso, costi_aggiuntivi) VALUES ('$id_carrello', '$id_utente', '$IDResp', '$id_prod', '$codice_art', '$quant', '$negozio', '$data_attuale', '$data_attuale', '$prezzo_OK', '$confezione_art', '$categoria_art', '$descrizione_art', '$totale', '$azienda_prodotto', '$azienda_utente', '$lingua_impostata', '$cavo', '$flusso', '$totale_costo_aggiuntivo')") or die("Impossibile eseguire l'inserimento" . mysql_error());
$id_carrello = mysql_insert_id();
//inserimento nel LOG
$riepilogo = "Inserimento nuova riga su carrello nuovo (".$id_carrello.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento3". mysql_error();
}
switch($lingua) {
case "it":
	$dicitura = '<span class="Stile1">Il prodotto &egrave; stato <br>correttamente inserito nel carrello</span>';
break;
case "en":
$dicitura = '<span class="Stile1">The product was correctly <br>inserted in your cart</span>';
break;
}
}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function refreshbomb() {
  window.parent.location.href = "<?php echo $percorso_ritorno; ?>";
}

function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
window.close();
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
}
.Stile2 {
	font-family: Arial;
	color: red;
	font-size: 16px;
	font-weight: bold;
}
-->
</style></head>

<?php
	//echo '<body onLoad="chiudi()"; onUnload="refreshbomb()">';
if ($percorso_ritorno != "") {
	echo '<body onLoad="chiudi()"; onUnload="refreshbomb()">';
} else {
	echo '<body onLoad="chiudi()";  onUnload="refreshParent()">';
}
?>

<div style="width:100%; height:500px; background-image:url('immagini/interfaccia_carrello_it.png')">
 <div style="width: 100%; height: 150px;">
  <!--<div style="width: 100%; height: 150px; background-color:#80B6E2;">
    <div style="width: auto; min-height: 70px; overflow:hidden; height:auto; margin:20px 0px 0px 20px;">
      <div style="width: 54px; height: 54px; float:left; text-align:center;">
        <img src="immagini/percorso_rda_01_on.png"><br>Carrello
      </div>
      <div style="width: 148px; height: 54px; float:left; text-align:right;">
        <img src="immagini/percorso_rda_02_off.png">
      </div>
      <div style="width: 148px; height: 54px; float:left; text-align:right;">
        <img src="immagini/percorso_rda_03_off.png">
      </div>
    </div>-->
  </div>
  <div style="width: 100%; min-height: 20px;overflow:hidden; height:auto; text-align:center; margin-top:20px;">
    <?php echo $dicitura; ?>
  </div>
  <div style="width: 100%; min-height: 20px;overflow:hidden; height:auto; text-align:center; margin-top:20px;">
  </div>
</div>
</body>
</html>
