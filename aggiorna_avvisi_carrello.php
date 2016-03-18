<?php
@session_start();
$lingua = $_SESSION[lang];
$id_riga = $_GET['id_riga'];
$tot = $_GET['id'];
$quant = $_GET['quant'];
$um = $_GET['um'];
$confezione = $_GET['conf'];
$salvataggio = $_GET['salvataggio'];
switch($lingua) {
case "it":
$dic_rimuovere = "Rimuovere";
$dic_aggiorna = "Aggiorna";
$dic_salvato = "Salvato";
break;
case "en":
$dic_rimuovere = "Remove";
$dic_aggiorna = "Update";
$dic_salvato = "Saved";
break;
}
if ($salvataggio == "1") {
	$out_value = "<span style=\"color:rgb(3,173,59); font-weight:bold;\">".$dic_salvato."</span>";
}
if ($um != 'Articolo_singolo') {
  $quoziente = ceil($quant/$confezione);
  if ($quoziente == '0') {
	$quoziente = "1";
  }
  $quant_ins = $quoziente*$confezione;
  } else {
  $quant_ins = $quant;
}
include "query.php";
$querya = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_riga'";
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
$quant_DB = $row[quant];
}
if ($quant != "") {
if ($quant == "0") {
$out_value = "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><span title=\"$elimina_articolo\" style=\"color:red; font-weight:bold;\">".$dic_rimuovere."</span></a>";
	$quant_ins = "0";
} else {
if ($quant_DB != $quant) {
	$out_value = "<a href=\"javascript:void(0);\" onClick=\"total_general(".$id_riga.",".$tot.")\"><span style=\"color:rgb(3,173,59); font-weight:bold; text-decoration:none;\">".$dic_aggiorna."</span></a>";
	$quant_ins = $quant;
} else {
	$quant_ins = "";
}
}
} else {
$out_value = "";
	$quant_ins = "";
}
$query = "UPDATE qui_righe_carrelli SET quant_modifica = '$quant_ins' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

	//output finale
	
	echo $out_value;

 ?>
