<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_rda = $_GET['id_rda'];

$sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND flag_buyer != '2' AND stato_ordine = '2'";
//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num_totale_righe = mysql_num_rows($risultn);
while ($rigan = mysql_fetch_array($risultn)) {
}
$sqlp = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND flag_buyer = '1' AND stato_ordine = '2'";
//echo "<span style=\"color:rgb(0,0,0);\">".$sqln."</span><br>";
$risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$Num_righe_rda_selezionate = mysql_num_rows($risultp);
	if ($Num_righe_rda_selezionate != $num_totale_righe) {
	$tooltip_select = "Seleziona_tutto";
	$tab_output = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",1);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	} else {
	$tooltip_select = "Deseleziona_tutto";
	$tab_output = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",0);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	}

//$tab_output .= 'tot '.$num_totale_righe.'<br>';
//$tab_output .= 'sel '.$Num_righe_rda_selezionate.'<br>';


//output finale

//echo "pippo";
echo $tab_output;



 ?>
