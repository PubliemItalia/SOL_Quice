<?php
$avviso = $_GET[avviso];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$negozio_prod = $_GET[negozio_prod];
$id_riga_carrello = $_GET[id_riga_carrello];
$lingua = $_GET[lang];
include "query.php";


switch($avviso) {
case "del_bookmark":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'richiesta_canc_bookmark'";
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
break;
case "config":
$dicitura = "I dati sono stati modificati correttamente!";
break;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Richiesta</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Stile1 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	vertical-align: middle;
}
-->
</style></head>

<body onUnload="refreshParent()">
<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width="340" valign="middle" class="Stile1"><img src=immagini/spacer.gif width=340 height=20><br>
      <?php echo $dicitura; ?><br>
    <img src=immagini/spacer.gif width=340 height=20>
<table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="120">
<form name="form1" method="get" action="popup_notifica.php">
    <div align="center">
      <input type="submit" name="button" id="button" value="OK">
      <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>">
      <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
      <input name="avviso" type="hidden" id="avviso" value="del_bookmark">
    </div>
</form>
      </td>
      <td width="120">
        <form name="form2" method="get" action="popup_notifica.php">
                    <div align="center">
                      <input type="submit" name="button" id="button" value="NO">
                      <input name="avviso" type="hidden" id="avviso" value="op_annullata">
                      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
                            </div>
            </form>
      
      </td>
    </tr>
  </table>
    </td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>
</body>
</html>
