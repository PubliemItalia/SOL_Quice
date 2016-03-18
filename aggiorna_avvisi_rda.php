<?php
session_start();
$id_riga = $_GET['id_riga'];
$tot = $_GET['id'];
$quant = $_GET['quant'];
$salvataggio = $_GET['salvataggio'];
if ($salvataggio == "1") {
	$out_value = '<span style="color:green;">Salvato</span>';
}
include "query.php";
$querya = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$n_rda = $row[id_rda];
$data_leggibile = date("d.m.Y",$row[data]);
$quant_DB = $row[quant];
}
if ($quant != "") {
if ($quant == "0") {
$out_value = "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$id_riga."&id_rda=".$n_rda."&id_utente=".$_SESSION[user_id]."&lang=".$_SESSION[lang]."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><span title=\"$elimina_articolo\" style=\"color:red;\">Rimuovere</span></a>";
	$quant_ins = "0";
} else {
if ($quant_DB != $quant) {
	echo '<a href="javascript:void(0);" onClick="total_general('.$id_riga.','.$tot.')"><span style="color:green;text-decoration:none;">Aggiorna</span></a>';
	$quant_ins = $quant;
} else {
	$quant_ins = "";
}
}
} else {
$out_value = "";
	$quant_ins = "";
}
$query = "UPDATE qui_righe_rda SET quant_modifica = '$quant' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

	//output finale
	
	echo $out_value;

 ?>
