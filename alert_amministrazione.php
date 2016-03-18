<?php
if ($_GET[id_prod] != "") {
$id_prod = $_GET[id_prod];
} else {
$id_prod = $_POST[id_prod];
}
if ($_GET[negozio_prod] != "") {
$negozio_prod = $_GET[negozio_prod];
} else {
$negozio_prod = $_POST[negozio_prod];
}
if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
}

$avviso = $_GET[avviso];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
<style type="text/css">
<!--
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
.Stile2 {
	font-family: Arial, Helvetica, sans-serif;
	color: #33CCFF;
	font-weight: bold;
}
.Stile3 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.Stile4 {
	font-family: Arial, Helvetica, sans-serif;
	color: #FF9900;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
</head>

<body>
<div style="width:500px; height:300px; margin:auto; text-align:center; font-family:Arial; color:red; font-size:18px; font-weight:bold;">
<?php echo $avviso; ?>
</div>
</body>
</html>
