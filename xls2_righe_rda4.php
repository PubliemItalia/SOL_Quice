<?php
/*Supponiamo di voler esportare in Excel un elenco clienti da un applicativo php/MySQl 
la prima cosa da fare sar ovviamente la query sul db per l'estrazione dati, che sar qualcosa di simile;
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
$stringa = str_replace("è","",$stringa);
$stringa = str_replace("","e",$stringa);
$stringa = str_replace("","i",$stringa);
$stringa = str_replace("","o",$stringa);
$stringa = str_replace("","u",$stringa);
$stringa = str_replace("","",$stringa);
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
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$a = "negozio = '$shopDaModulo'";
$clausole++;
}
if (isset($_GET['unita'])) {
$unitaDaModulo = $_GET['unita'];
} 
if ($unitaDaModulo != "") {
$b = "id_unita = '$unitaDaModulo'";
$clausole++;
}
if (isset($_GET['categoria_righe'])) {
$categ_DaModulo = $_GET['categoria_righe'];
} 
if ($categ_DaModulo != "") {
$c = "categoria = '$categ_DaModulo'";
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
$d = "(data_inserimento BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = "";
}
if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$e = "id_rda = '$nrRdaDaModulo'";
$clausole++;
}
if (isset($_GET['codice_art'])) {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$f = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}
if (isset($_GET['nr_pl'])) {
$nrPlDaModulo = $_GET['nr_pl'];
} 
if ($nrPlDaModulo != "") {
$g = "pack_list = '$nrPlDaModulo'";
$clausole++;
}
if ($_GET['archivio']!= "") {
$archivioDaModulo = $_GET['archivio'];
} 
//if ($archivioDaModulo != "") {
	switch ($archivioDaModulo) {
		case "":
		$h = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "0":
		break;
		case "1":
		$h = "n_fatt_sap = ''";
		$clausole++;
		break;
		case "2":
		$h = "n_fatt_sap != ''";
		$clausole++;
		break;
	}
//	}

if ($_GET['societa']!= "") {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
	switch ($societaDaModulo) {
		case "sol":
		  $dest_contab = "SOLSPA";
		break;
		case "vivisol":
		  $dest_contab = "VIVISOL";
		break;
	}
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$l = "dest_contab LIKE '%".$dest_contab."%'";
$clausole++;
}
if (isset($_GET['doc'])) {
$docDaModulo = $_GET['doc'];
} 
if ($docDaModulo != "") {
$m = "dest_contab LIKE '%".$docDaModulo."%'";
$clausole++;
}
if (isset($_GET['status'])) {
$statusDaModulo = $_GET['status'];
} 
if ($statusDaModulo == "4") {
$n = "stato_ordine = '4'";
$clausole++;
} else {
$n = "(stato_ordine BETWEEN '2' AND '3')";
$clausole++;
}
if (isset($_GET['output_mode'])) {
$output_modulo = $_GET['output_mode'];
} 
if ($output_modulo != "") {
$p = "output_mode = '".$output_modulo."'";
$clausole++;
}
if (isset($_GET['flag_chiusura'])) {
$flagDaModulo = $_GET['flag_chiusura'];
} 
if ($flagDaModulo != "") {
$q = "flag_chiusura = '".$flagDaModulo."'";
$clausole++;
}

//costruzione query
if ($clausole > 0) {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE ";
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = '4' AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE stato_ordine = '4' AND ";

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
if ($l != "") {
$testoQuery .= $l;
$sumquery .= $l;
}
if ($m != "") {
$testoQuery .= $m;
$sumquery .= $m;
}
if ($n != "") {
$testoQuery .= $n;
$sumquery .= $n;
}
if ($p != "") {
$testoQuery .= $p;
$sumquery .= $p;
}
if ($q != "") {
$testoQuery .= $q;
$sumquery .= $q;
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
if ($l != "") {
$testoQuery .= $l." AND ";
$sumquery .= $l." AND ";
}
if ($m != "") {
$testoQuery .= $m." AND ";
$sumquery .= $m." AND ";
}
if ($n != "") {
$testoQuery .= $n." AND ";
$sumquery .= $n." AND ";
}
if ($p != "") {
$testoQuery .= $p." AND ";
$sumquery .= $p." AND ";
}
if ($q != "") {
$testoQuery .= $q;
$sumquery .= $q;
}
}
} else {
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

/*$header .= "<tr>";
$header .= "<td>";
$header .= $testoQuery;
$header .= "</td>";
$header .= "<tr>";
*/
$header .= "<tr>";
$header .= "<td>";
$header .= "RdA";
$header .= "</td>";
$header .= "<td>";
$header .= "Società";
$header .= "</td>";
$header .= "<td>";
$header .= "Data inserimento";
$header .= "</td>";
$header .= "<td>";
$header .= "Negozio";
$header .= "</td>";
$header .= "<td>";
$header .= "Output";
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
$rda = mysql_query($querya) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigaaaa = mysql_fetch_array($rda)) {
$righe .= "<tr>";
$righe .= "<td>";
$righe .= $rigaaaa[id_rda];
$righe .= "</td>";
$righe .= "<td>";
$righe .= $rigaaaa[azienda_prodotto];
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
$righe .= tratta($rigaaaa[output_mode]);
$righe .= "</td>";
$righe .= "<td>";
$queryd = "SELECT * FROM qui_unita WHERE id_unita = '$rigaaaa[id_unita]'";
$resultd = mysql_query($queryd);
while ($rowd = mysql_fetch_array($resultd)) {
$righe .= stripslashes($rowd[nome_resp]);
}
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[nome_unita]);
$righe .= "</td>";
$righe .= "<td>";
$righe .= tratta($rigaaaa[codice_art]);
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
if ($rigaaaa['wbs'] != "") {
$righe .= tratta($rigaaaa[wbs]);
}
$righe .= "</td>";
$righe .= "</tr>";
}

/*L'invio del Mime-Type
Questa  la parte fondamentale di tutto il codice, l'invio del'header con il  Mime-Type adatto per Excel. 
Attenzione a non inviare nulla in output prima dell'header, pena il mancato funzionamento;
*/
   $filename="Elenco_righe_rda.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<html>
<head>
  <title>Esportazione excel righe rda</title>
<meta charset="utf-8">
</head>
<body>
<table>
<?php
echo $header;
echo $righe;
//echo "testoQuery: ".$testoQuery;

?>
</table>

</body>
</html>
