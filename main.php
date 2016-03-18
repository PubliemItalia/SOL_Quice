<?php
@session_start();
if ($_POST['IDUser'] != "") {
    $_SESSION[user_id]=$_POST[IDUser];
    $_SESSION[posta]=$_POST[posta];
    $_SESSION[IDResp]=$_POST[IDResp];
	$_SESSION[login]=$_POST[login];
	$_SESSION[nome]=$_POST[nome];
	$_SESSION[idlocalita]=$_POST[idlocalita];
	$_SESSION[idunita]=$_POST[idunita];
	$_SESSION[indirizzo]=$_POST[indirizzo];
	$_SESSION[CAP]=$_POST[CAP];
	$_SESSION[localita]=$_POST[localita];
	$_SESSION[company]=$_POST[company];
	$_SESSION[nazione]=$_POST[nazione];
	$_SESSION[nomeunita]=$_POST[nomeunita];
	$_SESSION[ruolo]="User";
}
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
require('query.php');
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "functions.php";
if ($_POST['IDUser'] != "") {
$user_id = $_POST['IDUser'];
$login = addslashes($_POST['login']);
$nome = addslashes($_POST['nome']);
$posta = addslashes($_POST['posta']);
$idlocalita = addslashes($_POST['idlocalita']);
$idunita = addslashes($_POST['idunita']);
$indirizzo = addslashes($_POST['indirizzo']);
$CAP = addslashes($_POST['CAP']);
$localita = addslashes($_POST['localita']);
$company = addslashes($_POST['company']);
$nazione = addslashes($_POST['nazione']);
$nomeunita = addslashes($_POST['nomeunita']);
$IDResp = addslashes($_POST['IDResp']);
$pagina = "main.php";

$hh = "SELECT * FROM utenti WHERE user_id = '$user_id'";
$risulthh = mysql_query($hh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulthh);
if ($num_righe > 0) {
    // Esiste un record con questo id:
//se ho trovato l'utente aggiorno i dati
$queryv = "UPDATE utenti SET login = '$login', nome = '$nome', posta = '$posta', idlocalita = '$idlocalita', idunita = '$idunita', indirizzo = '$indirizzo', cap = '$CAP', localita = '$localita', company = '$company', nazione = '$nazione', nomeunita = '$nomeunita', idresp = '$IDResp' WHERE user_id = '$user_id'";
if (mysql_query($queryv)) {
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}
} else {
//echo "non ho trovato l'utente<br>";
//se non ho trovato l'utente lo inserisco
$queryg = "INSERT INTO utenti (user_id, login, nome, posta, idlocalita, idunita, indirizzo, cap, company, localita, nazione, nomeunita, idresp) VALUES ('$user_id', '$login', '$nome', '$posta', '$idlocalita', '$idunita', '$indirizzo', '$CAP', '$company', '$localita', '$nazione', '$nomeunita', '$IDResp')";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}
$mm = "SELECT * FROM utenti WHERE user_id = '$user_id'";
$risultmm = mysql_query($mm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
 while ($rigamm = mysql_fetch_array($risultmm)) {
$_SESSION[ruolo] = $rigamm[ruolo];
}
}
include "testata.php";
?>
<html>
<head>
  <title>Geoflow-Menu principale</title>
<link href="tabelle.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;	
}
-->
</style>

<SCRIPT type="text/javascript">
function aggiorna(){
document.form_lingua.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_lingua.submit();
}
</SCRIPT>
</head>
<body>
<div class="ecoformcentro" id="main_container">
<table width=960 border=1 align="center" cellspacing=0>
<tr><td class=titoli>MENU PRINCIPALE</td></tr></table><br>
Benvenuto, <strong> <?php echo $_SESSION[nome]; ?></strong>, il tuo ruolo &egrave; <strong><?php echo $_SESSION[ruolo]; ?></strong>
</div>
</body>
</html>
