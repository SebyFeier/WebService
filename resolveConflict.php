<?php
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    //$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $time = time();
    $documentName = $_GET[@"documentName"];
    $timeStamp = $_GET[@"timeStamp"];
    $jsonSection = $_GET[@"section"];
    
    $updatedSection = json_decode($jsonSection, true);
    foreach ($updatedSection as $value => $key) {
        if ($value == "name") {
            $sectionName = $key['text'];
        } else if ($value == "value") {
            $sectionValue = $key['text'];
        }
    }
    
    $sql = "SELECT documentId, lastModified FROM document WHERE documentName='".$documentName."'";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $documentId = $row["documentId"];
    }
    $sql = "SELECT sectionText FROM section WHERE documentId='".$documentId."'";
//    echo $sql;
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $sectionText = $row["sectionText"];
    }
//    echo $sectionText;
    $xml=simplexml_load_string($sectionText) or die("Error: Cannot create object");
//    print_r($xml);
    if (count($xml) == 1) {
        if ($xml->section[0]->name == $sectionName) {
            $newXml .= "<sections>";
            $newXml .= "<section>";
            $newXml .= "<name>".$sectionName."</name>";
            $newXml .= "<timestamp>".$time."</timestamp>";
            $newXml .= "<value>".$sectionValue."</value>";
            $newXml .= "</section>";
            $newXml .= "</sections>";
//            $xml->section[0]->name = "1234567";
            $sql = "UPDATE section SET sectionText = '".mysql_real_escape_string($newXml)."' WHERE documentId='".$documentId."'";
            $result = mysqli_query($con, $sql);
//            echo $sql;
            
        }
    }
    
    //foreach ($_GET as $name => $value) {
    //	if ($name == "documentName") {
    //		$documentName = $value;
    //	} else if ($name == "timeStamp") {
    //		$timeStamp = $value;
    //	} else {
    //		$sectionName = $name;
    //		$sectionValue = $value;
    //	}
    //}
    //
    //$sql = "SELECT ".$sectionName."_modif FROM document WHERE documentName = '".$documentName."'";
    //$result = mysqli_query($con, $sql);
    //while($row = mysqli_fetch_assoc($result)) {
    //	$dataBaseSectionTimeStamp = $row[$sectionName."_modif"];
    //}
    ////echo $dataBaseSectionTimeStamp;
    ////if ($dataBaseSectionTimeStamp == $timeStamp) {
    //	$sql = "UPDATE document SET ".$sectionName."='".$sectionValue."',".$sectionName."_modif=".$timeStamp.",lastModified=".$timeStamp." WHERE documentName='".$documentName."'";
    //	$result = mysqli_query($con, $sql) or die ("Error".mysql_error());
    //	//$json = json_encode($sectionName);
    //	$json = '{"message":"The document has been modified successfully"}';
    //	echo $json;
    ///*} else {
    //	$sql = "SELECT ".$sectionName." FROM document WHERE documentName = '".$documentName."'";
    ////echo $dataBaseSectionTimeStamp;
    ////echo $timeStamp;
    //	$result = mysqli_query($con, $sql);
    //
    //	while($row = mysqli_fetch_assoc($result)) {
    //		$newText = $row[$sectionName];
    //	}
    //	$newArray = array($sectionName => $newText);
    //	$json = json_encode($newArray);
    //	echo $json;
    //}*/
    
    //file_put_contents($file, json_encode($json));
    mysqli_close($con);
    function Makejson($json)
    {
        return json_encode($json);
    }
    
    ?>