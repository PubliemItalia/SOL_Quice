<?php
$avviso = $_GET[avviso];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$id_riga_carrello = $_GET[id_riga_carrello];
$id_carrello = $_GET[id_carrello];
$lingua = $_GET[lang];
include "query.php";
//cancellazione riga carrello
if ($avviso == "canc_riga_carr") {
$data_attuale = mktime();
$queryg = "UPDATE qui_righe_carrelli SET cancellato = '1' WHERE id = '$id_riga_carrello'"; 
if (mysql_query($queryg)) {
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' AND cancellato = '0'";
$result = mysql_query($querya);
$elementi_in_carrello = mysql_num_rows($result);
if ($elementi_in_carrello == 0) {
$query = "UPDATE qui_carrelli SET cancellato = '1', attivo = '0' WHERE id = '$id_carrello'"; 
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}

//inserimento nel LOG
$riepilogo = "Cancellazione riga carrello ".$id_riga_carrello." carrello: ".$id_carrello;
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

}


switch($avviso) {
case "del_riga":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'richiesta_canc_riga_carrello'";
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
break;
case "canc_riga_carr":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'canc_riga_carr'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
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
$timeout = 1500;
break;
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
-->
</style>
</head>

<body onUnload="refreshParent()">
<!--fine div POP container-->

<div class="pop_container">
  <div class="avvisi_pop">
	<?php echo $dicitura; ?>
  </div>
  <div id="puls_ok" class="cont_form_modal_pulsanti">
    <form name="form1" method="get" action="popup_notifica.php">
          <input type="submit"  class="bottoni_notifiche" name="button" id="button" value="OK">
          <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>">
          <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
          <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
        <input name="avviso" type="hidden" id="avviso" value="canc_riga_carr">
        <input name="id_carrello" type="hidden" id="id_carrello" value="<?php echo $id_carrello; ?>">
        <input name="id_riga_carrello" type="hidden" id="id_riga_carrello" value="<?php echo $id_riga_carrello; ?>">
    </form>
  </div>
  <div id="puls_no" class="cont_form_modal_pulsanti">
    <form name="form2" method="get" action="popup_notifica.php">
      <input type="submit" class="bottoni_notifiche_neg" name="button" id="button" value="NO">
      <input name="avviso" type="hidden" id="avviso" value="op_annullata">
      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
    </form>
  </div>
</div>
</body>
</html>
