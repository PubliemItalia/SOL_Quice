<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
if ($_GET[id] != "") {
$id = $_GET[id];
} else {
$id = $_POST[id];
}
if ($_GET[negozio] != "") {
$negozio = $_GET[negozio];
} else {
$negozio = $_POST[negozio];
}
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}
if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
}
if ($mode == "") {
	$mode = "mod";
}
//echo "_SESSION[cod_temp]: ".$_SESSION[cod_temp]."<br>";
$modifica_prodotto = $_POST[modifica_prodotto];
$inserisci_nuovo = $_POST[inserisci_nuovo];
$action = $_GET[action];
$codice_mod = $_GET[codice];
//echo "percorso: ".$_SESSION[percorso_indietro]."<br>";
include "funzioni.js";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db


$azienda_mod = $_POST[azienda];
$categoria1_it_mod = $_POST[categoria1_it];
$categoria2_it_mod = $_POST[categoria2_it];
$categoria3_it_mod = $_POST[categoria3_it];
$categoria4_it_mod = $_POST[categoria4_it];
$categoria1_en_mod = $_POST[categoria1_en];
$categoria2_en_mod = $_POST[categoria2_en];
$categoria3_en_mod = $_POST[categoria3_en];
$categoria4_en_mod = $_POST[categoria4_en];
$descrizione1_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione1_it]));
$descrizione2_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione2_it]));
$descrizione3_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione3_it]));
$descrizione4_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione4_it]));
$descrizione1_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione1_en]));
$descrizione2_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione2_en]));
$descrizione3_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione3_en]));
$descrizione4_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione4_en]));
$immagine1_mod = $_POST[immagine1];
$immagine2_mod = $_POST[immagine2];
$immagine3_mod = $_POST[immagine3];
$immagine4_mod = $_POST[immagine4];
$immagine5_mod = $_POST[immagine5];
$modifica_prodotto = $_POST[modifica_prodotto];
$consenso = $_POST[consenso];
$confezione_mod = $_POST[confezione];
$paese_mod = $_POST[paese];
$foto_paese_mod = $_POST[foto_paese];
$precedenza_int_mod = $_POST[precedenza_int];
$codice = $_POST[codice];
$prezzo_mod = str_replace(",",".",$_POST[prezzo]);
$gruppo_merci_mod = $_POST[gruppo_merci];
$wbs_mod = $_POST[wbs];
$immagine1_mod = $_POST[immagine1];
$img_gallery1_rem = $_POST[img_gallery1_rem];
$img_gallery2_rem = $_POST[img_gallery2_rem];
$img_gallery3_rem = $_POST[img_gallery3_rem];
$img_gallery4_rem = $_POST[img_gallery4_rem];

$nuova_immagine_princ = $_POST[immagine_princ];
//se cambio l'immagine faccio il controllo che non esista già
//comunque sia l'immagine viene copiata nella cartella con un codice davanti. 
//se c'è l'immagine con lo stesso nome avverto e, se la risposta è si, cancello la vecchia immagine e rinomino quella nuova come quella vecchia
//se la risposta è no torno alla pagina precedente e cancello l'immagine nuova

//***********************************
//non si modifica più il codice art in quanto viene creato automaticamente
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$sqlf = "SELECT * FROM qui_utenti WHERE user_id = '$_SESSION[user_id]'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$email = $rigaf[posta];
}

if ($modifica_prodotto != "") {
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$immagine_change = $rigaf[foto_sost];
$scheda_change = $rigaf[filepath];
}
$query_gall = "UPDATE qui_gallery SET temp = '' WHERE id_prodotto = '$codice' AND temp = 'T'";
if (mysql_query($query_gall)) {
	$avviso = "Dati del prodotto modificati correttamente";
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}

if ($immagine_change != "") {
$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', wbs = '$wbs_mod', foto = '$immagine_change', foto_sost = '', precedenza_int =  '$precedenza_int_mod', azienda = '$azienda_mod' WHERE id = '$id'";
//$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione4_it = '$descrizione4_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', descrizione4_en = '$descrizione4_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', wbs = '$wbs_mod', foto = '$immagine_change', foto_sost = '' WHERE id = '$id'";
} else {
$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', wbs = '$wbs_mod', precedenza_int = '$precedenza_int_mod', azienda = '$azienda_mod' WHERE id = '$id'";
//$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione4_it = '$descrizione4_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', descrizione4_en = '$descrizione4_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', wbs = '$wbs_mod' WHERE id = '$id'";
}
//$titolo_pop1 = levapar($_POST[titolo_pop1]);
if (mysql_query($query)) {
	$avviso = "Dati del prodotto modificati correttamente";
} else {
echo "Errore durante l'inserimento4: ".mysql_error();
}
if ($scheda_change != "") {
  $query = "UPDATE qui_prodotti_".$negozio." SET percorso_pdf = '$scheda_change' WHERE id = '$id'";
  //$titolo_pop1 = levapar($_POST[titolo_pop1]);
  if (mysql_query($queryd)) {
	  $avviso = "Scheda del prodotto modificata correttamente";
  } else {
  echo "Errore durante l'inserimento4: ".mysql_error();
  }
}
$riepilogo = "Modifica prodotto id".$id." negozio ".$negozio." - prezzo ".$prezzo_mod." - confezione ".$confezione_mod." - foto ".$immagine_change." - utente ".$id_utente;
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'prodotti', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}

if ($inserisci_nuovo != "") {
if ($negozio == "spare_parts") {
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." ORDER BY codice_art DESC LIMIT 1";
} else {
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." ORDER BY id DESC LIMIT 1";
}
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
if (substr($rigaf[codice_art],0,1) == "*") {
	$temp_new_code = intval(substr($rigaf[codice_art],1));
	$nuovo_codice = "*".($temp_new_code+1);
} else {
	$nuovo_codice = $rigaf[codice_art]+1;
}
}
$sqlh = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
  if ($rigah[foto_sost] != "") {
	$foto = $rigah[foto_sost];
	$sqlj = "UPDATE qui_prodotti_".$negozio." SET foto_sost = '' WHERE id = '$id'";
	if (mysql_query($sqlj)) {
	} else {
	  echo "Errore durante l'inserimento4: ".mysql_error();
	}
  } else {
	$foto = $rigah[foto];
  }
	$ric_mag = $rigah[ric_mag];
	$gr_merci = $rigah[gruppo_merci];
}

mysql_query("INSERT INTO qui_prodotti_".$negozio." (obsoleto, ric_mag, paese, foto_paese, negozio, categoria1_it, categoria2_it, categoria3_it, categoria4_it, descrizione1_it, descrizione2_it, descrizione3_it, descrizione4_it, gruppo_merci, wbs, prezzo, confezione, foto, categoria1_en, categoria2_en, categoria3_en, categoria4_en, descrizione1_en, descrizione2_en, descrizione3_en, descrizione4_en, codice_art, precedenza_int, azienda) VALUES ('0', '$ric_mag', '$paese_mod', '$foto_paese_mod', '$negozio', '$categoria1_it_mod', '$categoria2_it_mod', '$categoria3_it_mod', '$categoria4_it_mod', '$descrizione1_it_mod', '$descrizione2_it_mod', '$descrizione3_it_mod', '$descrizione4_it_mod', '$gr_merci', '$wbs_mod', '$prezzo_mod', '$confezione_mod', '$foto', '$categoria1_en_mod', '$categoria2_en_mod', '$categoria3_en_mod', '$categoria4_en_mod', '$descrizione1_en_mod', '$descrizione2_en_mod', '$descrizione3_en_mod', '$descrizione4_en_mod', '$nuovo_codice', '$precedenza_int_mod', '$azienda_mod')");
if (mysql_query()) {
	echo "inserito id ".mysql_insert_id()."<br>";
} else {
echo "Errore durante l'inserimento". mysql_error();
}
$id_inserito = mysql_insert_id();
$id = $id_inserito;

$sqlk = "UPDATE qui_gallery SET id_prodotto = '$nuovo_codice', temp = '' WHERE id_prodotto = '$_SESSION[cod_temp]' AND temp = 'T'";
if (mysql_query($sqlk)) {
} else {
echo "Errore durante l'inserimento4: ".mysql_error();
}
$_SESSION[cod_temp] = "";
$avviso = "Richiesta inserimento nuovo prodotto inoltrata correttamente";
$oggetto = "Qui c'e'; - Richiesta inserimento nuovo prodotto";
$messaggio .= $datalogtx."<br>".$operatore." (email ".$email.") richiede di inserire il seguente prodotto identificato dal numero di ID ".$id_inserito.":<br>";
$messaggio .= "Negozio: ".$negozio."<br>";
$messaggio .= "Codice: ".$nuovo_codice."<br>";
$messaggio .= "Categoria 1: ".$categoria1_it_mod."<br>";
$messaggio .= "Descrizione: ".$descrizione1_it_mod."<br>";
include "spedizione_richiesta.php";
}
/*
switch ($mode) {
case "":
$sfondo = "#FFF";
break;
case "mod":
$sfondo = "#FFEAA6";
break;
case "ins":
$sfondo = "#D2E888";
break;
}
*/
$sfondo = "#EDEDED";

//$lingua = $_SESSION[lang];
//echo "sess_immtemp: ".$_SESSION[imm_temp]."<br>";
if (is_file("files/".$_SESSION[imm_temp])) {
unlink("files/".$_SESSION[imm_temp]);
}





$sqleee = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$categoria1_it = $rigaeee[categoria1_it];
$categoria2_it = $rigaeee[categoria2_it];
$categoria3_it = $rigaeee[categoria3_it];
$categoria4_it = $rigaeee[categoria4_it];
$categoria1_en = $rigaeee[categoria1_en];
$categoria2_en = $rigaeee[categoria2_en];
$categoria3_en = $rigaeee[categoria3_en];
$categoria4_en = $rigaeee[categoria4_en];
$descrizione1_it = str_replace("<br>","\n",$rigaeee[descrizione1_it]);
$descrizione2_it = str_replace("<br>","\n",$rigaeee[descrizione2_it]);
$descrizione3_it = str_replace("<br>","\n",$rigaeee[descrizione3_it]);
$descrizione4_it = str_replace("<br>","\n",$rigaeee[descrizione4_it]);
$descrizione1_en = str_replace("<br>","\n",$rigaeee[descrizione1_en]);
$descrizione2_en = str_replace("<br>","\n",$rigaeee[descrizione2_en]);
$descrizione3_en = str_replace("<br>","\n",$rigaeee[descrizione3_en]);
$descrizione4_en = str_replace("<br>","\n",$rigaeee[descrizione4_en]);
$indicazione_ric_mag = $rigaeee[ric_mag];
$foto = $rigaeee[foto];
$scheda_tecnica = $rigaeee[percorso_pdf];
$codice_art = $rigaeee[codice_art];
$azienda = $rigaeee[azienda];
$paese = $rigaeee[paese];
$foto_paese = $rigaeee[foto_paese];
$precedenza_int = $rigaeee[precedenza_int];
$prezzo = str_replace(".",",",$rigaeee[prezzo]);
$confezione = $rigaeee[confezione];
$gruppo_merci = $rigaeee[gruppo_merci];
$wbs = $rigaeee[wbs];
switch($lingua) {
case "it":
$categoria1 = $rigaeee[categoria1_it];
$categoria2 = $rigaeee[categoria2_it];
$categoria3 = $rigaeee[categoria3_it];
$categoria4 = $rigaeee[categoria4_it];
$descrizione1 = $rigaeee[descrizione1_it];
$descrizione2 = $rigaeee[descrizione2_it];
$descrizione3 = $rigaeee[descrizione3_it];
$descrizione4 = $rigaeee[descrizione4_it];
break;
case "en":
$categoria1 = $rigaeee[categoria1_en];
$categoria2 = $rigaeee[categoria2_en];
$categoria3 = $rigaeee[categoria3_en];
$categoria4 = $rigaeee[categoria4_en];
$descrizione1 = $rigaeee[descrizione1_en];
$descrizione2 = $rigaeee[descrizione2_en];
$descrizione3 = $rigaeee[descrizione3_en];
$descrizione4 = $rigaeee[descrizione4_en];
break;
case "fr":
$descrizione = $rigaeee[descrizione_fr];
break;
case "de":
$descrizione = $rigaeee[descrizione_de];
break;
case "es":
$descrizione = $rigaeee[descrizione_es];
break;
}
}

include "traduzioni_interfaccia.php";
switch($lingua) {
case "it":
$titolo_scheda = "Scheda prodotto";
break;
case "en":
$titolo_scheda = "Product sheet";
break;
}

$sqlq = "SELECT DISTINCT categoria1_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione7" . mysql_error());
$num1 = mysql_num_rows($risultq);
if ($num1 > 1) {
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[categoria1_it] == $categoria1_it) {
$blocco_cat1_it .= "<option selected value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_it])."</option>";
} else {
$blocco_cat1_it .= "<option value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_it])."</option>";
}
}
}
$sqlr = "SELECT DISTINCT categoria2_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = '$categoria1_it' ORDER BY precedenza ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
$num2 = mysql_num_rows($risultr);
if ($num2 > 1) {
while ($rigar = mysql_fetch_array($risultr)) {
if ($rigar[categoria2_it] == $categoria2_it) {
$blocco_cat2_it .= "<option selected value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_it])."</option>";
} else {
$blocco_cat2_it .= "<option value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_it])."</option>";
}
}
}
$ssls = "SELECT DISTINCT categoria3_it FROM qui_prodotti_".$negozio." WHERE categoria2_it = '$categoria2_it' ORDER BY precedenza ASC";
$risults = mysql_query($ssls) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
$num3 = mysql_num_rows($risults);
if ($num3 > 1) {
while ($rigas = mysql_fetch_array($risults)) {
if ($rigas[categoria3_it] == $categoria3_it) {
$blocco_cat3_it .= "<option selected value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_it])."</option>";
} else {
$blocco_cat3_it .= "<option value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_it])."</option>";
}
}
}
$stlt = "SELECT DISTINCT categoria4_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultt = mysql_query($stlt) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
$num4 = mysql_num_rows($risultt);
if ($num4 > 1) {
while ($rigat = mysql_fetch_array($risultt)) {
if ($rigat[categoria4_it] == $categoria4_it) {
$blocco_cat4_it .= "<option selected value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_it])."</option>";
} else {
$blocco_cat4_it .= "<option value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_it])."</option>";
}
}
}

$sqlq = "SELECT DISTINCT categoria1_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione11" . mysql_error());
if ($num1 > 1) {
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[categoria1_en] == $categoria1_it) {
$blocco_cat1_en .= "<option selected value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_en])."</option>";
} else {
$blocco_cat1_en .= "<option value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_en])."</option>";
}
}
}
$sqlr = "SELECT DISTINCT categoria2_en FROM qui_prodotti_".$negozio." WHERE categoria1_it = '$categoria1_it' ORDER BY precedenza ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione12" . mysql_error());
if ($num2 > 1) {
while ($rigar = mysql_fetch_array($risultr)) {
if ($rigar[categoria2_it] == $categoria2_it) {
//if ($rigar[categoria2_en] == $categoria2_en) {
$blocco_cat2_en .= "<option selected value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_en])."</option>";
} else {
$blocco_cat2_en .= "<option value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_en])."</option>";
}
}
}
$ssls = "SELECT DISTINCT categoria3_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risults = mysql_query($ssls) or die("Impossibile eseguire l'interrogazione13" . mysql_error());
if ($num3 > 1) {
while ($rigas = mysql_fetch_array($risults)) {
if ($rigas[categoria3_it] == $categoria3_it) {
//if ($rigas[categoria3_en] == $categoria3_en) {
$blocco_cat3_en .= "<option selected value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_en])."</option>";
} else {
$blocco_cat3_en .= "<option value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_en])."</option>";
}
}
}
$stlt = "SELECT DISTINCT categoria4_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultt = mysql_query($stlt) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
if ($num4 > 1) {
while ($rigat = mysql_fetch_array($risultt)) {
if ($rigat[categoria4_it] == $categoria4_it) {
//if ($rigat[categoria4_en] == $categoria4_en) {
$blocco_cat4_en .= "<option selected value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_en])."</option>";
} else {
$blocco_cat4_en .= "<option value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_en])."</option>";
}
}
}
$stlv = "SELECT * FROM qui_gruppo_merci ORDER BY gruppo_merce ASC";
$risultv = mysql_query($stlv) or die("Impossibile eseguire l'interrogazione15" . mysql_error());
while ($rigav = mysql_fetch_array($risultv)) {
if ($rigav[gruppo_merce] == $gruppo_merci) {
$blocco_gruppo_merci .= "<option selected value=".$rigav[gruppo_merce].">".$rigav[gruppo_merce]."</option>";
} else {
$blocco_gruppo_merci .= "<option value=".$rigav[gruppo_merce].">".$rigav[gruppo_merce]."</option>";
}
}
//echo $_SESSION[percorso_modifica];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $titolo_scheda; ?></title>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/visual.css" rel="stylesheet" type="text/css">
  <link href="css/modifica_scheda.css" rel="stylesheet" type="text/css">
<link href="css/lightbox3.css" rel="stylesheet" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="tinybox2/styletiny_gallery.css" />
<style type="text/css">


body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: <?php echo $sfondo; ?>;
	color:rgb(0,0,0);
	text-align:center;
}
#pulsante_indietro {
	width: auto;
	height: auto;
	float:left;
}
#pulsante_modifica {
	width: auto;
	height: auto;
	float:left;
}
<!--
.Stile1 {color: #FF0000}
.Stile2 {
	color: #33CCFF;
	font-weight: bold;
}
.Stile3 {
	color: #000000;
	font-weight: bold;
}
.colonna_ordinati {
	width:118px;
	height:70px;
	float:left;
	margin:0px 0px 0px 10px;
	padding:10px 5px;
	background-color:#CC0;"
}
.colonna_magazzino_riserva {
	width:185px;
	height:70px;
	float:left;
	margin:0px 0px 0px 10px;
	padding:10px 5px;
	background-color:rgb(255,0,0);
}
.colonna_magazzino {
	width:180px;
	height:70px;
	float:left;
	margin:0px 0px 0px 10px;
	padding:10px 10px;
	background-color:transparent;
}
.colonna_gestione {
	width:320px;
	height:70px;
	float:left;
	margin:0px 0px 0px 10px;
	padding:10px 5px;
	background-color:transparent;
}
.etichetta_magazzino {
	float:left;
	height:20px;
	}
.colonnina_rda {
	padding-top:3px;
	border-bottom:1px solid rgb(0,0,0);
	float:left;
	width:50px;
	height:15px;
	}
.colonnina_data {
	padding-top:3px;
	border-bottom:1px solid rgb(0,0,0);
	float:left;
	width:90px;
	height:15px;
	}
.colonnina_unit {
	padding-top:3px;
	border-bottom:1px solid rgb(0,0,0);
	float:left;
	width:70px;
	height:15px;
	}
.colonnina_quant {
	padding-top:3px;
	border-bottom:1px solid rgb(0,0,0);
	float:left;
	width:60px;
	text-align:right;
	height:15px;
	}
.colonnina_tot {
	padding-top:3px;
	border-bottom:1px solid rgb(0,0,0);
	float:left;
	width:100px;
	text-align:right;
	height:15px;
	}
.bottone_servizio-esterno {
	color:#fff; 
	width:100px; 
	height:30px; 
	float:right; 
	margin-right:20px;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px; 
	border-radius: 5px; 
}
.bottone_servizio-icona {
	width:auto;
	height:auto; 
	float:left; 
	margin:7px 5px 0px 5px; 
}
.bottone_servizio-testo {
	width:65px; 
	height:auto; 
	float:left; 
	font-size:11px;
	margin-top:3px;
	text-align:center;
}
.stripN {
	width:960px;
	min-height:40px;
	overflow: hidden; 
	height:auto; 
	float:left; 
	font-size:11px;
	margin-top:30px;
}
.caselle {
	float: right; 
	margin:5px 5px 0px 0px;
	width:28px;
	height:27px;
}
.caselle_spuntate {
	background-image:url(immagini/check_ok.png);
}
.caselle_vuote {
	background-image:url(immagini/check_vuoto.png);
}
.diciture_pag_modifica {
	font-weight:normal; 
	font-size:14px;
	width:100%;
	text-align:left;
}
.elementi_grandi_csottili {
	float: right; 
	width: auto; 
	margin:5px 5px 0px 0px;
	width:28px;
	height:27px;
}
.bottone_carica-cambia {
	cursor:pointer;
	color:#5e5e5e; 
	font-size: 15px;
	width:120px; 
	height:19px;
	padding-top: 3px; 
	float:none; 
	margin: auto;
	margin-top:20px;
	border: 2px solid #ebebeb;
	background-color: #dddddd;
	text-align:center;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px; 
	border-radius: 5px; 
}
.bottone_carica-cambia:hover {
	border: 2px solid #3fa9f5;
	background-color: #d4efff;
	text-align:center;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px; 
	border-radius: 5px; 
}
.campo_evid {
	width:73px; 
	height:27px;
	background-color:#d4efff; 
	color:#5e5e5e; 
	border:1px solid #e6e6e6; 
	text-align:right; 
	padding:2px 3px 0px 0px;
}
.campo_norm {
	width:73px;
	height:27px; 
	text-align:right; 
	color:#5e5e5e; 
	border:1px solid #e6e6e6; 
	padding:2px 3px 0px 0px;
}
.area_selez {
	color:#3fa9f5;
	font-weight:bold; 
	width:100%; 
	height:38px; 
	background-color:#fff; 
	border: 2px solid #3fa9f5; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
	border-radius: 5px; 
	margin-bottom: 27px;
}
.area_norm {
	color: #5e5e5e; 
	font-weight:bold; 
	width:100%;
	height:38px; 
	background-color:#fff; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
	border-radius: 5px; 
	margin-bottom: 27px; 
	border: 2px solid #e6e6e6;
}

-->
</style>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox3.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
</head>

<?php
if (($inserisci_nuovo != "") OR ($modifica_prodotto != "")) {
	echo "<body onLoad=\"TINY.box.show({iframe:'alert_amministrazione.php?avviso=".$avviso."&id_prod=".$id."&negozio_prod=".$_SESSION[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){torna_indietro_dopo_salva()}})\">";

} else {
	echo "<body>";
}
?>


<div id="wrap">
    <!--INIZIO DEL FORM-->
<form action="popup_modifica_scheda.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div id="lingua_scheda" style="margin-top:20px;">
      <div id="disp_azione" style="background-color:#fff; width:auto; height:auto; border: 1px solid #EBEBEB; float: left; padding:10px;">
        <div id="icona_titolo" style="width:auto; height:auto; margin-right: 10px; float: left;">
          <?php
            switch ($mode) {
              case "ins": 
                echo '<img src="immagini/icon_add_prodotto.png">';
              break;
              case "mod": 
                echo '<img src="immagini/icon_mod_prodotto.png">';
              break;
            }
          
          ?>
        </div>
        <div id="titolo" style="width:auto; height:auto; color:#727272; float: left; font-size:20px; padding-top:3px;">
          <?php
            switch ($mode) {
              case "ins": 
                echo "Inserimento scheda prodotto";
              break;
              case "mod": 
                echo "Modifica scheda prodotto";
              break;
            }
          ?>
        </div>
      </div>
          <?php
            switch ($mode) { 
              case "mod":
                  echo '
                   <a href="popup_modifica_scheda.php?mode=ins&id='.$id.'&negozio='.$negozio.'&lang='.$lingua.'">
                      <div class="bottone_servizio-esterno" style="margin-right: 0px; background-color: #2ece45; border:1px solid #32a32f;">
                        <div class="bottone_servizio-icona">
                          <img src="immagini/icona_+.png" width="17" height="17">
                        </div>
                        <div class="bottone_servizio-testo">
                          AGGIUNGI<br>PRODOTTO
                       </div>
                     </div>
                    </a>
                    ';
              break;
              case "ins":
                  echo '
                   <a href="popup_modifica_scheda.php?mode=mod&id='.$id.'&negozio='.$negozio.'&lang='.$lingua.'">
                      <div class="bottone_servizio-esterno" style="margin-right: 0px; background-color: #ffbc13; border:1px solid #ffa20b;">
                        <div class="bottone_servizio-icona">
                          <img src="immagini/icona_matita.png" width="17" height="17">
                        </div>
                        <div class="bottone_servizio-testo">
                          MODIFICA<br>PRODOTTO
                       </div>
                     </div>
                    </a>
                    ';
              break;
            }
        ?>
          <div class="bottone_servizio-esterno" style="background-color: #D43E00; border:1px solid #A90000; cursor:pointer;" onclick="eliminazione_articolo('<?php echo $negozio; ?>','<?php echo $id; ?>');">
            <div class="bottone_servizio-icona" style="margin-top:2px; font-size:22px;">
              x
            </div>
            <div class="bottone_servizio-testo">
              ELIMINA<br>PRODOTTO
           </div>
         </div>
<?php
if (($mode == "ins") OR ($mode == "mod")) {
	echo '<div class="bottone_servizio-esterno" style="background-color: #3fa9f5; border:1px solid #4485d3; cursor:pointer;" onclick="submission()">';
	  echo '<div class="bottone_servizio-icona">
		<img src="immagini/icona_segno_spunta.png" width="17" height="17">
	  </div>
	  <div class="bottone_servizio-testo" style="padding-top:6px;">
		SALVA
	 </div>
   </div>';
echo "<input name=categoria1_it type=hidden value=".$categoria1_it.">
<input name=categoria2_it type=hidden value=".$categoria2_it.">
       <input name=categoria3_it type=hidden value=".$categoria3_it.">
       <input name=categoria4_it type=hidden value=".$categoria4_it.">
       <input name=categoria1_en type=hidden value=".$categoria1_en.">
       <input name=categoria2_en type=hidden value=".$categoria2_en.">
       <input name=categoria3_en type=hidden value=".$categoria3_en.">
       <input name=categoria4_en type=hidden value=".$categoria4_en.">
       <input name=mode type=hidden value=".$mode.">
        <input name=id type=hidden value=".$id.">
        <input name=codice type=hidden value=".$codice_art.">
        <input name=negozio type=hidden value=".$negozio.">
        <input name=lang type=hidden value=".$lingua.">
        <input name=foto_paese type=hidden value=".$foto_paese.">
        <input name=paese type=hidden value=".$paese.">";
} else {
//echo "<div class=pulsanti_scheda_verde style=\"float:right; width:100px; height:20px; padding:2px 0px; border:none; background-color:transparent;\">";
}

if (($inserisci_nuovo != "") OR ($modifica_prodotto != "")) {
	echo '<div class="bottone_servizio-esterno" style="background-color: #bfbfbf; border:1px solid #aaaaaa; cursor:pointer;" onclick="torna_indietro_dopo_salva();">';
} else {
	echo '<div class="bottone_servizio-esterno" style="background-color: #bfbfbf; border:1px solid #aaaaaa; cursor:pointer;" onclick="torna_indietro();">';
}
	  echo '<div class="bottone_servizio-icona">
		<img src="immagini/icona_indietro.png" width="17" height="17">
	  </div>
	  <div class="bottone_servizio-testo" style="padding-top:6px;">
		INDIETRO
	 </div>
   </div>';
?>
  
    </div><!--END LINGUA SCHEDA-->

    <div class="titolo_scheda_modifica" style="height:41px; padding:0px; background-repeat:repeat-x; margin-top: 20px;">
	  <?php
      if (($mode == "ins") OR ($mode == "mod")) {
            echo '<div style="width:auto; padding:12px 5px 0px 5px; height:31px; background-image:url(\'immagini/bcgr_freccia.png\');  background-repeat:repeat-x; float:left; color: #5e5e5e; font-size:13px;">';
              switch ($negozio) {
                case "consumabili":
                  $titolo = $tasto_consumabili;
                break;
                case "spare_parts":
                  $titolo = $spare_parts;
                break;
                case "assets":
                  $titolo = $tasto_asset;
                break;
              }
              echo ucfirst($titolo);
             echo '</div>';
			echo '<div style="width:auto; height:auto; float:left;">
			<img src="immagini/punta_freccia_mezzo.png">
			</div>';
            echo '<div style="width:auto; padding:12px 5px 0px 5px; height:31px; background-image:url(\'immagini/bcgr_freccia.png\'); float:left; color: #5e5e5e; font-size:13px;">';
			 echo str_replace("_"," ",$categoria1);
             echo '</div>';
			echo '<div style="width:auto; height:auto; float:left;">
			<img src="immagini/punta_freccia_mezzo.png">
			</div>';
             if ($categoria2 != "") {
             echo '<div style="width:auto; padding:12px 5px 0px 5px; height:31px; background-image:url(\'immagini/bcgr_freccia.png\'); float:left; color: #5e5e5e; font-size:13px;">';
              echo str_replace("_"," ",$categoria2);
             echo '</div>';
			echo '<div style="width:auto; height:auto; float:left;">
			<img src="immagini/punta_freccia_penultima.png">
			</div>';
              }
              if ($categoria3 != "") {
             echo '<div style="width:auto; padding:12px 5px 0px 5px; height:31px; background-image:url(\'immagini/bcgr_freccia_bianca.png\'); float:left; color: #3fa9f5; font-size:13px;">';
              echo str_replace("_"," ",$categoria3);
             echo '</div>';
			echo '<div style="width:auto; height:auto; float:left;">
			<img src="immagini/punta_freccia_bianca.png">
			</div>';
              }
      }
      switch ($mode) {
        case "mod":
          echo "<input name=modifica_prodotto type=hidden value=1>";
        break;
        case "ins":
          echo "<input name=inserisci_nuovo type=hidden value=1>";
        break;
      }
      ?>
        <div style="margin-left:10px; padding:13px 20px; width:auto; height:auto; border-left:1px solid #5e5e5e; border-right:1px solid #5e5e5e; color:#5e5e5e; float:left;">
          Gruppo merci <?php echo $gruppo_merci; ?>
        </div>
        <div style="padding:13px 20px; width:auto; height:auto; border-right:1px solid #5e5e5e; color:#5e5e5e; font-weight:bold; float:left;">
        <?php echo $indicazione_ric_mag; ?>
        </div>
<!--<div class="pulsanti_scheda_azzurro" style="margin-right:30px; width:100px; height:16px; padding:2px 0px; border:none; float:right;">-->

    </div>  <!--END TITOLO_SCHEDA-->
    <div id="check_completato"></div>
    

<?php
switch ($mode) {
case "mod":
include "modifica_scheda.php";
break;
case "ins":
include "modifica_scheda.php";
break;
}

?>
  </form>
</div><!--END WRAP-->
<script type="text/javascript">
function evidenz(id_campo,class_campo,actual_class_campo,id_cont,class_cont,actual_class_cont){
//alert(id_campo+","+class_campo+","+id_cont+","+class_cont);
$('#'+id_campo).addClass(class_campo);
$('#'+id_cont).addClass(class_cont);
$('#'+id_campo).removeClass(actual_class_campo);
$('#'+id_cont).removeClass(actual_class_cont);
}
function deselect(id_campo,class_campo,actual_class_campo,id_cont,class_cont,actual_class_cont){
//alert('closed');
$('#'+id_campo).addClass(actual_class_campo);
$('#'+id_cont).addClass(actual_class_cont);
$('#'+id_campo).removeClass(class_campo);
$('#'+id_cont).removeClass(class_cont);
}
function solviv(azienda){
//alert(id_campo+","+class_campo+","+id_cont+","+class_cont);
switch(azienda) {
	case "check_viv":
	  $('#check_viv').removeClass('caselle_vuote');
	  $('#check_viv').addClass('caselle_spuntate');
	  $('#check_sol').removeClass('caselle_spuntate');
	  $('#check_sol').addClass('caselle_vuote');
	  document.getElementById('azienda').value = "VIVISOL";
	break;
	case "check_sol":
	  $('#check_sol').addClass('caselle_spuntate');
	  $('#check_sol').removeClass('caselle_vuote');
	  $('#check_viv').removeClass('caselle_spuntate');
	  $('#check_viv').addClass('caselle_vuote');
	  document.getElementById('azienda').value = "SOL";
	break;
}
}
function submission() {
document.getElementById("form1").submit();
}
function closeJS(){
//alert('closed');
  //window.location.href = window.location.href;
}
function closeJS1(){
/*alert('url');
				$.ajax({
						type: "GET",   
						url: "aggiorna_anteprima_immagine.php",   
						//data: "tipo_immagine=anteprima&shop=<?php //echo $negozio; ?>&id=<?php //echo $id; ?>",
						data: "ciao",
						success: function(output) {
						$('#componente_immagine').html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "aggiorna_anteprima_immagine.php",   
						data: "tipo_immagine=miniatura"+"&shop=<?php //echo $negozio; ?>"+"&id=<?php //echo $id; ?>",
						success: function(output) {
						$('#images').html(output).show();
						}
						})*/
}
function closeJS2(){
//alert('url');
				$.ajax({
						type: "GET",   
						url: "aggiorna_anteprima_immagine.php",   
						data: "tipo_immagine=1"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#componente_immagine').html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "aggiorna_anteprima_immagine.php",   
						data: "tipo_immagine=2"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#image_gallery').html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "aggiorna_anteprima_immagine.php",   
						data: "tipo_immagine=3"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#valore_gallery').html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "aggiorna_anteprima_immagine.php",   
						data: "tipo_immagine=4"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#input_immagine').html(output).show();
						}
						})
}
function closeJS3(discr){
//alert('url');
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati_scheda_tecnica.php",   
						data: "tipo_immagine=1"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#scheda').html(output).show();
						}
						})
				/*$.ajax({
						type: "GET",   
						url: "aggiorna_dati_scheda_tecnica.php",   
						data: "tipo_immagine=2"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#valore_scheda_tecnica').html(output).show();
						}
						})*/
}
function carico_magazzino(){
	var quant = document.getElementById('caricare').value;
//alert(quant);
				$.ajax({
						type: "GET",   
						url: "aggiorna_quant_magazzino.php",   
						data: "quant="+quant+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#colonna_ordinati').html(output).show();
						}
						})
}

function caricamento_pdf() {
var input = document.getElementById ("scelta_pdf");
var str = input.value;
var n = str.indexOf(".pdf");
  if (n == "-1") {
	alert('Scegliere un PDF da caricare');
  } else {
	$.ajax({
			type: "GET",   
			url: "aggiorna_elaborazione_pdf.php",   
			data: "tipo_immagine=1"+"&shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
			success: function(output) {
			$('#componente_immagine').html(output).show();
			}
			})
  }
}

function torna_indietro() {
				$.ajax({
						type: "GET",   
						url: "aggiorna_cancella_modifiche.php",   
						data: "shop=<?php echo $negozio; ?>"+"&id=<?php echo $id; ?>",
						success: function(output) {
						$('#zzz').html(output).show();
						}
						})
alert("Nessuna modifica è stata applicata");
	location.href = "<?php echo $_SESSION[percorso_indietro]; ?>";
}
function torna_indietro_dopo_salva() {
	location.href = "<?php echo $_SESSION[percorso_indietro];; ?>";
}
function sostituisci(id,contenuto) {
	contenuto = contenuto.replace(/[\n]/g, "<br>");
   contenuto = contenuto.replace(/[\r]/g, "<br>");
	//alert(contenuto);
  var contenitore = document.getElementById(id);
  contenitore.innerHTML = contenuto;
}
function eliminazione_articolo(negozio,id){
	  var x;
	  if (confirm("Sei proprio sicuro di eliminare questo articolo?") == true) {
		  /*x = "La modifica è stata registrata!";*/
		  $.ajax({
				  type: "GET",   
				  url: "eliminazione_articolo.php",   
					data: "shop="+negozio+"&id="+id,
				  success: function(output) {
				  $('#check_completato').html(output).show();
				  }
				  })

		
	  }
}
  function doRedirect() {
	var check_completato = document.getElementById('check').value;
	if (check_completato == "OK") {
    //Genera il link alla pagina che si desidera raggiungere
    location.href = "<?php echo $_SESSION[percorso_modifica]; ?>";
}
  }
      
  //Fa partire il redirect dopo 1 secondi da quando l'intermprete JavaScript ha rilevato la funzione
  window.setInterval("doRedirect()", 1000);
 
//-->
</script>
</body>
</html>
