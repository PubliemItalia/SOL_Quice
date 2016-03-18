  <?php
    $querym = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '4' ORDER BY data_ultima_modifica ASC";
	$resultm = mysql_query($querym);
	$righe_evase = mysql_num_rows($resultm);
	while ($rowm = mysql_fetch_array($resultm)) {
	  $data_ultima_modifica = $rowm[data_ultima_modifica];
	  if ($rowm[data_chiusura] > 0) {
			$data_chiusura = $rowm[data_chiusura];
	  }
	}
    $queryn = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY data_ultima_modifica DESC";
	$resultn = mysql_query($queryn);
	$righe_totali_rda = mysql_num_rows($resultn);
	  echo "<div style=\"width:90%; height:auto; float:left;\">";
       echo "<span class=noteRda>".date("d.m.Y - H:i:s",$data_inserimento)." - ".stripslashes($nome_utente)." - ".$testo_info_utente_rda."</span>";
	  echo "</div>"; 
	  echo "<div style=\"width:90%; height:auto; float:left;\">";
if ($data_approvazione > 0) {
       echo "<span class=noteRda>".date("d.m.Y - H:i:s",$data_approvazione)." - ".stripslashes($nome_resp)." - ".$testo_info_resp_rda."</span>";
	  } else {
if ($id_utente_rda == $id_resp_rda) {
       echo "<span class=noteRda>".date("d.m.Y - H:i:s",$data_inserimento)." - ".stripslashes($nome_utente)." - ".$testo_info_resp_rda."</span>";
	}
}
	  echo "</div>"; 
if ($data_output > 0) {
	  echo "<div style=\"width:90%; height:auto; float:left;\">";
       echo "<span class=noteRda>".date("d.m.Y - H:i:s",$data_output)." - ".stripslashes($nome_buyer)."</span>";
	  echo "</div>"; 
}
//if (count($array_ordini) > 0) {
  foreach($array_ordini as $sing_ordine) {
	$queryb = "SELECT * FROM qui_ordini_for WHERE id = '$sing_ordine'";
	$resultb = mysql_query($queryb);
	while ($rowb = mysql_fetch_array($resultb)) {
	  echo "<div style=\"width:90%; height:auto; float:left; margin-bottom:15px;\">";
	 echo "<span class=noteRda>Ordine n. ".$sing_ordine." del ".date("d/m/Y",$rowb[data_ordine])."</span>";
	  echo "</div>"; 
	}
  }
//}

if ($righe_totali_rda == $righe_evase) {
	if ($data_chiusura > 0) {
		$data_finale = $data_chiusura;
	} else {
		$data_finale = $data_ultima_modifica;
	}
	  echo "<div style=\"width:90%; height:auto; float:left; margin-bottom:15px;\">";
       echo "<span class=noteRda>".date("d.m.Y - H:i:s",$data_finale)." - ".$rda_chiusa."</span>";
	  echo "</div>"; 
} else {
	  echo "<div style=\"width:90%; height:auto; float:left; margin-bottom:15px;\">";
       echo "<span class=noteRda>".$rda_attesa_chiusura."</span>";
	  echo "</div>"; 
}
?>
