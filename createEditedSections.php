<?php

$json['documents'][] = array(
    1
);
$file                = "file.txt";
$i                   = 0;
//$con                 = mysqli_connect("sql313.byetcluster.com", "mzzho_14755235", "n3wMexico", "mzzho_14755235_licenta");
        $con=mysqli_connect("localhost","root","123456","Licenta");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_GET["documentId"])) {
    $documentId = $_GET["documentId"];
}

$sql    = "SELECT * FROM document where documentId='$documentId'";
echo $sql;
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $key => $value) {
        //echo $key;
        if (strpos($key, 'section') !== false && strpos($key, 'modif') === false) {
//if (strpos($key,'section') !== false) {
echo $key;
            $sql    = "ALTER TABLE editedDocument ADD " . $key . " BOOL NOT NULL DEFAULT FALSE";
            $result = mysqli_query($con, $sql);
        }
    }
}


?>	