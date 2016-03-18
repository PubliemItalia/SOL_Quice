<?php
include "query.php";
$id_riga = $_GET['id_riga'];
$tot = $_GET['id'];

$out_value = "<input name=".$tot." type=text class=casella_input id=".$tot." size=4 maxlength=4 onkeypress = \"return ctrl_solo_num(event)\" onKeyUp=\"axc(".$id_riga.",this.value,this.id);\" value=1>";

	//output finale
	
	
	
	
	echo $out_value;

 ?>
