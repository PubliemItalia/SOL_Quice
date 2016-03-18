<?php
/*
include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione","agente");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
*/
echo "<br><span class=titoli>Messaggio Eliminazione Agenzia</span><br><br>";
$id = $_POST['id_agente'];
if ($_POST['rifiuto'] == 1) {
$pag_precedente = "lista_agenti.php";
include "redir_neutro.php";
}
include "query.php";
$sqlddd = "SELECT * FROM ".$prefix."agenti WHERE id = '$id'";
$risultddd = mysql_query($sqlddd) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaddd = mysql_fetch_array($risultddd)) {
$agente = $rigaddd[agente];
}
?>
<html>
<head>
  <title>Geoflow - Eliminazione agente</title>
  <link href="tabelle.css" rel="stylesheet" type="text/css">
</head>
<table width="400" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="ecoform14ctcentro">Sei proprio sicuro di voler eliminare l&rsquo;Agente<br>
      <strong><?php echo $agente; ?>?</strong></td>
  </tr>
  <tr>
    <td width="198">&nbsp;</td>
    <td width="200">&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="lista_agenti.php">
      <div align="center">
        <input name="eliminazione" type="hidden" id="eliminazione" value="1">
        <input name="id_agente" type="hidden" id="id_agente" value="<?php echo $id; ?>">
        <input type="submit" name="Submit" value="SI">
      </div>
    </form>
    </td>
    <td><form name="form2" method="post" action="alert_elimina_agente.php">
      <div align="center">
        <input name="rifiuto" type="hidden" id="rifiuto" value="1">
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