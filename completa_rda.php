<?php
$rda = $_POST[rda];
$inserisci = $_POST[inserisci];
if ($inserisci == 1) {
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$query = "UPDATE qui_rda SET stato = '4' WHERE id = '$rda'"; 
if (mysql_query($query)) {
	echo "RdA ".$rda." aggiornata correttamente<br>";
} else {
echo "Errore durante l'inserimento". mysql_error();
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
</head>

<body>
<form action="completa_rda.php" method="post" name="chiusura">
<input name="rda" id="rda" type="text" />
<input name="SALVA" type="submit" />
<input name="inserisci" id="inserisci" type="hidden" value="1" />
</form>
</body>
</html>