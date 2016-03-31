<?php
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '1024M');
/*******************************************************************************************
    phpMySQLAutoBackup  -  Author:  http://www.DWalker.co.uk - released under GPL License
           For support and help please try the forum at: http://www.dwalker.co.uk/forum/
********************************************************************************************
Version    Date              Comment
0.2.0      7th July 2005     GPL release
0.3.0      June 2006  Upgrade - added ability to backup separate tables
0.4.0      Dec 2006   removed bugs/improved code
1.4.0      Dec 2007   improved faster version
1.5.0      Dec 2008   improved and added FTP backup to remote site
********************************************************************************************/
$phpMySQLAutoBackup_version="1.5.0";
// ---------------------------------------------------------
// you must add your details below:       
//$db_server = "localhost"; // your MySQL server - localhost will normally suffice
//$db = "ted"; // your MySQL database name
//$mysql_username = "root_user";  // your MySQL username
//$mysql_password = "4ng3l0n3";  // your MySQL password

$from_emailaddress = "server@sol.it";// your email address to show who the email is from (should be different $to_emailaddress)
$to_emailaddress = "luigi.riva@dtpc.it"; // your email address to send backup files to
                       //best to specify an email address on a different server than the MySQL db  ;-)

//interval between backups - stops malicious attempts at bringing down your server by making multiple requests to run the backup
$time_internal=3;// 3600 = one hour - only allow the backup to run once each hour
// Turn off all error reporting
error_reporting(0);

//DEBUGGING section - for debugging uncomment 2 lines below:
error_reporting(E_ALL);
$time_internal=3;// 30 = seconds - only allow backup to run once each 30 seconds

/****************************************************************************************
The settings below are for the more the more advanced user  - in the majority of cases no changes will be required below. */


//FTP settings - uses CURL so your webhost where you run this must support PHP CURL
//when the 4 lines below are uncommented will attempt to push the compressed backup file to the remote site ($ftp_server)
//$ftp_username=""; // your ftp username
//$ftp_password=""; // your ftp password
//$ftp_server=""; // eg. ftp.yourdomainname.com
//$ftp_path="/public_html/"; // can be just "/" or "/public_html/securefoldername/"


$save_backup_zip_file_to_server = 1; // if set to 1 then the backup files will be saved in the folder: /phpMySQLAutoBackup/backups/
                                    //(you must also chmod this folder for write access to allow for file creation)

$newline="\r\n"; //email attachment - if backup file is included within email body then change this to "\n"


// Below you can uncomment the variables to specify separate tables to backup,
// leave commented out and ALL tables will be included in the backup.
//$table_select[0]="MyFirstTableName";
//$table_select[1]="mySecondTableName";
//$table_select[2]="myThirdTableName";
//note: when you uncomment $table_select only the named tables will be backed up.

// Below you can uncomment the variables to specify separate tables to EXCLUDE from the TOTAL backup,
// leave commented out and ALL tables will be included in the backup.
//$table_exclude[0]="FirstTableName-to-exclude";
//$table_exclude[1]="SecondTableName-to-exclude";
//$table_exclude[2]="ThirdTableName-to-exclude";
//note: when you uncomment $table_exclude these tables will be excluded from your backed up.

$limit_to=10000000; //total rows to export - IF YOU ARE NOT SURE LEAVE AS IS
$limit_from=0; //record number to start from - IF YOU ARE NOT SURE LEAVE AS IS
//the above variables are used in this formnat:
//  SELECT * FROM tablename LIMIT $limit_from , $limit_to

// No more changes required below here
// ---------------------------------------------------------
define('LOCATION', dirname(__FILE__) ."/files/");
include(LOCATION."phpmysqlautobackup.php");
?>
