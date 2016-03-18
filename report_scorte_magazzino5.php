<?php 
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
//echo "lingua: ".$lingua."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
//echo "selezione_singola: ".$selezione_singola."<br>";
//echo "selezione_multipla_app: ".$selezione_multipla_app."<br>";


include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
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
//echo "negozio buyer: ".$_SESSION[negozio_buyer]."<br>";
//echo "negozio2 buyer: ".$_SESSION[negozio2_buyer]."<br>";

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_POST['limit'] != "") {
$limit = $_POST['limit'];
} else {
$limit = $_GET['limit'];
}
if ($_POST['page'] != "") {
$page = $_POST['page'];
} else {
$page = $_GET['page'];
}
$ordinamento = "categoria1_it ASC";

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query

if (isset($_GET['shop'])) {
$shopDaModulo = $_GET['shop'];
} 
if (isset($_GET['categoria_ricerca'])) {
$categoria_ricercaDaModulo = $_GET['categoria_ricerca'];
} 
if ($categoria_ricercaDaModulo != "") {
$e = "categoria1_it = '$categoria_ricercaDaModulo'";
$clausole++;
}
if ($_GET['codice_art'] != "") {
$codice_artDaModulo = $_GET['codice_art'];
} 
if ($codice_artDaModulo != "") {
$f = "codice_art LIKE '%$codice_artDaModulo%'";
$clausole++;
}
if (isset($_GET['ricerca'])) {
$flag_ricerca = $_GET['ricerca'];
} 
if ($_GET['paese'] != "") {
$paeseDaModulo = $_GET['paese'];
} 
if ($paeseDaModulo != "") {
$g = "paese LIKE '%$paeseDaModulo%'";
$clausole++;
}
if ($_GET['categoria4'] != "") {
$categoria4DaModulo = $_GET['categoria4'];
} 
if ($categoria4DaModulo != "") {
$h = "categoria4_it LIKE '%$categoria4DaModulo%'";
$clausole++;
}

if ($_GET['dispo'] != "") {
$dispoDaModulo = $_GET['dispo'];
} 
if ($dispoDaModulo != "") {
  switch ($dispoDaModulo) {
	  case 0:
		$m = "giacenza <= soglia";
	  break;
	  case 1:
		$m = "giacenza > soglia";
	  break;
  }
$clausole++;
}
//echo "shopDaModulo: ".$shopDaModulo."<br>";

//costruzione query
//ogni buyer ha alcuni negozi da gestire e sono indicati nella tabella "qui_buyer_negozi"
$negozi_buyer = array("consumabili","spare_parts","assets","labels","vivistore");
/*
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigat = mysql_fetch_array($risultt)) {
		$add_negozio = array_push($negozi_buyer,$rigat[negozio]);
	}
*/
if ($clausole > 0) {
  if ($shopDaModulo != "") {
	$testoQuery = "SELECT * FROM qui_prodotti_".$shopDaModulo." WHERE ";
  } else {
	$testoQuery = "SELECT * FROM qui_prodotti_".$negozi_buyer[0]." WHERE ";
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
	if ($h != "") {
	  $testoQuery .= $h;
	}
	if ($m != "") {
	  $testoQuery .= $m;
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
	  $testoQuery .= $g." AND ";
	}
	if ($h != "") {
	  $testoQuery .= $h." AND ";
	}
	if ($m != "") {
	  $testoQuery .= $m;
	}
  }
} else {
  if ($shopDaModulo != "") {
	$testoQuery = "SELECT * FROM qui_prodotti_".$shopDaModulo;
  } else {
	$testoQuery = "SELECT * FROM qui_prodotti_".$negozi_buyer[0];
  }
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}

//condizioni per evitare errori
if(($limit == "") OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 40; //default
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

//echo "testoQuery: ".$testoQuery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";

?>
<html>
<head>
  <title>Quice - Lista Giacenze prodotti</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report_balconi.css" />
<link rel="stylesheet" href="css/style.css" />
<style type="text/css">
#outerWrap {
position: relative;
z-index: 0;
/*min-height: 400px;
overflow:hidden;
*/height: auto;
width: 960px;
margin:auto;
}
#layer1 {
position: absolute;
	margin: auto;
z-index: 1;
height: auto;
width: 960px;
top: 0px;
left: 0px; 
	text-align:left;
}
#layer2 {
position: absolute;
z-index: 2;
background-color:rgb(255,255,255);
height: 6000px;
width: 960px;
top: 0px;
left: 0px;
opacity:0.9;
}
#container_princ {
	width:960px;
    height: auto;
	margin: auto;
	margin-top: 10px;
	text-align:left;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align:center;
}
.righe_scorte1 {
    width: 936px !important;
    border-top: none !important;
    border-bottom: 1px solid #badcf4 !important;
    background: none !important;
    padding: 12px 0px 22px 0px;
    height: 20px;
	color:#000;
}
.righe_scorte2 {
    width: 936px !important;
    border-top: none !important;
    border-bottom: 1px solid #badcf4 !important;
    background: none !important;
    padding: 12px 0px 22px 0px;
    height: 20px;
	color:#000;
}

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
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>
<script type="text/javascript" src="tinybox.js"></script>
	<script>
    /*var width = viewportSize.getWidth();
    var height = viewportSize.getHeight();
	alert(height);*/
		// Wait for window load
		$(window).load(function() {
			// Animate loader off screen
			$("#layer2").animate({
				left: -4000
			}, 1500);
		});
	</script>

</head>
<body>
  <div id="outerWrap">

  <div id="layer2">
    <div style="margin:20%; width:60%; height:60%; color: #999; text-align:center; font-size:24px;">
      Sto caricando i dati/<br>Loading data<br><br><img src="images/preloader_image.gif">
    </div>
  </div>
  <div id="layer1">
	<div id="container_princ">
    <?php
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
 $querya = $testoQuery;
 ?>
<?php
  echo "<div id=contenitore_generale>";
//testata
echo '<div style="font-family: Arial; font-size: 11px; font-weight: bold; width: 955px; padding-left: 5px; height: 25px; background-color: #8e8e8e; color: white; float:left;">';
echo '<div style="width:140px; float:left; padding:7px 0px 0px 0px;">';
echo "Categoria";
echo "</div>";
echo '<div style="float:left; width:150px; padding:7px 0px 0px 10px;">';
echo "Codice";
echo "</div>";

echo '<div style="width:250px; float:left; padding:7px 0px 0px 10px;">';
echo "Descrizione";
echo "</div>";
echo '<div style="width:60px; text-align:center; float:left; padding:7px 0px 0px 10px;">';
echo "A scaffale";
echo "</div>";
echo '<div style="width:70px; text-align:center; float:left; padding:7px 0px 0px 10px;">';
echo "Ordinate (3)";
echo "</div>";
echo '<div style="width:60px; text-align:center; float:left; padding:7px 0px 0px 10px;">';
echo "Previs (1-2)";
echo "</div>";
echo '<div style="width:50px; text-align:center; float:left; padding:7px 0px 0px 10px;">';
echo "Evasi";
echo "</div>";
echo "</div>";
$x = 0;
//inizia il corpo della tabella
$result = mysql_query($querya);
//inizio while RDA
while ($row = mysql_fetch_array($result)) {
$x = $x+1;
if ($sf == 1) {
//inizio contenitore riga
echo '<div class="righe_scorte2" style="min-height: 24px; overflow: hidden; height: auto;" id="riga_'.$x.'">';
} else {
echo '<div class="righe_scorte1" style="min-height: 24px; overflow: hidden; height: auto;" id="riga_'.$x.'">';
}
//div codice riga
//div categoria
echo '<div style="width:140px; padding:7px 0px 0px 5px; float:left;">';
echo str_replace("_"," ",$row[categoria1_it]);
echo '<br>'.$row[paese];
//fine div categoria
echo "</div>";
echo '<div style="width:150px; padding:7px 0px 0px 10px; float:left;">';
if (substr($row[codice_art],0,1) != "*") {
  echo $row[codice_art];
} else {
  echo substr($row[codice_art],1);
}
echo '<br>'.$row[categoria4_it];
//fine div codice riga
echo "</div>";
//div descrizione riga
echo '<div style="width:250px; min-height: 24px; overflow: hidden; height: auto; padding:7px 0px 0px 10px; float:left;">';
echo $row[descrizione1_it];
//fine div descrizione riga
echo "</div>";
//div giacenza
$sumquery = "SELECT SUM(quant) as somma_inordineOK FROM qui_righe_rda WHERE negozio = '".$row[negozio]."' AND codice_art = '".$row[codice_art]."' AND stato_ordine = '3'";
$resultb = mysql_query($sumquery);
list($somma_inordineOK) = mysql_fetch_array($resultb);
if (($row[giacenza]-$somma_inordineOK) <= 100) {
	$colore_giacenza = 'red';
} else {
	$colore_giacenza = '#000';
}
echo '<div id="quant_'.$x.'" style="color:'.$colore_giacenza.'; text-align:center; width:60px; padding:7px 0px 0px 10px; float:left;">';
echo '<strong>'.$row[giacenza].'</strong>';
//fine div giacenza
echo "</div>";
//div ORDINE EFFETTIVO (stato 3)
echo '<div style="text-align:center; width:70px; padding:7px 0px 0px 10px; float:left;">';
echo intval($somma_inordineOK);
$somma_inordineOK = "";
//fine div giacenza
echo "</div>";
//div quantità in ordine non ancora processate dal buyer (stato 1 e 2)
echo '<div style="text-align:center; width:60px; min-height: 15px; padding:7px 0px 0px 10px; float:left;">';
$sumquery = "SELECT SUM(quant) as somma_inordine FROM qui_righe_rda WHERE negozio = '".$row[negozio]."' AND codice_art = '".$row[codice_art]."' AND (stato_ordine = '1' OR stato_ordine = '2')";
$resultb = mysql_query($sumquery);
list($somma_inordine) = mysql_fetch_array($resultb);
//echo intval($somma_inordine);
$somma_inordine = "";
//fine quantità in ordine
echo "</div>";



//div quantità già evase
echo '<div style="width:50px; text-align:center; padding:7px 0px 0px 10px; float:left;">';
$sumquerya = "SELECT SUM(quant) as somma_evase FROM qui_righe_rda WHERE negozio = '".$row[negozio]."' AND codice_art = '".$row[codice_art]."' AND stato_ordine = '4' AND data_chiusura >= '1443654000'";
$resulta = mysql_query($sumquerya);
list($somma_evase) = mysql_fetch_array($resulta);
echo intval($somma_evase);
$somma_evase = "";
//fine div quantità già evase
echo "</div>";
//div pulsante per visualizzare scheda
echo '<div class="lente_prodotto" style="width:25px; text-align:right; padding:7px 0px 0px 0px; float:left;">';
if ($rigam[categoria1_it] == "Bombole") {
} else {
	echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$row[categoria1_it]."&categoria2=".$row[categoria2_it]."&categoria3=".$row[categoria3_it]."&paese=&nazione_ric=&negozio=".$shopDaModulo."&codice_art=".$row[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
//fine div pulsante per visualizzare scheda
echo "</div>";
echo '<div class="lente_prodotto" style="width:25px; text-align:right; padding:7px 0px 0px 0px; float:left;">';
if (substr($row[codice_art],0,1) != "*") {
  $cod_art_tiny = $row[codice_art];
} else {
  $cod_art_tiny = substr($row[codice_art],1);
}
switch ($_SESSION[nome]) {
	case "AAA-MAGAZZINIERE":
	case "AAA-BUYER1":
	case "Fabio Muzzi":
	echo '<a href="javascript:void(0);" onClick="TINY.box.show({iframe:\'gestione_giacenze.php?codice_art='.$row[codice_art].'&negozio='.$row[negozio].'\',boxid:\'frameless960\',width:960,height:360,fixed:false,maskid:\'bluemask\',maskopacity:40,closejs:function(){refresh_prod('.$x.')}})"><img src="immagini/bottone-edit.png" width="19" height="19" border"=0" title="Modifica giacenza"></a>';
	break;
}
//fine div pulsante per MODIFICA GIACENZA
echo "</div>";

//fine contenitore riga tabella
echo "</div>";

//fine while
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}





echo "<div class=contenitore_rda_fattura style=\"margin-top:10px; margin-bottom:10px;\">";
    echo "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td class=num_pag>";

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
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&categoria_ricerca=".$categoria_ricercaDaModulo."&codice_art=".$codice_artDaModulo."&ricerca=1&lang=".$lingua."><b>1</b></a>"; 

  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&categoria_ricerca=".$categoria_ricercaDaModulo."&codice_art=".$codice_artDaModulo."&dispo=".$dispoDaModulo."&ricerca=1&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&categoria_ricerca=".$categoria_ricercaDaModulo."&codice_art=".$codice_artDaModulo."&dispo=".$dispoDaModulo."&ricerca=1&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&categoria_ricerca=".$categoria_ricercaDaModulo."&codice_art=".$codice_artDaModulo."&dispo=".$dispoDaModulo."&ricerca=1&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&categoria_ricerca=".$categoria_ricercaDaModulo."&codice_art=".$codice_artDaModulo."&dispo=".$dispoDaModulo."&ricerca=1&lang=".$lingua."><b>".$last_page."</b></a>"; 
        echo "</td>";
     echo " </tr>";
    echo "</table>";


    echo "</div>";
//fine contenitore totale
echo "</div>";
?>
</div>
</div>
</div>
<script type="text/javascript">
	/*
function msc(mode,valore){
	switch (mode) {
		case "societa":
		  var socval = valore;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		break;
		case "shop":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shopval = valore;
		  var categ = document.forms['form_filtri2'].elements['categoria_righe'];
		  var categval = categ.options[categ.selectedIndex].value;
		break;
		case "categoria_righe":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var shop = document.forms['form_filtri2'].elements['shop'];
		  var shopval = shop.options[shop.selectedIndex].value;
		  var categval = valore;
		break;
	}
	var codice_art = document.getElementById('codice_art').value;
	var codice_art = document.getElementById('codice_art').value;
	$.ajax({
			type: "POST",   
			url: "motore_ricerca_MSC.php",   
			data: "societa="+socval+"&shop="+shopval+"&categoria="+categval+"&codice_art="+codice_art+"&file_presente=<?php echo $file_presente; ?>",
			success: function(output) {
			$('#formRicerca').html(output).show();
			$("#contenitore_msc").fadeIn(1000);
			}
})
}
	*/
function refresh_prod(id){
	/*
	alert(id);
	*/
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_scorte_prodotti.php",   
	  data: "id="+id,
	  success: function(output) {
	  $('#quant_'+id).html(output).show();
	  }
	  })
}
</SCRIPT>
</body>
</html>
