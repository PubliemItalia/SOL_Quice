<?php
session_start();
$lingua = $_SESSION[lang];
switch ($lingua) {
case "it":
$new = "Nuova proposta";
$back = "Annulla";
$salva = "Registra";
$modifica = "Modifica";
$dic_note = "Note";
$dic_cat1 = "Categoria 1";
$dic_cat2 = "Categoria 2";
$dic_negozio = "Negozio";
$dic_prezzo = "Prezzo";
$dic_confezione = "Confezione";
$dic_gr_merci = "Gruppo merci";
$dic_immagine = "Carica immagine";
$dic_scegli = "Scegli";
$dic_paese = "Paese";
break;
case "en":
$new = "New item";
$back = "Cancel";
$salva = "Save";
$modifica = "Save changes";
$dic_note = "Notes";
$dic_cat1 = "Category 1";
$dic_cat2 = "Category 2";
$dic_negozio = "Shop";
$dic_prezzo = "Price";
$dic_confezione = "Package";
$dic_gr_merci = "Goods Group";
$dic_immagine = "Upload image";
$dic_scegli = "Choose";
$dic_paese = "Country";
break;
}
$inserimento_proposta = $_POST[inserimento_proposta];
$negozio = $_POST[negozio];
$paese = $_POST[paese];
$categoria1_it = $_POST[categoria1_it];
$categoria2_it = $_POST[categoria2_it];
$prezzo = $_POST[prezzo];
$confezione = $_POST[confezione];
$gruppo_merci = $_POST[gruppo_merci];
$descrizione1_it = addslashes($_POST[descrizione1_it]);
$descrizione2_it = addslashes($_POST[descrizione2_it]);
$descrizione1_en = addslashes($_POST[descrizione1_en]);
$descrizione2_en = addslashes($_POST[descrizione2_en]);
$note_it = addslashes($_POST[note_it]);
if ($_SESSION[user_id] == $_SESSION[IDResp]) {
	$livello_approvazione = "2";
} else {
	$livello_approvazione = "1";
}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
if ($inserimento_proposta != "") {
$negozio_ins = strtolower($negozio);
$nn = "SELECT * FROM qui_utenti WHERE user_id = '$_SESSION[IDResp]'";
$risultnn = mysql_query($nn) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigann = mysql_fetch_array($risultnn)) {
$mail_resp = $rigann['posta'];
$unita_rda .= stripslashes($rigann['nomeunita'])."<br>";
$unita_rda .= stripslashes($rigann['indirizzo'])."<br>";
$unita_rda .= stripslashes($rigann['cap'])." ".stripslashes($rigann['localita'])."<br>";
$unita_rda .= stripslashes($rigann['nazione']);
}
$mm = "SELECT * FROM qui_prodotti_".$negozio_ins." WHERE categoria1_it = '$categoria1_it' ORDER BY id ASC LIMIT 1";
$risultmm = mysql_query($mm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigamm = mysql_fetch_array($risultmm)) {
$categoria1_en = $rigamm['categoria1_en'];
}
$mm = "SELECT * FROM qui_prodotti_".$negozio_ins." WHERE categoria2_it = '$categoria2_it' ORDER BY id ASC LIMIT 1";
$risultmm = mysql_query($mm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigamm = mysql_fetch_array($risultmm)) {
$categoria2_en = $rigamm['categoria2_en'];
}
$mail_utente = $_SESSION[posta];
$mail_resp = $mail_resp;
$mail_destinatario = "diego.sala@publiem.it";
mysql_query("INSERT INTO qui_proposte_prodotti (negozio, paese, categoria1_it, categoria2_it, descrizione1_it, descrizione2_it, descrizione3_it, gruppo_merci, confezione, prezzo, foto, categoria1_en, categoria2_en, descrizione1_en, descrizione2_en, id_proponente, mail_proponente, livello_approvazione, id_resp, mail_resp) VALUES ('$negozio_ins', '$paese', '$categoria1_it', '$categoria2_it', '$descrizione1_it', '$descrizione2_it', '$note_it', '$gruppo_merci', '$confezione', '$prezzo', '$immagine', '$categoria1_en', '$categoria2_en', '$descrizione1_en', '$descrizione2_en', '$_SESSION[user_id]', '$_SESSION[posta]', '$livello_approvazione', '$_SESSION[IDResp]','$mail_resp')");
$ultimo_id = mysql_insert_id();
if (mysql_error()) {
echo "Errore durante l'inserimento 1". mysql_error();
}
//costruzione testatina tabella dettagli rda x email
$tx_html .= "<table width=640 border=0 align=center cellpadding=1 cellspacing=0>";
$tx_html .= "<tr valign=top bgcolor=#eaeaea>";
$tx_html .= "<td width=370 valign=top class=table_mail_test_product>Descrizione</td>";
$tx_html .= "<td width=120 valign=top class=table_mail_test_numeri>Categoria1</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri>Gr. merci</td>";
$tx_html .= "<td width=70 valign=top class=table_mail_test_numeri_dx>Prezzo</td>";
$tx_html .= "</tr>";

//costruzione righe tabellina dettagli rda x invio email
$tx_html .= "<tr valign=top>";
$tx_html .= "<td class=table_mail_product>".stripslashes($descrizione1_it)."</td>";
$tx_html .= "<td class=table_mail_numeri>".$categoria1_it."</td>";
$tx_html .= "<td class=table_mail_numeri>".$gruppo_merci."</td>";
$tx_html .= "<td class=table_mail_numeri_dx>".$prezzo."</td>";
$tx_html .= "</tr>";
//**********************************
$tx_html .= "</table>";

/*
include "spedizione_mail_proposta.php";
*/

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $titolo_scheda; ?></title>
    <!--INIZIO DEL FORM-->
 
    <link href="css/modifica_scheda.css" rel="stylesheet" type="text/css">
    <?php
$sfondo = "#FFEAA6";
?>
<style type="text/css">


body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: <?php echo $sfondo; ?>;
	font-family:Arial;
	font-size:12px;
}
#pulsante_indietro {
	width: auto;
	height: auto;
	float:left;
}
#pulsante_modifica {
	width: auto;
	height: auto;
	float:left;
}
<!--
.Stile1 {color: #FF0000}
.Stile2 {
	color: #33CCFF;
	font-weight: bold;
}
.Stile3 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
<script src="js/jquery-1.7.2.min.js"></script>
    </head>
    <body>
<div style="width:auto; height:auto; ">
<form action="proposta_nuovo_prodotto.php" method="post" enctype="multipart/form-data" name="form1">

<?php
include "funzioni.js";
include "query.php";
mysql_set_charset("utf8");
?>
<div class="strip">
    <div class="colonna" style="width:390px;">
          <div class="etichetta" style="width:100px">
          <?php echo $dic_negozio; ?>
        </div>
      <div class="valore" style="width:250px">
      <select name="negozio" id="negozio" onchange="varia_tendina1()">
		  <option selected value=><?php echo $dic_scegli; ?></option>
        <?php
$sqlr = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'menu' AND posizione LIKE '%tasto%' AND negozio = '1' ORDER BY testo_it ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
switch ($lingua) {
case "it":
$testo_negozio = $rigar[testo_it];
break;
case "en":
$testo_negozio = $rigar[testo_en];
break;
}
if ($rigar[testo_it] == "Ricambi") {
echo "<option value=spare_parts>".$testo_negozio."</option>"; 
} else {
echo "<option value=".$rigar[testo_it].">".$testo_negozio."</option>"; 
}
}
		?>
        </select>
        </div>
<div class="etichetta" style="width:100px">
          <?php echo $dic_paese; ?>
        </div>
      <div class="valore" style="width:250px">
      <select name="paese" id="paese">
		  <option selected value=><?php echo $dic_scegli; ?></option>
        <?php
$sqlr = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'menu' AND posizione LIKE '%tasto%' AND negozio = '1' ORDER BY testo_it ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
switch ($lingua) {
case "it":
$testo_negozio = $rigar[testo_it];
break;
case "en":
$testo_negozio = $rigar[testo_en];
break;
}
if ($rigar[testo_it] == "Ricambi") {
echo "<option value=spare_parts>".$testo_negozio."</option>"; 
} else {
echo "<option value=".$rigar[testo_it].">".$testo_negozio."</option>"; 
}
}
		?>
        </select>
        </div>
        
    </div><!--END colonna-->
      <div class="colonna" style="width:350px;">
      <div class="etichetta" style="width:100px">
          <?php echo $dic_cat1; ?>
        </div>
      <div id="tendina_cat1" class="valore" style="width:250px">
<select name="categoria1_it" id="categoria1_it" onchange="varia_tendina2()" disabled>
		  <option selected value=><?php echo $dic_scegli; ?></option>
        <?php
		$array_cat1 = array();
		$sqlp = "SELECT * FROM qui_prodotti_consumabili ORDER BY precedenza ASC";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
while ($rigap = mysql_fetch_array($risultp)) {
switch ($lingua) {
case "it":
$categoria1 = $rigap[categoria1_it];
break;
case "en":
$categoria1 = $rigap[categoria1_en];
break;
}
if (!in_array($categoria1,$array_cat1)) {
		  echo "<option value=".$categoria1.">".str_replace("_"," ",$categoria1)."</option>"; 
		  $add_cat1 = array_push($array_cat1,$categoria1);
}
}
		?>
        </select>
        </div>
        <div class="etichetta" style="width:100px">
          <?php echo $dic_cat2; ?>
        </div>
      <div id="tendina_cat2" class="valore" style="width:250px">
        <select name="categoria2_it" id="categoria2_it" disabled>
		  <option value=><?php echo $dic_scegli; ?></option>
        </select>
      </div></div><!--END colonna-->
  </div>


    <div class="strip">
      <div class="colonna" style="width:390px;"><!--END SELEZIONE-->
        <div class="etichetta">
          <?php echo $dic_prezzo; ?>
          </div>
        <div class="valore">
          <input name="prezzo" type="text" class="menu_markets" id="prezzo" size="25" onkeypress = "return ctrl_decimali(event)" value="<?php echo $prezzo; ?>">
        </div><!--END SELEZIONE-->
        
        <div class="etichetta">
        <?php echo $dic_confezione; ?>
        </div>
        <div class="valore">
        <input name="confezione" type="text" class="menu_markets" id="confezione" size="25" value="<?php echo $confezione; ?>">
        </div>
         <div class="etichetta">
        <?php echo $dic_gr_merci; ?>
        </div>
        <div class="valore">
        <select name="gruppo_merci" id="gruppo_merci">
		  <option value=><?php echo $dic_scegli; ?></option>
<?php
$sqlq = "SELECT * FROM qui_gruppo_merci WHERE descrizione != '' ORDER BY descrizione ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
	switch ($lingua) {
case "it":
		  echo "<option value=".$rigaq[gruppo_merce].">".$rigaq[descrizione]."</option>"; 
break;
case "en":
		  echo "<option value=".$rigaq[gruppo_merce].">".$rigaq[descrizione_en]."</option>"; 
break;
	}
}
?>
        </select>
        </div>
     </div><!--END colonna-->
      <div class="colonna" style="width:350px;">
        <!--<div class="upload_img">
  <a href="javascript:void(0);" onclick="TINY.box.show({iframe:'gestione_immagine_princ.php?id_prod=<?php echo $id; ?>&negozio_prod=<?php echo $negozio; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><span class=Stile2><?php echo $main_image; ?></span></a>
        </div>--><!--END UPLOAD IMAGE-->
        <div class="upload_img"><br />
  <a href="javascript:void(0);" onclick="TINY.box.show({iframe:'gestione_gallery.php?id_prod=<?php echo $id; ?>&negozio_prod=<?php echo $negozio; ?>&id_utente=<?php echo $dic_immagine; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS2()}})"><div class="pulsanti_scheda_grigio" style="float:none;"><?php echo $dic_immagine; ?></div></a>
        </div><!--END UPLOAD IMAGE-->
        <div id="images" style="margin-top:20px; margin-right:15px; width:120px; height:50px; float:left;"><?php
		  if ($foto != "") {
			  echo "Immagine principale<br><img src=immagini/spacer.gif width=120 height=5><br>";
			  if (is_file("files/".$foto)) {
		  echo "<img src=files/".$foto." width=30 height=30>";
		  } else {
			  echo "File Immagine mancante<br>";
		  }
		  } else {
		  echo "<img src=immagini/spacer.gif width=30 height=30>";
		  }
		  ?>
        </div>
        <?php
$sqlp = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
$num_image_gallery = mysql_num_rows($risultp);
if ($num_image_gallery > 0) {
        echo "<div id=image_gallery style=\"margin-top:20px; width:200px; height:50px; float:left;\">";
		echo "Galleria fotografica<br><img src=immagini/spacer.gif width=120 height=5><br>";
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
      </div><!--END colonna-->
    </div><!--END STRIP -->


    <div class="strip">
      <div class="colonna" style="width:390px;">
        <div class="tit_strip">Descrizione prodotto</div> <!--END TIT STRIP-->
        <div class="etichetta">
          Descrizione breve<br />(Non più di 40 caratteri, ma che sia comunque comprensibile, senza abbreviazioni)
            
        </div>
        <div class="valore">
          <textarea name="descrizione1_it" cols="25" rows="3" class="styled_textareas" id="descrizione1_it"><?php echo $descrizione1_it; ?></textarea>
        </div>
        <!--END DESCRIZIONE-->
        <div class="etichetta">
         Descrizione estesa</div>
        <div class="valore">
        <textarea name="descrizione2_it" cols="25" rows="3" class="styled_textareas" id="descrizione2_it"><?php echo $descrizione2_it; ?></textarea> 
        </div><!--END DESCRIZIONE-->
      </div><!--END colonna-->
      <div class="colonna" style="width:350px;">
      <div class="tit_strip">Product description</div> <!--END TIT STRIP-->
        <div class="etichetta">
          Short description<br />(Please don't write more<br />than 40 digits <br /> and don't use<br />abbreviations
         </div>
        <div class="valore">
        <textarea name="descrizione1_en" cols="25" rows="3" class="styled_textareas" id="descrizione1_en"><?php echo $descrizione1_en; ?></textarea>
        </div><!--END DESCRIZIONE-->
        <div class="etichetta">
          Detailed Description</div>
        <div class="valore">
        <textarea name="descrizione2_en" cols="25" rows="3" class="styled_textareas" id="descrizione2_en"><?php echo $descrizione2_en; ?></textarea>
        </div><!--END DESCRIZIONE-->
      </div><!--END colonna-->
    </div><!--END STRIP-->

    <div class="strip">
    <div class="colonna" style="width:380px;">
        <div class="tit_strip"><?php echo $dic_note; ?></div> <!--END TIT STRIP-->
        <div class="valore" style="width:350px">
          <textarea name="note_it" cols="25" rows="3" class="styled_notes" id="note_it"><?php echo $descrizione3_it; ?></textarea>
      </div><!--END DESCRIZIONE--><!--END DESCRIZIONE--><!--END DESCRIZIONE--><!--END DESCRIZIONE--><!--END DESCRIZIONE-->

      </div><!--END colonna--><!--END colonna-->
    </div><!--END STRIP -->

    <div class="strip" style="text-align:center;">

        
		<input name="indietro" type="button" class="pulsanti_scheda_azzurro" style="width:100px; height:40px; margin-left:280px; border:none;" onClick="history.go(-2)" value="<?php echo $back; ?>" id="indietro">
		<input type="submit" name="button" id="button" class= "pulsanti_scheda_verde" style="width:100px; height:40px; margin-left:20px; border:none;" value="<?php 
		if ($ultimo_id != "") {
		echo $modifica;
		} else {
		echo $salva;
		}
?>">
<?php
		if ($ultimo_id != "") {
echo "<input name=nuova_proposta type=button class=pulsanti_scheda_azzurro style=\"width:100px; height:40px; margin-left:20px; border:none;\" onClick=\"doRedirect_nuovo()\" value=".$new." id=nuova_proposta>";
		}
?>
		</div>
       <input name="mode" type="hidden" value="<?php echo $mode; ?>">
        <input name="lang" type="hidden" value="<?php echo $lingua; ?>">
        <input name="inserimento_proposta" type="hidden" id="inserimento_proposta" value="1">

    <!--END container-->
  </form>
    </div>
<script type="text/javascript">
function doRedirect_nuovo() { //funzione con il link alla pagina che si desidera raggiungere
location.href = "proposta_nuovo_prodotto.php";
}
function varia_tendina1(){
var val_neg = document.getElementById('negozio').value;
	/*alert(val_cat1)*/;
		$.ajax({
			type: "GET",   
				url: "aggiorna_tendina_proposta_cat1.php",   
				data: "negozio="+val_neg,
				  success: function(output) {
				  $('#tendina_cat1').html(output).show();
				  }
				  });
}
function varia_tendina2(){
var val_cat1 = document.getElementById('categoria1_it').value;
	/*alert(val_cat1)*/;
		$.ajax({
			type: "GET",   
				url: "aggiorna_tendina_proposta_cat2.php",   
				data: "cat1="+val_cat1,
				  success: function(output) {
				  $('#tendina_cat2').html(output).show();
				  }
				  });
}
</script>
</body>
</html>