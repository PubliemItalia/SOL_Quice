<?php
session_start();
$logo = $_GET[logo];
$output_mode = $_GET[output_mode];
$output_ok = $_GET[output_ok];
$lingua = $_SESSION[lang];
$id = $_GET[id];
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
//echo "output_mode: ".$output_mode."<br>";
//$lingua = $_SESSION[lang];
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
$id_utente = $_SESSION[user_id];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$query = "SELECT * FROM qui_rda WHERE id = '$id'";
$risulty = mysql_query($query) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
$id_rda = $rigay[id];
$negozio_rda = $rigay[negozio];
$id_unita_rda = $rigay[id_unita];
$nome_unita_rda = $rigay[nome_unita];
$id_utente_rda = $rigay[id_utente];
$nome_utente_rda = $rigay[nome_utente];
$id_resp_rda = $rigay[id_resp];
$nome_resp_rda = $rigay[nome_resp];
$id_buyer_rda = $rigay[id_buyer];
$nome_buyer_rda = $rigay[nome_buyer];
$stato_rda = $rigay[stato];
$totale_rda = $rigay[totale_rda];
$buyer_output_rda = $rigay[buyer_output];
$data_ultima_modifica = $rigay[data_ultima_modifica];
$id_carrello_rda = $rigay[id_carrello];
$wbs_rda = $rigay[wbs];
if ($rigay[note_utente] != "") {
$note .= "Note utente - ".$rigay[note_utente];
}
if ($rigay[note_resp] != "") {
$note .= "<br>Note responsabile - ".$rigay[note_resp];
}
if ($rigay[note_buyer] != "") {
$note .= "<br>Note buyer - ".$rigay[note_buyer];
}
if ($rigay[note_magazziniere] != "") {
$note .= "<br>Note buyer - ".$rigay[note_magazziniere];
}
}
$querya = "SELECT * FROM qui_utenti WHERE idunita = '$id_unita_rda' ORDER BY user_id ASC LIMIT 1";
$risulta = mysql_query($querya) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaa = mysql_fetch_array($risulta)) {
$indirizzo_completo .= addslashes($rigaa[nomeunita])."<br>";
$indirizzo_completo .= addslashes($rigaa[indirizzo])."<br>";
$indirizzo_completo .= $rigaa[cap]." ".addslashes($rigaa[localita])." ".addslashes($rigaa[nazione]);
}
$data_ordine = mktime();
$data_ordine_tx = date("d/m/Y",$data_ordine);
mysql_query("INSERT INTO qui_ordini_for (negozio, id_unita, nome_unita, id_utente, nome_utente, id_resp, nome_resp, id_buyer, nome_buyer, stato, totale_ordine, ordinante, data_ordine, data_ordine_tx, buyer_output, data_ultima_modifica, id_carrello, id_rda, wbs, note, logo) VALUES ('$negozio_rda', '$id_unita_rda', '$nome_unita_rda', '$id_utente_rda', '$nome_utente_rda', '$id_resp_rda', '$nome_resp_rda', '$id_buyer_rda', '$nome_buyer_rda', '$stato_rda', '$totale_rda', '$indirizzo_completo', '$data_ordine', '$data_ordine_tx', '$buyer_output_rda', '$data_ultima_modifica', '$id_carrello_rda', '$id_rda', '$wbs_rda', '$note', '$logo')");
$n_ordine = mysql_insert_id();
/*
$queryx = "INSERT INTO qui_ordini_for (negozio, id_unita, nome_unita, id_utente, nome_utente , id_resp, nome_resp, id_buyer, nome_buyer, stato, totale_ordine, ordinante, data_ordine, data_ordine_tx, buyer_output, data_ultima_modifica, id_carrello, wbs) VALUES ('$negozio_rda', '$id_unita_rda', '$nome_unita_rda', '$id_utente_rda', '$nome_utente_rda', '$id_resp_rda', '$nome_resp_rda', '$id_buyer_rda', '$nome_buyer_rda', '$stato_rda', '$totale_rda', '$indirizzo_completo', '$data_ordine', '$data_ordine_tx', '$buyer_output_rda', '$data_ultima_modifica', '$id_carrello_rda', '$wbs_rda')";
if (mysql_query($queryx)) {
} else {
echo "Errore durante l'inserimento1". mysql_error();
}
*/
$data_attuale = mktime();

$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '1'";
$result = mysql_query($querya);
$num_righe_processare = mysql_num_rows($result);
$array_righe_modif = array();
while ($rigaa = mysql_fetch_array($result)) {
$add_riga = array_push($array_righe_modif,$rigaa[id]);
}

/*echo "righe da modificare: ";
print_r ($array_righe_modif);
echo "<br>";
*/
foreach ($array_righe_modif as $ogni_riga) {
$sqlr = "SELECT * FROM qui_righe_rda WHERE id = '$ogni_riga'";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
$id_carrello = $rigar[id_carrello];
$negozio = $rigar[negozio];
$id_unita = $rigar[id_unita];
$nome_unita = $rigar[nome_unita];
$categoria = $rigar[categoria];
$id_utente = $rigar[id_utente];
$id_resp = $rigar[id_resp];
$id_prodotto = $rigar[id_prodotto];
$codice_art = $rigar[codice_art];
$descrizione = $rigar[descrizione];
$confezione = $rigar[confezione];
$quant = $rigar[quant];
$prezzo = $rigar[prezzo];
$totale = $rigar[totale];
$data_inserimento = $rigar[data_inserimento];
$data_ultima_modifica = $rigar[data_ultima_modifica];
$id_rda = $rigar[id_rda];
$stato_ordine = $rigar[stato_ordine];
$flag_buyer = $rigar[flag_buyer];
$flag_chiusura = $rigar[flag_chiusura];
$flag_packing_list = $rigar[flag_packing_list];
$output_mode = $rigar[output_mode];
$file_sap = $rigar[file_sap];
$evaso_magazzino = $rigar[evaso_magazzino];
$vecchio_codice = $rigar[vecchio_codice];
$report_select = $rigar[report_select];
$gruppo_merci = $rigar[gruppo_merci];
$wbs = $rigar[wbs];
}
$sqlb = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$codice_art'";
$risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowb = mysql_fetch_array($risultb)) {
$giacenza = $rowb[giacenza];
}
$nuova_giacenza = $giacenza-$quant;
//AGGIORNAMENTO QUANTITA' PER SCARICO MAGAZZINO
$sqlk = "UPDATE qui_prodotti_".$negozio." SET giacenza = '$nuova_giacenza' WHERE codice_art = '$codice_art'";
if (mysql_query($sqlk)) {
} else {
echo "Errore durante l'inserimento4: ".mysql_error();
}
$nuova_giacenza = "";

$querya = "INSERT INTO qui_righe_ordini_for (id_ordine_for, id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, id_riga_rda, gruppo_merci, wbs) VALUES ('$n_ordine', '$id_carrello', '$negozio', '$id_unita', '$nome_unita', '$categoria', '$id_utente', '$id_resp', '$id_prodotto', '$codice_art', '$descrizione', '$confezione', '$quant', '$prezzo', '$totale', '$data_inserimento', '$data_ultima_modifica', '$id_rda', '$ogni_riga', '$gruppo_merci', '$wbs')";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento4". mysql_error();
}


$data_attuale = mktime();
$query = "UPDATE qui_righe_rda SET flag_buyer = '2', output_mode = 'ord', stato_ordine = '3', data_ultima_modifica = '$data_attuale', data_output = '$data_attuale', dest_contab = '' WHERE id = '$ogni_riga'";
if (mysql_query($query)) {
//echo "le righe rda sono state modificate correttamente";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}


$data_odierna = mktime();

//*********************
//versione precedente, con chiusura automatica della rda quando tutte le righe sono state processate e hanno il valore 4
	/*$sqlb = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
	$risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	$numrigherda = mysql_num_rows($risultb);
	while ($rigab = mysql_fetch_array($risultb)) {
	$sqlc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine = '4' AND flag_chiusura = '1'";
	$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	$righe_chiuse = mysql_num_rows($risultc);
	}
	if ($righe_chiuse == $numrigherda) {
	  $queryd = "UPDATE qui_rda SET stato = '4', , data_ultima_modifica = '".$data_odierna."', data_chiusura = '".$data_odierna."' WHERE id = '$id_rda'";
		if (mysql_query($queryd)) {
		} else {
		  echo "Errore durante l'inserimento: ".mysql_error();
		}
	} else {*/
	  $query = "UPDATE qui_rda SET stato = '3', data_output = '$data_odierna', buyer_output = '$id_utente', output_mode = 'ord' WHERE id = '$id'";
	  //echo "queri di modifica: ".$query."<br>";
	  if (mysql_query($query)) {
	  //echo "rda modificata correttamente";
	  } else {
	  echo "Errore durante l'inserimento: ".mysql_error();
	  }
	//}
//*********************


$riepilogo = "Output rda (".$id_rda.") su ".$output_mode." - utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}


echo "<div class=avviso>";
echo "L&acute;ordine fornitore ".$n_ordine." <br>&egrave; stato generato.<br>";
echo "</div>";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<style type="text/css">
<!--
.avviso {
color:#FF0000;
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
font-weight:bold;
text-align:center;
	width:350px;
	height:150px
	margin: auto;
	margin-top: 90px;
}
   -->
</style>

<script type="text/javascript">
function refreshParent() {
  window.myPop1.location.href = "popup_vis_ordine.php";
 if (window.myPop1.progressWindow)
 {
    window.myPop1.progressWindow.close()
  }
window.close();
}
</script>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<!--<body onUnload="remote2('ricerca_prodotti.php#<? //echo $id_prod; ?>')">-->
<body onUnload="refreshParent()">
</body>
</html>

