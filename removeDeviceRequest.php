<?php
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    $time  = time();
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    if (isset($_GET["userId"])) {
        $userId = $_GET["userId"];
    }
    if (isset($_GET["deviceUdid"])) {
        $deviceUdid = $_GET["deviceUdid"];
    }
    if (isset($_GET["isApproved"])) {
        $isApproved = $_GET["isApproved"];
    }
    $deviceUdids = explode("/", $deviceUdid);
    $approvals = explode("/",$isApproved);
    
    for ($i = 0; $i < count($deviceUdids);$i++) {
        $deviceUdid = $deviceUdids[$i];
        $isApproved = $approvals[$i];
        $sql = "UPDATE device SET isApproved=$isApproved WHERE userId=$userId AND udid='$deviceUdid'";
        $result = mysqli_query($con, $sql);
        $sql = "DELETE FROM deviceRequests WHERE userId=$userId AND deviceUdid='$deviceUdid'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $json = '{"status":"OK"}';
        } else {
            $json = '{"status":"ERROR"}';
        }
    }
    echo $json;
    
    ?>
