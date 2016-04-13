<?php 
function tratta($stringa) {
$stringa = str_replace("è","e'",$stringa);
$stringa = str_replace("é","e'",$stringa);
$stringa = str_replace("ì","i'",$stringa);
$stringa = str_replace("ò","o'",$stringa);
$stringa = str_replace("ù","u'",$stringa);
$stringa = str_replace("à","a'",$stringa);
$stringa = stripslashes($stringa);
$stringa = str_replace("\n"," ",$stringa);
$stringa = str_replace("\r"," ",$stringa);
$stringa = str_replace("\p"," ",$stringa);
return $stringa;
}
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

$result = mssql_query('select table_name from information_schema.tables order by table_name', $conn);
  while ($row = mssql_fetch_row($result)) {
   $tables[] = $row[0];
}
 
// Print MSSQL table list.
/*
print_r($tables);  
*/
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
$sql = 'SELECT * FROM [tNazioni]';
$sql = iconv("UTF-8","Latin1",$sql);
$query = mssql_query($sql);

echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab nazioni:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query); ++$i) {
    echo '<br> ' . mssql_field_name($query, $i), PHP_EOL;
}
echo '</div>';
// Free the query result
mssql_free_result($query);

*/
/*
$sql2 = 'SELECT * FROM [tDeleghe]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
$query2 = mssql_query($sql2);

// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab deleghe:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query2); ++$i) {
    echo '<br> ' . mssql_field_name($query2, $i), PHP_EOL;
}
echo '</div>';
// Free the query result
mssql_free_result($query2);
*/
/*
$sql2 = 'SELECT * FROM [tBMC_Clienti]';
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
  $query3 = mssql_query('SELECT * FROM [tLocalita]');

// Dump all field names in result
echo '<div style="float: left; width: 100px; min-height; 70px; overflow: hidden;">';
echo '<strong>Result tab tLocalita:</strong>', PHP_EOL;
for ($i = 0; $i < mssql_num_fields($query3); ++$i) {
    echo '<br> ' . mssql_field_name($query3, $i), PHP_EOL;
}
echo '</div>';
/*
// Free the query result
mssql_free_result($query3);
  $query4 = mssql_query('SELECT * FROM [tresp]');
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
// Free the query result
mssql_free_result($query3);
  $query4 = mssql_query('SELECT * FROM [tresp]');
*/
/*

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
echo '<div style="width: 1400px; min-height; 70px; overflow: hidden;">';
echo '<table>';
 
 
 
 
 
 
 
 

echo '<tr><td>KUNNR</td><td>NAME1</td><td>STRAS</td><td>PSTLZ</td><td>ORT01</td><td>LAND1</td><td>Descrizione</td><td>DescrInd</td><td>KUNN2</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [tBMC_Clienti]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
echo '<tr><td>'.$row["KUNNR"].'</td><td>'.$row["NAME1"].'</td><td>'.$row["STRAS"].'</td><td>'.$row["PSTLZ"].'</td><td>'.$row["ORT01"].'</td><td>'.$row["LAND1"].'</td><td>'.$row["Descrizione"].'</td><td>'.$row["DescrInd"].'</td><td>'.$row["KUNN2"].'</td></tr>';
}
echo '<table>';
echo '</div>';
*/

echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>Id_Delega</td><td>Id_Delegante</td><td>Id_Delegato</td><td>Id_Funzione</td><td>Inizio</td><td>Fine</td><td>Data_Annullamento</td><td>Timestamp</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [tDeleghe] ORDER BY Inizio DESC';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
echo '<tr><td>'.$row["Id_Delega"].'</td><td>'.$row["Id_Delegante"].'</td><td>'.$row["Id_Delegato"].'</td><td>'.$row["Id_Funzione"].'</td><td>'.$row["Inizio"].'</td><td>'.$row["Fine"].'</td><td>'.$row["Data_Annullamento"].'</td><td>'.$row["Timestamp"].'</td></tr>';
}
echo '<table>';





echo '<table style="color:red;">';
echo '<tr><td>Id</td><td>Nome</td><td>Short</td><td>Colore</td><td>Obsoleto</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [tDelegheFunzioni]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
echo '<tr><td>'.$row["Id"].'</td><td>'.$row["Nome"].'</td><td>'.$row["Short"].'</td><td>'.$row["Colore"].'</td><td>'.$row["Obsoleto"].'</td></tr>';
}
echo '<table>';
echo '</div>';
/*
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>IDUnit</td><td>Codice</td><td>Unit</td><td>Dipendenza</td><td>IDCompany</td><td>CodSAP</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [unità]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
echo '<tr><td>'.$row["IDUnit"].'</td><td>'.$row["Codice"].'</td><td>'.$row["Unit"].'</td><td>'.$row["Dipendenza"].'</td><td>'.$row["IDCompany"].'</td><td>'.$row["CodSAP"].'</td></tr>';
}
echo '<table>';
echo '</div>';
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>IDNazione</td><td>Nazione</td><td>Nazione_it</td><td>Codice</td></tr>'; 
//Declare the SQL statement that will query the database
$sql2 = 'SELECT * FROM [tNazioni]';
$sql2 = iconv("UTF-8","Latin1",$sql2);
//Execute the SQL query and return records
$query2 = mssql_query($sql2)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($query2) ) {
echo '<tr><td>'.$row["IDNazione"].'</td><td>'.$row["Nazione"].'</td><td>'.$row["Nazione_it"].'</td><td>'.$row["Codice"].'</td></tr>';
}
echo '</table>';
echo '</div>';
*/
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
}
echo '<table>';
echo '</div>';
/*
*/
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>IDLocalita</td><td>LocShort</td><td>Indirizzo</td><td>CAP</td><td>Localita</td><td>Nazione</td><td>Obsoleto</td></tr>'; 

//Declare the SQL statement that will query the database
  $query4 = 'SELECT * FROM [tLocalita ]';
//Execute the SQL query and return records
$result = mssql_query($query4)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($result) ) {
$company = iconv("Latin1","UTF-8",$row["Company"]);
echo '<tr><td>'.$row["IDLocalita"].'</td><td>'.$row["LocShort"].'</td><td>'.iconv("Latin1","UTF-8",$row["Indirizzo"]).'</td><td>'.$row["CAP"].'</td><td>'.iconv("Latin1","UTF-8",$row["Localita"]).'</td><td>'.$row["Nazione"].'</td><td>'.$row["Obsoleto"].'</td></tr>';
}
echo '<table>';
echo '</div>';
/*
*/
/*
echo '<div style="width: 800px; min-height; 70px; overflow: hidden;">';
echo '<table>';
echo '<tr><td>ID</td><td>Nome</td><td>Cognome</td><td>IDUnit</td><td>Resp</td><td>Posta</td><td>IDCompany</td><td>Company</td></tr>'; 
//Declare the SQL statement that will query the database
  $query4 = 'SELECT * FROM [nomi]';
//Execute the SQL query and return records
$result = mssql_query($query4)
	or die('A error occured: ' . mssql_error());
//Show result
while ( $row = mssql_fetch_array($result) ) {
	$sql2 = "SELECT * FROM [unità] WHERE IDUnit = '$row[IDUnit]'";
	$sql2 = iconv("UTF-8","Latin1",$sql2);
	//Execute the SQL query and return records
	$query2 = mssql_query($sql2)
		or die('A error occured: ' . mssql_error());
	//Show result
	while ( $row1 = mssql_fetch_array($query2) ) {
		$IDCompany = $row1["IDCompany"];
		$query4 = "SELECT * FROM [tcompany] WHERE IDCompany = '$IDCompany'";
	  //Execute the SQL query and return records
	  $result = mssql_query($query4)
		  or die('A error occured: ' . mssql_error());
	  //Show result
	  while ( $row2 = mssql_fetch_array($result) ) {
	  $company = iconv("Latin1","UTF-8",$row2["Company"]);
	  }
	}
*/
/*
echo '<tr><td>'.$row["ID"].'</td><td>'.iconv("Latin1","UTF-8",$row["Nome"]).'</td><td>'.iconv("Latin1","UTF-8",$row["Cognome"]).'</td><td>'.$row["IDUnit"].'</td><td>'.$row["Resp"].'</td><td>'.$row["Posta"].'</td><td>'.$IDCompany.'</td><td>'.$company.'</td></tr>';
}
echo '</table>';
echo '</div>';
*/
	//user_id	login	nome	posta	idlocalita	idunita	indirizzo	cap	company	localita	nazione	nomeunita	companyName	IDCompany	idresp	ruolo	ruolo_report	negozio_buyer	negozio2_buyer	precedenza_buyer	pwd	flag_etichette_pharma
	/*
*/

//Free result set memory
mssql_free_result($result);
//Close the connection
mssql_close($dbhandle);
}
?>
