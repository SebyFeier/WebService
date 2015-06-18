<?php
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    $time  = time();
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    if (isset($_GET["documentId"])) {
        $documentId = $_GET["documentId"];
    }
    if (isset($_GET["user"])) {
        $user = $_GET["user"];
    }
    if (isset($_GET["permission"])) {
        $permission = $_GET["permission"];
    }
    $documentIds = explode("/",$documentId);
    $users = explode("/", $user);
    $permissions = explode("/",$permission);
    
    for ($i = 0; $i < count($users);$i++) {
        $user = $users[$i];
        $permission = $permissions[$i];
        $docId = $documentIds[$i];
        $sql = "UPDATE permissions SET permissionType='$permission' WHERE userId=$user AND documentId=$docId";
        $result = mysqli_query($con, $sql);
        $sql = "DELETE FROM requests WHERE userId=$user AND documentId=$docId";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $json = '{"status":"OK"}';
        } else {
            $json = '{"status":"ERROR"}';
        }
    }
    echo $json;
    
    ?>
