<?php
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
$messaggio_resp=leggifile("quice_email_fatt_template.html");

//$messaggio_resp = str_replace("#Invoice_information#","RdA ".$n_rda,$messaggio_resp);
//$messaggio_resp = str_replace("#Invoice_detail#","Messaggio",$messaggio_resp);


$messaggio_resp = str_replace("#PL_number:#","Ordine SAP",$messaggio_resp);
$messaggio_resp = str_replace("numero_PL",$n_ord,$messaggio_resp);
$messaggio_resp = str_replace("#PL_date:#","Data",$messaggio_resp);
//$messaggio_resp = str_replace("#E-mail_utente:#",$testo_mail_utente,$messaggio_resp);
//$messaggio_resp = str_replace("#E-mail_responsabile:#",$testo_mail_responsabile,$messaggio_resp);
//$messaggio_resp = str_replace("#Indirizzo_filiale:#",$testo_mail_indirizzo_filiale,$messaggio_resp);
$messaggio_resp = str_replace("data_PL",date("d.m.Y", mktime()),$messaggio_resp);
//$messaggio_resp = str_replace("negozio_PL",$negozio_rda,$messaggio_resp);
//$messaggio_resp = str_replace("indirizzo_unita",$unita_rda,$messaggio_resp);
$gestione_rda = "report_fatturazione.php?doc=R";

$messaggio_resp = str_replace("report_fatturazione.php",$gestione_rda,$messaggio_resp);

//conclusione template x mail
$tx_html .= "</body>";
$tx_html .= "</html>";

//accodamento parte dinamica tabellina righe rda
$messaggio_resp .= $tx_html;

$oggetto = "Qui C'e' Ordine SAP ".$n_ord;
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
$mail->FromName = "Qui C'e' Ordini SAP";
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
$mail->AddAddress($mail_destinatario);
//$mail->AddAddress("luigi.riva@dtpc.it");
//$mail->AddAddress("c.cavenago@sol.it");
//$mail->AddBcc("diego.sala@publiem.it");
//$mail->AddBcc("luigi.riva@dtpc.it");
$mail->WordWrap = 50;  // set word wrap to 50 characters
//$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio_resp;
$mail->AltBody = "Invio Ordine SAP ".$id;

//if ($mail_destinatario != "") {
if(!$mail->Send()) {
   //echo "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo;
   $causa = $mail->ErrorInfo;
$esito = "NO";
//   exit;
} else {
$esito = "OK";
//echo "<span class=nero_grassettosx12>Email correttamente inviata></span><br>";
}
/*} else {
echo $indirizzo_mancante."<br>";
echo "<input name=button type=button onClick=window.close() value=OK>";
exit;
}
*/
//inserimento in db della mail appena spedita
$data_attuale = mktime();
$messaggio_resp = addslashes($messaggio_resp);
/*$queryb = "INSERT INTO qui_mail_inviate (data, mittente, destinatario, messaggio, esito, causa_fallimento) VALUES ('$data_attuale', '$mail_inviante', '$mail_destinatario', '$messaggio_resp', '$esito', '$causa')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
*///**************************
//fine routine x email
//**************************

?>