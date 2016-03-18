<?php 
/*mysql_connect("localhost", "root", "luigi") or die("Errore nella connessione a MySql: ");
mysql_select_db("oneway") or die("Errore nella selezione del db: ");*/
/*$connessione = mysql_connect("62.149.150.20", "Sql30420", "x-HTwwBD") or die("Errore nella connessione a MySql: " . mysql_error());
mysql_select_db("Sql30420_4", $connessione) or die("Errore nella selezione del db: " . mysql_error());*/
$connessione = mysql_connect("172.16.0.14", "luigiows", "rivaows") or die("Errore nella connessione a MySql: " . mysql_error());
mysql_select_db("diste", $connessione) or die("Errore nella selezione del db: " . mysql_error());
$prefix = "ows_";
?>