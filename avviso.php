<?php
session_start();
$avviso = $_GET[avviso];
//echo "<span style=\"color:rgb(0,0,0);\">";
//echo "avviso: ".$avviso."</span><br>"; 
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'troppo_poco'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione19" . mysql_error());
$num_righe = mysql_num_rows($risulteee);
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($_SESSION[lang]) {
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AVVISO</title>
<script type="text/javascript">
function chiudi() {
    setTimeout(function(){window.parent.TINY.box.hide()}, 2000);
}
</script>
</head>

<body>
<!--<body onLoad="chiudi()";>-->
<div style=" margin:auto; width:90%; height:80%; padding: 50px 20px 30px; text-align: center;">
<span style="color: green; font-size:16px; font-family:Arial; font-weight:bold;"><?php echo $dicitura; ?></span>
</div>
</body>
</html>