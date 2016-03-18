<?php
session_start();
$id = $_GET[id];
$output_mode = $_GET[output_mode];
$output_ok = $_GET[output_ok];
$lingua = $_SESSION[lang];
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
/*function tratta($stringa) {

$stringa = str_replace("%20"," ",$stringa);
$stringa = str_replace("%C3%A0","a'",$stringa);
$stringa = str_replace("%C3%B2","o'",$stringa);
$stringa = str_replace("%C3%A8","e'",$stringa);
$stringa = str_replace("%C3%A9","e'",$stringa);
$stringa = str_replace("%C3%AC","i'",$stringa);
$stringa = str_replace("%C3%B9","u'",$stringa);
$stringa = str_replace("%C2%B0","o.",$stringa);
$stringa = addslashes($stringa);
return $stringa;
}
*/
function accentate_mod($stringa) {
$stringa = str_replace("É","E_",$stringa);
$stringa = str_replace("È","E_",$stringa);
$stringa = str_replace("Ì","I_",$stringa);
$stringa = str_replace("Í","I_",$stringa);
$stringa = str_replace("Ò","O_",$stringa);
$stringa = str_replace("Ó","O_",$stringa);
$stringa = str_replace("Ù","U_",$stringa);
$stringa = str_replace("Ú","U_",$stringa);
$stringa = str_replace("À","A_",$stringa);
$stringa = str_replace("Á","A_",$stringa);
$stringa = str_replace("è","e_",$stringa);
$stringa = str_replace("é","e_",$stringa);
$stringa = str_replace("à","a_",$stringa);
$stringa = str_replace("á","a_",$stringa);
$stringa = str_replace("ò","o_",$stringa);
$stringa = str_replace("ó","o_",$stringa);
$stringa = str_replace("ì","i_",$stringa);
$stringa = str_replace("í","i_",$stringa);
$stringa = str_replace("ù","u_",$stringa);
$stringa = str_replace("ú","u_",$stringa);
$stringa = str_replace("°","_",$stringa);
$stringa = str_replace("ž","z",$stringa);
return $stringa;
}

//$lingua = $_SESSION[lang];
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
$id_utente = $_SESSION[user_id];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$queryd = "SELECT * FROM qui_files_sap ORDER BY id DESC LIMIT 1";
$resultd = mysql_query($queryd) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowd = mysql_fetch_array($resultd)) {
$progressivo = str_pad(($rowd[id]+1), 5, "0", STR_PAD_LEFT);
$progressivo_nozeri = $rowd[id]+1;
}
$data_attuale = mktime();
//$queryb = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$queryb = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND output_mode = ''";
$resultb = mysql_query($queryb);
$num_righe_totali = mysql_num_rows($resultb);
//$querya = "SELECT * FROM qui_righe_rda WHERE stato_ordine != '4' AND id_rda = '$id' AND flag_buyer = '1'";
$querya = "SELECT * FROM qui_righe_rda WHERE stato_ordine != '4' AND id_rda = '$id' AND flag_buyer = '1' AND output_mode = ''";
$result = mysql_query($querya);
$num_righe_processare = mysql_num_rows($result);
$array_righe_modif = array();
while ($rigaa = mysql_fetch_array($result)) {
$add_riga = array_push($array_righe_modif,$rigaa[id]);
}
$queryc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '3'";
$resultc = mysql_query($queryc);
$num_righe_gia_processate = mysql_num_rows($resultc);
if (($num_righe_totali-($num_righe_gia_processate+$num_righe_processare)) > 0) {
$stato_generale_rda = "3";
} else {
$stato_generale_rda = "4";
}
//echo "stato_generale_rda: ".$stato_generale_rda."<br>";

$data_attuale = mktime();
$dir_rda=leggifile("config/sap_path.txt");
//$dir_rda="rda/";
//recupero dati rda
$sqleee = "SELECT * FROM qui_rda WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$id_rda = $rigaeee[id];
$id_utente_rda = $rigaeee[id_utente];
$nome_utente_rda = accentate_mod($rigaeee[nome_utente]);
$negozio_rda = $rigaeee[negozio];
$wbs = $rigaeee[wbs];
$id_resp_rda = $rigaeee[id_resp];
$buyer_chiusura = $rigaeee[buyer_chiusura];
$data_inserimento = $rigaeee[data_inserimento];
$data_approvazione = $rigaeee[data_approvazione];
$data_chiusura = $rigaeee[data_chiusura];
$data_ultima_modifica = $rigaeee[data_ultima_modifica];
}

//recupero dati utente rda
$sqlr = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente_rda'";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
$idunita = $rigar[idunita];
$indirizzo = accentate_mod($rigar[indirizzo]);
$cap = $rigar[cap];
$localita = accentate_mod($rigar[localita]);
$nazione = $rigar[nazione];
$company = $rigar[company];
}


switch ($negozio_rda) {
case "assets":
$tipo_rda = "V";
break;
case "consumabili":
$tipo_rda = "C";
break;
case "labels":
$tipo_rda = "C";
break;
case "spare_parts":
$tipo_rda = "C";
break;
case "vivistore":
$tipo_rda = "C";
break;
}

    $sap_record = '';

//HEADER 
$sap_record .= "A";


//DATA generazione file SAP
$data_attuale = date("YmdHis",mktime());
$sap_record .= $data_attuale;


//CODICE FLUSSO
$sap_record .= "INTFI004";


//PROGR. ESTRAZIONE
$sap_record .= str_pad($progressivo, 10, "0", STR_PAD_LEFT);



//FINE RECORD
$sap_record = str_pad($sap_record, 177, " ", STR_PAD_RIGHT)."$#\r\n";
//$sap_record = str_pad($sap_record, 177, " ", STR_PAD_RIGHT)."$#\n";


//FINE TESTATA


//INIZIO ARTICOLI
//$queryb = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY id ASC";
$queryb = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND output_mode = '' ORDER BY id ASC";
$resultb = mysql_query($queryb);
$num_righe_totali = mysql_num_rows($resultb);
$conta_righe = 1;
//$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '1' ORDER BY id ASC";
$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '1' AND output_mode = '' ORDER BY id ASC";

$result = mysql_query($querya);
$num_righe_processa = mysql_num_rows($result);
while ($row = mysql_fetch_array($result)) {
$id_prod = $row[id_prodotto];
$quant = $row[quant];


//recupero dati prodotto

$queryb = "SELECT * FROM qui_prodotti_".$negozio_rda." WHERE id = '$id_prod'";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$codice_art = $rowb[codice_art];
$gruppo_merci = $rowb[gruppo_merci];
$prezzo_unitario = $rowb[prezzo];
$giacenza = $rowb[giacenza];
switch($lingua) {
case "it":
$descrizione_art_orig = $rowb[descrizione1_it];
break;
case "en":
$descrizione_art_orig = $rowb[descrizione1_en];
break;
case "fr":
$descrizione_art_orig = $rowb[descrizione_fr];
break;
case "de":
$descrizione_art_orig = $rowb[descrizione_de];
break;
case "es":
$descrizione_art_orig = $rowb[descrizione_es];
break;
}
}
$nuova_giacenza = $giacenza-$quant;
//AGGIORNAMENTO QUANTITA' PER SCARICO MAGAZZINO
$sqlk = "UPDATE qui_prodotti_".$negozio_rda." SET giacenza = '$nuova_giacenza' WHERE id = '$id_prod'";
if (mysql_query($sqlk)) {
} else {
echo "Errore durante l'inserimento4: ".mysql_error();
}

if ($negozio_rda == "labels") {
$descrizione_art_orig = $row[descrizione];
}
//trasformazione delle accentate
$descrizione_art = accentate_mod($descrizione_art_orig);

$descrizione_art = stripslashes($descrizione_art);
/*$descrizione_art = str_replace("°","o.",$descrizione_art);
$descrizione_art = str_replace("Ã","à",$descrizione_art);
$descrizione_art_codif = rawurlencode($descrizione_art);
$descrizione_art_codif = accentate_mod($descrizione_art_codif);
$descrizione_art = urldecode($descrizione_art_codif);
*/

//ID_RECORD
$articolo .= "1";

//ID_RDA
$articolo .= $tipo_rda;

//BANFN
$articolo .= str_pad($progressivo, 10, "0", STR_PAD_LEFT);

//BNFPO

//5 spazi blank
$articolo .= "     ";

//EKGRP
$articolo .= "T10";





//AFNAM
$articolo .= str_pad(substr(str_replace(" ","",$nome_utente_rda),0,12),12," ", STR_PAD_LEFT);

//BEDNR
$articolo .= str_pad($codice_art, 10, "0", STR_PAD_LEFT);

//BADAT
$data_richiesta = date("Ymd",mktime());
$articolo .= $data_richiesta;

//TXZ01
$articolo .= str_pad(substr($descrizione_art,0,40), 40, " ", STR_PAD_RIGHT);

//WERKS
$articolo .= str_pad($company, 4, "0", STR_PAD_LEFT);

//MATKL
$articolo .= str_pad($gruppo_merci, 9, " ", STR_PAD_RIGHT);

//MENGE
$pezzi_quant = explode(".",$quant);

//aggiungo la parte intera della quantità con n zeri a sinistra per arrivare a 10 caratteri, e la parte decimale con n zeri a destra per arrivare a 3 caratteri
$articolo .= str_pad($pezzi_quant[0], 10, "0", STR_PAD_LEFT).str_pad($pezzi_quant[1], 3, "0", STR_PAD_RIGHT);

//MEINS
$articolo .= "PAC";

//LFDAT
$articolo .= $data_richiesta;

//PREIS
$pezzi_prezzo = explode(".",$prezzo_unitario);

//aggiungo la parte intera del prezzo con n zeri a sinistra per arrivare a 8 caratteri, e la parte decimale con n zeri a destra per arrivare a 5 caratteri
$articolo .= str_pad($pezzi_prezzo[0], 8, "0", STR_PAD_LEFT).str_pad($pezzi_prezzo[1], 5, "0", STR_PAD_RIGHT);

if ($negozio_rda == "assets") {
$articolo .=  "WBS".str_pad($wbs, 9, "0", STR_PAD_LEFT);
}

//FINE RECORD
$articolo = str_pad($articolo, 177, " ", STR_PAD_RIGHT);
$contalettere = strlen($articolo);
//echo "contalettere: ".$contalettere."<br>";
$articolo .= "$#\r\n";
//$articolo = str_pad($articolo, 177, " ", STR_PAD_RIGHT)."$#\n";

//accodo al blocco da scrivere nel file la riga dell'articolo
$sap_record .= $articolo;
$articolo = "";

if ($conta_righe == 1) {
//solo dopo la prima riga della rda aggiungere 2 righe inizianti con il 2 contenenti
// la prima B01 / nome dell'utente per esteso


//ID_RECORD
$riga_nome .= "2";

//ID_RDA
$riga_nome .= $tipo_rda;

//BANFN
$riga_nome .= str_pad($progressivo, 10, "0", STR_PAD_LEFT);

//BNFPO

//5 spazi blank
$riga_nome .= "     ";

//TEXT_ID
$riga_nome .= "B01";

//TEXT_FORM
$riga_nome .= " / ";

//TEXT_LINE
$riga_nome .= $nome_utente_rda;

//FINE RECORD
$riga_nome = str_pad($riga_nome, 177, " ", STR_PAD_RIGHT)."$#\r\n";
//$riga_nome = str_pad($riga_nome, 177, " ", STR_PAD_RIGHT)."$#\n";



//accodo al blocco da scrivere nel file la riga del nome (B01)
$sap_record .= $riga_nome;
$riga_nome = "";


// la seconda B01 / nome dell'utente per esteso

//ID_RECORD
$riga_indirizzo .= "2";

//ID_RDA
$riga_indirizzo .= $tipo_rda;

//BANFN
$riga_indirizzo .= str_pad($progressivo, 10, "0", STR_PAD_LEFT);

//BNFPO

//5 spazi blank
$riga_indirizzo .= "     ";

//TEXT_ID
$riga_indirizzo .= "B03";

//TEXT_FORM
$riga_indirizzo .= " / ";

//TEXT_LINE
$riga_indirizzo .= $indirizzo.", ".$cap.", ".$localita.", ".$nazione." - ".str_pad($id_rda, 10, "0", STR_PAD_LEFT);

//FINE RECORD
$riga_indirizzo = str_pad($riga_indirizzo, 177, " ", STR_PAD_RIGHT)."$#\r\n";
//$riga_indirizzo2 = str_pad($riga_indirizzo, 177, " ", STR_PAD_RIGHT)."$#\n";

//accodo al blocco da scrivere nel file la riga dell'indirizzo (B03)
$sap_record .= $riga_indirizzo;
$riga_indirizzo = "";
}

$conta_righe = $conta_righe + 1;

//fine while righe rda
}

//FINE_RECORD
$finale .= "Z";
$finale = str_pad($finale, 177, " ", STR_PAD_RIGHT)."$#\r\n";
//$finale = str_pad($finale, 177, " ", STR_PAD_RIGHT)."$#\n";
$sap_record .= $finale;
$finale = "";

$conta_righe = "";

//$sap_record = htmlentities($sap_record, ENT_QUOTES, 'utf-8');
//$sap_record = html_entity_decode($sap_record, ENT_QUOTES , 'Windows-1252');
//******************************

//SCRITTURA FILE PER SAP

//*****************************
$file_corpo = $dir_rda."MMI004".$tipo_rda."_".$progressivo_nozeri.".txt";
//$file_corpo = $dir_rda."MMI004".$tipo_rda."_".$id."_".$progressivo_nozeri.".txt";

/*$files_sap_esistenti=elencafiles($dir_rda);
foreach ($files_sap_esistenti as $sing_file) {
$pos = strpos($sing_file, ".txt");
if ($pos === false) {
} else {
    if (substr($sing_file,0,$pos) == $id_rda) {
	$casuale = rand(100,200);
$file_corpo = $dir_rda.$id_rda."-".$casuale.".txt";
	} else {
	} 
}
}
*/
$fg = fopen($file_corpo, 'w') or die("can't open file");
fwrite($fg, $sap_record);
fclose($fg);
$sap_record = "";
$data_adesso = mktime();
$querys = "INSERT INTO qui_files_sap (nome_file, data_file, id_rda) VALUES ('$file_corpo', '$data_adesso', '$id')";
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
foreach ($array_righe_modif as $ogni_riga) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '2', output_mode = '$output_mode', stato_ordine = '4', data_ultima_modifica = '$data_adesso' WHERE id = '$ogni_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
$data_odierna = mktime();

//*********************
//versione precedente, con chiusura automatica della rda quando tutte le righe sono state processate e hanno il valore 4
//$query = "UPDATE qui_rda SET stato = '$stato_generale_rda', data_output = '$data_odierna', data_chiusura = '$data_odierna', buyer_output = '$id_utente', output_mode = '$output_mode' WHERE id = '$id'";
//*********************

$query = "UPDATE qui_rda SET stato = '4', data_output = '$data_odierna', buyer_output = '$id_utente', output_mode = '$output_mode' WHERE id = '$id'";
//echo "queri di modifica: ".$query."<br>";
if (mysql_query($query)) {
//echo "rda modificata correttamente";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
/*if ($stato_generale_rda == "4") {
$queryg = "UPDATE qui_righe_rda SET stato_ordine = '4' WHERE id_rda = '$id'";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
*/

$riepilogo = "Output rda (".$id_rda.") su ".$output_mode." - utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
echo "<div id=pop_container>";
  echo "<div align=center style=\"font-family:Arial;color: #FF0000;font-weight: bold;font-size: 16px;text-align:center;\">".$file_sap;
  echo "</div>";
echo "</div>";
echo "<div id=pop_container>";
  echo "<div align=center>";
//  echo "<input type=button name=button id=button onClick=\"window.close()\" value=OK>";
  echo "</div>";
echo "</div>";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
<!--window.opener.location.href+'#<?php echo $id_prod; ?>'
  if (window.opener.progressWindow)
 {
    window.opener.progressWindow.close()
  }
window.close();
}
</script>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<!--<body onUnload="remote2('ricerca_prodotti.php#<? echo $id_prod; ?>')">-->
<body onUnload="refreshParent()">
</body>
</html>

