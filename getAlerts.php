<?php
    
    $finalArray      = array();
    $json['alerts'][] = array(1);
    $file            = "file.txt";
    $i               = 0;
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    if (isset($_GET['userId']) && isset($_GET['documentId'])) {
        $userId = $_GET['userId'];
        $documentId = $_GET['documentId'];
        $sql = "SELECT * FROM alert WHERE user = '$userId' AND documentId = $documentId";
        $result = mysqli_query($con,$sql);
        $documentIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $json['alerts'][$i] = $row;
            $i++;
            $modifiedBys[] = $row["modifiedBy"];
            $sectionIds[] = $row["sectionId"];
        }
        if ($i != 0) {
            for ($position = 0; $position < count($modifiedBys); $position++) {
                $sql = "DELETE FROM alert WHERE documentId=$documentId AND user='$userId' AND sectionId=$sectionIds[$position]";
                $result = mysqli_query($con, $sql);
            }
            echo json_encode($json);
        } else {
            echo "";
        }
    }
    ?>