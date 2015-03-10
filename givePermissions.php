<?php

//$con=mysqli_connect("sql313.byetcluster.com","mzzho_14755235","n3wMexico","mzzho_14755235_licenta");
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
$users = explode("/", $user);
$permissions = explode("/",$permission);

for ($i = 0; $i < count($users);$i++) {
$user = $users[$i];
$permission = $permissions[$i];
//echo $permission;
$sql = "INSERT INTO permissions(userId, documentId, permissionType) VALUES ($user, $documentId, '$permission')";
//echo $sql;
$result = mysqli_query($con, $sql);
if ($result) {
		$json = '{"status":"OK"}';
} else {
		$json = '{"status":"ERROR"}';
}
}
                echo $json;

?>
