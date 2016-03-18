<?php
include "query.php";
$id_riga = $_GET['id_riga'];
$tot = $_GET['id'];
$querya = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_riga'";
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
}

$out_value = "<input name=".$tot." type=text class=casella_input id=".$tot." size=4 maxlength=4 onkeypress = \"return ctrl_solo_num(event)\" onKeyUp=\"axc(".$id_riga.",this.value,this.id);\" value=1>";

	//output finale
	
	
	
	
	echo $out_value;

 ?>
