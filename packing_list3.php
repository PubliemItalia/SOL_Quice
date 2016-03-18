<?php
session_start();
function tratta($stringa) {
$stringa = str_replace("Ã¨","è",$stringa);
$stringa = str_replace("é","e",$stringa);
$stringa = str_replace("ì","i",$stringa);
$stringa = str_replace("ò","o",$stringa);
$stringa = str_replace("ù","u",$stringa);
$stringa = str_replace("Ã","à",$stringa);
$stringa = stripslashes($stringa);
$stringa = str_replace("\n"," ",$stringa);
$stringa = str_replace("\r"," ",$stringa);
$stringa = str_replace("\p"," ",$stringa);
return $stringa;
}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$flusso_mag = $_SESSION[flusso];
if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
}
if ($_GET[n_pl] != "") {
$n_pl = $_GET[n_pl];
} else {
$n_pl = $_POST[n_pl];
}
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}
if ($_GET[temp_pl] != "") {
$temp_pl = $_GET[temp_pl];
} else {
$temp_pl = $_POST[temp_pl];
}
if ($_GET[behav] != "") {
$behav = $_GET[behav];
} else {
$behav = $_POST[behav];
}
if ($_GET[vettore] != "") {
$vettore = $_GET[vettore];
} else {
$vettore = $_POST[vettore];
}
if ($_GET[colli] != "") {
$colli = $_GET[colli];
} else {
$colli = $_POST[colli];
}
if ($_GET[peso] != "") {
$peso = $_GET[peso];
} else {
$peso = $_POST[peso];
}
if ($_GET[misure] != "") {
$misure = $_GET[misure];
} else {
$misure = $_POST[misure];
}

if ($_GET[aggiorna_dati_pack] != "") {
$aggiorna_dati_pack = $_GET[aggiorna_dati_pack];
} else {
$aggiorna_dati_pack = $_POST[aggiorna_dati_pack];
}
if ($_GET[aggiorna_visualizza] != "") {
$aggiorna_visualizza = $_GET[aggiorna_visualizza];
} else {
$aggiorna_visualizza = $_POST[aggiorna_visualizza];
}

$id_rda = $_GET['id_rda'];
$id_magazz = $_GET['id_utente'];

switch($lingua) {
case "it":
$bottone_stampa = "btn_green_freccia_stampa_ita.png";
$bottone_chiudi = "btn_green_freccia_chiudi_ita.png";
break;
case "en":
$bottone_stampa = "btn_green_freccia_stampa_eng.png";
$bottone_chiudi = "btn_green_freccia_chiudi_eng.png";
break;
}


if ($mode == "nuovo") {
  $array_pl = array();
  $array_rda = array();
  $array_units = array();
  $array_aziende_fatt = array();
  switch($behav) {
	  default:
		$sqlc = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '3' AND output_mode = '".$flusso_mag."' AND evaso_magazzino = '0'";
		$tipo_pl = $flusso_mag;
	  break;
	  case "publiem":
		$sqlc = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '3' AND output_mode = 'lab' AND evaso_magazzino = '0'";
		$tipo_pl = "lab";
	  break;
  }
  $risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
  while ($rowc = mysql_fetch_array($risultc)) {
  //echo 'aggiungo unit: '.$rowc[id_unita].'<br>';
	  if (!in_array($rowc[id_rda],$array_rda)) {
		  $addRda = array_push($array_rda,$rowc[id_rda]);
	  }
	  if (!in_array($rowc[id_unita],$array_units)) {
		  $addUnit = array_push($array_units,$rowc[id_unita]);
	  }
	  if (!in_array($rowc[dest_contab],$array_aziende_fatt)) {
		$addRda1 = array_push($array_aziende_fatt,$rowc[dest_contab]);
	  }
  }
  //echo '<span style="color: #000;">unit&agrave;: ';
  //print_r($array_units);
  //echo '</span><br>';
if (count($array_units) > 1) {
	echo "<div style=\"width:360; text-align:center; height:100; padding-top:50px; margin:auto; font-family: Arial; color: red; font-size: 16px; font-weight: bold;\">";
	echo "Non &egrave; consentito generare un Packing List<br>a partire da RdA che fanno capo<br>a unit&agrave; diverse.<br>RrA selezionate:<strong>";
	foreach ($array_rda as $ogni_sing_rda) {
		echo $ogni_sing_rda.", ";
	}
	echo "</strong></div>";
	exit;
} else {
	
	
//qui sotto c'è un ciclo foreach che serve a raccogliere le informazioni delle RdA coinvolte nel PL che si deve generare
//siccome le note possono essere diverse, allora le raccolgo tutte differenziandole con il numero di RdA di appartenenza
//mentre l'unità (che deve essere la stessa - vedi l'if qui sopra) serve una volta sola, per cui utilizzo il contatore $a
//subito nella riga successiva e compongo la variabile $blocco_note solo se il contatore è == 1 (in sostanza la prima delle RdA determina l'unità)
//inoltre si aggiunge il controllo a livello di fatturazione
$a = 1;
foreach($array_rda as $sing_rda) {
  //per ogni rda devo raccogliere le note in modo tale da averle tutte raggruppate
  $lista_rda .= $sing_rda.", ";

  $sqlc = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigac = mysql_fetch_array($risultc)) {
	if ($rigac[note_utente] != "") {
	  $blocco_note .= "<strong>RdA ".$sing_rda."<br>Note utente</strong> ".addslashes($rigac[note_utente])."<br>";
	}
	if ($rigac[note_resp] != "") {
	  $blocco_note .= "<strong>Note responsabile</strong> ".addslashes($rigac[note_resp])."<br>";
	}
	if ($rigac[note_buyer] != "") {
	  $blocco_note .= "<strong>Note buyer</strong> ".addslashes($rigac[note_buyer])."<br>";
	}
	if ($rigac[note_magazziniere] != "") {
	  $blocco_note .= "<strong>Note magazziniere</strong> ".addslashes($rigac[note_magazziniere])."<br><br>";
	}
	if ($rigac[indirizzo_spedizione] != "") {
	  $nome_unita = $rigac[indirizzo_spedizione];
	} else {
	  if ($a == 1) {
		$sqld = "SELECT * FROM qui_utenti WHERE user_id = '$rigac[id_utente]'";
		$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigad = mysql_fetch_array($risultd)) {
		  $nome_utente = $rigad[nome];
		  $unit_name = $rigad[nomeunita];
		  $nome_unita .= "<strong>".addslashes($rigad[companyName])."<br>(";
		  $nome_unita .= addslashes($rigad[nomeunita]).")</strong><br>";
		  $nome_unita .= addslashes($rigad[indirizzo])."<br>";
		  $nome_unita .= $rigad[cap]." ";
		  $nome_unita .= addslashes($rigad[localita])."<br>";
		  $nome_unita .= addslashes($rigad[nazione]);
		  $id_unita = $rigad[idunita];
		//fine while qui_utenti
		}
	  //fine if ($a == 1)
	  }
	}
	  //fine while qui_rda
  }
  $a = $a+1;
//fine foreach $array_rda as $sing_rda
}

//generazione packing list (uno per tipologia di ambito fatturazione) (teoricamente potrebbero essere anche più di uno a seconda se ci sono prodotti vivisol, e sol coesistenti nella stessa rda)
//proprio per questo ciò che viene generato non è una variabile singola con un numero di PL, ma un array che potrebbe avere un valore se RdA tutta sol o tutta vivisol, due valori se RdA mista
foreach($array_aziende_fatt as $sing_fatt) {
	$discr_sing_fatt = substr($sing_fatt,1);
	switch ($discr_sing_fatt) { 
	  default:
		$logo = "sol";
	  break;
	  case "SOLSPA":
		$logo = "sol";
	  break;
	  case "VIVISOL":
		$logo = "vivisol";
	  break;
	}

$timestamp_attuale = time();
$queryss = "INSERT INTO qui_packing_list_temp (indirizzo_spedizione, utente, responsabile, vettore, magazziniere, peso, colli, misure, data_spedizione, note, logo, dest_contab, id_unita, nome_unita) VALUES ('$nome_unita', '$utente_rda', '$resp_rda', '$indirizzo_vettore', '$_SESSION[nome]', '$peso', '$colli', '$misure', '$timestamp_attuale', '$blocco_note', '$logo', '$sing_fatt', '$id_unita', '$unit_name')";
if (mysql_query($queryss)) {
} else {
echo "Errore durante l'inserimento1". mysql_error();
}
$sqld = "SELECT * FROM qui_packing_list_temp ORDER BY id DESC LIMIT 1";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$add_pl = array_push($array_pl,$rigad[id]);
$n_pl = $rigad[id];
}

$array_mail = array();
$datalog = mktime();
switch($behav) {
	default:
	  $discr = $flusso_mag;
	  //pl fatti da Gaiani o magazzinieri bmc: vengono chiusi e resi fatturabili immediatamente
	break;
	case "publiem":
	  $discr = "lab";
	break;
}
	  $query = "UPDATE qui_righe_rda SET vecchio_codice = '$n_pl' WHERE flag_buyer = '3' AND output_mode = '".$discr."' AND evaso_magazzino = '0' AND dest_contab = '$sing_fatt'";
//$query = "UPDATE qui_righe_rda SET pack_list = '$n_pl' WHERE id_rda = '$id_rda' AND flag_buyer = '3' AND output_mode = 'mag'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento3: ".mysql_error();
}
//fine foreach($array_aziende_fatt  PER PRODUZIONE DUE PACKING LIST
}
foreach($array_pl as $sing_pl) {
$lista_pl_sessione .= $sing_pl.'-';
}
$_SESSION["lista_pl"] = $lista_pl_sessione;
//fine if count(array_units) > 1
}
//fine if mode = nuovo
}
//echo '<span style="color: #000;">Pl n.'.$n_pl.'</span>';

if ($mode == "vis") {
  $array_pl = array();
  $array_rda = array();
  $array_units = array();
  $array_aziende_fatt = array();
switch($behav) {
	default:
	  $tipo_pl = $flusso_mag;
	break;
	case "publiem":
	  $tipo_pl = "lab";
	break;
}
	  $sqlc = "SELECT * FROM qui_righe_rda WHERE vecchio_codice = '$temp_pl' AND output_mode = '$tipo_pl' AND evaso_magazzino = '0'";
  $risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
  while ($rowc = mysql_fetch_array($risultc)) {
  //echo 'aggiungo unit: '.$rowc[id_unita].'<br>';
	  if (!in_array($rowc[id_rda],$array_rda)) {
		  $addRda = array_push($array_rda,$rowc[id_rda]);
	  }
	  if (!in_array($rowc[id_unita],$array_units)) {
		  $addUnit = array_push($array_units,$rowc[id_unita]);
	  }
	  if (!in_array($rowc[dest_contab],$array_aziende_fatt)) {
	  $addRda1 = array_push($array_aziende_fatt,$rowc[dest_contab]);
	  }
  }
  //echo 'unit&agrave;: ';
  //print_r($array_units);
  //echo '<br>';
if (count($array_units) > 1) {
	echo "<div style=\"width:360; text-align:center; height:100; padding-top:50px; margin:auto; font-family: Arial; color: red; font-size: 16px; font-weight: bold;\">";
	echo "Non &egrave; consentito generare un Packing List<br>a partire da RdA che fanno capo<br>a unit&agrave; diverse.";
	echo "</div>";
	exit;
} else {
	
	
//qui sotto c'è un ciclo foreach che serve a raccogliere le informazioni delle RdA coinvolte nel PL che si deve generare
//siccome le note possono essere diverse, allora le raccolgo tutte differenziandole con il numero di RdA di appartenenza
//mentre l'unità (che deve essere la stessa - vedi l'if qui sopra) serve una volta sola, per cui utilizzo il contatore $a
//subito nella riga successiva e compongo la variabile $blocco_note solo se il contatore è == 1 (in sostanza la prima delle RdA determina l'unità)
//inoltre si aggiunge il controllo a livello di fatturazione
$a = 1;
foreach($array_rda as $sing_rda) {
  //per ogni rda devo raccogliere le note in modo tale da averle tutte raggruppate
  $lista_rda .= $sing_rda.", ";

  $sqlc = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigac = mysql_fetch_array($risultc)) {
	if ($rigac[note_utente] != "") {
	  $blocco_note .= "<strong>RdA ".$sing_rda."<br>Note utente</strong> ".addslashes($rigac[note_utente])."<br>";
	}
	if ($rigac[note_resp] != "") {
	  $blocco_note .= "<strong>Note responsabile</strong> ".addslashes($rigac[note_resp])."<br>";
	}
	if ($rigac[note_buyer] != "") {
	  $blocco_note .= "<strong>Note buyer</strong> ".addslashes($rigac[note_buyer])."<br>";
	}
	if ($rigac[note_magazziniere] != "") {
	  $blocco_note .= "<strong>Note magazziniere</strong> ".addslashes($rigac[note_magazziniere])."<br><br>";
	}
	if ($rigac[indirizzo_spedizione] != "") {
	  $nome_unita = $rigac[indirizzo_spedizione];
	} else {
	  if ($a == 1) {
		$sqld = "SELECT * FROM qui_utenti WHERE user_id = '$rigac[id_utente]'";
		$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigad = mysql_fetch_array($risultd)) {
		  $nome_utente = $rigad[nome];
		  $unit_name = $rigad[nomeunita];
		  $nome_unita .= "<strong>".addslashes($rigad[companyName])."<br>(";
		  $nome_unita .= addslashes($rigad[nomeunita]).")</strong><br>";
		  $nome_unita .= addslashes($rigad[indirizzo])."<br>";
		  $nome_unita .= $rigad[cap]." ";
		  $nome_unita .= addslashes($rigad[localita])."<br>";
		  $nome_unita .= addslashes($rigad[nazione]);
		  $id_unita = $rigad[idunita];
		//fine while qui_utenti
		}
	  //fine if ($a == 1)
	  }
	}
	
  //fine while qui_rda
  }
  $a = $a+1;
//fine foreach $array_rda as $sing_rda
}
/*
//AGGIORNAMENTO QUANTITA' PER SCARICO MAGAZZINO
//$sqlc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND flag_buyer = '3' AND output_mode = 'mag'";
switch($behav) {
	default:
	  $sqlc = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '3' AND output_mode = 'mag' AND evaso_magazzino = '0'";
	break;
	case "publiem":
	  $sqlc = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '3' AND output_mode = 'lab' AND evaso_magazzino = '0'";
	break;
}
$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowc = mysql_fetch_array($risultc)) {
  $quant_giac = $rowc[quant];
  $sqlb = "SELECT * FROM qui_prodotti_".$rowc[negozio]." WHERE codice_art = '$rowc[codice_art]'";
  $risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
  while ($rowb = mysql_fetch_array($risultb)) {
	$giacenza = $rowb[giacenza];
  }
//switch($behav) {
	//default:
	  $nuova_giacenza = $giacenza-$rowc[quant];
	  $sqlk = "UPDATE qui_prodotti_".$rowc[negozio]." SET giacenza = '$nuova_giacenza' WHERE codice_art = '$rowc[codice_art]'";
	  if (mysql_query($sqlk)) {
	  } else {
		echo "Errore durante l'inserimento4: ".mysql_error();
	  }
	//break;
	//case "publiem":
	//break;
//}
  $nuova_giacenza = "";
  $giacenza = "";
}
//FINE AGGIORNAMENTO QUANTITA' PER SCARICO MAGAZZINO
*/
//generazione packing list (uno per tipologia di ambito fatturazione) (teoricamente potrebbero essere anche più di uno a seconda se ci sono prodotti vivisol, e sol coesistenti nella stessa rda)
//proprio per questo ciò che viene generato non è una variabile singola con un numero di PL, ma un array che potrebbe avere un valore se RdA tutta sol o tutta vivisol, due valori se RdA mista
foreach($array_aziende_fatt as $sing_fatt) {
	$discr_sing_fatt = substr($sing_fatt,1);
	switch ($discr_sing_fatt) { 
	  default:
		$logo = "sol";
	  break;
	  case "SOLSPA":
		$logo = "sol";
	  break;
	  case "VIVISOL":
		$logo = "vivisol";
	  break;
	}
$queryv = "SELECT * FROM qui_vettori WHERE id = '$vettore'";
$resultv = mysql_query($queryv);
while ($rowv = mysql_fetch_array($resultv)) {
$indirizzo_vettore = $rowv[indirizzo_vettore];
}

$timestamp_attuale = time();
$queryss = "INSERT INTO qui_packing_list (indirizzo_spedizione, utente, responsabile, id_vettore, vettore, magazziniere, peso, colli, misure, data_spedizione, note, logo, dest_contab, id_unita, nome_unita) VALUES ('$nome_unita', '$utente_rda', '$resp_rda', '$vettore', '$indirizzo_vettore', '$_SESSION[nome]', '$peso', '$colli', '$misure', '$timestamp_attuale', '$blocco_note', '$logo', '$sing_fatt', '$id_unita', '$unit_name')";
if (mysql_query($queryss)) {
} else {
echo "Errore durante l'inserimento1". mysql_error();
}
$sqld = "SELECT * FROM qui_packing_list ORDER BY id DESC LIMIT 1";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$add_pl = array_push($array_pl,$rigad[id]);
$n_pl = $rigad[id];
}
foreach($array_rda as $sing_rda) {
	$lista_rda_pl .= '-'.$sing_rda;
	$queryss = "INSERT INTO qui_corrispondenze_pl_rda (pl,rda) VALUES ('$n_pl', '$sing_rda')";
	if (mysql_query($queryss)) {
	} else {
	  echo "Errore durante l'inserimento1". mysql_error();
	}
}
$queryb = "UPDATE qui_packing_list SET rda = '$lista_rda_pl' WHERE id = '$n_pl'";
  if (mysql_query($queryb)) {
  } else {
  echo "Errore durante l'inserimento2: ".mysql_error();
  }

$array_mail = array();
$datalog = mktime();
switch($behav) {
	default:
	  $discr = $flusso_mag;
	  //pl fatti da Gaiani o magazzinieri bmc: vengono chiusi e resi fatturabili immediatamente
	  $query = "UPDATE qui_righe_rda SET pack_list = '$n_pl', evaso_magazzino = '1', flag_buyer = '2', stato_ordine = '4', flag_chiusura = '1', data_ultima_modifica = '$datalog', data_chiusura = '$datalog' WHERE flag_buyer = '3' AND output_mode = '".$discr."' AND evaso_magazzino = '0' AND dest_contab = '$sing_fatt'";
	break;
	case "publiem":
	  $discr = "lab";
	  $negozio = "labels";
	  $sqlps = "SELECT * FROM qui_indirizzi_avviso WHERE codice_attivita = '$discr' ORDER BY id ASC";
	  $risultps = mysql_query($sqlps) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaps = mysql_fetch_array($risultps)) {
		$add_mail = array_push($array_mail,$rigaps[mail]);
	  }
	  include "spedizione_mail_avviso.php";
	  //pl fatti da noi: viene aggiornato solo il campo evaso_magazzino per non essere visibili alla fatturazione
	  $query = "UPDATE qui_righe_rda SET pack_list = '$n_pl', evaso_magazzino = '1', flag_buyer = '2', data_ultima_modifica = '$datalog' WHERE flag_buyer = '3' AND output_mode = '".$discr."' AND evaso_magazzino = '0' AND dest_contab = '$sing_fatt'";
	break;
}
//$query = "UPDATE qui_righe_rda SET pack_list = '$n_pl' WHERE id_rda = '$id_rda' AND flag_buyer = '3' AND output_mode = '$flusso_mag'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento3: ".mysql_error();
}
//**********************************
//CHIUSURA RDA ANCORA APERTE SE TUTTE LE RIGHE SONO A STATO 4
foreach($array_rda as $ogni_rda) {
  $sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$ogni_rda'";
  $risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_tot_righe_rda = mysql_num_rows($risultk);
  while ($rigak = mysql_fetch_array($risultk)) {
	  if ($rigak[stato_ordine] == 4) {
		  $righe_evase = $righe_evase + 1;
	  }
  }
  if ($righe_evase == $num_tot_righe_rda) {
	  $queryf = "UPDATE qui_rda SET stato = '4', data_chiusura = '$datalog', data_ultima_modifica = '$datalog' WHERE id = '$ogni_rda'";
	  if (mysql_query($queryf)) {
	  } else {
	  echo "Errore durante l'inserimento3: ".mysql_error();
	  }
  }
}
$riepilogo = "inserimento nuovo packing list (".$n_pl.") relativo a rda (".$lista_rda.") da magazziniere ".$_SESSION[nome];
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'packing_list', '$n_pl', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento4". mysql_error();
}

//fine foreach($array_aziende_fatt  PER PRODUZIONE DUE PACKING LIST
}
foreach($array_pl as $sing_pl) {
$lista_pl_sessione .= $sing_pl.'-';
}
$_SESSION["lista_pl"] = $lista_pl_sessione;
//fine if count(array_units) > 1
}
//fine if mode = vis
}

$timestamp_attuale = time();
$dataora_attuali = date("d.m.Y H:i",$timestamp_attuale);

$queryv = "SELECT * FROM qui_vettori WHERE id = '$vettore'";
$resultv = mysql_query($queryv);
while ($rowv = mysql_fetch_array($resultv)) {
$indirizzo_vettore = $rowv[indirizzo_vettore];
}
if (($mode == "print") AND ($aggiorna_dati_pack == "1")) {
$query = "UPDATE qui_packing_list SET peso = '$peso', colli = '$colli', id_vettore = '$vettore', vettore = '$indirizzo_vettore', magazziniere = '$_SESSION[nome]', data_spedizione = '$timestamp_attuale', data_chiusura = '$timestamp_attuale' WHERE id = '$n_pl'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}
}
if (($mode == "print") AND ($aggiorna_visualizza == "1")) {
switch($behav) {
	default:
	  $check = "1";
	break;
	case "publiem":
	  $check = "0";
	break;
}
$query = "UPDATE qui_packing_list SET peso = '$peso', colli = '$colli', id_vettore = '$vettore', vettore = '$indirizzo_vettore', magazziniere = '$_SESSION[nome]', check_completato = '".$check."' WHERE id = '$n_pl'";
if (mysql_query($query)) {
$riepilogo = "modifica colli e peso packing list (".$n_pl.") da magazziniere ".$_SESSION[nome];
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'packing_list', '$n_pl', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento6". mysql_error();
}
} else {
echo "Errore durante l'inserimento7: ".mysql_error();
}
}
/*
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/report.css" />
<link rel=”stylesheet” href=”css/video.css” type=”text/css” media=”screen” />
<link rel=”stylesheet” href=”css/printer.css” type=”text/css” media=”print” />
<title>Packing List</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#lingua_scheda {
	width:100%;
	margin: auto;
	background-color: #727272;
	margin-bottom: 10px;
	color: #FFFFFF;
	height: 40px;
	text-align: right;
	padding-topt: 5px;
	padding-right: 5px;
	vertical-align: middle;
	font-weight: bold;
}
#lingua_scheda a {
	color: #FFFFFF;
}
#main_container {
/*		background-size: cover;
		padding-top: 57px;
		padding-left: 119px;
		padding-right: 60px;
		padding-bottom: 138px;
		width: 577px;
		height: 874px;
*/
		page-break-after: avoid;
		page-break-before:avoid;
		page-break-inside: auto;
		width: 750px;
		height: 1069px;
}
.immpiede {
	width:100%; height:100px;
}
.superiore {
	width: 100%; height: 969px;
}
#order_container {
	width:637px;
	height:750px;
	margin: auto;
}
.testata_logo {
	width:310px;
	padding-left:25px;
	height: 90px;
	float:left;
	text-align: left;
}
.testata_testo {
	width:300px;
	height: 90px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.riga_divisoria {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-align:left;
	width:590px;
	min-height: 23px;
	overflow:hidden;
	height:auto;
	margin-left:119px;
	margin-right:60px;
	/*border-top:1px solid #CCC;*/
	border-bottom:1px solid #CCC;
	float:left;
	padding:7px 0px;
}
.cont_esterno {
	width:637px;
	height: auto;
	float:left;
}
.indirizzi {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:none;
}
.note_varie {
	width:200px;
	min-height:50px;
	overflow: hidden;
	height: auto;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.colonnine_form {
	width:100px;
	height: 35px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.colonnine_form_lunga {
	width:150px;
	height: 35px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}

.colliPeso {
	width:100px;
	height: 60px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.scritta_bianca {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color:#FFFFFF;
}

.testata_tab {
	width:637px;
	height: 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	float:left;
	font-weight: bold;
}
.corpo_tab {
	width:637px;
	height: 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	float:left;
}
.tab57 {
	width:57px;
	height: 20px;
	float:left;
}
.tab69 {
	width:69px;
	height: 20px;
	float:left;
}
.tab335 {
	width:335px;
	height: 20px;
	float:left;
}
.tab48 {
	width:48px;
	height: 20px;
	float:left;
	font-weight: bold;
	text-align: right;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.Stile2 {
	font-size: 18px;
	font-weight: bold;
}
.Stile3 {font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
font-weight: bold;
}
.Stile4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Stile5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.Stile6 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align:right;
}
.Stile7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-align:left;
}
.riga_finale {
	width:622px;
	height: auto;
	margin-left:100px;
	padding-top:10px;
	padding-bottom:10px;
	float:left;
	
}
.box_60{
	width:60px;
	padding-top:5px;
	height: auto;
	float:left;
}
.box_90{
	width:95px;
	padding-top:5px;
	height: auto;
	float:left;
}
.box_350{
	width:390px;
	padding-top:5px;
	height: auto;
	float:left;
}
@media print{
	#main_container{
		page-break-after: avoid;
		page-break-before:avoid;
		page-break-inside: auto;
		width: 700px;
		height: 1069px;
	}
.immpiede {
	width:100%; height:100px;
}
.superiore {
	width: 100%; height: 969px;
}
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function refreshParent() {
  window.opener.chiusura();
}
function trasf_pl() {
	window.close();
  window.opener.trasf_pl();
}

function svuotaColli() {
	var contenuto = colli.value;
  if (contenuto == "Colli") {
  //alert(contenuto);
  colli.value = "";
  colli.focus();
  }
}
function riprColli() {
	var contenuto = colli.value;
  if (contenuto == "") {
  //alert(contenuto);
  colli.value = "Colli";
  }
}

function svuotaMisure() {
	var contenuto = misure.value;
  if (contenuto == "Misure") {
  //alert(contenuto);
  misure.value = "";
  misure.focus();
  }
}
function riprMisure() {
	var contenuto = misure.value;
  if (contenuto == "") {
  //alert(contenuto);
  misure.value = "Misure";
  }
}
function svuotaPeso() {
	var contenuto = peso.value;
  if (contenuto == "Peso") {
  //alert(contenuto);
  peso.value = "";
  peso.focus();
  }
}
function riprPeso() {
	var contenuto = peso.value;
  if (contenuto == "") {
  //alert(contenuto);
  peso.value = "Peso";
  }
}
</script>

</head>

<?php
if (count($array_pl) > 1) {
  echo '<body onLoad="refreshParent(); trasf_pl();">';
} else {
  switch ($mode) {
	  case "print":
		echo "<body onLoad=javascript:window.print()>";
		break;
	  case "vis":
		echo '<body onUnload="refreshParent()">';
	  break;
	  case "nuovo":
		echo '<body>';
	  break;
	  
  }
}
  switch ($mode) {
	  case "nuovo":
		$queryv = "SELECT * FROM qui_packing_list_temp WHERE id = '$n_pl'";
	  break;
	  case "print":
	  case "cons":
	  case "vis":
		$queryv = "SELECT * FROM qui_packing_list WHERE id = '$n_pl'";
	  break;
  }
$resultv = mysql_query($queryv);
while ($rowv = mysql_fetch_array($resultv)) {
$id_pack = stripslashes($rowv[id]);
$indirizzo_spedizione = stripslashes($rowv[indirizzo_spedizione]);
$utente = stripslashes($rowv[utente]);
$colli = stripslashes($rowv[colli]);
$peso = stripslashes($rowv[peso]);
$misure = stripslashes($rowv[misure]);
$data_spedizione = date("d/m/Y H:i",$rowv[data_spedizione]);
$data_spedizionextestata = date("d/m/Y",$rowv[data_spedizione]);
$indirizzo_vettore = stripslashes($rowv[vettore]);
$id_vettore = $rowv[id_vettore];
	$pp = "SELECT * FROM qui_unita WHERE id_unita = '$rowv[id_unita]'";
	$risultpp = mysql_query($pp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rowp = mysql_fetch_array($risultpp)) {
	  $nome_unita = $rowp[nome_unita];
	}
	switch ($rowv[logo]) { 
	  case "sol":
		$immagine_logo = '<img src="immagini/velina_logo_sol.png" width="185" height="74" />';
		$immagine_piede = '<img src="immagini/velina_piede_sol.png" width="744" height="85" />';
	  break;
	  case "vivisol":
		$immagine_logo = '<img src="immagini/velina_logo_vivisol.png" width="251" height="74" />';
		$immagine_piede = '<img src="immagini/velina_piede_vivisol.png" width="744" height="85" />';
	  break;
	}
$dati_packing_list .= "|".$rowv[id]."|;|".$rowv[logo]."|;|".$rowv[id_unita]."|;|".tratta(addslashes($rowv[indirizzo_spedizione]))."|;|".tratta(addslashes($rowv[note]))."|;|".$rowv[data_spedizione]."|;|".$nome_unita."|;";
$dati_packing_list = str_replace("||","|0|",$dati_packing_list);
//$dati_packing_list .= "||";
//$dati_packing_list .= "|".$rowv[id]."|;|".$rowv[logo]."|;|".$rowv[check_completato]."|;|".$rowv[dest_contab]."|;|".$rowv[rda]."|;|".$rowv[id_unita]."|;|0|;|".$rowv[utente]."|;|".$rowv[responsabile]."|;|".$rowv[note]."|;|".$rowv[colli]."|;|".$rowv[peso]."|;|".$rowv[volume]."|;|".$rowv[id_vettore]."|;|".$rowv[vettore]."|;|".$rowv[data_spedizione]."|;|".$rowv[data_chiusura]."|;|".$rowv[data_chiusura_tx]."|;|".$rowv[magazziniere]."|;|".$rowv[operatore_chiusura]."|;|".$rowv[n_ord_sap]."|;|".$rowv[n_fatt_sap]."|;";
}
if ($peso == ""){
$peso = 'Peso';
}
if ($colli == ""){
$colli = 'Colli';
}
if ($misure == ""){
$misure = 'Misure';
}
$lista_vettori .= "<option selected value=>Scelta vettore</option>";
//$lista_vettori .= "<option selected value=>".$vettori_packing."</option>";
$queryh = "SELECT * FROM qui_vettori ORDER BY abbreviazione ASC";
$resulth = mysql_query($queryh);
while ($rowh = mysql_fetch_array($resulth)) {
if ($rowh[id] == $id_vettore) {
$lista_vettori .= "<option selected value=".$rowh[id].">".$rowh[abbreviazione]."</option>";
} else {
$lista_vettori .= "<option value=".$rowh[id].">".$rowh[abbreviazione]."</option>";
}
}
	if ($mode != "print") {
	  echo "<div id=lingua_scheda>";
switch($behav) {
	default:
	  echo "<form id=form1 name=form1 method=get action=packing_list.php>";
		  switch ($mode) {
				//echo "Colli<br>";
			  default:
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="colli" type="text" id="colli" size="10" onfocus="svuotaColli();" onblur="riprColli();" value="'.$colli.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="peso" type="text" id="peso" size="10" onfocus="svuotaPeso();" onblur="riprPeso();" value="'.$peso.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="misure" type="text" id="misure" size="10" onfocus="svuotaMisure();" onblur="riprMisure();" value="'.$misure.'">';
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=print>";
			  break;
			  case "cons":
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="colli" type="text" id="colli" size="10" onfocus="svuotaColli();" onblur="riprColli();" value="'.$colli.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="peso" type="text" id="peso" size="10" onfocus="svuotaPeso();" onblur="riprPeso();" value="'.$peso.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="misure" type="text" id="misure" size="10" onfocus="svuotaMisure();" onblur="riprMisure();" value="'.$misure.'">';
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=print>";
				echo "<input name=n_pl type=hidden id=n_pl value=".$n_pl.">";
				echo "<input name=aggiorna_visualizza type=hidden id=aggiorna_visualizza value=1>";
			  break;
			  case "nuovo":
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="colli" type="text" id="colli" size="10" onfocus="svuotaColli();" onblur="riprColli();" value="'.$colli.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="peso" type="text" id="peso" size="10" onfocus="svuotaPeso();" onblur="riprPeso();" value="'.$peso.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="misure" type="text" id="misure" size="10" onfocus="svuotaMisure();" onblur="riprMisure();" value="'.$misure.'">';
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=vis>";
				echo'<input name="temp_pl" type="hidden" id="temp_pl" value="'.$n_pl.'">';
			  break;
			  case "vis":
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="colli" type="text" id="colli" size="10" onfocus="svuotaColli();" onblur="riprColli();" value="'.$colli.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="peso" type="text" id="peso" size="10" onfocus="svuotaPeso();" onblur="riprPeso();" value="'.$peso.'">';
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="misure" type="text" id="misure" size="10" onfocus="svuotaMisure();" onblur="riprMisure();" value="'.$misure.'">';
				echo "</div>";
				echo "<input name=mode type=hidden id=mode value=print>";
				//echo'<input name="temp_pl" type="hidden" id="temp_pl" value="'.$n_pl.'">';
				echo "<input name=n_pl type=hidden id=n_pl value=".$n_pl.">";
				echo "<input name=aggiorna_dati_pack type=hidden id=aggiorna_dati_pack value=1>";
			  break;
		  }
	  echo "<div class=colonnine_form_lunga>";
		  //echo "Scelta vettore<br>";
			echo '<select name="vettore" style="margin-top:7px;" class="Stile1" id="vettore">';
			  echo $lista_vettori;
			echo "</select>";
	  echo "<input name=id type=hidden id=id value=".$id.">";
	  echo "<input name=output type=hidden id=output value=".$output.">";
		 // echo "<a href=packing_list.php?mode=print><img src=immagini/".$bottone_stampa." width=120 height=19 border=0 title=".$print_pkglist."></a>";
	  echo "</div>";
	  echo "<div class=colonnine_form style=\"padding-top:10px;\">";
		  //echo "<span class=scritta_bianca>Scelta vettore</span><br>";
  switch ($mode) {
	  case "nuovo":
	  echo "<a href=\"javascript:void(0);\" onclick=\"form1.submit()\"><span class=Stile1>Salva</span></a>";
	  break;
	  case "vis":
	  echo "<a href=\"javascript:void(0);\" onclick=\"form1.submit()\"><span class=Stile1>Salva e Stampa</span></a>";
	  break;
  }
	  //echo "<input name=submit class=tabellecentro style=\"margin-top:7px;\" type=image value=Invia src=immagini/".$bottone_stampa." width=120 height=19 border=0 title=".$print_pkglist.">";
		 echo "<br />";
	  echo "</div>";
	  echo "</div>";
	  echo "</form>";
	break;
	case "publiem":
  switch ($mode) {
	  case "nuovo":
		echo "<form id=form1 name=form1 method=get action=packing_list.php>";
				echo "<div class=colonnine_form>";
				  echo "<input class=Stile1 style=\"margin-top:7px;\" name=colli type=text id=colli size=10 value=".$colli.">";
				echo "</div>";
				echo "<div class=colonnine_form>";
				  echo '<input class="Stile1" style="margin-top:7px;" name="peso" type="text" id="peso" size="10" value="'.$peso.'">';
				echo '</div>';
				echo '<input name="behav" type="hidden" id="behav" value="publiem">';
				echo '<input name="mode" type="hidden" id="mode" value="vis">';
				echo '<input name="temp_pl" type="hidden" id="temp_pl" value="'.$n_pl.'">';
	  echo "<div class=colonnine_form_lunga>";
		  //echo "Scelta vettore<br>";
			echo '<select name="vettore" style="margin-top:7px;" class="Stile1" id="vettore">';
			  echo $lista_vettori;
			echo "</select>";
	  echo "<input name=id type=hidden id=id value=".$id.">";
	  echo "<input name=output type=hidden id=output value=".$output.">";
		 // echo "<a href=packing_list.php?mode=print><img src=immagini/".$bottone_stampa." width=120 height=19 border=0 title=".$print_pkglist."></a>";
	  echo "</div>";
	  echo "<div class=colonnine_form style=\"padding-top:10px;\">";
	  echo "<a href=\"javascript:void(0);\" onclick=\"form1.submit()\"><span class=Stile1>Salva</span></a>";
	  echo "</div>";
		echo "</form>";
	  echo "</div>";
	  break;
	  case "vis":
		echo '<form id="form1" name="form1" method="post" action="http://www.publiem.eu/quice/inserimento_PL_da_sol.php">';
		  $dati_rda = "";  
			// Fetch Record from Database
		  $sql = "SELECT * FROM qui_righe_rda WHERE pack_list = '$n_pl'";
		  $risult = mysql_query($sql);
		  while ($row = mysql_fetch_array($risult)) {
			  $sqla = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_utente]'";
			  $risulta = mysql_query($sqla);
			  while ($rowa = mysql_fetch_array($risulta)) {
				  $nome_utente = $rowa[nome];
		  //		$dati_utente .= "|".$rowa[user_id]."|;|".$rowa[login]."|;|".$rowa[nome]."|;|".$rowa[posta]."|;|".$rowa[idlocalita]."|;|".$rowa[idunita]."|;|".$rowa[indirizzo]."|;|".$rowa[cap]."|;|".$rowa[company]."|;|".$rowa[localita]."|;|".$rowa[nazione]."|;|".$rowa[nomeunita]."|;|".$rowa[companyName]."|;|".$rowa[IDCompany]."|;|".$rowa[idresp]."|;|".$rowa[ruolo]."|;|".$rowa[ruolo_report]."|;|".$rowa[negozio_buyer]."|;|".$rowa[negozio2_buyer]."|;|".$rowa[precedenza_buyer]."|;|".$rowa[pwd]."|;|".$rowa[flag_etichette_pharma]."|;";
			   // $dati_utente .= "||";
			  }
				$dati_rda .= "|".$row[id]."|;|".$row[id_utente]."|;|".$nome_utente."|;|".$row[codice_art]."|;|".$row[descrizione]."|;|".$row[quant]."|;|".$row[totale]."|;|".$row[id_rda]."|;|".$row[data_inserimento]."|;|".$row[gruppo_merci]."|;";
				$dati_rda .= "||";
				$nome_utente = "";
			}
				$dati_rda = str_replace("||","|0|",$dati_rda);
					echo '<input name="n_pl" type="hidden" id="n_pl" value="'.$n_pl.'">';
					echo '<input name="dati_rda" type="hidden" id="dati_rda" value="'.$dati_rda.'">';
					echo '<input name="dati_packing_list" type="hidden" id="dati_packing_list" value="'.$dati_packing_list.'">';
					echo '<input name="inserimento_pl" type="hidden" id="inserimento_pl" value="1">';
					  echo '<a href="javascript:void(0);" onclick="form1.submit()"><span class="Stile1">Avvisa cooperativa</span></a>';
			$completato = "1";
					echo "</div>";
				  echo "</div>";
		echo "</form>";
	  echo "</div>";
	  break;
  }
	break;
}
	}

  $array_rdapl = array();
  $array_gruppo_merci = array();
  
  switch ($mode) {
	  case "nuovo":
		$queryt = "SELECT * FROM qui_righe_rda WHERE vecchio_codice = '$n_pl' ORDER BY id_rda ASC";
	  break;
	  case "vis":
	  case "print":
		$queryt = "SELECT * FROM qui_righe_rda WHERE pack_list = '$n_pl' ORDER BY id_rda ASC";
	  break;
  }
    $resultt = mysql_query($queryt);
	$conteggio_righe_rda = mysql_num_rows($resultt);
    while ($rowt = mysql_fetch_array($resultt)) {
      if (!in_array($rowt[id_rda],$array_rdapl)) {
          $addRdapl = array_push($array_rdapl,$rowt[id_rda]);
      }
      if (!in_array($rowt[gruppo_merci],$array_gruppo_merci)) {
          $addgrm = array_push($array_gruppo_merci,$rowt[gruppo_merci]);
      }
	}
  $conteggio_rda = count($array_rdapl);
  $conteggio_grm = count($array_gruppo_merci);
$limite_max = 800;
  $spazio_intestazione_rda = 70;
  $spazio_totale_rda = 25;
  $spazio_grm = "20";
  $spazio_righe_rda = "32";
  $altezza_necessaria_stampa = ($spazio_intestazione_rda*$conteggio_rda)+($spazio_totale_rda*$conteggio_rda)+($conteggio_rda*$conteggio_grm)+($spazio_righe_rda*$conteggio_righe_rda);
  if ($altezza_necessaria_stampa > $limite_max) {
	  $pagine_PL = ceil($altezza_necessaria_stampa/$limite_max);
  } else {
	  $pagine_PL = 1;
  }
  //$array_righe_vis = explode(",",$_SESSION[lista_righe]);
  if ($mode == "print") {
	$riepilogo = "stampa packing list (".$n_pl.") da magazziniere ".$id_utente;
	$datalog = mktime();
	$datalogtx = date("d.m.Y H:i",$datalog);
	$operatore = addslashes($_SESSION['nome']);
	$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '$array_rda[0]', '$riepilogo')";
	if (mysql_query($queryb)) {
	} else {
	echo "Errore durante l'inserimento". mysql_error();
	}
  }
//*******************************
//generazione blocco righe
  //echo '<span style="color: #000;">'.$altezza_necessaria_stampa.'</span><br>';
  foreach ($array_rdapl as $sing_rda_vis) {
    $sqlh = "SELECT * FROM qui_rda WHERE id = '$sing_rda_vis'";
    $risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
    while ($rigah = mysql_fetch_array($risulth)) {
      $data_rda = date("d/m/Y", $rigah[data_inserimento]);
      $utente_rda = $rigah[nome_utente];
      $sqls = "SELECT * FROM qui_ordini_for WHERE id_rda = '$sing_rda_vis'";
      $risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
      $quant_ord = mysql_num_rows($risults);
      //if ($quant_ord > 0) {
        //while ($rigas = mysql_fetch_array($risults)) {
         // $riepilogo_ord_for .= "Ordine ".$rigas[id]." del ".date("d/m/Y",$rigas[data_ordine]).", ";
        //}
      //}
    }
	if (($altezza_reale + 70) <= $limite_max) {
	} else {
	  $altezza_reale = 0;
	  $blocco .= '(%)';
	}
	$altezza_reale = $altezza_reale + 70;
  $blocco .= '<div style="width:590px; min-height:30px; overflow: hidden; height: auto; margin-left: 119px;">';
	$blocco .= '<div class="riga_divisoria" style="margin-bottom:10px; margin-left: 0px; padding-bottom: 5px; border-bottom: 0px;">RdA '.$sing_rda_vis.' del '.$data_rda.' ('.$utente_rda.')';
	  $queryp = "SELECT * FROM qui_rda WHERE id = '$sing_rda_vis'";
      $resultp = mysql_query($queryp);
      while ($rowp = mysql_fetch_array($resultp)) {
		  if ($rowp[note_utente] != "") {
			  $note .= '<strong>Note utente:</strong> '.$rowp[note_utente].' - ';
		  }
		  if ($rowp[note_resp] != "") {
			  $note .= '<strong>Note responsabile:</strong> '.$rowp[note_resp].' - ';
		  }
		  if ($rowp[note_buyer] != "") {
			  $note .= '<strong>Note buyer:</strong> '.$rowp[note_buyer].' - ';
		  }
		  if ($rowp[note_magazziniere] != "") {
			  $note .= '<strong>Note magazziniere:</strong> '.$rowp[note_magazziniere].' - ';
		  }
	  }
	if ($note != "") {
		$blocco .= '<br><span style="font-size:11px; font-weight:normal;">'.$note.'</span>';
	}
	$note = "";
	$blocco .= '</div>';
  $blocco .= '</div>';
    
  switch ($mode) {
	  case "nuovo":
		$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_vis' AND vecchio_codice = '$n_pl' ORDER BY gruppo_merci ASC";
	  break;
	  case "vis":
	  case "print":
		$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda_vis' AND pack_list = '$n_pl' ORDER BY gruppo_merci ASC";
	  break;
  }
      $resultg = mysql_query($queryg);
      while ($rowg = mysql_fetch_array($resultg)) {
		if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
			if ($gruppo_merci_uff != "") {
			  //$blocco .= "<div class=riga_divisoria style=margin-bottom:10px; border-bottom:none; border-top:none;>";
			 // $blocco .= "</div>";
			}
			$gruppo_merci_uff = $rowg[gruppo_merci];
			$querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
			$results = mysql_query($querys);
			while ($rows = mysql_fetch_array($results)) {
				$descrizione_gruppo_merci = $rows[descrizione];
				$codice_sap = $rows[codice_sap];
			}
			switch ($mode) {
				case "nuovo":
				  $sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$sing_rda_vis' AND vecchio_codice = '$n_pl' AND gruppo_merci = '$gruppo_merci_uff'";
				break;
				case "vis":
				case "print":
				  $sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE id_rda = '$sing_rda_vis' AND pack_list = '$n_pl' AND gruppo_merci = '$gruppo_merci_uff'";
				break;
			}
			$resultz = mysql_query($sum_grm);
			list($somma_grm) = mysql_fetch_array($resultz);
			$totale_grm = $somma_grm;
			$TOTALE_rda = $TOTALE_rda + $totale_grm;
			if (($altezza_reale + 20) <= $limite_max) {
			} else {
			  $altezza_reale = 0;
			  $blocco .= '(%)';
			}
			$altezza_reale = $altezza_reale + 20;
			$blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
			  $blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; padding-left:0px;">';
				$blocco .= '<div class="box_60">';
				$blocco .= $gruppo_merci_uff;
				$blocco .= "</div>";
				$blocco .= '<div class="box_350" style="width:400px;">';
				$blocco .= "| ".$codice_sap." ".stripslashes($descrizione_gruppo_merci);
				$blocco .= "</div>";
			  $blocco .= "</div>";
			  $totale_grm = "";
			$blocco .= "</div>";
          }
		if (($altezza_reale + 32) <= $limite_max) {
		} else {
		  $altezza_reale = 0;
		  $blocco .= '(%)';
		}
		$altezza_reale = $altezza_reale + 32;
		$blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
		  $blocco .= '<div class="contenitore_riga_fattura" style="font-size: 12px; width:100%; min-height:15px; overflow:hidden; height:32px; padding-left:0px; padding-bottom: 5px !important;">';
		  $blocco .= '<div class="box_60">';
		  if (substr($rowg[codice_art],0,1) != "*") {
			$blocco .= $rowg[codice_art];
		  } else {
			$blocco .= substr($rowg[codice_art],1);
		  }
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_350" style="width:435px; border-left: 1px solid #666; padding-left: 5px; padding-top: 2px !important;">';
		  $blocco .= stripslashes($rowg[descrizione]);
		  $blocco .= "</div>";
		  $blocco .= '<div class="box_60" style="text-align:right; width:40px; float:right; margin-right:20px;">';
		  $blocco .= intval($rowg[quant]);
		  $blocco .= "</div>";
		  $x = $x + 1;
			if ($x == "1") {
			  if ($rowg[n_ord_sap] != "") {
				$n_ord_sap = $rowg[n_ord_sap];
				if ($rowg[n_fatt_sap] != "") {
				  $n_fatt_sap = $rowg[n_fatt_sap];
				}
			  }
			}
		  $blocco .= "</div>";	
		$blocco .= "</div>";	
      }
      
      $gruppo_merci_uff = "";
      
	  if (($altezza_reale + 25) <= $limite_max) {
	  } else {
		$altezza_reale = 0;
		$blocco .= '(%)';
	  }
	  $altezza_reale = $altezza_reale + 25;
	  $blocco .= '<div style="width:590px; min-height:20px; overflow: hidden; height: auto; margin-left: 119px;">';
		$blocco .= '<div class="contenitore_gruppo_merci" style="width:100%; border-bottom:1px solid #CCC; padding-bottom:5px; padding-left:0px; margin-bottom:10px;">';
		$blocco .= "</div>";	
		//fine singola RdA
	$blocco .= '</div>';
    $TOTALE_rda = "";
    $data_rda = "";
  //fine foreach
  }
  
  
$array_ordini_sap = array();
  
    if ($n_ord_sap != "") {
		if (!in_array($n_ord_sap,$array_ordini_sap)) {
		  $add_ord = array_push($array_ordini_sap,$n_ord_sap);
		  $blocco .= '<div class="colonnine_form" style="width:430px; margin-left: 119px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		  $blocco .= '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		  if ($n_fatt_sap != "") {
			  $blocco .= ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		  }
		  $blocco .= '</div>';
		}
    }
    if ($riepilogo_ord_for != "") {
      $blocco .= '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
      $blocco .= '<span style="font-weight:bold;">Ordine fornitore n.</span> '.$riepilogo_ord_for;
      $blocco .= '</div>';
    }
//fine generazione blocco righe
//*******************************
$array_blocchi = explode('(%)',$blocco);

$pagine_PL = count($array_blocchi);

for ($i = 0; $i < $pagine_PL; $i++) {
echo '<div id="main_container">
  <div id="parte_superiore" class="superiore">
  
  <div class="riga_divisoria" style="margin-left: 0px; margin-top:50px; min-height:23px; overflow:hidden; height: auto; border-bottom: 0px; margin-right: 0px; width:620px;">
    <div style="height:auto; width:390px; float:left;">'.$immagine_logo.'</div>
    <div class="indirizzi" style="height:100px; width:195px; float:left;">
    <span class="Stile4">Destinatario<br />'.$indirizzo_spedizione.'</span>
    </div>
  </div>
  <div class="riga_divisoria" style="margin-top:30px; margin-bottom:10px;">';
    if ($mode == "nuovo") {
		echo '<div style="width:360px; float:left;">Packing List del '.$data_spedizionextestata.'</div>';
	} else {
		echo '<div style="width:360px; float:left;">Packing List '.$id_pack.' del '.$data_spedizionextestata.'</div>';
	}

	echo '<div style="margin-top:3px; width:auto; float:left; font-size:12px; font-family:Arial;">Pag. '.($i+1).' di '.$pagine_PL.'</div>
  </div>';
  echo $array_blocchi[$i];

//PARTE TAGLIATA DA RIPRISTINARE-->
if ($i == ($pagine_PL - 1)) {
    if ($n_ord_sap != "") {
		if (!in_array($n_ord_sap,$array_ordini_sap)) {
		  $add_ord = array_push($array_ordini_sap,$n_ord_sap);
		  echo '<div class="colonnine_form" style="width:430px; margin-left: 119px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
		  echo '<span style="font-weight:bold;">Ord. SAP n.</span> '.$n_ord_sap;
		  if ($n_fatt_sap != "") {
			  echo ' - <span style="font-weight:bold;">Fatt. SAP n.</span> '.$n_fatt_sap;
		  }
		  echo '</div>';
		}
    }
    if ($riepilogo_ord_for != "") {
      echo '<div class="colonnine_form" style="width:430px; min-height:15px; overflow:hidden; height:auto; margin-bottom:5px;">';
      echo '<span style="font-weight:bold;">Ordine fornitore n.</span> '.$riepilogo_ord_for;
      echo '</div>';
    }
    echo '<div class="colonnine_form" style="width:230px; height:70px; margin-left: 119px;">
      <span class="Stile4"><strong> Inizio trasporto</strong>';
        if ($data_spedizione > 0) {
            echo $data_spedizione;
        }
      echo '</span><br>
      <span class="Stile4"><strong>Colli </strong>';
        if ($colli != "Colli") {
            echo $colli;
        }
      echo '</span><br>
      <span class="Stile4"><strong>Peso kg </strong>';
          if ($peso != "Peso") {
              echo $peso;
          }
       echo '</span><br>
      <span class="Stile4"><strong>Misure cm </strong>';
        if ($misure != "Misure") {
            echo $misure;
        }
     echo '</span>
    </div>
    <div class="note_varie" style="width:192px;">
      <span class="Stile4"><strong>Vettore</strong><br />'.$indirizzo_vettore.'<br></span>
    </div>
    <div class="note_varie" style="width:192px;">
      <span class="Stile4"><strong>Firma</strong><br /></span>
      <img src="immagini/spacer.gif" width="192" height="40" />
    </div>';
}

  echo '</div>';
  //contenitore piedino-->
  echo '<div class="immpiede">';
  echo $immagine_piede;
  echo '</div>
  
  </div>';
}
/*
*/

?>
</body>
<script type="text/javascript">
function aggiorna_nota(id_pl) {
var tx_testo = nota.value.replace(/\r?\n/g, '<br>');
  /*alert(tx_testo);*/
  $.ajax({
		  type: "GET",   
		  url: "aggiorna_pl.php",   
		  data: "testo="+tx_testo+"&id_pl="+id_pl,
		  success: function(output) {
		  $('#aaa').html(output).show();
		  }
		  });
}
</SCRIPT>
</html>
