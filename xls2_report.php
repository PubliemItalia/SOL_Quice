<?php
/*Supponiamo di voler esportare in Excel un elenco clienti da un applicativo php/MySQl 
la prima cosa da fare sar� ovviamente la query sul db per l'estrazione dati, che sar� qualcosa di simile;
*/
//include "validation.php";
function numdecim($stringa) {
$arr_stringa = explode(".",$stringa);
$parte_int = $arr_stringa[0];
$parte_decim = str_pad($arr_stringa[1], 2, "0", STR_PAD_RIGHT);
$num_fin = $parte_int.",".$parte_decim;
return $num_fin;
}
function tratta($stringa) {
$stringa = str_replace("è","e",$stringa);
$stringa = str_replace("é","e",$stringa);
$stringa = str_replace("ì","i",$stringa);
$stringa = str_replace("ò","o",$stringa);
$stringa = str_replace("ù","u",$stringa);
$stringa = str_replace("à","a",$stringa);
$stringa = stripslashes($stringa);
$stringa = str_replace("\n"," ",$stringa);
$stringa = str_replace("\r"," ",$stringa);
$stringa = str_replace("\p"," ",$stringa);
return $stringa;
}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_utente = $_GET[id_utente];
 	
	$array_negozi_validi = array();
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigat = mysql_fetch_array($risultt)) {
    if (!in_array($rigat[negozio],$array_negozi_validi)) {
	  $add_neg = array_push($array_negozi_validi,$rigat[negozio]);
	}
	}
///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
if (isset($_GET['unita'])) {
$unitaDaModulo = $_GET['unita'];
} 
if ($unitaDaModulo != "") {
$a = "id_unita = '$unitaDaModulo'";
$clausole++;
}
if (isset($_GET['categoria_ricerca'])) {
$categ_DaModulo = $_GET['categoria_ricerca'];
} 
if ($categ_DaModulo != "") {
$b = "categoria = '$categ_DaModulo'";
$clausole++;
}

if (isset($_GET['data_inizio'])) {
$data_inizio = $_GET['data_inizio'];
} 
if (isset($_GET['data_fine'])) {
$data_fine = $_GET['data_fine'];
} 
if ($data_inizio != "") {
if ($data_fine == "") {
$data_fine = date("d/m/Y",mktime());
}
}
if ($data_fine != "") {
if ($data_inizio == "") {
$pezzi_data_fine = explode("/",$data_fine);
$data_inizio = "01/".$pezzi_data_fine[1]."/".$pezzi_data_fine[2];
}
}
if ($data_inizio != "") {
$pieces_inizio = explode("/", $data_inizio);
$gginizio = $pieces_inizio[0]; 
$mminizio = $pieces_inizio[1];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
$ggfine = $pieces_fine[0]; 
$mmfine = $pieces_fine[1];
$aaaafine = $pieces_fine[2];
$fine_range = mktime(23,59,59,intval($mmfine), intval($ggfine), intval($aaaafine));
}
if (($inizio_range != "") AND ($fine_range != "")) {
if ($inizio_range > $fine_range) {
$campidate = "";
} else {
$campidate = 1;
$c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = "";
}
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
$statusDaModulo = $_GET['status'];
switch ($statusDaModulo) {
	case "":
	  $e = "(stato_ordine BETWEEN '2' AND '3')";
	  $clausole++;
	break;
	case "no_process":
	  $e = "output_mode LIKE '' AND (stato_ordine BETWEEN '2' AND '3')";
	  $clausole++;
	break;
	case "mag":
	  $e = "output_mode LIKE 'mag' AND evaso_magazzino = '0' AND stato_ordine = '3'";
	  $clausole++;
	break;
	case "sap":
	  $e = "output_mode LIKE 'sap' AND flag_chiusura = '0'";
	  $clausole++;
	break;
}

if (isset($_GET['codice_art'])) {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$g = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}



//costruzione query
if ($clausole > 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_righe_rda WHERE ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ";

if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
$sumquery .= $a;
}
if ($b != "") {
$testoQuery .= $b;
$sumquery .= $b;
}
if ($c != "") {
$testoQuery .= $c;
$sumquery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
$sumquery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
$sumquery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
$sumquery .= $f;
}
if ($g != "") {
$testoQuery .= $g;
$sumquery .= $g;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
$sumquery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
$sumquery .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
$sumquery .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
$sumquery .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
$sumquery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
$sumquery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g;
$sumquery .= $g;
}
}
} else {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '4'";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
$lungsum = strlen($sumquery);
$finale_sum = substr($sumquery,($lungsum-5),5);
if ($finale_sum == " AND ") {
$sumquery = substr($sumquery,0,($lungsum-5));
}

$testoQuery .= " ORDER BY id_rda DESC";
$querya = $testoQuery;
$resulta = mysql_query($querya);


$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;

//echo "testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
//}
//intestazione tabella

$header .= "<tr>";
$header .= "<td>";
$header .= "RdA";
$header .= "</td>";
$header .= "<td>";
$header .= "Data inserimento";
$header .= "</td>";
$header .= "<td>";
$header .= "Negozio";
$header .= "</td>";
$header .= "<td>";
$header .= "Nome resp";
$header .= "</td>";
$header .= "<td>";
$header .= "Nome unita";
$header .= "</td>";
$header .= "<td>";
$header .= "Codice art.";
$header .= "</td>";
$header .= "<td>";
$header .= "Descrizione";
$header .= "</td>";
$header .= "<td>";
$header .= "Gruppo merci";
$header .= "</td>";
$header .= "<td>";
$header .= "Quantita";
$header .= "</td>";
$header .= "<td>";
$header .= "Prezzo";
$header .= "</td>";
$header .= "<td>";
$header .= "Totale riga";
$header .= "</td>";
$header .= "<td>";
$header .= "Stato";
$header .= "</td>";
$header .= "<td>";
$header .= "Output";
$header .= "</td>";
$header .= "<td>";
$header .= "WBS";
$header .= "</td>";
$header .= "</tr>";
//righe
$rda = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigaaaa = mysql_fetch_array($rda)) {
	//if (in_array($rigaaaa[negozio],$array_negozi_validi)) {
$righe .= "<tr>";
$righe .= "<td>";
$righe .= $rigaaaa[id_rda];
$righe .= "</td>";
$righe .= "<td>";
if ($rigaaaa['data_inserimento'] > 0) {
$righe .= date("d/m/Y",$rigaaaa['data_inserimento']);
}
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[negozio]);
$righe .= "</td>";
$righe .= "<td>";
$queryd = "SELECT * FROM qui_utenti WHERE user_id = '$rigaaaa[id_resp]'";
$resultd = mysql_query($queryd);
while ($rowd = mysql_fetch_array($resultd)) {
$righe .= stripslashes($rowd[nome]);
}
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[nome_unita]);
$righe .= "</td>";
$righe .= "<td>";
  $righe .= $rigaaaa[codice_art];
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[descrizione]);
$righe .= "</td>";
$righe .= "<td>";
$righe .= $rigaaaa[gruppo_merci];
$righe .= "</td>";
$righe .= "<td>";
$righe .= numdecim($rigaaaa[quant]*1);
$righe .= "</td>";
$righe .= "<td>";
$righe .= numdecim($rigaaaa[prezzo]*1);
$righe .= "</td>";
$righe .= "<td>";
$righe .= numdecim($rigaaaa[totale]*1);
$righe .= "</td>";
$righe .= "<td>";
switch ($rigaaaa[stato_ordine]) {
	case "1":
	$righe .= "Inserita";
	break;
	case "2":
	$righe .= "Approvata";
	break;
	case "3":
	$righe .= "In processo";
	break;
	case "4":
	$righe .= "Completata";
	break;
}
$righe .= "</td>";
$righe .= "<td>";
$righe .= $rigaaaa[stato_ordine]." - ".$rigaaaa[output_mode];
$righe .= "</td>";
$righe .= "<td>";
if ($rigaaaa['wbs'] != "") {
$righe .= tratta($rigaaaa[wbs]);
}
$righe .= "</td>";
$righe .= "</tr>";
//fine if
//}
//fine while
}


/*Formattazione record CSV
A questo punto andiamo a formattare ogni riga separando i campi con la tabulazione ed includendo i campi di testo con i doppi apici. 
Il carattere speciale di tabulazione in php � "\t" e per includere i doppi apici useremo sempre lo slash;
davanti ai campi solo numerici bisogna mettere un carattere qualsiasi, in questo caso un punto
per evitare che excel si "mangi" gli zeri iniziali
*/
/*togliere questo
do {
$righe.= "\"".$row_clienti['nome']."\"\t\"".$row_clienti['cognome']."\"\t\"".$row_clienti['azienda']."\"\t\"".$row_clienti['citta']."\"\t\"".$row_clienti['prov']."\"\t\"".$row_clienti['stato']."\"\t\".".$row_clienti['telefono']."\"\t\".".$row_clienti['cellulare']."\"\t\"".$row_clienti['email']."\"\t\"".$row_clienti['username']."\"\t\".".$row_clienti['password']."\"\t\"".$row_clienti['lingua']."\"\t\"".$row_clienti['ufficio']."\"\t\"".date("d/m/Y",$row_clienti['data_registr'])."\"\n";
} while ($row_clienti= mysql_fetch_assoc($clienti));

/*L'invio del Mime-Type
Questa � la parte fondamentale di tutto il codice, l'invio del'header con il  Mime-Type adatto per Excel. 
Attenzione a non inviare nulla in output prima dell'header, pena il mancato funzionamento;
*/
   $filename="Elenco_righe_in_processo.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<html>
<head>
  <title>Esportazione excel righe in processo</title>
<meta charset="utf-8">
</head>
<body>
<table>
<?php
echo $header;
echo $righe;
?>
</table>

</body>
</html>
