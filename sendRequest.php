<?php

$finalArray = array();
$json['users'][] = array(1);
$file = "file.txt";
$i=0;

//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");

if (isset($_GET["userId"])) {
$userId = $_GET["userId"];
}
if (isset($_GET["createdBy"])) {
$createdBy = $_GET["createdBy"];
}
if (isset($_GET["documentId"])) {
$documentId = $_GET["documentId"];
}

$sql = "INSERT INTO requests(createdBy, userId, documentId) VALUES ($createdBy, $userId, $documentId)";
$result = mysqli_query($con, $sql);
	if($result) {	
	     $json = '{"status":"OK"}';
      } else {
              $json = '{"status":"ERROR"}';
       }
echo $json;

?>