  <form action="<?php echo $azione_form; ?>" method="get" name="form1">
<table width="960" border="0">
  <tr valign="top"> 
    <td width="276"><table width="172" align="center">
      <tr class="tabellecentro">
        <td class="ecoform"><div align="center"><?php echo $testata_nazione; ?></div></td>
      </tr>
      <tr>
        <td><div align="center" class="tabellecentro">
            <input name="nazione_ric" type="text" id="nazione_ric" value="<?php echo $_SESSION['nazione_ric']; ?>" size="12">
        </div></td>
      </tr>
    </table></td>
    <td width="258"><table width="172" align="center">
          
          <tr class="tabellecentro"> 
            <td class="ecoform"><div align="center"><?php echo $testata_descrizione; ?></div></td>
          </tr>
          <tr> 
            <td><div align="center" class="tabellecentro">
              <input name="descrizione" type="text" id="descrizione" value="<?php echo $_SESSION['descrizione']; ?>" size="12">
            </div></td>
          </tr>
        </table></td>
    <td width="70">&nbsp;</td>
<td width="200"><table width="172" align="center">
          
          <tr class="tabellecentro"> 
            <td class="ecoform"><div align="center"><?php echo $testata_codice; ?></div></td>
          </tr>
          <tr> 
            <td><div align="center" class="tabellecentro">
              <input name="codice" type="text" id="codice" value="<?php echo $_SESSION['codice']; ?>" size="12">
            </div></td>
          </tr>
          
      </table></td>
    <td width="134">&nbsp;</td>
  </tr>
  <tr valign="top">
    <td colspan="5"><div align="center">
      <input name="criterio" type="hidden" value="1">
      <input name="limit" type="hidden" value="<?php echo $limit; ?>">
      <input name="negozio" type="hidden" id="negozio" value="<?php echo $_SESSION[negozio]; ?>">
      <input name="categoria" type="hidden" id="categoria" value="<?php echo $_SESSION[categoria]; ?>">
      <input name="page" type="hidden" value="1">
      <input name="cerca_cliente" type="submit" id="cerca_cliente" value="<?php echo $pulsante_trova; ?>">
    <input type="button" value="<?php echo $pulsante_reset_filtri; ?>" onClick="location.href='preventivi.php?a=1';"></div></td>
    </tr>
</table>
</form>
