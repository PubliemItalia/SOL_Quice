<?php
include "query.php";
$id_riga = $_GET['id_riga'];
$id = $_GET['id'];
$ord = $_GET['ord'];
 $querya = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_riga'";
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
$quant_DB = $row[quant];
}

$out_value .= "<input name=".$ord." type=text class=casella_input id=c_".$ord." size=4 maxlength=4 onkeypress = \"return ctrl_solo_num(event);\" onKeyUp=\"axc(".$id_riga.",this.value,".$ord.");\" onBlur=\"ripristinaquantriga(".$id_riga.",".$ord.")\" value=".number_format($quant_DB,0,",","").">";
	//output finale
	
	echo $out_value;

 ?>
