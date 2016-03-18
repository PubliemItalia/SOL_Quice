<div class="container">
  <div class="contenitore_filo">
    <div class="colonna">
    <?php
	$array_esclusioni_stampa = array("Simbolo_pacco_bombole");
	$array_esclusioni_stampe_publiem = array("120_Fogli_illustrativi","121_Fogli_illustrativi");
	   if ($negozio == "labels") {
	   if (in_array($categoria3,$array_esclusioni_stampe_publiem)) {
	} else {
	   if (!in_array($categoria4,$array_esclusioni_stampa)) {
      echo "<div class=titolo_colonna>".$titolino1."</div>
       <div class=colonnino_interno_testata>".$dic_quant."</div>
       <div class=colonnino_interno_testata style=\"margin-left:10px; background-color:white;\">".$dic_prezzo."</div>
      <div class=colonnino_interno_riga_dispari style=\"padding-left:0px; margin-top:10px;\">
      <input name=quant_publiem type=text id=quant_publiem style=\"width:100px; height:15px;font-size:10px;\" maxlength=4 onkeypress = \"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant2(this.value,'0','Mod_laser')\">
	</div>";
echo "<div style=\"width:240px; margin-top:10px; float:left; font-size:12px;\">".$dida;

echo "</div>";
	  }
	}
	   }

	?>
   
    <div id="avviso_rosso" class="colonnino_interno_riga_dispari" style="margin-top:10px; color:red; font-weight:normal; height:auto; width:200px;">
	</div>
    <div class="colonnino_interno_riga_dispari" style="margin-left:10px;">
	<?php //echo number_format($prezzo_unitario_laser,2,",","."); ?>
	</div>

   </div>
    <div id="spaziatore" class="colonna" style="width:40px; height:380px;">
    </div>
    <div class="colonna">
      <div class="titolo_colonna" style="float:right;">
      <?php
	  if (($categoria3 == "120_Fogli_illustrativi") OR (in_array($categoria4,$array_esclusioni_stampa))) {
		  echo $titolino_blister;
	  } else {
	   if (in_array($categoria3,$array_esclusioni_stampe_publiem)) {
		  echo $titolino3;
	  } else {
		  echo $titolino2;
	  }
	  }
	  ?>
        
        
      </div>
       <div class="colonnino_interno_testata">
        <?php echo $dic_quant; ?>
      </div>
       <div class="colonnino_interno_testata" style="margin-left:10px;">
        <?php echo $dic_prezzo; ?>
      </div>
<?php
		$contatore = 1;
		$contarighe = 0;
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	if ($contatore == 2) {
		$divclass = "colonnino_interno_riga_pari";
		$contatore = 1;
	} else {
		$divclass = "colonnino_interno_riga_dispari";
		$contatore = $contatore + 1;
	}
    echo "<div class=riga_generale>";
	  echo "<div class=".$divclass.">";
		echo "<div class=cifra_trasp>";
		echo $rigag[quant];
		echo "</div>";
		echo "<div class=pallino style=\"padding:0px\">";
		echo "<input style=\"font-size:10px\" type=radio name=quant value=".$rigag[quant]." id=quant_".$contarighe." onClick=\"aggiorna_quant(".$rigag[id].",1)\">";
		echo "</div>";
	  echo "</div>";
	  echo "<div class=".$divclass." style=\"margin-left:10px; padding-bottom:4px\">";
	  echo number_format($rigag[prezzo],2,",",".");
	  echo "</div>";
	echo "</div>";
		$contarighe = $contarighe + 1;
}
    echo "<div class=riga_generale style=\"margin-top:10px;\">";
	  echo "<div class=colonnino_interno_riga_dispari>";
		echo "<div class=cifra_trasp>";
		echo $rigag[quant];
		echo "</div>";
		echo "<div class=pallino style=\"padding:0px\">";
	   if ($categoria3 == "Documentazione_pharma") {
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant3(this.value,'3','".trim($tipologia)."')\" style=\"width:100px; height:15px;font-size:10px;\">";
		} else {
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant3(this.value,'2','".trim($tipologia)."')\" style=\"width:100px; height:15px;font-size:10px;\">";
		}
		echo "</div>";
	  echo "</div>";
	  echo "<div id=prezzo_calcolato class=colonnino_interno_riga_dispari style=\"margin-left:10px; margin-top:10px;\">";
	  echo $dic_altre_quant;
	  echo "</div>";
	echo "</div>";



/*	echo "<div style=\"width:250px; height:auto; margin-top:10px; float:left;\">";
    echo "<div class=colonnino_interno_riga_dispari style=\"padding-left:0px; margin-right:30px; width:100px;\">";
	echo "<div class=cifra_trasp style=\"padding-left:0px; width:112px;\">";
	echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant3(this.value,'2','".$tipologia."')\" style=\"width:100px; height:15px;font-size:10px;\">";
	echo "</div>";
	//echo "<div class=pallino style=\"padding:0px;\">";
	//echo "<input style=\"font-size:10px\" type=radio name=quant value=".$rigag[quant]." id=quant_".$contarighe."\">";
	//echo "</div>";
	echo "</div>";
    echo "<div id=prezzo_calcolato class=".$divclass_dic." style=\"padding:0px; width:90px; float:left;\">";
	echo $dic_altre_quant;
	echo "</div>";
	echo "</div>";
*/
   echo "<div id=quant_nasc style=\"width:150px; hight:30px;\">";
   echo "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";
   echo "<input type=hidden name=blocco id=blocco value=1>";
	echo "</div>";
	

      
?>
    </div>
  </div>
  <div class="contenitore_filo" style="border:none;">
     <div class="colonna" style="height:50px; min-height:40px; float:left;">
      <div class="titolo_colonna" style="height:25px">
     <?php echo $descrizione_art; ?>
  </div>
      <div id="risultati" class="titolo_colonna" style="height:15px">
     <div class="colonnino_interno_riga_dispari">
        <?php echo $dic_quant; ?>
  </div>
     <div class="colonnino_interno_riga_dispari" style="float:none; width:200px;">
        <?php echo $dic_prezzo; ?> EUR 
  </div>
  </div>
   </div>
   <div class="colonna" style="width:40px; height:50px; min-height:40px">
    </div> 
    <div class="colonna" style="height:50px; min-height:40px; padding-top:20px;">
    <?php
				switch ($lingua) {
					case "it":
					$puls_carr = "Inserisci nel carrello";
					break;
					case "en":
					$puls_carr = "Add to cart";
					break;
					}
					?>
    <input type="submit" name="submit" class=pulsante_carrello style="margin-left:90px; height:30px; cursor:pointer;" id="submit" value="<?php echo $puls_carr; ?>">
    <div id="deposito_id">
      <input type="hidden" name="id_prod" id="id_prod" value="<?php echo $id_prod; ?>">
      <input type="hidden" name="negozio" id="negozio" value="<?php echo $negozio; ?>">
      <div id="tip_dep">
        <input type="hidden" name="tipologia" id="tipologia" value="<?php echo $tipologia; ?>">
      </div>
    </div>
    </div>
    </div>
   </div> 
