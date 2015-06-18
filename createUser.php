<?php
    
    $finalArray = array();
    $json['users'][] = array(1);
    $file = "file.txt";
    $i=0;
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    if (isset($_GET['username']) && isset($_GET['password'])) {
        $password = $_GET['password'];
        $username = $_GET['username'];
        $deviceUdid = $_GET['deviceUdid'];
        $deviceName = $_GET['deviceName'];
        $order = "INSERT INTO user (username, password, isLoggedIn, loggedInDeviceUdid) VALUES ('".$username."', PASSWORD('".$password."'), TRUE,'".$deviceUdid."')";
        $result = mysqli_query($con,$order);
        if($result) {
            $sql = "SELECT * FROM user WHERE username='$username' AND password=PASSWORD('$password')";
            $res = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($res))
            {
                $json['users'][$i]=$row;
                $i++;
                $userId = $row["userID"];
            }
            $columns = array();
            $sql="SELECT documentId FROM document ";
            $result=mysqli_query($con,$sql);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $columns[] =  $row['documentId'];
                }
            }
            for ($i=0; $i<count($columns);$i++) {
                $sql = "INSERT INTO permissions(userId, documentId, permissionType) VALUES ($userId, $columns[$i],'None')";
                $result=mysqli_query($con, $sql);
            }
            $sql = "INSERT INTO device(udid, deviceName, userId, isApproved) VALUES ('$deviceUdid', '$deviceName', $userId, TRUE)";
            $result=mysqli_query($con, $sql);
            
            echo Makejson($json);
        } else{
            $json = '{"response":"The email is already registered","status":"ERROR"}';
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
