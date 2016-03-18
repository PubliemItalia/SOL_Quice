<?
// a questo punto l'ultimo elemento dell'array è il messaggio
$messaggio = "prova spedizione email";
//estraggo il primo elemento dell'array che è il mittente
$mittente = "luigi@nuovatesea.it";
//il primo elemento dell'array adesso è l'oggetto
$oggetto = "1234";
//sono rimasti solo i destinatari; con il ciclo foreach mando una mail a ciascuno
//include "query.php";
print_r($_POST);
require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "smtp.fastwebnet.it";  // specify main and backup server
//$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "jswan";  // SMTP username
//$mail->Password = "secret"; // SMTP password

$mail->From = $mittente;
$mail->FromName = $username;
$dataora = mktime();
$email_operatore = "luigi.riva@dtpc.it";
$allegato = "C:\mysql_topcolor_27_May_2011_time_10_15_54.sql.gz";
$solonome_file = "/www.dtpc.it/mysql_topcolor_27_May_2011_time_10_15_54.sql.gz";
if (is_file($allegato)) {
echo "<br>File ok<br>";
}
$mail->AddAddress($email_operatore);
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio;
$mail->AltBody = "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".\nIl motivo e': ".$motivo.".\nPer maggiori dettagli guarda sul sito alla voce Telefonate. Ciao.";
//mail($email_operatore, "E' arrivata una telefonata in ufficio per te", "Alle ".$ora_chiamata." del ".$data_chiamata." ha telefonato ".$richiedente.$azienda_mail.".\nIl motivo e': ".$motivo.".\nPer maggiori dettagli guarda sul sito alla voce Telefonate. Ciao. ".$username,"From: ".$email_operatore);

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Messages have been sent";

/* Connessione al server ftp */

$ftp_host = 'ftp.dtpc.it';

$connect = ftp_connect($ftp_host) or die("Si è verificato un errore durante la connessione al server ftp");

/* login al server ftp */

$username = '1094479@aruba.it';

$pwd = '67c45a1fa5';

$login = ftp_login($connect, $username, $pwd) or die("Si è verificato un errore durante l'accesso al server ftp");

echo "login: ".$login;

/* INSERIMENTO DI UN FILE */

$destination_file = "/".$solonome_file;

$source_file = $allegato;

// attiva il modo passivo
ftp_pasv($connect, true);
echo "<br>destination_file: ".$destination_file."<br>";
echo "source_file: ".$source_file."<br>";
// trasferisce un file al server
if (ftp_put($connect, $destination_file, $source_file, FTP_BINARY)) {
 echo $solonome_file." trasferito correttamente\n";
} else {
 echo "Si e' verificato un problema durante il trasferimento di $solonome_file\n";
}
ftp_close($connect); // close the FTP stream

$pag_precedente = "../nuova_telefonata.php";
//include "../redir_neutro.php";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>