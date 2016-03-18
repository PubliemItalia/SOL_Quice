<?php 
/*include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione","operatore","agente");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
*/
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
$lingua = $_SESSION[lang];
$pag_attuale = "guida";
//echo "lingua: ".$lingua."<br>";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

include "functions.php";
//include "testata.php";
include "menu_quice3.php";
/*echo "num_categoria1: ".$num_categoria1."<br>";
echo "num_categoria2: ".$num_categoria2."<br>";
echo "num_categoria3: ".$num_categoria3."<br>";
echo "num_categoria4: ".$num_categoria4."<br>";

echo "<br>";
*/
//echo "sess lingua: ".$_SESSION[lang]."<br>";
//echo "sess negozio: ".$_SESSION[negozio]."<br>";


?>
<html>
<head>
<title>Quice - Guida/Tutorial</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}

-->
</style>

</head>
<?php

//if ($add_pref != "") {
//echo "<body onLoad=window.open('popup_notifica.php?avviso=bookmark&id_prod=".$id."','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//echo "<body onLoad=window.open('popup_notifica.php?avviso=config','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//} else {
//}

?>
<body>
<div id="main_container">
<?php
switch ($lingua) {
case "it":
echo "<a href=tutorial/Tutorial_utente_IT.pdf target=_blank class=Stile1>".$guida_utente."</a><br>";
echo "<img src=immagini/spacer.gif width=25 height=25><br>";
echo "<a href=tutorial/Tutorial_responsabile_IT.pdf target=_blank class=Stile1>".$guida_responsabile."</a><br>";
echo "<img src=immagini/spacer.gif width=25 height=25><br>";
echo "<a href=tutorial/Tutorial_Photo_Editing.pdf target=_blank class=Stile1>".$guida_photoediting."</a><br>";
echo "<img src=immagini/spacer.gif width=25 height=25>";
break;
case "en":
echo "<a href=tutorial/Tutorial_utente_EN.pdf target=_blank class=Stile1>".$guida_utente."</a><br>";
echo "<img src=immagini/spacer.gif width=25 height=25><br>";
echo "<a href=tutorial/Tutorial_responsabile_EN.pdf target=_blank class=Stile1>".$guida_responsabile."</a><br>";
echo "<img src=immagini/spacer.gif width=25 height=25><br>";
echo "<a href=tutorial/Tutorial_Photo_Editing.pdf target=_blank class=Stile1>".$guida_photoediting."</a><br>";
echo "<img src=immagini/spacer.gif width=25 height=25>";
break;
}
?>
</div>
</body>
</html>
