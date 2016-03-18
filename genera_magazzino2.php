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
//$lingua = $_SESSION[lang];
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
$id_utente = $_SESSION[user_id];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
//faccio l'array delle rda delle righe che trovo flaggate
//echo "<span style=\"color:rgb(0,0,0);\">fin qui OK1</span><br>";


$data_attuale = mktime();

$querya = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '1' AND id_buyer = '$id_utente' AND output_mode = '' ORDER BY id_rda ASC";
$result = mysql_query($querya);
$array_righe_modif = array();
$array_rda = array();
while ($rigaa = mysql_fetch_array($result)) {
  $add_riga = array_push($array_righe_modif,$rigaa[id]);
	if (!in_array($rigaa[id_rda],$array_rda)) {
		$add_rda = array_push($array_rda,$rigaa[id_rda]);
	}
}
$numRda = count($array_rda);
$a = 1;
foreach ($array_rda as $sing_rda) {
	if ($a < $numRda) {
		$lista_rda .= $sing_rda.",";
	} else {
		$lista_rda .= $sing_rda;
	}
	
}
//echo "<span style=\"color:rgb(0,0,0);\">fin qui OK2</span><br>";
$queryc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '3'";
$resultc = mysql_query($queryc);
$num_righe_gia_processate = mysql_num_rows($resultc);
if (($num_righe_totali-($num_righe_gia_processate+$num_righe_processare)) > 0) {
$stato_generale_rda = "3";
} else {
$stato_generale_rda = "3";
}

//echo "stato_generale_rda: ".$stato_generale_rda."<br>";

$data_attuale = mktime();
//echo "<span style=\"color:rgb(0,0,0);\">fin qui OK3</span><br>";
//recupero dati rda
$sqleee = "SELECT * FROM qui_rda WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$id_rda = $rigaeee[id];
$id_utente_rda = $rigaeee[id_utente];
$negozio_rda = $rigaeee[negozio];
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
$nome_utente_rda = $rigar[nome];
$idunita = $rigar[idunita];
$indirizzo = $rigar[indirizzo];
$cap = $rigar[cap];
$localita = $rigar[localita];
$nazione = $rigar[nazione];
$company = $rigar[company];
}

foreach ($array_righe_modif as $ogni_riga) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '2', output_mode = '$output_mode', stato_ordine = '3', data_output = '$data_attuale' WHERE id = '$ogni_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}

$query = "UPDATE qui_rda SET stato = '$stato_generale_rda', buyer_output = '$id_utente', output_mode = '$output_mode' WHERE id = '$id'";
if (mysql_query($query)) {
//echo "rda modificata correttamente";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
/*
if ($stato_generale_rda == "4") {
$queryg = "UPDATE qui_righe_rda SET stato_ordine = '4' WHERE id_rda = '$id'";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
$queryg = "UPDATE qui_righe_rda SET stato_ordine = '$stato_generale_rda' WHERE id_rda = '$id'";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
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

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§
//echo "<span style=\"color:rgb(0,0,0);\">fin qui OK4<br>";
//print_r($array_righe_modif)."</span><br>";

echo "<div id=pop_container>";
  echo "<div align=center style=\"font-family:Arial;color: #FF0000;font-weight: bold;font-size: 16px;text-align:center;\">".$gen_mag;
  echo "</div>";
echo "</div>";
echo "<div id=pop_container>";
  echo "<div align=center>";
//  echo "<input type=button name=button id=button onClick=\"window.close()\" value=OK>";
  echo "</div>";
echo "</div>";
/*
*/
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<!--<body onUnload="remote2('ricerca_prodotti.php#<?php echo $id_prod; ?>')">-->
<body>
</script>
</body>
</html>