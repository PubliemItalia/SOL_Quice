<?php
//include "query.php";
//mysql_set_charset("utf8"); //settare la codifica della connessione al db

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
</head>

<body>
<div id="switch2438" style="background-color:#000; color:#fff; cursor:pointer; width:1200px; height:30px; margin:auto;" onclick="mostra_nascondi(2438)">PL 2438</div>
<div id="pl2438" style="width:1200px; height:700px; margin:auto; display:none;"><iframe src="http://10.171.1.176/quice_staging/lista_pl.php?nr_pl=2438" width="1100" height="600"></iframe></div>
</body>
<script type="text/javascript">
function mostra_nascondi(id) {
	/*alert(id);*/
	//$("#test"+id).click(function () {
   $('#pl'+id).slideToggle(1000);
//});
}
function vis_invis(id_riga)  {
	/*alert(id_riga);*/
                if ($('#pl'+id_riga).css('display')=='none'){
                    $('#pl'+id_riga).css('display', 'block');
                } else {
                    $('#pl'+id_riga).css('display', 'none');
                }
 }
</script>

</html>