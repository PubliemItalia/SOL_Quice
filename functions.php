<?php
//funzioni utilizzate per tutto il software
function levapar($stringa) {
$stringa = str_replace("\n","<br>",$stringa);
$stringa = str_replace("\r","<br>",$stringa);
$stringa = str_replace("<br><br>","<br>",$stringa);
$stringa = str_replace("É","&Eacute;",$stringa);
$stringa = str_replace("È","&Egrave;",$stringa);
$stringa = str_replace("Ì","&Igrave;",$stringa);
$stringa = str_replace("Í","&Iacute;",$stringa);
$stringa = str_replace("Ò","&Ograve;",$stringa);
$stringa = str_replace("Ó","&Oacute;",$stringa);
$stringa = str_replace("Ù","&Ugrave;",$stringa);
$stringa = str_replace("Ú","&Uacute;",$stringa);
$stringa = str_replace("À","&Agrave;",$stringa);
$stringa = str_replace("Á","&Aacute;",$stringa);
$stringa = str_replace("è","&egrave;",$stringa);
$stringa = str_replace("é","&eacute;",$stringa);
$stringa = str_replace("à","&agrave;",$stringa);
$stringa = str_replace("á","&aacute;",$stringa);
$stringa = str_replace("ò","&ograve;",$stringa);
$stringa = str_replace("ó","&oacute;",$stringa);
$stringa = str_replace("ì","&igrave;",$stringa);
$stringa = str_replace("í","&iacute;",$stringa);
$stringa = str_replace("ù","&ugrave;",$stringa);
$stringa = str_replace("ú","&uacute;",$stringa);
$stringa = str_replace("'","&acute;",$stringa);
$stringa = str_replace("’","&rsquo;",$stringa);
$stringa = str_replace("°","&deg;",$stringa);
//$stringa = str_replace("&","&amp;",$stringa);
$stringa = str_replace("\"","&quot;",$stringa);
$stringa = str_replace("«","&laquo;",$stringa);
$stringa = str_replace("»","&raquo;",$stringa);
$stringa = str_replace("€","&euro;",$stringa);
$stringa = str_replace(";;",";",$stringa);
$stringa = addslashes($stringa);
return $stringa;
}
function levapar2($stringa) {
$stringa = str_replace("<br>","\n",$stringa);
$stringa = str_replace("<br>","\r",$stringa);
$stringa = str_replace("<br>","<br><br>",$stringa);
$stringa = str_replace("&Eacute;","É",$stringa);
$stringa = str_replace("&Egrave;","È",$stringa);
$stringa = str_replace("&Igrave;","Ì",$stringa);
$stringa = str_replace("&Iacute;","Í",$stringa);
$stringa = str_replace("&Ograve;","Ò",$stringa);
$stringa = str_replace("&Oacute;","Ó",$stringa);
$stringa = str_replace("&Ugrave;","Ù",$stringa);
$stringa = str_replace("&Uacute;","Ú",$stringa);
$stringa = str_replace("&Agrave;","À",$stringa);
$stringa = str_replace("&Aacute;","Á",$stringa);
$stringa = str_replace("&egrave;","è",$stringa);
$stringa = str_replace("&eacute;","é",$stringa);
$stringa = str_replace("&agrave;","à",$stringa);
$stringa = str_replace("&aacute;","á",$stringa);
$stringa = str_replace("&ograve;","ò",$stringa);
$stringa = str_replace("&oacute;","ó",$stringa);
$stringa = str_replace("&igrave;","ì",$stringa);
$stringa = str_replace("&iacute;","í",$stringa);
$stringa = str_replace("&ugrave;","ù",$stringa);
$stringa = str_replace("&uacute;","ú",$stringa);
$stringa = str_replace("&acute;","'",$stringa);
$stringa = str_replace("&rsquo;","’",$stringa);
//$stringa = str_replace("&amp;","&",$stringa);
$stringa = str_replace("&deg;","°",$stringa);
$stringa = str_replace("\\&quot;","&quot;",$stringa);
$stringa = str_replace("&quot;","\"",$stringa);
$stringa = str_replace("&laquo;","«",$stringa);
$stringa = str_replace("&raquo;","»",$stringa);
$stringa = str_replace("&euro;","€",$stringa);
$stringa = str_replace(";;",";",$stringa);
$stringa = stripslashes($stringa);
return $stringa;
}
function levapar4($stringa) {
//$stringa = str_replace("<br>"," ",$stringa);
$stringa = str_replace("&Eacute;","E'",$stringa);
$stringa = str_replace("&Egrave;","E'",$stringa);
$stringa = str_replace("&Igrave;","I'",$stringa);
$stringa = str_replace("&Iacute;","I'",$stringa);
$stringa = str_replace("&Ograve;","O'",$stringa);
$stringa = str_replace("&Oacute;","O'",$stringa);
$stringa = str_replace("&Ugrave;","U'",$stringa);
$stringa = str_replace("&Uacute;","U'",$stringa);
$stringa = str_replace("&Agrave;","A'",$stringa);
$stringa = str_replace("&Aacute;","A'",$stringa);
$stringa = str_replace("&egrave;","e'",$stringa);
$stringa = str_replace("&eacute;","e'",$stringa);
$stringa = str_replace("&agrave;","a'",$stringa);
$stringa = str_replace("&aacute;","a'",$stringa);
$stringa = str_replace("&ograve;","o'",$stringa);
$stringa = str_replace("&oacute;","o'",$stringa);
$stringa = str_replace("&igrave;","i'",$stringa);
$stringa = str_replace("&iacute;","i'",$stringa);
$stringa = str_replace("&ugrave;","u'",$stringa);
$stringa = str_replace("&uacute;","u'",$stringa);
$stringa = str_replace("&acute;","’",$stringa);
$stringa = str_replace("&rsquo;","’",$stringa);
$stringa = str_replace("&amp;","&",$stringa);
$stringa = str_replace("&deg;","°",$stringa);
$stringa = str_replace("Â","",$stringa);
$stringa = str_replace("\\&quot;","&quot;",$stringa);
$stringa = str_replace("&quot;","\"",$stringa);
$stringa = str_replace("&laquo;","«",$stringa);
$stringa = str_replace("&raquo;","»",$stringa);
$stringa = str_replace("&euro;","€",$stringa);
$stringa = str_replace(";;",";",$stringa);
$stringa = stripslashes($stringa);
return $stringa;
}
function levapar3($stringa) {
$stringa = str_replace("<br>","\n",$stringa);
$stringa = str_replace("<br>","\r",$stringa);
$stringa = stripslashes($stringa);
return $stringa;
}
function levapar6($stringa) {
$stringa = str_replace("\n","<br>",$stringa);
//$stringa = str_replace("\r","<br>",$stringa);
$stringa = addslashes($stringa);
return $stringa;
}

function DuplicateMySQLRecord ($table, $id_field, $id) {
    // load the original record into an array
 //    $result = mysql_query("SELECT * FROM {$table} WHERE {$id_field}={$id}");
   $result = mysql_query("SELECT * FROM ".$table." WHERE ".$id_field."='".$id."'");
    $original_record = mysql_fetch_assoc($result);
    
    // insert the new record and get the new auto_increment id
    mysql_query("INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)");
    $newid = mysql_insert_id();
    
    // generate the query to update the new record with the previous values
    $query = "UPDATE {$table} SET ";
    foreach ($original_record as $key => $value) {
        if ($key != $id_field) {
            $query .= '`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
        }
    }
    $query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
    $query .= " WHERE {$id_field}={$newid}";
    mysql_query($query);
    
    // return the new id
    return $newid;
}
function DuplicateMySQLRecord2 ($or_table, $dest_table, $id_field, $id) {
    // load the original record into an array
 //    $result = mysql_query("SELECT * FROM {$table} WHERE {$id_field}={$id}");
   $result = mysql_query("SELECT * FROM ".$or_table." WHERE ".$id_field."='".$id."'");
    $original_record = mysql_fetch_assoc($result);
    
    // insert the new record and get the new auto_increment id
    mysql_query("INSERT INTO {$dest_table} (`{$id_field}`) VALUES (NULL)");
    $newid = mysql_insert_id();
    
    // generate the query to update the new record with the previous values
    $query = "UPDATE {$dest_table} SET ";
    foreach ($original_record as $key => $value) {
        if ($key != $id_field) {
            $query .= '`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
        }
    }
    $query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
    $query .= " WHERE {$id_field}={$newid}";
    mysql_query($query);
    
    // return the new id
    return $newid;
}

function dataModifica() {
echo "<br>";
$nome = basename($_SERVER['PHP_SELF']);
$Data = filemtime($nome);
$LastMod = "Ultima modifica il: " . date("d.m.Y H:i",$Data);
echo $LastMod;
}

?>