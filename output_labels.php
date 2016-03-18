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
//$query = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '1' AND id_buyer != '$id_utente' ORDER BY id_rda ASC";
$query = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer = '1' ORDER BY id_rda ASC";
$risulty = mysql_query($query) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulty);
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
}
.Stile1 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
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
if ($num_righe > 0) {
echo "<table width=400 border=0 align=center cellpadding=0 cellspacing=0>";
  echo "<tr>";
    echo "<td class=titolo_rda>&nbsp;</td>";
    echo "<td class=titolo_rda><img src=immagini/spacer.gif width=10 height=15></td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td width=25 class=titolo_rda>&nbsp;</td>";
    echo "<td width=154 class=titolo_rda><strong>RdA ".$id."<br>";
echo "</strong></td>";
    echo "<td width=196>&nbsp;</td>";
    echo "<td width=25>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign=bottom class=titolo_rda>&nbsp;</td>";
    echo "<td valign=bottom class=titolo_rda>Invia la richiesta<br>";
    echo "al seguente processo</td>";
    echo "<td><img src=immagini/spacer.gif width=10 height=40></td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td>&nbsp;</td>";
    echo "<td><img src=immagini/spacer.gif width=10 height=40></td>";
    echo "<td valign=bottom><div align=right><a href=genera_ordine.php?output_ok=1&output_mode=ord&id=".$id."&id_utente=".$_SESSION[user_id]."&lang=". $lingua."&logo=sol><img src=immagini/btn_blu_sol_freccia_170x27off.png name=ord_for width=170 height=27 border=0 id=ord_for onMouseOver=\"MM_swapImage('ord_for','','immagini/btn_blu_sol_freccia_170x27on.png',1)\" onMouseOut=\"MM_swapImgRestore()\"></a></div></td>";
    echo "<td valign=bottom>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td>&nbsp;</td>";
    echo "<td><img src=immagini/spacer.gif width=10 height=40></td>";
    echo "<td valign=bottom><div align=right><a href=genera_ordine.php?output_ok=1&output_mode=ord&id=".$id."&id_utente=".$_SESSION[user_id]."&lang=". $lingua."&logo=vivisol><img src=immagini/btn_green_vivisol_freccia_170x27off.png name=ord_for width=170 height=27 border=0 id=ord_for onMouseOver=\"MM_swapImage('ord_for','','immagini/btn_green_vivisol_freccia_170x27on.png',1)\" onMouseOut=\"MM_swapImgRestore()\"></a></div></td>";
    echo "<td valign=bottom>&nbsp;</td>";
  echo "</tr>";
echo "</table>";
} else {
//se non ci sono righe rda selezionate
echo "<table width=400 border=0 align=center cellpadding=0 cellspacing=0>";
  echo "<tr>";
    echo "<td width=10><img src=immagini/spacer.gif width=10 height=200></td>";
    echo "<td width=380 valign=middle class=Stile1>Nessun elemento<br>appartenente alla RdA ".$id."<br>selezionato";
echo "</td>";
    echo "<td width=10><img src=immagini/spacer.gif width=10 height=200></td>";
  echo "</tr>";
echo "</table>";
}
?>            
</body>
</html>