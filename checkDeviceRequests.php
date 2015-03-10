<?php
 
$finalArray = array();
$json['deviceRequests'][] = array(1);
$file = "file.txt";
$i=0;
 
//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
    $con=mysqli_connect("localhost","root","123456","Licenta");
 
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (isset($_GET['userId'])) {
	$userId = $_GET['userId'];
$sql = "select d.deviceName, dr.* from device d, deviceRequests dr where d.udid = dr.deviceUdid and d.userId = dr.userId and d.userId=$userId";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        $json['deviceRequests'][$i]=$row;
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
