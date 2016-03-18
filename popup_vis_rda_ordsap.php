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
$ins_ord_sap = $_GET['ins_ord_sap'];
$ordine_fornitore = addslashes($_GET['ordine_fornitore']);
$id_fornitore = addslashes($_GET['id_fornitore']);
$tx_fornitore = addslashes($_GET['tx_fornitore']);
$data_attuale = mktime();
/*echo '<span style="color:#000;">id rda: '.$id.'<br>
ordine fornitore: '.$ordine_fornitore.'<br>
tx_fornitore: '.$tx_fornitore.'</span>';*/
if ($ins_ord_sap == 1) {
  if ($ordine_fornitore != "") {
	$query = "UPDATE qui_righe_rda SET stato_ordine = '4', assegnaz_fornitore = '$id_fornitore', fornitore_tx = '$tx_fornitore', ord_fornitore = '$ordine_fornitore', flag_chiusura = '1', flag_buyer = '2', data_chiusura = '".$data_attuale."', data_ultima_modifica = '".$data_attuale."' WHERE id_rda = '$id' AND output_mode = 'sap' AND flag_chiusura = '0' AND flag_buyer = '4'";
	  } else {
	$query = "UPDATE qui_righe_rda SET assegnaz_fornitore = '', fornitore_tx = '', ord_fornitore = '' WHERE id_rda = '$id' AND output_mode = 'sap' AND flag_chiusura = '0' AND flag_buyer = '4'";
  }
  if (mysql_query($query)) {
	  $esito = 'OK';
  } else {
	echo "Errore durante l'inserimento: ".mysql_error();
  }
  //VERIFICA PER CHIUSURA RDA
  $queryv = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
  $resultv = mysql_query($queryv);
  $totale_righe_rda = mysql_num_rows($resultv);
  while ($rigav = mysql_fetch_array($resultv)) {
	if ($rigav[flag_chiusura] == 1) {
	  $righe_chiuse_rda = $righe_chiuse_rda + 1;
	}
  }
	if ($totale_righe_rda == $righe_chiuse_rda) {
	$query2 = "UPDATE qui_rda SET stato = '4', data_chiusura = '".$data_attuale."', data_ultima_modifica = '".$data_attuale."' WHERE id = '$id'";
	  if (mysql_query($query2)) {
	  } else {
		echo "Errore durante l'inserimento: ".mysql_error();
	  }
		
	}
}

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
#main_divprinc {
	width:960px;
	margin: 10px auto;
}
body {
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	/*background-color:#e5f6ff;*/
}
html {
	margin-bottom: 20px;
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
#layer_avviso {
position: absolute;
z-index: 2;
background-color:rgb(255,255,255);
height: 100%;
width: 100%;
top: 0px;
left: 0px;
opacity:0.9;
}
.avvisi_scomp {
	margin: 40px auto;
	width:80%;
	min-height:30px;
	overflow: hidden;
	height:auto;
	font-family:Arial;
	font-size:18px;
	color:green;
	font-weight:bold;
	text-align:center;
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
function refreshParent() {
      setTimeout(sfuma(), 1500);

}
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
if ($esito == 'OK') {
echo '<body onLoad="refreshParent()">';
} else {
echo "<body>";
}
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'processo'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
  }
  $codice_php_testatina_righe = $blocco_testatina_righe;
$sqly = "SELECT * FROM qui_rda WHERE id = '$id'";
$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione09" . mysql_error());
while ($rigay = mysql_fetch_array($risulty)) {
$data_inserimento = $rigay[data_inserimento];
$data_output = $rigay[data_output];
$data_approvazione = $rigay[data_approvazione];
$data_chiusura = $rigay[data_chiusura];
$data_ultima_modifica = $rigay[data_ultima_modifica];
$stato_orig_rda = stripslashes($rigay[stato]);
$tipo_negozio = stripslashes($rigay[negozio]);
$wbs_visualizzato = stripslashes($rigay[wbs]);
$note_utente = stripslashes($rigay[note_utente]);
$nome_utente_rda = stripslashes($rigay[nome_utente]);
$note_resp = stripslashes($rigay[note_resp]);
$nome_resp_rda = stripslashes($rigay[nome_resp]);
$note_magazziniere = stripslashes($rigay[note_magazziniere]);
$note_buyer = str_replace("<br>","\n",stripslashes($rigay[note_buyer]));
}
if ($esito == 'OK') {
	echo '
	  <div id="layer_avviso">
		<div class="avvisi_scomp">
		Il numero ordine SAP &egrave; stato inserito correttamente
		</div>
	  </div>
	';
}

?>

<div id="main_divprinc" class="cont_rda">
<div class="cont_rda" id="contenitore_generale">
<div class="cont_rda" style="min-height: 10px;" id="glob_<?php echo $id; ?>">
  <!--testata-->
  <?php
//inizio contenitore esterno sing rda
echo "<div class=riassunto_rda>";

echo "<div class=ind_num_rda>";
echo "RDA ".$id;
echo "</div>";
echo "</div>";

echo "</div>";
$bottone_immagine = '';
  $codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
  echo $codice_php_testatina_righe;
echo '<div id="blocco_rda_'.$id.'" class="cont_rda blocco_rda" style="width:auto; min-height:30px overflow:hidden;">';

$array_date_chiusura = array();
if ($ins_ord_sap == 1) {
$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '4' AND flag_chiusura = '0' AND output_mode = 'SAP' AND ord_fornitore = '$ordine_fornitore' ORDER BY ".$ordinamento;
} else {
$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '3' AND flag_chiusura = '0' AND output_mode = 'SAP' AND flag_buyer = '4' ORDER BY ".$ordinamento;
}
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
	$codice_php_singola_riga = $blocco_singola_riga;
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
   $sost_id_riga = $row[id];
  // codice riga
  if (substr($row[codice_art],0,1) != "*") {
	$sost_codice_art .= $row[codice_art];
  } else {
	$sost_codice_art .= substr($row[codice_art],1);
  }
  // descrizione riga
  $sost_descrizione = $row[descrizione];
  // nome unità riga
  $sost_unita = $row[nome_unita];
  // quant riga
  $sost_quant = intval($row[quant]);
  // pulsante per evasione parziale riga
  $bottone_edit = "";
  $bottone_lente = "";
  // totale riga
  $sost_totale_riga = number_format($row[totale],2,",",".");
  $totale_rda = $totale_rda + $row[totale];
  
  $colore_aggiornamento = "style_aggiornamento";
  //div output mode riga (vuoto)
  $colore_scritta = "style_sap";
  if ($row[ord_fornitore] != "") {
  $dettaglio_stato = "Ordine Sap ".$row[ord_fornitore]." - ".$row[fornitore_tx];
  if ($row[data_chiusura] > 0) {
  $aggiornamento_stato = date("d/m/Y",$row[data_chiusura]);
  } else {
  $aggiornamento_stato = date("d/m/Y",$row[data_ultima_modifica]);
  }
  $campo_ordsap = '';
  } else {
  $campo_ordsap = '';
  $dettaglio_stato = "Inoltrato a Sap";
  $aggiornamento_stato = date("d/m/Y",$row[data_ultima_modifica]);
  }
  $aggiornamento_stato = "Aggiornato al ".$aggiornamento_stato;
/*
  switch ($row[flag_buyer]) {
  case "2":
	$casella_check = '<input name="id_riga[]" type="checkbox" id="id_riga[]" value="'.$row[id].'" onClick="processa('.$row[id].','.$id.');">';
  break;
  case "4":
	$casella_check = '<input name="id_riga[]" type="checkbox" id="id_riga[]" checked value="'.$row[id].'" onClick="processa('.$row[id].','.$id.');">';
	$contatore_righe_flag_sap = $contatore_righe_flag_sap + 1;
  break;
  }
*/  
  	$casella_check = '';

  $sost_logo = '<a href="report_prodotti.php?shop='.$row[negozio].'&categoria_ricerca=&paese=&codice_art='.$row[codice_art].'&categoria4=&ricerca=1" target="_blank">';
  //echo 'neg: '.$row[negozio].'<br>';
  switch ($row[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $sost_logo .= '<img src="immagini/bottone-vivisol.png" style="margin-bottom:5px;">';
	break;
	case "SOL":
	  $sost_logo .= '<img src="immagini/bottone-sol.png" style="margin-bottom:5px;">';
	break;
  }
  $sost_logo .= '<br><span style="font-size:8px; text-align:right; color: #000;">'.$giacenza.'</span>';
  $sost_logo .= "</a>";
  $data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
  $codice_php_singola_riga = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*sost_unita*",$sost_unita,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*campo_ordsap*",$campo_ordsap,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*colore_aggiornamento*",$colore_aggiornamento,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*aggiornamento_stato*",$aggiornamento_stato,$codice_php_singola_riga);
  $codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
  $sost_codice_art = '';
  $colore_scritta = '';
  $sost_logo = '';
  echo $codice_php_singola_riga;
}
  echo "</div>";
 ?>
  </div>
  <div style="width:100%; height:30px; float:left; margin-top:20px;">
    <div class="titolo_scheda" style="width:20%; float:left;"></div>
    <div class="titolo_scheda" style="width:77%; float:right; font-size:12px;">
      <form name="form2" method="get" action="popup_vis_rda_ordsap.php">
        <div style="width:30%; float:right; text-align:right;">
	  <!--<div style="cursor:pointer; font-size:12px;" onClick="inserimento_ordine(<?php //echo $id_rda; ?>);"><img src="immagini/btn_inserisciOrdSap.png" width="160" height="25" border="0"></div>-->
	  <div style="font-size:12px;">
      <INPUT TYPE="image" SRC="immagini/btn_inserisciOrdSap.png" width="160" height="25" border="0"></div>
        </div>
        <div style="width:35%; float:right;">
          Ordine <input type="text" name="ordine_fornitore" id="ordine_fornitore" tabindex="2">
        </div>
        <div style="width:35%; float:right;">
          Fornitore <input type="text" name="tx_fornitore" id="tx_fornitore" tabindex="1">
          <input name="ins_ord_sap" id="ins_ord_sap" type="hidden" value="1">
           <input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
       </div>
      </form>
    </div>
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
function sfuma() {
$("#layer_avviso").fadeOut(3000);

}
</SCRIPT>


</body>
</html>
