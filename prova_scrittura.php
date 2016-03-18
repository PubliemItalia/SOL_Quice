<?php
session_start();
$lingua = $_SESSION[lang];
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
//$lingua = $_SESSION[lang];
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
$id_utente = $_SESSION[user_id];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$queryd = "SELECT * FROM qui_utenti WHERE user_id = '1588'";
$resultd = mysql_query($queryd) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowd = mysql_fetch_array($resultd)) {
$nome = $rowd[nome];
$posta = $rowd[posta];
}
//FINE RECORD
$articolo = str_pad($nome, 177, " ", STR_PAD_RIGHT);
//echo "contalettere: ".$contalettere."<br>";
$articolo .= "$#\r\n";
//$articolo = str_pad($articolo, 177, " ", STR_PAD_RIGHT)."$#\n";

$articolo = str_pad($posta, 177, " ", STR_PAD_RIGHT);
//echo "contalettere: ".$contalettere."<br>";
$articolo .= "$#\r\n";
//$articolo = str_pad($articolo, 177, " ", STR_PAD_RIGHT)."$#\n";

//accodo al blocco da scrivere nel file la riga dell'articolo
$sap_record .= $articolo;
$articolo = "";
$fg = fopen("ferjan", 'w') or die("can't open file");
fwrite($fg, $sap_record);
fclose($fg);
$sap_record = "";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
<!--window.opener.location.href+'#<?php echo $id_prod; ?>'
  if (window.opener.progressWindow)
 {
    window.opener.progressWindow.close()
  }
window.close();
}
</script>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<!--<body onUnload="remote2('ricerca_prodotti.php#<? echo $id_prod; ?>')">-->
<body onUnload="refreshParent()">
</body>
</html>

