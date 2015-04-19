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
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $documentId = $_GET['documentName'];
        
        $sql = "SELECT userID FROM user WHERE username != '$username'";
        $result = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $json['users'][$i] = $row;
            $i++;
            $userId = $row["userID"];
        }
        if ($i != 0) {
            for ($position = 0; $position < count($userId); $position++) {
                $sql = "INSERT INTO updatedDocuments(documentId, userId) VALUES($documentId, $userId[$position])";
                $result = mysqli_query($con, $sql);
            }
        }
    }
    ?>