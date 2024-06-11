<?php
include('config.php'); // include database connection

if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];

    $stmt = $conn->prepare("SELECT * FROM ftd WHERE fid = ?");
    $stmt->bind_param("s", $fid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $ftd = $result->fetch_assoc();
        echo json_encode($ftd);
    } else {
        echo json_encode(["error" => "FTD not found"]);
    }
    $stmt->close();
}
$conn->close();
?>
