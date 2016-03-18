<html>
<head>
  <title>Quice - pacchi</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report_balconi.css" />
<style type="text/css">
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
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>

</head>
<body>
<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$ads = $_GET['ads'];
$rid = $_GET['rid'];
$id = $_GET['id'];
$id_prod = $_GET['id_prod'];
$quant = $_GET['quant'];
$mode = $_GET['mode'];
$tipologia = $_GET['tipologia'];
$lingua = $_GET['lang'];
$negozio = $_GET['negozio'];
$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id_prod'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione_1" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$ric_mag = $rigad[ric_mag];
$um = $rigad[um];
$categoria1_it = $rigad[categoria1_it];
$categoria2_it = $rigad[categoria2_it];
$categoria3_it = $rigad[categoria3_it];
$categoria4_it = $rigad[categoria4_it];
$materiale = $rigad[materiale];
$pressione = $rigad[pressione];
}
if ($quant > 0) {
switch ($_SESSION[lang]) {
	case "it":
	$c_bombola = "Devo acquistare le bombole (prosegui con la scelta delle bombole)";
	$s_bombola = "Ho a disposizione le bombole necessarie per il pacco (indicare le caratteristiche delle bombole)";
	$scelta_bomb = "Scelta bombole (scelta obbligatoria dopo l&acute;inserimento del numero di pacchi richiesti)";
	$package = "Package bombole (scelta obbligatoria dopo l&acute;inserimento del numero di bombole richieste)";
	$pacco = "Pacco bombole";
	$cestello = "Cestello";
	$pallet = "Pallet";
	$nessuno = "Nessuno";
	break;
	case "en":
	$c_bombola = "I&acute;ve to buy the cylinders (continue with the cylinders choice)";
	$s_bombola = "I already have the needed cylinders for bundle (please specify cylinders specifications)";
	$scelta_bomb = "Do you want to choose some Cylinders? (required choice after input of required bundle number)";
	$package = "Cylinder package (required choice after input of required cylinder number)";
	$pacco = "Bundle";
	$cestello = "Cestello";
	$pallet = "Pallet";
	$nessuno = "None";
	break;
}
switch ($categoria1_it) {
	case "Bombole":
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#CCC;\">";
	  $output .= $package;
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= $pacco;
	  $output .= "</div>";
	  $output .= "<div style=\"width:auto; height:auto; float:right; font-size:12px;font-weight:bold; color:#000;\">";
	   $output .= "<input type=radio onClick=\"aggiorna_solo_bottone_invio_bomb('pacco');\" name=gruppoPacchi value=pacco id=gruppoPacchi_0>";
	//$output .= "<input type=submit name=submit id=submit value=OK onclick=\"validateForm(); processa_bombola('".$percorso_pacco."');\">";
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= $cestello;
	  $output .= "</div>";
	  $output .= "<div style=\"width:auto; height:auto; float:right; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= "<input type=radio onClick=\"aggiorna_solo_bottone_invio_bomb('cestello');\" name=gruppoPacchi value=cestello id=gruppoPacchi_1>";
	  //$output .= "<input type=submit name=submit id=submit value=OK onclick=\"processa_bombola('".$percorso_cestello."');\">";
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= $pallet;
	  $output .= "</div>";
	  $output .= "<div style=\"width:auto; height:auto; float:right; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= "<input type=radio onClick=\"aggiorna_solo_bottone_invio_bomb('pallet');\" name=gruppoPacchi value=pallet id=gruppoPacchi_2>";
	//  $output .= "<input type=submit name=submit id=submit value=OK onclick=\"processa_bombola('1');\">";
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= $nessuno;
	  $output .= "</div>";
	  $output .= "<div style=\"width:auto; height:auto; float:right; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= "<input type=radio onClick=\"aggiorna_solo_bottone_invio_bomb('nessuno');\" name=gruppoPacchi value=nessuno id=gruppoPacchi_3>";
	//  $output .= "<input type=button name=button id=button value=OK onClick=\"validateForm()\">";
	  $output .= "</div>";
	$output .= "</div>";
	break;
	case "Pacchi_bombole":
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#CCC;\">";
	  $output .= $scelta_bomb;
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= $c_bombola;
	  $output .= "</div>";
	  $output .= "<div style=\"width:auto; height:auto; float:right; font-size:12px;font-weight:bold; color:#000;\">";
	   $output .= "<input type=radio onClick=\"aggiornamento_pacchi('si_bomb');\" name=gruppoPacchi value=si id=gruppoPacchi_0>";
	//$output .= "<input type=submit name=submit id=submit value=OK onclick=\"validateForm(); processa_bombola('".$percorso_pacco."');\">";
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div style=\"width:100%; height:25px; border-bottom:1px solid black; float:left; padding:3px 0px 0px 5px;\">";
	  $output .= "<div style=\"width:auto; height:auto; float:left; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= $s_bombola;
	  $output .= "</div>";
	  $output .= "<div style=\"width:auto; height:auto; float:right; font-size:12px;font-weight:bold; color:#000;\">";
	  $output .= "<input type=radio onClick=\"aggiornamento_pacchi('no_bomb');\" name=gruppoPacchi value=no id=gruppoPacchi_1>";
	  //$output .= "<input type=submit name=submit id=submit value=OK onclick=\"processa_bombola('".$percorso_cestello."');\">";
	  $output .= "</div>";
	$output .= "</div>";
	$output .= "<div id=note_bombole style=\"width:100%; height:40px; float:left; padding:3px 0px 0px 0px;\">";
	
	$output .= "</div>";
	break;
	default:
	$output .= "";
		break;
	}
}
echo $output;
 ?>
</body>
</html>