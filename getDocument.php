<?php
    
    $finalArray = array();
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    if (isset($_GET['documentName'])) {
        $documentName = $_GET['documentName'];
    }
    $sql = "SELECT * FROM document, section WHERE document.documentName='$documentName' AND document.documentId = section.documentId";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $json['documents'][$i]=$row;
        $i++;
    }
    echo Makejson($json);
    file_put_contents($file, json_encode($json));
    mysqli_close($con);
    
    function Makejson($json)
    {
        return json_encode($json);
    } 
    
    ?>








