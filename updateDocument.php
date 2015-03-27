<?php
    
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    //$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $documentName = $_GET["documentName"];
    $timeStamp = $_GET["timeStamp"];
    $initialTimeStamp = $_GET["initialTimeStamp"];
    $json = $_GET["json"];
    $type = $_GET["type"];
//    echo $json;
    
    $sql = "SELECT documentId FROM document WHERE documentName='".$documentName."'";
    //    echo $sql;
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $documentId = $row["documentId"];
    }
    $array = json_decode($json, true);
    
    if ($type == "dictionary") {
        $xml .= "<sections>";
        $xml .= "<section>";
        foreach ($array as $value => $key) {
            if ($value == "name") {
                $xml .= "<name>".$key['text']."</name>";
            } else if ($value == "timestamp") {
                $xml .= "<timestamp>".$key['text']."</timestamp>";
            } else if ($value == "value") {
                $xml .= "<value>".$key['text']."</value>";
            }
        }
        $xml .= "</section>";
        $xml .= "</sections>";
    } else if ($type == "array") {
        $xml .= "<sections>";
//        var_dump($array);
        for ($i = 0; $i < count($array); $i++) {
//            echo "a";
            $xml .= "<section>";
            $section = $array[$i];
            foreach ($section as $value => $key) {
                if ($value == "name") {
                    $xml .= "<name>".$key['text']."</name>";
                } else if ($value == "timestamp") {
                    $xml .= "<timestamp>".$key['text']."</timestamp>";
                } else if ($value == "value") {
                    $xml .= "<value>".$key['text']."</value>";
                }
            }
            $xml .= "</section>";
//            foreach ($)
        }
        $xml .= "</sections>";
    }
//    echo $xml;
    $sql = "UPDATE section SET sectionText = '".mysql_real_escape_string($xml)."' WHERE documentId='".$documentId."'";
//    echo $sql;
    $result = mysqli_query($con, $sql);
    function DecodeJson($json) {
        return json_decode($json);
    }
    
    function Makejson($json)
    {
        return json_encode($json);
    }
    
    
    
    
    
    //$documentKeys = array();
    //$documentValues = array();
    //foreach ($_GET as $name => $value) {
    //	if ($name == "documentName") {
    //		$documentName = $value;
    //	} else if ($name == "timeStamp") {
    //		$timeStamp = $value;
    //	} else if ($name == "initialTimeStamp") {
    //		$initialTimeStamp = $value;
    //	} else {
    //		$documentKeys[] = $name;
    //		$documentValues[] = $value;
    //        }
    //}
    //
    //$columns = array();
    //$sql="SELECT * FROM document WHERE documentName = '".$documentName."'";
    //if ($result=mysqli_query($con,$sql))
    //{
    //	while ($fieldInfo=mysqli_fetch_field($result)) {
    //		$columns[] = $fieldInfo->name;
    //	}
    //	mysqli_free_result($result);
    //}
    //
    //$sql = "SELECT lastModified FROM document WHERE documentName = '".$documentName."'";
    //$result = mysqli_query($con, $sql);
    // while($row = mysqli_fetch_assoc($result)) {
    // 	$dataBaseTimeStamp = $row["lastModified"];
    // }
    //
    // if ($initialTimeStamp == $dataBaseTimeStamp) {
    // 	$count = mysqli_affected_rows($con);
    // 	if ($count > 0) {
    // 		for ($i = 0; $i < count($documentKeys); $i++) {
    // 			$columnExists = FALSE;
    // 			for ($j = 0; $j < count($columns); $j++) {
    // 				if ($documentKeys[$i] == $columns[$j]) {
    // 					$columnExists = TRUE;
    // 					break;
    // 				}
    // 			}
    // 			if ($columnExists == FALSE) {
    //                $sql = "ALTER TABLE document ADD (".$documentKeys[$i]." TEXT NULL, ".$documentKeys[$i]."_modif TEXT NOT NULL)";
    ////                echo $sql;
    // 				$result=mysqli_query($con,$sql) or die("Alter Error: ".mysql_error());
    // 			}
    // 		}
    //
    // 		for ($i = 0; $i < count($documentKeys); $i++) {
    // 			$sql = "UPDATE document SET ".$documentKeys[$i]."='".$documentValues[$i]."',".$documentKeys[$i]."_modif='".$timeStamp."' WHERE documentName='".$documentName."'";
    // 			$result = mysqli_query($con, $sql) or die("Error".mysql_error());
    // 		}
    // 		$sql = "UPDATE document SET lastModified='".$timeStamp."' WHERE documentName='".$documentName."'";
    // 		$result = mysqli_query($con, $sql) or die ("Error".mysql_error());
    // 		$json = '{"response":"The document has been modified successfully","status":"OK"}';
    // 	} else {
    // 		$json = '{"response":"The document does not exist. Do you want to create another document?","status":"ERROR"}';
    // 	}
    // } else {
    // 	$updatedFields = array();
    // 	for ($i = 0; $i < count($documentKeys); $i++) {
    // 		$sql = "SELECT ".$documentKeys[$i]."_modif"." FROM document WHERE documentName = '".$documentName."'";
    // 		//echo $sql;
    // 		$result = mysqli_query($con, $sql);
    //		while($row = mysqli_fetch_assoc($result)) {
    // 			$sectionTimeStamp = $row[$documentKeys[$i]."_modif"];
    // 		}
    // 		if ($initialTimeStamp != $sectionTimeStamp) {
    // 			$sql = "SELECT ".$documentKeys[$i]." FROM document WHERE documentName='".$documentName."'";
    // 			//echo "sql ".$sql;
    // 			$result = mysqli_query($con, $sql);
    // 			while($row = mysqli_fetch_assoc($result)) {
    // 				$updatedFields[] = $row[$documentKeys[$i]];
    // 			}
    // 		}
    // 		//echo $var."   ";
    // 	}
    // 	$mergedArray = array();
    // 	for ($i = 0; $i < count($updatedFields); $i++) {
    // 		if ($updatedFields[$i] != $documentValues[$i]) {
    // 			$mergedArray[$documentKeys[$i]] = array($updatedFields[$i],$documentValues[$i]);
    // 		}
    // 	}
    // 	//$mergedArray["status"] = "There are some conflicts. Do you want to resolve them?";
    // 	$json = json_encode($mergedArray);
    // }
    //
    //
    //echo $json;
    //file_put_contents($file, json_encode($json));
    //mysqli_close($con);
    //function Makejson($json)
    //{
    //return json_encode($json);
    //}
    
    ?>