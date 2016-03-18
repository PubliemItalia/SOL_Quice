<?php
session_start();
//echo '<div style="color:#000;">'.$_SESSION[nome].'</div>';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
	<link rel="stylesheet" type="text/css" href="css/jquery.powertip.css" />
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.powertip.js"></script>
	<script type="text/javascript" src="js/jquery.powertip.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
</head>

<body>
<div style="width: 960px; height: 650px; margin:auto; background-color:#ccc;">
<?php
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
include "testata_amministrazione.php";
?>
  <div style="width: 180px; height: 20px; padding: 15px 20px; float: left; color: #fff; font-weight:bold; margin: 50px 50px 0px 110px; font-family:Arial, Helvetica, sans-serif; font-size:16px; background-color:#06F;">
  	Reportistica
  </div>
  <div style="width: 180px; height: 20px; padding: 15px 20px; float: left; color: #fff; font-weight:bold; margin: 50px 50px 0px 200px; font-family:Arial, Helvetica, sans-serif; font-size:16px; background-color:#F63;">
  	Contabilit&agrave;
  </div>
<div style="width: 220px; min-height: 20px; height: auto; overflow: hidden; padding: 15px 20px; margin-left: 110px; float: left;">
  <a href="report_righe_admin.php">
    <div class="east" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Consente di cercare<br />i singoli prodotti ordinati<br />all&acute;interno delle RdA"><span style="font-size: 18px">Report righe</span><br />
      <span style="font-size:12px;"></span>
    </div>
  </a>
  <a href="report_rda.php">
    <div class="east" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Ricerca le RdA<br />create da tutti gli utenti">
      <span style="font-size:18px;">Report RdA</span><br />
      <span style="font-size:12px;"></span>
    </div>
  </a>
  <a href="lista_pl.php">
    <div class="east" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Ricerca i Packing List<br />creati dal magazzino">
      <span style="font-size:18px;">Report Packing List</span><br />
      <span style="font-size:12px;"></span>
    </div>
  </a>
  <a href="report_scorte_magazzino.php">
    <div class="east" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Gestione e controllo<br />delle scorte<br />dei prodotti a magazzino">
      <span style="font-size:18px;">Report Scorte</span><br />
        <span style="font-size: 12px"></span>
    </div>
  </a>
  <div style="width: 100%; height: auto; padding: 0px 20px; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;">
    <span style="font-size:18px;">
    </span>
  </div>
  </div>
 <div style="width: 220px; min-height: 20px; height: auto; overflow: hidden; padding: 15px 20px; margin-left:210px; float: left;">
  <a href="report_fatturazione.php?doc=G">
    <div class="west" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Ricerca e controllo<br />operazioni contabili<br />sugli acquisti delle filiali">
      <span style="font-size:18px;">Giroconto</span><br />
      <span style="font-size:12px;"></span>
    </div>
  </a>
  <a href="report_fatturazione.php?doc=F">
    <div class="west" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Ricerca e controllo<br />Fatture Sol e Vivisol<br />alle Intercompany">
      <span style="font-size:18px;">Richiesta Fattura</span><br />
      <span style="font-size:12px;"></span>
    </div>
  </a>
  <a href="ordini_sap.php">
    <div class="west" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Ricerca e controllo<br />degli ordini SOL e VIVISOL<br />ai fornitori">
      <span style="font-size:18px;">Ordini SAP</span><br />
      <span style="font-size:12px;"></span>
    </div>
  </a>
  <a href="ordini.php">
    <div class="west" style="width: 100%; height: auto; float: left; color: #000; margin: 25px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Gestione, ricerca e controllo<br />degli ordini ai fornitori">
      <span style="font-size:18px;">Ordini Fornitori</span><br />
      <span style="font-size:12px;"> </span>
    </div>
  </a>
  <a href="report_fatturazione.php?doc=R">
    <div class="west" style="width: 100%; height: auto; float: left; color: #000; margin: 50px 50px 0px 0px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" title="Gestione, ricerca e controllo<br />degli ordini ai fornitori">
      <span style="font-size:18px;">Registrazione Fattura</span><br />
      <span style="font-size:12px;"> </span>
    </div>
  </a>
  </div>
 
</div>
	<script type="text/javascript">
		$(function() {
			// placement examples
			$('.north').powerTip({ placement: 'n' });
			$('.east').powerTip({ placement: 'e' });
			$('.south').powerTip({ placement: 's' });
			$('.west').powerTip({ placement: 'w' });
			$('.north-west').powerTip({ placement: 'nw' });
			$('.north-east').powerTip({ placement: 'ne' });
			$('.south-west').powerTip({ placement: 'sw' });
			$('.south-east').powerTip({ placement: 'se' });
			$('.north-west-alt').powerTip({ placement: 'nw-alt' });
			$('.north-east-alt').powerTip({ placement: 'ne-alt' });
			$('.south-west-alt').powerTip({ placement: 'sw-alt' });
			$('.south-east-alt').powerTip({ placement: 'se-alt' });
		});
		$(function() {
			// api examples
			$('#api-open').on('click', function() {
				$.powerTip.show($('#mouseon-examples div'));
			});
			$('#api-close').on('click', function() {
				$.powerTip.hide();
			});
			$('#api-manual')
				.powerTip({
					manual: true
				})
				.on('click', function() {
					$(this).powerTip('show');
				})
				.on('mouseleave', function() {
					$(this).powerTip('hide', true);
				});
			$('#api-manual-mouse')
				.on('mouseenter', 'input', function(evt) {
					if (!$(this).data('powertip')) {
						$(this)
							.data('powertip', 'Tooltip added: ' + (new Date()))
							.powerTip({
								manual: true
							});
					}
					$(this).powerTip('show', evt);
				})
				.on('mouseleave', 'input', function() {
					$(this).powerTip('hide');
				});
		});
	</script>
</body>
</html>