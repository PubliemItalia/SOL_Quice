<?php
$sqlx = "SELECT * FROM qui_buyer_funzioni WHERE user_id = '$_SESSION[user_id]'";
$risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
while($rigax = mysql_fetch_array($risultx)) {
  $vis_report = $rigax[F_report];
  $vis_fatturazione = $rigax[F_fatturazione];
  $vis_gestione = $rigax[F_gestione];
  $vis_magazzino = $rigax[F_magazzino];
  $vis_admin = $rigax[F_amm_prodotti];
  $vis_ordini = $rigax[F_amm_ordini];
  $vis_giacenze = $rigax[F_amm_giacenze];
}
?>
<div class="barra_sup">
<?php
  echo "<a href=report_fatturazione.php>";
	if ($file_presente == "report_fatturazione.php") {
	  echo "<div class=cella_menu style=\"font-weight:bold;\">";
	 } else {
	  echo "<div class=cella_menu>";
	}
	  if ($vis_fatturazione == "1") {
		echo "Report PL";
	  }
	echo "</div>";
  echo "</a>";
  echo "<a href=ordini.php>";
	if ($file_presente == "ordini.php") {
	  echo "<div class=cella_menu style=\"font-weight:bold;\">";
	 } else {
	  echo "<div class=cella_menu>";
	}
	  if ($vis_ordini == "1") {
		  echo "Ordini";
	  }
	echo "</div>";
  echo "</a>";
  echo "<a href=ordini_sap.php>";
	if ($file_presente == "ordini_sap.php") {
	  echo "<div class=cella_menu style=\"font-weight:bold;\">";
	 } else {
	  echo "<div class=cella_menu>";
	}
	  if ($vis_ordini == "1") {
		  echo "Ordini SAP";
	  }
	echo "</div>";
  echo "</a>";
  echo "<div class=cella_menu style=\"cursor:pointer; float:right;\" onClick=\"window.close();\">";
	echo "Torna al Qui C&acute;&egrave;";
  echo "</div>";
?>
</div>