<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
if ($_GET['unita'] != "") {
  $a = "id_unita = '$_GET[unita]'";
  $clausole++;
}
if ($_GET['societa'] != "") {
  $b = "azienda_prodotto = '$_GET[societa]'";
  $clausole++;
}
if ($_GET['shop'] != "") {
  $c = "negozio = '$_GET[shop]'";
  $clausole++;
}

/*
*/
$output .= '<select name="categoria_righe" class="codice_lista_nopadding" id="categoria_righe" style="height:27px; width: 90%;" onchange="agg_tendina_unita_categ(this.value)">
	<option selected value="">Categoria prodotto</option>';
	if ($clausole > 0) {
	  $sqlr = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3') AND ";
	  if ($clausole == 1) {
		if ($a != "") {
		$sqlr .= $a;
		}
		if ($b != "") {
		$sqlr .= $b;
		}
		if ($c != "") {
		$sqlr .= $c;
		}
	  } else {
		if ($a != "") {
		$sqlr .= $a." AND ";
		}
		if ($b != "") {
		$sqlr .= $b." AND ";
		}
		if ($c != "") {
		$sqlr .= $c." AND ";
		}
	  }
	} else {
	  $sqlr = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine BETWEEN '2' AND '3')";
	}
	$lung = strlen($sqlr);
	$finale = substr($sqlr,($lung-5),5);
	if ($finale == " AND ") {
	$sqlr = substr($sqlr,0,($lung-5));
	}
	  $sqlr .= " ORDER BY categoria ASC";
	  $output .= $sqlr;
	$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
	while ($rigar = mysql_fetch_array($risultr)) {
		$output .= '<option value="'.$rigar[categoria].'">'.str_replace("_"," ",$rigar[categoria]).'</option>';
	}
  $output .= "</select>";
/*
*/
//output finale
echo $output;
//echo "ciao";

