<?php
session_start();
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}
$salvataggio = $_POST[salvataggio];
$id_rda = $_GET[id_rda];
if ($_GET[id_ord] != "") {
$id_ord = $_GET[id_ord];
} else {
$id_ord = $_POST[id_ord];
}
$lingua = $_GET[lang];
$note = str_replace("\n","<br>",$_POST[note]);
$note = str_replace("\r","<br>",$note);
$note = str_replace("<br><br>","<br>",$note);
$note = addslashes($note);
$data_consegna_provv = explode("/",$_POST[data_consegna]);
$data_consegna_ins = mktime(12,30,0,$data_consegna_provv[1],$data_consegna_provv[0],$data_consegna_provv[2]);
$ordine_interno = $_POST[ordine_interno];
$fornitore = str_replace("\n","<br>",$_POST[fornitore]);
$fornitore = str_replace("\r","<br>",$fornitore);
$fornitore = str_replace("<br><br>","<br>",$fornitore);
$fornitore = addslashes($fornitore);
$termini_pagamento = addslashes($_POST[termini_pagamento]);
$termini_pagamento = str_replace("\n","<br>",$termini_pagamento);
$termini_pagamento = str_replace("<br><br>","<br>",$termini_pagamento);
$termini_consegna = addslashes($_POST[termini_consegna]);
$termini_consegna = str_replace("\n","<br>",$termini_consegna);
$termini_consegna = str_replace("<br><br>","<br>",$termini_consegna);
$id_buyer = $_SESSION[user_id];
$ordinante = $_SESSION[nome];
include "funzioni.js";
include "functions.php";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
if ($salvataggio == "1") {
$query = "UPDATE qui_ordini_for SET note = '$note', indirizzo_for = '$fornitore', ordine_interno = '$ordine_interno', data_consegna = '$data_consegna_ins', termini_consegna = '$termini_consegna', termini_pagamento = '$termini_pagamento' WHERE id = '$id_ord'";
if (mysql_query($query)) {
//echo "modificata riga ".$ogni_riga."<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
$sqlk = "SELECT * FROM qui_ordini_for WHERE id = '$id_ord'";
$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
$ordinante = stripslashes($rigak[ordinante]);
$id_rda_ord = stripslashes($rigak[id_rda]);
$nome_utente_disp = stripslashes($rigak[nome_utente]);
$nome_resp_disp = stripslashes($rigak[nome_resp]);
$note_disp = stripslashes($rigak[note]);
$fornitore_disp = $rigak[indirizzo_for];
$id_utente_disp = stripslashes($rigak[id_utente]);
$data_ordine = $rigak[data_ordine];
$data_consegna = $rigak[data_consegna];
$logo = $rigak[logo];
$termini_consegna = stripslashes($rigak[termini_consegna]);
$termini_pagamento = stripslashes($rigak[termini_pagamento]);

$TOTALE_ordine = $rigak[totale_ordine];
if ($rigak[ordine_interno] != "") {
$ordine_interno = stripslashes($rigak[ordine_interno]);
}
$ordine_interno = $rigak[id];
}
$sqlj = "SELECT * FROM qui_rda WHERE id = '$id_rda_ord'";
$risultj = mysql_query($sqlj) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rigaj = mysql_fetch_array($risultj)) {
$wbs_vis = stripslashes($rigaj[wbs]);
}
$sqld = "SELECT * FROM qui_utenti WHERE user_id = '$id_utente_disp'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$nome_unita_disp = "<strong>".stripslashes($rigad[nomeunita])."</strong><br>";
$nome_unita_disp .= $rigad[indirizzo]."<br>";
$nome_unita_disp .= $rigad[cap]." ";
$nome_unita_disp .= $rigad[localita]."<br>";
$nome_unita_disp .= $rigad[nazione];
}

if ($mode == "") {

$nome_unita_rda_ins .= addslashes($nome_unita_rda)."<br>";
$data_ordine = mktime();
$data_ordine_tx = date("d/m/Y",$data_ordine);

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/report.css" />
<link rel="stylesheet" href="calendar/style.css" />
<link rel=”stylesheet” href=”css/video.css” type=”text/css” media=”screen” />
<link rel=”stylesheet” href=”css/printer.css” type=”text/css” media=”print” />
<title>Ordine Fornitore</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#lingua_scheda {
	width:723px;
	/*margin: auto;*/
	background-color: #727272;
	margin-bottom: 10px;
	color: #FFFFFF;
	height: 20px;
	text-align: right;
	padding-right: 5px;
	vertical-align: middle;
	font-weight: bold;
}
.casella_input {
	font-size: 10px;
	font-family: Arial, Helvetica, sans-serif;
}
#lingua_scheda a {
	color: #FFFFFF;
}
#main_container {
	width:723px;
	margin-bottom: 10px;
	height: 800px;
	padding-right: 5px;
}
#order_container {
	width:637px;
	height:750px;
	margin: auto;
}
.testata_logo {
	width:310px;
	padding-left:25px;
	height: 90px;
	float:left;
	text-align: left;
}
.testata_testo {
	width:300px;
	height: 90px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.riga_divisoria {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-align:left;
	margin-left:100px;
	width:622px;
	height: auto;
	float:none;
}
.cont_esterno {
	width:637px;
	height: auto;
	float:left;
}
.indirizzi {
	width:339px;
	height: auto;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.note_varie {
	width:315px;
	height: auto;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.colonnine_form {
	width:170px;
	height: 35px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}

.colliPeso {
	width:100px;
	height: 60px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	float:left;
}
.scritta_bianca {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color:#FFFFFF;
}

.testata_tab {
	width:637px;
	height: 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	float:left;
	font-weight: bold;
}
.corpo_tab {
	width:637px;
	height: auto;
	font-family: Arial, Helvetica, sans-serif;
	padding-bottom:10px;
	font-size: 12px;
	float:left;
}
.tab57 {
	width:57px;
	height: auto;
	float:left;
}
.tab69 {
	width:99px;
	height: auto;
	float:left;
}
.tab335 {
	width:250px;
	height: auto;
	float:left;
	margin-right:10px;
}
.tab48 {
	width:48px;
	height: auto;
	float:left;
	font-weight: bold;
	text-align: right;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.Stile2 {
	font-size: 18px;
	font-weight: bold;
}
.Stile3 {font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
font-weight: bold;
}
.Stile4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Stile5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.Stile6 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align:right;
}
.Stile7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-align:left;
}
.riga_finale {
	width:622px;
	height: auto;
	margin-left:100px;
	padding-top:10px;
	padding-bottom:10px;
	float:left;
	
}
.box_60{
	width:60px;
	padding-top:5px;
	height: auto;
	float:left;
}
.box_90{
	width:95px;
	padding-top:5px;
	height: auto;
	float:left;
}
.box_350{
	width:390px;
	padding-top:5px;
	height: auto;
	float:left;
}
.spaziatore{
	width:700px;
	height: 50px;
}
.riga_indirizzi{
height:100px; 
width:auto; 
margin-left:100px; 
margin-bottom:20px; 
border-bottom:1px solid rgb(230,230,230);
}

-->
</style>
	<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript">
function submitform()
{
    document.forms["form1"].submit();
}
</script>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
}
</script>
</head>
<?php
if ($mode == "print") {
echo "<body onLoad=javascript:window.print();\"refreshParent()\";>";
} else {
echo "<body>";
}
?>
<form name="form1" method="post" action="ordine_fornitore.php">
<?php
if ($mode != "print") {
echo "<div id=lingua_scheda>";
  echo "<table width=723 border=0 cellspacing=0 cellpadding=0>";
      echo "<tr>";
        echo "<td width=450 class=testo_chiudi><img src=immagini/spacer.gif width=450 height=15></td>";
        echo "<td class=Stile1 width=150>";
          echo "<div align=right>";
echo "<a href=\"javascript: submitform()\"><span class=Stile1>Salva e Stampa</span></a>";

          echo "</div>";
        echo "</td>";
        echo "<td class=Stile1 width=90>";
          echo "<div align=right>";
echo "<a href=ordine_fornitore.php?id_ord=".$id_ord."&mode=print>";
echo "<span class=Stile1>Stampa</span>";
echo "</a>";
          echo "</div>";
        echo "</td>";
        echo "<td width=30><img src=immagini/spacer.gif width=30 height=15></td>";
    echo "</tr>";
    echo "</table>  ";  
echo "</div>";
	}
        ?>
        
<div id="main_container">



<div class="spaziatore">
<img src=immagini/spacer.gif width=622 height=30>
</div>
<div style="width:auto; height:80px;">
  <div class="testata_logo" style="width:335px">
  <?php
  switch ($logo) {
	  case "sol":
	  $immagine_logo = "immagini/SOL_RGB.png";
	  break;
	  case "vivisol":
	  $immagine_logo = "immagini/vivisol_RGB.png";
	  break;
  }
  ?>
  <img src="<?php echo $immagine_logo; ?>"/>
  </div>
  <div class="indirizzi">
  <span class="Stile4"><strong>Fornitore</strong><br />
      <?php 
          if ($mode == "print") {
      echo $fornitore_disp;
      } else {
  echo "<textarea name=fornitore id=fornitore cols=25 rows=5>".stripslashes(str_replace("<br>","\n",$fornitore_disp))."</textarea>";
  }
  ?></span></div>
</div>

<div class="spaziatore">
<img src=immagini/spacer.gif width=622 height=30>
</div>
<div class="riga_divisoria" style="margin-bottom:10px;">Ordine fornitore <?php 
		//if ($mode == "print") {
		echo $ordine_interno;
	//} else {
	//echo "<input name=ordine_interno type=text id=ordine_interno  size=10 maxlength=12 value=".$ordine_interno.">";
//}
?>
  <br /><img src=immagini/spacer.gif width=622 height=10><img src="immagini/riga_prev_GREY.jpg" width="622" height="1" /></div>
<div class="riga_indirizzi">
    <div class="indirizzi Stile4" style="width:260px;">
    <strong>Committente</strong><br />
            <?php 
    //		if ($mode == "print") {
        echo "Utente: <strong>".$nome_utente_disp."</strong><br>";
        echo "Responsabile: <strong>".$nome_resp_disp."</strong><br>";
        echo "RdA: <strong>".$id_rda_ord."</strong><br>";
    //	} else {
    //	echo "Utente: <strong>".$nome_utente_rda."</strong><br>";
    //	echo "Responsabile: <strong>".$nome_resp_rda."</strong><br><br>";
    //}
    if ($wbs_vis != "") {
        echo "WBS: <strong>".$wbs_vis."</strong><br><br>";
        }
    ?>
    </div>
    <div class="indirizzi Stile4">
    <?php echo $nome_unita_disp; ?>
    </div>
</div>


<div class="riga_indirizzi" style="height:85px;">
    <div class="indirizzi" style="width:260px; height:70px;">
            <?php 
        
		//echo "Data ordine: <strong>".date ("d/m/Y",$data_ordine)."</strong><br>";
		echo "Data ordine: <strong>".$data_ordine_tx."</strong><br>";
        echo "Data consegna: <strong>";
    if ($mode == "print") {
        if ($data_consegna > 0) {
            echo date ("d/m/Y",$data_consegna);
        }
    } else {
    echo "<input name=data_consegna type=text class=casella_input id=data_consegna size=10 maxlength=10 onkeypress = \"return ctrl_decimali(event)\"  onclick=\"Calendar.show(this, '%d/%m/%Y', false)\" onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\"";
    echo " value=";
        if ($data_consegna > 0) {
            echo date ("d/m/Y",$data_consegna);
        }
    echo ">";
    }
        echo "</strong><br><br>";
    ?>
    </div>
    <div style="height:40px;" class="indirizzi Stile4">
      <div style="float:left; width:150px;">
      Termini di pagamento
      </div>
      <div style="float:left; width:180px;">
      <?php
    if ($mode == "print") {
		echo $termini_pagamento;
	} else {
     echo "<textarea name=termini_pagamento id=termini_pagamento style=\"width:210px; height:40px;\">".$termini_pagamento."</textarea>";
	}
	?>
      </div>
    </div>
    <div class="indirizzi Stile4">
      <div style="float:left; width:150px;">
      Termini di consegna
      </div>
      <div style="float:left; width:180px;">
      <?php
    if ($mode == "print") {
		echo $termini_consegna;
	} else {
     echo "<textarea name=termini_consegna id=termini_consegna style=\"width:210px; height:40px; \">".$termini_consegna."</textarea>";
	}
	?>
      </div>
    </div>
</div>





<?php
		include "query.php";
//$array_righe_vis = explode(",",$_SESSION[lista_righe]);
if ($mode == "print") {
$riepilogo = "stampa ordine fornitore (".$array_rda[0].") da buyer ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '$array_rda[0]', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}



echo "<div class=riga_divisoria style=\"margin-bottom:10px; height:auto; float:left; margin-left:0px; padding:0px;\">";



?>
<div class="riga_divisoria" style="margin-bottom:40px; float:none;"></div>
<div class="testata_tab" style="margin-left:100px;">
<div class="tab57">
Codice
</div>
<div class="tab335">
Prodotto
</div>
<div class="tab69">
Unit&agrave;
</div>
<div class="tab48">
Q.t&agrave;
</div>
<div class="tab57" style="margin-left:10px; width:62px; text-align:right;">
Prezzo
</div>
<div class="tab69" style="margin-left:15px; width:69px; text-align:right;">
Tot. parz.
</div>
</div>

<div class="riga_divisoria" style="margin-bottom:10px; float:none;">
  <img src="immagini/riga_prev_GREY.jpg" width="622" height="1" /></div>
<div class="testata_tab" style="margin-left:100px; height:480px;">
<?php
$sqleee = "SELECT * FROM qui_righe_ordini_for WHERE id_ordine_for = '$id_ord'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
echo "<div class=corpo_tab style=\"font-weight:normal;\">";
$tot = $tot + 1;
/*
echo "<div class=tab57>";
echo $rigaeee[id_rda];
echo "</div>";
echo "<div class=tab69>";
echo date("d.m.Y",$rigaeee[data_inserimento]);
echo "</div>";
*/
echo "<div class=tab57>";
if (substr($rigaeee[codice_art],0,1) != "*") {
  echo $rigaeee[codice_art];
} else {
  echo substr($rigaeee[codice_art],1);
}
echo "</div>";
echo "<div class=tab335>";
echo stripslashes($rigaeee[descrizione]);
echo "</div>";
echo "<div class=tab69>";
echo $rigaeee[nome_unita];
echo "</div>";

echo "<div class=tab48 id=q_".$tot.">";
if ($mode == "print") {
echo number_format($rigaeee[quant],0,",","");
} else {
echo "<input name=".$tot." type=text class=casella_input id=c_".$tot." size=4 maxlength=4 onkeypress = \"return ctrl_decimali(event)\" onKeyUp=\"set_quant(".$rigaeee[id].",this.value,".$tot.");\"";
echo " value=".number_format($rigaeee[quant],0,",","");
echo ">";
}
echo "</div>";

echo "<div class=tab57 style=\"margin-left:10px; width:62px; text-align:right;\">";
if ($mode == "print") {
echo number_format($rigaeee[prezzo],2,",",".");
} else {
echo "<input name=".$tot." type=text class=casella_input id=p_".$tot." size=4 maxlength=8 onkeypress = \"return ctrl_decimali(event)\" onKeyUp=\"set_prez(".$rigaeee[id].",this.value,".$tot.");\"";
echo " value=".number_format($rigaeee[prezzo],2,",","");
echo ">";
}
echo "</div>";
echo "<div class=tab69 style=\"margin-left:15px; width:69px; text-align:right;\" id=\"tot_".$rigaeee[id]."\">";
echo number_format($rigaeee[totale],2,",",".");
echo "</div>";
echo "</div>";
$TOTALE_generale = $TOTALE_generale + $rigaeee[totale];
		}
echo "<div class=riga_divisoria style=\"margin-bottom:10px; margin-left:0px;\">";
  echo "<img src=immagini/riga_prev_GREY.jpg width=622 height=1/></div>";
echo "<div class=corpo_tab>";
echo "<div class=tab57>";
echo "Totale";
echo "</div>";	
	
echo "<div class=box_350>";
echo "</div>";
echo "<div class=box_60 style=\"text-align:right; width:40px;\">";
echo "</div>";
echo "<div id=\"tot_generale\" class=box_90 style=\"text-align:right; width:70px; float:right; margin-right:20px;\">";
echo number_format($TOTALE_generale,2,",",".");
echo "</div>";
//fine singolo contenitore
echo "</div>";	
$TOTALE_ordine = "";
echo "<div class=testata_tab style=\"height:auto;\">";
	if ($mode == "print") {
	if ($note_disp != "") {
		echo "Note<br>";
		echo $note_disp;
	}
	} else {
echo "Note<br>";
echo "<textarea name=note id=note cols=60 rows=5>".str_replace("<br>","\n",$note_disp)."</textarea>";
echo "<input name=id_ord type=hidden id=id_ord value=".$id_ord." />";
echo "<input name=mode type=hidden id=mode value=print>";
echo "<input name=salvataggio type=hidden id=salvataggio value=1>";
echo "</div>";
}
echo "</div>";
?>
</div>
  
  
<div class="riga_finale">
<div class="box_90" style="width:240px; font-family: Arial, Helvetica, sans-serif; font-size: 9px;"></div>
<div class="box_90"  style="width:240px; font-family: Arial, Helvetica, sans-serif; font-size: 9px;"></div>
</div>
<div class="riga_finale">
<div class="box_90" style="width:240px; font-family: Arial, Helvetica, sans-serif; font-size: 9px;"></div>
<div class="box_90"  style="width:240px; font-family: Arial, Helvetica, sans-serif; font-size: 9px;"></div>
<div class="box_90" style="width:140px; text-align:right;">
<img src="immagini/solgroup_RGB.png"/>
</div>
</div>

</div>
</form>
<script type="text/javascript">
	function total_general(id_riga){
		/*alert('beccato');*/
								$.ajax({
										type: "GET",   
										url: "aggiorna_totale_ordine.php",
										cache: "false",   
										data: "id_riga="+id_riga,
										success: function(output) {
										$('#tot_generale').html(output).show();
								}
								})
}
function set_quant(id_riga,valoreQuant,id){
	var prezzo = document.getElementById('p_'+id).value;
	//if (valoreQuant == '' || valoreQuant == '0') {
		/*alert('#tot'+id_riga);*/
						$.ajax({
								type: "GET",   
								url: "aggiorna_avvisi_ordini.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&id="+id+"&quant="+valoreQuant+"&prezzo="+prezzo,
								success: function(output) {
								$('#tot_'+id_riga).html(output).show();
								$.ajax({
										type: "GET",   
										url: "aggiorna_totale_ordine.php",
										cache: "false",   
										data: "id_riga="+id_riga,
										success: function(output) {
										$('#tot_generale').html(output).show();
								}
								})
						}
						})
}
function set_prez(id_riga,prezzo,id){
	var valoreQuant = document.getElementById('c_'+id).value;
	if (prezzo.indexOf('.')>0) {
		alert('Non inserire il separatore delle migliaia.\nVerrà aggiunto automaticamente sulla versione stampabile del documento.');
		document.getElementById('p_'+id).value = "";
	} else {
						$.ajax({
								type: "GET",   
								url: "aggiorna_avvisi_ordini.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&id="+id+"&quant="+valoreQuant+"&prezzo="+prezzo,
								success: function(output) {
								$('#tot_'+id_riga).html(output).show();
								$.ajax({
										type: "GET",   
										url: "aggiorna_totale_ordine.php",
										cache: "false",   
										data: "id_riga="+id_riga,
										success: function(output) {
										$('#tot_generale').html(output).show();
								}
								})
						}
						})
	}
}
function ripristinaquantriga(id_riga,ord){
	var id_campo = document.getElementById('c_'+ord).value;
		

	if (id_campo == '') {
		/*alert(id_campo);*/
		//alert("<?php //echo $testo_alert; ?>");
						$.ajax({
								type: "GET",   
								url: "aggiorna_ripristinaquant_ordini.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&ord="+ord,
								success: function(output) {
								$('#q_'+ord).html(output).show();
						}
						})
	}
	}

</SCRIPT>
</body>
</html>
