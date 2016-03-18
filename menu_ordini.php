<?php
//header("Pragma: no-cache"); 
if ($_GET[lang] != "") {
$lingua_alt = $_GET[lang];
} else {
$lingua_alt = $_POST[lang];
}
$num_righeXcolonna = 4;
$negozio = $_GET[negozio];
$lista = $_GET[lista];
$archive = $_GET[archive];
$preferiti = $_GET[preferiti];
$stile = $_GET[stile];
$posizione = ($_GET[posizione]);
$categoria1 = $_GET['categoria1'];
$paese = $_GET['paese'];
$id_utente = $_SESSION[user_id];





include "traduzioni_interfaccia.php";

?>
<!DOCTYPE html><head>
<link href="css/style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<SCRIPT type="text/javascript">
function aggiorna(){
document.form_lingua.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_lingua.submit();
}
</SCRIPT>
<script type="text/javascript" src="calendar/calendar.js"></script>
<!--<script type="text/javascript" src="calendar/
<?php
?>"></script>-->
<style type="text/css">
<!--
.Stile_alert {
	font-size: 16px;
	font-family: Arial;
	color: #FF0000;
	font-weight: bold;
}
.Stile2 {
	font-size: 12px;
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Stile3 {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
/*a:link {
	color: #FFFFFF;
}
*/.Stile4 {font-family: Arial}
-->
</style>
</head>
<?php
	$sqlx = "SELECT * FROM qui_buyer_funzioni WHERE user_id = '$_SESSION[user_id]'";
            $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
            while($rigax = mysql_fetch_array($risultx)) {
				$vis_ordini = $rigax[amm_ordini];
			  }
    if ($vis_ordini == "1") {
echo "<body onLoad=location.replace('http://www.solgroup/Pub/DITP/DIMM/SMR/ordine.asp');>";
exit;
} else {
echo "<body>";
}
?>

<div id="wrap">
<div id="lingua">
<table width="960" border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="110"><img src=immagini/spacer.gif width=110 height=5></td>
    <td width="110"><a href=index.php><span class=Stile2>Torna al Qui C'&egrave;</span></a></td>
    <td width="118"><img src=immagini/spacer.gif width=115 height=5></td>
    <td width="100"><a href=ordini.php?archive=1><span class=Stile2>Archivio ordini</span></a></td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=5></td>
    <td width="100"></td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=5></td>
    <td width="84">
	<?php 
/*    if ($vis_report == "1") {
		echo "<a href=report_rda.php><span class=Stile2>Report RdA</span></a>";
	}
*/
?>
</td>
    <td width="10"><img src=immagini/spacer.gif width=10 height=5></td>
    <td width="80">
	<?php 
    /*if ($vis_report == "1") {
		echo "<a href=ordini.php><span class=Stile2>Ordini</span></a>";
	}*/
?>
</td>
    
    <td width="89" class="Stile2"><!--<a href="mailto:adv@publiem.it?bcc=publiem@publiem.it&Subject=Qui C'e'" class="Stile2 Stile4">Scrivici</a><a href=guida.php?lang=<?php //echo $lingua; ?> class="Stile2 Stile4">Tutorial</a>--></td>
    <td width="129"><form id="form_lingua" name="form_lingua" method="get" action="<?php echo $azione_form; ?>">
        <div align="right">
          <select name="lang" class="btnProsegui" id="lang" onchange="aggiorna()">
            <?php
            $sqlx = "SELECT * FROM qui_lingue WHERE idioma = '$_SESSION[lang]' AND attiva = '1'";
            $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
            $num_lang = mysql_num_rows($risultx);
            while($rigax = mysql_fetch_array($risultx)) {
              if ($rigax[lang] == $_SESSION[lang]) {
                echo "<option selected value=".$rigax[lang].">".$rigax[desc]."</option>";
                } 
              else{
                echo "<option value=".$rigax[lang].">".$rigax[desc]."</option>";
              }
            }
          ?>
          </select>
          <input name="mod_lang" type="hidden" id="mod_lang" value="1" />
          <input name="page" type="hidden" id="page" value="<?php echo $page; ?>" />
          <input name="limit" type="hidden" id="limit" value="<?php echo $limit; ?>" />
          <input name="paese" type="hidden" id="paese" value="<?php echo $paese; ?>" />
          <input name="negozio" type="hidden" id="negozio" value="<?php echo $negozio; ?>" />
          <?php 
      		if ($posizione != "") {
        		echo "<input name=posizione type=hidden id=posizione value=".$posizione.">";
        		}
      		if ($lista != "") {
        		echo "<input name=lista type=hidden id=lista value=".$lista.">";
        		}
      		?>
          
        </div>
    </form>
    </td>
    <td width="20"><img src=immagini/spacer.gif width=20 height=5></td>
  </tr>
</table>

    <li><form id="form_lingua" name="form_lingua" method="get" action="<?php //echo $azione_form; ?>">
<!--        <select name="lang" class="btnProsegui" id="lang" onChange="aggiorna()">
          <?php
/*            $sqlx = "SELECT * FROM qui_lingue WHERE idioma = '$_SESSION[lang]' AND attiva = '1'";
            $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
            $num_lang = mysql_num_rows($risultx);
            while($rigax = mysql_fetch_array($risultx)) {
              if ($rigax[lang] == $_SESSION[lang]) {
                echo "<option selected value=".$rigax[lang].">".$rigax[desc]."</option>";
                } 
              else{
                echo "<option value=".$rigax[lang].">".$rigax[desc]."</option>";
              }
            }
*/          ?>
        </select>-->
        <input name="mod_lang" type="hidden" id="mod_lang" value="1" />
        <input name="page" type="hidden" id="page" value="<?php //echo $page; ?>" />
        <input name="limit" type="hidden" id="limit" value="<?php //echo $limit; ?>" />
        <input name="negozio" type="hidden" id="negozio" value="<?php //echo $negozio; ?>" />
        <?php 
      		if ($posizione != "") {
        		echo "<input name=posizione type=hidden id=posizione value=".$posizione.">";
        		}
      		if ($lista != "") {
        		echo "<input name=lista type=hidden id=lista value=".$lista.">";
        		}
      		?>

        </form>
      </li>
-->    </ul> 


</div><!--END DIV_LINGUA-->

	
<div>
    <div style="font-family:Arial, sans-serif; font-size:36px; font-weight:bold; height:auto; padding:10px 0 10px 0;">Ordini fornitori</div>
  </div>
 <?php

//div ricerca rda
if ($file_presente == "ordini.php") { 
echo "<div id=ricerca class=submenuordini>";
echo "<div id=formRicerca>";
echo "<form action=".$azione_form." method=get name=form_filtri2>";
echo "<div class=col>";
echo "<strong>".$shop."</strong><br>";
echo "<select name=shop class=codice_lista_nopadding id=shop>";
switch ($shopDaModulo) {
case "":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "assets":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option selected value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "consumabili":
echo "<option selected value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option selected value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "spare_parts":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option selected value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "labels":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option selected value=labels>".$tasto_labels."</option>";
echo "<option value=vivistore>".$tasto_vivistore."</option>";
break;
case "vivistore":
echo "<option value=>".$scegli_shop."</option>";
echo "<option value=assets>".$tasto_asset."</option>";
echo "<option value=consumabili>".$tasto_consumabili."</option>";
echo "<option value=spare_parts>".$tasto_spare_parts."</option>";
echo "<option value=labels>".$tasto_labels."</option>";
echo "<option selected value=vivistore>".$tasto_vivistore."</option>";
break;
}
echo "</select><br>";
echo "<img src=immagini/spacer.gif width=100 height=5><br>";
echo "<strong>".$unita."</strong><br>";
echo "<select name=unita class=codice_lista_nopadding id=unita>";
echo "<option selected value=>".$scegli_unita."</option>";
$sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_rda ORDER BY nome_unita ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
if ($rigag[id_unita] == $unitaDaModulo) {
echo "<option selected value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
} else {
echo "<option value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
}
}
echo "</select>";
echo "</div>";



echo "<div class=col>";
echo "<strong>".$testo_nr_ord."</strong><br>";
echo "<input name=nr_ordine type=text class=tabelle8 id=nr_ordine size=10 value=".$nr_ord.">";
echo "<br><img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$testo_nr_rda."</strong><br>";
echo "<input name=nr_rda type=text class=tabelle8 id=nr_rda size=10 value=".$nr_rda.">";
echo "</div>";
echo "<div class=col>";
echo "<strong>".$testo_data_inizio."</strong><br>";
echo "<input name=data_inizio type=text class=tabelle8 id=data_inizio size=10 onclick=\"Calendar.show(this, '%d/%m/%Y', false)\"
onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\" value=".$data_inizio.">";
echo "<br>";
echo "<img src=immagini/spacer.gif width=100 height=2><br>";
echo "<strong>".$testo_data_fine."</strong><br>";
echo "<input name=data_fine type=text class=tabelle8 id=data_fine size=10 onclick=\"Calendar.show(this, '%d/%m/%Y', false)\"
onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\" value=".$data_fine.">";
echo "</div>";
echo "<div class=col>";
echo "<br><input type=submit name=button id=button value=".$filtra.">";
echo "<br><br><a href=xls2.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&stato_rda=".$stato_rdaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine." target=_blank><span class=Stile3>".$esporta."</span></a>";
echo "</div>";
/*
echo "<div class=col_excel>";
echo "<br><a href=xls2.php?shop=".$shopDaModulo."&unita=".$unitaDaModulo."&stato_rda=".$stato_rdaDaModulo."&nr_rda=".$nrRdaDaModulo."&data_inizio=".$data_inizio."&data_fine=".$data_fine." target=_blank><span class=Stile3>".$esporta."</span></a>";
echo "</div>";
*/
echo "</form>";
echo "</div>";//fine formRicerca

echo "</div>";//fine div id=ricerca class=submenuRicerca

}


?>
</div>
<!--END WRAP-->


<script type="text/javascript">
	//Menu
	var menuAsset = document.getElementById('menuAsset');
	var menuConsumable = document.getElementById('menuConsumable');
	var menuSpareParts = document.getElementById('menuSpareParts');
	//var menuvivistore = document.getElementById('menuvivistore');
	//var menuMedDevice = document.getElementById('menuMedDevice');
	//var menuSearch = document.getElementById('menuSearch');

	//Tendine
	var asset = document.getElementById('asset');
	var consumable = document.getElementById('consumable');
	var spareParts = document.getElementById('spareParts');
	//var vivistore = document.getElementById('vivistore');
	//var medDevice = document.getElementById('medDevice');
	//var search = document.getElementById('search');

	asset.className = 'hide';
	consumable.className = 'hide';
	spareParts.className = 'hide';
	//vivistore.className = 'hide';
	//medDevice.className = 'hide';
	//search.className = 'hide';    //COMMENTATO 

	function visualizza(mercato){
		//Menu
		menuAsset.className = mercato == 'asset' ? 'voce_top_menu_hover assetColor' : 'voce_top_menu';
		menuConsumable.className = mercato == 'consumable' ? 'voce_top_menu_hover consumableColor' : 'voce_top_menu';
		menuSpareParts.className = mercato == 'spareParts' ? 'voce_top_menu_hover sparePartsColor' : 'voce_top_menu';
		//menuvivistore.className = mercato == 'vivistore' ? 'voce_top_menu_hover vivistoreColor' : 'voce_top_menu';
		//menuMedDevice.className = mercato == 'medDevice' ? 'voce_top_menu_hover medDeviceColor' : 'voce_top_menu';
		//menuSearch.className = mercato == 'search' ? 'voce_top_menu_hover search' : 'voce_top_menu';  //COMMENTATO
		
		//Tendine
		asset.className = mercato == 'asset' ? 'show menuAssetBg' : 'hide';
		consumable.className = mercato == 'consumable' ? 'show menuConsumableBg' : 'hide';
		spareParts.className = mercato == 'spareParts' ? 'show menuSpBg' : 'hide';
		//vivistore.className = mercato == 'vivistore' ? 'show vivistoreColor' : 'hide';
		//medDevice.className = mercato == 'medDevice' ? 'show medDeviceColor' : 'hide';
		//search.className = mercato == 'search' ? 'show search' : 'hide';    //COMMENTATO
	}
	function nascondi(mercato){
		//Menu
		menuAsset.className = 'voce_top_menu';
		menuConsumable.className = 'voce_top_menu';
		menuSpareParts.className = 'voce_top_menu';
		//menuvivistore.className = 'voce_top_menu';
		//menuMedDevice.className = 'voce_top_menu';
		//menuSearch.className = 'voce_top_menu';  //COMMENTATO
		//Tendine
		asset.className = 'hide';
		consumable.className = 'hide';
		spareParts.className = 'hide';
		//vivistore.className = 'hide';
		//medDevice.className = 'hide';
		//search.className = 'hide';  //COMMENTATO

	}
</script>

</body>
</html>