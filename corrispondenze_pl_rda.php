<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
	$querys = "SELECT * FROM qui_packing_list ORDER BY id";
	$results = mysql_query($querys);
	while ($rows = mysql_fetch_array($results)) {
$querya = "INSERT INTO qui_corrispondenze_pl_rda (pl, rda) VALUES ('$rows[id]', '$rows[rda]')";
if (mysql_query($querya)) {
echo "inserito pl ".$rows[id]." - rda ".$rows[rda]."<br>";
} else {
echo "Errore durante l'inserimento4". mysql_error();
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
</body>
</html>