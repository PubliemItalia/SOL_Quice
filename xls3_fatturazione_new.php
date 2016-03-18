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
$doc = $_GET['doc'];
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
//$gginizio = $pieces_inizio[0]; 
//$mminizio = $pieces_inizio[1];
//$aaaainizio = $pieces_inizio[2];
$gginizio = $pieces_inizio[0]; 
$mminizio = $pieces_inizio[1];
$aaaainizio = $pieces_inizio[2];
$inizio_range = mktime(0,0,0,intval($mminizio), intval($gginizio), intval($aaaainizio));
}
if ($data_fine != "") {
$pieces_fine = explode("/", $data_fine);
//$ggfine = $pieces_fine[0]; 
//$mmfine = $pieces_fine[1];
//$aaaafine = $pieces_fine[2];
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
$inizio_range = mktime(12,30,0,1,1,2013);
$fine_range = mktime();
$c = "(data_chiusura BETWEEN '$inizio_range' AND '$fine_range')";
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
$f = "flag_chiusura = '1'";
//$h = "evaso_magazzino = '1'";
$clausole++;

if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
$g = "azienda_prodotto = '".$societaDaModulo."'";
$clausole++;
}

switch ($doc) {
	case "G":
	case "F":
	  $m = "n_ord_sap = ''";
	  $clausole++;
	  $ordinamento = "pack_list DESC";
	break;
	case "R":
	  $m = "n_ord_sap != ''";
	  $doc = "F";
	  $arc = "1";
	  $clausole++;
	  $ordinamento = "pack_list DESC";
	break;
}

$h = "pack_list > '0'";
$clausole++;

//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole == 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' ";
} else {
$testoQuery = "SELECT * FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ";
$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE dest_contab LIKE '%".$doc."%' AND ";
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


//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento;
$array_units_ids = array();
$array_units = array();
$array_pl = array();
$array_ord_sap = array();
$array_fatt_sap = array();
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	if (!in_array($row[pack_list],$array_pl)) {
		$add_pl = array_push($array_pl,$row[pack_list]);
	}
	if (!in_array($row[nome_unita],$array_units)) {
		$add_unit = array_push($array_units,$row[nome_unita]);
	}
	if ($row[n_ord_sap] != "0") {
	  if (!in_array($row[n_ord_sap],$array_ord_sap)) {
		  $add_ord = array_push($array_ord_sap,$row[n_ord_sap]);
	  }
	}
	if ($row[n_fatt_sap] != "0") {
	  if (!in_array($row[n_fatt_sap],$array_fatt_sap)) {
		  $add_fatt = array_push($array_fatt_sap,$row[n_fatt_sap]);
	  }
	}
}
sort($array_units);
foreach ($array_units as $cada_unit) {
	$queryt = "SELECT * FROM qui_unita WHERE nome_unita = '$cada_unit'";
	$resultt = mysql_query($queryt);
	while ($rowt = mysql_fetch_array($resultt)) {
	$add_id_unit = array_push($array_units_ids,$rowt[id_unita]);
	}
}
sort($array_fatt_sap);
sort($array_ord_sap);


//echo "testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
//}
switch ($doc) {
//BLOCCO PER PAGINA RICHIESTA FATTURA
case "F":
case "G":
  foreach ($array_units_ids as $sing_unit) {
  $array_pl_unit = array();
  foreach ($array_pl as $ogni_pl) {
	  $queryw = "SELECT * FROM qui_packing_list WHERE id = '$ogni_pl'";
	  $resultw = mysql_query($queryw);
	  while ($roww = mysql_fetch_array($resultw)) {
		  if ($roww[id_unita] == $sing_unit) {
			$add_pl_unit = array_push($array_pl_unit,$ogni_pl);
		  }
	  }
  }
  foreach ($array_pl_unit as $pl_singolo) {
	  $contatore = $contatore +1;
	  $queryz = "SELECT * FROM qui_unita WHERE id_unita = '$sing_unit'";
	  $resultz = mysql_query($queryz);
	  while ($rowz = mysql_fetch_array($resultz)) {
		$nome_sing_unita = $rowz[nome_unita];
	  }
	  $righe .= "<tr>";
	  $righe .= "<td>";
	  $righe .= tratta($nome_sing_unita);
	  $righe .= "</td>";
	  $righe .= "</tr>";
  foreach ($array_pl as $sing_pl) {
	  $queryx = "SELECT * FROM qui_packing_list WHERE id = '$sing_pl' AND id_unita = '$sing_unit'";
	  $resultx = mysql_query($queryx);
	  $presenza_pl = mysql_num_rows($resultx);
	  while ($rowx = mysql_fetch_array($resultx)) {
		$n_ord_sap = $rowx[n_ord_sap];
		$n_fatt_sap = $rowx[n_fatt_sap];
	  }
	  if ($presenza_pl > 0) {
	$array_rda_pl = array();
	$array_resp = array();
	  $querys = "SELECT * FROM qui_corrispondenze_pl_rda WHERE pl = '$sing_pl'";
	  $results = mysql_query($querys);
	  while ($rows = mysql_fetch_array($results)) {
		if (!in_array($rows[rda],$array_rda_pl)) {
		  $add_rdapl = array_push($array_rda_pl,$rows[rda]);
		}
	  }
	  foreach ($array_rda_pl as $sing_rdapl) {
		$lista_rdapl .= $sing_rdapl." ";
		$queryh = "SELECT * FROM qui_rda WHERE id = '$sing_rdapl'";
		$resulth = mysql_query($queryh);
		while ($row = mysql_fetch_array($resulth)) {
			$lista_unita = $row[nome_unita]." ";
		  $queryk = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
		  $resultk = mysql_query($queryk);
		  while ($rowk = mysql_fetch_array($resultk)) {
			$lista_resp = $rowk[nome]." ";
		  }
		}
	  }
	  $lista_rdapl = "";
	  $lista_resp = "";
	  $lista_unita = "";
	//singolo contenitore
  //stampa file
	  foreach ($array_rda_pl as $sing_rdapl) {
		echo "RdA ".$sing_rdapl;
		//if ($clausole <= 5) {
		  $queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' ORDER BY gruppo_merci ASC";
		//} else {
		  //$queryg = "SELECT * FROM qui_righe_rda WHERE id_rda = '$sing_rdapl' AND pack_list = '$sing_pl' AND dest_contab = '$dest_contab' ORDER BY gruppo_merci ASC";
		//}
	   //echo '<span style="color:red;">clausole: '.$clausole.'<br>';
	   //echo $queryg.'</span><br>';
		$resultg = mysql_query($queryg);
		while ($rowg = mysql_fetch_array($resultg)) {
		  if ($rowg[gruppo_merci] != $gruppo_merci_uff) {
			$gruppo_merci_uff = $rowg[gruppo_merci];
			$querys = "SELECT * FROM qui_gruppo_merci WHERE gruppo_merce = '$gruppo_merci_uff'";
			$results = mysql_query($querys);
			while ($rows = mysql_fetch_array($results)) {
			  $descrizione_gruppo_merci = $rows[descrizione];
			  $codice_sap = $rows[codice_sap];
			}
			$sum_grm = "SELECT SUM(totale) as somma_grm FROM qui_righe_rda WHERE pack_list = '$sing_pl' AND gruppo_merci = '$gruppo_merci_uff'";
			$resultz = mysql_query($sum_grm);
			list($somma_grm) = mysql_fetch_array($resultz);
			$totale_grm = $somma_grm;
			$righe .= "<tr>";
			$righe .= "<td>";
			$righe .= $gruppo_merci_uff;
			$righe .= "</td>";
			$righe .= "<td>";
			$righe .= $codice_sap." ".stripslashes($descrizione_gruppo_merci);
			$righe .= "</td>";
			$righe .= "<td>";
			$righe .= number_format($totale_grm,2,",",".");
			$righe .= "</td>";
			$righe .= "</tr>";
			$totale_grm = "";
		  }
		  $righe .= "<tr>";
		  $righe .= "<td>";
		  $righe .= $rowg[pack_list];
		  $righe .= "</td>";
		  $righe .= "<td>";
		  $righe .= $rowg[id_rda];
		  $righe .= "</td>";
		  $righe .= "<td>";
		  $righe .= $rowg[azienda_prodotto];
		  $righe .= "</td>";
		  $righe .= "<td>";
		  if ($rowg['data_chiusura'] > 0) {
		  $righe .= date("d/m/Y",$rowg['data_chiusura']);
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
			  if (substr($rowg[codice_art],0,1) != "*") {
				echo $rowg[codice_art];
				$righe .= tratta($rowg[codice_art]);
			  } else {
				$righe .= substr($rowg[codice_art],1);
			  }
		  $righe .= "</td>";
		  $righe .= "<td>";
		  $righe .= tratta($rowg[descrizione]);
		  $righe .= "</td>";
		  $righe .= "<td>";
		  $righe .= numdecim(intval($rowg[quant]*1));
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
		//fine while $sing_rdapl
		}
	  //fine foreach ($array_rda_pl as $sing_rdapl) {
	  }
  
	$gruppo_merci_uff = "";
	$TOTALE_pl = "";
	//fine if pl appartiene all'unità
	}
	$presenza_pl = "";
	//FINE FOREACH PL
  }
  $totale_fattura = "";
  
	$n_ord_sap = "";
	//FINE FOREACH UNITA'
  }
  break;
}
  }







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
$header .= "Packing List";
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
