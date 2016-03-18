<?php
$avviso = $_GET[avviso];
$id_ordine = $_GET[id_ordine];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
include "query.php";
//eliminazione ordine
if ($avviso == "archiv_ordine") {
$data_attuale = mktime();
$queryg = "UPDATE qui_ordini_for SET stato = '4' WHERE id = '$id_ordine'"; 
if (mysql_query($queryg)) {

//inserimento nel LOG
$riepilogo = "Archiviazione ordine ".$id_ordine;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}




$timeout = 1500;
echo "<table width=\"360\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td colspan=\"3\"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width=\"10\"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width=\"340\" valign=\"middle\" class=\"Stile1\"><img src=immagini/spacer.gif width=340 height=40><br>
    
     L&acute;ordine ".$id_ordine." &egrave; stato archiviato,<br>come richiesto. 
	</td>
    <td width=\"10\"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>";


exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Richiesta</title>
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
<!--fine div POP container-->
<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
  <tr>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
    <td width="340" valign="middle" class="Stile1"><img src=immagini/spacer.gif width=340 height=10><br>Vuoi veramente archiviare l&acute;ordine <?php echo $id_ordine; ?>?
	<table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="120">
<form name="form1" method="get" action="popup_modal_archivia_ordine.php">
    <div align="center">
      <input type="submit"  class="bottoni_notifiche" name="button" id="button" value="OK">
      <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
    <input name="avviso" type="hidden" id="avviso" value="archiv_ordine">
    <input name="id_ordine" type="hidden" id="id_ordine" value="<?php echo $id_ordine; ?>">
    </div>
</form>
      </td>
      <td width="120">
        <form name="form2" method="get" action="popup_notifica.php">
                    <div align="center">
                      <input type="submit" class="bottoni_notifiche_neg" name="button" id="button" value="NO">
                      <input name="avviso" type="hidden" id="avviso" value="op_annullata">
                      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
              </div>
            </form>
      
      </td>
    </tr>
  </table>
    <div align="center"></div></td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=100></td>
  </tr>
  <tr>
    <td colspan="3"><img src=immagini/spacer.gif width=360 height=10></td>
  </tr>
</table>
</body>
</html>
