<?php
session_start();
$id = $_GET[id];
$lingua = $_SESSION[lang];
//$lingua = $_SESSION[lang];
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
//echo "output_ok: ".$output_ok."<br>";
//echo "output_mode: ".$output_mode."<br>";
$id_utente = $_SESSION[user_id];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$query = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY id_rda ASC";
$risulty = mysql_query($query) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulty);
//echo "num_righe: ".$num_righe."<br>";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selezione output RdA</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<link href="css/report_balconi.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
}
body {
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
	/*background-color:#CFF;*/
	color:rgb(0,0,0);
}
-->
</style>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
window.close();
}
</script>
</head>
<body>
<div id="main_container"></div>


<?php
//if ($num_righe > 0) {


$tot = "1";
//inizio div rda
echo "<div id=blocco_rda_".$id." class=cont_rda>";
//echo "ecco qua<br>";
echo "<div class=riassunto_rda>";
if ($tipo_negozio != "assets") {
//echo "RDA ".$id.$indicazione_negozio_rda.$tracciati_sap.$ut_rda;
echo "RDA ".$id.$tracciati_sap.$ut_rda;
} else {
$output_wbs .= "<img src=immagini/spacer.gif width=25 height=2>WBS ";
$output_wbs .= " (".$wbs_visualizzato.")";
//echo "RDA ".$id.$indicazione_negozio_rda.$output_wbs.$ut_rda;
echo "RDA ".$id.$output_wbs.$ut_rda;
}
$wbs_visualizzato = "";
$output_wbs = "";
echo "</div>";
echo "<div class=stato_rda>";
echo $imm_status;
echo "</div>";
$tracciati_sap = "";
 $sf = 1;

//determino se le righe sono selezionate o meno per stabilire quale bottone di selezione utilizzare
$sqlk = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$Num_righe_rda = mysql_num_rows($risultk);
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[flag_buyer] == 1) {
$Num_righe_rda_selezionate = $Num_righe_rda_selezionate + 1;
}
if ($rigak[output_mode] != "") {
//if ($rigak[flag_buyer] >= 2 AND $rigak[evaso_magazzino] == 1) {
if ($rigak[flag_buyer] >= 2) {
$Num_righe_processate = $Num_righe_processate + 1;
}
} else {
if ($rigak[flag_buyer] >= 2) {
$Num_righe_processate = $Num_righe_processate + 1;
}
}
if ($rigak[output_mode] != "") {
if ($rigak[output_mode] != "mag") {
$Num_righe_evadere = $Num_righe_evadere + 1;
} else {
if ($rigak[evaso_magazzino] == 1) {
$Num_righe_evadere = $Num_righe_evadere + 1;
}
}
}

if ($flag_ricerca != "") {
  } else {
	if ($Num_righe_rda_selezionate == 0) {
	$tooltip_select = $tooltip_seleziona_tutto;
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id.",1);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	} else {
	$tooltip_select = $tooltip_deseleziona_tutto;
	$bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id.",0);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	}
  }
}

$Num_righe_rda_selezionate = "";

echo "<div class=sel_all>";
//if ($Num_righe_processate < $Num_righe_rda) {
echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'gestione_evasione_righe.php?id=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$id.")}})\"><img src=immagini/visione_righe.png width=17 height=17 border=0 title=".$visualizza_dettaglio."></a>";
//}
echo "</div>";

echo "<div class=sel_all>";
if ($Num_righe_processate < $Num_righe_rda) {
if ($flag_ricerca != "") {
} else {
echo $bottone_immagine;
}
}
echo "</div>";

$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
//echo "<span style=\"color:rgb(0,0,0);\">sqln: ".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
if ($sf == 1) {
//inizio contenitore riga
echo "<div class=columns_righe2>";
} else {
echo "<div class=columns_righe1>";
}
//div num rda riga
echo "<div class=cod1_riga>";
echo $rigan[id_rda];
//fine div num rda riga
echo "</div>";
//div data riga
echo "<div class=cod1_riga>";
echo date("d.m.Y",$rigan[data_inserimento]);
//fine div data riga
echo "</div>";
//div codice riga
echo "<div id=confez5_riga>";
if (substr($rigan[codice_art],0,1) != "*") {
  echo $rigan[codice_art];
} else {
  echo substr($rigan[codice_art],1);
}
//fine div codice riga
echo "</div>";

//div descrizione riga
echo "<div class=descr4_riga>";
echo $rigan[descrizione];
//fine div descrizione riga
echo "</div>";


//div nome unità riga
echo "<div class=cod1_riga style=\"width:60px;\">";
echo $rigan[nome_unita];
//fine div nome unità riga
echo "</div>";
//div quant riga
echo "<div id=q_".$tot." name=q_".$tot." class=price6_riga_quant style=\"width:50px; padding-right:10px;\">";
echo number_format($rigan[quant],0);
echo "<input name=v_".$tot." type=hidden id=v_".$tot." value=".number_format($rigan[quant],0).">";
echo "</div>";
echo "<div class=price6_riga_quant style=\"width:50px; padding-right:10px; float:left;\">";
if ($rigan[output_mode] == "") {
echo "<input name=c_".$tot." type=text id=c_".$tot." style=\"width:40px; font-size:11px;\" maxlength=4 onkeypress = \"return ctrl_solo_num(event);\" onKeyUp=\"spezza(".$rigan[id].",".$tot.");\" onBlur=\"ripristinaquantriga(".$rigan[id].",".$tot.")\">";
}
echo "</div>";
//div pulsante per visualizzare scheda
echo "<div class=lente_prodotto>";
if ($rigan[output_mode] == "") {
echo "<a href=ricerca_prodotti.php?categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rigan[negozio]."&codice_art=".$rigan[codice_art]."&anchor=blocco_rda_".$id."&lang=".$lingua."&nofunz=1><img src=immagini/btn_lente_bn.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
}
//fine div pulsante per visualizzare scheda
echo "</div>";
//div totale riga
echo "<div class=price6_riga style=\"width:75px; padding-right:10px;\">";
echo number_format($rigan[totale],2,",",".");
//fine div totale riga
echo "</div>";

//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "":
$button_style = "vuoto9_riga";
break;
case "mag":
$button_style = "style_mag";
break;
case "sap":
$button_style = "style_sap";
break;
case "ord":
$button_style = "style_ord";
break;
}
echo "<div class=".$button_style.">";
echo strtoupper($rigan[output_mode]);
//fine div output mode riga
echo "</div>";

//div evaso (vuoto)
echo "<div class=vuoto9_riga>";
if ($rigan[evaso_magazzino] == 1) {
echo " evaso";
}
//fine div evaso
echo "</div>";
//div checkbox (vuoto)
echo "<div class=sel_all_riga id=".$rigan[id].">";
if ($rigan[output_mode] == "") {
switch ($rigan[flag_buyer]) {
case "0":
  echo "<input name=id_riga[] type=checkbox id=id_riga[] value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'1',".$id.");\">";
break;
case "1":
echo "<input name=id_riga[] type=checkbox id=id_riga[] checked value=".$rigan[id]." onClick=\"axc(".$rigan[id].",'0',".$id.");\">";
$contatore_righe_flag = $contatore_righe_flag + 1;
  break;
}
} else {
if ($rigan[flag_buyer] > 1) {
$contatore_x_chiusura = $contatore_x_chiusura + 1;
}

}
//fine div checkbox
echo "</div>";
$tot = $tot+1;
//fine contenitore riga tabella
echo "</div>";

//fine foreach
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}
/*
*/
echo "</div>";
//}
?>            
<script type="text/javascript">
function spezza(id_riga,progr_riga){
  var valore_attuale = document.getElementById('c_'+progr_riga).value;
  var valore_prec = document.getElementById('v_'+progr_riga).value;
  if (valore_attuale >= valore_prec) {
	alert("Il valore inserito è troppo alto");
  } else {
	  val diff = valore_attuale-valore_prec;
$("#avviso_filtri").html(" ");
  }
				$.ajax({
						type: "GET",   
						url: "imposta_selezione_blocco_sing_rda.php",   
						data: "singola=1"+"&unita=<?php echo $unitaDaModulo; ?>"+"&categoria_ricerca=<?php echo $categoria_ricerca_DaModulo; ?>"+"&data_inizio=<?php echo $data_inizio; ?>"+"&data_fine=<?php echo $data_fine; ?>"+"&shop=<?php echo $shopDaModulo; ?>"+"&codice_art=<?php echo $codice_artDaModulo; ?>"+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda+"&lang=<?php echo $lingua; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>"+"&ricerca=<?php echo $flag_ricerca; ?>",
						success: function(output) {
						$('#blocco_rda_'+id_rda).html(output).show();
						}
						})

}
</SCRIPT>
</body>
</html>