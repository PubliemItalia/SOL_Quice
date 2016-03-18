<?php
session_start();
$nome_buyer = $_SESSION['nome'];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_buyer = $_GET['id_utente'];
$data_chiusura = mktime();

$righe_processare = array();
$d = "SELECT * FROM qui_righe_rda WHERE flag_buyer = '4' AND output_mode = 'sap'";
$risultd = mysql_query($d) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
	if (!in_array($rigad[id],$righe_processare)) {
		$add_righe = array_push($righe_processare,$rigad[id]);
}
}
foreach ($righe_processare as $riga_sing) {
  $query = "UPDATE qui_righe_rda SET flag_chiusura = '1', data_chiusura = '$data_chiusura', stato_ordine = '4', flag_buyer = '2' WHERE id = '$riga_sing'";
	if (mysql_query($query)) {
  } else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
  }
}
?>
<html>
<head>
  <title>Quice - Chiusura SAP</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
#main_container {
	width:300px;
    height: 180px;
	margin: auto;
	margin-top: 40px;
	text-align:center;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	color: rgb(0,153,102);
	font-weight:bold;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>

</head>
<body onLoad="termine_operazioni()">
<div id="main_container">
</div>

<script type="text/javascript">
function termine_operazioni(){
$("#main_container").html("Le righe che hai selezionato<br>sono state chiuse con successo");
 }

</SCRIPT>
</body>
</html>
