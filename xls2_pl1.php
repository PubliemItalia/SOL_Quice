<?php
/*Supponiamo di voler esportare in Excel un elenco clienti da un applicativo php/MySQl 
la prima cosa da fare sarà ovviamente la query sul db per l'estrazione dati, che sarà qualcosa di simile;
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
  if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$b = "id_rda = '$nrRdaDaModulo'";
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
$campidate = 1;
$inizio_range = mktime(12,30,0,10,1,2013);
$fine_range = mktime();
$c = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
if (isset($_GET['nr_pl'])) {
$nr_plDaModulo = $_GET['nr_pl'];
} 
if ($nr_plDaModulo != "") {
$e = "n_ord_sap LIKE '%$nr_plDaModulo%'";
$clausole++;
}
if (isset($_GET['nazione'])) {
$nazioneDaModulo = $_GET['nazione'];
} 
//if ($nazioneDaModulo != "") {
	switch ($nazioneDaModulo) {
		case "":
		$f = "nazione != 'Italy'";
		$clausole++;
		break;
		case "tutte":
		break;
		case "eu":
		$f = "nazione != 'Italy'";
		$clausole++;
		break;
		case "it":
		$f = "nazione = 'Italy'";
		$clausole++;
		break;
	}
//}

if (isset($_GET['archivio'])) {
$archivioDaModulo = $_GET['archivio'];
} 
//if ($archivioDaModulo != "") {
	switch ($archivioDaModulo) {
		case "":
		$m = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "0":
		break;
		case "1":
		$m = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "2":
		$m = "n_fatt_sap != ''";
		$clausole++;
		break;
	}
//	}

if (isset($_GET['nr_rda'])) {
$nr_rdaDaModulo = $_GET['nr_rda'];
} 
if ($nr_rda != "") {
$g = "id_rda = '$nr_rdaDaModulo'";
$clausole++;
}

$h = "stato_ordine = '4'";
//$h = "evaso_magazzino = '1'";
$clausole++;

$j = "output_mode = 'mag'";
$clausole++;



//costruzione query
if ($clausole == 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_righe_rda ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda ";
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE  ";
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
if ($h != "") {
$testoQuery .= $h;
$sumquery .= $h;
}
if ($j != "") {
$testoQuery .= $j;
$sumquery .= $j;
}
if ($m != "") {
$testoQuery .= $m;
$sumquery .= $m;
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
$testoQuery .= $g." AND ";
$sumquery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h." AND ";
$sumquery .= $h." AND ";
}
if ($j != "") {
$testoQuery .= $j." AND ";
$sumquery .= $j." AND ";
}
if ($m != "") {
$testoQuery .= $m;
$sumquery .= $m;
}
}
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4'";
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
//fine valutazione criteri, inizia il corpo della tabella
$array_rda = array();
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	if (!in_array($row[id_rda],$array_rda)) {
		$add_rda = array_push($array_rda,$row[id_rda]);
	}
}
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
$header .= "Quant.";
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
$header .= "WBS";
$header .= "</td>";
$header .= "</tr>";

//stampa file
foreach ($array_rda as $sing_rda) {
  $queryh = "SELECT * FROM qui_rda WHERE id = '$sing_rda'";
  $resulth = mysql_query($queryh);
  while ($row = mysql_fetch_array($resulth)) {
	$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rda' ORDER BY gruppo_merci ASC";
	$resultg = mysql_query($queryg);
	while ($rowg = mysql_fetch_array($resultg)) {
	$righe .= "<tr>";
	$righe .= "<td>";
	$righe .= $rowg[id_rda];
	$righe .= "</td>";
	$righe .= "<td>";
		if ($rowg['data_inserimento'] > 0) {
		  $righe .= date("d/m/Y",$rowg['data_inserimento']);
		}
	$righe .= "</td>";
	$righe .= "<td>";
		$righe .= tratta($rowg[negozio]);
	$righe .= "</td>";
	$righe .= "<td>";
	$queryd = "SELECT * FROM qui_utenti WHERE user_id = '$rigaaaa[id_resp]'";
	$resultd = mysql_query($queryd);
	while ($rowd = mysql_fetch_array($resultd)) {
	  $righe .= stripslashes($rowd[nome]);
	}
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= tratta($rowg[nome_unita]);
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= tratta($rowg[codice_art]);
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= tratta($rowg[descrizione]);
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= $rowg[gruppo_merci];
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= numdecim($rowg[quant]*1);
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= numdecim($rowg[prezzo]*1);
	$righe .= "</td>";
	$righe .= "<td>";
	  $righe .= numdecim($rowg[totale]*1);
	$righe .= "</td>";
	$righe .= "<td>";
	  switch ($rowg[stato_ordine]) {
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
	  if ($rowg['wbs'] != "") {
		$righe .= tratta($rowg[wbs]);
	  }
	$righe .= "</td>";
	$righe .= "</tr>";
	//fine while righe rda
	}
  //fine while rda
  }
//fine foreach
}

/*L'invio del Mime-Type
Questa è la parte fondamentale di tutto il codice, l'invio del'header con il  Mime-Type adatto per Excel. 
Attenzione a non inviare nulla in output prima dell'header, pena il mancato funzionamento;
*/
   $filename="Elenco_pl.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<html>
<head>
  <title>Esportazione excel pl</title>
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
