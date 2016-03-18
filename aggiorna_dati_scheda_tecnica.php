<?php
$id = $_GET[id];
$negozio = $_GET[shop];
$tipo_immagine = $_GET[tipo_immagine];
$discr_eliminazione = $_GET[eliminazione];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($row = mysql_fetch_array($result)) {
	if ($row[filepath] != "") {
	  if ($row[filepath] == "eliminare") {
	  $scheda = "";
	  } else {
	  $scheda = $row[filepath];
	  }
	} else {
	  $scheda = $row[percorso_pdf];
	}
//fine while
}
switch ($tipo_immagine) {
case "1":
  $div_scheda .= "<div class=etichetta style=\"float:none; width:100%;\">";
	if ($scheda != "") {
	  $div_scheda .= $scheda;
	} else {
	  $div_scheda .= "Scheda tecnica mancante";
	}
  $div_scheda .= "</div>";
  $div_scheda .= "<div class=etichetta>";
  $div_scheda .= "<input type=button name=button id=button value=\"Carica/Modifica\" onClick=\"TINY.box.show({iframe:'gestione_scheda_tecnica.php?mode=mod&id_prod=".$id."&negozio_prod=".$negozio."',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS3(0)}});\" style=\"cursor:pointer;\">";
  $div_scheda .= "</div>";
break;
case "2":
	  if ($scheda != "") {
		$div_scheda .= "<a href=documenti/".$scheda." target=_blank>";
		$div_scheda .= "<span class=pulsante_scheda>Scheda tecnica</span>";
		$div_scheda .= "</a>";
	  }
break;
}
	//output finale
	echo $div_scheda;
?>
