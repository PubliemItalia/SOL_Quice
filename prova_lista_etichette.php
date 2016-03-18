<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestione etichette</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: Arial;
}
</style>
 <script type="text/javascript" src="jquery-1.6.2.min.js"></script>
</head>

<body>
<?php
include "query.php";
if ($_GET['categoria1'] != "") {
$categoria1 = $_GET['categoria1'];
} 

if ($_GET['categoria2'] != "") {
$categoria2 = $_GET['categoria2'];
} 

if ($_GET['categoria3'] != "") {
$categoria3 = $_GET['categoria3'];
} 

if ($_GET['categoria4'] != "") {
$categoria4 = $_GET['categoria4'];
} 

if ($_GET['paese'] != "") {
$paese = $_GET['paese'];	
} 
if ($_GET['extra'] != "") {
$extra = $_GET['extra'];	
} 
if ($categoria2 != "") {
$c = "categoria2_it = '$categoria2'";
$clausole++;
}
if ($categoria1 != "") {
$e = "categoria1_it = '$categoria1'";
$_SESSION[categoria1] = $categoria1;
$clausole++;
}
if ($categoria3 != "") {
$f = "categoria3_it = '$categoria3'";
$_SESSION[categoria3] = $categoria3;
$clausole++;
}
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$h = "(paese = '$paese' OR prodotto_multilingue LIKE '%$paese%')";
$clausole++;
}
$blocco_opz_categ1 .= '<option selected value="">Scegli</option>';
$sql1 = "SELECT DISTINCT categoria1_it FROM qui_prodotti_labels WHERE obsoleto = '0' ORDER BY categoria1_it ASC";
$result1 = mysql_query($sql1);
while ($row1 = mysql_fetch_array($result1)) {
	if ($row1[categoria1_it] == $categoria1) {
	  $blocco_opz_categ1 .= '<option selected value="'.$row1[categoria1_it].'">'.$row1[categoria1_it].'</option>';
	} else {
	  $blocco_opz_categ1 .= '<option value="'.$row1[categoria1_it].'">'.$row1[categoria1_it].'</option>';
	}
}
$blocco_opz_categ2 .= '<option selected value="">Scegli</option>';
$sql2 = "SELECT DISTINCT categoria2_it FROM qui_prodotti_labels WHERE obsoleto = '0' ORDER BY categoria2_it ASC";
$result2 = mysql_query($sql2);
while ($row2 = mysql_fetch_array($result2)) {
	if ($row2[categoria2_it] == $categoria2) {
	  $blocco_opz_categ2 .= '<option selected value="'.$row2[categoria2_it].'">'.$row2[categoria2_it].'</option>';
	} else {
	  $blocco_opz_categ2 .= '<option value="'.$row2[categoria2_it].'">'.$row2[categoria2_it].'</option>';
	}
}
$blocco_opz_categ3 .= '<option selected value="">Scegli</option>';
$sql3 = "SELECT DISTINCT categoria3_it FROM qui_prodotti_labels WHERE obsoleto = '0' ORDER BY categoria3_it ASC";
$result3 = mysql_query($sql3);
while ($row3 = mysql_fetch_array($result3)) {
	if ($row3[categoria3_it] == $categoria3) {
	  $blocco_opz_categ3 .= '<option selected value="'.$row3[categoria3_it].'">'.$row3[categoria3_it].'</option>';
	} else {
	  $blocco_opz_categ3 .= '<option value="'.$row3[categoria3_it].'">'.$row3[categoria3_it].'</option>';
	}
}
$blocco_opz_extra .= '<option selected value="">Scegli</option>';
$sql4 = "SELECT DISTINCT tipologia FROM qui_pharma_quant_prezzi ORDER BY tipologia ASC";
$result4 = mysql_query($sql4);
while ($row4 = mysql_fetch_array($result4)) {
	if ($row4[tipologia] == $extra) {
	  $blocco_opz_extra .= '<option selected value="'.$row4[tipologia].'">'.$row4[tipologia].'</option>';
	} else {
	  $blocco_opz_extra .= '<option value="'.$row4[tipologia].'">'.$row4[tipologia].'</option>';
	}
}


$testoQuery = "SELECT * FROM qui_prodotti_labels WHERE obsoleto = '0' AND ";
if ($clausole > 0) {
if ($clausole == 1) {
if ($c != "") {
$testoQuery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
}
if ($g != "") {
$testoQuery .= $g;
}
if ($h != "") {
$testoQuery .= $h;
}
} else {
if ($c != "") {
$testoQuery .= $c." AND ";
}
if ($d != "") {
$testoQuery.= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h;
}
}
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}
echo '<div style="width:800px; min-height:50px; overflow: hidden; height:auto; margin-bottom: 20px; padding: 10px;">
<form action="" method="get">
  <div style="float:left; width:100px; height:50px; border-bottom: 1px solid #666; text-align:left;"><strong>Categoria 1</strong><br /><select name="categoria1" style="width: 90px; height: 20px;">'.$blocco_opz_categ1.'</select></div>
  <div style="float:left; width:100px; height:50px; border-bottom: 1px solid #666; text-align:left;"><strong>Categoria 2</strong><br /><select name="categoria2" style="width: 90px; height: 20px;">'.$blocco_opz_categ2.'</select></div>
  <div style="float:left; width:100px; height:50px; border-bottom: 1px solid #666; text-align:left;"><strong>Categoria 3</strong><br /><select name="categoria3" style="width: 90px; height: 20px;">'.$blocco_opz_categ3.'</select></div>
  <div style="float:left; width:100px; height:50px; border-bottom: 1px solid #666; text-align:left;"><strong>Extra</strong><br /><select name="extra" style="width: 90px; height: 20px;">'.$blocco_opz_extra.'</select></div>
  <div style="float:left; width:100px; height:50px; border-bottom: 1px solid #666; text-align:left;"><input name="Submit" type="submit" value="Ricerca" /></div>
  <div style="float:left; width:100px; height:50px; border-bottom: 1px solid #666; text-align:left;"><input name="Reset" type="reset" value="Reset" /></div>
</form>
</div>';
$resultb = mysql_query($testoQuery);
while ($rowb = mysql_fetch_array($resultb)) {
  echo '<div id="'.$rowb[id].'" style="width:800px; border-bottom: 1px solid #666; min-height:180px; overflow: hidden; height:auto; padding: 10px; margin-bottom: 10px;">
  <div style="float:left; width:200px; min-height:170px; overflow: hidden; height:auto; text-align:left;">'.
	$rowb[descrizione1_it].' - <i>'.$rowb[codice_art].'</i><br /><strong>'.$rowb[extra].'</strong><br>Prezzo <i>'.number_format($rowb[prezzo],2,",",".").'</i><br /><span style="color: red;">'.strtoupper($rowb[ric_mag]).'</span>';
	if ($rowb[extra] != "") {
	  if ($rowb[ric_mag] == "mag") {
		  echo '<span style="color:#ccc;">';
	  }
		$querys = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$rowb[extra]' ORDER BY quant ASC";
		$results = mysql_query($querys);
		while ($rows = mysql_fetch_array($results)) {
			echo '<br>'.$rows[quant].' - '.$rows[prezzo];
		}
	  if ($rowb[ric_mag] == "mag") {
		  echo '</span>';
	  }
	}
  echo '</div>
  <div style="float:left; width:170px; min-height:170px; overflow: hidden; height:auto; text-align:center;"><img src="files/'.$rowb[foto].'" width="162" height="162" /></div>
  <div style="float:left; width:200px; min-height:170px; overflow: hidden; height:auto; text-align:left;"><strong>Codice Extra</strong><br /><input id="codice_'.$rowb[id].'" name="codice_'.$rowb[id].'" type="text" value="'.$rowb[extra].'" onKeyUp="aggiorna_codice(codice_'.$rowb[id].','.$rowb[id].');" onblur="modifica_ricmag(0,0,'.$rowb[id].');" /><br><br>
  <strong>Richiesta/Magazzino</strong><br />
  <select name="ricmag" style="width: 90px; height: 20px;" onchange="modifica_ricmag(this.value,1,'.$rowb[id].')">';
  switch ($rowb[ric_mag]) {
  case "":
  echo '<option selected value="">Scegli</option>
  <option value="RIC">Richiesta</option>
  <option value="mag">Magazzino</option>';
  break;
  case "RIC":
  echo '<option value="">Scegli</option>
  <option selected value="RIC">Richiesta</option>
  <option value="mag">Magazzino</option>';
  break;
  case "mag":
  echo '<option value="">Scegli</option>
  <option value="RIC">Richiesta</option>
  <option selected value="mag">Magazzino</option>';
  break;
  }
  echo '</select><br><br>
  <strong>Prezzo</strong><br /><input id="prezzo_'.$rowb[id].'" name="prezzo_'.$rowb[id].'" type="text" value="'.str_replace(".",",",$rowb[prezzo]).'" onKeyUp="aggiorna_prezzo(prezzo_'.$rowb[id].','.$rowb[id].');" onblur="modifica_ricmag(0,0,'.$rowb[id].');" />
  </div>
  </div>';
}


?>
<script type="text/javascript">
function aggiorna_codice(id_codice,id) {
var tx_testo = id_codice.value.replace(/\r?\n/g, '<br>');
				/*alert(tx_testo);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_extra.php",   
						data: "testo="+tx_testo+"&id="+id,
						success: function(output) {
						$('#aaa').html(output).show();
						}
						});
}

function aggiorna_prezzo(id_prezzo,id) {
var tx_testo = id_prezzo.value.replace(/\r?\n/g, '<br>');
				/*alert(tx_testo);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_prezzo_labels.php",   
						data: "testo="+tx_testo+"&id="+id,
						success: function(output) {
						$('#aaa').html(output).show();
						}
						});
}
function modifica_ricmag(rm,mode,id) {
				/*alert(rm);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_ricmag.php",   
						data: "rm="+rm+"&mode="+mode+"&id="+id,
						success: function(output) {
						$('#'+id).html(output).show();
						}
						});
}
</SCRIPT>
</body>
</html>
