<?php
//如果没有这个header, localhost3000 port(NPM server)就无法访问80 port(APACHE)
 //add this CORS header to enable any domain to send HTTP requests to these endpoints:
 //this header should be added before include statement.
header("Access-Control-Allow-Origin: *");

include_once 'Connection.php';
 
$method = $_SERVER['REQUEST_METHOD'];
 
// 如果这个内容也删掉，就会出现

// echo "hello";
 
$sql = "SELECT * FROM `Confusingwords`;";

// run SQL statement
$result = mysqli_query($con,$sql);

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

// if ($result) {
//   echo "Returned rows are: " . mysqli_num_rows($result)."<br>";
//   // Free result set
//   // mysqli_free_result($result);
// }

//  每次从result取一行而已，当表格中没有其它行的时候，$row=NULL, iteration is over.
// while ($row = mysqli_fetch_row($result)) {
//   // （）会在row 2加上括号：（cell);
//   printf("%s %s %s <br>", $row[0],$row[1], $row[2]);
// }

// 这个echo 出来的array才是pass到前端的数据，一定不要额外多echo一个标点符号，
//不然就会提示 syntax error: blabla is not valid json. 
// 感觉这个array里面的json最后被用起来了。解析不成功，就废了。
// 突然发现为啥要用ECHO啊，因为这是对前端的回应啊。
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