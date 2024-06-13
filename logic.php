<?php
// Assuming you have a database connection established
$conn = mysqli_connect("localhost", "root", "", "upwork4");

// Step 1: Check approved orders
$query = "SELECT * FROM orders WHERE approval = 'Yes'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

    // Fetch the order details
    $orderRow = mysqli_fetch_assoc($result);

    // Calculate the number of fillers that have not been used by our_network
    $cappsFtds = $orderRow['capps'] - $orderRow['ftds'];
    // Step 2: Filler Selection
    // Query to select fillers that have not been used by our_network
    $fillerQuery = "SELECT * FROM filler WHERE our_network IS NULL";
    $fillerResult = mysqli_query($conn, $fillerQuery);

    // Count the number of fillers that have not been used by our_network
    $numUnusedFillers = mysqli_num_rows($fillerResult);
    // Check if the number of unused fillers is greater than or equal to $cappsFtds
    if ($numUnusedFillers >= $cappsFtds) {
        // Loop through fillers to update them as used by our_network
        while (($fillerRow = mysqli_fetch_assoc($fillerResult)) && $cappsFtds > 0) {
            $fillerId = $fillerRow['id'];
            // Update the filler to mark it as used by our_network
            $updateFillerQuery = "UPDATE filler SET our_network = '{$orderRow['our_network_today']}', client_network = '{$orderRow['brand_name']}' WHERE id = $fillerId";
            mysqli_query($conn, $updateFillerQuery);
            $cappsFtds--; // Decrease the count of unused fillers

            // Echo to test
            echo "Filler with ID: $fillerId updated.<br>";
        }




        $brandTableQuery = "INSERT INTO brand_table ( brand_name, aff_manager_id) VALUES ('" . $orderRow['brand_name'] . "', '" . $orderRow['aff_manager_id'] . "')";
        mysqli_query($conn, $brandTableQuery);

        echo "Order successfully processed and injected.";
    } else {
        echo "Not enough unused fillers available.";
    }
} else {
    echo "No approved orders to process.";
}

mysqli_close($conn);
