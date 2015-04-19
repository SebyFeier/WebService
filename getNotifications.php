<?php
    
    $finalArray      = array();
    $json['users'][] = array(
                             1
                             );
    $file            = "file.txt";
    $i               = 0;
    
    //$con = mysqli_connect("sql313.byetcluster.com", "mzzho_14755235", "n3wMexico", "mzzho_14755235_licenta");
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];
    $sql = "SELECT documentId FROM updatedDocuments WHERE userId=$userId";
//        echo $sql;
        $result = mysqli_query($con,$sql);
        $documentIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
//            $json['users'][$i] = $row;
            $i++;
            $documentIds[] = $row["documentId"];
        }
        if ($i != 0) {
            for ($position = 0; $position < count($documentIds); $position++) {
//                echo $documentId[$position];
                $sql = "DELETE FROM updatedDocuments WHERE documentId=$documentIds[$position] AND userId=$userId";
                $result = mysqli_query($con, $sql);
            }
            echo json_encode($documentIds);
        }
    }
    ?>