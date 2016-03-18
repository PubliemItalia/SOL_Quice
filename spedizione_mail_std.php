<?php
$mittente = "server@sol.it";
require("PHPMailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "10.0.1.148";  // specify main and backup server

$mail->From = $mittente;
$mail->FromName = "Qui c'e' - admin";
$dataora = mktime();
//$mail->AddAddress($mail_destinatario);
$mail->AddAddress("luigi.riva@dtpc.it");
$mail->AddBcc("diego.sala@publiem.it");
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
//$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $corpo_messaggio;
$mail->AltBody = $bodyalt;

//if ($mail_destinatario != "") {
if(!$mail->Send()) {
   echo "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo;
   $causa = $mail->ErrorInfo;
$esito = "NO";
//   exit;
} else {
$esito = "OK";
//echo "<span class=nero_grassettosx12>Email correttamente inviata></span><br>";
}
//inserimento in db della mail appena spedita
$data_attuale = mktime();
$corpo_messaggio = addslashes($corpo_messaggio);
$queryb = "INSERT INTO qui_mail_inviate (data, mittente, destinatario, messaggio, esito, causa_fallimento) VALUES ('$data_attuale', '$mail_inviante', '$mail_destinatario', '$corpo_messaggio', '$esito', '$causa')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//**************************
//fine routine x email
//**************************

?>