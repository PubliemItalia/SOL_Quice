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

$pag_attuale = "lista_pl";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db


$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
//variabili di paginazione
if (isset($_GET['limit'])) {
$limit = $_GET['limit'];
} else {
$limit = $_POST['limit'];
}
if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}
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
$avviso = $_GET['avviso'];
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
if (isset($_GET['societa'])) {
$societaDaModulo = $_GET['societa'];
} 
if ($societaDaModulo != "") {
$b = "logo = '$societaDaModulo'";
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
$c = "(data_spedizione BETWEEN '$inizio_range' AND '$fine_range')";
$clausole++;
}
} else {
$campidate = "";
}

if (isset($_GET['nr_pl'])) {
$nrPlDaModulo = $_GET['nr_pl'];
} 
if ($nrPlDaModulo != "") {
$e = "id = '$nrPlDaModulo'";
$clausole++;
}
if (isset($_GET['nr_rda'])) {
$nrRdaDaModulo = $_GET['nr_rda'];
} 
if ($nrRdaDaModulo != "") {
$d = "rda LIKE '%$nrRdaDaModulo%'";
$clausole++;
}

//echo "clausole: ".$clausole."<br>";
//costruzione query
if ($clausole == 0) {
$testoQuery = "SELECT * FROM qui_packing_list ";
//$sumquery =   "SELECT SUM(totale_rda) as somma FROM qui_packing_list ";
} else {

$testoQuery = "SELECT * FROM qui_packing_list WHERE ";
//$sumquery =   "SELECT SUM(totale_rda) as somma FROM qui_packing_list WHERE ";

if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
//$sumquery .= $a;
}
if ($b != "") {
$testoQuery .= $b;
//$sumquery .= $b;
}
if ($c != "") {
$testoQuery .= $c;
//$sumquery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
//$sumquery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
//$sumquery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
//$sumquery .= $f;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
//$sumquery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
//$sumquery .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
//$sumquery .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
//$sumquery .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
//$sumquery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f;
//$sumquery .= $f;
}
}
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
//$lungsum = strlen($sumquery);
//$finale_sum = substr($sumquery,($lungsum-5),5);
//if ($finale_sum == " AND ") {
//$sumquery = substr($sumquery,0,($lungsum-5));
//}

//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 20; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
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

$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//$resultb = mysql_query($sumquery);
//list($somma) = mysql_fetch_array($resultb);
//$totale_storico_rda = $somma;


//echo "testoQuery: ".$testoQuery."<br>";
//echo "sumquery: ".$sumquery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "total_items: ".$total_items."<br>";
include "traduzioni_interfaccia.php";
?>
<html>
<head>
  <title>Quice - Lista PL</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<style type="text/css">
<!--
#main_container {
	width:960px;
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
.Stile3 {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
th {
	color:#000;
	font-weight:bold;
}
.ui-widget-header {
	background-color:#06F;
	background-image:none !important;
	border-color:#06F;
}
.bott_pl {
	font-size:9px;
	float: right;
	width: auto;
	height: auto;
	margin-left:12px;
	padding:1px;
	border-style:solid;
	border-width: 1px;
}
-->
</style>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>

</head>
<?php

//if ($add_pref != "") {
//echo "<body onLoad=window.open('popup_notifica.php?avviso=bookmark&id_prod=".$id."','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//echo "<body onLoad=window.open('popup_notifica.php?avviso=config','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//} else {
echo "<body>";
//}

?>
<div id="main_container">
<?php
include "testata_amministrazione.php";
include "modulo_filtri.php"; 
//**********************
//tabella può essere visualizzata solo da buyer ed admin perchè il menu compare solo se l'utente è buyer o admin
//************************
//riga del totale
/*
echo "<div class=contenitore_riga>";
echo "<div class=box_100>";
echo "TOTALE";
echo "</div>";
echo "<div class=box_100>";
echo "</div>";
echo "<div class=box_200>";
echo "</div>";
echo "<div class=box_200>";
echo "</div>";
echo "<div class=box_100>";
echo "</div>";
echo "<div class=box_100>";
echo "</div>";
echo "<div class=box_130_dx>";
echo number_format($totale_storico_rda,2,",",".");
echo "</div>";

echo "</div>";
*/	
?>
<div id="contenitore_testata" style="float:left;">
<div class="box_100" style="width:60px;">
<?php echo $testata_tab_id_pl; ?>
</div>
<div class="box_100" style="width:80px;">
<?php echo $testata_data; ?>
</div>
<div class="box_200">
<?php echo $testata_utente; ?>
</div>
<div class="box_200">
<?php echo $testata_tab_rda; ?>
</div>
<div class="box_100">
<?php echo $testata_unita; ?>
</div>
<div class="box_100">
</div>
<div class="box_130_dx">
<?php echo $testata_azienda; ?>
</div>
</div>
<?php
 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
//if ($clausole > 0) {
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
switch ($row[check_completato]) {
	case "0":
	$background = '#ffffff';
	break;
	case "1":
	$background = '#ffcdcd';
	break;
	case "2":
	$background = '#9c9ea0';
}
echo '<div id="blocco_pl_'.$row[id].'">';
  echo '<div class="contenitore_riga" style="background-color:'.$background.'">';
	echo '<div class="box_100" style="width:60px;">';
	echo $row[id];
	echo "</div>";
	echo '<div class="box_100" style="width:80px;">';
	echo date("d.m.Y",$row[data_spedizione]);
	echo "</div>";
	echo "<div class=box_200>";
	echo stripslashes($row[utente]);
	echo "</div>";
	echo "<div class=box_200>";
	echo substr($row[rda],1);
	echo "</div>";
	echo "<div class=box_100>";
	$sqly = "SELECT * FROM qui_unita WHERE id_unita = '$row[id_unita]'";
	$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigay = mysql_fetch_array($risulty)) {
	echo stripslashes($rigay[nome_unita]);
	}
	echo "</div>";
	//echo "<div class=box_130_dx>";
		echo '<div class="sel_all_riga" style="float: right; width:auto; padding:7px 5px 0px 5px;">';
		//echo 'neg: '.$rigan[negozio].'<br>';
		if ($row[logo] == "vivisol") {
		  echo '<img src="immagini/bottone-vivisol.png">';
		}
		if ($row[logo] == "sol") {
		  echo '<img src="immagini/bottone-sol.png">';
		}
		echo "</div>";
/**/
	//echo "</div>";
	echo '<div class="box_130" style="padding-top:6px;">';
/*	  echo '<a href="javascript:void(0);" onclick="elimina_pl('.$row[id].',0);">';
	  echo '<div class="bott_pl" style="color:red; border-color: red; margin-right:10px;">';
	  echo 'EliminaPL';
	  //echo '<img src=immagini/button_elimina.gif width=19 height=19 border=0 title="Elimina PL">';
	  echo '</div>';
	  echo '</a>';
*/
	  echo '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=cons&n_pl='.$row[id].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
	  echo '<div class="bott_pl" style="color:#F90;  border-color:#F90;">';
	  echo 'ModificaPL';
	  //echo '<img src=immagini/bottone-edit.png width=19 height=19 border=0 title="Modifica PL">';
	  echo '</div>';
	  echo '</a>';
	  echo '<a href="javascript:void(0);" onclick="PopupCenter(\'packing_list.php?mode=print&n_pl='.$row[id].'&lang='.$lingua.'\', \'myPop1\',800,800);">';
	  echo '<div class="bott_pl" style="color:blue;  border-color:blue;">';
	  echo 'StampaPL';
	  //echo '<img src=immagini/bottone_stamp.png width=19 height=19 border=0 title="Stampa PL">';
	  echo '</div>';
	  echo '</a>';
	  //if ($row[check_completato] >= 0) {
			switch ($_SESSION[nome]) {
			default:
			break;
			case "AAA-MAGAZZINIERE":
			case "AAA-BUYER1":
				echo '<form id="form_pl" name="form_pl" method="post"  action="http://www.publiem.eu/quice/chiusura_pl_def.php">';
				echo '<input name="id_pl" type="hidden" id="id_pl" value="'.$row[id].'">';
				echo '<input name="status" type="hidden" id="status" value="3">';
				echo '<input name="id_utente" type="hidden" id="id_utente" value="'.$_SESSION[nome].'">';
				echo '<a href="javascript:void(0);" onclick="chiusura_grigia('.$row[id].')">';
				echo '<div class="bott_pl" style="color:#000;  border-color:#000;">';
				echo 'ChiudiPL';
				echo '</div>';
				echo '</a>';
				echo '</form>';
			break;
		}
/**/
	  //}

	echo "</div>";
  echo "</div>";
echo "</div>";	
/*
*/
}
//}

?>
<div class=contenitore_riga>
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

   if($page > 1) {
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=1&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b>1</b></a>"; 
  }
if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$prev_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  echo("<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$a."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$next_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b>>></b></a>"; 
} 
   echo "<a href=".$_SERVER['PHP_SELF']."?limit=".$limit."&page=".$last_page."&shop=".$shopDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine."&stato_rda=".$stato_rdaDaModulo."&unita=".$unitaDaModulo."&nr_rda=".$nrRdaDaModulo."&lang=".$lingua."><b>".$last_page."</b></a>"; 
?>
        </td>
      </tr>
    </table>
  </div>
</div>
<script type="text/javascript">
$(function(){
  $(".datepicker").datepicker();
});
function elimina_pl(id_pl,id_rda){
						/*
						alert(id_pl+","+id_rda);
						*/
	  if (confirm("Sei proprio sicuro di eliminare il PL selezionato?<br>Fai un refresh della pagina dopo aver terminato l'operazione") == true) {
		  /*x = "La modifica è stata registrata!";*/
		$.ajax({
		  type: "GET",   
		  url: "eliminazione_pl.php",   
		  data: "id_pl="+id_pl+"id_rda="+id_rda,
		  success: function(output) {
		$('#blocco_rda_'+id_rda).html(output).show();
		  }
		  })
	  }
}
function chiusura(id_pl,check){
						/*
						alert(id_pl);
						*/
				$.ajax({
						type: "GET",   
						url: "refresh_blocco_sing_pl.php",   
						data: "id_pl="+id_pl+"check="+check+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#blocco_pl_'+id_pl).html(output).show();
						}
						})

}
function chiusura_grigia(id_pl){
						/*
						alert(id_pl);
						*/
document.forms["form_pl"].submit();
				$.ajax({
						type: "GET",   
						url: "refresh_blocco_sing_pl.php",   
						data: "id_pl="+id_pl+"&def=1&check=3&id_utente=<?php echo $_SESSION[user_id]; ?>",
						success: function(output) {
						$('#aaa'+id_pl).html(output).show();
						}
						})
}
function msc(mode,valore){
	switch (mode) {
		case "societa":
		  var socval = valore;
		  var unita = document.forms['form_filtri2'].elements['unita'];
		  var unitaval = unita.options[unita.selectedIndex].value;
		break;
		case "unita":
		  var soc = document.forms['form_filtri2'].elements['societa'];
		  var socval = soc.options[soc.selectedIndex].value;
		  var unitaval = valore;
		break;
	}
	var nr_rda = document.getElementById('nr_rda').value;
	/*alert( mode+','+socval+","+shopval+","+unitaval+","+categval+","+nr_rda+","+codice_art+","+data_inizio+","+data_fine);*/
	$.ajax({
			type: "POST",   
			url: "motore_ricerca_MSC.php",   
			data: "societa="+socval+"&unita="+unitaval+"&file_presente=<?php echo $file_presente; ?>",
			success: function(output) {
			$('#formRicerca').html(output).show();
			$("#contenitore_msc").fadeIn(1000);
			}
})
}
</SCRIPT>
</body>
</html>
