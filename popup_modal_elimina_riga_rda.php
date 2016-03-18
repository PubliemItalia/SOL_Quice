<?php
$avviso = $_GET[avviso];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$id_riga_rda = $_GET[id_riga_rda];
$id_rda = $_GET[id_rda];
$lingua = $_GET[lang];
include "query.php";

$sqlp = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga_rda'";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigap = mysql_fetch_array($risultp)) {
$rda_lav = $rigap[id_rda]; 
}

$sqlr = "SELECT * FROM qui_righe_rda WHERE id_rda = '$rda_lav'";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$righe_residue = mysql_num_rows($risultr);

if ($righe_residue > 1) {
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'richiesta_canc_riga_rda'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
} else {
$var_canc_rda = "<input name=canc_anche_rda type=hidden id=canc_anche_rda value=1>";
//echo "ultima riga<br>";
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'richiesta_canc_ultima_riga_rda'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
}
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "":
case "it":
$dicitura = $rigaeee[testo_it];
break;
case "en":
$dicitura = $rigaeee[testo_en];
break;
case "fr":
$dicitura = $rigaeee[testo_fr];
break;
case "de":
$dicitura = $rigaeee[testo_de];
break;
case "es":
$dicitura = $rigaeee[testo_es];
break;
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eliminazione riga RdA</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#modal_container {
	width:400px;
	min-height:70px;
	overflow:hidden;
	height: auto;
	margin: auto;
	margin-top: 10px;
	padding-top: 25px;
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	left: auto;
	right: auto;
	vertical-align: middle;
}
#spaziatura{
	width:400px;
	min-height:40px;
	overflow:hidden;
	height: auto;
	float: left;
}
.form_div{
	width:200px;
	min-height:40px;
	overflow:hidden;
	height: auto;
	float: left;
}
.bottoni_notifiche {
	width:70px;
	height: 40px;
	margin: auto;
	margin-top: 10px;
	padding: 5px;
	font-family: Arial;
	font-weight: bold;
	color: white;
	background-color:green;
	font-size: 18px;
	text-align: center;
	border:2px solid green;
}
.bottoni_notifiche_neg {
	width:70px;
	height: 40px;
	margin: auto;
	margin-top: 10px;
	padding: 5px;
	font-family: Arial;
	font-weight: bold;
	color: green;
	background-color:white;
	font-size: 18px;
	text-align: center;
	border:2px solid green;
}
-->
</style>
</head>

<body>
<!--<body onUnload="refreshParent()">-->
<div id="modal_container">
<div id="spaziatura">
<?php echo $dicitura; ?>
</div>
<div class="form_div">
<form name="form1" method="get" action="popup_notifica.php">
    
   <input type="submit" class="bottoni_notifiche" name="button" id="button" value="OK">
    <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>">
    <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
    <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
    <input name="avviso" type="hidden" id="avviso" value="del_riga_rda">
    <input name="id_rda" type="hidden" id="id_rda" value="<?php echo $id_rda; ?>">
    <input name="id_riga_rda" type="hidden" id="id_riga_rda" value="<?php echo $id_riga_rda; ?>">
    <?php echo $var_canc_rda; ?>
</form>
    </div>
<div class="form_div">
        <form name="form2" method="get" action="popup_notifica.php">
                      <input type="submit" class="bottoni_notifiche_neg" name="button" id="button" value="NO">
                      <input name="avviso" type="hidden" id="avviso" value="op_annullata">
                      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
            </form>
    </div>
      
</div><!--fine div POP container-->

</body>
</html>
