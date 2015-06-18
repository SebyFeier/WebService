<?php
    
    $finalArray      = array();
    $json['users'][] = array(
                             1
                             );
    $file            = "file.txt";
    $i               = 0;
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];
        $sql = "SELECT documentId FROM updatedDocuments WHERE userId=$userId";
        $result = mysqli_query($con,$sql);
        $documentIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $i++;
            $documentIds[] = $row["documentId"];
        }
        if ($i != 0) {
            for ($position = 0; $position < count($documentIds); $position++) {
                $sql = "DELETE FROM updatedDocuments WHERE documentId=$documentIds[$position] AND userId=$userId";
                $result = mysqli_query($con, $sql);
            }
            echo json_encode($documentIds);
        }
    }
    ?>