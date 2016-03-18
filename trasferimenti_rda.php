<?php
$id_rda = $_POST[id_rda];
$richiesta = $_POST[richiesta];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
if ($richiesta != "") {
$dati_rda = "";  
  // Fetch Record from Database
$sql = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
$risult = mysql_query($sql);
while ($row = mysql_fetch_array($risult)) {
	$sqla = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_utente]'";
	$risulta = mysql_query($sqla);
	while ($rowa = mysql_fetch_array($risulta)) {
		$indirizzo = $rowa[companyName]." - ".$rowa[indirizzo]." - ".$rowa[cap]." - ".$rowa[localita]." - ".$rowa[nazione];
		$utente = $rowa[nome];
		$mail = $rowa[posta];
	}
	  $dati_rda .= "|".$row[negozio]."|;|".$indirizzo."|;|".$row[categoria]."|;";
	  $dati_rda .= "|".$row[id_utente]."|;|".$row[id_resp]."|;|".$utente."|;|".$mail."|;|".$row[codice_art]."|;|".$row[descrizione]."|;";
	  $dati_rda .= "|".$row[confezione]."|;|".$row[quant]."|;|".$row[prezzo]."|;|".$row[totale]."|;|".$row[data_inserimento]."|;";
	  $dati_rda .= "|".$row[gruppo_merci]."|;|".$row[nazione]."|;".$id_rda."|;".$row[id]."|;";
	  $dati_rda .= "||";
		$indirizzo = "";
		$utente = "";
		$mail = "";
  }
  $completato = "1";
}
?>
<html>
    <head>
      <meta charset="utf-8">
      
      
    </head>

<body>
    <div>
<span style="font-family:arial; font-size:18px; font-weight:bold;">Recupero Informazioni RdA</span><br>
<br>
<form id="form1" name="form1" method="post" action="trasferimenti_rda.php">
  <table style="font-family:arial; font-size:12px;" width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="198" height="34" valign="top">Oggetto</td>
      <td width="378" valign="top"><input name="id_rda" type="text" id="id_rda" size="10"></td>
      <td width="24" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Invia">
        <input name="richiesta" type="hidden" id="richiesta" value="1"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</div>
    <div>
<?php
if ($completato == "1") {
echo "<form id=form1 name=form1 method=post action=\"http://www.publiem.eu/gestione/arrivo.php\">";
	echo "<input type=submit name=submit id=submit value=\"Carica dati\"><br><br>RdA ".$id_rda;
        echo "<input name=dati_rda type=hidden id=dati_rda value=\"".$dati_rda."\">";
        echo "<input name=inserimento_rda type=hidden id=inserimento_rda value=1>";
echo "</form>";
  //echo "dati_rda: ".$dati_rda."<br>";
	}
?>
</div>
</body>
    </html>