<?php
    
    $finalArray = array();
    $json['documents'][] = array(1);
    $file = "file.txt";
    $i=0;
    
    $con=mysqli_connect("localhost","root","123456","Licenta");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    if (isset($_GET["userId"])) {
        $userId = $_GET["userId"];
    }
    $num_rec_per_page=10;
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * $num_rec_per_page;
    $sql = "SELECT u.username,u.userID,d.*,p.permissionType from permissions p, user u, document d where p.userId=u.userId and p.documentId=d.documentId and p.userId=$userId and d.createdBy=$userId order by d.documentId limit $start_from, $num_rec_per_page";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $json['documents'][$i]=$row;
        $i++;
    }
    if ($i != 0) {
        echo Makejson($json);
    }
    file_put_contents($file, json_encode($json));
    mysqli_close($con);
    
    function Makejson($json)
    {
        return json_encode($json);
    }
    ?>







