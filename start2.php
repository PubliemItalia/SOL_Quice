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
	$_SESSION[companyName]=$_POST[companyName];
	$_SESSION[nazione]=$_POST[nazione];
	$_SESSION[nomeunita]=$_POST[nomeunita];
	$_SESSION[ruolo]="User";
	$_SESSION[IDCompany] = $_POST[IDCompany];
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
$companyName = ($rowh['companyName']);
$company = ($rowh['company']);
$localita = ($rowh['localita']);
$nazione = ($rowh['nazione']);
$nomeunita = ($rowh['nomeunita']);
$IDResp = ($rowh['idresp']);
$ruolo = ($rowh['ruolo']);
$login = ($rowh['login']);
$negozio_buyer = ($rowh['negozio_buyer']);
$IDCompany = ($rowh['IDCompany']);

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
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>

<body>
<table width="309" align="center" cellspacing="0">
  <tr> 
    <td width="1020">
      <div align="center"><img src="immagini/logo-quice.png" width="70" height="54"><br>
      </div></td></tr>
</table>

<table width="658" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="342" valign="top"><form action="index.php" method="post" name="form2">
  <div align="center"><strong>INGRESSO UTENTE<br>
    </strong>
  </div>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="111">Utente</td>
      <td width="189"><?php
      echo "<select name=IDUser class=ecoform id=IDUser onChange=aggiorna()>";
      echo $lista_utenti;
      echo "</select>";
      ?></td>
    </tr>
    <tr>
      <td>Login </td>
      <td><input name="login" type="text" id="login" size="25" value="<?php echo $login; ?>"></td>
    </tr>
    <tr>
      <td>Nome </td>
      <td><input name="nome" type="text" id="nome" size="25" value="<?php echo $nome; ?>">
      </td>
    </tr>
    <tr>
      <td>Mail </td>
      <td><input name="posta" type="text" id="posta" size="25" value="<?php echo $posta; ?>"></td>
    </tr>
    <tr>
      <td>ID Località </td>
      <td><input name="idlocalita" type="text" id="idlocalita"size="25" value="<?php echo $idlocalita; ?>" ></td>
    </tr>
    <tr>
      <td>ID unità </td>
      <td><input name="idunita" type="text" id="idunita" size="25" value="<?php echo $idunita; ?>"></td>
    </tr>
    <tr>
      <td>Indirizzo </td>
      <td><input name="indirizzo" type="text" id="indirizzo" size="25" value="<?php echo $indirizzo; ?>"></td>
    </tr>
    <tr>
      <td>C.A.P. </td>
      <td><input name="CAP" type="text" id="CAP" size="25" value="<?php echo $CAP; ?>"></td>
    </tr>
    <tr>
      <td>Località </td>
      <td><input name="localita" type="text" id="localita" size="25" value="<?php echo $localita; ?>"></td>
    </tr>
    <tr>
      <td>company</td>
      <td><input name="company" type="text" id="company" size="25" value="<?php echo $company; ?>"></td>
    </tr>
    <tr>
      <td>companyName</td>
      <td><input name="companyName" type="text" id="companyName" size="25" value="<?php echo $companyName; ?>"></td>
    </tr>
    <tr>
      <td>IDCompany</td>
      <td><input name="IDCompany" type="text" id="IDCompany" size="25" value="<?php echo $IDCompany; ?>"></td>
    </tr>
    <tr>
      <td>Nazione </td>
      <td><input name="nazione" type="text" id="nazione" size="25" value="<?php echo $nazione; ?>"></td>
    </tr>
    <tr>
      <td>Nome unità </td>
      <td><input name="nomeunita" type="text" id="nomeunita" size="25" value="<?php echo $nomeunita; ?>"></td>
    </tr>
    <tr>
      <td>ID resp</td>
      <td><input name="IDResp" type="text" id="IDResp" size="25" value="<?php echo $IDResp; ?>"></td>
    </tr>
<!--    <tr>
      <td>Ruolo</td>
      <td><select name="ruolo" class="ecoform" id="ruolo">
      <?php
/*	  switch ($ruolo) {
	  case "utente":
	  echo "<option selected value=utente>Utente</option>";
      echo "<option value=responsabile>Responsabile</option>";
      echo "<option value=buyer>Buyer</option>";
     echo "<option value=magazziniere>Magazziniere</option>";
	  break;
	  case "responsabile":
	  echo "<option value=utente>Utente</option>";
      echo "<option selected value=responsabile>Responsabile</option>";
      echo "<option value=buyer>Buyer</option>";
     echo "<option value=magazziniere>Magazziniere</option>";
	  break;
	  case "buyer":
	  echo "<option value=utente>Utente</option>";
      echo "<option value=responsabile>Responsabile</option>";
      echo "<option selected value=buyer>Buyer</option>";
     echo "<option value=magazziniere>Magazziniere</option>";
	  break;
	  case "magazziniere":
	  echo "<option value=utente>Utente</option>";
      echo "<option value=responsabile>Responsabile</option>";
       echo "<option value=buyer>Buyer</option>";
     echo "<option selected value=magazziniere>Magazziniere</option>";
	  break;
	  }
*/      
	  ?>
 </select>        
      </td>
    </tr>
     <tr>
      <td>Negozio (buyer)</td>
      <td><select name="negozio_buyer" class="ecoform" id="negozio_buyer">
            <?php
/*	  switch ($negozio_buyer) {
	  case "assets":
	  echo "<option selected value=assets>Assets</option>";
      echo "<option value=consumabili>Consumabili</option>";
      echo "<option value=spare_parts>Spare parts</option>";
	  break;
	  case "consumabili":
	  echo "<option value=assets>Assets</option>";
      echo "<option selected value=consumabili>Consumabili</option>";
      echo "<option value=spare_parts>Spare parts</option>";
	  break;
	  case "spare_parts":
	  echo "<option value=assets>Assets</option>";
      echo "<option value=consumabili>Consumabili</option>";
      echo "<option selected value=spare_parts>Spare parts</option>";
	  break;
	  }
*/	  ?>
      </select>
      </td>
    </tr>-->
   <tr>
      <td colspan="2"><div align="center">
        <input name="ingresso" type="hidden" id="ingresso" value="1">
        <input type="submit" name="button" id="button" value="Invia">
      </div></td>
    </tr>
  </table>
    </form>
</td>
    <td width="316" valign="top"><div align="center"><strong>INGRESSO ADMIN</strong><br>
        <form name="form1" method="post" action="index_admin.php">
                <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="122">Login</td>
          <td width="178"><input name="user_name" type="text" id="user_name" size="25"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input name="user_pass" type="password" id="user_pass" size="25"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="center">
            <input name="login_alternativo" type="hidden" id="login_alternativo" value="admin">
            <input type="submit" name="button2" id="button2" value="Invia">
          </div></td>
          </tr>
      </table>
</form>
    </div></td>
  </tr>
</table>
<br>
</body>
</html>