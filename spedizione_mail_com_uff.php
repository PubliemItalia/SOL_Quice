<?php

//echo "oggetto: ".$oggetto."<br>";
//echo $messaggio_resp."<br>";
//**********************************************************************
//SEZIONE SPEDIZIONE EMAIL
//**********************************************************************


//estraggo il primo elemento dell'array che è il mittente
$mittente = "server@sol.it";
//echo "mittente: ".$mittente."<br>";
//il primo elemento dell'array adesso è l'oggetto
//print_r($_POST);
require("PHPMailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
/*switch ($_SERVER["REMOTE_ADDR"]) {
case "10.5.0.25":
//sol interno
$mail->Host = "10.0.1.148";  // specify main and backup server
break;
case "95.252.15.147":
//aruba
$mail->Host = "smtp.sol-quice.it";  // specify main and backup server
break;
case "xxxxx":
//publiem
$mail->Host = "smtp.fastweb.it";  // specify main and backup server
break;
case "192.168.1.161":
//casa
$mail->Host = "out.aliceposta.it";  // specify main and backup server
break;

}
*/$mail->Host = "10.0.1.148";  // specify main and backup server
//$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "jswan";  // SMTP username
//$mail->Password = "secret"; // SMTP password

$mail->From = $mittente;
$mail->FromName = "Qui C'e'";
$dataora = mktime();
//$email_operatore = "luigi.riva@dtpc.it";
//$allegato = "C:\\xampp\htdocs\\topcolor\\phpmysqlautobackup\\backups\\".$backup_file_name;
//$allegato = $percorso_backup.$backup_file_name;

//echo "allegato: ".$allegato."<br>";
//$solonome_file = "/www.dtpc.it/mysql_topcolor_27_May_2011_time_10_15_54.sql.gz";
//$solonome_file = $backup_file_name;

/*if (is_file($allegato)) {
echo "<br>File ok<br>";
}
*/
if ($mail_destinatario != "") {
$mail->AddAddress($mail_destinatario);
} else {
	foreach ($array_dest_princ as $sing_dest_princ) {
$mail->AddAddress($sing_dest_princ);
	}
}

if ($mail_conoscenza != "") {
$mail->AddBcc($mail_conoscenza);
} else {
	foreach ($array_dest_sec as $sing_dest_sec) {
$mail->AddBcc($sing_dest_sec);
	}
}
$mail->AddBcc("diego.sala@publiem.it");
$mail->AddBcc("luigi.riva@publiem.it");
$mail->WordWrap = 50;  // set word wrap to 50 characters
//$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio;
$mail->AltBody = "comunicazione ufficiale Qui C'è";

//if ($mail_destinatario != "") {
if(!$mail->Send()) {
   $esito = "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo;
   $causa = $mail->ErrorInfo;
//   exit;
} else {
$esito = "<span class=nero_grassettosx12>Email correttamente inviata></span><br>";
}
/*} else {
echo $indirizzo_mancante."<br>";
echo "<input name=button type=button onClick=window.close() value=OK>";
exit;
}
*/
//inserimento in db della mail appena spedita
$data_attuale = mktime();
$messaggio_resp = addslashes($messaggio);
$queryb = "INSERT INTO qui_mail_inviate (data, mittente, destinatario, messaggio, esito, causa_fallimento) VALUES ('$data_attuale', '$mail_inviante', '$mail_destinatario', '$messaggio_resp', '$esito', '$causa')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//**************************
//fine routine x email
//**************************

?>