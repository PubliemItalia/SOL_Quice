<?php
session_start();
$val_rda = $_GET['val_rda'];
if ($val_rda != "") {
$tab_output .= '<div style="width: 100%; background-color:#00b2ff; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="ricerca_rda('.$val_rda.')">
			Ricerca RdA
		  </div>';
} else {
$tab_output .= '<div style="width: 100%; background-color:#06F; color:#fff; padding:7px 0px; text-align: center; font-size: 12px; font-weight: bold; cursor:pointer; margin-bottom:5px;" onclick="document.form_filtri2.submit();">
			Applica filtri
		  </div>';
}

//output finale
echo $tab_output;
 ?>