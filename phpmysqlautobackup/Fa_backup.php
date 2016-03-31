<?php
include "query.php";
function has_data($value)
{
 if (is_array($value)) return (sizeof($value) > 0)? true : false;
 else return (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) ? true : false;
}

$phpMySQLAutoBackup_version="1.5.0";
$db_server = "localhost"; // your MySQL server - localhost will normally suffice
$db = "topcolor"; // your MySQL database name
$mysql_username = "root";  // your MySQL username
$mysql_password = "luigi";  // your MySQL password

$from_emailaddress = "";// your email address to show who the email is from (should be different $to_emailaddress)
$to_emailaddress = ""; // your email address to send backup files to
                       //best to specify an email address on a different server than the MySQL db  ;-)

//interval between backups - stops malicious attempts at bringing down your server by making multiple requests to run the backup
$time_internal=3600;// 3600 = one hour - only allow the backup to run once each hour
// Turn off all error reporting
error_reporting(0);

//DEBUGGING section - for debugging uncomment 2 lines below:
error_reporting(E_ALL);
$time_internal=30;// 30 = seconds - only allow backup to run once each 30 seconds



$save_backup_zip_file_to_server = 1; // if set to 1 then the backup files will be saved in the folder: /phpMySQLAutoBackup/backups/
                                    //(you must also chmod this folder for write access to allow for file creation)

$newline="\r\n"; //email attachment - if backup file is included within email body then change this to "\n"


$limit_to=10000000; //total rows to export - IF YOU ARE NOT SURE LEAVE AS IS
$limit_from=0; //record number to start from - IF YOU ARE NOT SURE LEAVE AS IS
//the above variables are used in this formnat:
//  SELECT * FROM tablename LIMIT $limit_from , $limit_to

// No more changes required below here
// ---------------------------------------------------------
define('LOCATION', dirname(__FILE__) ."/files/");
if(($db=="")OR($mysql_username=="")OR($mysql_password==""))
{
 echo "Configure your installation BEFORE running, add your details to the file /phpmysqlautobackup/run.php";
 exit;
}
$backup_type="\n\n BACKUP Type: Full database backup (all tables included)\n\n";
if (isset($table_select))
{
 $backup_type="\n\n BACKUP Type: partial, includes tables:\n";
 foreach ($table_select as $key => $value) $backup_type.= "  $value;\n";
}
if (isset($table_exclude))
{
 $backup_type="\n\n BACKUP Type: partial, EXCLUDES tables:\n";
 foreach ($table_exclude as $key => $value) $backup_type.= "  $value;\n";
}

//costruzione backup
$link = mysql_connect($db_server,$mysql_username,$mysql_password);
if ($link) mysql_select_db($db);
if (mysql_error()) exit(mysql_error($link));
//add new phpmysqlautobackup table if not there...
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'phpmysqlautobackup' "))==0)
{
   $query = "
    CREATE TABLE phpmysqlautobackup (
    id int(11) NOT NULL,
    version varchar(6) default NULL,
    time_last_run int(11) NOT NULL,
    PRIMARY KEY (id)
    ) TYPE=MyISAM;";
   $result=mysql_query($query);
   $query="INSERT INTO phpmysqlautobackup (id, version, time_last_run)
             VALUES ('1', '$phpMySQLAutoBackup_version', '0');";
   $result=mysql_query($query);
}
//check time last run - to prevent malicious over-load attempts
$query="SELECT * from phpmysqlautobackup WHERE id=1 LIMIT 1 ;";
$result=mysql_query($query);
$row=mysql_fetch_array($result);
if (time() < ($row['time_last_run']+$time_internal)) exit();// exit if already run within last time_interval
//update version number if not already done so
if ($row['version']!=$phpMySQLAutoBackup_version) mysql_query("update phpmysqlautobackup set version='$phpMySQLAutoBackup_version'");
////////////////////////////////////////////////////////////////////////////////////

$query="UPDATE phpmysqlautobackup SET time_last_run = '".time()."' WHERE id=1 LIMIT 1 ;";
$result=mysql_query($query);

if (!isset($table_select))
{
  $t_query = mysql_query('show tables');
  $i=0;
  $table="";
  while ($tables = mysql_fetch_array($t_query, MYSQL_ASSOC) )
        {
         list(,$table) = each($tables);
         $exclude_this_table = isset($table_exclude)? in_array($table, $table_exclude) : false;
         if(!$exclude_this_table) $table_select[$i]=$table;
         $i++;
        }
}

$thedomain = $_SERVER['HTTP_HOST'];
if (substr($thedomain,0,4)=="www.") $thedomain=substr($thedomain,4,strlen($thedomain));

$buffer = '# MySQL backup created by phpMySQLAutoBackup - Version: '.$phpMySQLAutoBackup_version . "\n" .
          '# ' . "\n" .
          '# http://www.dwalker.co.uk/phpmysqlautobackup/' . "\n" .
          '#' . "\n" .
          '# Database: '. $db . "\n" .
          '# Domain name: ' . $thedomain . "\n" .
          '# (c)' . date('Y') . ' ' . $thedomain . "\n" .
          '#' . "\n" .
          '# Backup START time: ' . strftime("%H:%M:%S",time()) . "\n".
          '# Backup END time: #phpmysqlautobackup-endtime#' . "\n".
          '# Backup Date: ' . strftime("%d %b %Y",time()) . "\n";$i=0;
foreach ($table_select as $table)
        {
          $i++;
          $export = "\n" .'drop table if exists `' . $table . '`;' . "\n";

          //export the structure
          $query='SHOW CREATE TABLE `' . $table . '`';
          $rows_query = mysql_query($query);
          $tables = mysql_fetch_array($rows_query);
          $export.= $tables[1] ."; \n";

          $table_list = array();
          $fields_query = mysql_query('show fields from  `' . $table . '`');
          while ($fields = mysql_fetch_array($fields_query))
           {
            $table_list[] = $fields['Field'];
           }

          $buffer.=$export;
          // dump the data
          $query='select * from `' . $table . '` LIMIT '. $limit_from .', '. $limit_to.' ';
          $rows_query = mysql_query($query);
          while ($rows = mysql_fetch_array($rows_query)) {
            $export = 'insert into `' . $table . '` (`' . implode('`, `', $table_list) . '`) values (';
            reset($table_list);
            while (list(,$i) = each($table_list)) {
              if (!isset($rows[$i])) {
                $export .= 'NULL, ';
              } elseif (has_data($rows[$i])) {
                $row = addslashes($rows[$i]);
                $row = str_replace("\n#", "\n".'\#', $row);

                $export .= '\'' . $row . '\', ';
              } else {
                $export .= '\'\', ';
              }
            }
            $export = substr($export,0,-2) . "); \n";
            $buffer.= $export;
          }
        }
mysql_close();
$buffer = str_replace('#phpmysqlautobackup-endtime#', strftime("%H:%M:%S",time()), $buffer);
//fine costruzione backup

$from_emailaddress = "luigi@nuovatesea.it";
$to_emailaddress = "luigi.riva@dtpc.it";
// zip the backup and email it
$backup_file_name = 'mysql_'.$db.strftime("_%d_%b_%Y_time_%H_%M_%S.sql",time()).'.gz';
$dump_buffer = gzencode($buffer);
//if ($from_emailaddress>"") xmail($to_emailaddress,$from_emailaddress, "phpMySQLAutoBackup: $backup_file_name", $dump_buffer, $backup_file_name, $backup_type, $newline, $phpMySQLAutoBackup_version);
//if ($save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);
 //$backup_file_name = 'mysql_'.$db.strftime("_%d_%b_%Y_time_%H_%M_%S.sql",time()).'.sql';
$dump_buffer = $buffer;
 $fp = fopen(LOCATION."../backups/".$backup_file_name, "w");
 fwrite($fp, $dump_buffer);
 fclose($fp);
 //check folder is protected - stop HTTP access
 if (!file_exists(".htaccess"))
 {
  $fp = fopen(LOCATION."../backups/.htaccess", "w");
  fwrite($fp, "deny from all");
  fclose($fp);
 }
$pag_precedente = "../PHPMailer/distribuzione_backup.php";
include "../redir_neutro.php";

//FTP backup file to remote server
if (isset($ftp_username))
{
 //write the backup file to local server ready for transfer if not already done so
 if (!$save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);
 $transfer_backup = new transfer_backup();
 $transfer_backup->transfer_data($ftp_username,$ftp_password,$ftp_server,$ftp_path,$backup_file_name);
 if (!$save_backup_zip_file_to_server) unlink(LOCATION."../backups/".$backup_file_name);
}
 ?>
