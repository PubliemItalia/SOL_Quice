<?php
$negozio_carrello = $_GET[negozio_carrello];
$avviso = $_GET[avviso];
$id_utente = $_GET[id_utente];
$id_carrello = $_GET[id_carrello];
$lingua = $_GET[lang];
$mex = $_GET[mex];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
include "funzioni.js";
//echo "id_carrello: ".$id_carrello."<br>";
//echo "file popup modal gen rda<br>";
//determino se i prodotti nel carrello hanno un flusso
$array_flussi = array();
$queryh = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello'";
$resulth = mysql_query($queryh) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigah = mysql_fetch_array($resulth)) {
	if ($rigah[flusso] != "") {
	  if (!in_array($rigah[flusso], $array_flussi)) {
		  $add_flusso = array_push($array_flussi,$rigah[flusso]);
	  }
	}
}
//echo "flussi: ";
//print_r($array_flussi);
//echo "<br>";
$queryc = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' AND quant_modifica != ''";
$resultc = mysql_query($queryc) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num_righe_sospese = mysql_num_rows($resultc);
//echo "lingua: ".$lingua."<br>";

switch($lingua) {
case "it":
$dicitura_sospese = "<span class=stile_rosso>Per poter generare la RdA devi completare le modifiche in sospeso</span>";
$dicitura_acquisto = "Acquisto per conto di<br>un&acute;altra company del gruppo";
$dicitura_indirizzo = "Indica un indirizzo di spedizione diverso";
break;
case "en":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to produce the Order Request</span>";
$dicitura_acquisto = "Purchase in name of another company";
$dicitura_indirizzo = "Select another delivery address";
break;
case "fr":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to produce the Order Request</span>";
$dicitura_acquisto = "Purchase in name of another company";
$dicitura_indirizzo = "Select another delivery address";
break;
case "de":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to produce the Order Request</span>";
$dicitura_acquisto = "Purchase in name of another company";
$dicitura_indirizzo = "Select another delivery address";
break;
case "es":
$dicitura_sospese = "<span class=stile_rosso>You have to finish editing the products quantity to produce the Order Request</span>";
$dicitura_acquisto = "Purchase in name of another company";
$dicitura_indirizzo = "Select another delivery address";
break;
}

$sqleee = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'rich_genera_rda'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "it":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_it]."</span>";
break;
case "en":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_en]."</span>";
break;
case "fr":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_fr]."</span>";
break;
case "de":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_de]."</span>";
break;
case "es":
$dicitura = "<span class=stile_rosso>".$rigaeee[testo_es]."</span>";
break;
}
}
$sqlf = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'alert' AND posizione = 'rich_genera_rda_wbs'";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
switch($lingua) {
case "it":
$dicitura_wbs = "<span class=stile_rosso>".$rigaf[testo_it]."</span>";
break;
case "en":
$dicitura_wbs = "<span class=stile_rosso>".$rigaf[testo_en]."</span>";
break;
case "fr":
$dicitura_wbs = "<span class=stile_rosso>".$rigaf[testo_fr]."</span>";
break;
case "de":
$dicitura_wbs = "<span class=stile_rosso>".$rigaf[testo_de]."</span>";
break;
case "es":
$dicitura_wbs = "<span class=stile_rosso>".$rigaef[testo_es]."</span>";
break;
}
}
switch($lingua) {
case "it":
$interno_campo = "";
$alert_wbs = "Il Codice investimento deve essere composto da un minimo di 8 a un massimo di 12 cifre";
break;
case "en":
$interno_campo = "";
$alert_wbs = "Asset code must contain from 8 to 12 digits";
break;
case "fr":
$interno_campo = "";
break;
case "de":
$interno_campo = "";
break;
case "es":
$interno_campo = "";
break;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma generazione RdA</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin: 0px !important;
	font-family: Arial;
}
.Stile1 {
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	vertical-align: middle;
}
.Stile2 {
	font-family: Arial;
	color: red;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
.bottoni_notifiche {
	width:70px;
	height: 40px;
	margin: auto;
	margin-top: 10px;
	padding: 5px;
	font-family: Arial;
	font-weight: bold;
	color: white;
	background-color:green;
	font-size: 18px;
	text-align: center;
	border:2px solid green;
}
.bottoni_notifiche_neg {
	width:70px;
	height: 40px;
	margin: auto;
	margin-top: 10px;
	padding: 5px;
	font-family: Arial;
	font-weight: bold;
	color: green;
	background-color:white;
	font-size: 18px;
	text-align: center;
	border:2px solid green;
}
-->
</style>
 <script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script language="javascript">
function controllo(){
with(document.form1) {
	
if(wbs.value=="") {
alert("Errore: compilare il campo WBS");
wbs.focus();
return false;
}
if (wbs.value.length < 8) {
alert("<?php echo $alert_wbs; ?>");
wbs.focus();
return false;
}
}
return true;
}
</script>
</head>

<body onUnload="refreshParent()">
<!--fine div POP container-->
<form name="form1" method="get" action="DaCarrelloARda.php">
  <div style="width:100%; text-align:center; min-height:150px; overflow: hidden; height:auto; margin-top:20px;">
      <div class="Stile1" style="width:100%; min-height:25px; overflow: hidden; height:auto; margin-top:10px;">
      <?php 
      if ($num_righe_sospese > 0) {
        echo $dicitura_sospese."<br>";
      } else {
        echo $dicitura."<br>";
        if ($negozio_carrello == "assets") {
          echo $dicitura_wbs."<br><br>"; 
        }
      }
      ?>
      </div>
      <div style="width:100%; min-height:25px; overflow: hidden; height:auto; margin-top:10px;"><?php
      if ($negozio_carrello == "assets") {
         echo "<input name=wbs type=text id=wbs size=30 maxlength=12 onkeypress=\"return ctrl_solo_num(event)\" value=".$interno_campo.">";
      }
      if ($mex != "") {
          echo "<br><span class=Stile2>".$mex."</span>";
      }
      ?>
      </div>
      <div style="width:50%; min-height:25px; overflow: hidden; height:auto; margin-top:10px; float:left;"><?php
          if ($num_righe_sospese < 1) {
  
        echo "<input type=submit name=button class=bottoni_notifiche id=button value=OK><br>";
          }
          ?>
                      <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>">
                      <input name="negozio_carrello" type="hidden" id="negozio_carrello" value="<?php echo $negozio_carrello; ?>">
                      <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
                      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
                      <input name="avviso" type="hidden" id="avviso" value="<?php echo $avviso; ?>">
                      <input name="id_carrello" type="hidden" id="id_carrello" value="<?php echo $id_carrello; ?>">
                      <?php //echo "id carrello: ".$id_carrello; ?>
                      <input name="ok_resp" type="hidden" id="ok_resp" value="1">
                      
      </div>
      <div style="width:50%; min-height:25px; overflow: hidden; height:auto; margin-top:10px; float:left;"><?php
          if ($num_righe_sospese < 1) {
  
        echo "<input type=button class=bottoni_notifiche_neg value=NO onClick=\"location.href='popup_notifica.php?avviso=op_annullata&lang=".$lingua."'\">";
          }
          ?>
          </div>
  </div>
</div>
  <div style="width:50%; text-align:center; height:160px; float:left; background-color:#ddd; color:#414141; font-size:11px;">
    <div style="margin:10px 25px; width:auto; text-align:left; min-height:25px; overflow: hidden; height:auto;">
	  <?php echo '<strong>'.$dicitura_acquisto.'</strong>'; ?>
    </div>
    <div style="margin-left:25px; width:80%; text-align:left; min-height:30px; overflow: hidden; height:auto;">
      <?php
	  $sqlq = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente'";
	  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaq = mysql_fetch_array($risultq)) {
		  $unita_originaria = $rigaq[IDCompany];
		  $sqlp = "SELECT * FROM qui_company WHERE IDCompany = '$rigaq[IDCompany]'";
		  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  while ($rigap = mysql_fetch_array($risultp)) {
			  if ($rigap[indirizzo] != "") {
				$indirizzo_originario = $rigap[indirizzo];
			  } else {
				$indirizzo_originario = $rigap[Company];
			  }
		  }
		  //$indirizzo_originario .= '<br>('.$rigaq[nomeunita].')<br>'.$rigaq[indirizzo].'<br>'.$rigaq[cap].' '.$rigaq[localita].'<br>('.$rigaq[nazione].')';
	  }
	   	
	  $sqlp = "SELECT * FROM qui_company ORDER BY Company ASC";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		if ($rigap[IDCompany] == $unita_originaria) {
			$tendina_unita .= '<option selected value="'.$rigap[id].'">'.$rigap[Company].' - '.substr($rigap[localita],0,7).'</option>';
		} else {
			$tendina_unita .= '<option value="'.$rigap[id].'">'.$rigap[Company].' - '.substr($rigap[localita],0,7).'</option>';
		}
	  }
      echo '<select name="company_scelta" class="codice_lista_nopadding" id="company_scelta" style="font-size: 11px; height:22px; width:90%;" onchange="indir(this.value)">'.$tendina_unita.'</select>';
	  ?>
    </div>
    <div id="indirizzo_unita" style="margin:10px 25px; width:auto; text-align:left; min-height:25px; overflow: hidden; height:auto; font-size:11px;"><?php echo $indirizzo_originario; ?></div>
  </div>
  <div style="width:50%; text-align:center; height:160px; float:left; background-color:#ddd; color:#414141; font-size:11px;">
    <?php 
	  if (count($array_flussi) > 0) {
	echo '<div style="margin:10px 25px; width:auto; text-align:left; min-height:25px; overflow: hidden; height:auto;">
	  <strong>'.$dicitura_indirizzo.'</strong>
    </div>
    <div style="margin-left:25px; width:80%; text-align:left; min-height:30px; overflow: hidden; height:auto;">'; 
		$tendina_addr .= '<option selected value="">Seleziona indirizzo</option>';
		foreach ($array_flussi as $sing_flusso) {
		  $sqlp = "SELECT * FROM qui_tBMC_Clienti WHERE flusso LIKE '%$sing_flusso%' ORDER BY NAME1 ASC";
		  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  while ($rigap = mysql_fetch_array($risultp)) {
				$tendina_addr .= '<option value="'.$rigap[id].'">'.$rigap[Descrizione].'</option>';
		  }
		}
      echo '<select name="addr_spedizione" class="codice_lista_nopadding" id="addr_spedizione" style="font-size: 11px; height:22px; width:90%;" onchange="addr_sped(this.value)">'.$tendina_addr.'</select>';
    echo '</div>
    <div id="indirizzo_spedizione" style="margin:10px 25px; width:auto; text-align:left; min-height:25px; overflow: hidden; height:auto; font-size:11px;"></div>';
	  }
	  ?>
  </div>
</form>
<script type="text/javascript">
function indir(id){
	/*alert(id);*/
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_indirizzo_unita.php",  
	  data: "id="+id+"&mode=unita",
	  success: function(output) {
	  $('#indirizzo_unita').html(output).show();
	  }
	})
}
function addr_sped(id){
	/*alert(id);*/
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_indirizzo_unita.php",  
	  data: "id="+id+"&mode=sped",
	  success: function(output) {
	  $('#indirizzo_spedizione').html(output).show();
	  }
	})
}
</script>
</body>
</html>
