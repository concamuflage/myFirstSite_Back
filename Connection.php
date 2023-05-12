
<?php
// the delimiter above cannot be omitted

$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "myFirstSite"; 
// how to use the following statement?
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = mysqli_connect($host, $user, $password,$dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
// the delimiter below cannot be omitted
?>