<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_prodotti_assets WHERE categoria1_it = 'Bombole' ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$prezzo_attuale_bombola = $rigaz[prezzo];
$id_riga = $rigaz[id];
				//recupero informazioni valvola
				if ($rigaz[id_valvola] != "Senza_valvola") {
		$sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigaz[id_valvola]'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigam = mysql_fetch_array($risultm)) {
			$prezzo_valvola = $rigam[prezzo];
		}
				}
				//recupero informazioni cappellotto
				if ($rigaz[id_cappellotto] != "") {
		$sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigaz[id_cappellotto]'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigan = mysql_fetch_array($risultn)) {
			$prezzo_cappellotto = $rigan[prezzo];
		}
				}
				//recupero informazioni pescante
		if ($rigak[id_pescante] == "SI") {
			$prezzo_pescante = "5.00";
		}
		$prezzo_giusto_bombola = $prezzo_attuale_bombola - $prezzo_cappellotto - $prezzo_valvola - $prezzo_pescante;
echo "prezzi: ".$prezzo_attuale_bombola." - ".$prezzo_giusto_bombola."<br>";
$sqlq = "UPDATE qui_prodotti_assets SET prezzo = '$prezzo_giusto_bombola', codice_originale_duplicato = '$prezzo_attuale_bombola' WHERE id = '$id_riga'";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
if (mysql_query($risultq)) {
} else {
//echo "Errore durante la modifica". mysql_error()."<br>";
}
$prezzo_attuale_bombola = "";
$prezzo_cappellotto = "";
$prezzo_valvola = "";
$prezzo_pescante = "";
$prezzo_giusto_bombola = "";
}
?>