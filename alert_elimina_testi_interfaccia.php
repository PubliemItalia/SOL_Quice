<?
include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione","agente");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
echo "<br><span class=titoli>Messaggio Eliminazione Testo</span><br><br>";
$id = $_POST['id'];
include "query.php";
$sqlddd = "SELECT * FROM qui_testi_interfaccia WHERE id = '$id'";
$risultddd = mysql_query($sqlddd) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaddd = mysql_fetch_array($risultddd)) {
$posizione = $rigaddd[posizione];
}
?>
<html>
<head>
  <title>Eliminazione testo</title>
  <link href="tabelle.css" rel="stylesheet" type="text/css">
</head>
<table width="400" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="ecoform14ctcentro">Sei proprio sicuro di voler eliminare il testo della posizione<br>
      <strong><?php echo $posizione; ?></strong> in tutte le lingue?</td>
  </tr>
  <tr>
    <td width="198">&nbsp;</td>
    <td width="200">&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="lista_testi_interfaccia.php">
      <div align="center">
        <input name="elimina" type="hidden" id="elimina" value="1">
        <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
        <input type="submit" name="Submit" value="SI">
      </div>
    </form>
    </td>
    <td><form name="form2" method="post" action="lista_testi_interfaccia.php">
      <div align="center">
        <input name="Submit" type="submit" id="Submit" value="NO">
      </div>
    </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>