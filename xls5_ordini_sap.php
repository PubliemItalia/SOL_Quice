<?php
session_start();
/*Supponiamo di voler esportare in Excel un elenco clienti da un applicativo php/MySQl 
la prima cosa da fare sar ovviamente la query sul db per l'estrazione dati, che sar qualcosa di simile;
*/
//include "validation.php";
$id_utente = $_SESSION[user_id];
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
$ordinamento = "id_rda DESC";
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
$campidate = "";
}
if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if ($shopDaModulo != "") {
$d = "negozio = '$shopDaModulo'";
$clausole++;
}
$output_modulo = "sap";
$flag_chiusura = "1";
if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
	//echo '<span style="color: #000;">azienda: SOL</span><br>';
$f = "azienda_prodotto = '$societaDaModulo'";
$clausole++;
}
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 
//echo "shopDaModulo: ".$shopDaModulo."<br>";

//costruzione query
//ogni buyer ha alcuni negozi da gestire e sono indicati nella tabella "qui_buyer_negozi"
//ATTENZIONE: lo switch qui sotto serve perchè se nei filtri viene specificato il negozio, la ricerca va fatta solo su quello, e la tabella deve essere esclusa
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
	$num_negozi_buyer = mysql_num_rows($risultt);
	$z = 1;
    while ($rigat = mysql_fetch_array($risultt)) {
	  if ($z == 1) {
		$blocco_negozi_buyer .= "(negozio = '".$rigat[negozio]."'";
	  } else {
		$blocco_negozi_buyer .= " OR negozio = '".$rigat[negozio]."'";
	  }
	  $z = $z+1;
	  if ($z > $num_negozi_buyer) {
		$blocco_negozi_buyer .= ")";
	  }
	}
if ($clausole > 0) {
  if ($shopDaModulo != "") {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE stato_ordine = 4  AND output_mode = 'sap' AND flag_chiusura = '1' AND ";
  } else {
	$testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' AND ";
  }
  if ($clausole == 1) {
	if ($a != "") {
	  $testoQuery .= $a;
	}
	if ($b != "") {
	  $testoQuery .= $b;
	}
	if ($c != "") {
	  $testoQuery .= $c;
	}
	if ($d != "") {
	  $testoQuery .= $d;
	}
	if ($e != "") {
	  $testoQuery .= $e;
	}
	if ($f != "") {
	  $testoQuery .= $f;
	}
	if ($g != "") {
	  $testoQuery .= $g;
	}
  } else {
	if ($a != "") {
	  $testoQuery .= $a." AND ";
	}
	if ($b != "") {
	  $testoQuery .= $b." AND ";
	}
	if ($c != "") {
	  $testoQuery .= $c." AND ";
	}
	if ($d != "") {
	  $testoQuery .= $d." AND ";
	}
	if ($e != "") {
	  $testoQuery .= $e." AND ";
	}
	if ($f != "") {
	  $testoQuery .= $f." AND ";
	}
	if ($g != "") {
	  $testoQuery .= $g;
	}
  }
} else {
  $testoQuery = "SELECT * FROM qui_righe_rda WHERE ".$blocco_negozi_buyer." AND stato_ordine = 4 AND output_mode = 'sap' AND flag_chiusura = '1' ";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}


//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento;
//echo "testoQuery: ".$testoQuery."<br>";
$querya = $testoQuery;
$resulta = mysql_query($querya);



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
$header .= "Ord. SAP";
$header .= "</td>";
$header .= "<td>";
$header .= "Fornitore";
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
$righe .= $rigaaaa[ord_fornitore];
$righe .= "</td>";
$righe .= "<td>";
$righe .= $rigaaaa[fornitore_tx];
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
