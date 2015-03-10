 <?php
 
 $finalArray = array();
 $json['documents'][] = array(1);
 $file = "file.txt";
 $i=0;
 
// $con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
         $con=mysqli_connect("localhost","root","123456","Licenta");
 if (mysqli_connect_errno()) {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 if (isset($_GET['documentName'])) {
 	$documentName = $_GET['documentName'];
 }
 if (isset($documentName)) {
 $columns = array();
$sql="SELECT * FROM document WHERE documentName = '".$documentName."'";
if ($result=mysqli_query($con,$sql))
{
	while ($fieldInfo=mysqli_fetch_field($result)) {
		$columns[] = $fieldInfo->name;
	}
	mysqli_free_result($result);
}
 	
 }
 //unset($columns['lastModified']);
 //unset($columns['documentName']);
 /*for ($i = 0; $i < count($columns); $i++) {
 	echo $columns[$i];
 	if (strpos($columns[$i], '_modif') !== FALSE) {
 		echo"removed";
 		unset($columns[$i]);
 		$i--;
 	}
 }*/
 //echo count($columns);
 //echo "<br>";
 //for ($i = 0; $i < count($columns); $i++) {
 //	echo $i;
 //	echo $columns[$i];
 //}
 	$result = mysqli_query($con,"SELECT * FROM document WHERE documentName='$documentName'");
 while($row = mysqli_fetch_assoc($result)) {
 	//echo $row["lastModified"];
 	$json['documents'][$i]=$row;
 	$i++;
 }
 //unset($json['documents']['lastModified']);
 echo Makejson($json);
 file_put_contents($file, json_encode($json));
 mysqli_close($con);
 
 function Makejson($json)
 {
 	return json_encode($json);
 } 
 //$mergedArray[$documentKeys[$i]] = array($updatedFields[$i],$documentValues[$i]);
 
 ?>
 







