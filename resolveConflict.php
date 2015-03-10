<?php
$json['documents'][] = array(1);
$file = "file.txt";
$i=0;
//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

foreach ($_GET as $name => $value) {
	if ($name == "documentName") {
		$documentName = $value;
	} else if ($name == "timeStamp") {
		$timeStamp = $value;
	} else {
		$sectionName = $name;
		$sectionValue = $value;	
	}
}

$sql = "SELECT ".$sectionName."_modif FROM document WHERE documentName = '".$documentName."'";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_assoc($result)) {
	$dataBaseSectionTimeStamp = $row[$sectionName."_modif"];
}
//echo $dataBaseSectionTimeStamp;
//if ($dataBaseSectionTimeStamp == $timeStamp) {
	$sql = "UPDATE document SET ".$sectionName."='".$sectionValue."',".$sectionName."_modif=".$timeStamp.",lastModified=".$timeStamp." WHERE documentName='".$documentName."'";
	$result = mysqli_query($con, $sql) or die ("Error".mysql_error());
	//$json = json_encode($sectionName);
	$json = '{"message":"The document has been modified successfully"}';
	echo $json;
/*} else {
	$sql = "SELECT ".$sectionName." FROM document WHERE documentName = '".$documentName."'";
//echo $dataBaseSectionTimeStamp;
//echo $timeStamp;
	$result = mysqli_query($con, $sql);
	
	while($row = mysqli_fetch_assoc($result)) {
		$newText = $row[$sectionName];
	}
	$newArray = array($sectionName => $newText);
	$json = json_encode($newArray);
	echo $json;
}*/

//file_put_contents($file, json_encode($json));
mysqli_close($con);
function Makejson($json)
{
	return json_encode($json);
}

?>