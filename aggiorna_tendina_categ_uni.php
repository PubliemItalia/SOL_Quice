<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$unita = $_GET['unita'];
$shop = $_GET['shop'];
$soloshop = $_GET['soloshop'];
			

    if ($soloshop == "") {
	  $output .= '<select name="categoria_righe" class="codice_lista_nopadding" id="categoria_righe" style="height:27px; width: 90%;">
		<option selected value="">Categoria prodotto</option>';
    if ($shop == "") {
	  $sqlr = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE id_unita = '$unita' ORDER BY categoria ASC";
	} else {
	  $sqlr = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE id_unita = '$unita' AND negozio = '$shop' ORDER BY categoria ASC";
	}
	} else {
	  $output .= '<select name="categoria_righe" class="codice_lista_nopadding" id="categoria_righe" style="height:27px; width: 90%;" onchange="agg_tendina_unita_categ(this.value)">
		<option selected value="">Categoria prodotto</option>';
	  $sqlr = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE negozio = '$shop' ORDER BY categoria ASC";
	}
	$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
	while ($rigar = mysql_fetch_array($risultr)) {
	  if ($rigar[categoria] != "") {
		if ($rigar[categoria] == $categ_rdaDaModulo) {
		  $output .= '<option selected value="'.$rigar[categoria].'">'.str_replace("_"," ",$rigar[categoria]).'</option>';
		} else {
		  $output .= '<option value="'.$rigar[categoria].'">'.str_replace("_"," ",$rigar[categoria]).'</option>';
		}
	  }
	}

  $output .= '</select>';
/*
*/
//output finale
echo $output;
//echo "ciao";

