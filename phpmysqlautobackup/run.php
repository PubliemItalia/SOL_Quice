<?php
ini_set("memory_limit","1024M");
ini_set("max_execution_time","1200"); //in secondi - imopstato a 20 minuti
include "query.php";
		$sqleee = "SELECT * FROM parametri_backup";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rowc = mysql_fetch_array($risulteee)) {
				$ultimo_backup = ($rowc [ultimo_backup]);
				$intervallo = ($rowc [intervallo_backup_automatico]);
				$intervallo_secondi = $intervallo*60;
	$mail_partenza = $rowc["mail_partenza"];
	$mail1 = $rowc["mail_destinazione1"];
	$smtp = $rowc["smtp_server"];
	$db_server = $rowc["db_server"];
	$db = $rowc["db"];
	$mysql_username = $rowc["mysql_username"];
	$mysql_password = $rowc["mysql_password"];
			}
			$timestamp_attuale = time();
			$diff = ($timestamp_attuale - $ultimo_backup);
			echo "intervallo_secondi: ".$intervallo_secondi."<br>";
			echo "diff timestamp: ".$diff."<br>";
if ($diff > $intervallo_secondi)  {

			echo "BACKUP IN ESECUZIONE<br>";
			include "runok.php";
			$timestamp_attuale = time();
include "query.php";
$queryv = "UPDATE parametri_backup SET ultimo_backup = '$timestamp_attuale', operatore_ultimo_backup = 'sistema' WHERE id = '1'";
if (mysql_query($queryv)) {
echo "MODIFICA EFFETTUATA<br>";
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//**********************************************************************
//SEZIONE SPEDIZIONE BACKUP
//**********************************************************************

$timestamp_adesso = time();
$data_backup = date("d.m.Y H:i",$timestamp_adesso);
$messaggio = "In allegato il backup del database del ".$data_backup."<br>Backup eseguito automaticamente dal sistema";
//estraggo il primo elemento dell'array che è il mittente
$mittente = $mail_partenza;
//il primo elemento dell'array adesso è l'oggetto
$oggetto = "Backup database ".$data_backup;
require("../class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();             // set mailer to use SMTP
$mail->Host = $smtp;  // specify main and backup server
//$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "youruser";  // SMTP username
//$mail->Password = "yourpass"; // SMTP password

$mail->From = $mail_partenza;
$mail->FromName = "BackupQuice";
$dataora = time();
$allegato = LOCATION."../backups/".$backup_file_name;

if (is_file($allegato)) {
}
if ($mail1 != "") {
$mail->AddAddress($mail1);
}
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio;
$mail->AltBody = "In allegato il backup del database del ".$data_backup;

if(!$mail->Send())
{
   echo "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo."<br>\n";
   exit;
}
}

echo "<br><span class=nero_grassettosx12>Il backup &egrave stato correttamente spedito all'indirizzo email: </span><span class=rosso_grassettosx12>".$mail1."</span><br>\n";

//fine routine x email

?>