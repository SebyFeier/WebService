<?php
    
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    //$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $time  = time();
    
    $documentName = $_GET["documentName"];
    $timeStamp = $_GET["timeStamp"];
    $initialTimeStamp = $_GET["initialTimeStamp"];
    $json = $_GET["json"];
    $type = $_GET["type"];
    
    $sql = "SELECT documentId, lastModified FROM document WHERE documentName='".$documentName."'";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $documentId = $row["documentId"];
        $documentTimeStamp = 0;
        $documentTimeStamp = $row["lastModified"];
    }
    $array = json_decode($json, true);
    if ($type == "dictionary") {
        $xml .= "<sections>";
        $xml .= "<section>";
        foreach ($array as $value => $key) {
            if ($value == "name") {
                $xml .= "<name>".$key['text']."</name>";
            } else if ($value == "timestamp") {
                $xml .= "<timestamp>".$time."</timestamp>";
            } else if ($value == "value") {
                $xml .= "<value>".$key['text']."</value>";
            }
        }
        $xml .= "</section>";
        $xml .= "</sections>";
    } else if ($type == "array") {
        $sql = "SELECT sectionText FROM section WHERE documentId='".$documentId."'";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $sectionText = $row["sectionText"];
        }
        $serverXml=simplexml_load_string($sectionText) or die("Error: Cannot create object");
        $xml .= "<sections>";
        $appNames = array();
        $appTimestamps = array();
        $appValues = array();
        for ($i = 0; $i < count($array); $i++) {
            $section = $array[$i];
            foreach ($section as $value => $key) {
                if ($value == "name") {
                    $appNames[] = $key['text'];
                } else if ($value == "timestamp") {
                    $appTimestamps[] = $key['text'];
                } else if ($value == "value") {
                    $appValues[] = $key['text'];
                }
            }
        }
        if (count($serverXml) > count($appNames)) {
            echo "SERVER";
            $notFoundNames = array();
            $notFoundTimestamps = array();
            $notFoundValues = array();
            $foundNames = array();
            for ($server = 0; $server < count($serverXml);$server++) {
                echo "SERVER : ".$serverXml->section[$server]->name;
                $sectionFound = FALSE;
                for ($app = 0; $app < count($appNames); $app++) {
                    if ($appNames[$app] == $serverXml->section[$server]->name && in_array($appNames[$app], $notFoundNames) == NULL) {
                        echo "SAME :".$appNames[$app];
                        $foundNames[] = $appNames[$app];
                        $xml .= "<section>";
                        $xml .= "<name>".$appNames[$app]."</name>";
                        $xml .= "<timestamp>".$appTimestamps[$app]."</timestamp>";
                        $xml .= "<value>".$appValues[$app]."</value>";
                        $xml .= "</section>";
                        $sectionFound = TRUE;
                        break;
                    } else {
                        if (in_array($appNames[$app], $notFoundNames) == NULL) {
                            echo "ADD : ".$appNames[$app];
                            $notFoundNames[] = $appNames[$app];
                            $notFoundTimestamps[] = $appTimestamps[$app];
                            $notFoundValues[] = $appValues[$app];
                            
                        }
                    }
                }
                if ($sectionFound == FALSE) {
                    if (in_array($serverXml->section[$server]->name, $notFoundNames) == NULL) {
                        echo "NOT : ".$serverXml->section[$server]->name;
                        $notFoundNames[] = $serverXml->section[$server]->name;
                        $notFoundTimestamps[] = $serverXml->section[$server]->timestamp;
                        $notFoundValues[] = $serverXml->section[$server]->value;
                        
                    }
                }
            }
            echo "COUNT : ".count($notFoundNames);
            for ($i = 0; $i < count($notFoundNames); $i++) {
                echo $notFoundNames[$i];
                if (in_array($notFoundNames[$i],$foundNames) == NULL) {
                    $xml .= "<section>";
                    $xml .= "<name>".$notFoundNames[$i]."</name>";
                    $xml .= "<timestamp>".$notFoundTimestamps[$i]."</timestamp>";
                    $xml .= "<value>".$notFoundValues[$i]."</value>";
                    $xml .= "</section>";
                }
            }
        } else if (count($serverXml) < count($appNames)) {
            echo "APP";
            $notFoundNames = array();
            $notFoundTimestamps = array();
            $notFoundValues = array();
            $foundNames = array();
//            for ($server = 0; $server < count($serverXml);$server++) {
            for ($app = 0; $app < count($appNames); $app++) {
                echo "SERVER : ".$appNames[$app];
                $sectionFound = FALSE;
//                for ($app = 0; $app < count($appNames); $app++) {
                for ($server = 0; $server < count($serverXml); $server++) {
                    if ($appNames[$app] == $serverXml->section[$server]->name && in_array($serverXml->section[$server]->name, $notFoundNames) == NULL) {
                        echo "SAME :".$serverXml->section[$server]->name;
                        $foundNames[] = $appNames[$app];
                        $xml .= "<section>";
                        $xml .= "<name>".$appNames[$app]."</name>";
                        $xml .= "<timestamp>".$appTimestamps[$app]."</timestamp>";
                        $xml .= "<value>".$appValues[$app]."</value>";
                        $xml .= "</section>";
                        $sectionFound = TRUE;
                        break;
                    } else {
                        if (in_array($serverXml->section[$server]->name, $notFoundNames) == NULL) {
                            echo "ADD : ".$serverXml->section[$server]->name;
                            $notFoundNames[] = $serverXml->section[$server]->name;
                            $notFoundTimestamps[] = $serverXml->section[$server]->timestamp;
                            $notFoundValues[] = $serverXml->section[$server]->value;
                            
                        }
                    }
                }
                if ($sectionFound == FALSE) {
                    if (in_array($appNames[$app], $notFoundNames) == NULL) {
                        echo "NOT : ".$appNames[$app];
                        $notFoundNames[] = $appNames[$app];
                        $notFoundTimestamps[] = $appTimestamps[$app];
                        $notFoundValues[] = $appValues[$app];
                        
                    }
                }
            }
            echo "COUNT : ".count($notFoundNames);
            for ($i = 0; $i < count($notFoundNames); $i++) {
                echo $notFoundNames[$i];
                if (in_array($notFoundNames[$i],$foundNames) == NULL) {
                    $xml .= "<section>";
                    $xml .= "<name>".$notFoundNames[$i]."</name>";
                    $xml .= "<timestamp>".$notFoundTimestamps[$i]."</timestamp>";
                    $xml .= "<value>".$notFoundValues[$i]."</value>";
                    $xml .= "</section>";
                }
            }
        } else if (count($serverXml) == count($appNames)) {
            echo "EQUAL";
            $notFoundNames = array();
            $notFoundTimestamps = array();
            $notFoundValues = array();
            $foundNames = array();
            for ($server = 0; $server < count($serverXml);$server++) {
                echo "SERVER : ".$serverXml->section[$server]->name;
                $sectionFound = FALSE;
                for ($app = 0; $app < count($appNames); $app++) {
                    if ($appNames[$app] == $serverXml->section[$server]->name && in_array($appNames[$app], $notFoundNames) == NULL) {
                        echo "SAME :".$appNames[$app];
                        $foundNames[] = $appNames[$app];
                        $xml .= "<section>";
                        $xml .= "<name>".$appNames[$app]."</name>";
                        $xml .= "<timestamp>".$appTimestamps[$app]."</timestamp>";
                        $xml .= "<value>".$appValues[$app]."</value>";
                        $xml .= "</section>";
                        $sectionFound = TRUE;
                        break;
                    } else {
                        if (in_array($appNames[$app], $notFoundNames) == NULL) {
                            echo "ADD : ".$appNames[$app];
                            $notFoundNames[] = $appNames[$app];
                            $notFoundTimestamps[] = $appTimestamps[$app];
                            $notFoundValues[] = $appValues[$app];
                    
                        }
                    }
                }
                if ($sectionFound == FALSE) {
                    if (in_array($serverXml->section[$server]->name, $notFoundNames) == NULL) {
                        echo "NOT : ".$serverXml->section[$server]->name;
                        $notFoundNames[] = $serverXml->section[$server]->name;
                        $notFoundTimestamps[] = $serverXml->section[$server]->timestamp;
                        $notFoundValues[] = $serverXml->section[$server]->value;
                        
                    }
                }
            }
            echo "COUNT : ".count($notFoundNames);
            for ($i = 0; $i < count($notFoundNames); $i++) {
                echo $notFoundNames[$i];
                if (in_array($notFoundNames[$i],$foundNames) == NULL) {
                    $xml .= "<section>";
                    $xml .= "<name>".$notFoundNames[$i]."</name>";
                    $xml .= "<timestamp>".$notFoundTimestamps[$i]."</timestamp>";
                    $xml .= "<value>".$notFoundValues[$i]."</value>";
                    $xml .= "</section>";
                }
            }
        }
        $xml .= "</sections>";
        echo $xml;
    }
    if ($initialTimeStamp == $documentTimeStamp) {//check if document was already updated from different device
        $sql = "UPDATE section SET sectionText = '".mysql_real_escape_string($xml)."' WHERE documentId='".$documentId."'";
        $result = mysqli_query($con, $sql);
        $json = '{"response":"The document has been modified successfully","status":"OK"}';
        echo $json;
    } else {
        $sql = "SELECT * FROM document, section WHERE document.documentName='$documentName' AND document.documentId = section.documentId";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $existingSection = $row["sectionText"];
        }
        $conflictedSection = array();
        $conflictedSection["existing"] = $existingSection;
        $conflictedSection["new"] = $xml;
        echo Makejson($conflictedSection);
    }
    function DecodeJson($json) {
        return json_decode($json);
    }
    
    function Makejson($json)
    {
        return json_encode($json);
    }
    
    ?>