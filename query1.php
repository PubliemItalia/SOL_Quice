<?php 
mysql_connect("localhost", "root", "enapsoam") or die("Errore nella connessione a MySql: ");
mysql_select_db("quice_staging") or die("Errore nella selezione del db: ");
//mysql_set_charset("utf8"); //settare la codifica della connessione al db
//variabili che servono per la creazione del backup
$db_server = "localhost";
$db = "quice_staging";
$mysql_username = "root";
$mysql_password = "enapsoam";
?>
