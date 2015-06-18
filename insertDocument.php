<?php
    
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    $con=mysqli_connect("localhost","root","123456","Licenta");
    $time  = time();
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $time  = time();
    
    if (isset($_GET["documentName"])) {
        $documentName = $_GET["documentName"];
    }
    if (isset($_GET["createdBy"])) {
        $createdBy = $_GET["createdBy"];
    }
    
    if (isset($documentName)) {
        $sql = "INSERT INTO document (documentName, lastModified, createdBy) VALUES ('".$documentName."','".$time."','".$createdBy."')";
        
        $result = mysqli_query($con, $sql);
        if($result) {
            $sql = "SELECT * FROM document WHERE documentName='$documentName'";
            $result = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($result)) {
                $json['documents'][$i]=$row;
                $i++;
                $documentId = $row["documentId"];
            }
            
            $sql = "INSERT INTO editedDocument (documentId) VALUES ('$documentId')";
            $result =mysqli_query($con, $sql);
            $xml .= "<sections>";
            $xml .= "<section>";
            $xml .= "<name>"."1"."</name>";
            $xml .= "<timestamp>".$time."</timestamp>";
            $xml .= "<modifiedBy>".$createdBy."</modifiedBy>";
            $xml .= "<value></value>";
            $xml .= "</section>";
            $xml .= "</sections>";
            $sql = "INSERT INTO section (documentId, sectionText) VALUES ('$documentId','".mysql_real_escape_string($xml)."')";
            $result = mysqli_query($con, $sql);
            
            echo makejson($json);
        }
        else {
            $json = '{"response":"The document name already exists","status":"ERROR"}';
            echo $json;
        }
    }
    file_put_contents($file, json_encode($json));
    mysqli_close($con);
    function Makejson($json)
    {
        return json_encode($json);
    }
    
    
    
    ?>