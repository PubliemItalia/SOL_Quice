<?php
$header .= "<tr>";
$header .= "<td>";
$header .= "Cod. utente";
$header .= "</td>";
$header .= "<td>";
$header .= "Mail";
$header .= "</td>";
$header .= "<td>";
$header .= "Nome";
$header .= "</td>";
$header .= "<td>";
$header .= "Responsabile";
$header .= "</td>";
$header .= "<td>";
$header .= "Unita";
$header .= "</td>";
$header .= "<td>";
$header .= "Nazione";
$header .= "</td>";
$header .= "</tr>";
include "query.php";

$queryv = "SELECT DISTINCT operatore FROM qui_log_utenti WHERE tabella = 'login'";
$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
  $queryx = "SELECT * FROM qui_utenti WHERE user_id = '$rowv[operatore]'";
  $resultx = mysql_query($queryx) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
  while ($rowx = mysql_fetch_array($resultx)) {
	//if ($rowx[nazione] != "Italy") {
	  $righe .= "<tr>";
	  $righe .= "<td>";
	  $righe .= $rowv[operatore];
	  $righe .= "</td>";
		$righe .= "<td>";
		$righe .= $rowx[posta];
		$righe .= "</td>";
		$righe .= "<td>";
		$righe .= $rowx[nome];
		$righe .= "</td>";
		$righe .= "<td>";
		  if ($rowx[user_id] != $rowx[idresp]) {
			$querys = "SELECT * FROM qui_utenti WHERE user_id = '$rowx[idresp]'";
			$results = mysql_query($querys) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
			while ($rows = mysql_fetch_array($results)) {
			  $righe .= $rows[nome];
			}
		  }
		$righe .= "</td>";
		$righe .= "<td>";
		$righe .= $rowx[nomeunita];
		$righe .= "</td>";
		$righe .= "<td>";
		$righe .= $rowx[nazione];
		$righe .= "</td>";
		$righe .= "</tr>";
	//}
  }
}
   $filename="Elenco_login_utenti_esteri.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<html>
<head>
  <title>Elenco login utenti esteri</title>
<meta charset="utf-8">
</head>
<body>
<table>
<?php
echo $header;
echo $righe;
?>
</table>
</body>
</html>
