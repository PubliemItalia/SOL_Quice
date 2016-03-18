<?php
$avviso = $_GET[avviso];
$id_prod = $_GET[id_prod];
$lingua = $_GET[lang];
$negozio = $_GET[negozio];
include "query.php";
/*//cancellazione riga carrello
if ($avviso == "canc_riga_prodotto_ok") {
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
$operatore = $_SESSION['nome'];
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_carrelli', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
} else {
echo "Errore durante l'inserimento10". mysql_error();
}

}
*/

switch($avviso) {
case "elimina_prodotto":
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'richiesta_canc_prodotto'";
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
<script> 
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
/*  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
*///window.close();
}
</script>
 
<style type="text/css">
<!--
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
<div id="pop_container_grande">
  <div align="center"><?php echo $dicitura; ?></div>
<?php
if ($avviso != "canc_prodotto") {
echo "<div id=spaziatore>";
 echo "</div>";
echo "<div id=scelta>";
echo "<form name=form1 method=get action=popup_notifica.php>";
    echo "<input type=submit class=bottoni_notifiche name=button id=button value=OK>";
    echo "<input name=id_prod type=hidden id=id_prod value=".$id_prod.">";
    echo "<input name=id_utente type=hidden id=id_utente value=".$id_utente.">";
    echo "<input name=lang type=hidden id=lang value=".$lingua.">";
    echo "<input name=avviso type=hidden id=avviso value=canc_prodotto>";
    echo "<input name=negozio type=hidden id=negozio value=".$negozio.">";
echo "</form>";
 echo "</div>";
echo "<div id=scelta>";
      echo "<form name=form2 method=get action=popup_notifica.php>";
    echo "<input type=submit class=bottoni_notifiche_neg name=button id=button value=NO>";
    echo "<input name=avviso type=hidden id=avviso value=op_annullata>";
    echo "<input name=lang type=hidden id=lang value=".$lingua.">";
echo "</form>";
 echo "</div>";
//fine div scelta
echo "</div>";//fine div POP container
       

  }
?>


</body>
</html>
