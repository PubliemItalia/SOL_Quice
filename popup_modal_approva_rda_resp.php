<?php
$avviso = $_GET[avviso];
$id_utente = $_GET[id_utente];
$id_rda = $_GET[id_rda];
$lingua = $_GET[lang];
include "query.php";
//echo "lingua: ".$lingua."<br>";
$queryc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND quant_modifica != ''";
$resultc = mysql_query($queryc) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num_righe_sospese = mysql_num_rows($resultc);

switch($lingua) {
case "it":
$dicitura_sospese = "<span class=stile_rosso>Per poter approvare la RdA devi completare le modifiche in sospeso</span>";
break;
case "en":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to approve the Order Request</span>";
break;
case "fr":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to approve the Order Request</span>";
break;
case "de":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to approve the Order Request</span>";
break;
case "es":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to approve the Order Request</span>";
break;
}

$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'approvazione_resp'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "it":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_it]."</span>";
break;
case "en":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_en]."</span>";
break;
case "fr":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_fr]."</span>";
break;
case "de":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_de]."</span>";
break;
case "es":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_es]."</span>";
break;
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma generazione RdA</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.Stile1 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	vertical-align: middle;
}
.Stile2 {
	font-family: Arial;
	color: red;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
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

<body onUnload="refreshParent()">
        
        <div id="pop_container">
<img src=immagini/spacer.gif width=368 height=20> 
  <?php 
  	if ($num_righe_sospese > 0) {
echo $dicitura_sospese."<br>";
	} else {
echo $dicitura;
	}
	?>

<div id="scelta">
<table width="240" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="120">
<form name="form1" method="get" action="approva_Rda.php">
    <div align="center">
    <?php
		if ($num_righe_sospese < 1) {
      echo "<input type=submit name=button class=bottoni_notifiche id=button value=OK>";
		}
		?>
                    <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>">
                    <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
                    <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
                    <input name="avviso" type="hidden" id="avviso" value="<?php echo $avviso; ?>">
                    <input name="id_rda" type="hidden" id="id_rda" value="<?php echo $id_rda; ?>">
    </div>
</form>
      </td>
      <td width="120">
        <form name="form2" method="get" action="popup_notifica.php">
                    <div align="center">
    <?php
		if ($num_righe_sospese < 1) {
                      echo "<input type=submit name=button class=bottoni_notifiche_neg id=button value=NO>";
		}
		?>

              <input name="avviso" type="hidden" id="avviso" value="op_annullata">
              <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
         </div>
    </form>
      
      </td>
    </tr>
  </table>
            
        

</div><!--fine div scelta-->
</div><!--fine div POP container-->
</body>
</html>
