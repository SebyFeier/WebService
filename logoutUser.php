<?php
//$con = mysqli_connect("sql313.byetcluster.com", "mzzho_14755235", "n3wMexico", "mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_GET["userId"])) {
$userId=$_GET["userId"];
}
$sql = "UPDATE user SET isLoggedIn=FALSE, loggedInDeviceUdid='' WHERE userID='$userId'";
$result = mysqli_query($con, $sql);
$json = '{"status":"OK"}';
                echo $json;
?>