<?php 
$ricerca = $_POST[ricerca];
$servername = $_POST[server];
$username = $_POST[user];
$password = $_POST[password];
?>
<div style="width:100%; height:50px;">
<form action="" method="post" name="form1">
<div style="float:left; width: 200px; height:30px; font-family:Arial; font-size:14px;">
  Server<br /><input name="server" type="text" value="<?php echo $servername; ?>" />
</div>
<div style="float:left; width: 200px; height:30px; font-family:Arial; font-size:14px;">
  User<br /><input name="user" type="text"  value="<?php echo $username; ?>"/>
</div>
<div style="float:left; width: 200px; height:30px; font-family:Arial; font-size:14px;">
  Password<br /><input name="password" type="text"  value="<?php echo $password; ?>"/>
</div>
<div style="float:left; width: 200px; height:30px; font-family:Arial; font-size:14px;">
  <br /><input name="ricerca" type="hidden" value="1" />
  <input name="submit" type="submit" value="invia" />
</div>
</form>
</div>
<?php
if ($ricerca == 1) {
  /*$servername = "srvsepsql,4394";
  $username = "service_www";
  $password = "Public70";
  $port = "4394";
  $db = "quice_staging";*/
  
  // Create connection
  $conn = mssql_connect($servername, $username, $password);
  
  // Check connection
  if (!$conn) {
	  die("Connection failed: " . mssql_get_last_message());
  }
  echo "Connected successfully<br>";
  mssql_select_db("intranet",$conn);
/*
$sql = 'SELECT * FROM [nomi]';
$sql = iconv("UTF-8","Latin1",$sql);
$query = mssql_query($sql);

echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab nomi:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query); ++$i) {
    echo '<br> ' . mssql_field_name($query, $i), PHP_EOL;
}
echo '</div>';
// Free the query result
mssql_free_result($query);

*/
/*
$sql2 = 'SELECT * FROM [unità]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
$query2 = mssql_query($sql2);

// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab unità:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query2); ++$i) {
    echo '<br> ' . mssql_field_name($query2, $i), PHP_EOL;
}
echo '</div>';
// Free the query result
mssql_free_result($query2);
*/
/*
  $query3 = mssql_query('SELECT * FROM [tcompany]');

// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab tcompany:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query3); ++$i) {
    echo '<br> ' . mssql_field_name($query3, $i), PHP_EOL;
}
echo '</div>';
*/
/*
// Free the query result
mssql_free_result($query3);
  $query4 = mssql_query('SELECT * FROM [tresp]');

// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab tresp:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query4); ++$i) {
    echo '<br> ' . mssql_field_name($query4, $i), PHP_EOL;
}
echo '</div>';
  
echo '</div>';
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>IDUnit</td><td>IDResp</td><td>Diretto</td></tr>';
//Declare the SQL statement that will query the database
  $query4 = 'SELECT * FROM [tresp]';
//Execute the SQL query and return records
$result = mssql_query($query4)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($result) ) {
echo '<tr><td>'.$row["IDUnit"].'</td><td>'.$row["IDResp"].'</td><td>'.$row["Diretto"].'</td></tr>';
}
echo '<table>';
echo '</div>';
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>IDUnit</td><td>Codice</td><td>Unit</td><td>Dipendenza</td><td>IDCompany</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [unità]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
echo '<tr><td>'.$row["IDUnit"].'</td><td>'.$row["Codice"].'</td><td>'.$row["Unit"].'</td><td>'.$row["Dipendenza"].'</td><td>'.$row["IDCompany"].'</td></tr>';
}
echo '<table>';
echo '</div>';
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>IDCompany</td><td>Company</td><td>Ordine</td><td>CodSAP</td><td>IDNazione</td><td>Prefisso</td></tr>'; 

//Declare the SQL statement that will query the database
  $query4 = 'SELECT * FROM [tcompany]';
//Execute the SQL query and return records
$result = mssql_query($query4)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($result) ) {
$company = iconv("Latin1","UTF-8",$row["Company"]);
echo '<tr><td>'.$row["IDCompany"].'</td><td>'.$company.'</td><td>'.$row["Ordine"].'</td><td>'.$row["CodSAP"].'</td><td>'.$row["IDNazione"].'</td><td>'.$row["Prefisso"].'</td></tr>';
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
	$queryz = "SELECT * FROM qui_company WHERE IDCompany = '$row[IDCompany]'";
	  $resultz = mysql_query($queryz);
	  $presenza_company = mysql_num_rows($resultz);
	  if ($presenza_company > 0) {
		$query = "UPDATE qui_company SET IDCompany = '$row[IDCompany]', Company = '$company', Ordine = '$row[Ordine]', CodSAP = '$row[CodSAP]', IDNazione = '$row[IDNazione]', Prefisso = '$row[Prefisso]' WHERE IDCompany = '$row[IDCompany]'"; 
		if (mysql_query($query)) {
echo '<tr><td>riga aggiornata</td><td></td><td></td><td></td><td></td><td></td></tr>';
			//$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
		} else {
		$out_value .= "Errore durante l'inserimento3". mysql_error();
echo '<tr><td>Errore durante inserimento3'. mysql_error().'</td><td></td><td></td><td></td><td></td><td></td></tr>';
		}
	  } else {
		$queryss = "INSERT INTO qui_company (IDCompany, Company, Ordine, CodSAP, IDNazione, Prefisso) VALUES ('$row[IDCompany]', '$company', '$row[Ordine]', '$row[CodSAP]', '$row[IDNazione]', '$row[Prefisso]')";
		if (mysql_query($queryss)) {
echo '<tr><td></td><td>riga inserita</td><td></td><td></td><td></td><td></td></tr>';
		} else {
		  echo "Errore durante l'inserimento1". mysql_error();
		}
	  }
}
echo '<table>';
echo '</div>';
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>ID</td><td>Nome</td><td>Cognome</td><td>IDUnit</td><td>nome unit</td><td>Resp</td><td>Posta</td></tr>'; 
//Declare the SQL statement that will query the database
  $query4 = 'SELECT * FROM [nomi]';
//Execute the SQL query and return records
$result = mssql_query($query4)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($result) ) {
echo '<tr><td>'.$row["ID"].'</td><td>'.$row["Nome"].'</td><td>'.$row["Cognome"].'</td><td>'.$row["IDUnit"].'</td><td>'.$row["Resp"].'</td><td>'.$row["Posta"].'</td></tr>';
}
echo '</table>';
echo '</div>';
*/
echo '<tr><td>KUNNR</td><td>NAME1</td><td>STRAS</td><td>PSTLZ</td><td>ORT01</td><td>LAND1</td><td>Descrizione</td><td>DescrInd</td><td>KUNN2</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [tBMC_Clienti]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
$KUNNR = iconv("Latin1","UTF-8",$row["KUNNR"]);
$NAME1 = iconv("Latin1","UTF-8",$row["NAME1"]);
$STRAS = iconv("Latin1","UTF-8",$row["STRAS"]);
$PSTLZ = iconv("Latin1","UTF-8",$row["PSTLZ"]);
$ORT01 = iconv("Latin1","UTF-8",$row["ORT01"]);
$LAND1 = iconv("Latin1","UTF-8",$row["LAND1"]);
$Descrizione = iconv("Latin1","UTF-8",$row["Descrizione"]);
$DescrInd = iconv("Latin1","UTF-8",$row["DescrInd"]);
$KUNN2 = iconv("Latin1","UTF-8",$row["KUNN2"]);
echo '<tr><td>'.$row["KUNNR"].'</td><td>'.$row["NAME1"].'</td><td>'.$row["STRAS"].'</td><td>'.$row["PSTLZ"].'</td><td>'.$row["ORT01"].'</td><td>'.$row["LAND1"].'</td><td>'.$row["Descrizione"].'</td><td>'.$row["DescrInd"].'</td><td>'.$row["KUNN2"].'</td></tr>';
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
	$queryz = "SELECT * FROM qui_tBMC_Clienti WHERE KUNNR = '$row[KUNNR]'";
	  $resultz = mysql_query($queryz);
/*	  
	  $presenza_address = mysql_num_rows($resultz);
	  if ($presenza_address > 0) {
		  
		$query = "UPDATE qui_tBMC_Clienti SET NAME1 = '$NAME1', STRAS = '$STRAS', PSTLZ = '$PSTLZ', ORT01 = '$ORT01', LAND1 = '$LAND1', Descrizione = '$Descrizione', DescrInd = '$DescrInd', KUNN2 = '$KUNN2' WHERE KUNNR = '$KUNNR'"; 
		if (mysql_query($query)) {
echo '<tr><td>riga aggiornata</td><td></td><td></td><td></td><td></td><td></td></tr>';
			//$out_value .= "riga aggiornata: ".$n_pl." con fattura ".$n_ord."<br>";
		} else {
		$out_value .= "Errore durante l'inserimento3". mysql_error();
echo '<tr><td>Errore durante inserimento3'. mysql_error().'</td><td></td><td></td><td></td><td></td><td></td></tr>';
		}
	  } else {
*/
		$queryss = "INSERT INTO qui_tBMC_Clienti (KUNNR, NAME1, STRAS, PSTLZ, ORT01, LAND1, Descrizione, DescrInd, KUNN2) VALUES ('$KUNNR', '$NAME1', '$STRAS', '$PSTLZ', '$ORT01', '$LAND1', '$Descrizione', '$DescrInd', '$KUNN2')";
		if (mysql_query($queryss)) {
echo '<tr><td></td><td>riga inserita</td><td></td><td></td><td></td><td></td></tr>';
		} else {
		  echo "Errore durante l'inserimento1". mysql_error();
		}
	 // }
}
echo '<table>';
echo '</div>';

//Free result set memory
mssql_free_result($result);
//Close the connection
mssql_close($dbhandle);
}
?>
