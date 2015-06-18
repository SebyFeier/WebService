<?php
    
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    if (isset($_GET["documentId"])) {
        $documentId = $_GET["documentId"];
    }
    if (isset($_GET["userId"])) {
        $userId = $_GET["userId"];
    }
    if (isset($documentId) && isset($userId)) {
        $sql = "DELETE FROM document WHERE documentId = '".$documentId."' AND createdBy='".$userId."'";
        
        $result = mysqli_query($con, $sql) or die("Error".mysqli_error());
        
        $count = mysqli_affected_rows($con);
        if ($count > 0) {
            $json = '{"response":"The document has been deleted successfully","status":"OK"}';
        } else {
            $json = '{"response":"The document does not exist","status":"ERROR"}';
        }
    }
    
    echo $json;
    file_put_contents($file, json_encode($json));
    mysqli_close($con);
    function Makejson($json)
    {
        return json_encode($json);
    }
    
    ?>