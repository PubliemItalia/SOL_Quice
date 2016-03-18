<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
<style type="text/css">
<!--
.zona1 {
	background-color: #d29f9b;
}
.zona2 {
	background-color: #62c1d3;
}
.zona3 {
	background-color: #7d84b0;
}
.zona4 {
	background-color: #beb481;
}
.zona5 {
	background-color: #7ac9ac;
}
.colonna_costi {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	width: 45px;
	height:auto;
	padding: 5px 0px;
	/*border-bottom:1px solid black;*/
	text-align:center;
	float:left;
}
-->
</style>

</head>

<body>
<div style="width:100%; height:100%; margin:auto;">
  <div style="width:320px; height:440;float:left;">
  <?php
echo '<div style="width:auto; height:auto; font-family: Arial; font-size:18; font-weight:bold; margin:20px 0px 20px 20px;">';
echo 'Prospetto dei costi indicativi<br>delle spedizioni di merci<br>nei paesi europei';
  echo '</div>';
  include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$queryh = "SELECT * FROM qui_costi_spedizioni ORDER BY peso ASC";
$resulth = mysql_query($queryh);
while ($rowh = mysql_fetch_array($resulth)) {
echo '<div style="width:auto; height:27px;">';
  echo '<div class="colonna_costi">';
	echo $rowh[peso];
  echo '</div>';
  echo '<div class="colonna_costi zona1">';
	echo $rowh[zona1];
  echo '</div>';
  echo '<div class="colonna_costi zona2">';
	echo $rowh[zona2];
  echo '</div>';
  echo '<div class="colonna_costi zona3">';
	echo $rowh[zona3];
  echo '</div>';
  echo '<div class="colonna_costi zona4">';
	echo $rowh[zona4];
  echo '</div>';
  echo '<div class="colonna_costi zona5">';
	echo $rowh[zona5];
  echo '</div>';
echo '</div>';
}

  ?>
  </div>
 <div style="width:580px; height:440; overflow:hidden; float:left;">
  <img src="immagini/europa_SOL.png"/>
  </div>
</div>
</body>
</html>