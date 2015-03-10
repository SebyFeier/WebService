<?php

$finalArray = array();
$json['devices'][] = array(1);
$file = "file.txt";
$i=0;

//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");

if (isset($_GET["userId"])) {
$userId = $_GET["userId"];
}
if (isset($_GET["deviceUdid"])) {
$deviceUdid = $_GET["deviceUdid"];
}

$sql = "INSERT INTO deviceRequests(userId, deviceUdid) VALUES ('$userId','$deviceUdid')";
$result = mysqli_query($con, $sql);
	if($result) {	
	     $json = '{"status":"OK","response":"Request Sent"}';
      } else {
              $json = '{"status":"ERROR"}';
       }
echo $json;

?>