<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento senza titolo</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#main_container {
	width:1000px;
	height:100%;
}
.intestazione_pl {
	width:960px;
	margin: 5px 10px;
	height: 70px;
	color: red;
	text-align: left;
	font-family:arial;
	font-size:12px;
	font-weight: bold;
	float:left;
}
.righe_pl {
	width:900px;
	margin-left: 30px;
	height: 50px;
	color: black;
	text-align: left;
	font-family:arial;
	font-size:12px;
	font-weight: normal;
	float:left;
}
.interni {
	float:left;
	width:120px;
	height: auto;
	padding:2px 10px;
}
</style>
</head>

<body>
<div id="main_container">
<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$queryv = "SELECT * FROM qui_packing_list ORDER BY id DESC";
$resultv = mysql_query($queryv);
while ($rowv = mysql_fetch_array($resultv)) {
	echo "<div class=intestazione_pl>
	  <div class=interni>".$rowv[id]."</div>
	  <div class=interni>".$rowv[rda]."</div>
	  <div class=interni>".$rowv[indirizzo_spedizione]."</div>
	  <div class=interni>".$rowv[utente]."</div>
	  <div class=interni>".date("d.m.Y",$rowv[data_spedizione])."</div>
	</div>";
$queryz = "SELECT * FROM qui_righe_rda WHERE pack_list = '$rowv[id]' ORDER BY id DESC";
$resultz = mysql_query($queryz);
while ($rowz = mysql_fetch_array($resultz)) {
	echo "<div class=righe_pl>
	  <div class=interni>".$rowz[pack_list]."</div>
	  <div class=interni>".$rowz[id_rda]."</div>
	  <div class=interni>".$rowz[descrizione]."</div>
	  <div class=interni>".$rowz[nome_unita]."</div>
	</div>";
}
}
?>
</div>
</body>
</html>