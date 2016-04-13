<?php
session_start();
$id = $_GET[id];
$output_mode = $_GET[output_mode];
$output_ok = $_GET[output_ok];
$lingua = $_SESSION[lang];
//$lingua = $_SESSION[lang];
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
//echo "output_ok: ".$output_ok."<br>";
//echo "output_mode: ".$output_mode."<br>";
$id_utente = $_SESSION[user_id];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
//$query = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '1' ORDER BY id_rda ASC";
$array_rda = array();
$query = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '1' AND id_buyer = '$id_utente' AND output_mode = '' ORDER BY id_rda ASC";
$risulty = mysql_query($query) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulty);
while ($rowy = mysql_fetch_array($risulty)) {
	if (!in_array($rowy[id_rda],$array_rda)) {
		$add_rda = array_push($array_rda,$rowy[id_rda]);
		$lista_rda .= $rowy[id_rda].", ";
		$conteggio_rda = $conteggio_rda + 1;
	}
}

//echo "num_righe: ".$num_righe."<br>";
if ($output_ok != "") {
/*case "war":
break;
case "qor":
break;
}
*/
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selezione output RdA</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#main_container {
	width:360px;
	margin: auto;
}
body {
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align:center;
}
.Stile1 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
.puls_margine {
	margin-bottom:10px;
}
.puls_altezza {
	height: 37px;
	overflow:hidden;
}
.puls_sap {
	font-family: Arial;
	width: 100%;
	}
.puls_mag_vivisol {
  /* IE 8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";

  /* IE 5-7 */
  filter: alpha(opacity=70);

  /* Netscape */
  -moz-opacity: 0.7;

  /* Safari 1.x */
  -khtml-opacity: 0.7;

  /* Good browsers */
  opacity: 0.7;
  	font-family: Arial;
	width: 100%;
}
.puls_mag_vivisol:hover {
  /* IE 8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";

  /* IE 5-7 */
  filter: alpha(opacity=100);

  /* Netscape */
  -moz-opacity: 1;

  /* Safari 1.x */
  -khtml-opacity: 1;

  /* Good browsers */
  opacity: 1;
  }
.puls_sap_vivisol {
	font-family: Arial;
	width: 100%;
	}
	
.puls_mag {
	font-family: Arial;
	width: 100%;
	}
.puls_ord_sol {
	font-family: Arial;
	width: 100%;
	}
.puls_ord_vivisol {
	font-family: Arial;
	width: 100%;
	}
.puls_mag_lab {
	font-family: Arial;
	width: 100%;
	}
html {
	margin-bottom:20px !important;
}
-->
</style>
 <script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
window.close();
}
</script>
</head>
<?php
/*if (($ok_resp != "") OR ($ok_buyer != "")) {
echo "<body onLoad=\"refreshParent()\">";
} else {
echo "<body>";
}
*/?>
<body onLoad="MM_preloadImages('immagini/btn_green_freccia_sap_on.jpg','immagini/btn_green_freccia_mag_on.jpg','immagini/btn_green_freccia_ord_for_on.jpg')">
<?php
$array_cat_flusso = array();
	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione02" . mysql_error());
    while ($rigat = mysql_fetch_array($risultt)) {
		if ($rigat[flusso] != "") {
		  $flusso = $rigat[flusso];
		}
	}
if ($num_righe > 0) {
	echo '<div style="width:380px; min-height:40px; overflow: hidden; height: auto; margin: 20px auto; text-align: left !important;">';
		if ($conteggio_rda > 1) {
			echo '<div class="messaggio_rda">Puoi processare solo una RdA per volta</div>';
		} else {
	  echo '<div class="titolo_rda" style="width:100%; min-height:30px; overflow: hidden; height: auto; color:rgb(0,0,0); float: left; text-align: left !important;">
		<strong>RdA '.$lista_rda.'<br></strong>
	  </div>
	  <div style="width:40%; min-height:30px; overflow: hidden; height: auto; color:rgb(0,0,0); float: left; text-align: left !important;">
		Invia la richiesta<br>al seguente processo
	  </div>
	  <div style="width:60%; min-height:60px; overflow: hidden; height: auto; color:rgb(0,0,0); float: left;">';
		  switch ($flusso) {
		  case "":
			echo '<a href="genera_tracciato_sap.php?output_ok=1&output_mode=sap&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div id="sap" class="puls_sap puls_margine puls_altezza">
		  <img id="sapd" src="immagini/btn_green_freccia_sap_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
			</div></a>';
			echo '<a href="genera_magazzino.php?output_ok=1&output_mode=mag&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div id="mag" class="puls_mag puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_mag_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
			</div></a>';
			echo '<a href="genera_magazzino.php?output_ok=1&output_mode=lab&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div id="lab" class="puls_mag_lab puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_labels_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
			</div></a>';
			echo '<a href="genera_ordine.php?output_ok=1&output_mode=ord&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='. $lingua.'&logo=sol"><div id="ord_sol" class="puls_ord_sol puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_sol_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
			</div></a>';
			echo '<a href="genera_ordine.php?output_ok=1&output_mode=ord&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='. $lingua.'&logo=vivisol"><div id="ord_viv" class="puls_ord_vivisol puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_vivisol_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
		  </div></a>';
		  break;
		  case "bmc":
		  echo '<a href="genera_tracciato_sap.php?output_ok=1&flusso=bmc&output_mode=bmc&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div id="sap_viv" class="puls_sap_vivisol puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_sapviv_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
		  </div></a>';		
		  echo '<a href="genera_magazzino.php?output_ok=1&output_mode=bmc&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div id="mag_viv" class="puls_mag_vivisol puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_magviv_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
		  </div></a>';
		  break;
		  case "htc":
		  echo '<a href="genera_magazzino.php?output_ok=1&output_mode=htc&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div id="mag_viv" class="puls_mag_vivisol puls_margine puls_altezza">
		  <img src="immagini/btn_green_freccia_magviv_onoff.png" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
		  </div></a>';
		  break;
		  case "pre":
			echo '<a href="genera_ordine.php?output_ok=1&output_mode=ord&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='. $lingua.'&logo=sol"><div id="ord_sold" class="puls_ord_sol puls_margine puls_altezza">
		  <img src="immagini/prenota_onoff.png" id="ord_sol" style="cursor: pointer;" onmouseover="scambioOn(this)" onmouseout="scambioOff(this)">
			</div></a>';
		  break;
		  }
		}
	  echo '</div>
	</div>
	';
} else {
//se non ci sono righe rda selezionate
	echo '<div class="Stile1" style="width:400px; min-height:40px; overflow: hidden; height: auto; margin: auto;">
		Nessun elemento<br>appartenente alla RdA '.$id.'<br>selezionata
	</div>
	';
}
?> 

<script type="text/javascript">
function scambioOn(x){
    x.style.margin = "-47px 0px 0px 0px";
	/*
    x.style.height = "32px";
    x.style.width = "32px";
	alert(x);
		  switch (id) {
		  case "sap":
			id.style.margin = "20px 0px 0px 0px";
		  break;
		  case "mag":
		  var imgsost = '<img src="immagini/btn_green_freccia_mag_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "lab":
		  var imgsost = '<img src="immagini/btn_green_freccia_labels_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "ord_sol":
		  var imgsost = '<img src="immagini/btn_green_freccia_sol_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "ord_viv":
		  var imgsost = '<img src="immagini/btn_green_freccia_vivisol_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "sap_viv":
		  var imgsost = '<img src="immagini/btn_green_freccia_sapviv_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "mag_viv":
		  var imgsost = '<img src="immagini/btn_green_freccia_magviv_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "pre":
			var imgsost = '<img src="immagini/prenota_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  }
	$('#'+mode).html(imgsost).show();
	*/
}
function scambioOff(x){
    x.style.margin = "0px 0px 0px 0px";
	/*
	alert(mode2+',off');
		  switch (id) {
		  case "sap":
			id.style.margin = "0px 0px 0px 0px";
		  break;
		  case "mag":
		  var imgsost2 = '<img src="immagini/btn_green_freccia_mag_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "lab":
		  var imgsost2 = '<img src="immagini/btn_green_freccia_labels_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "ord_sol":
		  var imgsost2 = '<img src="immagini/btn_green_freccia_sol_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "ord_viv":
		  var imgsost2 = '<img src="immagini/btn_green_freccia_vivisol_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "sap_viv":
		  var imgsost2 = '<img src="immagini/btn_green_freccia_sapviv_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "mag_viv":
		  var imgsost2 = '<img src="immagini/btn_green_freccia_magviv_on.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  case "pre":
			var imgsost2 = '<img src="immagini/prenota_off.png" style="width: 227px; height:35px; cursor: pointer;">';
		  break;
		  }
	$('#'+mode2).html(imgsost2).show();
	*/
}
 </script>      
</body>
</html>