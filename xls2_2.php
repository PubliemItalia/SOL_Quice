<?php
/*Supponiamo di voler esportare in Excel un elenco clienti da un applicativo php/MySQl 
la prima cosa da fare sar� ovviamente la query sul db per l'estrazione dati, che sar� qualcosa di simile;
*/
//include "validation.php";
function numdecim($stringa) {
$arr_stringa = explode(".",$stringa);
$parte_int = $arr_stringa[0];
$parte_decim = $arr_stringa[1];
$num_fin = $parte_int.",".$parte_decim;
return $num_fin;
}
function tratta($stringa) {
$stringa = str_replace("è","�",$stringa);
$stringa = str_replace("�","e",$stringa);
$stringa = str_replace("�","i",$stringa);
$stringa = str_replace("�","o",$stringa);
$stringa = str_replace("�","u",$stringa);
$stringa = str_replace("�","�",$stringa);
$stringa = stripslashes($stringa);
$stringa = str_replace("\n"," ",$stringa);
$stringa = str_replace("\r"," ",$stringa);
$stringa = str_replace("\p"," ",$stringa);
return $stringa;
}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$ordinamento = "id DESC";
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
if (isset($_GET['stato_rda'])) {
$stato_rdaDaModulo = $_GET['stato_rda'];
} 
if ($stato_rdaDaModulo != "") {
$b = "stato = '$stato_rdaDaModulo'";
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
//$gginizio = $pieces_inizio[0]; 
//$mminizio = $pieces_inizio[1];
//$aaaainizio = $pieces_inizio[2];
$gginizio = $pieces_inizio[1]; 
$mminizio = $pieces_inizio[0];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
//$ggfine = $pieces_fine[0]; 
//$mmfine = $pieces_fine[1];
//$aaaafine = $pieces_fine[2];
$ggfine = $pieces_fine[1]; 
$mmfine = $pieces_fine[0];
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
if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$e = "id = '$nrRdaDaModulo'";
$clausole++;
}



//costruzione query
if ($clausole > 0) {
//$testoQuery = "SELECT * FROM qui_rda WHERE flag_storico = '1' AND ";
$testoQuery = "SELECT * FROM qui_rda WHERE totale_rda != '0.00' AND ";
$sumquery =   "SELECT SUM(totale_rda) as somma FROM qui_rda WHERE totale_rda != '0.00' AND ";

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
$testoQuery .= $f;
$sumquery .= $f;
}
}
} else {
$testoQuery = "SELECT * FROM qui_rda WHERE totale_rda != '0.00'";
$sumquery =   "SELECT SUM(totale_rda) as somma FROM qui_rda WHERE totale_rda != '0.00'";
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

//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 25; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 

$testoQuery .= " ORDER BY id DESC";
//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito pi� sotto
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
//$query1 = "SELECT * FROM ".$prefix."clienti";
$header .= "<tr>";
$header .= "<td>";
$header .= "RdA";
$header .= "</td>";
$header .= "<td>";
$header .= "Data inserimento";
$header .= "</td>";
$header .= "<td>";
$header .= "Data chiusura";
$header .= "</td>";
$header .= "<td>";
$header .= "Tracciato SAP";
$header .= "</td>";
$header .= "<td>";
$header .= "Negozio";
$header .= "</td>";
$header .= "<td>";
$header .= "Nome unita";
$header .= "</td>";
$header .= "<td>";
$header .= "Nome utente";
$header .= "</td>";
$header .= "<td>";
$header .= "Nome resp";
$header .= "</td>";
$header .= "<td>";
$header .= "Stato";
$header .= "</td>";
$header .= "<td>";
$header .= "Totale RdA";
$header .= "</td>";
$header .= "<td>";
$header .= "Note utente";
$header .= "</td>";
$header .= "<td>";
$header .= "Note responsabile";
$header .= "</td>";
$header .= "<td>";
$header .= "Note buyer";
$header .= "</td>";
$header .= "<td>";
$header .= "Note magazziniere";
$header .= "</td>";
$header .= "</tr>";
//stampa file
//$query = "SELECT * FROM ".$prefix."clienti";

$rda = mysql_query($querya) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigaaaa = mysql_fetch_array($rda)) {
$righe .= "<tr>";
$righe .= "<td>";
$righe .= $rigaaaa[id];
$righe .= "</td>";
$righe .= "<td>";
if ($rigaaaa['data_inserimento'] > 0) {
$righe .= date("d/m/Y",$rigaaaa['data_inserimento']);
}
$righe .= "</td>";
$righe .= "<td>";
if ($rigaaaa['data_approvazione'] > 0) {
$righe .= date("d/m/Y",$rigaaaa['data_approvazione']);
}
$righe .= "</td>";
$righe .= "<td>";
$querysss = "SELECT * FROM qui_files_sap WHERE id_rda = '$rigaaaa[id]' ORDER BY id ASC";
$resultsss = mysql_query($querysss);
while ($rowsss = mysql_fetch_array($resultsss)) {
$righe .= "(".$rowsss[id].")";
}
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[negozio]);
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[nome_unita]);
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[nome_utente]);
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[nome_resp]);
$righe .= "</td>";
$righe .= "<td>";
switch ($rigaaaa[stato]) {
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
$righe .= numdecim($rigaaaa[totale_rda]*1);
$righe .= "</td>";
$righe .= "<td>";
$righe .= str_replace("<br>"," ",tratta($rigaaaa[note_utente]));
$righe .= "</td>";
$righe .= "<td>";
$righe .= str_replace("<br>"," ",tratta($rigaaaa[note_resp]));
$righe .= "</td>";
$righe .= "<td>";
$righe .= str_replace("<br>"," ",tratta($rigaaaa[note_buyer]));
$righe .= "</td>";
$righe .= "<td>";
$righe .= str_replace("<br>"," ",tratta($rigaaaa[note_magazziniere]));
$righe .= "</td>";
$righe .= "</tr>";
//fine while
}

/*L'invio del Mime-Type
Questa � la parte fondamentale di tutto il codice, l'invio del'header con il  Mime-Type adatto per Excel. 
Attenzione a non inviare nulla in output prima dell'header, pena il mancato funzionamento;
*/
   $filename="Elenco_rda.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<html>
<head>
  <title>Esportazione excel rda</title>
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
