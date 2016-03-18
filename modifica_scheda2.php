  <div style="width:auto; height:auto; ">
    <!--PRIMA RIGA CON PREZZO E CONFEZIONE EDITABILI -->
    <div class="stripN">
      <div class="colonna" style="width:246px; height:auto; padding:0px; margin-right:40px;" >
        <div class="area_norm" id="cont_prezzo">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:10px 10px 0px 10px;">
            Prezzo
          </div>
          <div class="diciture_pag_modifica" style="float: right; width: auto; margin:5px 5px 0px 0px;">
            <input name="prezzo" type="text" id="prezzo" class="campo_norm" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_prezzo','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_prezzo','area_selez','area_norm')" onkeypress = "return ctrl_decimali(event)" value="<?php echo $prezzo; ?>"  onkeyup="sostituisci('valore_prezzo',this.value);">
          </div>
        </div>
        <div class="area_norm" id="cont_confez">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:10px 10px 0px 10px;">
            Confezione
          </div>
          <div class="diciture_pag_modifica" style="float: right; width: auto; margin:5px 5px 0px 0px;">
        <input name="confezione" type="text" id="confezione" class="campo_norm" value="<?php echo $confezione; ?>" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_confez','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_confez','area_selez','area_norm')" onkeyup="sostituisci('valore_confezione',this.value);">
          </div>
        </div>
        <div class="area_norm" id="cont_posiz">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:3px 10px 0px 10px;">
            Posizione<br />nell'elenco
          </div>
          <div class="diciture_pag_modifica" style="float: right; width: auto; margin:5px 5px 0px 0px;">
    <select name="precedenza_int" id="precedenza_int" class="campo_norm" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_posiz','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_posiz','area_selez','area_norm')">
    <option selected value="">Nessuna</option>";
    <?php
        for($a = 0; $a <= 30; $a++) {
    if ($a == $precedenza_int) {
	  echo "<option selected value=".$a.">".$a."</option>";
	} else {
	  echo "<option value=".$a.">".$a."</option>";
	}
	}
    ?>
    </select>
        </div>
        </div>
      </div><!--END colonna-->
       <div class="colonna" style="width:420px; height:174px; margin-right:40px; background-color:#fff; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; border: 1px solid #e6e6e6;">
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 20px;">
           Immagini
        </div>
        <div id="upload_image" style="width:370px; float:none; height:65px; background-image:url(immagini/sfondo_icona_immagine.png); background-repeat:no-repeat;">
        <div id="input_immagine" class="etichetta" style="float:left; width:60px; height:30px;">
           <input name="immagine_princ" type="hidden" id="immagine_princ" value="<?php echo $foto; ?>">
           <?php
		   if ($foto != "") {
              echo "<img src=files/".$foto." width=30 height=30>";
		   }
		   ?>
        </div>
		<?php
        echo '<div id=image_gallery style="width:300px; height:35px; float:left;">';
          $sqlp = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
          $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
          $num_image_gallery = mysql_num_rows($risultp);
          if ($num_image_gallery > 0) {
            while ($rigap = mysql_fetch_array($risultp)) {
              echo "<img src=files/gallery/".$rigap[immagine]." width=30 height=30>";
              echo "<img src=immagini/spacer.gif width=10 height=30>";
              $categoria1_it = $rigap[categoria1_it];
            }
          } else {
            echo "<img src=immagini/spacer.gif width=30 height=30>";
          }
        echo "</div>";
        ?>
        </div>
          <div class="bottone_carica-cambia" onClick="TINY.box.show({iframe:'gestione_gallery.php?id_prod=<?php echo $id; ?>&negozio_prod=<?php echo $negozio; ?>&mode=<?php echo $mode; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:600,height:600,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS2()}});">Carica/cambia</div>

      </div><!--END colonna-->
       <div class="colonna" style="width:210px; height:174px; background-color:#fff; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; border: 1px solid #e6e6e6;">
        <div class="diciture_pag_modifica" style="float:none; width:80%; height: 30px; margin:15px 0px 0px 20px;">
           Scheda tecnica
        </div>
        <div style="float:none; width:160px; height:65px; background-image:url(immagini/sfondo_icona_pagina.png); background-repeat:no-repeat;">
		<?php
		  if ($scheda_tecnica != "") {
			echo substr($scheda_tecnica,0,20);
		  } else {
			echo "Scheda tecnica mancante";
		  }
		  ?>
        </div>
          <div class="bottone_carica-cambia" onClick="TINY.box.show({iframe:'gestione_scheda_tecnica.php?mode=mod&id_prod=<?php echo $id; ?>&negozio_prod=<?php echo $negozio; ?>',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS3(0)}});">Carica/cambia</div>
        </div>
      </div><!--END colonna-->
    </div><!--END stripN-->
    <!--END PRIMA RIGA CON PREZZO E CONFEZIONE EDITABILI, IMMAGINI GESTIBILI -->
    <!--SECONDA RIGA CON CODICE EDITABILE, E BAR CODE (PREDISPOSIZIONE) -->
    <div class="stripN">
      <div class="colonna" style="width:246px; height:110px; padding:0px; margin-right:40px;" >
        <div class="area_norm" id="cont_cod_qc">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:10px 10px 0px 10px;">
            Cod. Qui C'è
          </div>
          <div class="diciture_pag_modifica" style="float: right; width: auto; margin:5px 5px 0px 0px;">
            <input name="codice_quice" type="text" id="codice_quice" class="campo_norm" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_cod_qc','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_cod_qc','area_selez','area_norm')" onkeypress = "return ctrl_decimali(event)" value="<?php
			if (substr($codice_art,0,1) != "*") {
		  echo $codice_art;
		} else {
		  echo substr($codice_art,1);
		}?>"  onkeyup="sostituisci('valore_prezzo',this.value);">
          </div>
        </div>
        <div class="area_norm" id="cont_gestione">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:10px 10px 0px 10px;">
            Azienda
          </div>
          
          <div class="diciture_pag_modifica elementi_grandi_csottili" style="width:auto;height:auto;">
            <img src="immagini/bottone-vivisol_big.png">
          </div>
           <div id="check_viv" class="caselle <?php
           if ($azienda == "VIVISOL") {
			   echo "caselle_spuntate";
		   } else {
			   echo "caselle_vuote";
		   }
		   ?>" onclick="solviv(this.id)">
          </div>
         <div class="diciture_pag_modifica elementi_grandi_csottili" style="width:auto;height:auto;">
            <img src="immagini/bottone-sol_big.png">
          </div>
           <div id="check_sol" class="caselle <?php
           if ($azienda == "SOL") {
			   echo "caselle_spuntate";
		   } else {
			   echo "caselle_vuote";
		   }
		   ?>" onclick="solviv(this.id)">
          </div>
           <input name="azienda" type="hidden" id="azienda" value="<?php echo $azienda; ?>">
        </div>
      </div><!--END colonna-->
       <div class="colonna" style="width:420px; height:110px; margin-right:40px;">
         <div class="area_norm" id="cont_cod_prod_it">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:10px 10px 0px 10px;">
            Cod. prodotto (IT)
          </div>
          <div class="diciture_pag_modifica" style="float: right; width: auto; margin:5px 5px 0px 0px;">
        <input name="codice_prodotto" type="text" id="codice_prodotto" class="campo_norm" style="width:250px;" value="<?php
		  echo $categoria4_it;
		 ?>" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_cod_prod_it','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_cod_prod_it','area_selez','area_norm')" onkeyup="sostituisci('valore_confezione',this.value);">
          </div>
        </div>
         <div class="area_norm" id="cont_cod_prod_en">
          <div class="diciture_pag_modifica" style="float:none; width:auto; float:left; height: auto; margin:10px 10px 0px 10px;">
            Cod. prodotto (EN)
          </div>
          <div class="diciture_pag_modifica" style="float: right; width: auto; margin:5px 5px 0px 0px;">
        <input name="codice_prodotto" type="text" id="codice_prodotto" class="campo_norm" style="width:250px;" value="<?php
		  echo $categoria4_en;
		 ?>" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_cod_prod_en','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_cod_prod_en','area_selez','area_norm')" onkeyup="sostituisci('valore_confezione',this.value);">
          </div>
        </div>
      </div><!--END colonna-->
       <div class="colonna" style="width:210px; height:110px;">
      </div><!--END colonna-->
    </div><!--END stripN -->
    <!--END SECONDA RIGA CON CODICI E GESTIONE AZIENDA -->
    <!--TERZA RIGA CON DESCRIZIONI -->
    <div class="stripN">
      <div class="colonna" style="width:460px; height:218px; padding:0px; margin-right:40px;" >
        <div class="area_norm" style="min-height: 100px; height:auto; overflow:hidden;" id="cont_desc_breve">
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 20px;">
           Descrizione breve IT (max 40 caratteri)
        </div>
          <div class="diciture_pag_modifica" style="float: none; width: 430; margin:0px 0px 20px 20px;">
           <textarea name="descrizione1_it" style="background-color:transparent; width:420px; height:50px; text-align:left; font-family:Arial; font-size:12px;" class="campo_norm" id="descrizione1_it" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_desc_breve','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_desc_breve','area_selez','area_norm')"><?php echo $descrizione1_it; ?></textarea>
          </div>
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 20px;">
           Descrizione breve EN (max 40 caratteri)
        </div>
          <div class="diciture_pag_modifica" style="float: none; width: 430; margin:0px 0px 20px 20px;">
           <textarea name="descrizione1_en" style="background-color:transparent; width:420px; height:50px; text-align:left; font-family:Arial; font-size:12px;" class="campo_norm" id="descrizione1_en" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_desc_breve','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_desc_breve','area_selez','area_norm')"><?php echo $descrizione1_en; ?></textarea>
          </div>
        </div>
      </div><!--END colonna-->
       <div class="colonna" style="width:460px; height:218px;">
        <div class="area_norm" style="min-height: 100px; height:auto; overflow:hidden;" id="cont_desc_dett">
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 20px;">
           Descrizione dettagliata IT
        </div>
          <div class="diciture_pag_modifica" style="float: none; width: 430; margin:0px 0px 20px 20px;">
           <textarea name="descrizione2_it" style="background-color:transparent; width:420px; height:50px; text-align:left; font-family:Arial; font-size:12px;" class="campo_norm" id="descrizione2_it" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_desc_dett','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_desc_dett','area_selez','area_norm')" onkeyup="sostituisci('anteprima_descrizione',this.value);"><?php echo $descrizione2_it; ?></textarea>
          </div>
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 20px;">
           Descrizione dettagliata EN 
        </div>
          <div class="diciture_pag_modifica" style="float: none; width: 430; margin:0px 0px 20px 20px;">
           <textarea name="descrizione2_en" style="background-color:transparent; width:420px; height:50px; text-align:left; font-family:Arial; font-size:12px;" class="campo_norm" id="descrizione2_en" onfocus="evidenz(this.id,'campo_evid','campo_norm','cont_desc_dett','area_selez','area_norm')" onblur="deselect(this.id,'campo_evid','campo_norm','cont_desc_dett','area_selez','area_norm')"><?php echo $descrizione2_en; ?></textarea>
          </div>
        </div>
      </div><!--END colonna-->
    </div><!--END stripN -->

    <!--QUARTA RIGA CON CAMPIONE SCHEDA PER ANTEPRIMA -->
    <div class="stripN">
       <div class="colonna" style="width:960px; height:auto; background-color:#fff;	-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;">
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 20px;">
          Anteprima scheda
        </div>
    	<div id=riquadro_prodotto style="background-color:#FFF; height:280px; margin-bottom:15px; box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5);
-webkit-box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5);
-moz-box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5);
-o-box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5);">
		  <div id="raggruppamento" class="raggruppo">
		  <div id="componente_descrizione">
		  <div class="Titolo_famiglia" style="width:320px;">
		  <?php
		  if ($negozio == "labels") {
			echo str_replace("_"," ",substr($categoria3_it,4));
		  } else {
			echo str_replace("_"," ",$categoria3_it);
		  }
			?>
		  </div>
		  <div id="anteprima_descrizione" class="descr_famiglia">
		  <?php
			echo stripslashes($descrizione2_it);
			?>
		  </div>
		  <div id="variante" class="Titolo_famiglia" style="width:320px;">
		  <?php
		  if ($categoria4_it != "0") {
			echo stripslashes(str_replace("_"," ",$categoria4_it));
		  }
			?>
		  </div>
		  </div>
		  <div id="componente_dati">
		  <div class="Titolo_famiglia" style="width:130px;"></div> 
		  <div class="scritte_bottoncini">Codice</div> 
			  <div id="valore_codice" class="bottoncini" style="width:65px;">
		  <?php
if (substr($codice_art,0,1) != "*") {
  echo $codice_art;
} else {
  echo substr($codice_art,1);
}
			?>
			  </div>
		  <div class="scritte_bottoncini">Prezzo</div> 
		<div id="valore_prezzo" class="bottoncini" style="width:65px;">
		  <?php
			echo $prezzo;
			?>
		</div>
		  <div class="scritte_bottoncini">Confezione</div>
		  <div id="valore_confezione" class="bottoncini" style="width:65px;">
		  <?php
			echo $confezione;
			?>
		  </div>
		  </div>
		  
		  <div id=componente_iconcine>
		  </div>
		  </div>
		  
		  <div id="componente_immagine" style="padding-top:20px;">
			<img src="files/<?php echo $foto; ?>" width=248 height=248>
		  </div>
		  <!--componente bottoni-->
		  <div id=componente_bottoni>
		  <div class=comandi>
		  </div> 
			<div class="comandi" id="valore_gallery">
		  <!--operazioni di costruzione della gallery-->
				<!--<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]>-->
                <!--<span class=pulsante_galleria>-->
				<?php 
			  $nome_gruppo = mt_rand(1000,9999);
			$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
			$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			$num_img = mysql_num_rows($risultz);
			if ($num_img > 0) {
			  $a = 1;
			  while ($rigaz = mysql_fetch_array($risultz)) {
				if ($a == 1) {
				  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>Galleria fotografica</span></a> ";
				} else {
				  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]></a> ";
				}
				$a = $a + 1;
			  }
			}
				?>
                <!--</span>-->
                <!--</a>-->
		  <!--fine  costruzione gallery-->
		  </div>
			<!--<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>-->
			<div class="comandi" id="valore_scheda_tecnica">
            <?php
			if ($scheda_tecnica != "") {
			  //echo "<a href=documenti/".$scheda_tecnica." target=_blank>";
			  echo "<span class=pulsante_scheda>Scheda tecnica</span>";
			  //echo "</a>";
			}
			?>
			</div>
            <!--</a>--> 
			<div class=comandi_spazio>
			</div>
			  <!--<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">-->
		<div class=comandi>
			  <span class=pulsante_preferiti>
				Aggiungi ai preferiti
			  </span>
		</div> 
		<!--</a>-->
		<!--<a href="javascript:void(0);" onclick="MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')">-->
		<div class=comandi>
		<span class=pulsante_stampa>
		  Stampa
		</span>
		</div>
		<!--</a>-->
		<div class=comandi_spazio>
		</div> 
		<div class=comandi>
		<!--$modulo = "popup_modifica_scheda.php";
		<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua.">-->
        <span class=pulsante_admin>
        Admin
        </span>
        <!--</a>-->
		</div> 	
		<div class=spazio_puls_carrello>
		</div> 
		  <!--<a href="javascript:void(0);" onclick="TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">-->
          <div class=pulsante_carrello title="Scegli quantit&agrave;">
		  Scegli quantit&agrave;
		  </div>
          <!--</a>-->
		<!--fine div componente_bottoni-->
		</div> 
		<!--fine div riquadro_prodotto-->
		</div>
      </div>
    </div><!--END stripN -->
    <!--QUINTA RIGA CON STATISTICHE VENDITE -->
    <div class="stripN" style="margin-bottom: 20px; padding-bottom: 20px;">
		<?php 
			$sqlr = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$codice_art' ORDER BY precedenza ASC";
			$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigar = mysql_fetch_array($risultr)) {
				  $giacenza = $rigar[giacenza];
			  }
			$venduti = 0;
			$contatore_storico = 1;
			$blocco_righe_rda .= '<div style="padding-top: 3px; border-bottom: 1px solid rgb(0,0,0); float: left; width: 90px; height: 20px; font-weight:bold; margin-top:10px; text-align:left;">RdA</div>';
			$blocco_righe_rda .= '<div style="padding-top: 3px; border-bottom: 1px solid rgb(0,0,0); float: left; width: 110px; height: 20px; font-weight:bold; margin-top:10px;">Data</div>';
			$blocco_righe_rda .= '<div style="padding-top: 3px; border-bottom: 1px solid rgb(0,0,0); float: left; width: 160px; height: 20px; font-weight:bold; margin-top:10px;">Unit&agrave;</div>';
			$blocco_righe_rda .= '<div style="padding-top: 3px; border-bottom: 1px solid rgb(0,0,0); float: left; width: 110px; height: 20px; font-weight:bold; margin-top:10px; text-align:center;">Quant</div>';
			$blocco_righe_rda .= '<div style="padding-top: 3px; border-bottom: 1px solid rgb(0,0,0); float: left; width: 130px; height: 20px; font-weight:bold; margin-top:10px;text-align:center;">Valore</div>';
			$sqlk = "SELECT * FROM qui_righe_rda WHERE negozio = '$negozio' AND codice_art = '$codice_art' AND stato_ordine = '4'";
			$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigak = mysql_fetch_array($risultk)) {
				  $venduti = $venduti + $rigak[quant];
			  }
			  $sqls = "SELECT * FROM qui_righe_rda WHERE negozio = '$negozio' AND codice_art = '$codice_art' ORDER BY data_inserimento DESC";
			$risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigas = mysql_fetch_array($risults)) {
				  switch ($rigas[stato_ordine]) {
					  case "1":
					  $fondo = '#d9dadb';
					  break;
					  case "2":
					  $fondo = '#fdca00';
					  break;
					  case "3":
					  $fondo = '#009036';
					  break;
					  case "4":
					  $fondo = '#009ee0';
					  break;
				  }
				  if ($contatore_storico <=5) {
$blocco_righe_rda .= '<div style="width:auto; height:auto; float:left; background-color: '.$fondo.';">';
$blocco_righe_rda .= '<div style="padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; width:90px; height:20px; font-weight:normal; text-align:left;">'.$rigas[id_rda].'</div>';
$blocco_righe_rda .= '<div style="padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; width:110px; height:20px; font-weight:normal; text-align:center;">'.date("d.m.Y",$rigas[data_inserimento]).'</div>';
$blocco_righe_rda .= '<div style="padding-top:3px; border-bottom:1px solid rgb(0,0,0); float: left; width: 160px; height: 20px; font-weight:normal; text-align:center;">'.$rigas[nome_unita].'</div>';
$blocco_righe_rda .= '<div style="padding-top:3px; border-bottom:1px solid rgb(0,0,0); float: left; width: 110px; height: 20px; font-weight:normal; text-align:center;">'.intval($rigas[quant]).'</div>';
$blocco_righe_rda .= '<div style="padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; width:130px; height:20px; font-weight:normal; text-align:center;">'.number_format($rigas[totale],2,",",".").'</div>';
$blocco_righe_rda .= '</div>';
					  $contatore_storico = $contatore_storico + 1;
				  }
			  }
$blocco_righe_rda .= '<div style="width:auto; height:auto; float:left;">';
$blocco_righe_rda .= '<div style="padding-top:3px; float:left; width:50px; height:20px; font-weight:normal; text-align:left;"></div>';
$blocco_righe_rda .= '<div style="padding-top:3px; float:left; width:90px; height:20px; font-weight:normal; text-align:left;"></div>';
$blocco_righe_rda .= '<div style="padding-top:3px; float: left; width: 60px; height: 20px; font-weight:normal; text-align:left;"></div>';
$blocco_righe_rda .= '<div style="padding-top:3px; float: left; width: 70px; height: 20px; font-weight:normal; text-align:right;"></div>';
$blocco_righe_rda .= '<div style="padding-top:3px; float:left; width:90px; height:20px; font-weight:normal; text-align:right;"></div>';
$blocco_righe_rda .= '</div>';
			$ordinati = 0;
			$sqly = "SELECT * FROM qui_righe_rda WHERE negozio = '$negozio' AND codice_art = '$codice_art' AND (stato_ordine = '1' OR stato_ordine = '2')";
			$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigay = mysql_fetch_array($risulty)) {
				  $ordinati = $ordinati + $rigay[quant];
			  }
			  $totali = ($giacenza-$ordinati);
			  if ($totali > 0) {
			  $perc_ordinati = ($ordinati/$totali)*100;
			  }
			  if ($perc_ordinati >= 80) {
				  $dic_giacenza = "Giacenza (DA ORDINARE)";
			  } else {
				  $dic_giacenza = "Giacenza";
			  }
			  
		?>
        <div class="diciture_pag_modifica" style="background-color: #d4efff; float:none; width:auto; height: auto; margin:15px 0px 0px 0px; padding:7px 20px;">
          Gestione scorte magazzino
        </div>
       <div class="colonna" style="width:960px; height:auto; background-color:#fff;	-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;  margin-bottom:20px;">
        <div style=" float:left; margin:auto; width:958px; height:240px; font-family:Arial; font-size:11px; width:920px; margin:0px 0px 20px 20px;">
          <div id="colonna_carico" style="width: 260px; height: 60px; float: none;"> 
            <div style="width:70px; float:left; margin:10px 0px 0px 10px; text-align:left;">Quantit&agrave;<br />da caricare</div>
            <div style="width:70px; float:left; margin-top:10px;">
              <input name="caricare" type="text" id="caricare" class="campo_norm" onkeypress = "return ctrl_solo_num_neg(event)" value="">
            </div>
             <div class="bottone_carica-cambia" style="margin-top:10px; margin-left:20px; width:80px; float:left;" onClick="carico_magazzino();">Carica</div>
          </div>

            <div id="colonna_ordinati" style="width: 260px; height: auto; float: left; margin: 0px 40px 0px 10px;"> 
              <div style="width:100%; height:auto; padding:5px 0px; background-color: #e6e6e6; font-size:13px;">
                Situazione prodotto
              </div>
              
              <div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
                Venduti
              </div>
              <div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
                <?php echo $venduti; ?>
              </div>
              <div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
                In Ordine
              </div>
              <div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
                <?php echo $ordinati; ?>
              </div>
              <div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
                <?php echo $dic_giacenza; ?>
              </div>
              <div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
                <?php echo $giacenza; ?>
              </div>
              <div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
                Totali
              </div>
              <div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
                <?php echo $totali; ?>
              </div>
            </div>
  
            <div id="colonna_storico" style="width:610px; float: left;"> 
              <div style="width:260px; height:auto; padding:5px 0px; background-color: #e6e6e6; font-size:13px; margin:auto;">
                Prodotti ordinati
              </div>
              <div style="width: 100%;">
              <?php echo $blocco_righe_rda; ?>
              </div>
           </div>
         </div>
    </div><!--END stripN -->
    <!--END container-->
    </div>
