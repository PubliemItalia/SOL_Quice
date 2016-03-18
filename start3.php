<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
//session_start();
//echo 'Max Life = ' . ini_get('session.gc_maxlifetime') . "<br>";
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
//	}
require('query.php');
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "functions.php";
/*echo "array_post: ";
$array_sped = $_POST;
print_r($array_sped);
echo "<br>";
echo "idUser: ".$array_sped[IDUser]."<br>";
*/
  $user_id = addslashes($_POST['IDUser']);
$lista_utenti .= "<option selected value=>Scegli</option>";
$queryh = "SELECT * FROM qui_utenti ORDER BY nome ASC";
$resulth = mysql_query($queryh);
while ($rowh = mysql_fetch_array($resulth)) {
if ($rowh[user_id] == $user_id) {
$lista_utenti .= "<option selected value=".$rowh[user_id].">".$rowh[nome]."</option>";
} else {
$lista_utenti .= "<option value=".$rowh[user_id].">".$rowh[nome]."</option>";
}
}

  $hh = "SELECT * FROM qui_utenti WHERE user_id = '$user_id'";
$risulthh = mysql_query($hh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulthh);
if ($num_righe > 0) {
while ($rowh = mysql_fetch_array($risulthh)) {
$nome = ($rowh['nome']);
$posta = ($rowh['posta']);
$idlocalita = ($rowh['idlocalita']);
$idunita = ($rowh['idunita']);
$indirizzo = ($rowh['indirizzo']);
$CAP = ($rowh['cap']);
$company = ($rowh['company']);
$localita = ($rowh['localita']);
$nazione = ($rowh['nazione']);
$nomeunita = ($rowh['nomeunita']);
$IDResp = ($rowh['idresp']);
$ruolo = ($rowh['ruolo']);
$login = ($rowh['login']);
$negozio_buyer = ($rowh['negozio_buyer']);

$pagina = "main.php";
}
} else {
}
/*$login = addslashes($_POST['login']);
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

$hh = "SELECT * FROM qui_utenti WHERE user_id = '$user_id'";
$risulthh = mysql_query($hh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulthh);
if ($num_righe > 0) {
    // Esiste un record con questo id:
//se ho trovato l'utente aggiorno i dati
$queryv = "UPDATE qui_utenti SET login = '$login', nome = '$nome', posta = '$posta', idlocalita = '$idlocalita', idunita = '$idunita', indirizzo = '$indirizzo', cap = '$CAP', localita = '$localita', company = '$company', nazione = '$nazione', nomeunita = '$nomeunita', idresp = '$IDResp' WHERE user_id = '$user_id'";
if (mysql_query($queryv)) {
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}
} else {
//echo "non ho trovato l'utente<br>";
//se non ho trovato l'utente lo inserisco
$queryg = "INSERT INTO qui_utenti (user_id, login, nome, posta, idlocalita, idunita, indirizzo, cap, company, localita, nazione, nomeunita, idresp) VALUES ('$user_id', '$login', '$nome', '$posta', '$idlocalita', '$idunita', '$indirizzo', '$CAP', '$company', '$localita', '$nazione', '$nomeunita', '$IDResp')";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}
*/ 
?>




<html>
<head>
<title>Quice</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="tabelle.css" rel="stylesheet" type="text/css">
<SCRIPT type="text/javascript">
function aggiorna(){
document.form2.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form2.submit();
}
</SCRIPT>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<!-- CSS -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.base.css"></script>

<style type="text/css">
<!--
.style1 {color: #000000}
.columns {
width:480px; min-height: 100px; overflow:hidden; height:auto; font-family:Arial; font-size:12px; float:left;
}
.labels {
width:120px; min-height: 30px; overflow:hidden; height:auto; margin-right: 10px; float:left; text-align:left;
}
.fields {
width:336px; min-height: 30px; overflow:hidden; height:auto; float:left;  text-align:left;
}
.campi {
width:330px; height: 30px; text-align:left;
}
-->
</style>
</head>

<body style="text-align:center;">
<div id="main_container" style="width:500px; min-height:50px; overflow:hidden; height:auto; margin:auto;">
  <div style="width:100%; text-align:center; height:70px;"><img src="immagini/logo-quice.png" width="70" height="54"></div>
    <div class="columns">
      <div style="width:100%; text-align:center; height:70px; font-family:Arial; font-size:18px; font-weight:bold;">INGRESSO UTENTE</div>
      <form action="index.php" method="post" name="form2">
        <div class="labels">Cerca</div>
        <div class="fields"><?php echo '<input id="campo" class="campi" name="campo" type="text" onKeyUp="agg_tendina(this.value)" />'; ?></div>
        <div id="dati" style="width:480px; min-height: 70px; overflow:hidden; height:auto;">
              <div class="labels">Utente</div>
              <div id="tendina_user" class="fields"><?php 
                echo '<select name="IDUser" class="campi" id="IDUser" onChange="aggiorna()">';
                echo $lista_utenti;
                echo "</select>";
              ?>
              </div>
              <div class="labels">Login</div>
              <div class="fields"><input name="login" type="text" id="login" class="campi" value="<?php echo $login; ?>"></div>
              <div class="labels">Nome</div>
              <div class="fields"><input name="nome" type="text" id="nome" class="campi" value="<?php echo $nome; ?>"></div>
              <div class="labels">Mail</div>
              <div class="fields"><input name="posta" type="text" id="posta" class="campi" value="<?php echo $posta; ?>"></div>
              <div class="labels">ID Località</div>
              <div class="fields"><input name="idlocalita" type="text" id="idlocalita"class="campi" value="<?php echo $idlocalita; ?>" ></div>
              <div class="labels">ID unità</div>
              <div class="fields"><input name="idunita" type="text" id="idunita" class="campi" value="<?php echo $idunita; ?>"></div>
              <div class="labels">Indirizzo</div>
              <div class="fields"><input name="indirizzo" type="text" id="indirizzo" class="campi" value="<?php echo $indirizzo; ?>"></div>
              <div class="labels">C.A.P.</div>
              <div class="fields"><input name="CAP" type="text" id="CAP" class="campi" value="<?php echo $CAP; ?>"></div>
              <div class="labels">Località</div>
              <div class="fields"><input name="localita" type="text" id="localita" class="campi" value="<?php echo $localita; ?>"></div>
              <div class="labels">Company</div>
              <div class="fields"><input name="company" type="text" id="company" class="campi" value="<?php echo $company; ?>"></div>
              <div class="labels">Nazione</div>
              <div class="fields"><input name="nazione" type="text" id="nazione" class="campi" value="<?php echo $nazione; ?>"></div>
              <div class="labels">Nome unità</div>
              <div class="fields"><input name="nomeunita" type="text" id="nomeunita" class="campi" value="<?php echo $nomeunita; ?>"></div>
              <div class="labels">ID resp</div>
              <div class="fields"><input name="IDResp" type="text" id="IDResp" class="campi" value="<?php echo $IDResp; ?>"></div>
          </div>
        <div class="labels"></div>
        <div class="fields"><input name="ingresso" type="hidden" id="ingresso" value="1"><input type="submit" name="button" id="button" value="Invia"></div>
      </form>
    </div>
    <!--<div class="columns">
      <div style="width:100%; text-align:center; height:70px; font-family:Arial; font-size:18px; font-weight:bold;">INGRESSO ADMIN</div>
      <form name="form1" method="post" action="index_admin.php">
        <div class="labels">Login</div>
        <div class="fields"><input name="user_name" type="text" id="user_name" class="campi"></div>
        <div class="labels">Password</div>
        <div class="fields"><input name="user_pass" type="password" id="user_pass" class="campi"></div>
        <div class="labels"></div>
        <div class="fields"><input name="login_alternativo" type="hidden" id="login_alternativo" value="admin"><input type="submit" name="button2" id="button2" value="Invia"></div>
    </form>
    </div>-->
    </div>
</div>
<script type="text/javascript">
function agg_tendina(testo){
	/*alert(testo);*/
	  $.ajax({
		type: "GET",   
		url: "cerca_utenti.php",   
		data: "term="+testo,
		success: function(output) {
		$('#dati').html(output).show();
		}
		})

}
</script>
</body>
</html>