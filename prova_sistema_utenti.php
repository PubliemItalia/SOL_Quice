<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlf = "SELECT user_id FROM qui_utenti";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
  $sqlg = "SELECT * FROM users_boncompagni WHERE id = '$rigaf[user_id]'";
  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $trovato = mysql_num_rows($risultg);
  if ($trovato != 0) {
	while ($rigag = mysql_fetch_array($risultg)) {
	  $query = "UPDATE qui_utenti SET login	= '$rigag[slug]', nome = '$rigag[nome]', posta  = '$rigag[posta]' WHERE user_id = '$rigag[id]'";
	  if (mysql_query($query)) {
		  echo "aggiorno riga ".$rowb[id]."<br>";
	  } else {
	  echo "Errore durante l'inserimento: ".mysql_error();
	  }
		echo "<strong>id: ".$rigag[id]." - nome: ".$rigag[nome]."</strong><br>";
	}
  }
}
?>