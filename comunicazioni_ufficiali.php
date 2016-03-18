<?php
$invio_messaggio = $_POST[invio_messaggio];
$indirizzo_princ = $_POST[indirizzo_princ];
$indirizzo_secondario = $_POST[indirizzo_secondario];
$oggetto = str_replace("è","e'",$_POST[oggetto]);
$oggetto = str_replace("é","e'",$oggetto);
$oggetto = str_replace("à","a'",$oggetto);
$oggetto = str_replace("ò","o'",$oggetto);
$oggetto = str_replace("ù","u'",$oggetto);
$oggetto = str_replace("ì","i'",$oggetto);

$messaggio = str_replace("è","e'",$_POST[messaggio]);
$messaggio = str_replace("é","e'",$messaggio);
$messaggio = str_replace("à","a'",$messaggio);
$messaggio = str_replace("ò","o'",$messaggio);
$messaggio = str_replace("ù","u'",$messaggio);
$messaggio = str_replace("ì","i'",$messaggio);
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

if ($invio_messaggio == "1") {
		$pos = strpos($indirizzo_princ,";");
	if ($pos == true) {
	$array_dest_princ = explode(";",$indirizzo_princ);
	} else {
	$mail_destinatario = $indirizzo_princ;
	}
		$pos_sec = strpos($indirizzo_secondario,";");
	if ($pos_sec == true) {
	$array_dest_sec = explode(";",$indirizzo_secondario);
	} else {
	$mail_conoscenza = $indirizzo_secondario;
	}

include "spedizione_mail_com_uff.php";
echo "<div>";
echo $esito;
echo "</div>";
}
?>
<html>
    <head>
      <meta charset="utf-8">
      
      
      <link rel="stylesheet" href="css/craftyslide.css" />
    </head>

<body>
    <div>
<span style="font-family:arial; font-size:18px; font-weight:bold;">Invio comunicazioni ufficiali Qui C&acute;&egrave;</span><br>
<br>
<form id="form1" name="form1" method="post" action="comunicazioni_ufficiali.php">
  <table style="font-family:arial; font-size:12px;" width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="198" valign="top">Destinatari principali<br>(Per indirizzi multipli intervallare <br>
        con un ";")</td>
      <td width="378" valign="top"><textarea name="indirizzo_princ" cols="45" rows="5" id="indirizzo_princ"></textarea></td>
      <td width="24" valign="top"></td>
    </tr>
    <tr>
      <td valign="top">Destinatari copia conoscenza<br>(Per indirizzi multipli intervallare <br>
        con un ";")</td>
      <td valign="top"><textarea name="indirizzo_secondario" cols="45" rows="5" id="indirizzo_secondario"></textarea></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td height="34" valign="top">Oggetto</td>
        <td valign="top"><input name="oggetto" type="text" id="oggetto" size="45"></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">Testo messaggio</td>
      <td valign="top"><textarea name="messaggio" cols="45" rows="5" id="messaggio"></textarea></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Invia">
      <input name="invio_messaggio" type="hidden" id="invio_messaggio" value="1"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</div>
</body>
    </html>