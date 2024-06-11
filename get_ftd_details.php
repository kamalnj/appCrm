<?php
include 'db.php';

if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];
    
    $query = "SELECT * FROM ftds WHERE fid = '$fid'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $ftd = mysqli_fetch_assoc($result);
        echo json_encode($ftd);
    } else {
        echo json_encode(["error" => "FTD not found"]);
    }
}
?>