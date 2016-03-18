<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
include "funzioni.js";
include "functions.php";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id = $_GET[id];
$a = $_GET[a];
$report = $_GET[report];
if ($_GET['pers'] != "") {
$pers = $_GET['pers'];
} else {
$pers = $_POST['pers'];
}
$report = $_GET[report];
$negozio_rda = $_GET[negozio_rda];
$id_riga = $_GET[id_riga];
$id_prodotto = $_GET[id_prodotto];
$mode = $_GET[mode];
$modifica_quant = $_GET[modifica_quant];
$quant = $_GET[quant];
$ok_resp2 = $_GET[ok_resp2];
$ok_buyer = $_GET[ok_buyer];
$chiusura = $_GET[chiusura];
$lingua = $_GET[lang];
$lingua = $_SESSION[lang];
$textarea = levapar6($_GET['textarea']);
$conferma = $_GET['conferma'];
$ruolo_ins = $_GET['ruolo_ins'];
$check_buyer = $_GET['check_buyer'];
$modifica_quant = $_GET['modifica_quant'];
$change_status = $_GET['change_status'];
$deseleziona = $_GET['deseleziona'];
$nome_sessione = $_SESSION[nome];
$id_utente = $_SESSION[user_id];

$data_attuale = mktime();

$sqleee = "SELECT * FROM qui_rda WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "it":
$descrizione = $rigaeee[descrizione_it];
break;
case "en":
$descrizione = $rigaeee[descrizione_en];
break;
case "fr":
$descrizione = $rigaeee[descrizione_fr];
break;
case "de":
$descrizione = $rigaeee[descrizione_de];
break;
case "es":
$descrizione = $rigaeee[descrizione_es];
break;
}
$id_rda = $rigaeee[id];
$negozio_rda = $rigaeee[negozio];
$nome_utente = $rigaeee[nome_utente];
$note_utente = $rigaeee[note_utente];
$id_utente_rda = $rigaeee[id_utente];
$id_resp_rda = $rigaeee[id_resp];
$note_resp = $rigaeee[note_resp];
$nome_resp = $rigaeee[nome_resp];
$buyer_chiusura = $rigaeee[buyer_chiusura];
$id_buyer = $rigaeee[buyer_output];
$stato_rda = $rigaeee[stato];
}
include "traduzioni_interfaccia.php";
$array_buyers = array();
$queryh = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resulth = mysql_query($queryh);
while ($rigah = mysql_fetch_array($resulth)) {
	if (!in_array($rigah[id_buyer],$array_buyers)) {
	  $add_buyer = array_push($array_buyers,$rigah[id_buyer]);
	}
}

if ($_GET['ordinamento'] != "") {
$ordinamento = $_GET['ordinamento'];
} else {
$ordinamento = "data_inserimento ASC";
}
//recupero gli importi delle righe della rda e aggiorno il totale nella tabella rda
$queryd = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resultd = mysql_query($queryd) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowd = mysql_fetch_array($resultd)) {
$importo_rda = $importo_rda + $rowd[totale];
}
$tot_rda_aggiornato = $importo_rda + $totale_aggiornato;
$querys = "UPDATE qui_rda SET totale_rda = '$tot_rda_aggiornato' WHERE id = '$id'";
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$querye = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resulte = mysql_query($querye) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
$righe_totali = mysql_num_rows($resulte);
$queryn = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '4' AND output_mode = 'sap'";
$resultn = mysql_query($queryn) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
$righe_attive_totali = mysql_num_rows($resultn);
//echo "righe_attive_totali: ".$righe_attive_totali."<br>";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dettaglio RdA <?php echo $id_rda; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report_balconi.css" />
<style type="text/css">
<!--
#main_container {
	width:930px;
	margin: auto;
}
body {
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color:#e5f6ff;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
}
.btnFreccia a {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 0 transparent;
    color: #fff;
    cursor: pointer;
    display: block;
    height: 19px;
    line-height: 19px;
    text-align: left;
    width: 117px;
    padding-left: 3px;
	float:left;
}
.forn {
    height: 100px;
    text-align: left;
    width: 235px;
    padding-left: 3px;
	float:left;
}
.btnFreccia a:hover {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 -29px transparent;
}
.casella_input {
	font-size: 10px;
	font-family: Arial, Helvetica, sans-serif;
}
.sfondoRigaColor{
	background-color:#F0F0F0;
	width:100%;
	height:auto;
	padding:5px 0px;
	margin-bottom:5px;
	float:left;
	color:#000;
	
}
.sfondoRigaColor:hover{
	background: #b8e3f6;
}
.sfondoRigaBianco{
	background-color:#FFF;
	width:100%;
	height:auto;
	padding:5px 0px;
	margin-bottom:5px;
	float:left;
	color:#000;
}
.sfondoRigaBianco:hover{
	background: #b8e3f6;
}
.cont_generale{
	background-color:#FFF;
	width:100%;
	height:20px;
	margin-top:15px;
	margin-bottom:5px;
	float:left;
	color:#000;
}

-->
</style>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
/*window.close();*/
}
</script>
<script>
function changetitle()
{
/*alert(window.document.title);*/
window.document.statusbar.enable = false;
window.document.titlebar.enable = false;
window.document.addressbar.enable = false;
}
</script>
	<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
</head>
<?php
echo "<body onUnload=\"refreshParent();\" onLoad=\"refreshParent(); changetitle();\">";
?>
<div id="main_container">
  <!--indicazione RdA-->
  <div style="width:100%; height:30px; float:left; margin-top:20px;">
    <div class="titolo_scheda" style="width:20%; float:left;"><?php echo "<span style=\"font-size:16px; color:rgb(0,0,0);\"><strong>RdA ".$id_rda."</strong></span>"; ?>
    </div>
    <div class="titolo_scheda" style="width:77%; float:right; font-size:12px;">
      <form name="form2" method="post" action="">
        <div style="width:30%; float:right; text-align:right;">
	  <div class="btnFrecciaRedLunga" style="cursor:pointer; font-size:12px;" onClick="inserimento_ordine(<?php echo $id_rda; ?>);"><strong>Inserisci Ordine SAP</strong></div>
        </div>
        <div style="width:35%; float:right;">
          Ordine <input type="text" name="ordine_fornitore" id="ordine_fornitore">
        </div>
        <div style="width:35%; float:right;">
          Fornitore <input type="text" name="tx_fornitore" id="tx_fornitore">
        </div>
      </form>
    </div>
  </div>
  <!--testata-->
  <div class="format_testata" style="width:100%; height:20px; float:left; background-color:#8e8e8e; padding-top:5px;">
    <div style="width:70px; height:auto; float:left; margin-left:10px;">
	  <?php echo $testata_codice; ?>
    </div>
    <div style="width:70px; height:auto; float:left;">
	  <?php echo $testata_nazione; ?>
    </div>
    <div style="width:250px; height:auto; float:left;">
	  <?php echo $testata_descrizione; ?>
    </div>
    <div style="width:80px; height:auto; float:left;">
	  <?php echo $testata_imballo; ?>
    </div>
    <div style="width:80px; height:auto; text-align:right; float:left;">
	  <?php echo $testata_prezzo; ?>
    </div>
    <div style="width:80px; height:auto; text-align:right; float:left;">
	  <?php echo $testata_quant; ?>
    </div>
    <div style="width:80px; height:auto; text-align:right; float:left;">
	  <?php echo $testata_totale; ?>
    </div>
    <div style="width:100px; height:auto; text-align:center; float:left;">
	  Ord. fornitore
    </div>
	  <?php
	  if ($righe_attive_totali != $righe_totali) {
		$tooltip_select = "Seleziona tutto";
		$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id.",4);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	  } else {
		$tooltip_select = "Deseleziona tutto";
		$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id.",2);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	  }
	  echo "<div id=bott_".$id." class=sel_all style=\"width:50px; float:right; margin-right:15px; text-align:right; background-color:transparent;\">";
	  //echo $bottone_immagine;
	  echo "</div>";
	  ?>
  </div>
  <?php
echo "<div id=blocco_rda_".$id." class=cont_rda style=\"width:auto; min-height:30px overflow:hidden;\">";

  $array_date_chiusura = array();
  $querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '4' AND flag_chiusura = '0' AND output_mode = 'SAP' AND flag_buyer = '4' ORDER BY ".$ordinamento;
  $sf = 1;
  //inizia il corpo della tabella
  $result = mysql_query($querya);
  while ($row = mysql_fetch_array($result)) {
	$tot = $tot + 1;
	$data_leggibile = date("d.m.Y",$row[data]);
	$id_prod_riga = $row[id_prodotto];
	$codice_art_riga = $row[codice_art];
	$ordine_forn_db = $row[fornitore_tx]." ".$row[ord_fornitore];	
	$nazione_prodotto = $row[nazione];
	if ($row[stato_ordine == 4]) {
	  $add_data = array_push($array_date_chiusura,$row[data_ultima_modifica]);
	}

	$descrizione_prodotto = $row[descrizione];
	$prezzo_prodotto = $row[prezzo];
	$confezione_prodotto = $row[confezione];
	if ($row[negozio] == "labels") {
	  $confezione_prodotto = "";
	  $prezzo_prodotto = "";
	  //echo "ord stamp: ".$ord_stamp."<br>";
	  $totale_art = $row[totale];
	}
	
	//echo "<form name=carrello method=get action=popup_vis_rda.php#".$row[id].">";
	if ($sf == 1) {
	  echo "<div class=sfondoRigaColor>";
	} else {
	  echo "<div class=sfondoRigaBianco>";
	}
	echo "<div style=\"width:70px; height:auto; float:left; margin-left:10px;\">";
	if (substr($codice_art_riga,0,1) != "*") {
	  echo $codice_art_riga;
	} else {
	  echo substr($codice_art_riga,1);
	}
	echo "</div>";
	echo "<div style=\"width:70px; height:20px; float:left;\">";
	  echo $nazione_prodotto;
	echo "</div>";
	echo "<div style=\"width:250px; height:auto; float:left;\">";
	if (strlen($descrizione_prodotto) < 3) {
	  echo $descrizione_ita." <strong>(da tradurre)</strong>";
	} else {
	  echo $descrizione_prodotto;
	}
	  //echo $descrizione_prodotto;
	  $descrizione_prodotto = "";
	  $descr_ita = "";
	echo "</div>";
	echo "<div style=\"width:80px; height:20px; float:left;\">";
	  echo $confezione_prodotto;
	echo "</div>";
	echo "<div style=\"width:80px; height:20px; float:left; text-align:right;\">";
	  echo number_format($prezzo_prodotto,2,",","");
	echo "</div>";
	echo "<div style=\"width:80px; height:auto; float:left; text-align:right;\">";
		  echo number_format($row[quant],0,",",".");
	echo "</div>";
	echo "<div style=\"width:80px; height:auto; float:left; text-align:right; padding-right:10px;\">";
		echo number_format($row[totale],2,",","");
	echo "</div>";
	echo "<div style=\"width:135px; height:20px; float:left;\">";
	echo $ordine_forn_db;
	//qui va l'indicazione del numero ordine
	echo "</div>";
	echo "<div style=\"width:50px; float:right; margin-right:15px; text-align:right; height:20px;\">";
	//qui va la checkbox per la selezione della riga
	if ($row[flag_buyer] == 4) {
	  echo '<input name="id_riga[]" type="checkbox" id="id_riga[]" checked value="'.$row[id].'" onClick="processa('.$row[id].','.$id.');">';
	} else {
	  echo '<input name="id_riga[]" type="checkbox" id="id_riga[]" value="'.$row[id].'" onClick="processa('.$row[id].','.$id.');">';
	}
	echo "</div>";
	echo "</div>";
	$ordine_forn_db = "";
	if ($sf == 1) {
	$sf = $sf + 1;
	} else {
	$sf = 1;
	}
  }
	echo "</div>";
 ?>
  </div>
</div>
<script type="text/javascript">
function inserimento_ordine(id_rda){
	var ordine_fornitore = document.getElementById("ordine_fornitore").value;
	var tx_fornitore = document.getElementById("tx_fornitore").value;
	
	/*var fornitore = document.getElementById("id_fornitore");
	var id_fornitore = fornitore.options[fornitore.selectedIndex].value;
	var tx_fornitore = fornitore.options[fornitore.selectedIndex].text;
	alert(tx_fornitore);*/
	if (ordine_fornitore != "") {
	  } else {
		  alert("I dati inseriti verranno cancellati!");
	}
	  $.ajax({
			  type: "GET",   
			  url: "imposta_selezione_ordine_SAP.php",
			  cache: "false",   
			  /*data: "id_rda="+id_rda+"&ordine_fornitore="+ordine_fornitore+"&id_fornitore="+id_fornitore+"&tx_fornitore="+tx_fornitore,*/
			  data: "id_rda="+id_rda+"&ordine_fornitore="+ordine_fornitore+"&tx_fornitore="+tx_fornitore,
			  success: function(output) {
			  $('#blocco_rda_'+id_rda).html(output).show();
	  }
	  })
}
function processa(id_riga,id_rda){
	//if (valoreQuant == '' || valoreQuant == '0') {
		/*alert(id);*/
	$.ajax({
			type: "GET",   
			url: "aggiorna_riga_sap.php",
			cache: "false",   
			data: "id_riga="+id_riga+"&id_rda="+id_rda,
			success: function(output) {
			$('#aaa').html(output).show();
	}
	})
  refreshParent();
}
function axc_multi(id_rda,valoreCheck){
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_ordine_SAP.php",   
						data: "multi=1"+"&check="+valoreCheck+"&id_rda="+id_rda,
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})
				$.ajax({
						type: "GET",   
						url: "aggiorna_testata_rda_SAP.php",   
						data: "check="+valoreCheck+"&id_rda="+id_rda,
						success: function(output) {
						$('#bott_'+id_rda).html(output).show();
						}
						})

}
</SCRIPT>


</body>
</html>
