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
.puls_sap {
	font-family: Arial;
	width: 100%;
	height: 35px;
	}
.puls_mag_vivisol {
	font-family: Arial;
	width: 100%;
	height: 35px;
}
.puls_sap_vivisol {
	font-family: Arial;
	width: 100%;
	height: 35px;
	}
	
.puls_mag {
	font-family: Arial;
	width: 100%;
	height: 35px;
	}
.puls_ord_sol {
	font-family: Arial;
	width: 100%;
	height: 35px;
	}
.puls_ord_vivisol {
	font-family: Arial;
	width: 100%;
	height: 35px;
	}
.puls_mag_lab {
	font-family: Arial;
	width: 100%;
	height: 35px;
	}
html {
	margin-bottom:20px !important;
}
-->
</style>
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
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>
<?php
/*if (($ok_resp != "") OR ($ok_buyer != "")) {
echo "<body onLoad=\"refreshParent()\">";
} else {
echo "<body>";
}
*/?><body onLoad="MM_preloadImages('immagini/btn_green_freccia_sap_on.jpg','immagini/btn_green_freccia_mag_on.jpg','immagini/btn_green_freccia_ord_for_on.jpg')">
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
			echo '<a href="genera_tracciato_sap.php?output_ok=1&output_mode=sap&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div class="puls_sap puls_margine">
		  <img src="immagini/btn_green_freccia_sap_on.png" style="width: 227px; height:35px; cursor: pointer;">
			</div></a>';
			echo '<a href="genera_magazzino.php?output_ok=1&output_mode=mag&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div class="puls_mag puls_margine">
		  <img src="immagini/btn_green_freccia_mag_on.png" style="width: 227px; height:35px; cursor: pointer;">
			</div></a>';
			echo '<a href="genera_magazzino.php?output_ok=1&output_mode=lab&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div class="puls_mag_lab puls_margine">
		  <img src="immagini/btn_green_freccia_labels_on.png" style="width: 227px; height:35px; cursor: pointer;">
			</div></a>';
			echo '<a href="genera_ordine.php?output_ok=1&output_mode=ord&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='. $lingua.'&logo=sol"><div class="puls_ord_sol puls_margine">
		  <img src="immagini/btn_green_freccia_sol_on.png" style="width: 227px; height:35px; cursor: pointer;">
			</div></a>';
			echo '<a href="genera_ordine.php?output_ok=1&output_mode=ord&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='. $lingua.'&logo=vivisol"><div class="puls_ord_vivisol puls_margine">
		  <img src="immagini/btn_green_freccia_vivisol_on.png" style="width: 227px; height:35px; cursor: pointer;">
		  </div></a>';
		  break;
		  case "bmc":
		  echo '<a href="genera_tracciato_sap.php?output_ok=1&flusso=bmc&output_mode=bmc&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div class="puls_sap_vivisol puls_margine">
		  <img src="immagini/btn_green_freccia_sapviv_on.png" style="width: 227px; height:35px; cursor: pointer;">
		  </div></a>';		
		  echo '<a href="genera_magazzino.php?output_ok=1&output_mode=bmc&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div class="puls_mag_vivisol puls_margine">
		  <img src="immagini/btn_green_freccia_magviv_on.png" style="width: 227px; height:35px; cursor: pointer;">
		  </div></a>';
		  break;
		  case "htc":
		  echo '<a href="genera_magazzino.php?output_ok=1&output_mode=htc&id='.$id.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'"><div class="puls_mag_vivisol puls_margine">
		  <img src="immagini/btn_green_freccia_magviv_on.png" style="width: 227px; height:35px; cursor: pointer;">
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
</body>
</html>