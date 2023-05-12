<?php
//如果没有这个header, localhost:3000 port(webpack server)就无法访问80 port(APACHE)
 //add this CORS header to enable any domain to send HTTP requests to these endpoints:
header("Access-Control-Allow-Origin: *");
include_once 'Connection.php';
$method = $_SERVER['REQUEST_METHOD'];

// get query string from the URL

if (isset($_GET['year'])) {
    $year=$_GET['year'];
    $likeVariable ="%".$year."%";
    $sql = "SELECT * FROM `Blogs` WHERE Time LIKE ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt,$sql)){
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt,"s",$likeVariable);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); }
  } elseif ($_GET['id']){
        $id=$_GET['id'];
        $sql = "SELECT * FROM `Blogs` WHERE id = ?;";
        // to create a prepared statement
        // the variable is $con , not $ conn
        // if you enconter a an internal error, usually
        // it is caused by your mysql query. 
        // need to debug line by line.
        // you must learn to catch error in php. 
        // at present, the error message is too general.
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt,$sql)){
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt,"i",$id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);  
  }}else {
    $year=2023; // the default year is 2023 in case the url doesn't contain this info.
    $likeVariable ="%".$year."%";
    $sql = "SELECT * FROM `Blogs` WHERE Time LIKE ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt,$sql)){
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt,"s",$likeVariable);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); }
  }

// to get blog entries in a certain year; since the year info 
// is stored in a php variable, we need to use prepared statement 
// in such a scenario.

// First, we need to create a template with question marks in it.
// SELECT * FROM customer WHERE last_name LIKE 'Pete%';

// this query must be wrong!
// if I cannot figure out the correct way to write the following
// query, I can use the variable directly in the query; however,
// I must avoid sql injection by escaping the variable first. 
// https://stackoverflow.com/questions/8645651/php-mysql-search-like-variable

// I wrote it like this, but it didn't work
// $sql = "SELECT * FROM Blogs WHERE Time LIKE '?%';";

// the following is the correct way to use a php variable in a 
// sql query to be used in a prepared statement.



    // the following is the echoed format
    // [{"id":1,"Title":"First Blog","Time":"2023\/4\/22","Body":"NONSENSE of 2023"},{"id":2,"Title":"Second Blog","Time":"2023\/4\/22","Body":"NONSENSE of 2022"}]
if ($method == 'GET') {
  echo '[';
  // how is the generated array used in the front end?
  for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
    // why use json_encode? it turns object into json
    // why dou you need jason here?
    //($i>0?',':'').jason_encode what does this mean?
    // i=0, it is the first row, no need to add coma before the result
    // i>0, must add the comma to construct the array. 
    // see the following result.
    //[{"ID":"1","WordOne":"coma","WordTwo":"comma","QuestionOne":"","QuestionTwo":""},
    //{"ID":"2","WordOne":"bowl","WordTwo":"bowel","QuestionOne":"","QuestionTwo":""}]
    // why not directly echo the obj?
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  echo ']';
  }



// else {
//     echo mysqli_affected_rows($con);
// }
 
$con->close();