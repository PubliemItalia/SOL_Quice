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
<html>
<head>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="calendar/calendar.js"></script>

<link rel="stylesheet" href="calendar/style.css" />
</head>
<body>
<div class="barra_sup">
<?php
  echo "<a href=report_righe_admin.php>";
	if ($file_presente == "report_righe_admin.php") {
	  echo "<div class=cella_menu style=\"font-weight:bold;\">";
	 } else {
	  echo "<div class=cella_menu>";
	}
	  if ($vis_report == "1") {
		echo "Report righe";
	  }
	echo "</div>";
  echo "</a>";
  echo "<a href=report_rda.php>";
	if ($file_presente == "report_rda.php") {
	  echo "<div class=cella_menu style=\"font-weight:bold;\">";
	 } else {
	  echo "<div class=cella_menu>";
	}
	  if ($vis_report == "1") {
		  echo "Report RdA";
	  }
	echo "</div>";
  echo "</a>";
  echo "<a href=report_prodotti.php>";
	if ($file_presente == "report_prodotti.php") {
	  echo "<div class=cella_menu style=\"font-weight:bold;\">";
	 } else {
	  echo "<div class=cella_menu>";
	}
		if ($vis_giacenze == "1") {
			echo "Gestione scorte";
		}
	  echo "</div>";
  echo "</a>";
  echo "<div class=cella_menu style=\"cursor:pointer; float:right;\" onClick=\"window.close();\">";
	echo "Torna al Qui C&acute;&egrave;";
  echo "</div>";
?>
</div>
</body>
</html>