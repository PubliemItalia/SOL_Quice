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
$id_riga = $_GET[id_riga];
$id_rda = $_GET[id_rda];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$azione_form = $_SERVER['PHP_SELF'];
include "functions.php";
include "funzioni.js";

?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report_balconi.css" />
<style type="text/css">
html {
	font-family:Arial;
	font-size:11px;
}
#main_container {
	width:960px;
    height: auto;
	margin: auto;
	margin-top: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
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

</head>
<body>
<div id="main_container">
<div class="titolo_evasione_parziale">
Evasione parziale prodotti
</div>
<!--div riga colorata in evasione-->
<div class=riassunto_rda style="margin-top:15px;">
In evasione
</div>

<?php
//inizio div rda
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'processo'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'note_sing_rda') {
		$blocco_note_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga_evasa') {
		$blocco_singola_riga_evasa = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_riepilogo_sing_rda = $rigav[codice_php];
	  }

  }
$codice_php_testatina_righe = $blocco_testatina_righe;
	$sost_id_rda = '';
	$bottone_immagine = '';
	$codice_php_testatina_righe = str_replace("*sost_id_rda*",$sost_id_rda,$codice_php_testatina_righe);
	$codice_php_testatina_righe = str_replace("*XX*",$bottone_immagine,$codice_php_testatina_righe);
echo "<div class=cont_rda style=\"display:block;\" id=cont_gen>";
echo '<div class="blocco_rda">';
	echo $codice_php_testatina_righe;
$sqln = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigan = mysql_fetch_array($risultn)) {
$codice_php_singola_riga = $blocco_singola_riga;
  //inizio contenitore riga
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art = '<a href="riepilogo_bombola.php?cod='.$rigan[codice_art].'" target="_blank">';
}
if (substr($rigan[codice_art],0,1) != "*") {
  $sost_codice_art .= $rigan[codice_art];
} else {
  $sost_codice_art .= substr($rigan[codice_art],1);
}
if ($rigan[categoria] == "Bombole") {
	$sost_codice_art .= "</a>";
}

// descrizione riga
$sost_descrizione = $rigan[descrizione];
// nome unità riga
$sost_unita = $rigan[nome_unita];
switch ($rigan[azienda_prodotto]) {
	case "":
	break;
	case "VIVISOL":
	  $sost_logo .= '<img src="immagini/bottone-vivisol.png" border="0" style="margin-bottom:5px;">';
	break;
	case "SOL":
	  $sost_logo .= '<img src="immagini/bottone-sol.png" border="0" style="margin-bottom:5px;">';
	break;
}

// quant riga
    $sost_quant = "<input name=quant_originale type=hidden id=quant_originale value=".intval($rigan[quant]).">";
 if ($rigan[negozio] == "labels") {
  $sqlp = "SELECT * FROM qui_prodotti_labels WHERE codice_art='".$rigan[codice_art]."'";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigap = mysql_fetch_array($risultp)) {
		$label_ric_mag = $rigap[ric_mag];
	  if ($rigap[ric_mag] == "mag") {
		$sost_quant .= "<span style=\"color:red; font-weight:bold;\"> - ".strtoupper($rigap[ric_mag])."</span>";
		 $sost_quant .= "<input name=prezzo type=hidden id=prezzo value=".$rigap[prezzo].">";
	  }
	}
  } else {
	 $sost_quant .= "<input name=prezzo type=hidden id=prezzo value=".$rigan[prezzo].">";
  }
  //div quant riga
  $sost_quant .= "<div id=quant_display class=price6_riga_quant>";
if ($rigan[output_mode] == "") { 
$sost_quant .= "<input name=quant_evadere type=text style=\"text-align:right;\" onKeypress=\"return ctrl_solo_num(event);\" class=casella_input id=quant_evadere size=4 maxlength=4";
$sost_quant .= " value=".number_format($rigan[quant],0,",","");
$sost_quant .= ">";
} else {
$sost_quant .= intval($rigan[quant]);
}
  $sost_quant .= "</div>";
$bottone_edit = '';
  //div pulsante per evasione parziale riga
  //echo "<div class=lente_prodotto id=cont_bottone>";
  $dettaglio_stato = '<input type="button" name="pulsante_mod" id="pulsante_mod" value="OK" onClick="procedura_parziale('.$rigan[id].');">';
  //fine div pulsante per evasione parziale riga
  //echo "</div>";
  //div pulsante per visualizzare scheda
  	$bottone_lente = "";
  //div totale riga
  $sost_totale_riga = "<div id=tot_display class=price6_riga>";
  $sost_totale_riga .= number_format($rigan[totale],2,",",".");
  //fine div totale riga
  $sost_totale_riga .= "</div>";
$totale_rda = $totale_rda + $rigan[totale];
  
  
/*
*/ 
  
$aggiornamento_stato  = ''; 
	$data_aggiornata = '';
	$casella_check = '';
	$aggiornamento_stato = '';
	$colore_aggiornamento = '';
	$campo_ordsap = '';
	$colore_scritta = '';
	
	$codice_php_singola_riga = str_replace("*sost_id_riga*",$sost_id_rda,$codice_php_singola_riga);
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
  echo $codice_php_singola_riga;
//fine while
}

//fine blocco
echo "</div>";
//fine contenitore totale
echo "</div>";
?>

  <!--div riga colorata rimanenza-->
<div class=riassunto_rda style="margin-top:15px;">
    Rimanenza
</div>
  
  <div class="cont_rda" style="height:30px;" id="cont_nuovo">
    
  </div>
<div class="titolo_evasione_parziale" style="text-align:right;">
    <input type="button" name="conferma" id="conferma" value="Conferma" onClick="chiusura_tinybox();">
</div>

</div>

<script type="text/javascript">
function procedura_parziale(id_riga){
	var quant_originale =document.getElementById('quant_originale').value;
	var prezzo =document.getElementById('prezzo').value;
	var quant_evasa = document.getElementById('quant_evadere').value;
	var tot_calcolato = quant_evasa*prezzo;
	  var x;
	  if (confirm("Sei proprio sicuro di evadere parzialmente questa riga?") == true) {
		  /*x = "La modifica è stata registrata!";*/
		  $.ajax({
				  type: "GET",   
				  url: "generazione_riga_parziale.php",   
				  data: "id_riga="+id_riga+"&quant_evasa="+quant_evasa,
				  success: function(output) {
				  $('#cont_nuovo').html(output).show();
				  }
				  })
		  
		document.getElementById('quant_display').innerHTML=quant_evasa;		  
		document.getElementById('tot_display').innerHTML=tot_calcolato;	
		document.getElementById('cont_bottone').innerHTML='';	
		
	  } else {
	  document.getElementById('quant_evadere').value = quant_originale;
	  }
}
function chiusura_tinybox() {
window.parent.TINY.box.hide();
}
function abilita_bottone() {
	var quant_originale =document.getElementById('quant_originale').value;
	var quant_evasa = document.getElementById('quant_evadere').value;
	/*if (quant_evasa > 0 && quant_evasa < quant_originale) {*/
	var c = quant_originale - quant_evasa;
		if (quant_evasa == quant_originale) {
			var b = "NO";
		alert (b);
		document.getElementById('pulsante_mod').disabled = true; 
		document.getElementById('pulsante_mod').style.cursor = none;
		} else {
			
			var b = "OK";
		document.getElementById('pulsante_mod').disabled = false; 
		document.getElementById('pulsante_mod').style.cursor = pointer;
		}
		alert (quant_evasa);

		
}

</SCRIPT>
</body>
</html>
