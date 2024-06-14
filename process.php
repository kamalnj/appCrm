<?php
$conn = mysqli_connect("localhost", "root", "", "upwork4");

$query = "SELECT * FROM orders WHERE approval = 'Yes'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

    while ($orderRow = mysqli_fetch_assoc($result)) {

        $cappsFtds = $orderRow['capps'] - $orderRow['ftds'];
        $fillerQuery = "SELECT * FROM filler WHERE our_network IS NULL";
        $fillerResult = mysqli_query($conn, $fillerQuery);
        $numUnusedFillers = mysqli_num_rows($fillerResult);

        if ($numUnusedFillers >= $cappsFtds) {
            while (($fillerRow = mysqli_fetch_assoc($fillerResult)) && $cappsFtds > 0) {
                $fillerId = $fillerRow['id'];
                $updateFillerQuery = "UPDATE filler SET our_network = '{$orderRow['our_network_today']}', client_network = '{$orderRow['brand_name']}' WHERE id = $fillerId";
                mysqli_query($conn, $updateFillerQuery);
                $cappsFtds--;

                echo "Filler with ID: $fillerId updated.<br>";
            }

            $brandTableQuery = "INSERT INTO brand_table (brand_name, aff_manager_id) VALUES ('{$orderRow['brand_name']}', '{$orderRow['aff_manager_id']}')";
            mysqli_query($conn, $brandTableQuery);

            echo "Order for brand: {$orderRow['brand_name']} successfully processed and injected.<br>";
        } else {
            echo "Not enough unused fillers available for brand: {$orderRow['brand_name']}.<br>";
        }

        // Second logic block: Process ftds
        $numFtdsToProcess = $orderRow['ftds'];

        while ($numFtdsToProcess > 0) {
            $ftdQuery = "SELECT fid FROM ftd WHERE our_network IS NULL LIMIT 1";
            $ftdResult = mysqli_query($conn, $ftdQuery);

            if (mysqli_num_rows($ftdResult) > 0) {
                $ftdRow = mysqli_fetch_assoc($ftdResult);
                $ftdId = $ftdRow['fid'];
                $updateFtdQuery = "UPDATE ftd SET our_network = '{$orderRow['our_network_today']}', client_network = '{$orderRow['brand_name']}' WHERE fid = $ftdId";
                mysqli_query($conn, $updateFtdQuery);
                $numFtdsToProcess--;

                echo "Ftd with ID: $ftdId updated.<br>";
            } else {
                echo "Not enough unused ftd available for brand: {$orderRow['brand_name']}.<br>";
                break;
            }
        }

        $orderinjection = "INSERT INTO orders_injection (order_date, country, aff_manager_id, work_hours, our_network_today) VALUES (
            '{$orderRow['order_date']}', 
            '{$orderRow['country']}', 
            '{$orderRow['aff_manager_id']}', 
            '{$orderRow['work_hours']}', 
            '{$orderRow['our_network_today']}')";
        mysqli_query($conn, $orderinjection);

        echo "Order for brand: {$orderRow['brand_name']} successfully processed and injected.<br>";
    }
} else {
    echo "No approved orders to process.";
}

mysqli_close($conn);
?>
