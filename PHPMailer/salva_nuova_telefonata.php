<?
include "validation.php";
$ruolo=$_SESSION['ruolo'];
$username=$_SESSION['username'];
$cod_cli = $_POST['cod_cli'];
$azienda = $_POST['azienda'];
$indirizzo = $_POST['indirizzo'];
$citta = $_POST['citta'];
$telefono = $_POST['telefono'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$persona_richiesta = $_POST['persona_richiesta'];
$motivo = $_POST['motivo'];
$cosa_fare = $_POST['cosa_fare'];
$priorita = $_POST['priorita'];
$dataora = mktime();
include "query.php";
$sql = "SELECT * FROM ".$prefix."utenti WHERE user_name = '$persona_richiesta'";
$risultpub = mysql_query($sql) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigapub = mysql_fetch_array($risultpub)) {
$email_operatore = $rigapub[email];
}
if ($cod_cli != "") {
$sqla = "SELECT * FROM ".$prefix."clienti WHERE cod_cli = '$cod_cli'";
$risulta = mysql_query($sqla) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaa = mysql_fetch_array($risulta)) {
$ragione_sociale = $rigaa[ragione_sociale];
}
$richiedente = $ragione_sociale;
}else {
$richiedente = $_POST['richiedente'];

}
$query = "INSERT INTO ".$prefix."telefonate (operatore, telef_timestamp, indirizzo, richiedente, citta, telefono, fax, email, az_richiedente, motivo, persona_richiesta, priorita, cosa_fare, vista) VALUES ('$username', '$dataora', '$indirizzo', '$richiedente', '$citta', '$telefono', '$fax', '$email', '$azienda', '$motivo', '$persona_richiesta', '$priorita', '$cosa_fare', 'NO')";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

if ($azienda != "") {
$azienda_mail = " della ditta ".$azienda;
}
$data_chiamata = date("d.m.Y",$dataora);
$ora_chiamata = date("H.i",$dataora);

require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.lm-net.it";  // specify main and backup server
//$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "jswan";  // SMTP username
//$mail->Password = "secret"; // SMTP password

$mail->From = "assistenza@onewayshop.it";
$mail->FromName = $username;
$mail->AddAddress($email_operatore);
//$mail->AddAddress("ellen@example.com");                  // name is optional
//$mail->AddReplyTo("info@example.com", "Information");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "E' arrivata una telefonata in ufficio per te";
$mail->Body    = "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".<br>Il motivo e': ".$motivo.".<br>Per maggiori dettagli guarda sul sito alla voce Telefonate. Ciao.";
$mail->AltBody = "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".\nIl motivo e': ".$motivo.".\nPer maggiori dettagli guarda sul sito alla voce Telefonate. Ciao.";
//mail($email_operatore, "E' arrivata una telefonata in ufficio per te", "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".\nIl motivo e': ".$motivo.".\nPer maggiori dettagli guarda sul sito alla voce Telefonate. Ciao. ".$username,"From: ".$email_operatore);

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
include "../redir_telefonate.htm";
?>
<html>
<head>
  <title>Registrazione nuova telefonata</title>
</head>
</html>