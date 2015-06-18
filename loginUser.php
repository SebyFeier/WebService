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
    if (isset($_GET['username'])) {
        $username   = $_GET['username'];
        $password   = $_GET['password'];
        $deviceUdid = $_GET['deviceUdid'];
        $deviceName = $_GET['deviceName'];
        $sql        = "SELECT u.userID, u.username, d.deviceName, d.udid FROM user u, device d WHERE u.username='$username' AND u.password=PASSWORD('$password') AND u.userID=d.userId and d.isApproved=TRUE and d.udid='$deviceUdid' AND u.isLoggedIn=FALSE";
        $result     = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $json['users'][$i] = $row;
            $i++;
            $userId = $row["userID"];
        }
        if ($i != 0) {
            $sql = "UPDATE user SET isLoggedIn = TRUE, loggedInDeviceUdid='".$deviceUdid."' WHERE userId='$userId'";
            $result = mysqli_query($con, $sql);
            echo Makejson($json);
        } else {
            $sql            = "SELECT u.userID, u.username, d.deviceName, d.udid FROM user u, device d WHERE u.username='$username' AND u.password=PASSWORD('$password') AND u.userID=d.userId AND d.isApproved=FALSE";
            $result         = mysqli_query($con, $sql);
            $j              = 0;
            $tmp['users'][] = array(1);
            while ($row = mysqli_fetch_assoc($result)) {
                $tmp['users'][$j] = $row;
                $j++;
                $userId = $row["userID"];
                if ($row["udid"] == $deviceUdid) {
                    $deviceExists = TRUE;
                } else {
                    $deviceExists = FALSE;
                }
            }
            
            if ($j != 0) {
                if ($deviceExists == TRUE) {
                    $sql         = "SELECT * FROM deviceRequests WHERE deviceUdid='$deviceUdid'";
                    $result      = mysqli_query($con, $sql);
                    $deviceFound = FALSE;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $deviceFound = TRUE;
                    }
                    if ($deviceFound == FALSE) {
                    }
                } else {
                    $sql = "INSERT INTO device (udid, deviceName, userId, isApproved) VALUES ('$deviceUdid', '$deviceName', $userId, FALSE)";
                    $result = mysqli_query($con, $sql);
                    $json   = '{"response":"You can not login from this device.Send Request?","status":"ERROR", "userId":"' . $userId . '"}';
                    echo $json;
                }
            } else {
                $sql = "SELECT * FROM user WHERE username='$username'";
                
                $result = mysqli_query($con, $sql);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    $userId = $row["userID"];
                    $isLoggedIn=$row["isLoggedIn"];
                    $loggedInDeviceUdid=$row["loggedInDeviceUdid"];
                }
                if (isset($userId)) {
                    if ($isLoggedIn==TRUE) {
                        $sql = "SELECT * FROM device WHERE userId = '$userId'";
                        $result = mysqli_query($con, $sql);
                        $allUserUdids = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $allUserUdids[] = $row["udid"];
                        }
                        $udidFound = FALSE;
                        for ($k = 0; $k < count($allUserUdids); $k++) {
                            if ($allUserUdids[$k] == $deviceUdid) {
                                $udidFound = TRUE;
                                break;
                            }
                        }
                        if ($udidFound == TRUE) {
                            if ($loggedInDeviceUdid == $deviceUdid) {
                                $sql        = "SELECT u.userID, u.username, d.deviceName, d.udid FROM user u, device d WHERE u.username='$username' AND u.password=PASSWORD('$password') AND u.userID=d.userId and d.isApproved=TRUE and d.udid='$deviceUdid' AND u.isLoggedIn=TRUE";
                                $result     = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $json['users'][$i] = $row;
                                    $i++;
                                    $userId = $row["userID"];
                                }
                                echo Makejson($json);
                            } else {
                                $json   = '{"response":"You are already logged in on a different device","status":"ERROR"}';
                                echo $json;
                                sleep(10);
                                $sql = "UPDATE user SET isLoggedIn=FALSE, loggedInDeviceUdid='' WHERE userID='$userId'";
                                $result = mysqli_query($con, $sql);
                            }
                        } else {
                            $json   = '{"response":"You are already logged in on a different device","status":"ERROR"}';
                            echo $json;
                            sleep(10);
                            $sql = "UPDATE user SET isLoggedIn=FALSE, loggedInDeviceUdid='' WHERE userID='$userId'";
                            $result = mysqli_query($con, $sql);
                        }
                    } else {
                        $sql = "INSERT INTO device (udid, deviceName, userId, isApproved) VALUES ('$deviceUdid', '$deviceName', $userId, FALSE)";
                        $result = mysqli_query($con, $sql);
                        $json   = '{"response":"You can not login from this device.Send Request?","status":"ERROR", "userId":"' . $userId . '"}';
                        echo $json;
                    }
                }
            }
        }
    }
    
    file_put_contents($file, json_encode($json));
    mysqli_close($con);
    
    function Makejson($json)
    {
        return json_encode($json);
    }
    ?>
