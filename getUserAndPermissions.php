<?php

$finalArray = array();
$json['users'][] = array(1);
$file = "file.txt";
$i=0;

//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_GET["documentId"])) {
        $documentId = $_GET["documentId"];
}
$num_rec_per_page=10;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $num_rec_per_page; 
$sql = "SELECT u.userID, u.username ,d.documentId,p.permissionType from permissions p, user u, document d where p.documentId=d.documentId and d.documentId = $documentId and p.userId = u.userId and u.userID != d.createdBy limit $start_from, $num_rec_per_page";
//echo $sql;
	$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_assoc($result)) {
	//echo $row["lastModified"];
	$json['users'][$i]=$row;
	$i++;
}
//echo $i;
if ($i != 0) {
echo Makejson($json);
}
file_put_contents($file, json_encode($json));
mysqli_close($con);

function Makejson($json)
{
	return json_encode($json);
}
?>







