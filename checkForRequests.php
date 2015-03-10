<?php
 
$finalArray = array();
$json['requests'][] = array(1);
$file = "file.txt";
$i=0;
 
//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");
 
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (isset($_GET['userId'])) {
	$userId = $_GET['userId'];
$sql = "SELECT r . * , d.documentName, u.username FROM requests r, document d, user u WHERE r.createdBy =$userId AND r.documentId = d.documentId and u.userID=r.userId";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        $json['requests'][$i]=$row;
        $i++;
    }
if ($i != 0) {
echo Makejson($json);
}
} 
file_put_contents($file, json_encode($json));
mysqli_close($con);
 
function Makejson($json)
{
return json_encode($json);
}
?>
