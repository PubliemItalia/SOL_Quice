<?php
session_start();
///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
$lingua = $_SESSION[lang];
$id_carrello = $_SESSION[carrello];
$negozio = $_SESSION[negozio];
$id_utente = $_SESSION[user_id];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqld = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND attivo = '1'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
$num_carrelli = mysql_num_rows($risultd);
//echo "num_carrelli: ".$num_carrelli."<br>";
//c'è un carello attivo
if ($num_carrelli > 0) {
while ($rigad = mysql_fetch_array($risultd)) {
$id_carrello = $rigad[id];
$negozio_carrello = $rigad[negozio];
}
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' AND cancellato = '0'";
$result = mysql_query($querya);
$elementi_in_carrello = mysql_num_rows($result);
}
include "traduzioni_interfaccia.php";
?>
          <a href="carrello.php?negozio=carrello&id_cart=<?php echo $id_carrello; ?>">
            <?php
              if ($elementi_in_carrello > 0) {
              if ($elementi_in_carrello == 1) {
                  echo $elementi_in_carrello." ".$testo_prodotto."<br>";
              } 
              else {
                  echo $elementi_in_carrello." ".$testo_prodotti."<br>";
              }
                	echo "<strong>".$testo_carrello."</strong>";
              } 
              else{
                echo "<br><strong>".$testo_carrello_vuoto."</strong>";
              }
            ?>
          </a>