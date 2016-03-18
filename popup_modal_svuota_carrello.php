<?php
$avviso = $_GET[avviso];
$id_utente = $_GET[id_utente];
$id_carrello = $_GET[id_carrello];
$lingua = $_GET[lang];
include "query.php";


$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'richiesta_svuota_carrello'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
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
<title>Conferma eliminazione articoli carrello</title>
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

<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width="340" valign="middle" class="Stile1"><div align="center"><img src=immagini/spacer.gif width=368 height=20><br>
      <?php echo $dicitura."<br><br>"; ?>
      <table width="180" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90">
            <form name="form1" method="get" action="popup_notifica.php">
              <div align="center">
                <input type="submit" class="bottoni_notifiche" name="button" id="button" value="OK">
                <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>">
                <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
                <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
                <input name="avviso" type="hidden" id="avviso" value="<?php echo $avviso; ?>">
                <input name="id_carrello" type="hidden" id="id_carrello" value="<?php echo $id_carrello; ?>">
                </div>
        </form>        </td>
            <td width="90">
              <form name="form2" method="get" action="popup_notifica.php">
                <div align="center">
                  <input type="submit" class="bottoni_notifiche_neg" name="button" id="button" value="NO">
                  <input name="avviso" type="hidden" id="avviso" value="op_annullata">
                  <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
                </div>
              </form>      </td>
          </tr>
              </table>
    </div>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>
</body>
</html>
