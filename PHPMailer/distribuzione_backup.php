<?php
include "query.php";
$queryc = "SELECT * FROM parametri_backup ORDER BY id DESC LIMIT 1";
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$mail_partenza = $rowc[mail_partenza];
$smtp_server = $rowc[smtp_server];
$mail_destinazione1 = $rowc[mail_destinazione1];
$mail_destinazione2 = $rowc[mail_destinazione2];
$ftp_host = $rowc[ftp_host];
$ftp_user = $rowc[ftp_user];
$ftp_pwd = $rowc[ftp_pwd];
$cartella_remota = $rowc[cartella_remota];
}
echo "mail_partenza: ".$mail_partenza."<br>";
echo "smtp_server: ".$smtp_server."<br>";
echo "mail_destinazione1: ".$mail_destinazione1."<br>";
echo "mail_destinazione2: ".$mail_destinazione2."<br>";
echo "ftp_host: ".$ftp_host."<br>";
echo "ftp_user: ".$ftp_user."<br>";
echo "ftp_pwd: ".$ftp_pwd."<br>";
echo "cartella_remota: ".$cartella_remota."<br>";

$data_backup = date("d.m.Y H:i",mktime());
// a questo punto l'ultimo elemento dell'array è il messaggio
$messaggio = "In allegato il backup del database del ".$data_backup;
//estraggo il primo elemento dell'array che è il mittente
$mittente = "luigi@nuovatesea.it";
//il primo elemento dell'array adesso è l'oggetto
$oggetto = "1234";
//sono rimasti solo i destinatari; con il ciclo foreach mando una mail a ciascuno
//include "query.php";
print_r($_POST);
require("PHPMailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = $ftp_host;  // specify main and backup server
//$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "jswan";  // SMTP username
//$mail->Password = "secret"; // SMTP password

$mail->From = $mail_partenza;
$mail->FromName = $mail_partenza;
$dataora = mktime();
$allegato = "phpmysqlautobackup/backups/".$backup_file_name;
echo "allegato: ".$allegato."<br>";
$solonome_file = "/www.dtpc.it/".$backup_file_name;
//$solonome_file = "/".$cartella_remota."/".$backup_file_name;
echo "cartella remota: ".$cartella_remota."<br>";
if (is_file($allegato)) {
echo "<br>File ok<br>";
}
$mail->AddAddress($mail_destinazione1);
//$mail->AddAddress($mail_destinazione2);
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio;
//$mail->AltBody = "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".\nIl motivo e': ".$motivo.".\nPer maggiori dettagli guarda sul sito alla voce Telefonate. Ciao.";
//mail($email_operatore, "E' arrivata una telefonata in ufficio per te", "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".\nIl motivo e': ".$motivo.".\nPer maggiori dettagli guarda sul sito alla voce Telefonate. Ciao. ".$username,"From: ".$email_operatore);

if(!$mail->Send()) {
   echo "Il messaggio non pu&ograve; essere spedito. <p>";
   echo "Errore durante la spedizione del messaggio: " . $mail->ErrorInfo;
   exit;
}

echo "Messaggio inviato";

/* Connessione al server ftp */

//$ftp_host = 'ftp.dtpc.it';

$connect = ftp_connect($ftp_host) or die("Si è verificato un errore durante la connessione al server ftp<br>");

/* login al server ftp */


$login = ftp_login($connect, $ftp_user, $ftp_pwd) or die("Si è verificato un errore durante l'accesso al server ftp<br>");

echo "login: ".$login;

/* INSERIMENTO DI UN FILE */

$destination_file = "/".$solonome_file;

$source_file = $allegato;
echo "<br>destination_file: ".$destination_file."<br>";
echo "source_file: ".$source_file."<br>";

// attiva il modo passivo
ftp_pasv($connect, true);
// trasferisce un file al server
if (ftp_put($connect, $destination_file, $source_file, FTP_BINARY)) {
 echo $solonome_file." trasferito correttamente<br>";
} else {
 echo "Si e' verificato un problema durante il trasferimento di $solonome_file<br>";
}
ftp_close($connect); // close the FTP stream

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>