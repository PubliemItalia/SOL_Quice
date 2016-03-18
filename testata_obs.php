<?php
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
$lingua = $_SESSION[lang];
echo "lingua: ".$lingua."<br>";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="tabelle.css" rel="stylesheet" type="text/css">
<style>
html{
	font-family: Arial;
	font-size: 11px;
}
li{
	list-style: none;
	/*width: 100px;*/
}
a{
	text-decoration: none;
} 

.voce_top_menu{
	float: left;
	padding: 7px 0 7px 7px;
	font-size: 12px;
	font-weight: bold;
	color: #fff;
	width: 100px;
	border-right: 1px solid #fff;
}
.select_market {
	font-weight: bold;
	padding: 7px;
	float:right;
	color: #FFED00;
}

#wrap {
	width:960px;
	margin: auto;	
}
#testa{
	color: #000;
	height: 85px;
	/*margin-bottom: 150px;*/
	background: #FFFFFF;
	overflow: inherit;
}
#menu{
	color: #000;
	height: 30px;
	/*margin-bottom: 150px;*/
	background: #008DD2;
}
.menu_markets li{
	color: #000;
}

#test{
	height: 140px;
}
/*JS Style*/
.col{
	width: 150px;
	float: left;
}
.show{
	margin-top: 30px;
	position: absolute;
	clear: both;
	z-index: 5;
	width: 960px;
	height: 140px;
	background: #d9dada;
}
.show ul{
	margin-left: -30px;
}
.show ul li{
	margin-top:5px;
}
.show ul li a{
	font-size: 12px;
	font-weight: bold;
	color: #000;
}
.hide{
	display:none;
}
</style>
  <SCRIPT type="text/javascript">
function aggiorna(){
document.form_lingua.submit();
}
</SCRIPT>
<script type="text/javascript">
	var asset = document.getElementById('asset');
	var consumable = document.getElementById('consumable');
	var spareParts = document.getElementById('spareParts')

	asset.className = 'hide';
	consumable.className = 'hide';
	spareParts.className = 'hide';

	function visualizza(mercato){
		asset.className = mercato == 'asset' ? 'show' : 'hide';
		consumable.className = mercato == 'consumable' ? 'show' : 'hide';
		spareParts.className = mercato == 'spareParts'?' show' : 'hide';
	}
	function nascondi(){
		asset.className = 'hide';
		consumable.className = 'hide';
		spareParts.className = 'hide';
	}
</script>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<div id="wrap">
<div id="testa">
<table width="956" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="126" height="64"><img src="immagini/quice_logo.jpg" width="99" height="78"></td>
    <td width="218" class="tabelle" >User login<br /><?php echo "<strong>".$_SESSION[nome]."</strong><br>".$_SESSION[nomeunita]; ?></td>
    <td width="385">&nbsp;</td>
    <td width="227">
    <form id="form_lingua" name="form_lingua" method="post" action="ricerca_prodotti.php">
  
  <select name="lang" class="ecoformdestra" id="lang" onChange="aggiorna()">
<?php
$sqlx = "SELECT * FROM lingue WHERE idioma = '$lingua'";
$risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigax = mysql_fetch_array($risultx)) {
if ($rigax[lang] == $_SESSION[lang]) {
echo "<option selected value=".$rigax[lang].">".$rigax[desc]."</option>";
} else {
echo "<option value=".$rigax[lang].">".$rigax[desc]."</option>";
}
}
?>
  </select>
  <input name="mod_lang" type="hidden" id="mod_lang" value="1" />
  <input name="page" type="hidden" id="page" value="<?php echo $page; ?>" />
  <input name="limit" type="hidden" id="limit" value="<?php echo $limit; ?>" />
    </form>
</td>
  </tr>
</table>
</div>
	<div id="menu">

	  <a class="voce_top_menu" href="ricerca_prodotti.php?negozio=assets" onMouseOver="visualizza('asset');" onMouseOut="nascondi();">Asset</a>
	  <a class="voce_top_menu" href="ricerca_prodotti.php?negozio=consumables" onMouseOver="visualizza('consumable');" onMouseOut="nascondi();">Consumable</a>
	  <a class="voce_top_menu" href="ricerca_prodotti.php?negozio=spareparts" onMouseOver="visualizza('spareParts');" onMouseOut="nascondi();">Spare Parts</a>
		<a class="voce_top_menu" href="#">vivistore</a>
		<a class="voce_top_menu" href="#">MedDevice</a>
		<a class="voce_top_menu" href="#">Search</a>
		<a class="select_market" href="#">Scegli il tuo negozio</a>

		<div id="asset" onMouseOver="visualizza('asset')" onMouseOut="nascondi('asset')">
        
			<div class="col">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  
  </tr>
</table>
    <td width="150"><table width=150 border=0 cellspacing=0 cellpadding=0>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="150">&nbsp;</td>
    <td width="150">&nbsp;</td>
    <td width="150">&nbsp;</td>
<ul>
					<li><a href="#">Cylinder</a></li>
					<li><a href="#">Valve</a></li>
					<li><a href="#">Cap</a></li>
					<li><a href="#">Pescanti</a></li>
					<li><a href="#">Accessori</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 1-->
			<div class="col">
				<ul>
					<li><a href="#">Cylinder pack</a></li>
					<li><a href="#">Hard baske</a></li>
					<li><a href="#">tank</a></li>
					<li><a href="#">Steamer</a></li>
					<li><a href="#">Tank cylinder</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 2-->
			<div class="col">
				<ul>
					<li><a href="#">Dewar</a></li>
					<li><a href="#">Base unit</a></li>
					<li><a href="#">Portable unit</a></li>
					<li><a href="#">Forklift</a></li>
					<li><a href="#">Forniture</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 3-->
		</div><!--END ASSET-->

		<div id="consumable" onMouseOver="visualizza('consumable')" onMouseOut="nascondi()">
			<div class="col">

				<ul>
					<li><a href="#">Ufficio e archivio</a></li>
					<li><a href="#">Carta, buste e penne</a></li>
					<li><a href="#">Accessori</a></li>
					<li><a href="#">Etichette ADR-CLP</a></li>
					<li><a href="#">Sanificazioni ViviSol</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 1-->
			<div class="col">
				<ul>
					<li><a href="#">Etichette di sicurezza</a></li>
					<li><a href="#">Macchine ufficio</a></li>
					<li><a href="#">Prodotti promozionali</a></li>
					<li><a href="#">Ricambi</a></li>
					<li><a href="#">Pubblicazioni</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 2-->
			<div class="col">
				<ul>
					<li><a href="#">Servizi generali</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 2-->
		</div><!--END ASSET-->

		<div id="spareParts" onMouseOver="visualizza('spareParts')" onMouseOut="nascondi()">
			<div class="col">
				<ul>
					<li><a href="#">Cylinder</a></li>
					<li><a href="#">Valve</a></li>
					<li><a href="#">Cap</a></li>
					<li><a href="#">Pescanti</a></li>
					<li><a href="#">Accessori</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 1-->
			<div class="col">
				<ul>
					<li><a href="#">Cylinder pack</a></li>
					<li><a href="#">Hard baske</a></li>
					<li><a href="#">tank</a></li>
					<li><a href="#">Steamer</a></li>
					<li><a href="#">Tank cylinder</a></li>
					<!--INSERIMENTO FUNZIONE PHP PER LETTURA DELLE VOCI-->
				</ul>
			</div><!--END COL 2-->
		</div><!--END ASSET-->

	</div><!--END MENU-->
	<div id="test" style="">content here</div>
	<!---->
</div>

<!--END WRAP-->



</body>
</html>
