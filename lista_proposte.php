<?php 
/*include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione","operatore","agente");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
*/
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
$lingua = $_SESSION[lang];
$id_utente = $_SESSION[user_id];


$pag_attuale = "proposte";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
$archive = $_GET['archive'];
include "functions.php";
//include "funzioni.js";

if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[nazione_ric] = "";
$_SESSION[descrizione] = "";
$_SESSION[negozio] = "";
$_SESSION[categoria] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_POST['page'] != "") {
$page = $_POST['page'];
} else {
$page = $_GET['page'];
}
if ($_POST['limit'] != "") {
$limit = $_POST['limit'];
} else {
$limit = $_GET['limit'];
}
$avviso = $_GET['avviso'];
$ordinamento = "ultima_modifica DESC";

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
if (isset($_GET['categoria_righe'])) {
$categ_DaModulo = $_GET['categoria_righe'];
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
if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$e = "id_rda = '$nrRdaDaModulo'";
$clausole++;
}
/*
if (isset($_GET['gruppo_merci_righe'])) {
$gruppo_merciDaModulo = $_GET['gruppo_merci_righe'];
} 
if ($gruppo_merciDaModulo != "") {
$f = "gruppo_merci = '$gruppo_merciDaModulo'";
$clausole++;
}
*/
if (isset($_GET['codice_art'])) {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$g = "codice_art = '$codice_artDaModulo'";
$clausole++;
}
//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole > 0) {
//$testoQuery = "SELECT * FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
$testoQuery = "SELECT * FROM qui_proposte_prodotti WHERE ";
//$sumquery =   "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";

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
$testoQuery .= $h;
$sumquery .= $h;
}
}
} else {
$testoQuery = "SELECT * FROM qui_proposte_prodotti";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}

//condizioni per evitare errori
if(($limit == "") OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 50; //default
 } 

if(($page == "") OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 

//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito più sotto
//if ($clausole > 0) {
$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);
//}

//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}

echo "testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
include "menu_quice3.php";
?>
<html>
<head>
  <title>Quice - Lista proposte inserimento prodotti</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report.css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  //window.location.reload();
  location.replace('report_righe.php?selezione_singola=&selezione_multipla=');
}
</SCRIPT>
<script type="text/javascript" src="tinybox.js"></script>

</head>
<body>
<div id="main_container">
<div id="contenitore_testata">
<div class="box_100_20">
Negozio
</div>
<div class="box_100_20">
Categoria 1
</div>
<div class="box_100_20">
Categoria 2
</div>
<div class="box_100_20">
Descrizione 1
</div>
<div class="box_100_20">
Descrizione 2
</div>
<div class="box_40">
Gr. merci
</div>
<div class="box_40">
Confezione
</div>
<div class="box_40">
Prezzo
</div>
<div class="box_80">
Utente
</div>
<div class="box_80">
Responsabile
</div>
</div>
  <?php
/*
//riga del totale
echo "<div class=contenitore_riga>";
echo "<div class=box_120>";
echo "TOTALE";
echo "</div>";
echo "<div class=box_450>";
echo "</div>";
echo "<div class=box_130_dx>";
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($totale_storico_rda,2,",",".");
echo "</div>";
echo "<div class=box_100_20>";
echo "</div>";

echo "</div>";	
*/
//if ($clausole > 0) {
 $querya = $testoQuery;
 $sf = 1;
//$querya = $testoQuery;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
echo "<div class=contenitore_riga>";
	if ($xx == 0) {
$xx = $xx+1;
	} else {
$xx = "0";
	}
echo "<div class=box_100_20>";
echo $row[negozio];
echo "</div>";
echo "<div class=box_100_20>";
echo $row[categoria1_it];
echo "</div>";
echo "<div class=box_100_20>";
echo $row[categoria2_it];
echo "</div>";
echo "<div class=box_120>";
echo stripslashes($row[descrizione1_it])."<br>";
echo "</div>";
echo "<div class=box_120>";
echo stripslashes($row[descrizion2_it]);
echo "</div>";
echo "<div class=box_40>";
echo $row[gruppo_merci];
echo "</div>";
echo "<div class=box_40>";
echo $row[confezione];
echo "</div>";
echo "<div class=box_40>";
echo number_format($row[prezzo],2,",",".");
echo "</div>";
echo "<div class=box_80>";
echo $row[mail_proponente]."<br>";
echo "</div>";
echo "<div class=box_80>";
echo $row[mail_resp];
echo "</div>";
echo "</div>";	
}
//}
?>
<!--</form>--> 
    <table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">
    <?php

//posizione per paginazione
$last_page = $total_pages;
   if ($total_pages <= 10) {
  	 	$pag_iniz = 1;
  	 	$pag_fin = $total_pages -1;
   } else {
	   if ($page < ($total_pages - 10)) {
			$pag_iniz = $page;
			$pag_fin = $page + 9;
	   } else {
			$pag_iniz = $total_pages - 10;
			$pag_fin = $total_pages -1;
	   }
   }
$prev_page = $page - 1;
/*
//variabili da aggiungere ai numeri della paginazione per la ricerca corretta
$categ_DaModulo = $_GET['categoria_righe'];
$unitaDaModulo = $_GET['unita'];
$data_inizio = $_GET['data_inizio'];
$data_fine = $_GET['data_fine'];
$shopDaModulo = $_GET['shop'];
$nrRdaDaModulo = $_GET['nr_rda'];
$gruppo_merciDaModulo = $_GET['gruppo_merci_righe'];
$codice_artDaModulo = $_GET['codice_art'];
*/

   if($page > 1) {
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&categoria_righe=".$categ_DaModulo."&gruppo_merci_righe=".$gruppo_merciDaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b>1</b></a>"; 
  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&categoria_righe=".$categ_DaModulo."&gruppo_merci_righe=".$gruppo_merciDaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&categoria_righe=".$categ_DaModulo."&gruppo_merci_righe=".$gruppo_merciDaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&categoria_righe=".$categ_DaModulo."&gruppo_merci_righe=".$gruppo_merciDaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&categoria_righe=".$categ_DaModulo."&gruppo_merci_righe=".$gruppo_merciDaModulo."&codice_art=".$codice_artDaModulo."&lang=".$lingua."><b>".$last_page."</b></a>"; 
?>
        </td>
      </tr>
    </table>


    </div>
</body>
</html>
