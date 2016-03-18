<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id = $_GET['id'];
$rm = $_GET['rm'];
$mode = $_GET['mode'];
/*
$tab_output = '<span style="color:#000">
id: '.$id.'<br>
rm: '.$rm.'<br>
modea: '.$mode.'<br>
</span>';
*/
if ($mode == 1) {
  $query = "UPDATE qui_prodotti_labels SET ric_mag = '$rm' WHERE id = '$id'";
  if (mysql_query($query)) {
  } else {
  $tab_output .= "Errore durante l'inserimento: ".mysql_error();
  }	
}
$testoQuery = "SELECT * FROM qui_prodotti_labels WHERE id = '$id'";
$resultb = mysql_query($testoQuery);
while ($rowb = mysql_fetch_array($resultb)) {
  $tab_output .= '<div style="float:left; width:200px; min-height:170px; overflow: hidden; height:auto; text-align:left;">'.
	$rowb[descrizione1_it].' - <i>'.$rowb[codice_art].'</i><br /><strong>'.$rowb[extra].'</strong><br>Prezzo <i>'.number_format($rowb[prezzo],2,",",".").'</i><br /><span style="color: red;">'.strtoupper($rowb[ric_mag]).'</span>';
	if ($rowb[extra] != "") {
	  if ($rowb[ric_mag] == "mag") {
		  $tab_output .= '<span style="color:#ccc;">';
	  }
		$querys = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$rowb[extra]' ORDER BY quant ASC";
		$results = mysql_query($querys);
		while ($rows = mysql_fetch_array($results)) {
			$tab_output .= '<br>'.$rows[quant].' - '.$rows[prezzo];
		}
	  if ($rowb[ric_mag] == "mag") {
		  $tab_output .= '</span>';
	  }
	}
  $tab_output .= '</div>
  <div style="float:left; width:170px; min-height:170px; overflow: hidden; height:auto; text-align:center;"><img src="files/'.$rowb[foto].'" width="162" height="162" /></div>
  <div style="float:left; width:200px; min-height:170px; overflow: hidden; height:auto; text-align:left;"><strong>Codice Extra</strong><br /><input id="codice_'.$rowb[id].'" name="codice_'.$rowb[id].'" type="text" value="'.$rowb[extra].'" onKeyUp="aggiorna_codice(codice_'.$rowb[id].','.$rowb[id].');" onblur="modifica_ricmag(0,0,'.$rowb[id].');" /><br><br>
  <strong>Richiesta/Magazzino</strong><br />
  <select name="ricmag" style="width: 90px; height: 20px;" onchange="modifica_ricmag(this.value,1,'.$rowb[id].')">';
  switch ($rowb[ric_mag]) {
  case "":
  $tab_output .= '<option selected value="">Scegli</option>
  <option value="RIC">Richiesta</option>
  <option value="mag">Magazzino</option>';
  break;
  case "RIC":
  $tab_output .= '<option value="">Scegli</option>
  <option selected value="RIC">Richiesta</option>
  <option value="mag">Magazzino</option>';
  break;
  case "mag":
  $tab_output .= '<option value="">Scegli</option>
  <option value="RIC">Richiesta</option>
  <option selected value="mag">Magazzino</option>';
  break;
  }
  $tab_output .= '</select><br><br>
  <strong>Prezzo</strong><br /><input id="prezzo_'.$rowb[id].'" name="prezzo_'.$rowb[id].'" type="text" value="'.str_replace(".",",",$rowb[prezzo]).'" onKeyUp="aggiorna_prezzo(prezzo_'.$rowb[id].','.$rowb[id].');" onblur="modifica_ricmag(0,0,'.$rowb[id].');" />
  </div>';
}


//output finale
echo $tab_output;
 ?>
