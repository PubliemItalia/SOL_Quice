<?php
session_start();
$check = $_GET['check'];
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];

  switch ($check) {
	case "2":
	  $tooltip_select = "Seleziona tutto";
	  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",4);\"><img src=immagini/select-none.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	break;
	case "4":
	  $tooltip_select = "Deseleziona tutto";
	  $bottone_immagine = "<a href=\"javascript:void(0);\" onclick=\"axc_multi(".$id_rda.",2);\"><img src=immagini/select-all.png width=17 height=17 border=0 title=".$tooltip_select."></a>";
	break;
  }
$tab_output .= $bottone_immagine;

//output finale
echo $tab_output;

//echo "pippo";



 ?>
