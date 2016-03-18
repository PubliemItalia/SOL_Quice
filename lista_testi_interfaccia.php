<?php
include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
include "testata.php";
include "functions.php";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

//lettura variabili
$add_testo=$_POST['add_testo'];
$modifica=$_POST['modifica'];
$elimina=$_POST['elimina'];
$id=$_POST['id'];
$testo_it = levapar3($_POST['testo_it']);
$testo_en = levapar3($_POST['testo_en']);
$testo_fr = levapar3($_POST['testo_fr']);
$testo_de = levapar3($_POST['testo_de']);
$testo_es = levapar3($_POST['testo_es']);
if (isset($_POST['posizione_nuova'])) {
$posizione = str_replace(" ","_",levapar3($_POST['posizione_nuova']));
} else {
$posizione = str_replace(" ","_",levapar3($_POST['posizione']));
}
$avviso = $_GET['avviso'];
//elimina testo
if ($elimina != "") {
$sql = "DELETE FROM testi_interfaccia WHERE id = '$id'";
$risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
}
//aggiunta testo
if ($add_testo != "") {
$queryz = "SELECT * FROM testi_interfaccia WHERE posizione = '$posizione'";
$resultz = mysql_query($queryz);
$righe_esistenti = mysql_num_rows($resultz);
if ($righe_esistenti >= 1) {
$avviso = "<span class=rosso_grassettosx>ATTENZIONE! STAI CERCANDO DI INSERIRE UN TESTO CHE ESISTE GIA'</span>";
} else {
$query = "INSERT INTO testi_interfaccia (posizione, pag, testo_it, testo_en, testo_fr, testo_de, testo_es) VALUES ('$posizione', '$pag', '$testo_it', '$testo_en', '$testo_fr', '$testo_de', '$testo_es')";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}
}
//modifica testo
if ($modifica != "") {
$query = "UPDATE testi_interfaccia SET posizione = '$posizione', pag = '$pag', testo_it = '$testo_it', testo_en = '$testo_en', testo_fr = '$testo_fr', testo_de = '$testo_de', testo_es = '$testo_es' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}
$sqlf = "SELECT DISTINCT posizione FROM testi_interfaccia ORDER BY posizione ASC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$blocco_posizioni_add .= "<option value=".$rigaf[posizione].">".$rigaf[posizione]."</option>"; 
}

?>
<html>
<head>
  <title>QUICE</title>
<link href="tabelle.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
a:link {
	color: #0000FF;
}
a:hover {
	color: #FF0000;
}
body {
	margin-left: 10px;
	margin-top: 0px;
}
-->
</style>
<!-- Script per campi obbligatori Form -->
<script language = "Javascript">
function controllo(){
with(document.aggiungi) {
	
<!--if(posizione.value=="" && nuova_posizione.value=="") {-->
<!--alert("Errore: compilare il campo POSIZIONE");-->
<!--posizione.focus();-->
<!--return false;-->
<!--}-->
}
return true
 }
</script>
<?php include "funzioni.js"; ?>
</head>
<br>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="575" valign="top" class=nero_grassettosx13>GESTIONE TESTI INTERFACCIA  </td>
    <td width="325" valign="top" class="sottotitoli"></td>
  </tr>
</table>
<?php echo $avviso; ?><br>
<span class="nero_grassettosx12">Aggiunta nuovo testo <br>
</span>
<table width="979" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<form name="aggiungi" method="post" action="lista_testi_interfaccia.php" onSubmit="return controllo();">
		<table width="967" border="0" cellspacing="0" cellpadding="0">
	    <tr bgcolor="#CCCCCC">
              <td valign="top" class=tabelle>Posizione</td>
		      <td width="124" valign="top" class=tabelle>Testo IT</td>
  			  <td width="124" valign="top" class=tabelle>Testo UK</td>
	          <td width="124" valign="top" class=tabelle>Testo FR</td>
              <td width="124" valign="top" class=tabelle>Testo DE</td>
              <td width="124" valign="top" class=tabelle>Testo ES</td>
            <td valign="top" class=tabelle>&nbsp;</td>
		  </tr>
  			<tr>
			  <td width="304" valign="top" class="tabelle">
<!--              <select name="posizione" class="tabelle" id="posizione">
                <?php //echo $blocco_posizioni_add; ?>
                </select>
                <br>
-->              <input name="posizione_nuova" type="text" class="tabelle" id="posizione_nuova" size="60"></td>
              <td valign="top" class="tabelle"><input name="testo_it" type="text" class="tabelle" id="testo_it" size="20"></td>
              <td valign="top" class="tabelle"><input name="testo_en" type="text" class="tabelle" id="testo_en" size="20"></td>
              <td valign="top" class="tabelle"><input name="testo_fr" type="text" class="tabelle" id="testo_fr" size="20"></td>
              <td valign="top" class="tabelle"><input name="testo_de" type="text" class="tabelle" id="testo_de" size="20"></td>
              <td valign="top" class="tabelle"><input name="testo_es" type="text" class="tabelle" id="testo_es" size="20"></td>
              <td width="43" valign="top" class="tabelle">
<input name="add_testo" type="hidden" id="add_testo" value="1">
<input name="submit" class="tabelle" type="image" value="Invia" src="immagini/button_add.gif"></td>
	    </tr></table>
	<br>
	</form></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td><img src=immagini/riga_400.jpg width=958 height=3></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="625" valign="top">
<span class="nero_grassettosx12">Testi gi&agrave; inseriti<br>
</span>
<table width=968 border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#CCCCCC">
              <td width="307" valign="top" class=tabelle>Posizione</td>
		      <td width="121" valign="top" class=tabelle>Testo IT</td>
		  <td width="125" valign="top" class=tabelle>Testo UK</td>
          <td width="124" valign="top" class=tabelle>Testo FR</td>
          <td width="126" valign="top" class=tabelle>Testo DE</td>
          <td width="119" valign="top" class=tabelle>Testo ES</td>
            <td width="22" valign="top" class=tabelle>&nbsp;</td>
          <td width="24" valign="top" class=tabelle>&nbsp;</td>
	    </tr>
  <?
$query = "SELECT * FROM testi_interfaccia ORDER BY posizione ASC";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
echo "<tr>";
echo "<form name=modifica method=post action=lista_testi_interfaccia.php>";
echo "<td valign=top class=tabelle>";
$sqlf = "SELECT * FROM testi_interfaccia ORDER BY posizione ASC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
if ($rigaf[posizione] == $row[posizione]) {
$blocco_posizioni .= "<option selected value=".$rigaf[posizione].">".$rigaf[posizione]."</option>"; 
} else {
$blocco_posizioni .= "<option value=".$rigaf[posizione].">".$rigaf[posizione]."</option>"; 
}
}
/*echo "<select name=posizione class=tabelle id=posizione>";
echo $blocco_posizioni;
echo "</select><br>";
*/echo "<input name=posizione_nuova type=text class=tabelle id=posizione_nuova size=60 value=".$row[posizione].">";
echo "</td>";
echo "<td valign=top class=tabelle><input name=testo_it type=text class=tabelle id=testo_it size=20 value=".$row[testo_it].">";
echo "</td>";
echo "<td valign=top class=tabelle><input name=testo_en type=text class=tabelle id=testo_en size=20 value=".$row[testo_en].">";
echo "</td>";
echo "<td valign=top class=tabelle><input name=testo_fr type=text class=tabelle id=testo_fr size=20 value=".$row[testo_fr].">";
echo "</td>";
echo "<td valign=top class=tabelle><input name=testo_de type=text class=tabelle id=testo_de size=20 value=".$row[testo_de].">";
echo "</td>";
echo "<td valign=top class=tabelle><input name=testo_es type=text class=tabelle id=testo_es size=20 value=".$row[testo_es].">";
echo "</td>";
echo "<td valign=top class=tabelle>";
echo "<input name=id type=hidden id=id value=".$row[id].">";
echo "<input name=modifica type=hidden id=modifica value=1>";
echo "<input name=submit class=tabelle type=image value=Invia src=immagini/button_mod.gif>";
echo "</td></form>";
echo "<form name=cancella method=post action=alert_elimina_testi_interfaccia.php>";
echo "<td valign=top class=tabelle>";
echo "<input name=id type=hidden id=id value=".$row[id].">";
echo "<input name=submit class=tabelle type=image value=Invia src=immagini/button_elimina.gif>";
echo "</td></form>";
echo "</tr>"; 
echo "<tr><td colspan=8><img src=immagini/riga_400.jpg width=958 height=1></td></tr>";
$blocco_posizioni = "";
}
?>
    </table></td>
    <td width="10" valign="top">&nbsp;</td>
  </tr>
</table>
</html>
